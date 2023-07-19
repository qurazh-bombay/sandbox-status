<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Team;
use App\Entity\TeamSettings;
use App\Service\Bot\Parser\TelegramRequest;
use App\Service\Command\CommandFactory;
use App\Service\Command\Invoker;
use App\Service\HealthService;
use App\Service\Kaiten\KaitenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    public function taken(Team $team, KaitenService $service): Response
    {
        if (!($teamSettings = $team->getTeamSettings()) instanceof TeamSettings) {
            return new Response('У команды не установлены настройки.');
        }

        return $this->json($service->fetchTakenSandboxes($teamSettings));
    }

    public function free(Team $team, KaitenService $service): Response
    {
        if (!($teamSettings = $team->getTeamSettings()) instanceof TeamSettings) {
            return new Response('У команды не установлены настройки.');
        }

        return $this->json($service->fetchFreeSandboxes($teamSettings));
    }

    public function health(HealthService $service): Response
    {
        $service->checkEnvironmentVariables();

        return new Response('It works');
    }

    public function updates(TelegramRequest $request, Invoker $invoker, CommandFactory $commandFactory): Response
    {
        $input   = $request->content;
        $command = $commandFactory->create($input);
        $invoker->setCommand($command)->execute($request);

        return new Response('Ok');
    }
}
