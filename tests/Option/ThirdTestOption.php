<?php

namespace Consolly\Tests\Option;

use Consolly\Option\Option;

/**
 * Class ThirdTestOption represents third test option.
 *
 * @package Consolly\Tests\Option
 */
class ThirdTestOption extends Option
{
    /**
     * ThirdTestOption constructor.
     */
    public function __construct()
    {
        $this->name = 'third';
        $this->abbreviation = 't';
        $this->requiresValue = false;
        $this->required = false;
        $this->indicated = false;
        $this->value = false;
    }
}
