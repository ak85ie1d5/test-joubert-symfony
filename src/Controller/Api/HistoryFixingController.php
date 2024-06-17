<?php

namespace App\Controller\Api;

use App\Repository\HistoryFixingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class HistoryFixingController extends AbstractController
{
    private HistoryFixingRepository $historyFixingRepository;

    public function __construct(HistoryFixingRepository $historyFixingRepository)
    {
        $this->historyFixingRepository = $historyFixingRepository;
    }

    #[Route('/api/history-fixing/{start_date}/{period}', name: 'app_api_history_fixing', methods: ['GET', 'HEAD'])]
    public function index(string $start_date, string $period): JsonResponse
    {
        $filteringByPeriod = $this->historyFixingRepository->filteringByPeriod($start_date, $period);

        $filteringByPeriodArray = array_map(function ($entry) {
            return [
                'id' => $entry->getId(),
                'open_price' => $entry->getOpenPrice(),
                'metal' => $entry->getMetal(),
                'open_time' => $entry->getOpenTime(),
                'currency' => $entry->getCurrency(),
            ];
        }, $filteringByPeriod);

        return new JsonResponse($filteringByPeriodArray);
    }
}
