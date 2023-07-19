<?php
declare(strict_types = 1);

namespace App\Service\Bot\KeyBoard;

class Row implements KeyBoardInterface
{
    private array $buttons = [];

    public function add(Button ...$buttons): self
    {
        foreach ($buttons as $button) {
            $this->buttons[] = $button;
        }

        return $this;
    }

    public function toArray(): array
    {
        return array_map(fn(Button $button) => $button->toArray(), $this->buttons);
    }
}
