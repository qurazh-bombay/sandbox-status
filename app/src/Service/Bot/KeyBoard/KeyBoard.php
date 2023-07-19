<?php
declare(strict_types = 1);

namespace App\Service\Bot\KeyBoard;

class KeyBoard
{
    private array $rows = [];

    public function getRow(int $key): ?Row
    {
        return $this->rows[$key] ?? null;
    }

    public function clear(): self
    {
        $this->rows = [];

        return $this;
    }

    public function add(Row ...$rows): self
    {
        foreach ($rows as $row) {
            $this->rows[] = $row;
        }

        return $this;
    }

    public function toArray(): array
    {
        return array_map(fn(Row $row) => $row->toArray(), $this->rows);
    }
}
