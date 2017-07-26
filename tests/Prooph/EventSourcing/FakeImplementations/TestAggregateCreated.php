<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\EventSourcing\FakeImplementations;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\ServiceBus\Async\AsyncMessage;
use Ramsey\Uuid\UuidInterface;

class TestAggregateCreated extends AggregateChanged implements AsyncMessage
{

	private const TEST_PAYLOAD_KEY   = 'key';
	private const TEST_PAYLOAD_VALUE = 'value';
	public const TEST_PAYLOAD = [
				self::TEST_PAYLOAD_KEY => self::TEST_PAYLOAD_VALUE,
			];

	public static function create(UuidInterface $uuid): AggregateChanged
	{
		return self::occur(
			$uuid->toString(),
			self::TEST_PAYLOAD
		);
	}
}
