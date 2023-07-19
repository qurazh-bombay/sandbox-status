<?php
declare(strict_types = 1);

namespace App\Entity\Traits;

/**
 * сущности использующие этот трейт должны содержать HasLifecycleCallbacks в аннотации
 */
trait TimestampTrait
{
    use CreatedAtTrait, UpdatedAtTrait;
}
