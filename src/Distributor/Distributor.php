<?php

namespace Consolly\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Exception\OptionRequiredException;
use Consolly\Exception\OptionRequiresValueException;
use Consolly\Helper\Argument;
use Consolly\Option\OptionInterface;
use InvalidArgumentException;
use LogicException;

/**
 * Class Distributor represents default implementation of the {@link DistributorInterface}.
 *
 * @package Consolly\Distributor
 */
class Distributor implements DistributorInterface
{
    /**
     * Contains an array of commands.
     *
     * @var array $commands
     */
    protected array $commands;

    /**
     * Contains an array of the arguments.
     *
     * @var array $arguments
     */
    protected array $arguments;

    /**
     * Contains a position of the command in the arguments.
     *
     * @var int $commandPosition
     */
    protected int $commandPosition;

    /**
     * Distributor constructor.
     */
    public function __construct()
    {
        $this->commandPosition = 0;
    }

    /**
     * @inheritdoc
     */
    public function setCommands(array $commands): void
    {
        $this->commands = $this->handleCommands($commands);
    }

    /**
     * Iterates through an array of commands and returns an array whose keys are the command name.
     *
     * @param array $commands
     *
     * @return array
     */
    protected function handleCommands(array $commands): array
    {
        $handledCommands = [];

        /**
         * @var CommandInterface $command
         */
        foreach ($commands as $command) {
            $handledCommands[$command->getName()] = $command;
        }

        return $handledCommands;
    }

    /**
     * @inheritdoc
     */
    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    /**
     * @inheritdoc
     */
    public function getCommand(): ?CommandInterface
    {
        foreach ($this->arguments as $i => $argument) {
            if (!is_int($i)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'The arguments array given to the "%s" class must have an integers as keys, but "%s" given. ',
                        __CLASS__,
                        $i
                    )
                );
            }

            if (!Argument::isCommand($argument)) {
                continue;
            }

            $this->commandPosition = $i;

            if (!isset($this->commands[$argument])) {
                continue;
            }

            $command = $this->commands[$argument];

            if (is_null($command)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Commands array contains "%s" key, but the value is null, implementation of "%s" needed.',
                        $argument,
                        CommandInterface::class
                    )
                );
            }

            return $command;
        }

        return null;
    }

    /**
     * @inheritdoc
     *
     * @param CommandInterface $command
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function handleOptions(CommandInterface $command): void
    {
        $commandOptions = [];
        $requiredOptionsNumber = 0;

        /**
         * @var OptionInterface $option
         */
        foreach ($command->getOptions() as $option) {
            $name = sprintf('--%s', trim($option->getName(), "\"'- "));

            $commandOptions[$name] = $option;

            $abbreviation = sprintf('-%s', trim($option->getAbbreviation(), "\"'- "));

            if ($abbreviation != false) {
                $commandOptions[$abbreviation] = $option;
            }

            if ($option->isRequired()) {
                $requiredOptionsNumber++;
            }
        }

        $options = [];
        $values = [];

        foreach ($this->arguments as $argument) {
            if (Argument::isOption($argument)) {
                $this->handleOption($options, $values, $argument);
            } elseif (Argument::isValue($argument)) {
                $this->handleValue($options, $values, $argument);
            }
        }

        $pointer = 0;
        $requiredOptionsProcessed = 0;

        foreach ($options as $rawOption) {
            if (!isset($commandOptions[$rawOption])) {
                continue;
            }

            $option = $commandOptions[$rawOption];

            $option->setIndicated(true);

            if ($option->isRequiresValue()) {
                if (!isset($values[$pointer])) {
                    throw new OptionRequiresValueException(
                        sprintf(
                            'Cannot find a value for the option "%s". ' .
                            'Expected value index is "%s" while array values count is "%s". ',
                            $option->getName(),
                            $pointer,
                            count($values)
                        )
                    );
                }

                $option->setValue(
                    trim($values[$pointer], '\'" ')
                );

                $pointer++;
            }

            if ($option->isRequired()) {
                $requiredOptionsProcessed++;
            }
        }

        if ($requiredOptionsNumber !== $requiredOptionsProcessed) {
            throw new OptionRequiredException(
                sprintf(
                    'The number of required options (%s) and ' .
                    'the number of processed required options (%s) is not equal.',
                    $requiredOptionsNumber,
                    $requiredOptionsProcessed
                )
            );
        }
    }

    /**
     * Handles the argument as option.
     *
     * @param array $options
     *
     * @param array $values
     *
     * @param string $argument
     */
    protected function handleOption(array &$options, array &$values, string $argument): void
    {
        if (Argument::isAbbreviations($argument)) {
            $this->handleAbbreviatedOptions($options, $values, $argument);
        } else {
            if (Argument::isEqualSeparatedOption($argument)) {
                $this->handleEqualSeparated($options, $values, $argument);
            } else {
                $options[] = $argument;
            }
        }
    }

    /**
     * Handles the argument as an array of abbreviated options.
     *
     * @param array $options
     *
     * @param array $values
     *
     * @param string $argument
     */
    protected function handleAbbreviatedOptions(array &$options, array &$values, string $argument): void
    {
        if (Argument::isEqualSeparatedOption($argument)) {
            $this->handleEqualSeparated($options, $values, $argument);
        } else {
            foreach (str_split(trim($argument, '-')) as $item) {
                $options[] = sprintf('-%s', $item);
            }
        }
    }

    /**
     * Handles the argument as a value.
     *
     * @param array $options
     *
     * @param array $values
     *
     * @param string $argument
     */
    protected function handleValue(array &$options, array &$values, string $argument): void
    {
        $values[] = $argument;
    }

    /**
     * Handles the argument as an equal separated option.
     *
     * @param array $options
     *
     * @param array $values
     *
     * @param string $argument
     */
    protected function handleEqualSeparated(array &$options, array &$values, string $argument): void
    {
        [$option, $value] = Argument::explodeEqualSeparatedOption($argument);

        if (Argument::isAbbreviations($option)) {
            foreach (str_split(trim($option, '-')) as $item) {
                $options[] = sprintf('-%s', $item);
                $values[] = $value;
            }
        } else {
            $options[] = $option;
            $values[] = $value;
        }
    }

    /**
     * @inheritdoc
     */
    public function getNextArguments(): array
    {
        return array_slice($this->arguments, $this->commandPosition + 1);
    }
}
