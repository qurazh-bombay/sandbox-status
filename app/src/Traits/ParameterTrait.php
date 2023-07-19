<?php
declare(strict_types = 1);

namespace App\Traits;

trait ParameterTrait
{
    protected function getParameter(string $name): array|bool|string|int|float|null
    {
        return $this->params->get($name);
    }
}
