<?php
namespace App\Command;

use App\Entity\RealTimeCommodity;
use App\Service\GoldApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'fetchdata',
    description: 'Fetches data from the API and stores it in the database.',
)]
class FetchDataCommand extends Command
{
    private array $metals = ['XAU', 'XAG', 'XPT', 'XPD'];
    private string $currency = "EUR";

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
        $this->setDescription('Fetches data from the API and stores it in the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $data = $this->goldApiService->sendRequestToApi("https://www.goldapi.io/api/status");

            foreach ($this->metals as $metal) {
                $data = $this->goldApiService->sendRequestToApi("https://www.goldapi.io/api/{$metal}/{$this->currency}");

                $realTimeCommodity = new RealTimeCommodity();
                $realTimeCommodity->setMetal($metal);
                $realTimeCommodity->setCurrency($this->currency);
                $realTimeCommodity->setExchange($data['exchange']);
                $realTimeCommodity->setSymbol($data['symbol']);
                $realTimeCommodity->setPrice($data['price']);

                $datetime = (new \DateTimeImmutable())->setTimestamp($data['timestamp']);
                $realTimeCommodity->setCreatedAt($datetime);

                $this->entityManager->persist($realTimeCommodity);
            }

            $this->entityManager->flush();

            //$io->success('Data fetched successfully.');
            //$url = "https://www.goldapi.io/api/{$symbol}/{$this->currency}{$this->date}";
            $io->success(print_r($data, true));
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
