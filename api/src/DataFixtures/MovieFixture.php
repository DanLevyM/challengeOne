<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Movie;

class MovieFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $now = new \DateTime();
        $futureDate = new \DateTime('July 1, 2023');

        for ($i = 1; $i <= 50; $i++) {

            // Générer une date aléatoire entre maintenant et juillet 2023
            $timestamp = rand($now->getTimestamp(), $futureDate->getTimestamp());
            $randomDate = new \DateTime();
            $randomDate->setTimestamp($timestamp);

            $movie = new Movie();
            $movie->setTitle('Le Roi Lion');
            $movie->setDuration(120);
            $movie->setDirector('Jon Favreau');
            $movie->setDescription('Le Roi Lion est un film américain réalisé par Jon Favreau, sorti en 2019. Il s’agit d’une adaptation en images de synthèse du film d’animation Le Roi Lion de 1994, réalisé par Roger Allers et Rob Minkoff. Le film est produit par Walt Disney Pictures et distribué par The Walt Disney Company France. Il est sorti en France le 17 juillet 2019.');
            $movie->setReleaseDate($randomDate);

            $manager->persist($movie);
            $manager->flush();
        }
    }
}
