<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests;

use LidskaSila\Prooph\Tests\Configurators\ProophExtensionTestCase;
use Nette\Configurator;
use Nette\DI\Compiler;

class ProophExtensionTest extends ProophExtensionTestCase
{

	public function testGenerateContainer_WithConfiguredExtension_ShouldPass()
	{
		$config = $this->givenTestConfig('FullTestConfig.neon');

		$this->whenGenerateContainer($config);

		$this->thenPass();
	}

	protected function whenGenerateContainer(Configurator $config)
	{
		$config->generateContainer(new Compiler());
	}
}
