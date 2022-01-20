<?php

namespace App\Services;

use App\Entity\Ad;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

final class AdQualityFilter
{
    const RELEVANT_SCORE = 40;

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function irelevantAdsForQualityDepartment(): float|int|array|string
    {
        $irrelevantsAds = $this->entityManager->getRepository(Ad::class)->findIrelevantAds(self::RELEVANT_SCORE);
        return $this->format($irrelevantsAds);
    }


    public function relevantAdsForUser(): float|int|array|string
    {
        $relevantAds = $this->entityManager->getRepository(Ad::class)->findRelevantAds(self::RELEVANT_SCORE);
        return $this->format($relevantAds);
    }

    public function format($ads): array
    {
        $adsFormatter = [];

        foreach ($ads as $ad)
        {
            $adsFormatter[] = [
                'id'               => $ad->getId(),
                'typology'         => $ad->getTipology(),
                'description'      => $ad->getDescription(),
                'size'             => $ad->getSize(),
                'garden-size'      => $ad->getGardenSize(),
                'irrelevant-since' => $ad->getIrrelevantSince(),
                'score'            => $ad->getScore()
            ];
        }

        return $adsFormatter;
    }
}