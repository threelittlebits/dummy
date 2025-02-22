<?php

declare(strict_types=1);

namespace TLB\Dummy\Internet;

use TLB\Dummy\Builder;
use TLB\Dummy\Internet\Exceptions\PasswordException;
use TLB\Dummy\Primitives\Boolean;
use TLB\Dummy\Primitives\Integer;

final class Password extends Builder
{
    private const LOWERCASE_CHARS = 'abcdefghijklmnopqrstuvwxyz';
    private const UPPERCASE_CHARS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private const NUMERIC_CHARS = '0123456789';
    private const SPECIAL_CHARS = '_-.#%&/';

    private string $password;
    private string $allChars;

    private int $minLength;
    private int $maxLength;

    private function __construct()
    {
        $this->password = $this->takeChar(self::LOWERCASE_CHARS);
        $this->allChars = self::LOWERCASE_CHARS;
        $this->minLength = 10;
        $this->maxLength = 20;
    }

    public static function aPassword(): Password
    {
        return new self();
    }

    public function withMinLength(int $minLength): Password
    {
        $this->minLength = $minLength;

        return $this;
    }

    public function withMaxLength(int $maxLength): Password
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    public function withCaseDiff(): Password
    {
        $this->password .= $this->takeChar(self::UPPERCASE_CHARS);
        $this->allChars .= self::UPPERCASE_CHARS;

        return $this;
    }

    public function withNumbers(): Password
    {
        $this->password .= $this->takeChar(self::NUMERIC_CHARS);
        $this->allChars .= self::NUMERIC_CHARS;

        return $this;
    }

    public function withSpecialChars(): Password
    {
        $this->password .= $this->takeChar(self::SPECIAL_CHARS);
        $this->allChars .= self::SPECIAL_CHARS;

        return $this;
    }

    public function get(): string
    {
        $this->ensure(
            $this->minLength >= 4,
            'The minimum length must greater than or equal to 4'
        );

        $this->ensure(
            $this->minLength <= $this->maxLength,
            'The minimum length must be less than the maximum length'
        );

        $length = $this->calculatePasswordLength();
        $remainingLength = $length - strlen($this->password);
        for ($i = 0; $i < $remainingLength; $i++) {
            $this->password .= $this->takeChar($this->allChars);
        }

        return str_shuffle($this->password);
    }

    private function calculatePasswordLength(): int
    {
        if ($this->maxLength === $this->minLength) {
            return $this->minLength;
        }

        return Integer::random($this->minLength, $this->maxLength)->get();
    }

    private function takeChar(string $str): string
    {
        assert(!empty($str));

        return $str[rand(0, strlen($str) - 1)];
    }

    public function getOrNull(): ?string
    {
        $returnNull = Boolean::random();

        if ($returnNull) {
            return null;
        }

        return $this->get();
    }

    public function getOrEmpty(): string
    {
        $returnEmpty = Boolean::random();

        if ($returnEmpty) {
            return '';
        }

        return $this->get();
    }

    private function ensure(bool $param, string $description): void
    {
        if (!$param) {
            throw new PasswordException($description);
        }
    }
}
