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
        // if the command was not found it should return null, then default command will be used.
    }
    
    public function handleArguments(CommandInterface $command): void
    {
        // here you should handle arguments, find and set value, set indication and other.
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

After that, executes handleArguments() method and passes the command. It can be a command, returned by the getCommand() method, or default command if specified.
The handleArguments() method should handle the arguments and distribute them.

In the end, the getNextArguments() method executes. It should return an array of next arguments, which will be passed to the handle() method of the command.

## Distributor
The Distributor is a default implementation of the DistributorInterface interface.

A formatter is used to work with arguments.

Distributor distributes arguments according to the rules below:
- Command and is a plaintext without quotes or dashes.
- Utility is same as command and pure value. By default, utility is not used.
- Value is a text quoted by ' or ". It looks like "value". Is necessary to distinguish a value from a command.
- Pure value is a text without quotes, spaces, dashes and other.
- Option is a text starts with one or two dashes. It looks like -o --option --equalSeparatedOption=value.
- Equal-separated option provides an option(s) with values in one argument.

```bash
# All text after command will be transferred as $nextArgs.

# Full-name option with value and nested command.
myscript --my-option "myvalue" command --my-nested-option nested-command

# Full-name option with pure-value and nested command.
myscript --my-option myvalue command --my-nested-option nested-command

# Abbreviated option with value and nested command.
myscript -o "myvalue" command -n nested-command

# Abbreviated option with pure-value and nested command.
myscript -o myvalue command -n nested-command

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

It's recommended to not specify pure-value same as commands, because distributor by default finds first match of the command name.

```bash
# It this case, first command word will be regarded as a command.
# Values after the command will be used as next arguments.
myscript --my-option command command

# To avoid this you can enclose a value in quotes.
myscript --my-option "command" command

# Or you can use equal-separated options.
myscript --my-option=command command
```