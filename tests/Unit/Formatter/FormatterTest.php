<?php

namespace Consolly\Tests\Unit\Formatter;

use Consolly\Formatter\Formatter;
use Consolly\Formatter\FormatterInterface;
use Consolly\Tests\DataProvider\Formatter\FormatterDataProvider;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class FormatterTest represents test for {@link Formatter} class.
 *
 * @package Consolly\Tests\Unit\Formatter
 */
class FormatterTest extends TestCase
{
    /**
     * The formatter to test.
     *
     * @var FormatterInterface $formatter
     */
    protected FormatterInterface $formatter;

    /**
     * Data provider for testing.
     *
     * @var FormatterDataProvider $dataProvider
     */
    protected FormatterDataProvider $dataProvider;

    /**
     * @inheritDoc
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->dataProvider = new FormatterDataProvider();
    }

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->formatter = new Formatter();
    }

    /**
     * Data provider for testing parsing.
     *
     * @return string[][]
     */
    public function getParseArguments(): array
    {
        return $this->dataProvider->getParseArguments();
    }

    /**
     * Tests whether type of the argument identifies correctly.
     *
     * @dataProvider getParseArguments
     *
     * @param string $argument
     *
     * @param string $type
     */
    public function testParse(string $argument, string $type): void
    {
        self::assertEquals($type, $this->formatter->parse($argument));
    }

    /**
     * Data provider for testing formatting.
     *
     * @return string[][]
     */
    public function getFormatArguments(): array
    {
        return $this->dataProvider->getFormatArguments();
    }

    /**
     * Tests whether the value formats correctly.
     *
     * @dataProvider getFormatArguments
     *
     * @param mixed $raw
     * @param string $expected
     * @param string $type
     */
    public function testFormat(mixed $raw, string $expected, string $type): void
    {
        self::assertEquals($expected, $this->formatter->format($raw, $type));
    }

    /**
     * Data provider for testing format exception.
     *
     * @return array[]
     */
    public function getFormatExceptionArguments(): array
    {
        return $this->dataProvider->getFormatExceptionArguments();
    }

    /**
     * Tests whether the exception throws correctly.
     *
     * @dataProvider getFormatExceptionArguments
     *
     * @param array $raw
     *
     * @param string $type
     */
    public function testFormatException(array $raw, string $type): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->formatter->format($raw, $type);
    }
}
