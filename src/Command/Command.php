<?php

namespace CliP\Command;

/**
 * Class Command represents command abstract class
 *
 * @package CliP\Command
 */
abstract class Command
{
    /**
     * Returns command name.
     *
     * @return string
     */
    public abstract function getName(): string;

    /**
     * Returns array of command options, each option must be CliP\Option\Option instance.
     *
     * @return array
     */
    public abstract function getOptions(): array;

    /**
     * User-defined function, which will be executed when command invoked.
     *
     * @param array $nextArgs
     * Command line arguments which come after command. Each argument is instance of CliP\Console\Argument class
     */
    public abstract function handle(array $nextArgs): void;
}