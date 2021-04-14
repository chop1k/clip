<?php

namespace Consolly\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Exception\OptionRequiredException;
use Consolly\Exception\OptionRequiresValueException;
use Consolly\Formatter\FormatterInterface;
use Consolly\Helper\Argument;
use Consolly\Option\OptionInterface;
use InvalidArgumentException;

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
     * Contains a formatter instance.
     *
     * @var FormatterInterface $formatter
     */
    protected FormatterInterface $formatter;

    /**
     * Distributor constructor.
     *
     * @param FormatterInterface $formatter
     */
    public function __construct(FormatterInterface $formatter)
    {
        $this->commandPosition = 0;
        $this->formatter = $formatter;
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

            if (!isset($this->commands[$argument])) {
                continue;
            }

            $this->commandPosition = $i;

            return $this->commands[$argument];
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
    public function handleArguments(CommandInterface $command): void
    {
        [$commandOptions, $requiredOptionsNumber] = $this->sortOptions($command);

        [$options, $values] = $this->sortArguments();

        $this->handle($options, $values, $commandOptions, $requiredOptionsNumber);
    }

    /**
     * Sorts command options and returns indexed array of options.
     *
     * @param CommandInterface $command
     *
     * @return array
     */
    protected function sortOptions(CommandInterface $command): array
    {
        $commandOptions = [];
        $requiredOptionsNumber = 0;

        /**
         * @var OptionInterface $option
         */
        foreach ($command->getOptions() as $option) {
            $name = $this->formatter->format($option->getName(), Argument::TYPE_OPTION);

            $commandOptions[$name] = $option;

            $abbreviation = $option->getAbbreviation();

            if ($abbreviation !== null) {
                $abbreviation = $this->formatter->format($abbreviation, Argument::TYPE_ABBREVIATION);

                $commandOptions[$abbreviation] = $option;
            }

            if ($option->isRequired()) {
                $requiredOptionsNumber++;
            }
        }

        return [
            $commandOptions,
            $requiredOptionsNumber
        ];
    }

    /**
     * Sorts arguments and returns array with arrays of options and values.
     *
     * @return array[]
     */
    protected function sortArguments(): array
    {
        $options = [];
        $values = [];

        $handle = function ($argument, string $type) use (&$options, &$values) {
            if ($type === Argument::TYPE_OPTION || $type === Argument::TYPE_ABBREVIATION) {
                $options[] = $argument;
            } elseif ($type === Argument::TYPE_VALUE || $type === Argument::TYPE_PURE_VALUE) {
                $values[] = $argument;
            }
        };

        for ($i = 0; $i < count($this->arguments); $i++) {
            if ($i >= $this->commandPosition) {
                break;
            }

            $argument = $this->arguments[$i];

            $type = $this->formatter->parse($argument);

            if (
                $type === Argument::TYPE_EQUAL_SEPARATED_OPTION ||
                $type === Argument::TYPE_EQUAL_SEPARATED_ABBREVIATIONS
            ) {
                $this->handleEqualSeparated($argument, $handle);
            } else {
                $handle($argument, $type);
            }
        }

        return [
            $options, $values
        ];
    }

    /**
     * Explodes equal-separated argument and executes callback with basic types.
     *
     * @param $argument
     *
     * @param callable $handler
     * Handler callback for handling basic types like option, abbreviated option and values.
     * Takes value and type.
     */
    protected function handleEqualSeparated($argument, callable $handler): void
    {
        [$option, $value] = Argument::explodeEqualSeparated($argument);

        $type = $this->formatter->parse($option);

        if ($type === Argument::TYPE_ABBREVIATIONS) {
            $options = str_split(Argument::clear($option));
        } else {
            $options = [$option];
        }

        foreach ($options as $char) {
            $handler(
                $this->formatter->format($char, Argument::TYPE_ABBREVIATION),
                Argument::TYPE_ABBREVIATION
            );

            $handler(
                $this->formatter->format($value, Argument::TYPE_PURE_VALUE),
                Argument::TYPE_PURE_VALUE
            );
        }
    }

    /**
     * Distributes given options and values.
     *
     * @param array $options
     *
     * @param array $values
     *
     * @param array $commandOptions
     *
     * @param int $requiredOptionsNumber
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    protected function handle(array $options, array $values, array $commandOptions, int $requiredOptionsNumber): void
    {
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
                    throw OptionRequiresValueException::cannotFindValue($option->getName(), $pointer, count($values));
                }

                $option->setValue($this->formatter->format($values[$pointer], Argument::TYPE_PURE_VALUE));

                $pointer++;
            }

            if ($option->isRequired()) {
                $requiredOptionsProcessed++;
            }
        }

        if ($requiredOptionsNumber !== $requiredOptionsProcessed) {
            throw OptionRequiredException::optionRequired($requiredOptionsNumber, $requiredOptionsProcessed);
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
