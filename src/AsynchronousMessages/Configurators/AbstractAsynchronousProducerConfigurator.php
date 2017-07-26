<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\AsynchronousMessages\Configurators;

use LidskaSila\Prooph\AsynchronousMessages\AsynchronousMessageProducer;
use LidskaSila\Prooph\AsynchronousMessages\AsynchronousMessagesConfigurator;
use LidskaSila\Prooph\AsynchronousMessages\Factories\AbstractAsynchronousMessageProducerFactory;
use LidskaSila\Prooph\Common\DefaultConfigurator;

abstract class AbstractAsynchronousProducerConfigurator extends DefaultConfigurator
{

	public static function create($factory, $producerSectionConfigName, $containerWrapperService): AsynchronousMessageProducer
	{
		return $factory::$producerSectionConfigName($containerWrapperService);
	}

	abstract public function getProducerFactoryClass(): string;

	public function buildDefaultConfig(): array
	{
		return [];
	}

	public function loadConfiguration(array $config): void
	{
		if (empty($config[AbstractAsynchronousMessageProducerFactory::KEY_BRIDGE])) {
			return;
		}

		$containerWrapperServiceId = $this->getContainerWrapperServiceId();

		$this
			->getContainerBuilder()
			->addDefinition($this->getProducerServiceId())
			->setClass(AsynchronousMessageProducer::class)
			->setFactory(static::class . '::create', [ $this->getProducerFactoryClass(), $this->getConfigKey(), '@' . $containerWrapperServiceId ]);
	}

	private function getProducerServiceId(): string
	{
		return $this->extension->prefix(AsynchronousMessagesConfigurator::KEY . '.' . $this->getConfigKey());
	}
}
