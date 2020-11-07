<?php

namespace Consolly\Option;

/**
 * Class Option represents option abstract class
 *
 * @package Consolly\Option
 */
abstract class Option
{
    /**
     * Returns option full name.
     * It must not starts with "-" or "--", otherwise option will be ignored or an exception will be thrown.
     *
     * @return string
     */
    public abstract function getName(): string;

    /**
     * Returns abbreviation of option name.
     * It must not starts with "-", "--" and must contain only one symbol, otherwise option will be ignored or an exception will be thrown.
     *
     * @return string|null
     */
    public abstract function getAbbreviation(): ?string;

    /**
     * Must return true if option requires value, false otherwise.
     *
     * @return bool
     */
    public abstract function isRequiresValue(): bool;

    /**
     * Will be executed if option value found.
     *
     * @param string $value
     * Option value.
     */
    public abstract function setValue(string $value): void;

    /**
     * Returns true if option is required, false otherwise.
     * If option required and not defined in console arguments it will throw exception.
     *
     * @return bool
     */
    public abstract function isRequired(): bool;

    /**
     * Will be executed with true parameter if option contains in console arguments, otherwise with false parameter.
     *
     * @param bool $value
     */
    public abstract function setIndicated(bool $value): void;
}