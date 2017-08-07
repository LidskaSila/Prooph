# Configuration

## Supported prooph libraries
<ul>
<li>Event Sourcing (<a href="https://github.com/prooph/event-sourcing">prooph/event-sourcing</a>)</li>
<li>Event Store (<a href="https://github.com/prooph/event-store">prooph/event-store</a>)</li>
<li>PDO Event Store (<a href="https://github.com/prooph/pdo-event-store">prooph/pdo-event-store</a>) - support for projection_manager config</li>
<li>Service Buses (<a href="https://github.com/prooph/service-bus">prooph/service-bus</a>)</li>
<li>More to come (you can wait or contribute :P)</li>
</ul>

## Basics
<p>
	Array structure for configuration is exactly same as in original prooph libraries, because
	extension uses original interop factories from toolbox. 
	However there is some additional config fields (listed below).
</p>

## Example
<p>
	Example basic neon configuration can be found <a href="https://github.com/LidskaSila/Prooph/blob/master/tests/Prooph/configs/FullTestConfig.neon">here</a>
	or you can see other <a href="https://github.com/LidskaSila/Prooph/tree/master/tests/Prooph/configs">working test configs</a> for inspiration.
</p>

## Additional config fields

### `event_store`
<p>
	There is additional configuration in `event_store` library config. 
	It has special key `use`, where you need to define which config name and factory should be used:
</p>

```yaml
prooph:
    event_store:
        use:
            config: default
            factory: Prooph\EventStore\Container\InMemoryEventStoreFactory
```

### `projection_manager`
<p>
	There is additional configuration in `projection_manager` library config. 
	It has special key `use`, where you need to define which config name and factory should be used:
</p>

```yaml
prooph:
    projection_manager:
        use:
            config: default
            factory: Prooph\EventStore\Pdo\Container\MySqlProjectionManagerFactory
```
