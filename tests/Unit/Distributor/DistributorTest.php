<?php

namespace Consolly\Tests\Unit\Distributor;

use Consolly\Distributor\Distributor;
use Consolly\Exception\OptionRequiredException;
use Consolly\Exception\OptionRequiresValueException;
use Consolly\Formatter\Formatter;
use Consolly\Tests\Command\TestCommand;
use Consolly\Tests\DataProvider\Distributor\DistributorDataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class DistributorTest represents test for the {@link Distributor} class.
 *
 * @package Consolly\Tests\Unit\Distributor
 */
class DistributorTest extends TestCase
{
    /**
     * Distributor for testing.
     *
     * @var Distributor $distributor
     */
    protected Distributor $distributor;

    /**
     * Test command which will be used during testing.
     *
     * @var TestCommand $command
     */
    protected TestCommand $command;

    /**
     * Data provider, provides data for testing.
     *
     * @var DistributorDataProvider $dataProvider
     */
    protected DistributorDataProvider $dataProvider;

    /**
     * Test value.
     *
     * @var string $testValue
     */
    protected string $testValue;

    /**
     * @inheritDoc
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->command = new TestCommand();
        $this->testValue = 'value';
        $this->dataProvider = new DistributorDataProvider($this->command, $this->testValue);
    }

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->distributor = new Distributor(new Formatter());
    }

    /**
     * Executes distributor.
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    protected function executeDistributor(array $arguments): void
    {
        $this->distributor->setCommands([
            $this->command
        ]);

        $this->distributor->setArguments($arguments);

        $command = $this->distributor->getCommand();

        $this->distributor->handleArguments($command);

        $command->handle(
            $this->distributor->getNextArguments()
        );
    }

    /**
     * Data provider for testing full name.
     *
     * @return string[][][]
     */
    public function getFullNameArguments(): array
    {
        return $this->dataProvider->getFullNameArguments();
    }

    /**
     * Tests whether full name options identifies correctly.
     *
     * @dataProvider getFullNameArguments
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testFullName(array $arguments): void
    {
        $this->executeDistributor($arguments);

        self::assertTrue($this->command->getFirst()->isIndicated());
    }

    /**
     * Data provider for testing full name with value.
     *
     * @return string[][][]
     */
    public function getFullNameWithValueArguments(): array
    {
        return $this->dataProvider->getFullNameWithValueArguments();
    }

    /**
     * Tests whether full name options correctly identifies the value.
     *
     * @dataProvider getFullNameWithValueArguments
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testFullNameWithValue(array $arguments): void
    {
        $this->command->getFirst()->setRequiresValue(true);

        $this->executeDistributor($arguments);

        self::assertEquals($this->testValue, $this->command->getFirst()->getValue());
    }

    /**
     * Data provider for testing abbreviation.
     *
     * @return string[][][]
     */
    public function getAbbreviationArguments(): array
    {
        return $this->dataProvider->getAbbreviationArguments();
    }

    /**
     * Tests whether abbreviated options identifies correctly.
     *
     * @dataProvider getAbbreviationArguments
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testAbbreviation(array $arguments): void
    {
        $this->executeDistributor($arguments);

        self::assertTrue($this->command->getFirst()->isIndicated());
    }

    /**
     * Data provider for testing abbreviation with value.
     *
     * @return string[][][]
     */
    public function getAbbreviationWithValueArguments(): array
    {
        return $this->dataProvider->getAbbreviationWithValueArguments();
    }

    /**
     * Tests whether abbreviated option correctly identifies the value.
     *
     * @dataProvider getAbbreviationWithValueArguments
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testAbbreviationWithValue(array $arguments): void
    {
        $this->command->getFirst()->setRequiresValue(true);

        $this->executeDistributor($arguments);

        self::assertEquals($this->testValue, $this->command->getFirst()->getValue());
    }

    /**
     * Data provider for testing abbreviations.
     *
     * @return string[][][]
     */
    public function getAbbreviationsArguments(): array
    {
        return $this->dataProvider->getAbbreviationsArguments();
    }

    /**
     * Tests whether all abbreviations identifies correctly.
     *
     * @dataProvider getAbbreviationsArguments
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testAbbreviations(array $arguments): void
    {
        $this->executeDistributor($arguments);

        self::assertTrue($this->command->getFirst()->isIndicated());
        self::assertTrue($this->command->getSecond()->isIndicated());
        self::assertTrue($this->command->getThird()->isIndicated());
    }

    /**
     * Data provider for testing abbreviations with value.
     *
     * @return string[][][]
     */
    public function getAbbreviationsWithValueArguments(): array
    {
        return $this->dataProvider->getAbbreviationsWithValueArguments();
    }

    /**
     * Tests whether abbreviations correctly identifies the value.
     *
     * @dataProvider getAbbreviationsWithValueArguments
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testAbbreviationsWithValue(array $arguments): void
    {
        $this->command->getFirst()->setRequiresValue(true);
        $this->command->getSecond()->setRequiresValue(true);
        $this->command->getThird()->setRequiresValue(true);

        $this->executeDistributor($arguments);

        self::assertEquals($this->testValue, $this->command->getFirst()->getValue());
        self::assertEquals($this->testValue, $this->command->getSecond()->getValue());
        self::assertEquals($this->testValue, $this->command->getThird()->getValue());
    }

    /**
     * Data provider for testing equal-separated full name options.
     *
     * @return string[][][]
     */
    public function getEqualSeparatedFullNameArguments(): array
    {
        return $this->dataProvider->getEqualSeparatedFullNameArguments();
    }

    /**
     * Tests whether equal-separated option identifies correctly. Also tests whether the value identifies correctly.
     *
     * @dataProvider getEqualSeparatedFullNameArguments
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testEqualSeparatedFullNameOption(array $arguments): void
    {
        $this->command->getFirst()->setRequiresValue(true);

        $this->executeDistributor($arguments);

        self::assertTrue($this->command->getFirst()->isIndicated());

        self::assertEquals($this->testValue, $this->command->getFirst()->getValue());
    }

    /**
     * Data provider for testing equal-separated abbreviated options.
     *
     * @return string[][][]
     */
    public function getEqualSeparatedAbbreviatedArguments(): array
    {
        return $this->dataProvider->getEqualSeparatedAbbreviatedArguments();
    }

    /**
     * Tests whether equal-separated abbreviated options identifies correctly.
     * Also tests whether the value identifies correctly.
     *
     * @dataProvider getEqualSeparatedAbbreviatedArguments
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testEqualSeparatedAbbreviatedOption(array $arguments): void
    {
        $this->command->getFirst()->setRequiresValue(true);

        $this->executeDistributor($arguments);

        self::assertTrue($this->command->getFirst()->isIndicated());

        self::assertEquals($this->testValue, $this->command->getFirst()->getValue());
    }

    /**
     * Data provider for testing equal-separated abbreviations.
     *
     * @return string[][][]
     */
    public function getEqualSeparatedAbbreviations(): array
    {
        return $this->dataProvider->getEqualSeparatedAbbreviations();
    }

    /**
     * Tests whether equal-separated abbreviations identifies correctly.
     * Also tests whether the value identifies correctly.
     *
     * @dataProvider getEqualSeparatedAbbreviations
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testEqualSeparatedAbbreviations(array $arguments): void
    {
        $this->command->getFirst()->setRequiresValue(true);
        $this->command->getSecond()->setRequiresValue(true);
        $this->command->getThird()->setRequiresValue(true);

        $this->executeDistributor($arguments);

        self::assertTrue($this->command->getFirst()->isIndicated());
        self::assertTrue($this->command->getSecond()->isIndicated());
        self::assertTrue($this->command->getThird()->isIndicated());

        self::assertEquals($this->testValue, $this->command->getFirst()->getValue());
        self::assertEquals($this->testValue, $this->command->getSecond()->getValue());
        self::assertEquals($this->testValue, $this->command->getThird()->getValue());
    }

    /**
     * Data provider for testing requires value exception.
     *
     * @return string[][][]
     */
    public function getRequiresValueArguments(): array
    {
        return $this->dataProvider->getRequiresValueArguments();
    }

    /**
     * Tests whether exception throws correctly when no value passed to option which requires value.
     *
     * @dataProvider getRequiresValueArguments
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testRequiresValueThrowsException(array $arguments): void
    {
        $this->command->getFirst()->setRequiresValue(true);

        $this->expectException(OptionRequiresValueException::class);

        $this->executeDistributor($arguments);
    }

    /**
     * Data provider for testing required options.
     *
     * @return string[][][]
     */
    public function getRequiredArguments(): array
    {
        return $this->dataProvider->getRequiredArguments();
    }

    /**
     * Tests whether exception throws correctly when required option is not specified.
     *
     * @dataProvider getRequiredArguments
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testRequiredThrowsException(array $arguments): void
    {
        $this->command->getFirst()->setRequired(true);

        $this->expectException(OptionRequiredException::class);

        $this->executeDistributor($arguments);
    }

    /**
     * Data provider for testing next arguments.
     *
     * @return string[][][]
     */
    public function getNextArguments(): array
    {
        return $this->dataProvider->getNextArguments();
    }

    /**
     * Tests whether next arguments passed to the handle() method correctly.
     *
     * @dataProvider getNextArguments
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testNextArgumentsEquals(array $arguments): void
    {
        $this->executeDistributor($arguments);

        self::assertEquals($this->dataProvider->getExpectedNextArguments(), $this->command->getNextArguments());
    }
}
