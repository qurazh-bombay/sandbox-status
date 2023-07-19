<?php
declare(strict_types = 1);

namespace App\Service\Bot\KeyBoard;

class Button implements KeyBoardInterface
{
    public function __construct(private readonly string $text, private readonly string $callbackData)
    {
    }

    public function toArray(): array
    {
        return [
            'text'          => $this->text,
            'callback_data' => $this->callbackData,
        ];
    }
}
