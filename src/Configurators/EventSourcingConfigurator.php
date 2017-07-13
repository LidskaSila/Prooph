<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Configurators;

use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Container\Aggregate\AggregateRepositoryFactory;

class EventSourcingConfigurator extends DefaultConfigurator
{

	public const KEY                        = 'event_sourcing';
	public const KEY_AGGREGATE_REPOSITORIES = 'aggregate_repository';
	public const KEY_REPOSITORY_CLASS       = 'repository_class';

	public function buildDefaultConfig(): array
	{
		return [
			self::KEY_AGGREGATE_REPOSITORIES => [],
		];
	}

	public function getConfigKey(): string
	{
		return self::KEY;
	}

	public function loadConfiguration(array $config): void
	{
		$repositoriesConfigs = $config[self::KEY_AGGREGATE_REPOSITORIES];

		$containerWrapperServiceId = $this->getContainerWrapperServiceId();

		foreach ($repositoriesConfigs as $repositoryConfigName => $repositoryConfig) {
			$repositoryClass = $repositoryConfig[self::KEY_REPOSITORY_CLASS];
			$this
				->getContainerBuilder()
				->addDefinition($this->extension->prefix($repositoryConfigName))
				->setClass($repositoryClass)
				->setFactory(self::class . '::create', [ $repositoryConfigName, '@' . $containerWrapperServiceId ]);
		}
	}

	public static function create($repositoryConfigName, $containerWrapperService): AggregateRepository
	{
		return AggregateRepositoryFactory::$repositoryConfigName($containerWrapperService);
	}
}
