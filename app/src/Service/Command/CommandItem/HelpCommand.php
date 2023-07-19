<?php
declare(strict_types = 1);

namespace App\Service\Command\CommandItem;

use App\Service\Bot\BotService;
use App\Service\Bot\Parser\TelegramRequest;
use App\Service\Command\CommandInterface;
use GuzzleHttp\Exception\GuzzleException;

class HelpCommand implements CommandInterface
{
    public function __construct(private readonly BotService $bot)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function execute(TelegramRequest $request): void
    {
        $this->bot->sendMessage($request->chatId, $this->getMessage());
    }

    private function getMessage(): string
    {
        return <<<MSG
Список команд:\n
/start,\n
/choose_team, вызывает меню для выбора команды, в которую входит пользователь\n
/free, показывает список свободных песочек\n
/taken, показывает список занятых песочек\n
/taken_f, показывает подробную информацию по занятым песочкам
MSG;
    }
}
