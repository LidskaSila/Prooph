<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\AsynchronousMessages;

use LidskaSila\Prooph\AsynchronousMessages\Configurators\AsynchronousCommandProducerConfigurator;
use LidskaSila\Prooph\AsynchronousMessages\Configurators\AsynchronousEventProducerConfigurator;
use LidskaSila\Prooph\AsynchronousMessages\Configurators\AsynchronousQueryProducerConfigurator;
use LidskaSila\Prooph\Common\CompositeConfigurator;
use LidskaSila\Prooph\Common\Configurator;

class AsynchronousMessagesConfigurator extends CompositeConfigurator
{

	public const KEY = 'asynchronous_messaging';

	public function getConfigKey(): string
	{
		return self::KEY;
	}

	/**
	 * @return Configurator[]|string[]
	 */
	protected function createConfigurators(): array
	{
		return [
			new AsynchronousCommandProducerConfigurator($this->extension),
			new AsynchronousEventProducerConfigurator($this->extension),
			new AsynchronousQueryProducerConfigurator($this->extension),
		];
	}
}
