# Cli Package (CliP)
Package for working with console

## Requirements
- PHP 7.4+

## How to use
```php
$cons = new \Consolly\Consolly();

$cons->addCommand(new MyCommand1());
$cons->addCommand(new MyCommand2());
$cons->addCommand(new MyCommand3());

// add your commands...

$cons->setDefaultCommand(new MyDefaultCommand());

$cons->handle($argv);

```
