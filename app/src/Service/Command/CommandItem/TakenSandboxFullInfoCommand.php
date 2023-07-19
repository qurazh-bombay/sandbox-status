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

class TakenSandboxFullInfoCommand implements CommandInterface
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
            $takenSandboxes = $this->kaitenService->fetchTakenSandboxes($teamSettings);

            $this->bot->sendMessage($request->chatId, $this->getMessage($takenSandboxes));
        } catch (InvalidArgumentException $e) {
            $this->bot->sendMessage($request->chatId, $e->getMessage());
        }
    }

    private function getMessage(array $takenSandboxes): string
    {
        $response = [];

        foreach ($takenSandboxes as $item) {
            $response[] = $this->kaitenService->getHtml($item);
        }

        return empty($takenSandboxes)
            ? 'Все песочки свободны.'
            : implode("\n---------------\n", $response);
    }
}
