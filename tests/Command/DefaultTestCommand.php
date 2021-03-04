<?php

namespace Consolly\Tests\Command;

use Consolly\Command\Command;

/**
 * Class DefaultTestCommand represents class for testing default command functionality.
 *
 * @package Consolly\Tests\Command
 */
class DefaultTestCommand extends Command
{
    /**
     * DefaultTestCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'default';

        $this->options = [];
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @inheritDoc
     */
    public function handle(array $nextArgs): bool
    {
        return true;
    }
}
