<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\AsynchronousMessages\Configurators;

use LidskaSila\Prooph\AsynchronousMessages\Factories\AsynchronousCommandProducerFactory;

class AsynchronousCommandProducerConfigurator extends AbstractAsynchronousProducerConfigurator
{

	public function getProducerFactoryClass(): string
	{
		return AsynchronousCommandProducerFactory::class;
	}

	public function getConfigKey(): string
	{
		return AsynchronousCommandProducerFactory::SECTION_CONFIG_ID;
	}
}
