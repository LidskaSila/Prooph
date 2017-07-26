<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\AsynchronousMessages\Factories;

class AsynchronousCommandProducerFactory extends AbstractAsynchronousMessageProducerFactory
{

	public const SECTION_CONFIG_ID = 'commands';

	public function __construct(string $configId = self::SECTION_CONFIG_ID)
	{
		parent::__construct($configId);
	}
}
