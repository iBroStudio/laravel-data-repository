<?php

namespace IBroStudio\DataRepository\Concerns;

trait ValueObjectToJson
{
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
