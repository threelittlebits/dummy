<?php

declare(strict_types=1);

namespace TLB\Dummy\Internet;

use TLB\Dummy\Builder;
use TLB\Dummy\Primitives\Integer;

final class Jwt extends Builder
{
    private const CHARS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-';

    public static function token(): Jwt
    {
        return new self();
    }

    public function get(): string
    {
        $token = [
            'header' => $this->takeChar(),
            'payload' => $this->takeChar(),
            'signature' => $this->takeChar()
        ];

        return implode('.', $token);
    }

    private function takeChar(): string
    {
        $numChars = strlen(self::CHARS);
        $length = Integer::random(20, 100)->get();
        $str = '';

        for ($i = 0; $i < $length; $i++) {
            $str .= self::CHARS[rand(0, $numChars - 1)];
        }

        return str_shuffle($str);
    }
}
