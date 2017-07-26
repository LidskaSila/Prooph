<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\AsynchronousMessages\Factories;

use Interop\Config\ConfigurationTrait;
use Interop\Config\ProvidesDefaultOptions;
use Interop\Config\RequiresConfigId;
use InvalidArgumentException;
use LidskaSila\Prooph\AsynchronousMessages\AsynchronousMessageProducer;
use LidskaSila\Prooph\AsynchronousMessages\AsynchronousMessageProducerBridge;
use Prooph\Common\Messaging\MessageConverter;
use Psr\Container\ContainerInterface;

abstract class AbstractAsynchronousMessageProducerFactory implements RequiresConfigId, ProvidesDefaultOptions
{

	use ConfigurationTrait;
	public const KEY_BRIDGE = 'bridge';
	public const KEY_ROUTES = 'routes';

	/**
	 * @var string
	 */
	private $configId;

	public function __construct(string $configId)
	{
		$this->configId = $configId;
	}

	/**
	 * Creates a new instance from a specified config, specifically meant to be used as static factory.
	 *
	 * @throws InvalidArgumentException
	 */
	public static function __callStatic(string $name, array $arguments): AsynchronousMessageProducer
	{
		if (!isset($arguments[0]) || !$arguments[0] instanceof ContainerInterface) {
			throw new InvalidArgumentException(
				sprintf('The first argument must be of type %s', ContainerInterface::class)
			);
		}

		return (new static($name))->__invoke($arguments[0]);
	}

	public function __invoke(ContainerInterface $container): AsynchronousMessageProducer
	{
		$producerConfig = $this->getProducerconfg($container);

		$producer = $this->createMessageProducer($container, $producerConfig);

		$this->injectRoutesToProducer($producerConfig, $producer);

		return $producer;
	}

	public function dimensions(): iterable
	{
		return [ 'prooph', 'asynchronous_messaging' ];
	}

	public function defaultOptions(): iterable
	{
		return [];
	}

	private function getProducerconfg(ContainerInterface $container): array
	{
		$config = $container->get('config');

		return $this->optionsWithFallback($config, $this->configId);
	}

	private function createMessageProducer(ContainerInterface $container, array $producerConfig): AsynchronousMessageProducer
	{
		$producerBridge   = $this->getProducerBridge($container, $producerConfig);
		$messageConverter = $this->getMessageConverter($container);

		return new AsynchronousMessageProducer($producerBridge, $messageConverter);
	}

	private function getProducerBridge(ContainerInterface $container, $producerConfig): AsynchronousMessageProducerBridge
	{
		$producerBridgeKey = $this->getProducerBridgeServiceKey($producerConfig);

		return $container->get($producerBridgeKey);
	}

	private function getProducerBridgeServiceKey(array $producerConfig): string
	{
		return $producerConfig[self::KEY_BRIDGE];
	}

	private function getMessageConverter(ContainerInterface $container): MessageConverter
	{
		return $container->get(MessageConverter::class);
	}

	private function injectRoutesToProducer(array $producerConfig, AsynchronousMessageProducer $producer): void
	{
		$routes = is_array($producerConfig[self::KEY_ROUTES]) ? $producerConfig[self::KEY_ROUTES] : [];
		$producer->injectRoutes($routes);
	}
}
