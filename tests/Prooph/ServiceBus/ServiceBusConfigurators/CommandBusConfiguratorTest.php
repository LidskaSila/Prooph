<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\ServiceBus\ServiceBusConfigurators;

use LidskaSila\Prooph\Tests\Configurators\ProophExtensionTestCase;
use Prooph\ServiceBus\CommandBus;

class CommandBusConfiguratorTest extends ProophExtensionTestCase
{
	private const TEST_CONFIG_PATH = 'ServiceBusConfiguratorTests/CommandBusConfiguratorTest.neon';

	public function testGetServiceBusByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenTestContainer(self::TEST_CONFIG_PATH);

		$repository = $this->whenGetServiceByTypeFromContainer(CommandBus::class);

		$this->thenIsInstanceOfExpectedClass(CommandBus::class, $repository);
	}
}
