<?php
declare(strict_types = 1);

namespace App\Service\Command\CommandItem;

use App\Service\Bot\BotService;
use App\Service\Bot\Parser\TelegramRequest;
use App\Service\Command\CommandInterface;
use GuzzleHttp\Exception\GuzzleException;

class UnknownCommand implements CommandInterface
{
    public function __construct(private readonly BotService $bot)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function execute(TelegramRequest $request): void
    {
        $msg = sprintf('Извините, данная команда: "%s" мне не известна', $request->content);

        $this->bot->sendMessage($request->chatId, $msg);
    }
}
