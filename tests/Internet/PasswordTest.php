<?php

declare(strict_types=1);

namespace Tests\TLB\Dummy\Internet;

use PHPUnit\Framework\TestCase;
use TLB\Dummy\Internet\Exceptions\PasswordException;
use TLB\Dummy\Internet\Password;

final class PasswordTest extends TestCase
{
    /** @test */
    public function get_withMinLengthGreaterThanMaxLength_throwsPasswordException(): void
    {
        $this->expectException(PasswordException::class);

        Password::aPassword()->withMinLength(10)->withMaxLength(5)->get();
    }

    /** @test */
    public function get_withMinLengthLessThanDefaultMinimumLength_throwsPasswordException(): void
    {
        $this->expectException(PasswordException::class);

        Password::aPassword()->withMinLength(3)->get();
    }

    /** @test */
    public function get_withMinLengthEqualsThanMinLength_producesAPasswordWithLengthEqualsToMinLength(): void
    {
        $password = Password::aPassword()->withMinLength(10)->withMaxLength(10)->get();

        $this->assertEquals(10, strlen($password));
    }

    /** @test */
    public function get_withAllConstrains_producesAPasswordConformingToRequiredFormat(): void
    {
        $password = Password::aPassword()
            ->withMinLength(10)
            ->withMaxLength(20)
            ->withCaseDiff()
            ->withNumbers()
            ->withSpecialChars()
            ->get();

        $this->assertTrue(strlen($password) >= 10);
        $this->assertTrue(strlen($password) <= 20);
        $this->assertMatchesRegularExpression('/^[a-zA-Z0-9_\-\.#%&\/]*$/', $password);
    }
}
