<?php

namespace App\Command;

use App\Entity\HistoryFixing;
use App\Service\GoldApiService;
use App\Service\OptionsService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:history-fixing',
    description: 'Add a short description for your command',
)]
class HistoryFixingCommand extends Command
{
    private GoldApiService $goldApiService;

    private EntityManagerInterface $entityManager;

    private OptionsService $optionsService;

    public function __construct(GoldApiService $goldApiService, EntityManagerInterface $entityManager, OptionsService $optionsService)
    {
        parent::__construct();
        $this->goldApiService = $goldApiService;
        $this->entityManager = $entityManager;
        $this->optionsService = $optionsService;
    }

    protected function configure(): void
    {
        $this->setDescription('Get the historical data from the API and store it in the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $data = $this->goldApiService->sendRequestToApi("{$this->optionsService->getApiUrl()}/status");

            if (!$data['error']) {
                // Get the current date
                $currentDate = new \DateTimeImmutable();

                // Check if it's the first time the command is running
                $firstRun = $this->entityManager->getRepository(HistoryFixing::class)->findAll() === [];

                if ($firstRun) {
                    // If it's the first run, fetch the data for the past year
                    for ($i = 0; $i < 365; $i++) {
                        $this->fetchAndStoreData($currentDate->modify('-' . $i . ' days'), $io);
                    }
                } else {
                    // If it's not the first run, fetch the daily data
                    $this->fetchAndStoreData($currentDate, $io);
                }
            }

            $io->success(print_r($data, true));
            return Command::SUCCESS;
        } catch (Exception $e) {
            $io->error('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * @throws Exception
     */
    private function fetchAndStoreData(\DateTimeImmutable $date, SymfonyStyle $io): void
    {
        $formattedDate = $date->format('Ymd');

        foreach ($this->optionsService->getMnemonicCommodity() as $metal) {
            $data = $this->goldApiService->sendRequestToApi("{$this->optionsService->getApiUrl()}/{$metal}/{$this->currency}/{$formattedDate}");

            $historyFixing = new HistoryFixing();
            $historyFixing->setMetal($metal);
            $historyFixing->setCurrency($this->optionsService->getMnemonicCurrency());
            $historyFixing->setOpenPrice($data['open_price']);
            $historyFixing->setOpenTime($data['open_time']);

            $this->entityManager->persist($historyFixing);
        }

        $this->entityManager->flush();
    }
}
