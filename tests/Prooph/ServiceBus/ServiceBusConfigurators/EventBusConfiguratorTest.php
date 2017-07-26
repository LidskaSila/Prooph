<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\ServiceBus\Configurators\ServiceBusConfigurators;

use LidskaSila\Prooph\Tests\Configurators\ProophExtensionTestCase;
use Prooph\ServiceBus\EventBus;

class EventBusConfiguratorTest extends ProophExtensionTestCase
{
	private const TEST_CONFIG_PATH = 'ServiceBusConfiguratorTests/CommandBusConfiguratorTest.neon';

	public function testGetServiceBusByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenTestContainer(self::TEST_CONFIG_PATH);

		$repository = $this->whenGetServiceByTypeFromContainer(EventBus::class);

		$this->thenIsInstanceOfExpectedClass(EventBus::class, $repository);
	}
}
