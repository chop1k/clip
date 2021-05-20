# Events
Consolly have lifecycle events. Every event dispatches at a specific stage of life.
Consolly uses [symfony/event-dispatcher](https://symfony.com/doc/current/components/event_dispatcher.html) component for subscribing and dispatching events.
For more information read the symfony docs.

Subscribers or listeners defines via the dispatcher

```php
use Consolly\Consolly;

$consolly = Consolly::default($argv);

$dispatcher = $consolly->getDispatcher();

$dispatcher->addSubscriber(new ExceptionSubscriber());
```

or via the builder

```php
use Consolly\ConsollyBuilder;

$builder = new ConsollyBuilder();

$builder
    ->withSubscriber(new ExceptionSubscriber())
->build($argv);
```

## List of events
All events located at appropriate class as constants.
- Consolly events - [ConsollyEvents](../src/ConsollyEvents.php) class.
- Distributor events - [DistributorEvents](../src/Distributor/DistributorEvents.php) class.
- Source events - [SourceEvents](../src/Source/SourceEvents.php) class.

Consolly events
- consolly.exception - Dispatches when any exception thrown.

```php
use Consolly\ConsollyEvents;
use Consolly\Event\Consolly\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ConsollyEvents::EXCEPTION => 'onException'
        ];
    }
    
    public function onException(ExceptionEvent $event): void
    {
        /*
         * Here you can handle the event.
         * 
         * You can overwrite the exception to your custom exception,
         * use the appropriate accessors for this.
         * 
         * You also can return result as it returned by the command handle() method.
         * In this case, the exception will be skipped.
         * (result must not be null, otherwise the exception will not be skipped.)
         */
    }
}
```

Source events
- consolly.source.arguments - Dispatches after execution of the getArguments() method.

```php
use Consolly\Event\Source\ArgumentsEvent;use Consolly\Source\SourceEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ArgumentsSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            SourceEvents::ARGUMENTS => 'onArguments'
        ];
    }
    
    public function onArguments(ArgumentsEvent $event): void
    {
        /*
         * Here you can handle the event.
         * 
         * You can rewrite the arguments by using the appropriate accessors.
         */
    }
}
```

Distributor events
- consolly.distributor.commands - Dispatches before setting the commands.

```php
use Consolly\Distributor\DistributorEvents;
use Consolly\Event\Distributor\CommandsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommandsSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            DistributorEvents::COMMANDS => 'onCommands'
        ];
    }
    
    public function onCommands(CommandsEvent $event): void
    {
        /*
         * Here you can handle the event.
         * 
         * You can rewrite the commands by using the appropriate methods.
         */
    }
}
```

- consolly.distributor.command_not_found - Dispatches when command not found and no default command specified.

```php
use Consolly\Distributor\DistributorEvents;
use Consolly\Event\Distributor\CommandNotFoundEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommandNotFoundSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            DistributorEvents::COMMAND_NOT_FOUND => 'onCommandNotFound'
        ];
    }
    
    public function onCommandNotFound(CommandNotFoundEvent $event): void
    {
        /*
         * Here you can handle the event.
         * 
         * You can get all registered commands
         * and set the command by using the appropriate methods.
         */
    }
}
```

- consolly.distributor.command_found - Dispatches when command found. It dispatches even if the command specified by the event.

```php
use Consolly\Distributor\DistributorEvents;
use Consolly\Event\Distributor\CommandFoundEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommandFoundSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            DistributorEvents::COMMAND_FOUND => 'onCommandFound'
        ];
    }
    
    public function onCommandFound(CommandFoundEvent $event): void
    {
        /*
         * Here you can handle the event.
         * 
         * You can rewrite the command by using appropriate methods.
         */
    }
}
```

- consolly.distributor.next_arguments - Dispatches after getting the next arguments by the distributor.

```php
use Consolly\Distributor\DistributorEvents;
use Consolly\Event\Distributor\NextArgumentsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NextArgumentsSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            DistributorEvents::NEXT_ARGUMENTS => 'onNextArguments'
        ];
    }
    
    public function onNextArguments(NextArgumentsEvent $event): void
    {
        /*
         * Here you can handle the event.
         * 
         * You can get or rewrite the next arguments by using the appropriate methods.
         */
    }
}
```