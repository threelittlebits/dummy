<?php

declare(strict_types=1);

namespace Tests\TLB\Dummy\Internet;

use PHPUnit\Framework\TestCase;
use TLB\Dummy\Internet\Email;

final class EmailTest extends TestCase
{
    /** @test */
    public function example_shouldGenerateASaveEmailAddress(): void
    {
        $email = Email::example();

        $address = $email->get();

        $this->assertTrue($this->isValid($address));
        $this->assertTrue($this->isSafe($address));
    }

    /** @test */
    public function random_shouldGenerateAValidEmailAddress()
    {
        $email = Email::random();

        $this->assertTrue($this->isValid($email->get()));
    }

    private function isValid(string $address): bool
    {
        return filter_var($address, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function isSafe(string $email): bool
    {
        return str_ends_with($email, '@example.com')
            || str_ends_with($email, '@example.org')
            || str_ends_with($email, '@example.net');
    }
}
