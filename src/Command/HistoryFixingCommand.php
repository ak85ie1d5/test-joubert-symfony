<?php

namespace App\Command;

use App\Entity\HistoryFixing;
use App\Entity\RealTimeCommodity;
use App\Service\GoldApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'App:HistoryFixing',
    description: 'Add a short description for your command',
)]
class HistoryFixingCommand extends Command
{
    private array $metals = ['XAU', 'XAG', 'XPT', 'XPD'];

    private string $currency = "EUR";

    private string $currentDate;

    private GoldApiService $goldApiService;

    private EntityManagerInterface $entityManager;

    public function __construct(GoldApiService $goldApiService, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->goldApiService = $goldApiService;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setDescription('Get the historical data from the API and store it in the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $data = $this->goldApiService->sendRequestToApi("https://www.goldapi.io/api/status");

            $this->currentDate = date('Ymd');

            foreach ($this->metals as $metal) {
                $data = $this->goldApiService->sendRequestToApi("https://www.goldapi.io/api/{$metal}/{$this->currency}/{$this->currentDate}");

                $historyFixing = new HistoryFixing();
                $historyFixing->setMetal($metal);
                $historyFixing->setCurrency($this->currency);
                $historyFixing->setOpenPrice($data['open_price']);
                $historyFixing->setOpenTime($data['open_time']);

                $this->entityManager->persist($historyFixing);
            }

            $this->entityManager->flush();

            $io->success(print_r($data, true));
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
