<?php
namespace App\Command;

use App\Entity\RealTimeCommodity;
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
    name: 'app:fetch-datas',
    description: 'Fetches data from the API and stores it in the database.',
)]
class FetchDataCommand extends Command
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
        $this->setDescription('Fetches data from the API and stores it in the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $data = $this->goldApiService->sendRequestToApi("{$this->optionsService->getApiUrl()}/status");

            if (!$data['error']) {
                $this->fetchAndStoreData();
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
    private function fetchAndStoreData(): void
    {
        foreach ($this->optionsService->getMnemonicCommodity() as $metal) {

            $data = $this->goldApiService->sendRequestToApi("{$this->optionsService->getApiUrl()}/{$metal}/{$this->optionsService->getMnemonicCurrency()}");

            $realTimeCommodity = new RealTimeCommodity();
            $realTimeCommodity->setMetal($metal);
            $realTimeCommodity->setCurrency($this->optionsService->getMnemonicCurrency());
            $realTimeCommodity->setExchange($data['exchange']);
            $realTimeCommodity->setSymbol($data['symbol']);
            $realTimeCommodity->setPrice($data['price']);

            $datetime = (new \DateTimeImmutable())->setTimestamp($data['timestamp']);
            $realTimeCommodity->setCreatedAt($datetime);

            $realTimeCommodity->setPriceGram24k($data['price_gram_24k']);
            $realTimeCommodity->setPriceGram22k($data['price_gram_22k']);
            $realTimeCommodity->setPriceGram21k($data['price_gram_21k']);
            $realTimeCommodity->setPriceGram20k($data['price_gram_20k']);
            $realTimeCommodity->setPriceGram18k($data['price_gram_18k']);
            $realTimeCommodity->setPriceGram16k($data['price_gram_16k']);
            $realTimeCommodity->setPriceGram14k($data['price_gram_14k']);
            $realTimeCommodity->setPriceGram10k($data['price_gram_10k']);

            $this->entityManager->persist($realTimeCommodity);
        }

        $this->entityManager->flush();
    }
}
