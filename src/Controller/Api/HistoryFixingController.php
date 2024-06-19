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

    #[Route('/api/history-fixing/{period}', name: 'app_api_history_fixing', methods: ['GET', 'HEAD'])]
    public function index(string $period): JsonResponse
    {
        $filteringByPeriod = $this->historyFixingRepository->filteringByPeriod($period);

        $datasets = [];
        $labels = [];
        foreach ($filteringByPeriod as $entry) {
            $metal = $entry->getMetal();
            $datasets[$metal]['label'] = $metal;
            $datasets[$metal]['data'][] = $entry->getOpenPrice();
            $datasets[$metal]['borderWidth'] = 1;

            $labels[] = date('d/m/Y', $entry->getOpenTime());
        }

        // Reset array keys
        $datasets = array_values($datasets);

        $response = [
            'labels' => $labels,
            'datasets' => $datasets,
        ];

        return new JsonResponse($response);
    }
}
