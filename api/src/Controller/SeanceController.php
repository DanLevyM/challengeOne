<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class SeanceController extends AbstractController
{
    public function __construct(
) {}
    public function __invoke(Request $request): array
    {
        $date = $request->query->get('date');
        // Récupération des séances par jour à partir de la date fournie...
        return []; // Retourner les séances au format souhaité
    }
}
