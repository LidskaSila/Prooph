<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\AsynchronousMessages;

use LidskaSila\Prooph\AsynchronousMessages\AsynchronousMessageProducer;
use LidskaSila\Prooph\Tests\Configurators\ProophExtensionTestCase;

class AsynchronousQueryProducerConfiguratorTest extends ProophExtensionTestCase
{

	const TEST_CONFIG           = 'AsynchronousMessages/AsynchronousQueryProducerTest.neon';
	const EXPECTED_SERVICE_NAME = 'prooph.asynchronous_messaging.queries';

	public function testGet_FromTestContainer_ShouldReturnExpectedInstance()
	{
		$this->givenTestContainer(self::TEST_CONFIG);

		$producer = $this->whenGetServiceByNameFromContainer(self::EXPECTED_SERVICE_NAME);

		$this->thenIsInstanceOfExpectedClass(AsynchronousMessageProducer::class, $producer);
	}
}
