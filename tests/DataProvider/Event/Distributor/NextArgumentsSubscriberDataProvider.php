<?php

namespace Consolly\Tests\DataProvider\Event\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Tests\DataProvider\Distributor\DistributorDataProvider;

class NextArgumentsSubscriberDataProvider
{
    protected DistributorDataProvider $dataProvider;

    public function __construct(CommandInterface $command, string $value)
    {
        $this->dataProvider = new DistributorDataProvider($command, $value);
    }

    public function getArguments(): array
    {
        return array_merge($this->dataProvider->getFullNameArguments()[0][0], $this->getExceptedArguments());
    }

    public function getExceptedArguments(): array
    {
        return [
            $this->dataProvider->getAbbreviationArguments()[0][0]
        ];
    }

    public function getArgumentsToOverride(): array
    {
        return $this->dataProvider->getAbbreviationsArguments()[0][0];
    }
}
