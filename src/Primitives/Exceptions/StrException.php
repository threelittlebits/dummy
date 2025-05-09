<?php

declare(strict_types=1);

namespace TLB\Dummy\Primitives\Exceptions;

use TLB\Dummy\DummyException;

final class StrException extends \InvalidArgumentException implements DummyException
{
}
