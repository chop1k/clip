<?php

namespace Consolly\Option;

/**
 * Interface OptionInterface defines functionality required by each option.
 *
 * @package Consolly\Option
 */
interface OptionInterface
{
    /**
     * Returns option full name.
     *
     * It must not starts with "-" or "--", otherwise there might be problems.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Returns abbreviation of option name.
     *
     * It must not starts with "-", "--" and must contain only one symbol, otherwise there might be problems.
     *
     * @return string|null
     */
    public function getAbbreviation(): ?string;

    /**
     * Must return true if option requires value, false otherwise.
     *
     * @return bool
     */
    public function isRequiresValue(): bool;

    /**
     * Will be executed if option value found.
     *
     * @param mixed $value
     * Option value.
     */
    public function setValue(mixed $value): void;

    /**
     * Returns true if option is required, false otherwise.
     *
     * If option required and not defined in console arguments it will throw exception.
     *
     * @return bool
     */
    public function isRequired(): bool;

    /**
     * Will be executed with true parameter if option contains in console arguments, otherwise with false parameter.
     *
     * @param bool $value
     */
    public function setIndicated(bool $value): void;
}
