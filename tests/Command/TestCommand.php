<?php

namespace Consolly\Tests\Command;

use Consolly\Command\Command;
use Consolly\Option\Option;
use Consolly\Tests\Option\FirstTestOption;
use Consolly\Tests\Option\SecondTestOption;
use Consolly\Tests\Option\ThirdTestOption;

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
     * @var FirstTestOption $first
     */
    protected FirstTestOption $first;

    /**
     * Contains second option.
     *
     * @var SecondTestOption $second
     */
    protected SecondTestOption $second;

    /**
     * Contains third option.
     *
     * @var ThirdTestOption $third
     */
    protected ThirdTestOption $third;

    /**
     * Contains next arguments.
     *
     * @var array $nextArguments
     */
    protected array $nextArguments;

    /**
     * TestCommand constructor.
     */
    public function __construct()
    {
        $this->name = 'test';
        $this->first = new FirstTestOption();
        $this->second = new SecondTestOption();
        $this->third = new ThirdTestOption();

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
     * @return FirstTestOption
     */
    public function getFirst(): FirstTestOption
    {
        return $this->first;
    }

    /**
     * Returns the second option.
     *
     * @return SecondTestOption
     */
    public function getSecond(): SecondTestOption
    {
        return $this->second;
    }

    /**
     * Returns the third option.
     *
     * @return ThirdTestOption
     */
    public function getThird(): ThirdTestOption
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
     * Checks if the properties of an option match.
     *
     * @param Option $option
     *
     * @return bool
     */
    protected function checkOption(Option $option): bool
    {
        $value = true;

        if ($option->isRequired() && !$option->isIndicated()) {
            $value = false;
        }

        if (($option->isRequiresValue() && $option->isIndicated()) && $option->getValue() !== $this->name) {
            $value = false;
        }

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function handle(array $nextArgs): bool
    {
        $this->nextArguments = $nextArgs;

        return $this->checkOption($this->first)
            && $this->checkOption($this->second)
            && $this->checkOption($this->third);
    }
}
