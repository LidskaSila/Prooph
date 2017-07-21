<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\ServiceBus\Configurators\ServiceBusConfigurators;

use LidskaSila\Prooph\Tests\Configurators\ProophExtensionTestCase;
use Prooph\ServiceBus\QueryBus;

class QueryBusConfiguratorTest extends ProophExtensionTestCase
{

	public function testGetServiceBusByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenTestContainer();

		$repository = $this->whenGetServiceByTypeFromContainer(QueryBus::class);

		$this->thenIsInstanceOfExpectedClass(QueryBus::class, $repository);
	}
}
