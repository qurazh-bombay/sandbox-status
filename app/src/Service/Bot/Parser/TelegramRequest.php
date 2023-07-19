<?php
declare(strict_types = 1);

namespace App\Service\Bot\Parser;

class TelegramRequest
{
    public ?int $updateId = null;

    public ?int $chatId = null;

    public ?array $rawData = null;

    public ?array $userInfo = null;

    public ?string $content = null;
}
