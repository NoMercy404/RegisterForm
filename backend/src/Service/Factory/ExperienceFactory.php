<?php

namespace App\Service\Factory;

use App\Entity\Experience;
use App\Entity\Candidate;


class ExperienceFactory
{
    public function create(array $experienceData, Candidate $candidate): Experience
    {
        $entity = new Experience();
        $entity->setCompany($experienceData['company']);
        $entity->setPosition($experienceData['position']);
        $entity->setDateFrom($experienceData['dateFrom']);
        $entity->setDateTo($experienceData['dateTo']);
        $entity->setCandidate($candidate);

        return $entity;
    }

    /**
     * Create multiple experience entities
     *
     * @param array $experiencesData
     * @param Candidate $candidate
     * @return array<Experience>
     */
    public function createMultiple(array $experiencesData, Candidate $candidate): array
    {
        $experiences = [];

        foreach ($experiencesData as $expData) {
            $experiences[] = $this->create($expData, $candidate);
        }

        return $experiences;
    }
}

