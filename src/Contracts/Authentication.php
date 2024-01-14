<?php

namespace IBroStudio\DataRepository\Contracts;

interface Authentication
{
    public function toDecryptedArray(): array;
}
