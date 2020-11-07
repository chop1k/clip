<?php

namespace Consolly\Console;

/**
 * Class Argument represents console argument
 *
 * @package Consolly\Console
 */
class Argument
{
    /**
     * Contains raw argument.
     *
     * @var string $arg
     */
    protected string $arg;

    /**
     * Returns raw argument.
     *
     * @return string
     */
    public function getArg(): string
    {
        return $this->arg;
    }

    /**
     * Contains option value.
     *
     * @var string $value
     */
    protected string $value;

    /**
     * Returns option value.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Sets option value.
     *
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * Contains argument position in console arguments.
     *
     * @var int|null $position
     */
    protected ?int $position;

    /**
     * Returns argument position.
     *
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * Sets argument position.
     *
     * @param int|null $position
     */
    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    public function __construct(string $arg)
    {
        $this->arg = $arg;
        $this->value = "";
        $this->position = null;
    }

    /**
     * Returns true when argument is abbreviated option.
     *
     * @return bool
     */
    public function isAbbreviation(): bool
    {
        return strpos($this->arg, "-") === 0 && strpos($this->arg, "--") === false;
    }

    /**
     * Returns true when argument is array of abbreviated options.
     * For example:
     * -AtOg is array of abbreviated options.
     * --AtOg is one option.
     * -A is one abbreviated option.
     *
     * @return bool
     */
    public function isAbbreviations(): bool
    {
        return $this->isAbbreviation() && strlen($this->arg) > 2;
    }

    /**
     * Returns true when argument is option.
     *
     * @return bool
     */
    public function isOption(): bool
    {
        return strpos($this->arg, "-") === 0 || strpos($this->arg, "--") === 0;
    }

    /**
     * Returns true when argument is value.
     *
     * @return bool
     */
    public function isValue(): bool
    {
        $len = strlen($this->arg)-1;

        return ($this->arg[0] === '"' && $this->arg[$len] === '"')
            || ($this->arg[0] === "'" && $this->arg[$len] === "'");
    }

    /**
     * Returns true when argument is command.
     *
     * @return bool
     */
    public function isCommand(): bool
    {
        return !$this->isOption() && !$this->isValue();
    }

    /**
     * Returns trimmed option name.
     *
     * @return string
     */
    public function getName(): string
    {
        return trim($this->arg, "-");
    }

    /**
     * Returns array of  abbreviations without "-"
     *
     * @return array
     */
    public function getAbbreviations(): array
    {
        return str_split($this->getName());
    }

    /**
     * Converts array of strings to array of arguments.
     *
     * @param array $args
     * Array of console arguments.
     *
     * @return array
     * Array of arguments.
     */
    public static function getArguments(array $args): array
    {
        $arguments = [];

        for ($i = 0; $i < count($args); $i++)
        {
            $rawArg = $args[$i];

            $arg = ($rawArg instanceof Argument) ? $rawArg : new Argument($args[$i]);

            $arg->setPosition($i);

            $arguments[$arg->getArg()] = $arg;
        }

        return $arguments;
    }

    /**
     * Returns array of options, filtered by given args.
     *
     * @param array $args
     * Array of arguments
     *
     * @return array
     * Array of options.
     */
    public static function getOptions(array $args): array
    {
        $options = [];

        foreach ($args as $argName)
        {
            $arg = ($argName instanceof Argument) ? $argName :  new Argument($argName);

            if ($arg->isOption())
            {
                $options[] = $arg;
            }
        }

        return $options;
    }

    /**
     * Returns array of values, filtered by given args.
     *
     * @param array $args
     * Array of args.
     *
     * @return array
     * Array of values.
     */
    public static function getValues(array $args): array
    {
        $values = [];

        foreach ($args as $value)
        {
            $arg = ($value instanceof Argument) ? $value :  new Argument($value);

            if ($arg->isValue())
            {
                $values[] = $arg;
            }
        }

        return $values;
    }
}