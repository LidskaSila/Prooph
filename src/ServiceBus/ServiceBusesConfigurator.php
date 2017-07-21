<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\ServiceBus;

use LidskaSila\Prooph\Common\CompositeConfigurator;
use LidskaSila\Prooph\Common\Configurator;
use LidskaSila\Prooph\ServiceBus\ServiceBusConfigurators\CommandBusConfigurator;
use LidskaSila\Prooph\ServiceBus\ServiceBusConfigurators\EventBusConfigurator;
use LidskaSila\Prooph\ServiceBus\ServiceBusConfigurators\QueryBusConfigurator;

class ServiceBusesConfigurator extends CompositeConfigurator
{

	public const KEY_SERVICE_BUS = 'service_bus';

	public function getConfigKey(): string
	{
		return self::KEY_SERVICE_BUS;
	}

	/**
	 * @return Configurator[]|string[]
	 */
	protected function createConfigurators(): array
	{
		return [
			new CommandBusConfigurator($this->extension),
			new EventBusConfigurator($this->extension),
			new QueryBusConfigurator($this->extension),
		];
	}
}
