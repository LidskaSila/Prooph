<?php

namespace LidskaSila\Prooph\AsynchronousMessages;

interface AsynchronousMessageProducerBridge
{

	public function publishWithRoutingKey($routingKey, $data): void;
}
