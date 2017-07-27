# Configuration

## Supported prooph libraries
<ul>
<li>Event Sourcing (<a href="https://github.com/prooph/event-sourcing">prooph/event-sourcing</a>)</li>
<li>Event Store (<a href="https://github.com/prooph/event-store">prooph/event-store</a>)</li>
<li>Service Buses (<a href="https://github.com/prooph/service-bus">prooph/service-bus</a>)</li>
<li>More to come (you can wait or contribute :P)</li>
</ul>

## Basics

Array structure for configuration is exactly same as in original prooph libraries, because
extension uses original interop factories from toolbox. 
However there is some additional config fields (listed below).

## Example
Example basic neon configuration is as follows below. 

```yaml
extensions:
    prooph: LidskaSila\Prooph\ProophExtension

prooph:
    event_sourcing:
        aggregate_repository:
            test_repository:
                repository_class: LidskaSila\Prooph\Tests\FakeImplementations\MemoryTestRepository
                aggregate_type: LidskaSila\Prooph\Tests\FakeImplementations\TestAggregateRoot
                aggregate_translator: Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator
                one_stream_per_aggregate: true
    event_store:
        use:
            config: default
            factory: Prooph\EventStore\Container\InMemoryEventStoreFactory
        default:
            plugins:
                - Prooph\EventStoreBusBridge\EventPublisher
    service_bus:
        command_bus:
            plugins:
                - Prooph\ServiceBus\Plugin\InvokeStrategy\HandleCommandStrategy
            router:
                routes:
        event_bus:
            plugins:
                - Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy
            router:
                routes:
        query_bus:
            plugins:
            router:
                routes:

services:
    onEventStrategy: Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy
    - Prooph\ServiceBus\Plugin\InvokeStrategy\HandleCommandStrategy
    - Prooph\EventStoreBusBridge\EventPublisher
    - Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator
    - Prooph\Common\Messaging\FQCNMessageFactory
```

## Additional config fields

### `event_store`
There is additional configuration in `event_store` library config. 
It has special key `use`, where you need to define which config name and factory should be used:

```yaml
    event_store:
        use:
            config: default
            factory: Prooph\EventStore\Container\InMemoryEventStoreFactory
```
