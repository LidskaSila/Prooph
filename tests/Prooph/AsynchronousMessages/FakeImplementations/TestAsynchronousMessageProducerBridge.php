<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\AsynchronousMessages\FakeImplementations;

use LidskaSila\Prooph\AsynchronousMessages\AsynchronousMessageProducerBridge;

class TestAsynchronousMessageProducerBridge implements AsynchronousMessageProducerBridge
{

	public const KEY_ROUTING_KEY = 'routingKey';
	public const KEY_DATA        = 'data';

	private $published = [];

	public function publishWithRoutingKey($routingKey, $data): void
	{
		$this->published[] = [
			self::KEY_ROUTING_KEY => $routingKey,
			self::KEY_DATA        => $data,
		];
	}

	public function getPublished()
	{
		return $this->published;
	}
}
