<?php
declare(strict_types = 1);

use App\Debug\DebugException;

function debug(mixed $payload, bool $withDebugType = false): void
{
    throw new DebugException($payload, $withDebugType);
}
