<?php
declare(strict_types = 1);

namespace App\Command;

use App\Service\Bot\BotService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:bot-webhook')]
class BotWebhookCommand extends Command
{
    public function __construct(private readonly BotService $botService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('set')
            ->addOption('delete');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $response = [];

            if ($input->getOption('set')) {
                $response = $this->botService->setWebHook();
            } elseif ($input->getOption('delete')) {
                $response = $this->botService->deleteWebHook();
            }

            $output->writeln($response);

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln($e->getMessage());

            return Command::FAILURE;
        }
    }
}
