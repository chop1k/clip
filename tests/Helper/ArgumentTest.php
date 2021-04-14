<?php

namespace Consolly\Tests\Helper;

use Consolly\Helper\Argument;
use PHPUnit\Framework\TestCase;

class ArgumentTest extends TestCase
{
    public function getClearArguments(): array
    {
        return [
            [
                '"value"', 'value'
            ],
            [
                "'value'", 'value'
            ],
            [
                '--option', 'option'
            ],
            [
                '---option', 'option'
            ],
            [
                '-a', 'a'
            ],
            [
                '-abs', 'abs'
            ],
            [
                '  value  ', 'value'
            ],
            [
                '--value--', 'value'
            ],
            [
                '- "\' value "\'-- ', 'value'
            ]
        ];
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
        return [
            [
                '--option=value', ['--option', 'value']
            ],
            [
                '-a=value', ['-a', 'value']
            ],
            [
                '-abs=value', ['-abs', 'value']
            ],
            [
                'value=value', ['value', 'value']
            ],
            [
                'value=value=value', ['value', 'value=value']
            ],
            [
                'value= value', ['value', ' value']
            ]
        ];
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
        return [
            [
                '--option', true
            ],
            [
                '--option=value', false
            ],
            [
                '-a', false
            ],
            [
                '-a=value', false
            ],
            [
                '-abs', false
            ],
            [
                '-abs=value', false
            ],
            [
                'value', false
            ],
            [
                '"value"', false
            ],
            [
                "'value'", false
            ]
        ];
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
        return [
            [
                '--option', false
            ],
            [
                '--option=value', false
            ],
            [
                '-a', true
            ],
            [
                '-a=value', false
            ],
            [
                '-abs', false
            ],
            [
                '-abs=value', false
            ],
            [
                'value', false
            ],
            [
                '"value"', false
            ],
            [
                "'value'", false
            ]
        ];
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
        return [
            [
                '--option', false
            ],
            [
                '--option=value', false
            ],
            [
                '-a', false
            ],
            [
                '-a=value', false
            ],
            [
                '-abs', true
            ],
            [
                '-abs=value', false
            ],
            [
                'value', false
            ],
            [
                '"value"', false
            ],
            [
                "'value'", false
            ]
        ];
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
        return [
            [
                '--option', false
            ],
            [
                '--option=value', false
            ],
            [
                '-a', false
            ],
            [
                '-a=value', false
            ],
            [
                '-abs', false
            ],
            [
                '-abs=value', false
            ],
            [
                'value', false
            ],
            [
                '"value"', true
            ],
            [
                "'value'", true
            ]
        ];
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
        return [
            [
                '--option', false
            ],
            [
                '--option=value', false
            ],
            [
                '-a', false
            ],
            [
                '-a=value', false
            ],
            [
                '-abs', false
            ],
            [
                '-abs=value', false
            ],
            [
                'value', true
            ],
            [
                '"value"', false
            ],
            [
                "'value'", false
            ]
        ];
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
        return [
            [
                'option', '--option'
            ]
        ];
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
        return [
            [
                'a', '-a'
            ],
            [
                'abs', '-abs'
            ]
        ];
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
        return [
            [
                'value', 'value', 'value=value'
            ],
            [
                '--option', 'value', '--option=value'
            ],
            [
                '-a', 'value', '-a=value'
            ],
            [
                '-abs', 'value', '-abs=value'
            ]
        ];
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
        return [
            [
                'value', '"value"'
            ],
            [
                '"value"', '"value"'
            ],
            [
                "'value'", '"value"'
            ]
        ];
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
        return [
            [
                'value', 'value'
            ],
            [
                '"value"', 'value'
            ],
            [
                "'value'", 'value'
            ]
        ];
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
