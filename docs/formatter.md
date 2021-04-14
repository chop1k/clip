# Formatter
Formatter is used by Distributor to formatting given arguments to given types. Also, it defines a type of the argument and returns it.

Formatter implements FormatterInterface interface.

```php
use Consolly\Formatter\FormatterInterface;

class MyFormatter implements FormatterInterface
{
    public function format($value, string $type): string
    {
        // here you should format the value to given type.
    }
    
    public function parse(string $argument): string
    {
        // here you should define type and return it.
    }
}
```

## Formatter class
Formatter class is a default implementation of FormatterInterface interface which used by default by Distributor class.

Formatter and Distributor both uses Argument helper class.

```php
use Consolly\Formatter\Formatter;
use Consolly\Helper\Argument;

$formatter = new Formatter();

// will return --option.
$formatter->format('option', Argument::TYPE_OPTION);

// will return -a.
$formatter->format('a', Argument::TYPE_ABBREVIATION);

// will return -abs.
$formatter->format('abs', Argument::TYPE_ABBREVIATIONS);

// will return "value".
$formatter->format('value', Argument::TYPE_VALUE);

// will return value.
$formatter->format('value', Argument::TYPE_PURE_VALUE);
$formatter->format('"value"', Argument::TYPE_PURE_VALUE);

// will return --option=value
$formatter->format(['option', 'value'], Argument::TYPE_EQUAL_SEPARATED_OPTION);

// will return -a=value
$formatter->format(['a', 'value'], Argument::TYPE_EQUAL_SEPARATED_ABBREVIATION);

// will return -abs=value
$formatter->format(['abs', 'value'], Argument::TYPE_EQUAL_SEPARATED_ABBREVIATIONS);

// will return value of Argument::TYPE_ABBREVIATION constant.
$formatter->parse('-a');

// will return value of Argument::TYPE_ABBREVIATIONS constant.
$formatter->parse('-abs');

// will return value of Argument::TYPE_VALUE constant.
$formatter->parse('"value"');

// will return value of Argument::TYPE_VALUE constant.
$formatter->parse("'value'");

// will return value of Argument::TYPE_PURE_VALUE constant.
$formatter->parse('value');

// will return value of Argument::EQUAL_SEPARATED_OPTION constant.
$formatter->parse('--option=value');

// will return value of Argument::EQUAL_SEPARATED_ABBREVIATION constant.
$formatter->parse('-a=value');

// will return value of Argument::EQUAL_SEPARATED_ABBREVIATIONS constant.
$formatter->parse('-abs=value');
```

By default, the formatter does not distinguish the command and utility from pure value, because in order to distinguish a command or utility from a pure value, you need to know the location and type of the remaining arguments, the formatter is not able to do this because it only takes one value. 

```php
use Consolly\Formatter\Formatter;
use Consolly\Helper\Argument;

$formatter = new Formatter();

// will return utility.
$formatter->format('utility', Argument::TYPE_UTILITY);

// will return command.
$formatter->format('command', Argument::TYPE_COMMAND);

// will return value of Argument::TYPE_PURE_VALUE constant.
$formatter->parse('utility');

// will return value of Argument::TYPE_PURE_VALUE constant.
$formatter->parse('command');

```

You can override the formatter isCommand, isUtility, toCommand, toUtility methods and write custom handling logic.