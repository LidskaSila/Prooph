<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\ProjectionManager;

use LidskaSila\Prooph\Tests\Configurators\ProophExtensionTestCase;
use Prooph\EventStore\Pdo\Projection\MariaDbProjectionManager;
use Prooph\EventStore\Projection\ProjectionManager;

class MariaDbProjectionManagerConfiguratorTest extends ProophExtensionTestCase
{

	private const TEST_CONFIG_PATH = 'ProjectionManagerTests/MariaDbProjectionManagerTest.neon';

	public function testGetEventStoreByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenTestContainer(self::TEST_CONFIG_PATH);

		$repository = $this->whenGetServiceByTypeFromContainer(ProjectionManager::class);

		$this->thenIsInstanceOfExpectedClass(MariaDbProjectionManager::class, $repository);
	}
}
