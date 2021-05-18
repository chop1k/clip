<?php

namespace Consolly\Distributor;

final class DistributorEvents
{
    public const COMMANDS = 'consolly.distributor.commands';

    public const COMMAND_NOT_FOUND = 'consolly.distributor.command_not_found';

    public const COMMAND_FOUND = 'consolly.distributor.command_found';

    public const NEXT_ARGUMENTS = 'consolly.distributor.next_arguments';
}
