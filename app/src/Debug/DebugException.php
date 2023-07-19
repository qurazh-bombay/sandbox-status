<?php
declare(strict_types=1);

namespace App\Debug;

use Exception;
use Throwable;

class DebugException extends Exception
{
    public function __construct(public mixed $payload, public bool $withDebugType, $message = '', $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
