<?php
declare(strict_types = 1);

namespace App\Service\Command;

use App\Repository\TeamRepository;
use App\Service\Bot\BotService;
use App\Service\Command\CommandItem\ChooseTeamCommand;
use App\Service\Command\CommandItem\FreeSandboxCommand;
use App\Service\Command\CommandItem\HelpCommand;
use App\Service\Command\CommandItem\SetChosenTeamCommand;
use App\Service\Command\CommandItem\StartCommand;
use App\Service\Command\CommandItem\TakenSandboxCommand;
use App\Service\Command\CommandItem\TakenSandboxFullInfoCommand;
use App\Service\Command\CommandItem\UnknownCommand;
use App\Service\Kaiten\KaitenService;
use App\Service\UserService;

class CommandFactory
{
    public function __construct(
        private readonly BotService     $bot,
        private readonly KaitenService  $kaitenService,
        private readonly TeamRepository $teamRepository,
        private readonly UserService    $userService
    ) {
    }

    public function create(string $command): CommandInterface
    {
        return match ($command) {
            '/start' => new StartCommand($this->bot, $this->kaitenService),
            '/help' => new HelpCommand($this->bot),
            '/free' => new FreeSandboxCommand($this->bot, $this->kaitenService, $this->userService),
            '/taken' => new TakenSandboxCommand($this->bot, $this->kaitenService, $this->userService),
            '/taken_f' => new TakenSandboxFullInfoCommand($this->bot, $this->kaitenService, $this->userService),
            '/choose_team' => new ChooseTeamCommand($this->bot, $this->teamRepository),
            '/optimize', '/improvement', '/content', '/interest', '/expansion', '/engineer' => new SetChosenTeamCommand($this->bot, $this->userService),
            default => new UnknownCommand($this->bot)
        };
    }
}
