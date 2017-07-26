<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\AsynchronousMessages;

use LidskaSila\Prooph\Tests\Configurators\ProophExtensionTestCase;
use LidskaSila\Prooph\Tests\EventSourcing\FakeImplementations\MemoryTestRepository;

class AsynchronousMessagesConfiguratorTest extends ProophExtensionTestCase
{

	const TEST_PRODUCER_ROUTE_KEY = 'producerRouteKey';

	public function testGet_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenTestContainer();

		$repository = $this->whenGetServiceByTypeFromContainer(MemoryTestRepository::class);

		$this->thenIsInstanceOfExpectedClass(MemoryTestRepository::class, $repository);
	}

	protected function setUp()
	{
		parent::setUp();
	}
}
