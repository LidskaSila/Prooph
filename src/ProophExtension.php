<?php declare(strict_types = 1);

namespace LidskaSila\Prooph;

use LidskaSila\Prooph\Common\Configurator;
use LidskaSila\Prooph\Common\NetteContainerWrapper;
use Nette\DI\CompilerExtension;
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

	public function loadConfiguration()
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

	private function registerContainerWrapper(): void
	{
		/** @var ContainerBuilder $containerBuilder */
		$containerBuilder = $this->getContainerBuilder();

		if (!$containerBuilder->getByType(NetteContainerWrapper::class)) {
			$containerBuilder
				->addDefinition($this->getNetteContainerWrapperDefinitionId())
				->setClass(NetteContainerWrapper::class)
				->setArguments([ [ $this->configurator->getConfigKey() => $this->config ] ]);
		}
	}

	private function getNetteContainerWrapperDefinitionId()
	{
		return $this->prefix('NetteContainerWrapper');
	}
}

