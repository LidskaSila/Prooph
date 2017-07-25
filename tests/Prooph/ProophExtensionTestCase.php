<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\Configurators;

use Nette\Configurator;
use Nette\DI\Container;
use PHPUnit\Framework\TestCase;

abstract class ProophExtensionTestCase extends TestCase
{

	private const CONFIGS_DIR = 'configs';
	private const DEFAULT_TEST_FILE = 'test.neon';

	/** @var Container */
	protected $container;

	protected function givenTestConfig($configPath = self::DEFAULT_TEST_FILE)
	{
		$config = new Configurator();
		$config->setTempDirectory(TEMP_DIR);
		$config->addConfig(__DIR__ . '/' . self::CONFIGS_DIR . '/' . $configPath);

		return $config;
	}

	protected function givenTestContainer($configPath = self::DEFAULT_TEST_FILE)
	{
		$testConfig = $this->givenTestConfig($configPath);

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
