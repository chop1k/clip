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

    /**
     * Handles commands by given args
     *
     * @param array $args
     * Console arguments
     *
     * @param bool $ignoreFirst
     * If true first item of array will be ignored
     *
     * @throws CommandNotFoundException
     * Throws when command not found and default command not defined
     *
     * @throws NameConflictException
     * Throws when option with same name found
     *
     * @throws OptionRequiredException
     * Throws when required option of command not defined
     *
     * @throws OptionRequiresValueException
     * Throws when option requires value and value not specified
     */
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

        $this->handleCommand($command, array_slice($args, 0, $i), array_slice($args, $i+1));
    }

    /**
     * Search command in given args
     *
     * @param array $args
     * Array of argument
     *
     * @return array
     * Array wherein first item is command position in args, second item is command instance.
     * If command not found it returns [0, null]
     */
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

    /**
     * Handles given options
     *
     * @param array $args
     * Array of all args
     *
     * @param array $options
     * Array of command options
     *
     * @return int
     * Number of handled required options for comparison
     *
     * @throws OptionRequiresValueException
     * Throws when option requires value and value not specified
     */
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
                    [$required, $requiredValue] = $this->processOption($args, $options, $abbreviations[$o], $i + $valuePointer + 1, $argsCount);

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

    /**
     * Gets option and handles it
     *
     * @param array $args
     * Array of args
     *
     * @param array $options
     * Array of command options
     *
     * @param string $option
     * Option name
     *
     * @param int $index
     * Next argument index
     *
     * @param int $argsCount
     * Number of arguments
     *
     * @return array|false[]
     * Returns array wherein first item is option isRequired property, second item is isRequiresValue property
     *
     * @throws OptionRequiresValueException
     * Throws when option requires value and value not specified
     */
    private function processOption(array $args, array $options, string $option, int $index, int $argsCount): array
    {
        $option = $this->getOption($options, $option);

        if (is_null($option))
        {
            return [false, false];
        }

        $this->handleOption($option, ($index < $argsCount) ? $args[$index] : null);

        return [$option->isRequired(), $option->isRequiresValue()];
    }

    /**
     * Shortcut
     *
     * @param array $options
     * Array of command options
     *
     * @param string $option
     * Option name
     *
     * @return Option|null
     * Returns option if exists otherwise returns null
     */
    private function getOption(array $options, string $option): ?Option
    {
        return isset($options[$option]) ? $options[$option] : null;
    }

    /**
     * Handles option
     *
     * @param Option $option
     * Option instance
     *
     * @param Argument|null $nextArg
     * Next argument which will be option value if option requires it
     *
     * @throws OptionRequiresValueException
     * Throws when option requires value and value not specified
     */
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

    /**
     * Handles command options, sets aliases and counts number of required options
     *
     * @param Command $command
     * Command instance
     *
     * @return array
     * Returns array wherein first item is number of required options, second item is array of handled options
     *
     * @throws NameConflictException
     * Throws when option with same name found
     */
    private function getOptions(Command $command): array
    {
        $options = [];

        $requiredOptions = 0;

        /**
         * @var Option $option
         */
        foreach ($command->getOptions() as $option)
        {
            $name = Argument::toOption($option->getName());

            if (isset($options[$name]))
            {
                throw new NameConflictException(sprintf('Option with name "%s" already defined', $name));
            }

            $options[$name] = $option;

            $abbreviation = Argument::toAbbreviation($option->getAbbreviation());

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

    /**
     * Handles command and executes command handler
     *
     * @param Command $command
     * Command instance
     *
     * @param array $args
     * Array of console arguments preceding the command
     *
     * @param array $nextArgs
     * Array of console arguments following the command
     *
     * @throws NameConflictException
     * Throws when option with same name found
     *
     * @throws OptionRequiredException
     * Throws when option requires value and value not specified
     *
     * @throws OptionRequiresValueException
     * Throws when option requires value and value not specified
     */
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