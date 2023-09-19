<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\TaskService;

#[AsCommand(
    name: 'start:timer',
    description: 'Start ongoing task',
)]
class StartTimerCommand extends Command
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('label', InputArgument::REQUIRED, 'Task Name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->taskService->startTask($input->getArgument('label'));

        return Command::SUCCESS;
    }
}
