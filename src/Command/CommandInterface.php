<?php

namespace Consolly\Command;

use Consolly\Option\OptionInterface;

/**
 * Interface CommandInterface defines functionality required by each command.
 *
 * @package Consolly\Command
 */
interface CommandInterface
{
    /**
     * Returns command name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Returns array of command options, each option must be {@link OptionInterface} instance.
     *
     * @return array
     */
    public function getOptions(): array;

    /**
     * User-defined function, which will be executed when command invoked.
     *
     * @param array $nextArgs
     * Command line arguments which come after command.
     */
    public function handle(array $nextArgs);
}
