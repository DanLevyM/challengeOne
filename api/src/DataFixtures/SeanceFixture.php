<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\MovieRoom;
use App\Entity\Movie;
use App\Entity\Seance;

class SeanceFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movie = $manager->getRepository(Movie::class)->findAll()[0];
        $movieRoom = $manager->getRepository(MovieRoom::class)->findAll()[0];

        $seance = new Seance();
        $seance->setStartTime(new \DateTime());
        $seance->setEndTime(new \DateTime());
        $seance->setDate(new \DateTime());
        $seance->setMovieroomId($movieRoom);
        $seance->setMovie($movie);
        $seance->setPrice(mt_rand (10, 25));
        $manager->persist($seance);
        $manager->flush();

        $movie1 = $manager->getRepository(Movie::class)->findAll()[1];
        $movieRoom1 = $manager->getRepository(MovieRoom::class)->findAll()[1];

        $seance = new Seance();
        $seance->setStartTime(new \DateTime());
        $seance->setEndTime(new \DateTime());
        $seance->setDate(new \DateTime());
        $seance->setMovieroomId($movieRoom1);
        $seance->setMovie($movie1);
        $seance->setPrice(mt_rand (10, 25));
        $manager->persist($seance);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            MovieRoomFixture::class,
            MovieFixture::class,
        );
    }
}
