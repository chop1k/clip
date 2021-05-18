<?php

namespace Consolly\Tests\Unit\Formatter;

use Consolly\Formatter\Formatter;
use Consolly\Formatter\FormatterInterface;
use Consolly\Tests\DataProvider\Formatter\FormatterDataProvider;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FormatterTest extends TestCase
{
    protected FormatterInterface $formatter;

    protected FormatterDataProvider $dataProvider;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->dataProvider = new FormatterDataProvider();
    }

    protected function setUp(): void
    {
        $this->formatter = new Formatter();
    }

    public function getParseArguments(): array
    {
        return $this->dataProvider->getParseArguments();
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
        return $this->dataProvider->getFormatArguments();
    }

    /**
     * @dataProvider getFormatArguments
     *
     * @param $raw
     * @param string $expected
     * @param string $type
     */
    public function testFormat($raw, string $expected, string $type): void
    {
        self::assertEquals($expected, $this->formatter->format($raw, $type));
    }

    public function getFormatExceptionArguments(): array
    {
        return $this->dataProvider->getFormatExceptionArguments();
    }

    /**
     * @dataProvider getFormatExceptionArguments
     *
     * @param array $raw
     * @param string $type
     */
    public function testFormatException(array $raw, string $type): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->formatter->format($raw, $type);
    }
}
