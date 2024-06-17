<?php

namespace App\Controller\Api;

use App\Repository\RealTimeCommodityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class RealTimeCommodityController extends AbstractController
{
    private RealTimeCommodityRepository $realTimeCommodityRepository;

    public function __construct(RealTimeCommodityRepository $realTimeCommodityRepository)
    {
        $this->realTimeCommodityRepository = $realTimeCommodityRepository;
    }

    #[Route('/api/real-time-commodity/{metal}', name: 'app_api_real_time_commodity', methods: ['GET', 'HEAD'])]
    public function index(string $metal): JsonResponse
    {

        $latestEntries = $this->realTimeCommodityRepository->findLastest([$metal]);

        $latestEntriesArray = array_map(function ($entry) {
            return [
                'id' => $entry->getId(),
                'metal' => $entry->getMetal(),
                'currency' => $entry->getCurrency(),
                'exchange' => $entry->getExchange(),
                'symbol' => $entry->getSymbol(),
                'price' => $entry->getPrice(),
                'time' => $entry->getCreatedAt()->format(DATE_ATOM),
                'price_gram_24k' => $entry->getPriceGram24k(),
                'price_gram_22k' => $entry->getPriceGram22k(),
                'price_gram_21k' => $entry->getPriceGram21k(),
                'price_gram_18k' => $entry->getPriceGram18k(),
                'price_gram_14k' => $entry->getPriceGram14k(),
                'price_gram_10k' => $entry->getPriceGram10k()
            ];
        }, $latestEntries);

        return new JsonResponse($latestEntriesArray);
    }
}
