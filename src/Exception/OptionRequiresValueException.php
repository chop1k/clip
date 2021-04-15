<?php

namespace Consolly\Exception;

/**
 * Class OptionRequiresValueException represents exception, which throws when option value isn't specified.
 *
 * @package Consolly\Exception
 */
class OptionRequiresValueException extends OptionException
{
    /**
     * Shortcut for returning self instance with certain data.
     *
     * @param string $optionName
     *
     * @param int $pointer
     *
     * @param int $valuesNumber
     *
     * @return static
     */
    public static function cannotFindValue(string $optionName, int $pointer, int $valuesNumber): self
    {
        return new OptionRequiresValueException(
            sprintf(
                'Cannot find a value for the option "%s". ' .
                'Expected value index is "%s" while array values count is "%s". ',
                $optionName,
                $pointer,
                $valuesNumber
            )
        );
    }
}
