<?php

namespace Consolly\Exception;

/**
 * Class OptionRequiredException represents exception, which throws when required option isn't specified.
 *
 * @package Consolly\Exception
 */
class OptionRequiredException extends OptionException
{
    /**
     * Shortcut for returning self instance with certain data.
     *
     * @param int $optionsNumber
     *
     * @param int $optionsProcessed
     *
     * @return static
     */
    public static function optionRequired(int $optionsNumber, int $optionsProcessed): self
    {
        return new OptionRequiredException(
            sprintf(
                'The number of required options (%s) and ' .
                'the number of processed required options (%s) is not equal.',
                $optionsNumber,
                $optionsProcessed
            )
        );
    }
}
