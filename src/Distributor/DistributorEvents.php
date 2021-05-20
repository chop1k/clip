<?php

namespace Consolly\Distributor;

/**
 * Class DistributorEvents contains constants for all distributor events.
 *
 * @package Consolly\Distributor
 */
final class DistributorEvents
{
    /**
     * Dispatches before passing commands to distributor.
     */
    public const COMMANDS = 'consolly.distributor.commands';

    /**
     * Dispatches if command not found and default command not specified.
     */
    public const COMMAND_NOT_FOUND = 'consolly.distributor.command_not_found';

    /**
     * Dispatches when command found.
     */
    public const COMMAND_FOUND = 'consolly.distributor.command_found';

    /**
     * Dispatches after getting next arguments.
     */
    public const NEXT_ARGUMENTS = 'consolly.distributor.next_arguments';
}
