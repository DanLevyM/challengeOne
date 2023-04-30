<?php

namespace App\Controller;

use Stripe\Charge;
use Stripe\Stripe;
use App\Entity\Seance;
use App\Entity\Ticket;
use Psr\Log\LoggerInterface;
use App\Service\JwtAuthService;
use App\Repository\SeanceRepository;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class PaymentController extends AbstractController
{
    public function __construct(
        private SeanceRepository $seanceRepo,
        // private UserRepository $userRepo,
        private SubscriptionRepository $subRepo,
        private RequestStack $requestStack,
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
        private JwtAuthService $jwtAuthService,
        // private PaymentService $paymentService,
    ) {
    }

    public function __invoke(Request $request)
    {
        $seanceId = $request->get('id');

        // 1. Vérifier si la seance passée en paramètre de mon url existe et ne soit dépassée (en date) et qu'elle n'ait pas lieu dans plus de 7 jours. Si c'est le cas on renvoie un code api avec un message suivant le cas pour le renvoyer au front
        if (!(is_numeric($seanceId) && (int)$seanceId == $seanceId)) {
            return $this->json(['message' => 'Cette séance n\'a pas été trouvée'], 400);
        }

        $seance = $this->seanceRepo->find($seanceId);
        if (!$seance) {
            return $this->json(['message' => 'Cette séance n\'a pas été trouvée'], 404);
        }

        $today = new \DateTime();
        $seanceDate = $seance->getDate();
        $seanceLimitDate = (new \DateTime())->modify('+7 days');

        if ($seanceDate < $today || $seanceDate > $seanceLimitDate) {
            return $this->json(['message' => 'La séance est dépassée ou aura lieu dans plus de 7 jours.'], 400);
        }

        /* 2. Vérifier qu'il reste des places dans la salle */
        $remainingSeats = $this->seanceRepo->countRemainingSeatsForSession($seance);
        if ($remainingSeats <= 0) {
            return  $this->json(['message' => 'Toutes les places de la salle sont déjà réservées !'], 400);
        }

        /* 3. Vérifier si user est connecté
                A. Si pas connecté on le redirige sur la page de login puis on reprend le workflow */
        $user = $this->jwtAuthService->isAuthenticated();
        if (!$user) {
            return $this->json([], 302);
        }

        /*B. Si connecté */
        $subscription = $this->subRepo->findActiveSubscriptionByUser($user);

            // a . Si user n'a pas d'abonnement
            if (!$subscription) {
                // On vérifie que la séance a lieu 2 jours ou moins avant aujourd'hui
                $isSessionValid = $this->isSessionValid($seance);
                $price = $seance->getPrice();
                if (!$isSessionValid) {
                    return $this->json(['message' => 'Cette séance a lieu dans plus de 2 jours ! Abonnez-vous pour pouvoir réserver vos séances une semaine à l\'avance !'], 400);
                } 
            }
            // b. Si user a un abonnement découverte alors on applique - 20% sur le prix de la séance et on procède au paiement
            if ($subscription->getType() === "Offre Découverte") {
                $price = $seance->getPrice() * 80/100;
            } else if ($subscription->getType() === "Offre Drol") {
                // c. Si user a un abonnement drol il n'a pas besoin de payer fin du workflow
                return $this->createTicket($price, $seance);
            }

            $this->payment($request, $price);
            return $this->createTicket($price, $seance);
    }

    public function isSessionValid(Seance $session): bool
    {
        $sessionDate = $session->getDate();
        $today = new \DateTime();
        $diff = $today->diff($sessionDate);
        return $diff->days <= 2;
    }

    public function payment(Request $request, float $price): JsonResponse
    {
        try {
            // Charge the customer using Stripe
            Stripe::setApiKey($_ENV['STRIPE_SK']);
            Charge::create([
                "amount" => floatval($price) * 100,
                "currency" => "eur",
                "source" => json_decode($request->getContent())->stripeToken,
                "description" => "Payment for seance"
            ]);

            return $this->json(['message' => 'Payment successful'], 201);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return $this->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function createTicket(float $price, Seance $seance) :JsonResponse {
        $ticket = new Ticket();
        $ticket->setPrice($price);
        $ticket->setUserId($this->getUser());
        $ticket->setQuantity(1);
        $ticket->setSeanceId($seance);

        $this->entityManager->persist($ticket);
        $this->entityManager->flush();

        return $this->json(['message' => 'Ticket created'], 201);
    }
}
