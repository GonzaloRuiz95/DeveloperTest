<?php

namespace App\Services;

use App\Entity\Ad;

class AdQualityCalculator
{
    const SHORT_DESCRIPTION_LOW_THRESHOLD  = 20;
    const SHORT_DESCRIPTION_HIGH_THRESHOLD = 49;
    const SHORT_DESCRIPTION_SCORE          = 10;

    const LONG_DESCRIPTION_THRESHOLD       = 50;
    const LONG_DESCRIPTION_SCORE           = 30;

    const KEYWORDS                         = ['Luminoso', 'Nuevo', 'Centrico', 'Reformado', 'Atico'];
    const KEYWORD_OCCURRENCE_SCORE         = 5;

    const HD_IMAGE                         = 'HD';

    const HD_IMAGE_SCORE                   = 20;
    const SD_IMAGE_SCORE                   = 10;

    const NO_IMAGES_SCORE                  = -10;

    const COMPLETE_AD_SCORE                = 40;

    const FLAT_TYPOLOGY                    = 'Piso';
    const CHALET_TYPOLOGY                  = 'Chalet';
    const GARAGE_TYPOLOGY                  = 'Garaje';

    public function __construct()
    {
    }

    public function __invoke(Ad $ad): int
    {
        return ($this->score($ad) <= 0) ? 0 : $this->score($ad);
    }

    public function score($ad): int
    {
        return $this->evaluatePicturesQuality($ad) + $this->evaluateDescriptionQuality($ad) + $this->evaluateCompletenessByTypology($ad);
    }

    public function evaluatePicturesQuality($ad): int
    {
        if (count($ad->getPictures()) === 0){
            return self::NO_IMAGES_SCORE;
        }

        $score = 0;
        foreach ($ad->getPictures() as $picture)
        {
            $score += ($picture->getQuality() === self::HD_IMAGE) ? self::HD_IMAGE_SCORE : self::SD_IMAGE_SCORE;
        }

        return $score;
    }

    public function evaluateDescriptionQuality($ad): int
    {
        if (is_null($ad->getDescription()) || $ad->getTipology() === self::GARAGE_TYPOLOGY){
            return 0;
        }

        $score = 0;
        if ($ad->getTipology() === self::FLAT_TYPOLOGY && strlen($ad->getDescription()) >= self::SHORT_DESCRIPTION_LOW_THRESHOLD && strlen($ad->getDescription()) <= self::SHORT_DESCRIPTION_HIGH_THRESHOLD){
            $score += self::SHORT_DESCRIPTION_SCORE;
        }

        if ($ad->getTipology() === self::CHALET_TYPOLOGY && strlen($ad->getDescription()) >= self::LONG_DESCRIPTION_THRESHOLD) {
            $score += self::LONG_DESCRIPTION_SCORE;
        }

        return $score + $this->findKeywords($ad);
    }

    public function findKeywords($ad): int
    {
        $eachDescriptionWord = explode(' ', $ad->getDescription());

        $score = 0;
        foreach ($eachDescriptionWord as $word)
        {
            if (in_array($word, self::KEYWORDS)) {
                $score += self::KEYWORD_OCCURRENCE_SCORE;
            }
        }

        return $score;
    }

    public function evaluateCompletenessByTypology($ad): int
    {
        $score = 0;
        if ($this->ensureFlatAdFeatures($ad) || $this->ensureChaletAdFeatures($ad) || $this->ensureGarageAdFeatures($ad)){
            $score = self::COMPLETE_AD_SCORE;
        }

        return $score;
    }

    public function ensureFlatAdFeatures($ad): bool
    {
        return ($ad->getTipology() === self::FLAT_TYPOLOGY)
            && !is_null($ad->getDescription())
            && count($ad->getPictures()) > 0
            && (is_null($ad->getSize()) || $ad->getSize() > 0);
    }

    public function ensureChaletAdFeatures($ad): bool
    {
        return ($ad->getTipology() === self::CHALET_TYPOLOGY)
            && !is_null($ad->getDescription())
            && count($ad->getPictures()) > 0
            && (is_null($ad->getSize()) || $ad->getSize() > 0)
            && !is_null($ad->getGardenSize());
    }

    public function ensureGarageAdFeatures($ad): bool
    {
        return ($ad->getTipology() === self::GARAGE_TYPOLOGY) && count($ad->getPictures) > 0;
    }
}