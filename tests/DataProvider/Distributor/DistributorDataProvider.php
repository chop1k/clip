<?php

namespace Consolly\Tests\DataProvider\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Helper\Argument;
use Consolly\Tests\Unit\Distributor\DistributorTest;
use InvalidArgumentException;

/**
 * Class DistributorDataProvider represents data provider for {@link DistributorTest} test.
 *
 * @package Consolly\Tests\DataProvider\Distributor
 */
class DistributorDataProvider
{
    /**
     * Array of command name with aliases.
     *
     * @var string[] $names
     */
    protected array $names;

    /**
     * The test value.
     *
     * @var string $value
     */
    protected string $value;

    /**
     * DistributorDataProvider constructor.
     *
     * @param CommandInterface $command
     *
     * @param string $value
     */
    public function __construct(CommandInterface $command, string $value)
    {
        $this->names = array_merge([$command->getName()], $command->getAliases());

        if (in_array($value, $this->names)) {
            throw new InvalidArgumentException('Value must not be same as command name or alias. ');
        }

        $this->value = $value;
    }

    /**
     * Returns data for {@link DistributorTest::testFullName()} test.
     *
     * @return string[][][]
     */
    public function getFullNameArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toOption('first'), $name
                ]
            ];
        }

        return $arguments;
    }

    /**
     * Returns data for {@link DistributorTest::testFullNameWithValue()} test.
     *
     * @return string[][][]
     */
    public function getFullNameWithValueArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toOption('first'), $this->value, $name
                ]
            ];
        }

        return $arguments;
    }

    /**
     * Returns data for {@link DistributorTest::testAbbreviation()} test.
     *
     * @return string[][][]
     */
    public function getAbbreviationArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toAbbreviation('f'), $name
                ]
            ];
        }

        return $arguments;
    }

    /**
     * Returns data for {@link DistributorTest::testAbbreviationsWithValue()} test.
     *
     * @return string[][][]
     */
    public function getAbbreviationWithValueArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toAbbreviation('f'), $this->value, $name
                ]
            ];
        }

        return $arguments;
    }

    /**
     * Returns data for {@link DistributorTest::testAbbreviations()} test.
     *
     * @return string[][][]
     */
    public function getAbbreviationsArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toAbbreviation('fst'), $name
                ]
            ];
        }

        return $arguments;
    }

    /**
     * Returns data for {@link DistributorTest::testAbbreviationsWithValue()} test.
     *
     * @return string[][][]
     */
    public function getAbbreviationsWithValueArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toAbbreviation('fst'), $this->value, $this->value, $this->value, $name
                ]
            ];
        }

        return $arguments;
    }

    /**
     * Returns data for {@link DistributorTest::testEqualSeparatedFullNameOption()} test.
     *
     * @return string[][][]
     */
    public function getEqualSeparatedFullNameArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toEqualSeparated(Argument::toOption('first'), $this->value), $name
                ]
            ];
        }

        return $arguments;
    }

    /**
     * Returns data for {@link DistributorTest::testEqualSeparatedAbbreviatedOption()} test.
     *
     * @return string[][][]
     */
    public function getEqualSeparatedAbbreviatedArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toEqualSeparated(Argument::toAbbreviation('f'), $this->value), $name
                ]
            ];
        }

        return $arguments;
    }

    /**
     * Returns data for {@link DistributorTest::testEqualSeparatedAbbreviations()} test.
     *
     * @return string[][][]
     */
    public function getEqualSeparatedAbbreviations(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toEqualSeparated(Argument::toAbbreviation('fst'), $this->value), $name
                ]
            ];
        }

        return $arguments;
    }

    /**
     * Returns data for {@link DistributorTest::testRequiresValueThrowsException()} test.
     *
     * @return string[][][]
     */
    public function getRequiresValueArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    Argument::toAbbreviation('f'), $name
                ]
            ];
        }

        return $arguments;
    }

    /**
     * Returns data for {@link DistributorTest::testRequiredThrowsException()} test.
     *
     * @return string[][][]
     */
    public function getRequiredArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                [
                    $name
                ]
            ];
        }

        return $arguments;
    }

    /**
     * Returns data for {@link DistributorTest::testNextArgumentsEquals()} test.
     *
     * @return string[][][]
     */
    public function getNextArguments(): array
    {
        $arguments = [];

        foreach ($this->names as $name) {
            $arguments[] = [
                array_merge([$name], $this->getExpectedNextArguments())
            ];
        }

        return $arguments;
    }

    /**
     * Returns expected next arguments array.
     *
     * @return string[][]
     */
    public function getExpectedNextArguments(): array
    {
        return $this->getFullNameArguments()[0];
    }
}
