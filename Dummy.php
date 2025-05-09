<?php

declare(strict_types=1);

if (!function_exists('boolean')) {
    /**
     * Get the value of a boolean.
     *
     * @return bool
     */
    function boolean(): bool
    {
        return call_user_func(
            ['TLB\Dummy\Primitives\Boolean', 'random']
        );
    }
}

if (!function_exists('phrase')) {
    /**
     * Get the value of a phrase.
     *
     * @param int $wordLength
     *
     * @return string
     */
    function phrase(int $wordLength = 10): string
    {
        $phrase = call_user_func(
            ['TLB\Dummy\Primitives\Str', 'phrase'],
            $wordLength
        );

        return $phrase->get();
    }
}

if (!function_exists('word')) {
    /**
     * Get the value of a word.
     *
     * @return string
     */
    function word(): string
    {
        $word = call_user_func(
            ['TLB\Dummy\Primitives\Str', 'word']
        );

        return $word->get();
    }
}

if (!function_exists('number')) {
    /**
     * Get the value of a number.
     *
     * @param int $length
     *
     * @return string
     */
    function number(int $length): string
    {
        $number = call_user_func(
            ['TLB\Dummy\Primitives\Str', 'number'],
            $length
        );

        return $number->get();
    }
}

if (!function_exists('alphaNum')) {
    /**
     * Get the value of an alphaNum.
     *
     * @param int $min
     * @param int $max
     * @param string $symbols
     *
     * @return string
     */
    function alphaNum(int $min = 1, int $max = 50, string $symbols = ''): string
    {
        $alphaNumb = call_user_func(
            ['TLB\Dummy\Primitives\Str', 'alphaNum'],
            $min,
            $max,
            $symbols
        );

        return $alphaNumb->get();
    }
}

if (!function_exists('random_string')) {
    /**
     * Get the value of a random string.
     *
     * @param string|null $mask
     * @param int $min
     * @param int $max
     *
     * @return string
     */
    function random_string(?string $mask = null, int $min = 1, int $max = 50): string
    {
        $randomString = call_user_func(
            ['TLB\Dummy\Primitives\Str', 'random'],
            $mask,
            $min,
            $max
        );

        return $randomString->get();
    }
}

if (!function_exists('regex')) {
    /**
     * Get the value of a regex.
     *
     * @param string $regex
     *
     * @return string
     */
    function regex(string $regex): string
    {
        $regex = call_user_func(
            ['TLB\Dummy\Primitives\Str', 'fromRegex'],
            $regex
        );

        return $regex->get();
    }
}

if (!function_exists('constant')) {
    /**
     * Get the value of a constant.
     *
     * @param string $value
     *
     * @return mixed
     */
    function constant(mixed $value): mixed
    {
        return $value;
    }
}

if (!function_exists('always_true')) {
    /**
     * Get the value of always true.
     *
     * @param mixed ...$args
     * @return bool
     */
    function always_true(mixed ...$args): bool
    {
        return constant(true);
    }
}

if (!function_exists('always_false')) {
    /**
     * Get the value of always false.
     *
     * @param mixed ...$args
     * @return bool
     */
    function always_false(mixed ...$args): bool
    {
        return constant(false);
    }
}

if (!function_exists('noop')) {
    /**
     * Get the value of noop.
     *
     * @param mixed ...$args
     * @return void
     */
    function noop(mixed ...$args): void
    {
    }
}

if (!function_exists('optional')) {
    /**
     * Get the value of optional.
     *
     * @param mixed $value
     * @return mixed
     */
    function optional(mixed $value): mixed
    {
        $dataGenerator = call_user_func(
            ['TLB\Dummy\DataGenerator', 'get']
        );

        return $dataGenerator->randomElement([$value, null]);
    }
}

if (!function_exists('integer')) {
    /**
     * Get the value of an integer.
     *
     * @param int $min
     * @param int $max
     *
     * @return int
     */
    function integer(int $min = TLB\Dummy\Primitives\Integer::MIN, int $max = TLB\Dummy\Primitives\Integer::MAX): int
    {
        $integer = call_user_func(
            ['TLB\Dummy\Primitives\Integer', 'random'],
            $min,
            $max
        );

        return $integer->get();
    }
}

if (!function_exists('zero')) {
    /**
     * Get a zero.
     *
     * @return int
     */
    function zero(): int
    {
        return 0;
    }
}

if (!function_exists('decimal')) {
    /**
     * Get the value of a decimal.
     *
     * @param float $min
     * @param float $max
     *
     * @return float
     */
    function decimal(float $min, float $max): float
    {
        $decimal = call_user_func(
            ['TLB\Dummy\Primitives\Decimal', 'between'],
            $min,
            $max
        );

        return $decimal->get();
    }
}

if (!function_exists('false')) {
    /**
     * Get the value of false.
     *
     * @return false
     */
    function false(): false
    {
        return false;
    }
}

if (!function_exists('true')) {
    /**
     * Get the value of true.
     *
     * @return true
     */
    function true(): true
    {
        return true;
    }
}

if (!function_exists('nan')) {
    /**
     * Get a NaN.
     *
     * @return float
     */
    function nan(): float
    {
        return NAN;
    }
}

if (!function_exists('guid_v4')) {
    /**
     * Get a UUID v4.
     *
     * @return string
     */
    function guid_v4(): string
    {
        $identifier = call_user_func(
            ['TLB\Dummy\Misc\Identifier', 'uuid4'],
        );

        return $identifier->get();
    }
}

if (!function_exists('guid_v7')) {
    /**
     * Get a UUID v7.
     *
     * @return string
     */
    function guid_v7(): string
    {
        $identifier = call_user_func(
            ['TLB\Dummy\Misc\Identifier', 'uuid7'],
        );

        return $identifier->get();
    }
}

if (!function_exists('name')) {
    /**
     * Get the value of a first name.
     *
     * @param ?string $gender
     *
     * @return string
     */
    function name(?string $gender = null): string
    {
        if ($gender !== null && !in_array($gender, ['male', 'female'])) {
            throw new InvalidArgumentException('Invalid gender');
        }

        $firstName = call_user_func(
            ['TLB\Dummy\Person\Name', 'firstName'],
            $gender
        );

        return $firstName->get();
    }
}

if (!function_exists('surname')) {
    /**
     * Get the value of a last name.
     *
     * @return string
     */
    function surname(): string
    {
        $lastName = call_user_func(
            ['TLB\Dummy\Person\Name', 'lastName'],
        );

        return $lastName->get();
    }
}

if (!function_exists('mobile_phone')) {
    /**
     * Get the value of a mobile phone.
     *
     * @return string
     */
    function mobile_phone(): string
    {
        $phoneNumber = call_user_func(
            ['TLB\Dummy\Contact\PhoneNumber', 'mobile'],
        );

        return $phoneNumber->spanish()->get();
    }
}

if (!function_exists('email')) {
    /**
     * Get the value of an email address.
     *
     * @return string
     */
    function email(): string
    {
        $email = call_user_func(
            ['TLB\Dummy\Internet\Email', 'random'],
        );

        return $email->get();
    }
}

if (!function_exists('sha256')) {
    /**
     * Get the value of a sha256 hash.
     *
     * @return string
     */
    function sha256(): string {
        return call_user_func(
            ['\Faker\Provider\Miscellaneous', 'sha256'],
        );
    }
}

if (!function_exists('random')) {
    /**
     * Get the value of a random.
     *
     * @param mixed ...$args
     * @return mixed
     */
    function random(mixed ...$args): mixed
    {
        return call_user_func(
            ['TLB\Dummy\Misc\Utils', 'randomElement'],
            $args
        );
    }
}