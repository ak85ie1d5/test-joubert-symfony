<?php

namespace App\Controller;

use App\Repository\RealTimeCommodityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommodityMarketController extends AbstractController
{
    #[Route('/commodity/market', name: 'app_commodity_market')]
    public function index(): Response
    {
        return $this->render('commodity-market.html.twig', [
            'realtime_datas' => ''
        ]);
    }
}
