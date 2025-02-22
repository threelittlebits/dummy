<?php

declare(strict_types=1);

namespace Tests\TLB\Dummy\Internet;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TLB\Dummy\Internet\Url;

final class UrlTest extends TestCase
{
    #[Test]
    public function random_shouldReturnAValidUrl(): void
    {
        $url = Url::random()->get();

        $this->assertTrue($this->isValid($url));
    }

    #[Test]
    public function random_shouldReturnAnExampleUrl(): void
    {
        $url = Url::example();

        $this->assertMatchesRegularExpression('/^https:\/\/example\.(com|org|net)$/', $url);
    }

    private function isValid(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}
