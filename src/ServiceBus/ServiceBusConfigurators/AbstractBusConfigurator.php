<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\ServiceBus\ServiceBusConfigurators;

use LidskaSila\Prooph\Common\DefaultConfigurator;
use Prooph\Common\Messaging\MessageFactory;
use Prooph\ServiceBus\MessageBus;

abstract class AbstractBusConfigurator extends DefaultConfigurator
{

	protected const KEY_BUS_PLUGINS             = 'plugins';
	protected const KEY_BUS_ROUTER              = 'router';
	protected const KEY_BUS_ROUTER_ROUTES       = 'routes';
	protected const KEY_ENABLE_HANDLER_LOCATION = 'enable_handler_location';
	protected const KEY_MESSAGE_FACTORY         = 'message_factory';

	abstract public function getBusClass(): string;

	abstract public function getBusFactoryClass(): string;

	public function buildDefaultConfig(): array
	{
		return [
			self::KEY_BUS_PLUGINS             => [],
			self::KEY_BUS_ROUTER              => [
				self::KEY_BUS_ROUTER_ROUTES => [],
			],
			self::KEY_ENABLE_HANDLER_LOCATION => true,
			self::KEY_MESSAGE_FACTORY         => MessageFactory::class,
		];
	}

	public function loadConfiguration(array $config): void
	{
		$containerWrapperServiceId = $this->getContainerWrapperServiceId();

		$this
			->getContainerBuilder()
			->addDefinition($this->getBusServiceId())
			->setClass($this->getBusClass())
			->setFactory(static::class . '::create', [ $this->getBusFactoryClass(), $this->getConfigKey(), '@' . $containerWrapperServiceId ]);
	}

	public static function create($factory, $busConfigName, $containerWrapperService): MessageBus
	{
		return $factory::$busConfigName($containerWrapperService);
	}

	private function getBusServiceId(): string
	{
		return $this->extension->prefix($this->getConfigKey());
	}
}
