<?php

namespace Consolly\Tests\DataProvider\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Helper\Argument;
use InvalidArgumentException;

class DistributorDataProvider
{
    protected array $names;

    protected string $value;

    public function __construct(CommandInterface $command, string $value)
    {
        $this->names = array_merge([$command->getName()], $command->getAliases());

        if (in_array($value, $this->names)) {
            throw new InvalidArgumentException('Value must not be same as command name or alias. ');
        }

        $this->value = $value;
    }

    public function getFullNameArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toOption('first'), $name
                ]
            ];
        }

        return $arguments;
    }

    public function getFullNameWithValueArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toOption('first'), $this->value, $name
                ]
            ];
        }

        return $arguments;
    }

    public function getAbbreviationArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toAbbreviation('f'), $name
                ]
            ];
        }

        return $arguments;
    }

    public function getAbbreviationWithValueArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toAbbreviation('f'), $this->value, $name
                ]
            ];
        }

        return $arguments;
    }

    public function getAbbreviationsArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toAbbreviation('fst'), $name
                ]
            ];
        }

        return $arguments;
    }

    public function getAbbreviationsWithValueArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toAbbreviation('fst'), $this->value, $this->value, $this->value, $name
                ]
            ];
        }

        return $arguments;
    }

    public function getEqualSeparatedFullNameArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toEqualSeparated(Argument::toOption('first'), $this->value), $name
                ]
            ];
        }

        return $arguments;
    }

    public function getEqualSeparatedAbbreviatedArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toEqualSeparated(Argument::toAbbreviation('f'), $this->value), $name
                ]
            ];
        }

        return $arguments;
    }

    public function getEqualSeparatedAbbreviations(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toEqualSeparated(Argument::toAbbreviation('fst'), $this->value), $name
                ]
            ];
        }

        return $arguments;
    }

    public function getRequiresValueArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toAbbreviation('f'), $name
                ]
            ];
        }

        return $arguments;
    }

    public function getRequiredArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    $name
                ]
            ];
        }

        return $arguments;
    }

    public function getNextArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                array_merge([$name], $this->getExpectedNextArguments())
            ];
        }

        return $arguments;
    }

    public function getExpectedNextArguments(): array
    {
        return $this->getFullNameArguments()[0];
    }
}
