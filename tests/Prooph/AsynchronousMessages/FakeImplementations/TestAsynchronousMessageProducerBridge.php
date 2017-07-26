<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\AsynchronousMessages\FakeImplementations;

use LidskaSila\Prooph\AsynchronousMessages\AsynchronousMessageProducerBridge;

class TestAsynchronousMessageProducerBridge implements AsynchronousMessageProducerBridge
{

	public const KEY_PRODUCER_ROUTE_KEY = 'producer';
	public const KEY_DATA               = 'data';

	private $published = [];

	public function publishToProducerOfName($producerName, $data): void
	{
		$this->published[] = [
			self::KEY_PRODUCER_ROUTE_KEY => $producerName,
			self::KEY_DATA               => $data,
		];
	}

	public function getPublished()
	{
		return $this->published;
	}
}
