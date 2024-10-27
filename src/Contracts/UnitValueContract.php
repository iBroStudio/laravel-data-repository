<?php

namespace IBroStudio\DataRepository\Contracts;

interface UnitValueContract
{
    public function value(): string;

    public static function unit(): ?string;
}
