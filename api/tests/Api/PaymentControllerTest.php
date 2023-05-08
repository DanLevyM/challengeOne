<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use App\Service\PaymentService;
use App\Repository\SeanceRepository;
use App\Service\JwtAuthService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PaymentControllerTest extends WebTestCase
{
    private $client;
    private $kernel;

    public function __construct()
    {
        $this->client = static::createClient();
        $this->kernel = static::bootKernel();
    }

    public function testPaymentWorkflow()
    {
        $client = static::createClient();

        $seanceId = 1;
        $requestUri = '/payment?id=' . $seanceId;
        $request = $this->client->request('GET', $requestUri);

        $container = $this->kernel->getContainer();
        $paymentService = $container->get('App\Service\PaymentService');
        
        
    }
}
