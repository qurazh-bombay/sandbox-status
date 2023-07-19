<?php
declare(strict_types = 1);

namespace App\Service\Command\CommandItem;

use App\Service\Bot\BotService;
use App\Service\Bot\Parser\TelegramRequest;
use App\Service\Command\CommandInterface;
use App\Service\Kaiten\KaitenService;
use GuzzleHttp\Exception\GuzzleException;

class StartCommand implements CommandInterface
{
    public function __construct(private readonly BotService $bot, private readonly KaitenService $kaitenService)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function execute(TelegramRequest $request): void
    {
        $url = 'https://cs.pikabu.ru/post_img/2013/04/07/0/1365278930_1698563458.jpg';
        $msg = 'Я бот, который менеджерит статус песочек команды улучшения продукта. Список команд доступен по /help';

        $this->kaitenService->isUrlAvailable($url)
            ? $this->bot->sendImage($request->chatId, $msg, $url) : $this->bot->sendMessage($request->chatId, $msg);
    }
}
