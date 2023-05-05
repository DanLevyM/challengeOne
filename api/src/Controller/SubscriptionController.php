<?php

namespace App\Controller;

use App\Service\JwtAuthService;
use App\Repository\SubscriptionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class SubscriptionController extends AbstractController
{
    public function __construct(
        private SubscriptionRepository $subRepo,
        private JwtAuthService $jwtAuthService,
    ) {}

    public function __invoke(): JsonResponse
    {
        $user = $this->jwtAuthService->isAuthenticated();
        if (!$user) {
            return $this->json(['message' => 'Not connected'], 302);
        }
        
        $subscription = $this->subRepo->findActiveSubscriptionByUser($user);

        if (!$subscription) {
            return $this->json(['message' => 'No active subscription found.'], 404);
        } else if ($subscription->getType() === "Offre Découverte") {
            return ($this->json(['message' => 'Offre Découverte'], 200));
        } else if ($subscription->getType() === "Offre Drol") {
            return ($this->json(['message' => 'Offre Drol'], 200));
        }
        
    }
}
