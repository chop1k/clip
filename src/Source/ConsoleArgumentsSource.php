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
     * @inheritdoc
     */
    public function getArguments(): array
    {
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
        $this->arguments = ($ignoreFirst) ? array_shift($arguments) : $arguments;
    }
}
