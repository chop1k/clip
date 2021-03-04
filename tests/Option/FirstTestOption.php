<?php

namespace Consolly\Tests\Option;

use Consolly\Option\Option;

/**
 * Class FirstTestOption represents first test option.
 *
 * @package Consolly\Tests\Option
 */
class FirstTestOption extends Option
{
    /**
     * FirstTestOption constructor.
     */
    public function __construct()
    {
        $this->name = 'first';
        $this->abbreviation = 'f';
        $this->requiresValue = false;
        $this->required = false;
        $this->indicated = false;
        $this->value = false;
    }
}
