<?php

declare(strict_types=1);

namespace TLB\Dummy;

abstract class Builder implements \Stringable
{
    abstract public function get(): int|string|float|array|\DateTimeInterface;

    public function getOrNull(): int|string|float|array|\DateTimeInterface|null
    {
        return DataGenerator::get()->randomElement([$this->get(), null]);
    }

    public function getOrEmpty(): int|string|float|array|\DateTimeInterface
    {
        $value = $this->get();
        $emptyResult = '';

        if (is_int($value) || is_float($value)) {
            $emptyResult = 0;
        }

        if (is_array($value)) {
            $emptyResult = [];
        }

        return DataGenerator::get()->randomElement([$this->get(), $emptyResult]);
    }

    public function __toString(): string
    {
        return (string) $this->get();
    }
}
