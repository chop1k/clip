<?php

namespace Consolly\Tests\DataProvider\Event\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Tests\DataProvider\Distributor\DistributorDataProvider;
use Consolly\Tests\Unit\Event\Distributor\NextArgumentsSubscriberTest;

/**
 * Class NextArgumentsSubscriberDataProvider represents data provider for {@link NextArgumentsSubscriberTest} test.
 *
 * @package Consolly\Tests\DataProvider\Event\Distributor
 */
class NextArgumentsSubscriberDataProvider
{
    /**
     * @var DistributorDataProvider $dataProvider
     */
    protected DistributorDataProvider $dataProvider;

    /**
     * NextArgumentsSubscriberDataProvider constructor.
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
     * Returns data for {@link NextArgumentsSubscriberTest} test.
     *
     * @return string[]
     */
    public function getArguments(): array
    {
        return array_merge($this->dataProvider->getFullNameArguments()[0][0], $this->getExceptedArguments());
    }

    /**
     * Returns expected arguments for comparison.
     *
     * @return string[]
     */
    public function getExceptedArguments(): array
    {
        return [
            $this->dataProvider->getAbbreviationArguments()[0][0]
        ];
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
