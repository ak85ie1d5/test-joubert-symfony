<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommodityMarketController extends AbstractController
{
    #[Route('/commodity/market', name: 'app_commodity_market')]
    public function index(): Response
    {
        return $this->render('commodity-market.html.twig', [
            'realtime_datas' => [
                [
                    'metal' => 'Gold',
                    'currency' => 'USD',
                    'exchange' => 'FOREXCOM',
                    'symbol' => 'FOREXCOM:XAUUSD',
                    'price' => 1800,
                    'date' => 1718266266,
                ],
                [
                    'metal' => 'Silver',
                    'currency' => 'USD',
                    'exchange' => 'FOREXCOM',
                    'symbol' => 'FOREXCOM:XAUUSD',
                    'price' => 25,
                    'date' => 1718266266
                ],
                [
                    'metal' => 'Platinum',
                    'currency' => 'USD',
                    'exchange' => 'FOREXCOM',
                    'symbol' => 'FOREXCOM:XAUUSD',
                    'price' => 1000,
                    'date' => 1718266266
                ]
            ]
        ]);
    }
}
