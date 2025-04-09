<?php

namespace IBroStudio\DataRepository\Enums;

enum ByteUnitEnum: string
{
    case B = 'bytes';
    case kB = 'kilobytes';
    case MB = 'megabytes';
    case GB = 'gigabytes';
    case TB = 'terabytes';
    case PB = 'petabytes';
    case EB = 'exabytes';

    public function getLabel(): string
    {
        return $this->name;
    }
}
