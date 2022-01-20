<?php

namespace App\Controller;

use App\Services\AdQualityFilter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QualityDeparmentController extends AbstractController
{
    #[Route('/quality/deparment', name: 'quality_deparment')]
    public function index(AdQualityFilter $filter): Response
    {
        $irrelevantAds = $filter->irelevantAdsForQualityDepartment();

        return $this->json([
            'irelevant-ads' => $irrelevantAds
        ]);
    }
}
