<?php

namespace Consolly\Tests\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Distributor\Distributor;
use Consolly\Distributor\DistributorInterface;
use Consolly\Exception\OptionRequiredException;
use Consolly\Exception\OptionRequiresValueException;
use Consolly\Formatter\Formatter;
use Consolly\Helper\Argument;
use Consolly\Tests\Command\TestCommand;
use PHPUnit\Framework\TestCase;

/**
 * Class DistributorTest represents test for the {@link Distributor} class.
 *
 * @package Consolly\Tests\Distributor
 */
class DistributorTest extends TestCase
{
    /**
     * Contains the distributor.
     *
     * @var DistributorInterface|Distributor $distributor
     */
    protected DistributorInterface $distributor;

    /**
     * Contains the test command.
     *
     * @var CommandInterface|TestCommand $command
     */
    protected CommandInterface $command;

    /**
     * @inheritdoc
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->command = new TestCommand();
    }

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        $this->distributor = new Distributor(new Formatter());
    }

    /**
     * Without quotes it will throw an Exception because command name and value is same.
     * By default it will choose first the first matching name.
     * For fix this you can quotes or equal-separated-option.
     *
     * @param string $value
     *
     * @return string
     */
    protected function fixValue(string $value): string
    {
        return sprintf('"%s"', Argument::clear($value));
    }

    /**
     * Uses distributor and returns result.
     *
     * @param array $arguments
     *
     * @return bool
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    protected function distribute(array $arguments): bool
    {
        $this->distributor->setCommands([
            $this->command
        ]);

        $this->distributor->setArguments($arguments);

        $command = $this->distributor->getCommand();

        $this->distributor->handleArguments($command);

        return $command->handle(
            $this->distributor->getNextArguments()
        );
    }

    /**
     * Returns an arguments for testFullName test.
     *
     * @return array[][]
     */
    public function getFullNameArguments(): array
    {
        return [
            [
                [
                    Argument::toOption('first'), $this->command->getName()
                ]
            ]
        ];
    }

    /**
     * Tests full name functionality of the option.
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
        self::assertTrue($this->distribute($arguments));
        self::assertTrue($this->command->getFirst()->isIndicated());
    }

    /**
     * Returns an arguments for testAbbreviation test.
     *
     * @return array[][]
     */
    public function getAbbreviationArguments(): array
    {
        return [
            [
                [
                    Argument::toAbbreviation('s'),
                    $this->fixValue($this->command->getName()),
                    $this->command->getName()
                ],
                [
                    Argument::toAbbreviation('fst'),
                    $this->fixValue($this->command->getName()),
                    $this->command->getName()
                ]
            ]
        ];
    }

    /**
     * Tests abbreviation functionality of the option.
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
        $this->command->getSecond()->setRequiresValue(true);

        self::assertTrue($this->distribute($arguments));
        self::assertTrue($this->command->getSecond()->isIndicated());
        self::assertEquals($this->command->getName(), $this->command->getSecond()->getValue());
    }

    /**
     * Returns an arguments for testEqualSeparatedArguments test.
     *
     * @return array[][]
     */
    public function getEqualSeparatedArguments(): array
    {
        return [
            [
                [
                    Argument::toEqualSeparated(
                        Argument::toOption('first'),
                        $this->fixValue($this->command->getName()),
                    ), $this->command->getName()
                ]
            ],
            [
                [
                    Argument::toEqualSeparated(
                        Argument::toAbbreviation('f'),
                        $this->fixValue($this->command->getName()),
                    ), $this->command->getName()
                ]
            ],
            [
                [
                    Argument::toEqualSeparated(
                        Argument::toAbbreviation('fst'),
                        $this->fixValue($this->command->getName()),
                    ), $this->command->getName()
                ]
            ]
        ];
    }

    /**
     * Tests equal-separated option functionality of the option.
     *
     * @dataProvider getEqualSeparatedArguments
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testEqualSeparatedOption(array $arguments): void
    {
        $this->command->getFirst()->setRequiresValue(true);
        $this->command->getSecond()->setRequiresValue(true);
        $this->command->getThird()->setRequiresValue(true);

        self::assertTrue($this->distribute($arguments));

        if ($this->command->getFirst()->isIndicated()) {
            self::assertEquals($this->command->getName(), $this->command->getFirst()->getValue());
        }

        if ($this->command->getSecond()->isIndicated()) {
            self::assertEquals($this->command->getName(), $this->command->getSecond()->getValue());
        }

        if ($this->command->getThird()->isIndicated()) {
            self::assertEquals($this->command->getName(), $this->command->getThird()->getValue());
        }
    }

    /**
     * Returns an arguments for testRequiresValue test.
     *
     * @return array[]
     */
    public function getRequiresValueArguments(): array
    {
        return [
            [
                [
                    Argument::toAbbreviation('f'),
                    $this->fixValue($this->command->getName()),
                    $this->command->getName()
                ], false
            ],
            [
                [
                    Argument::toOption('first'),
                    $this->fixValue($this->command->getName()),
                    $this->command->getName()
                ], false
            ],
            [
                [
                    Argument::toAbbreviation('f'), $this->command->getName()
                ], true
            ]
        ];
    }

    /**
     * Tests values functionality of the option.
     *
     * @dataProvider getRequiresValueArguments
     *
     * @param array $arguments
     *
     * @param bool $exception
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testRequiresValue(array $arguments, bool $exception): void
    {
        $this->command->getFirst()->setRequiresValue(true);

        if ($exception) {
            $this->expectException(OptionRequiresValueException::class);
        }

        self::assertTrue($this->distribute($arguments));

        self::assertTrue($this->command->getFirst()->isIndicated());
        self::assertEquals($this->command->getName(), $this->command->getFirst()->getValue());
    }

    /**
     * Returns an arguments for testRequired test.
     *
     * @return array[]
     */
    public function getRequiredArguments(): array
    {
        return [
            [
                [
                    Argument::toAbbreviation('f'), $this->command->getName()
                ], false
            ],
            [
                [
                    Argument::toOption('first'), $this->command->getName()
                ], false
            ],
            [
                [
                    $this->command->getName()
                ], true
            ]
        ];
    }

    /**
     * Tests required functionality of the option.
     *
     * @dataProvider getRequiredArguments
     *
     * @param array $arguments
     *
     * @param bool $exception
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testRequired(array $arguments, bool $exception): void
    {
        $this->command->getFirst()->setRequired(true);

        if ($exception) {
            $this->expectException(OptionRequiredException::class);
        }

        self::assertTrue($this->distribute($arguments));
    }

    /**
     * Returns an arguments for testValue test.
     *
     * @return array[][]
     */
    public function getValueArguments(): array
    {
        return [
            [
                [
                    Argument::toAbbreviation('f'),
                    $this->fixValue($this->command->getName()),
                    $this->command->getName()
                ],
                [
                    Argument::toOption('first'),
                    $this->fixValue($this->command->getName()),
                    $this->command->getName()
                ]
            ]
        ];
    }

    /**
     * Tests values functionality of the option.
     *
     * @dataProvider getValueArguments
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testValue(array $arguments): void
    {
        $this->command->getFirst()->setRequiresValue(true);

        self::assertTrue($this->distribute($arguments));

        self::assertEquals($this->command->getName(), $this->command->getFirst()->getValue());
    }

    /**
     * Returns an arguments for testIndicated test.
     *
     * @return array[][]
     */
    public function getIndicatedArguments(): array
    {
        return [
            [
                [
                    Argument::toAbbreviation('fst'), $this->command->getName()
                ]
            ]
        ];
    }

    /**
     * Tests indicated functionality of the option.
     *
     * @dataProvider getIndicatedArguments
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testIndicated(array $arguments): void
    {
        self::assertTrue($this->distribute($arguments));
    }

    /**
     * Returns an arguments for testNextArguments test.
     *
     * @return array[][]
     */
    public function getNextArguments(): array
    {
        return [
            [
                [
                    $this->command->getName(), Argument::toAbbreviation('f')
                ]
            ]
        ];
    }

    /**
     * Tests next arguments functionality of the option.
     *
     * @dataProvider getNextArguments
     *
     * @param array $arguments
     *
     * @throws OptionRequiredException
     *
     * @throws OptionRequiresValueException
     */
    public function testNextArguments(array $arguments): void
    {
        self::assertTrue($this->distribute($arguments));

        self::assertEquals(Argument::toAbbreviation('f'), $this->command->getNextArguments()[0]);
    }
}
