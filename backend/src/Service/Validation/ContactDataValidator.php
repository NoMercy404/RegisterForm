<?php

namespace App\Service\Validation;

use Symfony\Component\HttpFoundation\JsonResponse;


class ContactDataValidator
{
    private const PHONE_PATTERN = '/^(\+48\s?)?(\d{3}-?\d{3}-?\d{3})$/';

    public function validate(array $contactData): ?JsonResponse
    {
        // Validate required fields
        if (empty($contactData['phone']) || empty($contactData['email'])) {
            return new JsonResponse(['error' => 'Telefon i e-mail są wymagane'], 400);
        }

        // Validate email format
        if (!filter_var($contactData['email'], FILTER_VALIDATE_EMAIL)) {
            return new JsonResponse(['error' => 'Nieprawidłowy e-mail'], 400);
        }

        // Validate phone format
        if (!preg_match(self::PHONE_PATTERN, $contactData['phone'])) {
            return new JsonResponse([
                'error' => 'Nieprawidłowy numer telefonu. Dozwolone formaty: 111222333, 111-222-333, +48 111222333, +48 111-222-333'
            ], 400);
        }

        return null; // No validation errors
    }
}

