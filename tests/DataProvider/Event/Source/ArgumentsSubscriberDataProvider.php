<?php

namespace Consolly\Tests\DataProvider\Event\Source;

use Consolly\Command\CommandInterface;
use Consolly\Tests\DataProvider\Distributor\DistributorDataProvider;
use Consolly\Tests\Unit\Event\Source\ArgumentsSubscriberTest;

/**
 * Class ArgumentsSubscriberDataProvider represents data provider for {@link ArgumentsSubscriberTest} test.
 *
 * @package Consolly\Tests\DataProvider\Event\Source
 */
class ArgumentsSubscriberDataProvider
{
    /**
     * @var DistributorDataProvider $dataProvider
     */
    protected DistributorDataProvider $dataProvider;

    /**
     * ArgumentsSubscriberDataProvider constructor.
     *
     * @param CommandInterface $command
     *
     * @param string $value
     */
    public function __construct(CommandInterface $command, string $value)
    {
        $this->dataProvider = new DistributorDataProvider($command, $value);
    }

    /**
     * Returns expected arguments for comparison.
     *
     * @return string[]
     */
    public function getExceptedArguments(): array
    {
        return $this->dataProvider->getFullNameArguments()[0][0];
    }

    /**
     * Returns arguments for overriding.
     *
     * @return string[]
     */
    public function getArgumentsToOverride(): array
    {
        return $this->dataProvider->getAbbreviationsArguments()[0][0];
    }
}
