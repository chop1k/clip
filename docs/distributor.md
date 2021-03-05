# Distributor
Distributor is a class which implements DistributorInterface interface.

The distributor is responsible for the distribution and processing of arguments.

```php
use Consolly\Command\CommandInterface;
use Consolly\Distributor\DistributorInterface;

class MyDistributor implements DistributorInterface
{
    public function setCommands(array $commands): void
    {
        // here you can handle a commands.
    }
    
    public function setArguments(array $arguments): void
    {
        // here you can preprocessing an arguments.
    }
    
    public function getCommand(): ?CommandInterface
    {
        // here you should find the command and return it.
        // if the command was not found it should return null, then default command will be user 
    }
    
    public function handleOptions(CommandInterface $command): void
    {
        // here you should handle options and arguments, find and set value, set indication and other.
    }
    
    public function getNextArguments(): array
    {
        // here you should return array of next arguments.
        // the arguments can be any array.
    }
}
```

First executes the setCommands() method, where you can handle the commands.

Next executes the setArguments() method, where you can handle the arguments, given by a source.

Then executes the getCommand() method, which should return the command or null if command was not found.

After that, executes handleOption() method and passes the command. It can be a command, returned by the getCommand() method, or default command if specified.
The handleOptions() method should handle the arguments and distribute them.

In the end, the getNextArguments() method executes. It should return an array of next arguments, which will be passed to the handle() method of the command.

## Distributor
The Distributor is a default implementation of the DistributorInterface interface.

Distributor distributes arguments according to the rules below:
- Command is a plaintext without quotes or dashes.
- Value is a text quoted by ' or ". It looks like "value".
- Option is a text starts with one or two dashes. It looks like -o --option --equalSeparatedOption=value.

All text after command will be transferred as $nextArgs.

```bash
# Full-name option with value and nested command.
myscript --my-option "myvalue" command --my-nested-option nested-command

# Abbreviated option with value and nested command.
myscript -o "myvalue" command -n nested-command

# Equal-separated option with value and nested command.
myscript --my-option=myvalue command --my-nested-option nested-command

# Full-name options without nested commands.
myscript --first-option --second-option --third-option command

# Abbreviated options without nested commands.
myscript -fst command

# Abbreviated options with value.
myscript -fst "first option value" "second option value" "third option value" command

# Equal-separated abbreviated options.
myscript -fst=options_value command
```

If you use ConsoleArgumentsSource, it will ignore first argument "myscript".
To turn off this, you should set $ignoreFirst parameter to false. You can do this via the constructor or an accessor.