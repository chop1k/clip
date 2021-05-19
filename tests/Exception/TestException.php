<?php

namespace Consolly\Tests\Exception;

use Consolly\ConsollyEvents;
use Exception;

/**
 * Class TestException used for testing {@link ConsollyEvents::EXCEPTION} event`s exception overwriting.
 *
 * @package Consolly\Tests\Exception
 */
class TestException extends Exception
{
}
