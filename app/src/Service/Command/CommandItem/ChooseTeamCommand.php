<?php
declare(strict_types = 1);

namespace App\Service\Command\CommandItem;

use App\Repository\TeamRepository;
use App\Service\Bot\BotService;
use App\Service\Bot\Menu\MenuService;
use App\Service\Bot\Parser\TelegramRequest;
use App\Service\Command\CommandInterface;
use GuzzleHttp\Exception\GuzzleException;

class ChooseTeamCommand implements CommandInterface
{
    public function __construct(private readonly BotService $bot, private readonly TeamRepository $teamRepository)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function execute(TelegramRequest $request): void
    {
        $menu = $this->createMenu();

        $this->bot->sendMessage($request->chatId, 'Выберите команду', $menu);
    }

    private function createMenu(): array
    {
        $menuItems = $this->teamRepository->findAll();

        return MenuService::createTeamMenu($menuItems);
    }
}
