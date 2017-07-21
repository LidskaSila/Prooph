<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\EventSourcing;

use LidskaSila\Prooph\Tests\Configurators\ProophExtensionTestCase;
use LidskaSila\Prooph\Tests\EventSourcing\FakeImplementations\MemoryTestRepository;

class EventSourcingConfiguratorTest extends ProophExtensionTestCase
{

	public function testGetRepositoryByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenTestContainer();

		$repository = $this->whenGetServiceByTypeFromContainer(MemoryTestRepository::class);

		$this->thenIsInstanceOfExpectedClass(MemoryTestRepository::class, $repository);
	}
}
