<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\ProjectionManager;

use LidskaSila\Prooph\Common\DefaultConfigurator;
use Prooph\EventStore\Projection\ProjectionManager;

class ProjectionManagerConfigurator extends DefaultConfigurator
{

	public const KEY                 = 'projection_manager';
	public const KEY_USE             = 'use';
	public const KEY_USE_CONFIG_NAME = 'config';
	public const KEY_USE_FACTORY     = 'factory';

	public static function create($factory, $eventStoreConfigName, $containerWrapperService): ProjectionManager
	{
		return $factory::$eventStoreConfigName($containerWrapperService);
	}

	public function buildDefaultConfig(): array
	{
		return [];
	}

	public function getConfigKey(): string
	{
		return self::KEY;
	}

	public function loadConfiguration(array $config): void
	{
		if (!isset($config[self::KEY_USE][self::KEY_USE_CONFIG_NAME])) {
			return;
		}
		$eventStoreConfigName = $config[self::KEY_USE][self::KEY_USE_CONFIG_NAME];
		$factory              = $config[self::KEY_USE][self::KEY_USE_FACTORY];

		$containerWrapperServiceId = $this->getContainerWrapperServiceId();

		$this
			->getContainerBuilder()
			->addDefinition($this->getProjectionManagerServiceId())
			->setClass(ProjectionManager::class)
			->setFactory(self::class . '::create', [ $factory, $eventStoreConfigName, '@' . $containerWrapperServiceId ]);
	}

	private function getProjectionManagerServiceId()
	{
		return $this->extension->prefix('projection_manager');
	}
}
