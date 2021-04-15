<?php

namespace Consolly\Tests\Formatter;

use Consolly\Formatter\Formatter;
use Consolly\Formatter\FormatterInterface;
use Consolly\Helper\Argument;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FormatterTest extends TestCase
{
    protected FormatterInterface $formatter;

    protected function setUp(): void
    {
        $this->formatter = new Formatter();
    }

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
     * @dataProvider getParseArguments
     *
     * @param string $argument
     * @param string $type
     */
    public function testParse(string $argument, string $type): void
    {
        self::assertEquals($type, $this->formatter->parse($argument));
    }

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
                ['abc'], '', Argument::TYPE_EQUAL_SEPARATED_ABBREVIATIONS, true
            ],
            [
                ['abc', null], '', Argument::TYPE_EQUAL_SEPARATED_ABBREVIATIONS, true
            ],
            [
                [null, null], '', Argument::TYPE_EQUAL_SEPARATED_ABBREVIATIONS, true
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
     * @dataProvider getFormatArguments
     *
     * @param $raw
     * @param string $expected
     * @param string $type
     * @param bool $exception
     */
    public function testFormat($raw, string $expected, string $type, bool $exception = false): void
    {
        if ($exception) {
            $this->expectException(InvalidArgumentException::class);
        }

        self::assertEquals($expected, $this->formatter->format($raw, $type));
    }
}
