<?php

namespace App\Controller;

use App\Repository\RealTimeCommodityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommodityMarketController extends AbstractController
{
    private RealTimeCommodityRepository $realTimeCommodityRepository;


    public function __construct(RealTimeCommodityRepository $realTimeCommodityRepository)
    {
        $this->realTimeCommodityRepository = $realTimeCommodityRepository;
    }

    #[Route('/commodity/market', name: 'app_commodity_market')]
    public function index(): Response
    {
        $latestEntries = $this->realTimeCommodityRepository->findLastest(4);

        return $this->render('commodity-market.html.twig', [
            'realtime_datas' => $latestEntries
        ]);
    }
}
