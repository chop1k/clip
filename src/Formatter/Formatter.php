<?php

namespace Consolly\Formatter;

use Consolly\Distributor\Distributor;
use Consolly\Helper\Argument;
use InvalidArgumentException;

/**
 * Class Formatter represents implementation of {@link FormatterInterface} especially for {@link Distributor}.
 *
 * @package Consolly\Formatter
 */
class Formatter implements FormatterInterface
{
    /**
     * Formats the argument to option and returns it.
     *
     * @param string $argument
     *
     * @return string
     */
    protected function formatOption(string $argument): string
    {
        return Argument::toOption($argument);
    }

    /**
     * Formats the argument to abbreviated option(s) and returns it.
     *
     * @param string $argument
     *
     * @return string
     */
    protected function formatAbbreviation(string $argument): string
    {
        return Argument::toAbbreviation($argument);
    }

    /**
     * Formats arguments to equal-separated option and returns it.
     *
     * @param string $option
     *
     * @param string $value
     *
     * @return string
     */
    protected function formatEqualSeparated(string $option, string $value): string
    {
        return Argument::toEqualSeparated($option, $value);
    }

    /**
     * Formats the argument to value and returns it.
     *
     * @param string $argument
     *
     * @return string
     */
    protected function formatValue(string $argument): string
    {
        return Argument::toValue($argument);
    }

    /**
     * Formats the argument to pure value and returns it.
     *
     * @param string $argument
     *
     * @return string
     */
    protected function formatPureValue(string $argument): string
    {
        return Argument::toPureValue($argument);
    }

    /**
     * Formats the argument to utility and returns it.
     *
     * @param string $argument
     *
     * @return string
     */
    protected function formatUtility(string $argument): string
    {
        return Argument::clear($argument);
    }

    /**
     * Formats the argument to command and returns it.
     *
     * @param string $argument
     *
     * @return string
     */
    protected function formatCommand(string $argument): string
    {
        return Argument::clear($argument);
    }

    /**
     * Checks arguments for equal-separated type before they will be formatted.
     *
     * @param $value
     */
    protected function checkEqualSeparatedArguments($value): void
    {
        if (!is_array($value)) {
            throw new InvalidArgumentException(
                'Value for equal-separated-option must be an array with option and value. '
            );
        }

        if (!isset($value[0])) {
            throw new InvalidArgumentException('Value array must contain option name at 0 index. ');
        }

        if (!isset($value[1])) {
            throw new InvalidArgumentException('Value array must contain option value at 1 index. ');
        }
    }

    /**
     * @inheritdoc
     *
     * @param $value
     *
     * @param string $type
     *
     * @return string
     */
    public function format($value, string $type): string
    {
        if ($type === Argument::TYPE_OPTION) {
            return $this->formatOption($value);
        }

        if ($type === Argument::TYPE_ABBREVIATION || $type === Argument::TYPE_ABBREVIATIONS) {
            return $this->formatAbbreviation($value);
        }

        if ($type === Argument::TYPE_EQUAL_SEPARATED_OPTION) {
            $this->checkEqualSeparatedArguments($value);

            return $this->formatEqualSeparated($this->formatOption($value[0]), $value[1]);
        }

        if (
            $type === Argument::TYPE_EQUAL_SEPARATED_ABBREVIATIONS
            || $type === Argument::TYPE_EQUAL_SEPARATED_ABBREVIATION
        ) {
            $this->checkEqualSeparatedArguments($value);

            return $this->formatEqualSeparated($this->formatAbbreviation($value[0]), $value[1]);
        }

        if ($type === Argument::TYPE_VALUE) {
            return $this->formatValue($value);
        }

        if ($type === Argument::TYPE_PURE_VALUE) {
            return $this->formatPureValue($value);
        }

        if ($type === Argument::TYPE_UTILITY) {
            return $this->formatUtility($value);
        }

        if ($type === Argument::TYPE_COMMAND) {
            return $this->formatCommand($value);
        }

        throw new InvalidArgumentException('Unsupported type. ');
    }

    /**
     * Returns true if the argument is of an equal-separated type.
     *
     * @param string $argument
     *
     * @return bool
     */
    protected function isEqualSeparatedOption(string $argument): bool
    {
        return Argument::isEqualSeparatedOption($argument);
    }

    /**
     * Returns true if the argument is of an option type.
     *
     * @param string $argument
     *
     * @return bool
     */
    protected function isOption(string $argument): bool
    {
        return Argument::isOption($argument);
    }

    /**
     * Returns true if the argument is of an abbreviated option type.
     *
     * @param string $argument
     *
     * @return bool
     */
    protected function isAbbreviation(string $argument): bool
    {
        return Argument::isAbbreviation($argument);
    }

    /**
     * Returns true if the arguments is of an abbreviated options type.
     *
     * @param string $argument
     *
     * @return bool
     */
    protected function isAbbreviations(string $argument): bool
    {
        return Argument::isAbbreviations($argument);
    }

    /**
     * Returns true if the argument is of a value type.
     *
     * @param string $argument
     *
     * @return bool
     */
    protected function isValue(string $argument): bool
    {
        return Argument::isValue($argument);
    }

    /**
     * Returns true if the argument is of a pure value type.
     *
     * @param string $argument
     *
     * @return bool
     */
    protected function isPureValue(string $argument): bool
    {
        return Argument::isPureValue($argument);
    }

    /**
     * Returns true if the argument is of a command type.
     *
     * @param string $argument
     *
     * @return bool
     */
    protected function isCommand(string $argument): bool
    {
        return Argument::isCommand($argument);
    }

    /**
     * Returns true if the argument is of an utility type.
     *
     * @param string $argument
     *
     * @return bool
     */
    protected function isUtility(string $argument): bool
    {
        return Argument::isUtility($argument);
    }

    /**
     * @inheritdoc
     *
     * @param string $argument
     *
     * @return string
     */
    public function parse(string $argument): string
    {
        $isEqualSeparatedOption = $this->isEqualSeparatedOption($argument);

        if ($isEqualSeparatedOption) {
            [$option] = Argument::explodeEqualSeparated($argument);

            if ($this->isAbbreviations($option)) {
                return Argument::TYPE_EQUAL_SEPARATED_ABBREVIATIONS;
            }

            if ($this->isAbbreviation($option)) {
                return Argument::TYPE_EQUAL_SEPARATED_ABBREVIATION;
            }

            if ($this->isOption($option)) {
                return Argument::TYPE_EQUAL_SEPARATED_OPTION;
            } else {
                throw $this->unknownType();
            }
        }

        if ($this->isAbbreviations($argument)) {
            return Argument::TYPE_ABBREVIATIONS;
        } elseif ($this->isAbbreviation($argument)) {
            return Argument::TYPE_ABBREVIATION;
        } elseif ($this->isOption($argument)) {
            return Argument::TYPE_OPTION;
        } elseif ($this->isValue($argument)) {
            return Argument::TYPE_VALUE;
        } elseif ($this->isPureValue($argument)) {
            return Argument::TYPE_PURE_VALUE;
        } elseif ($this->isCommand($argument)) {
            return Argument::TYPE_COMMAND;
        } elseif ($this->isUtility($argument)) {
            return Argument::TYPE_UTILITY;
        } else {
            throw $this->unknownType();
        }
    }

    /**
     * @return InvalidArgumentException
     */
    protected function unknownType(): InvalidArgumentException
    {
        return new InvalidArgumentException('Unknown type. ');
    }
}
