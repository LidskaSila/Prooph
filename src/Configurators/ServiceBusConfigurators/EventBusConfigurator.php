<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Configurators\ServiceBusConfigurators;

use Prooph\ServiceBus\Container\EventBusFactory;
use Prooph\ServiceBus\EventBus;

class EventBusConfigurator extends AbstractBusConfigurator
{

	public const KEY_EVENT_BUS = 'event_bus';

	public function getBusClass(): string
	{
		return EventBus::class;
	}

	public function getBusFactoryClass(): string
	{
		return EventBusFactory::class;
	}

	public function getConfigKey(): string
	{
		return self::KEY_EVENT_BUS;
	}
}
