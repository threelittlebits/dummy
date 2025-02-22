<?php

declare(strict_types=1);

namespace TLB\Dummy\Internet\Exceptions;

use TLB\Dummy\DummyException;

final class PasswordException extends \UnexpectedValueException implements DummyException
{
}
