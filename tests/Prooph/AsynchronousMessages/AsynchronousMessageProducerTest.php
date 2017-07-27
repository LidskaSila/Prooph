<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\AsynchronousMessages;

use LidskaSila\Prooph\AsynchronousMessages\AsynchronousMessageProducer;
use LidskaSila\Prooph\Tests\AsynchronousMessages\FakeImplementations\TestAsynchronousMessageProducerBridge;
use LidskaSila\Prooph\Tests\EventSourcing\FakeImplementations\TestAggregateCreated;
use Mockery;
use PHPUnit\Framework\TestCase;
use Prooph\Common\Messaging\Message;
use Prooph\Common\Messaging\NoOpMessageConverter;
use Prooph\ServiceBus\Exception\RuntimeException;
use Ramsey\Uuid\Uuid;
use React\Promise\Deferred;

class AsynchronousMessageProducerTest extends TestCase
{

	const TEST_PRODUCER_ROUTE_KEY = 'producerRouteKey';

	/** @var TestAsynchronousMessageProducerBridge */
	private $testProducerBridge;

	/** @var AsynchronousMessageProducer */
	private $testProducer;

	public function setUp()
	{
		parent::setUp();
		$this->givenTestProducerBridge();
		$this->givenAsynchronousMessageProducer();
	}

	public function testInvoke_WithDeferredParam_ShouldThrowRuntimeException()
	{
		$testMessage = $this->givenTestMessage();
		$deffered    = $this->givenMockedDeffered();

		$this->willFailWith(RuntimeException::class);

		$this->whenInvokeProducerWith($testMessage, $deffered);
	}

	public function testInvoke_WithoutRoutes_ShouldThrowRuntimeException()
	{
		$testMessage = $this->givenTestMessage();

		$this->willFailWith(RuntimeException::class);

		$this->whenInvokeProducerWith($testMessage);
	}

	public function testInvoke_WithProperRoute_ShouldPublishExpectedMessageToExpectedProducerRouteKey()
	{
		$this->givenTestProducerHasInjectedTestRoute();

		$testMessage = $this->givenTestMessage();

		$this->whenInvokeProducerWith($testMessage);

		$this->thenShouldPublishExpectedMessageToExpectedProducerRouteKey(self::TEST_PRODUCER_ROUTE_KEY);
	}

	private function givenTestProducerBridge(): void
	{
		$this->testProducerBridge = new TestAsynchronousMessageProducerBridge();
	}

	private function givenAsynchronousMessageProducer(): void
	{
		$messageConverter   = new NoOpMessageConverter();
		$this->testProducer = new AsynchronousMessageProducer($this->testProducerBridge, $messageConverter);
	}

	private function givenMockedDeffered(): Deferred
	{
		$deffered = Mockery::mock('React\Promise\Deferred');
		assert($deffered instanceof Deferred);

		return $deffered;
	}

	private function givenTestProducerHasInjectedTestRoute()
	{
		$this->testProducer->injectRoutes(
			[
				TestAggregateCreated::class => self::TEST_PRODUCER_ROUTE_KEY,
			]
		);
	}

	private function givenTestMessage(): Message
	{
		return TestAggregateCreated::create(Uuid::uuid4());
	}

	private function willFailWith($class)
	{
		self::expectException($class);
	}

	private function whenInvokeProducerWith(Message $message, Deferred $deferred = null): void
	{
		$producer = $this->testProducer;
		$producer($message, $deferred);
	}

	private function thenShouldPublishExpectedMessageToExpectedProducerRouteKey($expectedProducerRouteKey): void
	{
		$publishedMessagesDump = $this->getPublishedEventsFromTestBridge();

		self::assertCount(1, $publishedMessagesDump);
		$publishedProducerRouteKey = $publishedMessagesDump[0][TestAsynchronousMessageProducerBridge::KEY_ROUTING_KEY];
		$publishedMessageData      = $publishedMessagesDump[0][TestAsynchronousMessageProducerBridge::KEY_DATA];
		self::assertEquals($publishedProducerRouteKey, $expectedProducerRouteKey);
		self::assertEquals($publishedMessageData['message_name'], TestAggregateCreated::class);
		self::assertEquals($publishedMessageData['payload'], TestAggregateCreated::TEST_PAYLOAD);
	}

	private function getPublishedEventsFromTestBridge(): array
	{
		return $this->testProducerBridge->getPublished();
	}
}
