<?php

namespace LidskaSila\Prooph\AsynchronousMessages;

use Prooph\Common\Messaging\Message;
use Prooph\Common\Messaging\MessageConverter;
use Prooph\Common\Messaging\MessageDataAssertion;
use Prooph\ServiceBus\Async\MessageProducer;
use Prooph\ServiceBus\Exception\RuntimeException;
use React\Promise\Deferred;

class AsynchronousMessageProducer implements MessageProducer
{

	/* @var AsynchronousMessageProducerBridge */
	private $producerBridge;

	/** @var MessageConverter */
	private $messageConverter;

	/** @var array */
	private $routes;

	public function __construct(AsynchronousMessageProducerBridge $producerBridge, MessageConverter $messageConverter)
	{
		$this->producerBridge   = $producerBridge;
		$this->messageConverter = $messageConverter;
	}

	public function injectRoutes(array $routes)
	{
		$this->routes = $routes;
	}

	public function __invoke(Message $message, Deferred $deferred = null): void
	{
		if ($deferred !== null) {
			throw new RuntimeException(__CLASS__ . ' cannot handle query messages which require future responses.');
		}
		$data = $this->arrayFromMessage($message);

		$producerName = $this->getProducerRouteKey($message);

		$this->producerBridge->publishWithRoutingKey($producerName, $data);
	}

	private function arrayFromMessage(Message $message): array
	{
		$messageData = $this->messageConverter->convertToArray($message);
		MessageDataAssertion::assert($messageData);
		$messageData['created_at'] = $message->createdAt()->format('Y-m-d\TH:i:s.u');

		return $messageData;
	}

	private function getProducerRouteKey(Message $message): string
	{
		if (empty($this->routes[$message->messageName()])) {
			throw new RuntimeException(
				sprintf(
					'Producer route key for message of name "%s" in asynchronous routing not found.',
					$message->messageName()
				)
			);
		}
		return $this->routes[$message->messageName()];
	}
}
