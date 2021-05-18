<?php

namespace Consolly\Tests\DataProvider\Event\Source;

use Consolly\Command\CommandInterface;
use Consolly\Tests\DataProvider\Distributor\DistributorDataProvider;

class ArgumentsSubscriberDataProvider
{
    protected DistributorDataProvider $dataProvider;

    public function __construct(CommandInterface $command, string $value)
    {
        $this->dataProvider = new DistributorDataProvider($command, $value);
    }

    public function getExceptedArguments(): array
    {
        return $this->dataProvider->getFullNameArguments()[0][0];
    }

    public function getArgumentsToOverride(): array
    {
        return $this->dataProvider->getAbbreviationsArguments()[0][0];
    }
}
