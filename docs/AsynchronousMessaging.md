# AsynchronousMessaging

<p>
    If you want integrate prooph with some asynchronous messaging library
    of your choice (for example <a href="https://github.com/Kdyby/RabbitMq">Kdyby/RabbitMq</a>),
    you need to write whole implementation of `Prooph\ServiceBus\Async\MessageProducer` on your own. 
    And you need to make it so that you can configure what message to what producer/exchange should go, right?
    But hang on boy.
</p>

## This package is shipped with configurable MessageProducer
<p>
    Implemented with 
    `LidskaSila\Prooph\AsynchronousMessages\AsynchronousMessageProducer`,
    to make it little bit easier for you. It is automatically 
    registered in Nette container with special id for each bus (if you provide 
    special config for it).
</p>

<p>
    In this config (example for asynchronous events configuration):
</p>

```yaml
prooph:
    asynchronous_messaging:
        events:
            bridge: "@producerBridge"
            routes:
                LidskaSila\Prooph\Tests\EventSourcing\FakeImplementations\TestAggregateCreated: producerRouteKey
```

<p>
    you set your routes and type/id of your service that implements bridge interface 
    (`LidskaSila\Prooph\AsynchronousMessages\AsynchronousMessageProducerBridge`)
    (Yes, damn, you still have to implement something but I will show you, it's easy!).
</p>

<p>
    This will register service `LidskaSila\Prooph\AsynchronousMessages\AsynchronousMessageProducer` 
    with container id "prooph.asynchronous_messaging.events".
</p>

<p>
    But to make it work, you need to have registered two services:
</p>
<ol>
    <li>
        Your implementation of `LidskaSila\Prooph\AsynchronousMessages\AsynchronousMessageProducerBridge` 
        with ID you provided in asynchronous_messaging config (you can have it type based).
    </li>
    <li>
        Some `Prooph\Common\Messaging\MessageConverter` implementation - it is strategy of how 
        your Message will be converted to array.
        There is default NoOpMessageConverter or you can implement your own. ;)
    </li>
</ol>

For example:

```yaml
services:
    producerBridge: LidskaSila\Prooph\Tests\AsynchronousMessages\FakeImplementations\TestAsynchronousMessageProducerBridge
    - Prooph\Common\Messaging\NoOpMessageConverter
```

<br>

Then, you can set async_switch router at Command, Event and/or Query bus configuration with
that special id. To stick to our example:
```yaml
prooph:
    service_bus:
        event_bus:
            router:
                async_switch: "@prooph.asynchronous_messaging.events"
```

## Final working example config might be:

```yaml
prooph:
    asynchronous_messaging:
        events:
            bridge: "@producerBridge"
            routes:
                LidskaSila\Prooph\Tests\EventSourcing\FakeImplementations\TestAggregateCreated: producerRouteKey
    service_bus:
        event_bus:
            router:
                async_switch: "@prooph.asynchronous_messaging.events"
                
services:
    producerBridge: LidskaSila\Prooph\Tests\AsynchronousMessages\FakeImplementations\TestAsynchronousMessageProducerBridge
    - Prooph\Common\Messaging\NoOpMessageConverter
    - Prooph\Common\Messaging\FQCNMessageFactory
```

<p>
    Now, your messages emmited from bus will go through your implementation of bridge you set.
</p>

<p>
    Note: messages are routed based on message-name parameter, not class name! 
    It's just that by default message-name parameter equals message class name.
</p>

<br>

## Example `AsynchronousMessageProducerBridge` implementation
<p>
    Implementing `LidskaSila\Prooph\AsynchronousMessages\AsynchronousMessageProducerBridge` is very easy,
    it has just one method: 
</p>

```php
<?php

namespace LidskaSila\Prooph\AsynchronousMessages;

interface AsynchronousMessageProducerBridge
{

    public function publishWithRoutingKey($routingKey, $data): void;
}
```

<p>
    So in case of Kdyby/Rabbit, for example, it can be implemented as easy as:
</p>


```php
<?php

namespace Example\Infrastructure;

use Kdyby\RabbitMq\Connection;
use LidskaSila\Prooph\AsynchronousMessages\AsynchronousMessageProducerBridge;

class AsynchronousMessageProducer implements AsynchronousMessageProducerBridge
{

    /* @var Connection */
    private $rabbit;

    public function __construct(Connection $rabbit)
    {
        $this->rabbit = $rabbit;
    }

    public function publishWithRoutingKey($producerName, $data): void
    {
        $jsonData = json_encode($data);
        $this->rabbit->getProducer($producerName)->publish($jsonData, $producerName);
    }
}

```
