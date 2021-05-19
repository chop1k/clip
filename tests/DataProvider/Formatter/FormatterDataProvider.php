<?php

namespace Consolly\Tests\DataProvider\Formatter;

use Consolly\Helper\Argument;
use Consolly\Tests\Unit\Formatter\FormatterTest;

/**
 * Class FormatterDataProvider represents data provider for {@link FormatterTest} test.
 *
 * @package Consolly\Tests\DataProvider\Formatter
 */
class FormatterDataProvider
{
    /**
     * Returns data for {@link FormatterTest::testParse()} test.
     *
     * @return string[][]
     */
    public function getParseArguments(): array
    {
        return [
            [
                '--option', Argument::TYPE_OPTION
            ],
            [
                '-a', Argument::TYPE_ABBREVIATION
            ],
            [
                '--option=value', Argument::TYPE_EQUAL_SEPARATED_OPTION
            ],
            [
                '-a=value', Argument::TYPE_EQUAL_SEPARATED_ABBREVIATION
            ],
            [
                'option=value', Argument::TYPE_PURE_VALUE
            ],
            [
                '--option=', Argument::TYPE_EQUAL_SEPARATED_OPTION
            ],
            [
                'value', Argument::TYPE_PURE_VALUE
            ],
            [
                'Lorem ipsum', Argument::TYPE_PURE_VALUE
            ],
            [
                '"another value"', Argument::TYPE_VALUE
            ],
            [
                '"value" "value"', Argument::TYPE_VALUE
            ]
        ];
    }

    /**
     * Returns data for {@link FormatterTest::testParse()} test.
     *
     * @return string[][]
     */
    public function getFormatArguments(): array
    {
        return [
            [
                'option', '--option', Argument::TYPE_OPTION
            ],
            [
                'a', '-a', Argument::TYPE_ABBREVIATION
            ],
            [
                'abc', '-abc', Argument::TYPE_ABBREVIATIONS
            ],
            [
                ['option', 'value'], '--option=value', Argument::TYPE_EQUAL_SEPARATED_OPTION
            ],
            [
                ['a', 'value'], '-a=value', Argument::TYPE_EQUAL_SEPARATED_ABBREVIATION
            ],
            [
                ['abc', 'value'], '-abc=value', Argument::TYPE_EQUAL_SEPARATED_ABBREVIATIONS
            ],
            [
                ['', ''], '-=', Argument::TYPE_EQUAL_SEPARATED_ABBREVIATIONS
            ],
            [
                '--option', '--option', Argument::TYPE_OPTION
            ],
            [
                '-a', '-a', Argument::TYPE_ABBREVIATION
            ],
            [
                '-abc', '-abc', Argument::TYPE_ABBREVIATIONS
            ],
            [
                'value', Argument::toValue('value'), Argument::TYPE_VALUE
            ],
            [
                Argument::toValue('value'), 'value', Argument::TYPE_PURE_VALUE
            ]
        ];
    }

    /**
     * Returns data for {@link FormatterTest::testFormatException()} test.
     *
     * @return array[][]
     */
    public function getFormatExceptionArguments(): array
    {
        return [
            [
                ['abc'], Argument::TYPE_EQUAL_SEPARATED_ABBREVIATIONS
            ],
            [
                ['abc', null], Argument::TYPE_EQUAL_SEPARATED_ABBREVIATIONS
            ],
            [
                [null, null], Argument::TYPE_EQUAL_SEPARATED_ABBREVIATIONS
            ],
        ];
    }
}
