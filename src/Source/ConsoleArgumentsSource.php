<?php

namespace Consolly\Source;

/**
 * Class ConsoleArgumentsSource represents simple implementation of the {@link SourceInterface}.
 *
 * @package Consolly\Source
 */
class ConsoleArgumentsSource implements SourceInterface
{
    /**
     * Contains an array of arguments.
     *
     * @var array $arguments
     */
    protected array $arguments;

    /**
     * If true, it ignores first arguments of $arguments.
     *
     * @var bool $ignoreFirst
     */
    protected bool $ignoreFirst;

    /**
     * @inheritdoc
     */
    public function getArguments(): array
    {
        if ($this->ignoreFirst) {
            array_shift($this->arguments);
        }

        return $this->arguments;
    }

    /**
     * Sets an array of arguments.
     *
     * @param array $arguments
     */
    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    /**
     * Returns true if first argument ignored.
     *
     * @return bool
     */
    public function isIgnoreFirst(): bool
    {
        return $this->ignoreFirst;
    }

    /**
     * Sets whether first argument should be ignored.
     *
     * @param bool $ignoreFirst
     */
    public function setIgnoreFirst(bool $ignoreFirst): void
    {
        $this->ignoreFirst = $ignoreFirst;
    }

    /**
     * ConsoleArgumentsSource constructor.
     *
     * @param array $arguments
     * An array of arguments.
     *
     * @param bool $ignoreFirst
     * If true, it ignores first arguments of $arguments.
     */
    public function __construct(array $arguments, bool $ignoreFirst = true)
    {
        $this->arguments = $arguments;
        $this->ignoreFirst = $ignoreFirst;
    }
}
