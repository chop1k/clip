<?php

namespace Consolly\Tests\Command;

use Consolly\Command\Command;
use Consolly\Option\Option;

/**
 * Class TestCommand represents class for testing distributors functionality.
 *
 * @package Consolly\Tests\Command
 */
class TestCommand extends Command
{
    /**
     * Contains first option.
     *
     * @var Option $first
     */
    protected Option $first;

    /**
     * Contains second option.
     *
     * @var Option $second
     */
    protected Option $second;

    /**
     * Contains third option.
     *
     * @var Option $third
     */
    protected Option $third;

    /**
     * Contains next arguments.
     *
     * @var array $nextArguments
     */
    protected array $nextArguments;

    /**
     * Determines if the command is executed.
     *
     * @var bool $executed
     */
    protected bool $executed;

    /**
     * TestCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'test';

        $this->aliases = ['testCommand', 'testAlias'];

        $this->first = new Option('first', 'f', false, false, false, false);
        $this->second = new Option('second', 's', false, false, false, false);
        $this->third = new Option('third', 't', false, false, false, false);

        $this->nextArguments = [];
        $this->executed = false;

        $this->options = [
            $this->first,
            $this->second,
            $this->third
        ];
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the first option.
     *
     * @return Option
     */
    public function getFirst(): Option
    {
        return $this->first;
    }

    /**
     * Returns the second option.
     *
     * @return Option
     */
    public function getSecond(): Option
    {
        return $this->second;
    }

    /**
     * Returns the third option.
     *
     * @return Option
     */
    public function getThird(): Option
    {
        return $this->third;
    }

    /**
     * Return the next arguments array.
     *
     * @return array
     */
    public function getNextArguments(): array
    {
        return $this->nextArguments;
    }

    /**
     * @inheritdoc
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Returns true if the command handle method is executed.
     *
     * @return bool
     */
    public function isExecuted(): bool
    {
        return $this->executed;
    }

    /**
     * Sets whether the command handle method is executed.
     *
     * @param bool $executed
     */
    public function setExecuted(bool $executed): void
    {
        $this->executed = $executed;
    }

    /**
     * @inheritdoc
     */
    public function handle(array $nextArgs): void
    {
        $this->executed = true;
        $this->nextArguments = $nextArgs;
    }
}
