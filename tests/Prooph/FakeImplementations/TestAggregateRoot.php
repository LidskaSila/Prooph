<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\FakeImplementations;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

class TestAggregateRoot extends AggregateRoot
{

	protected function aggregateId(): string
	{
		return 'fake';
	}

	protected function apply(AggregateChanged $event): void
	{
	}
}
