<?php
declare(strict_types = 1);

namespace App\Service\Command\CommandItem;

use App\Service\Bot\BotService;
use App\Service\Bot\Parser\TelegramRequest;
use App\Service\Command\CommandInterface;
use App\Service\Command\CommandItem\Traits\TeamSettingsTrait;
use App\Service\Kaiten\KaitenService;
use App\Service\UserService;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class FreeSandboxCommand implements CommandInterface
{
    use TeamSettingsTrait;

    public function __construct(
        private readonly BotService    $bot,
        private readonly KaitenService $kaitenService,
        private readonly UserService   $userService
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function execute(TelegramRequest $request): void
    {
        try {
            $teamSettings   = $this->getTeamSettings($request);
            $freeSandboxIds = $this->kaitenService->fetchFreeSandboxes($teamSettings);

            $this->bot->sendMessage($request->chatId, $this->getMessage($freeSandboxIds));
        } catch (InvalidArgumentException $e) {
            $this->bot->sendMessage($request->chatId, $e->getMessage());
        }
    }

    private function getMessage(array $freeSandboxIds): string
    {
        return empty($freeSandboxIds)
            ? 'Нет свободных песочек.'
            : sprintf('Свободные песочки: %s.', implode(', ', $freeSandboxIds));
    }
}
