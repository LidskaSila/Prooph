<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\Configurators;

use Nette\Configurator;
use Nette\DI\Container;
use PHPUnit\Framework\TestCase;

abstract class ProophExtensionTestCase extends TestCase
{

	/** @var Container */
	protected $container;

	protected function givenTestConfig()
	{
		$config = new Configurator();
		$config->setTempDirectory(TEMP_DIR);
		$config->addConfig(__DIR__ . '/config/test.neon');

		return $config;
	}

	protected function givenTestContainer()
	{
		$testConfig = $this->givenTestConfig();

		$this->container = $testConfig->createContainer();
	}

	protected function whenGetServiceByTypeFromContainer($classType)
	{
		return $this->container->getByType($classType);
	}

	protected function thenIsInstanceOfExpectedClass($expected, $actual): void
	{
		self::assertInstanceOf($expected, $actual);
	}

	protected function thenPass(): void
	{
		self::assertTrue(true);
	}
}
