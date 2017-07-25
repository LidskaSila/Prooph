<?php declare(strict_types = 1);

namespace LidskaSila\Prooph;

use LidskaSila\Prooph\Common\Configurator;
use LidskaSila\Prooph\Common\NetteContainerWrapper;
use Nette\DI\CompilerExtension;
use Nette\DI\Container;
use Nette\DI\ContainerBuilder;

class ProophExtension extends CompilerExtension
{

	/** @var array */
	public $defaults = [];

	/** @var Configurator */
	public $configurator;

	public function __construct()
	{
		$this->configurator = new ProophExtensionConfigurator($this);
	}

	public function loadConfiguration(): void
	{
		$this->defaults = $this->configurator->buildDefaultConfig();
		$this->config   = $this->mergeConfigIntoDefaults($this->config, $this->defaults);

		$this->registerContainerWrapper();

		$this->configurator->loadConfiguration($this->config);
	}

	private function mergeConfigIntoDefaults($original, $default): array
	{
		return array_replace_recursive($default, $original);
	}

	/**
	 * Container wrapper is needed in every interop factory, so we register it first.
	 */
	private function registerContainerWrapper(): void
	{
		/** @var ContainerBuilder $containerBuilder */
		$containerBuilder = $this->getContainerBuilder();

		if (!$containerBuilder->getByType(NetteContainerWrapper::class)) {
			$jsonConfig         = $this->determineJsonConfig();
			$containerServiceId = $this->getContainerServiceId($containerBuilder);

			$containerBuilder
				->addDefinition($this->getNetteContainerWrapperDefinitionId())
				->setClass(NetteContainerWrapper::class)
				->setFactory(static::class . '::createContainerWrapper', [ $jsonConfig, '@' . $containerServiceId ]);
		}
	}

	public static function createContainerWrapper(string $jsonConfig, $container): NetteContainerWrapper
	{
		$config = json_decode($jsonConfig, true);

		return new NetteContainerWrapper($config, $container);
	}

	private function getNetteContainerWrapperDefinitionId(): string
	{
		return $this->prefix('NetteContainerWrapper');
	}

	private function determineJsonConfig(): string
	{
		// Putting config array to json, because we want keep service links (@serviceId) in config as string.
		// If it would be array, Nette would replace all these string based links with real services.
		$config     = [ $this->configurator->getConfigKey() => $this->config ];
		return json_encode($config);
	}

	private function getContainerServiceId(ContainerBuilder $containerBuilder): string
	{
		return (string) $containerBuilder->getByType(Container::class);
	}
}

