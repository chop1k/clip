<?php

namespace Consolly\Helper;

/**
 * Class Argument represents helper class which defines shortcuts for distributing an argument.
 *
 * @package Consolly\Helper
 */
class Argument
{
    /**
     * Shortcut for exploding a given argument if the argument is equal separated option.
     *
     * @param string $argument
     *
     * @return array
     * First item of the array is an option(s), second item is a value.
     */
    public static function explodeEqualSeparatedOption(string $argument): array
    {
        return explode('=', $argument, 2);
    }

    /**
     * Returns true if argument is option.
     *
     * @param string $argument
     *
     * @return bool
     */
    public static function isOption(string $argument): bool
    {
        return strpos($argument, "-") === 0 || strpos($argument, "--") === 0;
    }

    /**
     * Returns true if option is an equal separated option.
     *
     * @param string $argument
     *
     * @return bool
     */
    public static function isEqualSeparatedOption(string $argument): bool
    {
        return strpos($argument, '=') !== false;
    }

    /**
     * Returns true if the argument is an abbreviated option.
     *
     * @param string $argument
     *
     * @return bool
     */
    public static function isAbbreviation(string $argument): bool
    {
        return strpos($argument, "-") === 0 && strpos($argument, "--") !== 0;
    }

    /**
     * Returns true if the argument is an array of abbreviated options.
     *
     * The function does not check for an equal separated option or a spaces.
     *
     * @param string $argument
     *
     * @return bool
     */
    public static function isAbbreviations(string $argument): bool
    {
        return self::isAbbreviation($argument) && strlen($argument) > 2;
    }

    /**
     * Returns true if the argument is a value.
     *
     * @param string $argument
     *
     * @return bool
     */
    public static function isValue(string $argument): bool
    {
        $len = strlen($argument) - 1;

        if ($len <= 0) {
            return false;
        }

        return ($argument[0] === '"' && $argument[$len] === '"')
            || ($argument[0] === "'" && $argument[$len] === "'");
    }

    /**
     * Returns true if the argument is a command.
     *
     * @param string $argument
     *
     * @return bool
     */
    public static function isCommand(string $argument): bool
    {
        return !self::isValue($argument) && !self::isOption($argument);
    }
}
