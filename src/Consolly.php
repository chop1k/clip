<?php

namespace Consolly;

use Consolly\Command\Command;
use Consolly\Console\Argument;
use Consolly\Exception\CommandNotFoundException;
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
     * Handles given arguments and invokes command found.
     *
     * @param array $args
     * Array of strings or Consolly\Console\Argument instances.
     *
     * @throws CommandNotFoundException
     * Throws when command not found and default command not specified.
     *
     * @throws OptionRequiredException
     * Throws when required option isn't specified.
     *
     * @throws OptionRequiresValueException
     * Throws when option requires value, but it's not specified.
     */
    public function handle(array $args): void
    {
        $args = Argument::getArguments($args);

        $i = 0;

        $command = null;

        try {
            [$i, $command] = $this->getCommand($args);
        } catch (CommandNotFoundException $exception) {
            if (is_null($this->defaultCommand))
            {
                throw $exception;
            }

            $i = count($args);
            $command = $this->defaultCommand;
        }

        $this->handleCommand($command, array_slice($args, 0, $i), array_slice($args, $i));
    }

    /**
     * Find command in given array and returns command and command index.
     *
     * @param array $args
     * Array of command line arguments.
     *
     * @return array
     * Array wherein first element is command index, second element Consolly\Command\Command instance.
     *
     * @throws CommandNotFoundException
     * If command not found it throws Consolly\Exception\CommandNotFoundException which will be caught.
     */
    private function getCommand(array $args): array
    {
        $i = 0;

        /**
         * @var Argument $arg
         */
        foreach ($args as $arg)
        {
            $i++;

            if ($arg->isCommand())
            {
                if (!isset($this->commands[$arg->getName()]))
                {
                    continue;
                }

                return [
                    $i,
                    $this->commands[$arg->getName()]
                ];
            }

        }

        throw new CommandNotFoundException('Command not found');
    }

    /**
     * Handles given options.
     *
     * @param array $args
     * Array of options, received from given args.
     *
     * @param array $values
     * Array of values, received from given args.
     *
     * @param array $options
     * Options, which defined in command.
     *
     * @throws OptionRequiredException
     * Throws when required option isn't specified.
     *
     * @throws OptionRequiresValueException
     * Throws when option requires value, but it's not specified.
     */
    private function handleOptions(array $args, array $values, array $options): void
    {
        $valuePointer = 0;

        /**
         * @var Option $option
         */
        foreach ($options as $option)
        {
            $name = "--{$option->getName()}";

            /**
             * @var Argument|null $arg
             */
            $arg = null;

            if (isset($args[$name]))
            {
                $arg = $args[$name];
            }

            $abbreviation = $option->getAbbreviation();

            if (!is_null($abbreviation))
            {
                $abbreviation = "-$abbreviation";

                if (isset($args[$abbreviation]))
                {
                    $arg = $args[$abbreviation];
                }
            }

            if (is_null($arg))
            {
                if ($option->isRequired())
                {
                    throw new OptionRequiredException(sprintf('Option with name "%s" is required', $option->getName()));
                }

                $option->setIndicated(false);

                continue;
            }

            if ($option->isRequiresValue())
            {
                if ($valuePointer+1 > count($values))
                {
                    throw new OptionRequiresValueException(sprintf('Value for option "%s" not found. Value must be in \'\' or "".', $option->getName()));
                }

                /**
                 * @var Argument $value
                 */
                $value = $values[$valuePointer];

                $option->setValue(trim($value->getArg(), "'\""));

                $valuePointer++;
            }

            $option->setIndicated(true);
        }
    }

    /**
     * Handles abbreviated parameters.
     *
     * @param array $rawArgs
     * Array of options, received from args.
     *
     * @return array
     * Returns the same array, but with multiple-abbreviated option converted to normal state.
     *
     * For example: option like -aTgP will be converted to array [-a, -T, -g, -P] and merged with other options.
     */
    private function handleAbbreviations(array $rawArgs): array
    {
        $args = [];

        /**
         * @var Argument $rawArg
         */
        foreach ($rawArgs as $rawArg)
        {
            if (!$rawArg->isAbbreviations())
            {
                $args[$rawArg->getArg()] = $rawArg;

                continue;
            }

            $abbreviations = $rawArg->getAbbreviations();

            array_walk($abbreviations, function (&$item) {
                $item = "-$item";
            });

            $abbreviationsAsArgs = array_values($abbreviations);

            $position = $rawArg->getPosition();

            array_walk($abbreviationsAsArgs, function (&$item, $key, &$position) {
                $item = new Argument($item);

                if (!is_null($position))
                {
                    $item->setPosition($position);

                    $position++;
                }
            }, $position);

            $args = array_merge($args, array_combine($abbreviations, $abbreviationsAsArgs));
        }

        return $args;
    }

    /**
     * Handles command options and executes command handler.
     *
     * @param Command $command
     * Command instance.
     *
     * @param array $args
     * All arguments preceding the command.
     *
     * @param array $nextArgs
     * All arguments following the command.
     *
     * @throws OptionRequiredException
     * Throws when required option isn't specified.
     *
     * @throws OptionRequiresValueException
     * Throws when option requires value, but it's not specified.
     */
    private function handleCommand(Command $command, array $args, array $nextArgs): void
    {
        $this->handleOptions($this->handleAbbreviations(Argument::getOptions($args)), Argument::getValues($args), $command->getOptions());

        $command->handle($nextArgs);
    }
}