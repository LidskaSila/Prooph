<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Configurators;

use LidskaSila\Prooph\Common\NetteContainerWrapper;
use LidskaSila\Prooph\ProophExtension;
use Nette\DI\ContainerBuilder;

abstract class DefaultConfigurator implements Configurator
{

	/** @var ProophExtension */
	public $extension;

	public function __construct(ProophExtension $extension)
	{
		$this->extension = $extension;
	}

	protected function getContainerBuilder(): ContainerBuilder
	{
		return $this->extension->getContainerBuilder();
	}

	public function getContainerWrapperServiceId()
	{
		$containerBuilder = $this->getContainerBuilder();

		return $containerBuilder->getByType(NetteContainerWrapper::class);
	}
}
