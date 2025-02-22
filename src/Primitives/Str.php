<?php

declare(strict_types=1);

namespace TLB\Dummy\Primitives;

use TLB\Dummy\DataGenerator;
use TLB\Dummy\Primitives\Exceptions\StrException;
use TLB\Dummy\StringBuilder;

class Str extends StringBuilder
{
    /**
     * Generates a random string with a given length.
     *
     * @param int $wordLength
     * @return Str
     */
    public static function phrase(int $wordLength = 10): Str
    {
        return new self(DataGenerator::get()->sentence($wordLength));
    }

    /**
     * Generates a random word.
     *
     * @return Str
     */
    public static function word(): Str
    {
        return new self(DataGenerator::get()->word());
    }

    public static function fromRegex(string $regex): Str
    {
        return new self(DataGenerator::get()->regexify($regex));
    }

    public static function number(int $length): Str
    {
        if ($length < 1) {
            throw new StrException('Length must be greater than 0');
        }

        return new self(DataGenerator::get()->numerify(str_repeat('#', $length)));
    }

    public static function alphaNum(int $min = 1, int $max = 50, string $symbols = ''): Str
    {
        if ($min < 1) {
            throw new StrException('Min must be greater than 0');
        }

        if ($max < 1) {
            throw new StrException('Max must be greater than 0');
        }

        $min = min($min, $max);
        $max = max($min, $max);

        $pattern = '[A-Za-z0-9';
        if (!empty($symbols)) {
            $pattern .= preg_quote($symbols, '/');
        }
        $pattern .= ']';

        $count = Integer::random($min, $max);

        $pattern .= '{' . $count . '}';

        return self::regex($pattern);
    }

    public static function regex(string $pattern): Str
    {
        return new self(DataGenerator::get()->regexify($pattern));
    }

    public static function random(?string $mask = null, int $min = 1, int $max = 50): Str
    {
        if ($mask === null) {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < rand($min, $max); ++$i) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            return new self($randomString);
        }

        if ($mask === '') {
            $str = DataGenerator::get()->lexify('????????');
        } else if (!str_contains($mask, '?') && !str_contains($mask, '#')) {
            $str = $mask;
        } else {
            $str = DataGenerator::get()->bothify($mask);
        }

        return new self($str);
    }
}
