<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\ServiceBus\ServiceBusConfigurators;

use Prooph\ServiceBus\Container\QueryBusFactory;
use Prooph\ServiceBus\QueryBus;

class QueryBusConfigurator extends AbstractBusConfigurator
{

	public const KEY_QUERY_BUS = 'query_bus';

	public function getBusClass(): string
	{
		return QueryBus::class;
	}

	public function getBusFactoryClass(): string
	{
		return QueryBusFactory::class;
	}

	public function getConfigKey(): string
	{
		return self::KEY_QUERY_BUS;
	}
}
