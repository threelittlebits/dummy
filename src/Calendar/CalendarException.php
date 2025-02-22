<?php

declare(strict_types=1);

namespace TLB\Dummy\Calendar;

use TLB\Dummy\DummyException;

final class CalendarException extends \InvalidArgumentException implements DummyException
{
}
