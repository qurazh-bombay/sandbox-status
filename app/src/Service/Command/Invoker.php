<?php
declare(strict_types = 1);

namespace App\Service\Command;

use App\Service\Bot\Parser\TelegramRequest;

final class Invoker
{
    private CommandInterface $command;

    public function setCommand(CommandInterface $command): self
    {
        $this->command = $command;

        return $this;
    }

    public function execute(TelegramRequest $request): void
    {
        $this->command->execute($request);
    }
}