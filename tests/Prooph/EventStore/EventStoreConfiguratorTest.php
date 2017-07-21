<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\EventStore;

use LidskaSila\Prooph\Tests\Configurators\ProophExtensionTestCase;
use Prooph\EventStore\EventStore;

class EventStoreConfiguratorTest extends ProophExtensionTestCase
{

	public function testGetEventStoreByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenTestContainer();

		$repository = $this->whenGetServiceByTypeFromContainer(EventStore::class);

		$this->thenIsInstanceOfExpectedClass(EventStore::class, $repository);
	}
}