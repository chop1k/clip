<?php

namespace Consolly\Tests\Unit\Helper;

use Consolly\Helper\Argument;
use Consolly\Tests\DataProvider\Helper\ArgumentDataProvider;
use PHPUnit\Framework\TestCase;

class ArgumentTest extends TestCase
{
    protected ArgumentDataProvider $dataProvider;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->dataProvider = new ArgumentDataProvider();
    }

    public function getClearArguments(): array
    {
        return $this->dataProvider->getClearArguments();
    }

    /**
     * @dataProvider getClearArguments
     *
     * @param string $input
     * @param string $output
     */
    public function testClear(string $input, string $output): void
    {
        self::assertEquals($output, Argument::clear($input));
    }

    public function getExplodeEqualSeparatedOptionArguments(): array
    {
        return $this->dataProvider->getExplodeEqualSeparatedOptionArguments();
    }

    /**
     * @dataProvider getExplodeEqualSeparatedOptionArguments
     *
     * @param string $input
     * @param array $output
     */
    public function testExplodeEqualSeparatedOption(string $input, array $output): void
    {
        self::assertEquals($output, Argument::explodeEqualSeparated($input));
    }

    public function getIsOptionArguments(): array
    {
        return $this->dataProvider->getIsOptionArguments();
    }

    /**
     * @dataProvider getIsOptionArguments
     *
     * @param string $input
     * @param bool $output
     */
    public function testIsOption(string $input, bool $output): void
    {
        self::assertEquals($output, Argument::isOption($input));
    }

    public function getIsAbbreviationArguments(): array
    {
        return $this->dataProvider->getIsAbbreviationArguments();
    }

    /**
     * @dataProvider getIsAbbreviationArguments
     *
     * @param string $input
     * @param bool $output
     */
    public function testIsAbbreviation(string $input, bool $output): void
    {
        self::assertEquals($output, Argument::isAbbreviation($input));
    }

    public function getIsAbbreviationsArguments(): array
    {
        return $this->dataProvider->getIsAbbreviationsArguments();
    }

    /**
     * @dataProvider getIsAbbreviationsArguments
     *
     * @param string $input
     * @param bool $output
     */
    public function testIsAbbreviations(string $input, bool $output): void
    {
        self::assertEquals($output, Argument::isAbbreviations($input));
    }

    public function getIsValueArguments(): array
    {
        return $this->dataProvider->getIsValueArguments();
    }

    /**
     * @dataProvider getIsValueArguments
     *
     * @param string $input
     * @param bool $output
     */
    public function testIsValue(string $input, bool $output): void
    {
        self::assertEquals($output, Argument::isValue($input));
    }

    public function getIsPureValueArguments(): array
    {
        return $this->dataProvider->getIsPureValueArguments();
    }

    /**
     * @dataProvider getIsPureValueArguments
     *
     * @param string $input
     * @param bool $output
     */
    public function testIsPureValue(string $input, bool $output): void
    {
        self::assertEquals($output, Argument::isPureValue($input));
    }

    public function getToOptionArguments(): array
    {
        return $this->dataProvider->getToOptionArguments();
    }

    /**
     * @dataProvider getToOptionArguments
     *
     * @param string $input
     * @param string $output
     */
    public function testToOption(string $input, string $output): void
    {
        self::assertEquals($output, Argument::toOption($input));
    }

    public function getToAbbreviationArguments(): array
    {
        return $this->dataProvider->getToAbbreviationArguments();
    }

    /**
     * @dataProvider getToAbbreviationArguments
     *
     * @param string $input
     * @param string $output
     */
    public function testToAbbreviation(string $input, string $output): void
    {
        self::assertEquals($output, Argument::toAbbreviation($input));
    }

    public function getToEqualSeparatedArguments(): array
    {
        return $this->dataProvider->getToEqualSeparatedArguments();
    }

    /**
     * @dataProvider getToEqualSeparatedArguments
     *
     * @param string $option
     * @param string $value
     * @param string $output
     */
    public function testToEqualSeparated(string $option, string $value, string $output): void
    {
        self::assertEquals($output, Argument::toEqualSeparated($option, $value));
    }

    public function getToValueArguments(): array
    {
        return $this->dataProvider->getToValueArguments();
    }

    /**
     * @dataProvider getToValueArguments
     *
     * @param string $input
     * @param string $output
     */
    public function testToValueArguments(string $input, string $output): void
    {
        self::assertEquals($output, Argument::toValue($input));
    }

    public function getToPureValueArguments(): array
    {
        return $this->dataProvider->getToPureValueArguments();
    }

    /**
     * @dataProvider getToPureValueArguments
     *
     * @param string $input
     * @param string $output
     */
    public function testToPureValue(string $input, string $output): void
    {
        self::assertEquals($output, Argument::toPureValue($input));
    }
}
