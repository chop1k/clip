# Cli Package (CliP)
Package for working with console

## Requirements
- PHP 7.4+

## How to use
```php
$clip = new \CliP\CliP();

$clip->addCommand(new MyCommand1());
$clip->addCommand(new MyCommand2());
$clip->addCommand(new MyCommand3());

// add your commands...

$clip->setDefaultCommand(new MyDefaultCommand());

$clip->handle($argv);

```
