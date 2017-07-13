# LidskaSila/Prooph

[![Build Status](https://img.shields.io/travis/LidskaSila/Prooph.svg?style=flat-square)](https://travis-ci.org/LidskaSila/Prooph)
[![Quality Score](https://img.shields.io/scrutinizer/g/LidskaSila/Prooph.svg?style=flat-square)](https://scrutinizer-ci.com/g/LidskaSila/Prooph)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/LidskaSila/Prooph.svg?style=flat-square)](https://scrutinizer-ci.com/g/LidskaSila/Prooph)

Nette extension for <a href="https://github.com/prooph">prooph</a> toolbox family.

If you are new to Domain Driven Design, CQRS or Event Sourcing, I recommend 
<a href="https://github.com/heynickc/awesome-ddd">this source list</a>.

If you are new to prooph, I recommend: 
<ol>
<li>Read <a href="http://getprooph.org/docs/html/">Prooph documentation</a></li>
<li>Dive deep in code of <a href="https://github.com/prooph/proophessor-do">example real life application</a> built on top of prooph toolbox.</li>
<li>Join to <a href="https://gitter.im/prooph/improoph">prooph gitter chat</a></li>
</ol>

This extension allows you to configure following libraries in neon config:

<ul>
<li>Event Sourcing (<a href="https://github.com/prooph/event-sourcing">prooph/event-sourcing</a>)</li>
<li>Event Store (<a href="https://github.com/prooph/event-store">prooph/event-store</a>)</li>
<li>Service Buses (<a href="https://github.com/prooph/service-bus">prooph/service-bus</a>)</li>
<li>More to come (you can wait or contribute :P)</li>
</ul>

Example basic neon configuration is as follows below. 
Array structure is exactly same as in original prooph libraries.

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


Extension uses original iterop factories from toolbox.
The only addition is in `event_store` library config, which has special key `use`,
where you need to define which config name and factory should be used:
```yaml
    event_store:
        use:
            config: default
            factory: Prooph\EventStore\Container\InMemoryEventStoreFactory
```
 
## Contribute

Please feel free to fork and extend existing or add new features and send a pull request with your changes! 
To establish a consistent code quality, please provide unit tests for all your changes and may adapt the documentation.
