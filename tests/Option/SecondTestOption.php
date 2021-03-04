<?php

namespace Consolly\Tests\Option;

use Consolly\Option\Option;

/**
 * Class SecondTestOption represents second test option.
 *
 * @package Consolly\Tests\Option
 */
class SecondTestOption extends Option
{
    /**
     * SecondTestOption constructor.
     */
    public function __construct()
    {
        $this->name = 'second';
        $this->abbreviation = 's';
        $this->requiresValue = false;
        $this->required = false;
        $this->indicated = false;
        $this->value = false;
    }
}
