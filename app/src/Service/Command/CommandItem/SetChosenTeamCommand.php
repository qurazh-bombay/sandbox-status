<?php
declare(strict_types = 1);

namespace App\Service\Command\CommandItem;

use App\Service\Bot\BotService;
use App\Service\Bot\Parser\TelegramRequest;
use App\Service\Command\CommandInterface;
use App\Service\UserService;
use GuzzleHttp\Exception\GuzzleException;

class SetChosenTeamCommand implements CommandInterface
{
    public function __construct(private readonly BotService $bot, private readonly UserService $userService)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function execute(TelegramRequest $request): void
    {
        $user = $this->userService->setTeam($request);

        $this->bot->sendMessage($request->chatId, sprintf('Вы записаны в команду "%s"', $user->getTeam()->getTitle()));
    }
}
