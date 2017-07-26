<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\AsynchronousMessages;

use InvalidArgumentException;
use LidskaSila\Prooph\AsynchronousMessages\Factories\AbstractAsynchronousMessageProducerFactory;
use PHPUnit\Framework\TestCase;

class AbstractAsynchronousMessageProducerFactoryTest extends TestCase
{

	public function testCallStatic_WithoutContainerWrapper_ShouldThrowInvalidArgumentException()
	{
		$this->willFailWith(InvalidArgumentException::class);

		$this->whenCallStaticWithoutContainerWrapper();
	}

	private function willFailWith($class)
	{
		self::expectException(InvalidArgumentException::class);
	}

	private function whenCallStaticWithoutContainerWrapper(): void
	{
		$factoryClass = $this->getFactoryClass();
		$factoryClass::testWithoutContainerWrapper();
	}

	private function getFactoryClass(): string
	{
		return AbstractAsynchronousMessageProducerFactory::class;
	}
}
