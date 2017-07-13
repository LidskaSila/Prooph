<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\Configurators\ServiceBusConfigurators;

use LidskaSila\Prooph\Tests\Configurators\ProophExtensionTestCase;
use Prooph\ServiceBus\CommandBus;

class CommandBusConfiguratorTest extends ProophExtensionTestCase
{

	public function testGetServiceBusByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenTestContainer();

		$repository = $this->whenGetServiceByTypeFromContainer(CommandBus::class);

		$this->thenIsInstanceOfExpectedClass(CommandBus::class, $repository);
	}
}
