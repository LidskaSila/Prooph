<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\AsynchronousMessages\Factories;

class AsynchronousQueryProducerFactory extends AbstractAsynchronousMessageProducerFactory
{

	public const SECTION_CONFIG_ID = 'queries';

	public function __construct(string $configId = self::SECTION_CONFIG_ID)
	{
		parent::__construct($configId);
	}
}
