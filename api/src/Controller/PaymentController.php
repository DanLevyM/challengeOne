<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Entity\Ticket;
use App\Repository\SeanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Stripe\Charge;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;


#[AsController]
class PaymentController extends AbstractController
{   
    public function __construct(
        private SeanceRepository $seanceRepo,  
        private RequestStack $requestStack,
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger
    ) {}
    
    public function __invoke(Request $request): JsonResponse
    {        
         // Find the seance by its ID
        $seanceId = $request->get('id');
    
        $seance = $this->seanceRepo->find($seanceId);
        if (!$seance) {
            throw new NotFoundHttpException("Cette séance n'a pas été trouvée");
        }
    
        // Get the Stripe token from the request parameters
        $token = $request->get('token');
        if (!$token) {
            throw new BadRequestHttpException('Token not found');
        }
    
        try {
            // Charge the customer using Stripe
            Stripe::setApiKey($_ENV['STRIPE_SK']);
            $charge = Charge::create([
                "amount" => floatval($seance->getPrice()),
                "currency" => "eur",
                "source" => $token,
                "description" => "Payment for seance"
            ]);
    
            // Create a ticket for the user
            $ticket = new Ticket();
            $ticket->setPrice($seance->getPrice());
            $ticket->setUserId($this->getUser());
            // $user = $this->get('security.token_storage')->getToken()->getUser();
    
            $ticket->setQuantity(1);
            $ticket->setSeanceId($seance);
    
            $this->entityManager->persist($ticket);
            $this->entityManager->flush();
    
            return $this->json([
                'status' => 'success',
                'message' => 'Payment successful',
                'ticket' => $ticket,
                'charge' => $charge
            ]);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return $this->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    



    /* public function __invoke(): JsonResponse
    {        
         // Find the seance by its ID
        $request = $this->requestStack->getCurrentRequest();
        $seanceId = $request->get('id');

        $seance = $this->seanceRepo->find($seanceId);
        if (!$seance) {
            throw new NotFoundHttpException("Cette séance n'a pas été trouvée");
        }

        // Get the Stripe token from the request
        $token = json_decode($request->getContent(), true); // add true as the second parameter to get an associative array
        if (!$token) {
            throw new BadRequestHttpException('Token not found');
        }

        try {
            // Charge the customer using Stripe
            Stripe::setApiKey($_ENV['STRIPE_SK']);
            $charge = Charge::create([
                "amount" => floatval($seance->getPrice()),
                "currency" => "eur",
                "source" => "tok_mastercard",
                "description" => "Payment for seance"
            ]);

            // Create a ticket for the user
            $ticket = new Ticket();
            $ticket->setPrice($seance->getPrice());
            $ticket->setUserId($this->getUser());
            // $user = $this->get('security.token_storage')->getToken()->getUser();

            $ticket->setQuantity(1);
            $ticket->setSeanceId($seance);

            $this->entityManager->persist($ticket);
            $this->entityManager->flush();

            return $this->json([
                'status' => 'success',
                'message' => 'Payment successful',
                'ticket' => $ticket,
                'charge' => $charge
            ]);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return $this->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    } */
}
