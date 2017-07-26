<?php

namespace LidskaSila\Prooph\AsynchronousMessages;

interface AsynchronousMessageProducerBridge
{

	public function publishToProducerOfName($producerName, $data): void;
}
