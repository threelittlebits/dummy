<?php

declare(strict_types=1);

namespace Tests\TLB\Dummy\Misc;

use PHPUnit\Framework\TestCase;
use TLB\Dummy\Misc\Identifier;

final class IdentifierTest extends TestCase
{
    /** @test */
    public function uuid4_shouldGenerateAValidUUIDVersion4String(): void
    {
        $pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

        $identifier = Identifier::uuid4();

        $this->assertMatchesRegularExpression($pattern, $identifier->get());
    }
}
