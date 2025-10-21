<?php

namespace App\Controller\Api;

use App\Service\CandidateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/candidates', name: 'api_candidates_')]
class CandidateController extends AbstractController
{
    public function __construct(
        private readonly CandidateService $candidateService
    ) {}

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return new JsonResponse(['error' => 'Nieprawidłowy format JSON'], 400);
        }

        return $this->candidateService->createCandidate($data);
    }
}
