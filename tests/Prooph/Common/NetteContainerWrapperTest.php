<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\Configurators;

use LidskaSila\Prooph\Common\NetteContainerWrapper;
use LidskaSila\Prooph\Common\NetteContainerWrapper\ContainerException;
use LidskaSila\Prooph\Common\NetteContainerWrapper\NotFoundException;
use Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy;

class NetteContainerWrapperTest extends ProophExtensionTestCase
{

	private const FAKE_CONFIG = [ 'key' => 'value' ];

	/** @var NetteContainerWrapper */
	protected $containerWrapper;

	public function testGet_NotExistingService_ShouldThrowNotFoundException()
	{
		$this->givenNetteContainerWrapper();

		$this->willThrowException(NotFoundException::class);

		$this->whenGetByKey('not_existing');
	}

	public function testGet_WithInvalidParameter_ShouldThrowContainerException()
	{
		$this->givenNetteContainerWrapper();

		$this->willThrowException(ContainerException::class);

		$this->whenGetByKey(new \DateTime());
	}

	public function testGet_ExistingServiceByType_ShouldReturnExpectedInstance()
	{
		$this->givenNetteContainerWrapper();

		$service = $this->whenGetByKey(OnEventStrategy::class);

		$this->thenIsInstanceOfExpectedClass(OnEventStrategy::class, $service);
	}

	public function testGet_ExistingServiceById_ShouldReturnExpectedInstance()
	{
		$this->givenNetteContainerWrapper();

		$service = $this->whenGetByKey('@onEventStrategy');

		$this->thenIsInstanceOfExpectedClass(OnEventStrategy::class, $service);
	}

	public function testGet_Config_ShouldReturnExpectedConfig()
	{
		$this->givenNetteContainerWrapper();

		$actualConfig = $this->whenGetByKey('config');

		$this->thenIsExpectedConfig($actualConfig);
	}

	public function testHas_ExistingServiceByType_ShouldReturnTrue()
	{
		$this->givenNetteContainerWrapper();

		$has = $this->whenAskIfHasKey(OnEventStrategy::class);

		$this->thenResultIsTrue($has);
	}

	public function testHas_ExistingServiceById_ShouldReturnTrue()
	{
		$this->givenNetteContainerWrapper();

		$has = $this->whenAskIfHasKey('@onEventStrategy');

		$this->thenResultIsTrue($has);
	}

	public function testHas_Config_ShouldReturnTrue()
	{
		$this->givenNetteContainerWrapper();

		$has = $this->whenAskIfHasKey('config');

		$this->thenResultIsTrue($has);
	}

	private function givenNetteContainerWrapper()
	{
		$this->givenTestContainer();
		$config                 = $this->givenFakeConfig();
		$this->containerWrapper = new NetteContainerWrapper($config, $this->container);
	}

	private function givenFakeConfig()
	{
		return self::FAKE_CONFIG;
	}

	private function whenGetByKey($key)
	{
		return $this->containerWrapper->get($key);
	}

	private function whenAskIfHasKey($key)
	{
		return $this->containerWrapper->has($key);
	}

	private function thenIsExpectedConfig($actualConfig)
	{
		self::assertEquals(self::FAKE_CONFIG, $actualConfig);
	}

	private function willThrowException($class)
	{
		self::expectException($class);
	}

	private function thenResultIsTrue($has)
	{
		self::assertTrue($has);
	}
}
