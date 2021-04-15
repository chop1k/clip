<?php

namespace Consolly\Formatter;

use InvalidArgumentException;

/**
 * Interface FormatterInterface defines functionality required by each formatter.
 *
 * @package Consolly\Formatter
 */
interface FormatterInterface
{
    /**
     * Formats given value to given type.
     *
     * @param $value
     *
     * @param string $type
     *
     * @return string
     *
     * @throws InvalidArgumentException When given an unsupported type.
     */
    public function format($value, string $type): string;

    /**
     * Defines a type of the argument and returns it.
     *
     * @param string $argument
     *
     * @return string
     *
     * @throws InvalidArgumentException When failed to find a type.
     */
    public function parse(string $argument): string;
}
