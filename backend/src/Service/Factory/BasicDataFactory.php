<?php

namespace App\Service\Factory;

use App\Entity\BasicData;
use App\Entity\Candidate;


class BasicDataFactory
{
    public function create(array $basicData, Candidate $candidate): BasicData
    {
        $entity = new BasicData();
        $entity->setFirstName($basicData['firstName']);
        $entity->setLastName($basicData['lastName']);
        $entity->setBirthDate(new \DateTime($basicData['birthDate']));
        $entity->setCandidate($candidate);

        return $entity;
    }
}

