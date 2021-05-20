<?php

namespace Consolly\Tests\DataProvider\Helper;

use Consolly\Tests\Unit\Helper\ArgumentTest;

/**
 * Class ArgumentDataProvider represents data provider for {@link ArgumentTest} test.
 *
 * @package Consolly\Tests\DataProvider\Helper
 */
class ArgumentDataProvider
{
    /**
     * Returns data for {@link ArgumentTest::testClear()} test.
     *
     * @return string[][]
     */
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
     * Returns data for {@link ArgumentTest::testExplodeEqualSeparatedOption()} test.
     *
     * @return array[]
     */
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
     * Returns data for {@link ArgumentTest::testIsOption()} test.
     *
     * @return array[]
     */
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
     * Returns data for {@link ArgumentTest::testIsAbbreviation()} test.
     *
     * @return array[]
     */
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
     * Returns data for {@link ArgumentTest::testIsAbbreviations()} test.
     *
     * @return array[]
     */
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
     * Returns data for {@link ArgumentTest::testIsValue()} test.
     *
     * @return array[]
     */
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
     * Returns data for {@link ArgumentTest::testIsPureValue()} test.
     *
     * @return array[]
     */
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
     * Returns data for {@link ArgumentTest::testToOption()} test.
     *
     * @return string[][]
     */
    public function getToOptionArguments(): array
    {
        return [
            [
                'option', '--option'
            ]
        ];
    }

    /**
     * Returns data for {@link ArgumentTest::testToAbbreviation()} test.
     *
     * @return string[][]
     */
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
     * Returns data for {@link ArgumentTest::testToEqualSeparated()} test.
     *
     * @return string[][]
     */
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
     * Returns data for {@link ArgumentTest::testToValue()} test.
     *
     * @return string[][]
     */
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
     * Returns data for {@link ArgumentTest::testToPureValue()} test.
     *
     * @return string[][]
     */
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
}
