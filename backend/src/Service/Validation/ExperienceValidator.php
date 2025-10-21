<?php

namespace App\Service\Validation;

use Symfony\Component\HttpFoundation\JsonResponse;


class ExperienceValidator
{
    public function validate(array $experiences): ?JsonResponse
    {
        if (empty($experiences)) {
            return null; // No experiences to validate
        }

        $today = new \DateTime();

        foreach ($experiences as $i => $expData) {
            // Validate required fields
            if (empty($expData['company']) || empty($expData['position']) ||
                empty($expData['dateFrom']) || empty($expData['dateTo'])) {
                return new JsonResponse([
                    'error' => "Wpis " . ($i + 1) . ": Wszystkie pola doświadczenia są wymagane"
                ], 400);
            }

            $dateFrom = new \DateTime($expData['dateFrom']);
            $dateTo = new \DateTime($expData['dateTo']);

            // Validate date logic
            if ($dateFrom > $dateTo) {
                return new JsonResponse([
                    'error' => "Wpis " . ($i + 1) . ": Data rozpoczęcia nie może być późniejsza niż data zakończenia"
                ], 400);
            }

            if ($dateFrom > $today) {
                return new JsonResponse([
                    'error' => "Wpis " . ($i + 1) . ": Data rozpoczęcia nie może być późniejsza niż dzisiaj"
                ], 400);
            }
        }

        return null; // No validation errors
    }

    public function normalizeExperienceDates(array $experiences): array
    {
        return array_map(function ($expData) {
            return [
                'company' => $expData['company'],
                'position' => $expData['position'],
                'dateFrom' => new \DateTime($expData['dateFrom']),
                'dateTo' => new \DateTime($expData['dateTo'])
            ];
        }, $experiences);
    }
}

