<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\AsynchronousMessages\Configurators;

use LidskaSila\Prooph\AsynchronousMessages\Factories\AsynchronousEventProducerFactory;

class AsynchronousEventProducerConfigurator extends AbstractAsynchronousProducerConfigurator
{

	public function getProducerFactoryClass(): string
	{
		return AsynchronousEventProducerFactory::class;
	}

	public function getConfigKey(): string
	{
		return AsynchronousEventProducerFactory::SECTION_CONFIG_ID;
	}
}
