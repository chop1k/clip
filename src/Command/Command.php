<?php

namespace Consolly\Command;

use Consolly\Option\OptionInterface;

/**
 * Class Command represents helpful implementation of the {@link CommandInterface}.
 *
 * WARNING: You must define values for every variable of this class because it has no default value.
 * Otherwise, when trying to access the variable, an exception will be thrown because the variable is not initialized.
 * For example, you can define values for the variables in the constructor.
 *
 * @package Consolly\Command
 */
class Command implements CommandInterface
{
    /**
     * Contains name of the command.
     *
     * @var string $name
     */
    protected string $name;

    /**
     * Contains command aliases.
     *
     * @var string[] $aliases
     */
    protected array $aliases;

    /**
     * Contains an array of options.
     *
     * @var OptionInterface[] $options
     */
    protected array $options;

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets command name.
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAliases(): array
    {
        return $this->aliases;
    }

    /**
     * @param string[] $aliases
     */
    public function setAliases(array $aliases): void
    {
        $this->aliases = $aliases;
    }

    /**
     * @inheritdoc
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Sets commands options
     *
     * @param OptionInterface[] $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    /**
     * Adds the option to the options array.
     *
     * @param OptionInterface $option
     */
    public function addOption(OptionInterface $option): void
    {
        $this->options[] = $option;
    }

    /**
     * @inheritdoc
     */
    public function handle(array $nextArgs)
    {
    }
}
