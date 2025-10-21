<?php

namespace App\Service;

use App\Entity\Candidate;
use App\Service\Factory\BasicDataFactory;
use App\Service\Factory\CandidateFactory;
use App\Service\Factory\ContactDataFactory;
use App\Service\Factory\ExperienceFactory;
use App\Service\Validation\BasicDataValidator;
use App\Service\Validation\ContactDataValidator;
use App\Service\Validation\ExperienceValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class CandidateService
{
    public function __construct(
        private readonly BasicDataValidator $basicDataValidator,
        private readonly ContactDataValidator $contactDataValidator,
        private readonly ExperienceValidator $experienceValidator,
        private readonly CandidateFactory $candidateFactory,
        private readonly BasicDataFactory $basicDataFactory,
        private readonly ContactDataFactory $contactDataFactory,
        private readonly ExperienceFactory $experienceFactory,
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function createCandidate(array $data): JsonResponse
    {
        // Validate basic data
        $validationError = $this->basicDataValidator->validate($data['basicData']);
        if ($validationError) {
            return $validationError;
        }

        // Validate contact data
        $validationError = $this->contactDataValidator->validate($data['contactData']);
        if ($validationError) {
            return $validationError;
        }

        // Validate experiences
        $validationError = $this->experienceValidator->validate($data['experiences'] ?? []);
        if ($validationError) {
            return $validationError;
        }

        // Create candidate entity
        $candidate = $this->candidateFactory->create();

        // Create and attach basic data
        $basicData = $this->basicDataFactory->create($data['basicData'], $candidate);
        $candidate->setBasicData($basicData);

        // Create and attach contact data
        $contactData = $this->contactDataFactory->create($data['contactData'], $candidate);
        $candidate->setContactData($contactData);

        // Create and attach experiences
        if (!empty($data['experiences'])) {
            $normalizedExperiences = $this->experienceValidator->normalizeExperienceDates($data['experiences']);
            $experiences = $this->experienceFactory->createMultiple($normalizedExperiences, $candidate);

            foreach ($experiences as $experience) {
                $candidate->getExperiences()->add($experience);
            }
        }

        // Persist to database
        $this->entityManager->persist($candidate);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'success', 'data' => $data]);
    }
}

