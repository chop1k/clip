# Changelog
Here is a list of versions with changes from first to last.

## v2.2.0
- Migrated to PHP 8.0 and phpunit 9.5.4.
- Added [lifecycle events](events.md).
- Tests refactored.
  - Unit tests are now located in the /Unit namespace.
  - Tests are now more readable.
  - DataProviders moved to separate classes.
- Added ConsollyBuilder with tests.

## v2.1.1
- Fixed bug where all arguments were ignored when using the default command.

## v2.1.0
- Added FormatterInterface and Formatter with test:
- DistributorInterface and Distributor:
  - handleOptions() renamed to handleArguments().
- Distributor:
  - Now requires implementation of FormatterInterface.
  - Minor changes in test.
  - Added new type of value "pure-type". Now you can use value without quotes.
- ConsoleArgumentsSource:
  - Removed $ignoreFirst flag. Now the developer is obliged to take care of this himself.
- Consolly
  - Added static method default().
- Argument:
  - Added type constants which used by Formatter and Distributor.
  - Added additional functions.
  - Improved the accuracy of defining the argument type.
  - Added test.

## v2.0.1
Fixes:
- Fixed useless LogicException thrown in the distributor's getNextArguments method after the distributor received an empty array of commands.
- Fixed uninitialized variable $commands in Consolly class.

Other:
- Added regression tests for the cases described above.

## v2.0.0
- Added more abstraction layers.
  - Added a DistributorInterface with implementation.
  - Added a SourceInterface with implementation.
- Added more expansion options.
  - Now, command is not abstract class. Now you should use CommandInterface or Command class.
  - Now, option is not abstract class. Now you should use OptionInterface or Option class.
- Added tests.
- Added documentation.

## v1.0.0
First release.

- Added main class with all logic.
- Added command abstract class, and option abstract class.