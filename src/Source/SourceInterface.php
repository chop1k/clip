<?php

namespace Consolly\Source;

/**
 * Interface SourceInterface provides functionality needed for getting an arguments.
 *
 * @package Consolly\Source
 */
interface SourceInterface
{
    /**
     * Returns array of arguments which will be transferred to a distributor.
     *
     * @return array
     */
    public function getArguments(): array;
}
