<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\EventStore;

use LidskaSila\Prooph\Tests\Configurators\ProophExtensionTestCase;
use Prooph\EventStore\EventStore;

class EventStoreConfiguratorTest extends ProophExtensionTestCase
{
	private const TEST_CONFIG_PATH = 'EventStoreConfiguratorTest.neon';

	public function testGetEventStoreByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenTestContainer(self::TEST_CONFIG_PATH);

		$repository = $this->whenGetServiceByTypeFromContainer(EventStore::class);

		$this->thenIsInstanceOfExpectedClass(EventStore::class, $repository);
	}
}
