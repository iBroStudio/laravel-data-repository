<?php

namespace IBroStudio\DataRepository\Contracts;

interface UnitValueContract
{
    public function withUnit(): string;

    public static function unit(): ?string;
}
