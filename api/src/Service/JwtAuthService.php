<?php

namespace App\Service;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use app\Entity\User;
use phpDocumentor\Reflection\Types\Null_;

class JwtAuthService
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private JWTTokenManagerInterface $JWTManager,
        private ManagerRegistry $managerRegistry,
    ){}

    public function isAuthenticated(): ?User
    {
        
        $token = $this->tokenStorage->getToken();

        if (null === $token) {
            return null;
        }

        $dataUser =  $this->JWTManager->decode($this->tokenStorage->getToken());

        $decodedToken = $this->JWTManager->decode($token);

        if ((isset($decodedToken['exp']) && $decodedToken['exp'] < time())) {
            // Token expiré ou décodage échoué
            return null;
        }

        $user = $this->managerRegistry->getRepository(User::class)->findOneBy(['email' => $dataUser['email']]);
        return $user;
    }
}
