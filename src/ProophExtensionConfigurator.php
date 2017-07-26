<?php declare(strict_types = 1);

namespace LidskaSila\Prooph;

use LidskaSila\Prooph\AsynchronousMessages\AsynchronousMessagesConfigurator;
use LidskaSila\Prooph\Common\CompositeConfigurator;
use LidskaSila\Prooph\Common\Configurator;
use LidskaSila\Prooph\EventSourcing\EventSourcingConfigurator;
use LidskaSila\Prooph\EventStore\EventStoreConfigurator;
use LidskaSila\Prooph\ServiceBus\ServiceBusesConfigurator;

class ProophExtensionConfigurator extends CompositeConfigurator
{

	public const KEY = 'prooph';

	public function getConfigKey(): ?string
	{
		return self::KEY;
	}

	/**
	 * @return Configurator[]
	 */
	protected function createConfigurators(): array
	{
		return [
			new EventStoreConfigurator($this->extension),
			new EventSourcingConfigurator($this->extension),
			new ServiceBusesConfigurator($this->extension),
			new AsynchronousMessagesConfigurator($this->extension),
		];
	}
}
