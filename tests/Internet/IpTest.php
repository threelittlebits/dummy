<?php

declare(strict_types=1);

namespace Tests\TLB\Dummy\Internet;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TLB\Dummy\Internet\Ip;

final class IpTest extends TestCase
{
    #[Test]
    public function loopback_shouldReturnAValidLoopbackIp(): void
    {
        $ip = Ip::loopback()->get();

        $this->assertEquals('127.0.0.1', $ip);
        $this->assertTrue($this->isValid($ip));
    }

    #[Test]
    public function unknown_shouldReturnAValidUnknownIp(): void
    {
        $ip = Ip::unknown()->get();

        $this->assertEquals('0.0.0.0', $ip);
        $this->assertTrue($this->isValid($ip));
    }

    #[Test]
    public function local_shouldReturnAValidLocalIp(): void
    {
        $ip = Ip::local()->get();

        $this->assertTrue($this->isLocal($ip));
        $this->assertTrue($this->isValid($ip));
    }

    #[Test]
    public function random_shouldReturnAValidIp(): void
    {
        $ip = Ip::random()->get();

        $this->assertTrue($this->isValid($ip));
    }

    private function isValid(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    private function isLocal(string $ip): bool
    {
        if (str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return true;
        }

        $patternParts = [
            '172\.(1[6-9]|[2][0-9]|3[0-1])\.',
            '(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.',
            '(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)'
        ];

        $pattern = '/^' . implode('', $patternParts). '$/';

        return preg_match($pattern, $ip) === 1;
    }
}
