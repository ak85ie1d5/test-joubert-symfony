<?php

namespace App\Controller;

use App\Repository\RealTimeCommodityRepository;
use App\Service\OptionsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommodityMarketController extends AbstractController
{
    private RealTimeCommodityRepository $realTimeCommodityRepository;

    private OptionsService $optionsService;


    public function __construct(RealTimeCommodityRepository $realTimeCommodityRepository, OptionsService $optionsService)
    {
        $this->realTimeCommodityRepository = $realTimeCommodityRepository;
        $this->optionsService = $optionsService;
    }

    #[Route('/commodity/market', name: 'app_commodity_market')]
    public function index(): Response
    {
        $latestEntries = $this->realTimeCommodityRepository->findLastest($this->optionsService->getMnemonicCommodity());

        return $this->render('commodity-market.html.twig', [
            'realtime_datas' => $latestEntries
        ]);
    }
}
