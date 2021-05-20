<?php

namespace Consolly\Option;

/**
 * Class Option represents helpful implementation of the {@link OptionInterface}.
 *
 * WARNING: You must define values for every variable of this class because it has no default value.
 * Otherwise, when trying to access the variable, an exception will be thrown because the variable is not initialized.
 * For example, you can define values for the variables in the constructor.
 *
 * @package Consolly\Option
 */
class Option implements OptionInterface
{
    /**
     * Contains a name of the option.
     *
     * @var string $name
     */
    protected string $name;

    /**
     * Contains an abbreviation of the option.
     *
     * @var string|null $abbreviation
     */
    protected ?string $abbreviation;

    /**
     * Contains bool which indicates whether option requires a value.
     *
     * @var bool $requiresValue
     */
    protected bool $requiresValue;

    /**
     * Contains a value of the option.
     *
     * @var mixed $value
     */
    protected mixed $value;

    /**
     * Contains bool which indicates whether option required.
     *
     * @var bool $required
     */
    protected bool $required;

    /**
     * Contains bool which indicates whether option specified.
     *
     * @var bool $indicated
     */
    protected bool $indicated;

    /**
     * Option constructor.
     *
     * @param string $name
     *
     * @param string|null $abbreviation
     *
     * @param bool $required
     *
     * @param bool $requiresValue
     *
     * @param mixed|null $value
     *
     * @param bool $indicated
     */
    public function __construct(
        string $name,
        ?string $abbreviation,
        bool $required,
        bool $requiresValue,
        mixed $value = null,
        bool $indicated = false
    ) {
        $this->name = $name;
        $this->abbreviation = $abbreviation;
        $this->required = $required;
        $this->requiresValue = $requiresValue;
        $this->value = $value;
        $this->indicated = $indicated;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets a name of the option.
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @inheritdoc
     */
    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    /**
     * Sets an abbreviation of the option.
     *
     * @param string|null $abbreviation
     */
    public function setAbbreviation(?string $abbreviation): void
    {
        $this->abbreviation = $abbreviation;
    }

    /**
     * @inheritdoc
     */
    public function isRequiresValue(): bool
    {
        return $this->requiresValue;
    }

    /**
     * Sets a requiresValue of the option.
     *
     * @param bool $requiresValue
     */
    public function setRequiresValue(bool $requiresValue): void
    {
        $this->requiresValue = $requiresValue;
    }

    /**
     * Returns a value of the option.
     *
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @inheritdoc
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    /**
     * @inheritdoc
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * Sets whether the option required or not.
     *
     * @param bool $required
     */
    public function setRequired(bool $required): void
    {
        $this->required = $required;
    }

    /**
     * Returns true if option was indicated.
     *
     * @return bool
     */
    public function isIndicated(): bool
    {
        return $this->indicated;
    }

    /**
     * @inheritdoc
     */
    public function setIndicated(bool $value): void
    {
        $this->indicated = $value;
    }
}
