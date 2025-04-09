<?php

namespace IBroStudio\DataRepository\Contracts;

interface Formatter
{
    public static function format(string $value): string;
}
