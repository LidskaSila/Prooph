<?php declare(strict_types = 1);

namespace LidskaSila\Prooph;

use LidskaSila\Prooph\Configurators\CompositeConfigurator;
use LidskaSila\Prooph\Configurators\Configurator;
use LidskaSila\Prooph\Configurators\EventSourcingConfigurator;
use LidskaSila\Prooph\Configurators\EventStoreConfigurator;
use LidskaSila\Prooph\Configurators\ServiceBusesConfigurator;

class ProophExtensionConfigurator extends CompositeConfigurator
{

	public const KEY = 'prooph';

	/**
	 * @return Configurator[]
	 */
	protected function createConfigurators(): array
	{
		return [
			new EventStoreConfigurator($this->extension),
			new EventSourcingConfigurator($this->extension),
			new ServiceBusesConfigurator($this->extension),
		];
	}

	public function getConfigKey(): ?string
	{
		return self::KEY;
	}
}
