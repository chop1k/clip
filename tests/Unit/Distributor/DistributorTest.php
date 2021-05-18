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
    protected Distributor $distributor;

    protected TestCommand $command;

    protected DistributorDataProvider $dataProvider;

    protected string $testValue;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->command = new TestCommand();
        $this->testValue = 'value';
        $this->dataProvider = new DistributorDataProvider($this->command, $this->testValue);
    }

    protected function setUp(): void
    {
        $this->distributor = new Distributor(new Formatter());
    }

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

    public function getFullNameArguments(): array
    {
        return $this->dataProvider->getFullNameArguments();
    }

    /**
     * @dataProvider getFullNameArguments
     *
     * @param array $arguments
     */
    public function testFullName(array $arguments): void
    {
        $this->executeDistributor($arguments);

        self::assertTrue($this->command->getFirst()->isIndicated());
    }

    public function getFullNameWithValueArguments(): array
    {
        return $this->dataProvider->getFullNameWithValueArguments();
    }

    /**
     * @dataProvider getFullNameWithValueArguments
     *
     * @param array $arguments
     */
    public function testFullNameWithValue(array $arguments): void
    {
        $this->command->getFirst()->setRequiresValue(true);

        $this->executeDistributor($arguments);

        self::assertEquals($this->testValue, $this->command->getFirst()->getValue());
    }

    public function getAbbreviationArguments(): array
    {
        return $this->dataProvider->getAbbreviationArguments();
    }

    /**
     * @dataProvider getAbbreviationArguments
     *
     * @param array $arguments
     */
    public function testAbbreviation(array $arguments): void
    {
        $this->executeDistributor($arguments);

        self::assertTrue($this->command->getFirst()->isIndicated());
    }

    public function getAbbreviationWithValueArguments(): array
    {
        return $this->dataProvider->getAbbreviationWithValueArguments();
    }

    /**
     * @dataProvider getAbbreviationWithValueArguments
     *
     * @param array $arguments
     */
    public function testAbbreviationWithValue(array $arguments): void
    {
        $this->command->getFirst()->setRequiresValue(true);

        $this->executeDistributor($arguments);

        self::assertEquals($this->testValue, $this->command->getFirst()->getValue());
    }

    public function getAbbreviationsArguments(): array
    {
        return $this->dataProvider->getAbbreviationsArguments();
    }

    /**
     * @dataProvider getAbbreviationsArguments
     *
     * @param array $arguments
     */
    public function testAbbreviations(array $arguments): void
    {
        $this->executeDistributor($arguments);

        self::assertTrue($this->command->getFirst()->isIndicated());
        self::assertTrue($this->command->getSecond()->isIndicated());
        self::assertTrue($this->command->getThird()->isIndicated());
    }

    public function getAbbreviationsWithValueArguments(): array
    {
        return $this->dataProvider->getAbbreviationsWithValueArguments();
    }

    /**
     * @dataProvider getAbbreviationsWithValueArguments
     *
     * @param array $arguments
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

    public function getEqualSeparatedFullNameArguments(): array
    {
        return $this->dataProvider->getEqualSeparatedFullNameArguments();
    }

    /**
     * @dataProvider getEqualSeparatedFullNameArguments
     *
     * @param array $arguments
     */
    public function testEqualSeparatedFullNameOption(array $arguments): void
    {
        $this->command->getFirst()->setRequiresValue(true);

        $this->executeDistributor($arguments);

        self::assertTrue($this->command->getFirst()->isIndicated());

        self::assertEquals($this->testValue, $this->command->getFirst()->getValue());
    }

    public function getEqualSeparatedAbbreviatedArguments(): array
    {
        return $this->dataProvider->getEqualSeparatedAbbreviatedArguments();
    }

    /**
     * @dataProvider getEqualSeparatedAbbreviatedArguments
     *
     * @param array $arguments
     */
    public function testEqualSeparatedAbbreviatedOption(array $arguments): void
    {
        $this->command->getFirst()->setRequiresValue(true);

        $this->executeDistributor($arguments);

        self::assertTrue($this->command->getFirst()->isIndicated());

        self::assertEquals($this->testValue, $this->command->getFirst()->getValue());
    }

    public function getEqualSeparatedAbbreviations(): array
    {
        return $this->dataProvider->getEqualSeparatedAbbreviations();
    }

    /**
     * @dataProvider getEqualSeparatedAbbreviations
     *
     * @param array $arguments
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

    public function getRequiresValueArguments(): array
    {
        return $this->dataProvider->getRequiresValueArguments();
    }

    /**
     * @dataProvider getRequiresValueArguments
     *
     * @param array $arguments
     */
    public function testRequiresValueThrowsException(array $arguments): void
    {
        $this->command->getFirst()->setRequiresValue(true);

        $this->expectException(OptionRequiresValueException::class);

        $this->executeDistributor($arguments);
    }

    public function getRequiredArguments(): array
    {
        return $this->dataProvider->getRequiredArguments();
    }

    /**
     * @dataProvider getRequiredArguments
     *
     * @param array $arguments
     */
    public function testRequiredThrowsException(array $arguments): void
    {
        $this->command->getFirst()->setRequired(true);

        $this->expectException(OptionRequiredException::class);

        $this->executeDistributor($arguments);
    }

    public function getNextArguments(): array
    {
        return $this->dataProvider->getNextArguments();
    }

    /**
     * @dataProvider getNextArguments
     *
     * @param array $arguments
     */
    public function testNextArgumentsEquals(array $arguments): void
    {
        $this->executeDistributor($arguments);

        self::assertEquals($this->dataProvider->getExpectedNextArguments(), $this->command->getNextArguments());
    }
}
