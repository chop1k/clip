<?php

namespace Consolly;

use Consolly\Argument\Argument;
use Consolly\Command\Command;
use Consolly\Exception\CommandNotFoundException;
use Consolly\Exception\NameConflictException;
use Consolly\Exception\OptionRequiredException;
use Consolly\Exception\OptionRequiresValueException;
use Consolly\Option\Option;

/**
 * Class Consolly contains main functional for working with Consolly architecture.
 *
 * @package Consolly
 */
class Consolly
{
    /**
     * Contains array of commands.
     *
     * @var array $commands
     */
    protected array $commands;

    /**
     * Adds command.
     *
     * @param Command $command
     */
    public function addCommand(Command $command)
    {
        $this->commands[$command->getName()] = $command;
    }

    /**
     * Contains command which will be executed of command not specified.
     *
     * @var Command|null
     */
    protected ?Command $defaultCommand;

    /**
     * Sets default command.
     *
     * @param Command $defaultCommand
     */
    public function setDefaultCommand(Command $defaultCommand): void
    {
        $this->defaultCommand = $defaultCommand;
    }

    public function __construct()
    {
        $this->defaultCommand = null;
    }

    public function handle(array $args, $ignoreFirst = true): void
    {
        if ($ignoreFirst)
        {
            array_shift($args);
        }

        array_walk($args, function (&$item) {
            $item = Argument::parse($item);
        });

        [$i, $command] = $this->getCommand($args);

        if (is_null($command))
        {
            if (is_null($this->defaultCommand))
            {
                throw new CommandNotFoundException('Command not found');
            }

            $command = $this->defaultCommand;
        }

        $this->handleCommand($command, array_slice($args, 0, $i), array_slice($args, $i));
    }

    private function getCommand(array $args): array
    {
        for ($i = 0; $i < count($args); $i++)
        {
            /**
             * @var Argument $arg
             */
            $arg = $args[$i];

            if ($arg->getType() === Argument::Command)
            {
                return [$i, $this->commands[$arg->getValue()]];
            }
        }

        return [0, null];
    }

    private function handleOptions(array $args, array $options): int
    {
        $handledRequiredOptions = 0;

        $argsCount = count($args);

        for ($i = 0; $i < $argsCount; $i++)
        {
            /**
             * @var Argument $arg
             */
            $arg = $args[$i];

            if ($arg->getType() > 200 || $arg->getType() < 100)
            {
                continue;
            }

            $name = $arg->getName();

            if ($arg->isAbbreviated() && strlen($name) > 1)
            {
                $abbreviations = Argument::toAbbreviations($name, true);

                $valuePointer = 0;

                for ($o = 0; $o < count($abbreviations); $o++)
                {
                    $option = $this->getOption($options, $abbreviations[$o]);

                    if (is_null($option))
                    {
                        continue;
                    }

                    $index = $i+$valuePointer+1;

                    $nextArg = ($index <= $argsCount) ? $args[$index] : null;

                    $this->handleOption($option, $nextArg);

                    if ($option->isRequiresValue())
                    {
                        $valuePointer++;
                    }

                    if ($option->isRequired())
                    {
                        $handledRequiredOptions++;
                    }

                    [$required, $requiredValue] = $this->processOption($args, $options, $abbreviations[$o], $i+$valuePointer+1, $argsCount);

                    if ($requiredValue)
                    {
                        $valuePointer++;
                    }

                    if ($required)
                    {
                        $handledRequiredOptions++;
                    }
                }
            }
            else
            {
                [$required] = $this->processOption($args, $options, $arg->getArg(), $i+1, $argsCount);

                if ($required)
                {
                    $handledRequiredOptions++;
                }
            }
        }

        return $handledRequiredOptions;
    }

    private function processOption(array $args, array $options, string $option, int $index, int $argsCount): array
    {
        $option = $this->getOption($options, $option);

        if (is_null($option))
        {
            return [false, false];
        }

        $this->handleOption($option, ($index <= $argsCount) ? $args[$index] : null);

        return [$option->isRequired(), $option->isRequiresValue()];
    }

    private function getOption(array $options, string $option): ?Option
    {
        return isset($options[$option]) ? $options[$option] : null;
    }

    private function handleOption(Option $option, ?Argument $nextArg): void
    {
        if ($option->isRequiresValue())
        {
            if (is_null($nextArg))
            {
                throw new OptionRequiresValueException("Value for option '{$option->getName()}' not found. Value must be in '' or \"\"");
            }

            if ($nextArg->getType() >= 300 || $nextArg->getType() < 200)
            {
                throw new OptionRequiresValueException("Value for option '{$option->getName()}' not found. Next value '$nextArg'");
            }

            $option->setValue($nextArg->getValue());
        }

        $option->setIndicated(true);
    }

    private function getOptions(Command $command): array
    {
        $options = [];

        $requiredOptions = 0;

        /**
         * @var Option $option
         */
        foreach ($command->getOptions() as $option)
        {
            $name = "--{$option->getName()}";

            if (isset($options[$name]))
            {
                throw new NameConflictException(sprintf('Option with name "%s" already defined', $name));
            }

            $options[$name] = $option;

            $abbreviation = "-{$option->getAbbreviation()}";

            if (isset($options[$abbreviation]))
            {
                throw new NameConflictException(sprintf('Option with name "%s" already defined', $abbreviation));
            }

            $options[$abbreviation] = $option;

            if ($option->isRequired())
            {
                $requiredOptions++;
            }
        }

        return [$requiredOptions, $options];
    }

    private function handleCommand(Command $command, array $args, array $nextArgs): void
    {
        [$requiredOptions, $options] = $this->getOptions($command);

        $handledRequiredOptions = $this->handleOptions($args, $options);

        if ($requiredOptions !== $handledRequiredOptions)
        {
            throw new OptionRequiredException("Number of required options ($requiredOptions) and number of handled required options ($handledRequiredOptions) are not match.");
        }

        $command->handle($nextArgs);
    }
}