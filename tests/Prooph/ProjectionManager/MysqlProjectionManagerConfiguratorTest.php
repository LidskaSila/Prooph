<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\ProjectionManager;

use LidskaSila\Prooph\Tests\Configurators\ProophExtensionTestCase;
use Prooph\EventStore\Pdo\Projection\MySqlProjectionManager;
use Prooph\EventStore\Projection\ProjectionManager;

class MysqlProjectionManagerConfiguratorTest extends ProophExtensionTestCase
{

	private const TEST_CONFIG_PATH = 'ProjectionManagerTests/MysqlProjectionManagerTest.neon';

	public function testGetEventStoreByType_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenTestContainer(self::TEST_CONFIG_PATH);

		$repository = $this->whenGetServiceByTypeFromContainer(ProjectionManager::class);

		$this->thenIsInstanceOfExpectedClass(MySqlProjectionManager::class, $repository);
	}
}
