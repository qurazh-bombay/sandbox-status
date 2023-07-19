<?php
declare(strict_types = 1);

namespace App\Service\Command;

use App\Service\Bot\Parser\TelegramRequest;

interface CommandInterface
{
    public function execute(TelegramRequest $request): void;
}
