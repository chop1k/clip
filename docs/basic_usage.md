# Basic usage
For use consolly you should create commands and options for the commands.
Alter that you should add your options to the command, create Consolly instance, add command to the Consolly class and execute the handle() method of the consolly instance.

## Commands
All commands must implement CommandInterface or extend Command class.
If you need custom logic, you can override it.

### Creating commands via Command class
Command class is helpful simple implementation of the CommandInterface where all variables and accessors are predefined and all you need to do - set default value, for example, in the constructor.

**WARNING: You must define values for every variable of this class because it has no default value.
Otherwise, when trying to access the variable, an exception will be thrown because the variable is not initialized.
For example, you can define values for the variables in the constructor.**

```php
use Consolly\Command\Command;

class MyCommand extends Command
{
    public function __construct()
    {
        $this->name = 'my-command';
        
        $this->options = [];
    }
    
    public function handle(array $nextArgs)
    {
        // $nextArgs is arguments which transferred to the command by a distributor.
        // This method will be executed if command specified.
        // Here you can define your logic.
        // Result of that function will be returned by Consolly class.
    }
}
```

Command class have only 2 variables which must be initialized:
- name - Contains command name.
- options - Array of instances of the OptionInterface.

Of course, you can override Command class as you want.

### Creating commands via CommandInterface
If you want a pure command class with no predefined logic, you can implement CommandInterface interface.
Actually, all commands must implement CommandInterface interface.

```php
use Consolly\Command\CommandInterface;

class MyCommand implements CommandInterface
{

    public function getName(): string
    {
        return 'my-command';
    }
    
    public function getOptions(): array
    {
        return []; // Using an options with a commands will be shown later.
    }
    
    public function handle(array $nextArgs)
    {
        // $nextArgs is arguments which transferred to the command by a distributor.
        // This method will be executed if command specified.
        // Here you can define your logic.
        // Result of that function will be returned by Consolly class.
    }
}
```

CommandInterface defines methods:
- getName() - Must return the command name.
- getOptions() - Must return an array of options.
- handle() - Method which will be executed if the command specified.

## Options
Option is string like "-o" or "--option" which are in front of the command. Option can require value and be required, can be equal separated and abbreviated.
All options must implement OptionInterface interface.

### Creating option via Option class
Option class is simple helpful implementation of the OptionInterface where all variables and accessors are predefined and all you need to do - set default value, for example, in the constructor.

**WARNING: You must define values for every variable of this class because it has no default value.
Otherwise, when trying to access the variable, an exception will be thrown because the variable is not initialized.
For example, you can define values for the variables in the constructor.**

```php
use Consolly\Option\Option;

class MyOption extends Option
{
    public function __construct()
    {
        $this->name = 'my-option';
        $this->abbreviation = 'o';
        $this->requiresValue = false;
        $this->required = false;
        $this->value = false;
        $this->indicated = false;
    }
}
```
Option class have predefined variables:
- name - Full name of the option.
- abbreviation - Abbreviated name of the option, or null if the option have no abbreviation.
- requiresValue - Indicates whether the option takes a value.
- required - Indicates whether the option must be specified.
- value - Value of the option.
- indicated - Indicates whether the option was specified.

Of course, you can override Option class as you want.

### Creating option via OptionInterface
If you want a pure option class with no predefined logic, you can implement OptionInterface interface.
Actually, all options must implement OptionInterface interface.

```php
use Consolly\Option\OptionInterface;

class MyOption implements OptionInterface
{
    public function getName(): string
    {
        return 'my-option';
    }
    
    public function getAbbreviation(): ?string
    {
        return 'o'; // or null
    }
    
    public function isRequiresValue(): bool
    {
        return false;
    }
    
    public function setValue($value): void
    {
        // here you can handle the value.
    }
    
    public function isRequired(): bool
    {
        return false;
    }
    
    public function setIndicated(bool $value): void
    {
        // here you can handle indication.
    }
}
```

OptionInterface defines methods:
- getName() - Returns full name of the option. 
- getAbbreviation() - Returns abbreviated name of the option, or null if the option have no abbreviation.
- isRequiresValue() - Indicates whether the option takes a value.
- isRequired() - Indicates whether the option must be specified.
- setValue() - Sets value of the option.
- setIndicated() - Indicates whether the option was specified.

## Consolly
Consolly class is the entry point. It requires a source and a distributor.
You should create consolly instance, add you commands and execute the handle() method.
After that consolly will get arguments by the source and transfer them to the distributor.
Then, distributor will return a command or null, if no command found.
If no command found, consolly will use the default command. If no default command specified, it will throw an exception.

Default command - the command, which will be used if the command was not found by the distributor.

After that, consolly will execute handleArguments() method of the distributor.
Distributor will handle an arguments, after that consolly will pass a result of the getNextArguments() method of the distributor to the handle() method of the command.
In the end, consolly will return a result of the handle() method of the command.

```php
use Consolly\Consolly;
use Consolly\Distributor\Distributor;
use Consolly\Formatter\Formatter;
use Consolly\Source\ConsoleArgumentsSource;

$consolly = new Consolly(
    new ConsoleArgumentsSource([]), // default source
    new Distributor(new Formatter()), // default distributor with default formatter
    new MyDefaultCommand()
);

// Or you can use preset.
$consolly = Consolly::default([], new MyDefaultClass());

// you also can use accessors to set default command.

$consolly->addCommand(new MyCommand());

$result = $consolly->handle();
```

By the way, you can create consolly class in the handle() method of the command, using the $nextArgs as console arguments.
This way, you can create nested commands.

```php
use Consolly\Command\Command;
use Consolly\Consolly;

class MyCommand extends Command
{
    public function __construct()
    {
        $this->name = 'my-command';
        
        $this->options = [];
    }
    
    public function handle(array $nextArgs)
    {
        $consolly = Consolly::default($nextArgs);
        
        $consolly->addCommand(new MyNestedCommand());
        $consolly->addCommand(new AlsoMyNestedCommand());
        
        return $consolly->handle();
    }
}
```

Executing the command below will execute the MyCommand and after that the command MyNestedCommand will be executed.

```bash
myscript --my-option my-command --my-nested-option my-nested-command
```

This way you can create unlimited number of nested commands.