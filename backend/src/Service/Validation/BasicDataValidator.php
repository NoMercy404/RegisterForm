<?php

namespace App\Service\Validation;

use Symfony\Component\HttpFoundation\JsonResponse;


class BasicDataValidator
{
    public function validate(array $basicData): ?JsonResponse
    {
        // Validate required fields
        if (empty($basicData['firstName']) || empty($basicData['lastName']) || empty($basicData['birthDate'])) {
            return new JsonResponse(['error' => 'Imię, nazwisko i data urodzenia są wymagane'], 400);
        }

        // Validate birth date
        $birthDate = new \DateTime($basicData['birthDate']);
        $today = new \DateTime();

        if ($birthDate >= $today) {
            return new JsonResponse(['error' => 'Data urodzenia musi być wcześniejsza niż dzisiaj'], 400);
        }

        return null; // No validation errors
    }

    public function getBirthDate(array $basicData): \DateTime
    {
        return new \DateTime($basicData['birthDate']);
    }
}

