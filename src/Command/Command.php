<?php

namespace Consolly\Command;

/**
 * Class Command represents helpful implementation of the {@link CommandInterface}.
 *
 * WARNING: You must define values for every variable of this class because it have no default value.
 * Otherwise when trying to access the variable, an exception will be thrown because the variable is not initialized.
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
     * Contains an array of options.
     *
     * @var array $options
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
     * @inheritdoc
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @inheritdoc
     */
    public function handle(array $nextArgs)
    {
    }
}
