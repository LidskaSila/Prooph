<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\EventStore;

use LidskaSila\Prooph\Common\DefaultConfigurator;
use Prooph\EventStore\EventStore;

class EventStoreConfigurator extends DefaultConfigurator
{

	public const KEY                 = 'event_store';
	public const KEY_USE             = 'use';
	public const KEY_USE_CONFIG_NAME = 'config';
	public const KEY_USE_FACTORY     = 'factory';

	public function buildDefaultConfig(): array
	{
		return [
			self::KEY_USE => [
				self::KEY_USE_CONFIG_NAME => [],
				self::KEY_USE_FACTORY     => false,
			],
		];
	}

	public function getConfigKey(): string
	{
		return self::KEY;
	}

	public function loadConfiguration(array $config): void
	{
		$eventStoreConfigName = $config[self::KEY_USE][self::KEY_USE_CONFIG_NAME];
		$factory              = $config[self::KEY_USE][self::KEY_USE_FACTORY];

		$containerWrapperServiceId = $this->getContainerWrapperServiceId();

		$this
			->getContainerBuilder()
			->addDefinition($this->getEventStoreServiceId())
			->setClass(EventStore::class)
			->setFactory(self::class . '::create', [ $factory, $eventStoreConfigName, '@' . $containerWrapperServiceId ]);
	}

	public static function create($factory, $eventStoreConfigName, $containerWrapperService): EventStore
	{
		return $factory::$eventStoreConfigName($containerWrapperService);
	}

	private function getEventStoreServiceId()
	{
		return $this->extension->prefix('event_store');
	}
}
