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
     * Option type. It looks like "--option".
     */
    public const TYPE_OPTION = 'option';

    /**
     * Abbreviated option type. It looks like "-a".
     */
    public const TYPE_ABBREVIATION = 'abbreviation';

    /**
     * List of abbreviated options. It looks like "-abs".
     */
    public const TYPE_ABBREVIATIONS = 'abbreviations';

    /**
     * Equal-separated option type. It looks like "--option=value".
     */
    public const TYPE_EQUAL_SEPARATED_OPTION = 'equal-separated-option';

    /**
     * Equal-separated abbreviation type. It looks like "-a=value".
     */
    public const TYPE_EQUAL_SEPARATED_ABBREVIATION = 'equal-separated-abbreviation';

    /**
     * Equal-separated abbreviations type. It looks like "-abs=value".
     */
    public const TYPE_EQUAL_SEPARATED_ABBREVIATIONS = 'equal-separated-abbreviations';

    /**
     * Value type. It looks like "value".
     */
    public const TYPE_VALUE = 'value';

    /**
     * Pure value type. It looks like value type but without quotes.
     */
    public const TYPE_PURE_VALUE = 'pure-value';

    /**
     * Utility type. It looks like "/path/to/script". Not used.
     */
    public const TYPE_UTILITY = 'utility';

    /**
     * Command type. It looks like pure value type.
     */
    public const TYPE_COMMAND = 'command';

    /**
     * Trims special symbols.
     *
     * @param string $value
     *
     * @return string
     */
    public static function clear(string $value): string
    {
        return trim($value, '\'" -');
    }

    /**
     * Shortcut for exploding a given argument if the argument is equal separated option.
     *
     * @param string $argument
     *
     * @return array
     * First item of the array is an option(s), second item is a value.
     */
    public static function explodeEqualSeparated(string $argument): array
    {
        return explode('=', $argument, 2);
    }

    /**
     * Wrapper to avoid recursion.
     *
     * @param string $argument
     *
     * @return bool
     */
    protected static function startsWithOptionPrefix(string $argument): bool
    {
        return str_starts_with($argument, "--");
    }

    /**
     * Wrapper to avoid recursion.
     *
     * @param string $argument
     *
     * @return bool
     */
    protected static function startsWithAbbreviationPrefix(string $argument): bool
    {
        return str_starts_with($argument, "-");
    }

    /**
     * Wrapper to avoid recursion.
     *
     * @param string $argument
     *
     * @return bool
     */
    protected static function containsEqualSeparation(string $argument): bool
    {
        return str_contains($argument, '=');
    }

    /**
     * Wrapper to avoid recursion.
     *
     * @param string $argument
     *
     * @return bool
     */
    protected static function surroundedByQuotes(string $argument): bool
    {
        $len = strlen($argument) - 1;

        return ($argument[0] === '"' && $argument[$len] === '"')
            || ($argument[0] === "'" && $argument[$len] === "'");
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
        return !static::isEqualSeparatedOption($argument) && static::startsWithOptionPrefix($argument);
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
        return (static::startsWithOptionPrefix($argument) || static::startsWithAbbreviationPrefix($argument))
            && static::containsEqualSeparation($argument);
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
        return self::startsWithAbbreviationPrefix($argument)
            && !static::startsWithOptionPrefix($argument)
            && !static::containsEqualSeparation($argument)
            && strlen($argument) <= 2;
    }

    /**
     * Returns true if the argument is an array of abbreviated options.
     *
     * @param string $argument
     *
     * @return bool
     */
    public static function isAbbreviations(string $argument): bool
    {
        return self::startsWithAbbreviationPrefix($argument)
            && !static::startsWithOptionPrefix($argument)
            && !static::containsEqualSeparation($argument)
            && strlen($argument) > 2;
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
        return self::surroundedByQuotes($argument);
    }

    /**
     * Returns true if the argument is a pure value.
     *
     * @param string $argument
     *
     * @return bool
     */
    public static function isPureValue(string $argument): bool
    {
        return !static::startsWithOptionPrefix($argument)
            && !static::startsWithAbbreviationPrefix($argument)
            && !static::surroundedByQuotes($argument);
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
        return self::isPureValue($argument);
    }

    /**
     * Returns true if the argument is a utility.
     *
     * @param string $argument
     *
     * @return bool
     */
    public static function isUtility(string $argument): bool
    {
        return static::isCommand($argument);
    }

    /**
     * Adds prefix to the argument and returns it.
     *
     * @param string $argument
     *
     * @return string
     */
    public static function toOption(string $argument): string
    {
        return sprintf('--%s', static::clear($argument));
    }

    /**
     * Adds prefix to the argument and returns it.
     *
     * @param string $argument
     *
     * @return string
     */
    public static function toAbbreviation(string $argument): string
    {
        return sprintf('-%s', static::clear($argument));
    }

    /**
     * Adds equal-separation between option and value.
     *
     * @param string $option
     *
     * @param string $value
     *
     * @return string
     */
    public static function toEqualSeparated(string $option, string $value): string
    {
        return sprintf('%s=%s', $option, static::clear($value));
    }

    /**
     * Adds quotes to the argument and returns it.
     *
     * @param string $argument
     *
     * @return string
     */
    public static function toValue(string $argument): string
    {
        return sprintf('"%s"', static::clear($argument));
    }

    /**
     * Clears the argument and returns it.
     *
     * @param string $argument
     *
     * @return string
     */
    public static function toPureValue(string $argument): string
    {
        return static::clear($argument);
    }
}
