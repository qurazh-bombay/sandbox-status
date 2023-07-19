<?php
declare(strict_types = 1);

namespace App\Service\Bot\KeyBoard;

interface KeyBoardInterface
{
    public function toArray(): array;
}
