<?php

namespace App\Controller;

use App\Services\AdQualityFilter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicAdController extends AbstractController
{
    #[Route('/public/ad', name: 'public_ad')]
    public function index(AdQualityFilter $filter): Response
    {
        $relevantAds = $filter->relevantAdsForUser();

        return $this->json([
            'relevant-ads' => $relevantAds
        ]);
    }
}
