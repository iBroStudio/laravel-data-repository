<?php

namespace IBroStudio\DataRepository\Enums;

enum SemanticVersionSegments: string
{
    case MAJOR = 'major';
    case MINOR = 'minor';
    case PATCH = 'patch';
}
