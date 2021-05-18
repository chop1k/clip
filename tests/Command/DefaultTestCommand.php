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
    protected bool $executed;

    /**
     * DefaultTestCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'default';

        $this->aliases = [];

        $this->options = [];

        $this->executed = false;
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
     * @return bool
     */
    public function isExecuted(): bool
    {
        return $this->executed;
    }

    /**
     * @param bool $executed
     */
    public function setExecuted(bool $executed): void
    {
        $this->executed = $executed;
    }

    /**
     * @inheritDoc
     */
    public function handle(array $nextArgs): bool
    {
        $this->executed = true;

        return true;
    }
}
