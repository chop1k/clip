# Source
Source is a class that provides arguments to the consolly class.
Source must implement SourceInterface interface.

```php
use Consolly\Source\SourceInterface;

class MySource implements SourceInterface
{
    public function getArguments(): array
    {
        return [
            // returns your data.
        ];
    }
}
```

You can provide data from your servers, files or any other source.

## ConsoleArgumentsSource
ConsoleArgumentsSource - default implementation of the SourceInterface.

ConsoleArgumentsSource takes data from the constructor and returns the data in the getArguments() method.
As planned, it should return console arguments ($argv), but it can take any php array.

```php
use Consolly\Source\ConsoleArgumentsSource;

$source = new ConsoleArgumentsSource($argv);

$arguments = $source->getArguments(); // returns the $argv
```

By default, it ignores first argument of the $arguments.
To turn off this, you should set $ignoreFirst parameter to false.
You can do this via the constructor or an accessor.