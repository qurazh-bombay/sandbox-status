<?php
declare(strict_types = 1);

namespace App\Service\Command\CommandItem\Traits;

use App\Entity\Team;
use App\Entity\TeamSettings;
use App\Service\Bot\Parser\TelegramRequest;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

trait TeamSettingsTrait
{
    private function getTeamSettings(TelegramRequest $request): TeamSettings
    {
        $team         = $this->userService->getUser($request)?->getTeam();
        $teamSettings = $team?->getTeamSettings();

        if (!$team instanceof Team) {
            throw new InvalidArgumentException('Сначала необходимо выбрать команду /choose_team');
        }

        if (!$teamSettings instanceof TeamSettings) {
            throw new InvalidArgumentException('Для вашей команды не установлены настройки');
        }

        return $teamSettings;
    }
}
