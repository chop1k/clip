# Consolly Package
Package for console scripts and applications.

## Requirements
- PHP 7.4

## How it works

Consolly defines a 3 structures:
- [Command](/src/Command/Command.php) - The class from which all commands inherit. The command class defines its parameters in getOptions() method.
- [Option](/src/Option/Option.php) - The class from which all command parameters are inherited. Option can take a value or be required.
- [Consolly](/src/Consolly.php) - The main class that processes the given commands and searches for them in the given string.

### How it distinguishes structures

- Option in the console call looks like ```--option-name "Optional value"```
- Abbreviated option looks like ```-o "Optional value"```
- EqualSeparated option looks like ```--option-name=value``` or ```--option-name="value""```
- Abbreviated EqualSeparated option looks like ```-o=value``` or ```-o="value"```
- Array of abbreviated options looks like ```-xzf "value for -x" "value for -z" "value for -f"```
- Value looks like ```"value"``` or ```\"value\"``` if ```"value"``` doesn't work
- Command looks like plain text

## How to use
You should define your commands using the Command class. Then you have to create an instance of Consolly and add commands to it. After that you need to execute the handle method of the instance. If command was found it will execute handle method of the command and pass the line following the command. If nothing is found it will execute the default command, if no default command is defined it will throw an exception.

### How Command looks like

```php
use Consolly\Command\Command;

class TestCommand extends Command
{

    public function getName(): string
    {
        return "test"; // here you returns name of your command
    }
    
    protected TestOption $option;
    
    public function getOptions(): array
    {
        return [
            $this->option 
            // here you need to add instances of a command parameters
        ];
    }
    
    public function __construct()
    {
        $this->option = new TestOption();
    }
    
    public function handle(array $nextArgs): void
    {
        // here you handling your command
        
        echo 'test successful';
    }
    
}
```

### How Option looks like

```php
use Consolly\Option\Option;

class TestOption extends Option
{

    public function getName(): string
    {
        return "test"; // here you specify your option name
    }
    
    public function getAbbreviation(): ?string
    {
        return 't'; // here you specify abbreviation of your option name
                    // abbreviation must not exceed 1 character
                    // if there is no need to abbreviation you can return null
    }
    
    public function isRequiresValue(): bool
    {
        return true; // returns true if option must require a value, false otherwise
    }
    
    public function setValue(string $value): void
    {
        // here you can handle value of the option
    }
    
    public function isRequired(): bool
    {
        return true; // returns true if option must be specified, false otherwise
    }
    
    public function setIndicated(bool $value): void
    {
        // this method executes when option was specified
    }
    
}
```

### How Consolly looks like

```php
// script.php

use Consolly\Consolly;

require_once dirname(__DIR__).'/vendor/autoload.php';

$consolly = new Consolly();

$consolly->addCommand(new TestCommand());

$consolly->handle($argv);
```

You can define default command via setDefaultCommand(command) method. The default command will be executed if no command was found. If no default command is specified it will throw an exception.

If you execute ```php script.php --test test``` it will print ```test successful``` as indicated in the command.
Command like ```php script.php -t test``` also will print ```test successful```.

Command like ```php script.php test``` will throw an exception because the ```--test``` option is required and wasn't specified.

Command ```php script.php -t``` will throw an exception because the default command wasn't specified.

## What can you do using Consolly?

You can create console script of varying complexity from simple to complex. 

## License
Consolly is licensed under MIT license. See [license file](LICENSE).
