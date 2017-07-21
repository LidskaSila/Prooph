<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\ServiceBus\ServiceBusConfigurators;

use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\Container\CommandBusFactory;

class CommandBusConfigurator extends AbstractBusConfigurator
{

	public const KEY_COMMAND_BUS = 'command_bus';

	public function getBusClass(): string
	{
		return CommandBus::class;
	}

	public function getBusFactoryClass(): string
	{
		return CommandBusFactory::class;
	}

	public function getConfigKey(): string
	{
		return self::KEY_COMMAND_BUS;
	}
}
