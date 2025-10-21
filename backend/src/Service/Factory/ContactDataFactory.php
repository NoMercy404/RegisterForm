<?php

namespace App\Service\Factory;

use App\Entity\ContactData;
use App\Entity\Candidate;


class ContactDataFactory
{
    public function create(array $contactData, Candidate $candidate): ContactData
    {
        $entity = new ContactData();
        $entity->setPhone($contactData['phone']);
        $entity->setEmail($contactData['email']);
        $entity->setCandidate($candidate);

        return $entity;
    }
}

