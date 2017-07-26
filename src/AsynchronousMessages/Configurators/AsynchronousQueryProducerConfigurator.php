<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\AsynchronousMessages\Configurators;

use LidskaSila\Prooph\AsynchronousMessages\Factories\AsynchronousQueryProducerFactory;

class AsynchronousQueryProducerConfigurator extends AbstractAsynchronousProducerConfigurator
{

	public function getProducerFactoryClass(): string
	{
		return AsynchronousQueryProducerFactory::class;
	}

	public function getConfigKey(): string
	{
		return AsynchronousQueryProducerFactory::SECTION_CONFIG_ID;
	}
}
