<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\EventSourcing\FakeImplementations;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class TestAggregateRoot extends AggregateRoot
{

	public static function create(UuidInterface $uuid = null)
	{
		$uuid = $uuid ?: Uuid::uuid4();
		$instance = new self();
		$instance->recordThat(TestAggregateCreated::create($uuid));

		return $instance;
	}

	protected function aggregateId(): string
	{
		return 'fake';
	}

	protected function apply(AggregateChanged $event): void
	{
	}
}
