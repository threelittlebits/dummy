<?php

namespace TLB\Dummy;

abstract class StringBuilder extends Builder
{
    protected function __construct(protected string $str)
    {
    }

    public static function blank(): string
    {
        return '';
    }

    public function get(): string
    {
        return $this->str;
    }
}