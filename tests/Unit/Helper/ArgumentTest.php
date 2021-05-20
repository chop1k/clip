<?php

namespace Consolly\Tests\Unit\Helper;

use Consolly\Helper\Argument;
use Consolly\Tests\DataProvider\Helper\ArgumentDataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class ArgumentTest represents test for {@link Argument} class.
 *
 * @package Consolly\Tests\Unit\Helper
 */
class ArgumentTest extends TestCase
{
    /**
     * Data provider for test.
     *
     * @var ArgumentDataProvider $dataProvider
     */
    protected ArgumentDataProvider $dataProvider;

    /**
     * @inheritDoc
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->dataProvider = new ArgumentDataProvider();
    }

    /**
     * Data provider for testing clearing the argument.
     *
     * @return string[][]
     */
    public function getClearArguments(): array
    {
        return $this->dataProvider->getClearArguments();
    }

    /**
     * Tests whether the arguments clears correctly.
     *
     * @dataProvider getClearArguments
     *
     * @param string $input
     *
     * @param string $output
     */
    public function testClear(string $input, string $output): void
    {
        self::assertEquals($output, Argument::clear($input));
    }

    /**
     * Data provider for testing exploding equal-separated options.
     *
     * @return array[]
     */
    public function getExplodeEqualSeparatedOptionArguments(): array
    {
        return $this->dataProvider->getExplodeEqualSeparatedOptionArguments();
    }

    /**
     * Tests whether equal-separated option explodes correctly.
     *
     * @dataProvider getExplodeEqualSeparatedOptionArguments
     *
     * @param string $input
     *
     * @param array $output
     */
    public function testExplodeEqualSeparatedOption(string $input, array $output): void
    {
        self::assertEquals($output, Argument::explodeEqualSeparated($input));
    }

    /**
     * Data provider for testing option determination.
     *
     * @return array[]
     */
    public function getIsOptionArguments(): array
    {
        return $this->dataProvider->getIsOptionArguments();
    }

    /**
     * Tests whether the option identifies correctly.
     *
     * @dataProvider getIsOptionArguments
     *
     * @param string $input
     *
     * @param bool $output
     */
    public function testIsOption(string $input, bool $output): void
    {
        self::assertEquals($output, Argument::isOption($input));
    }

    /**
     * Data provider for testing abbreviation determination.
     *
     * @return array[]
     */
    public function getIsAbbreviationArguments(): array
    {
        return $this->dataProvider->getIsAbbreviationArguments();
    }

    /**
     * Tests whether the abbreviation determines correctly.
     *
     * @dataProvider getIsAbbreviationArguments
     *
     * @param string $input
     *
     * @param bool $output
     */
    public function testIsAbbreviation(string $input, bool $output): void
    {
        self::assertEquals($output, Argument::isAbbreviation($input));
    }

    /**
     * Data provider for abbreviations determination.
     *
     * @return array[]
     */
    public function getIsAbbreviationsArguments(): array
    {
        return $this->dataProvider->getIsAbbreviationsArguments();
    }

    /**
     * Tests whether abbreviations determines correctly.
     *
     * @dataProvider getIsAbbreviationsArguments
     *
     * @param string $input
     *
     * @param bool $output
     */
    public function testIsAbbreviations(string $input, bool $output): void
    {
        self::assertEquals($output, Argument::isAbbreviations($input));
    }

    /**
     * Data provider for determining values.
     *
     * @return array[]
     */
    public function getIsValueArguments(): array
    {
        return $this->dataProvider->getIsValueArguments();
    }

    /**
     * Tests whether value determines correctly.
     *
     * @dataProvider getIsValueArguments
     *
     * @param string $input
     * @param bool $output
     */
    public function testIsValue(string $input, bool $output): void
    {
        self::assertEquals($output, Argument::isValue($input));
    }

    /**
     * Data provider for determination pure values.
     *
     * @return array[]
     */
    public function getIsPureValueArguments(): array
    {
        return $this->dataProvider->getIsPureValueArguments();
    }

    /**
     * Tests whether pure values determines correctly.
     *
     * @dataProvider getIsPureValueArguments
     *
     * @param string $input
     *
     * @param bool $output
     */
    public function testIsPureValue(string $input, bool $output): void
    {
        self::assertEquals($output, Argument::isPureValue($input));
    }

    /**
     * Data provider for converting the argument to the value.
     *
     * @return string[][]
     */
    public function getToOptionArguments(): array
    {
        return $this->dataProvider->getToOptionArguments();
    }

    /**
     * Tests whether the argument converts to the value correctly.
     *
     * @dataProvider getToOptionArguments
     *
     * @param string $input
     *
     * @param string $output
     */
    public function testToOption(string $input, string $output): void
    {
        self::assertEquals($output, Argument::toOption($input));
    }

    /**
     * Data provider for converting the argument to the abbreviation.
     *
     * @return string[][]
     */
    public function getToAbbreviationArguments(): array
    {
        return $this->dataProvider->getToAbbreviationArguments();
    }

    /**
     * Tests whether the argument converts to the abbreviation correctly.
     *
     * @dataProvider getToAbbreviationArguments
     *
     * @param string $input
     *
     * @param string $output
     */
    public function testToAbbreviation(string $input, string $output): void
    {
        self::assertEquals($output, Argument::toAbbreviation($input));
    }

    /**
     * Data provider for converting the arguments to the equal-separated option.
     *
     * @return string[][]
     */
    public function getToEqualSeparatedArguments(): array
    {
        return $this->dataProvider->getToEqualSeparatedArguments();
    }

    /**
     * Tests whether the arguments converts to the equal-separated option correctly.
     *
     * @dataProvider getToEqualSeparatedArguments
     *
     * @param string $option
     *
     * @param string $value
     *
     * @param string $output
     */
    public function testToEqualSeparated(string $option, string $value, string $output): void
    {
        self::assertEquals($output, Argument::toEqualSeparated($option, $value));
    }

    /**
     * Data provider for converting the argument to the value.
     *
     * @return string[][]
     */
    public function getToValueArguments(): array
    {
        return $this->dataProvider->getToValueArguments();
    }

    /**
     * Tests whether the argument converts to the value correctly.
     *
     * @dataProvider getToValueArguments
     *
     * @param string $input
     *
     * @param string $output
     */
    public function testToValue(string $input, string $output): void
    {
        self::assertEquals($output, Argument::toValue($input));
    }

    /**
     * Data provider for converting the argument to the pure value.
     *
     * @return string[][]
     */
    public function getToPureValueArguments(): array
    {
        return $this->dataProvider->getToPureValueArguments();
    }

    /**
     * Tests whether the argument converts to the pure value correctly.
     *
     * @dataProvider getToPureValueArguments
     *
     * @param string $input
     *
     * @param string $output
     */
    public function testToPureValue(string $input, string $output): void
    {
        self::assertEquals($output, Argument::toPureValue($input));
    }
}
