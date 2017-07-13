<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Configurators;

use LidskaSila\Prooph\ProophExtension;
use Nette\PhpGenerator\Method;

abstract class CompositeConfigurator extends DefaultConfigurator
{

	/** @var Configurator[] */
	public $configurators = [];

	public function __construct(ProophExtension $extension)
	{
		parent::__construct($extension);
		$this->configurators = $this->createConfigurators();
	}

	/**
	 * @return Configurator[]
	 */
	abstract protected function createConfigurators(): array;

	abstract public function getConfigKey(): ?string;

	public function buildDefaultConfig(): array
	{
		$config = [];
		foreach ($this->configurators as $configurator) {
			$config[$configurator->getConfigKey()] = $configurator->buildDefaultConfig();
		}

		return $config;
	}

	public function loadConfiguration(array $config): void
	{
		foreach ($this->configurators as $configurator) {
			$serviceConfig = $config[$configurator->getConfigKey()];
			$configurator->loadConfiguration($serviceConfig);
		}
	}
}
