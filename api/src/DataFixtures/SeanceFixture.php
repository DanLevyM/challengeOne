<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\MovieRoom;
use App\Entity\Movie;
use App\Entity\Seance;

class SeanceFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movies = $manager->getRepository(Movie::class)->findAll();
        $movieRooms = $manager->getRepository(MovieRoom::class)->findAll();
        
        foreach ($movies as $movie) {
            $num_seances = rand(30, 50);

            for ($i = 0; $i < $num_seances; $i++) {

                // Sélectionner une salle de cinéma aléatoirement
                $randomMovieRoom = $movieRooms[array_rand($movieRooms)];

                // Générer une heure de début de seance
                $start_hour = rand(10, 21);
                $start_minute = rand(0, 59);
                $start_time = new \DateTime("$start_hour:$start_minute:00");

                // Générer une heure de fin de séance
                $end_time = clone $start_time;
                $duration = $movie->getDuration();
                $interval = new \DateInterval('PT' . $duration . 'M');
                $end_time = clone $start_time;
                $end_time->add($interval);

                // Générer une date de séance
                $start_date = new \DateTime('2023-03-02');
                $end_date = new \DateTime('2023-06-30');
                $timestamp = rand($start_date->getTimestamp(), $end_date->getTimestamp());
                $date = new \DateTime();
                $date->setTimestamp($timestamp);


                $seance = new Seance();
                $seance->setStartTime($start_time);
                $seance->setEndTime($end_time);
                $seance->setDate($date);
                $seance->setMovieroomId($randomMovieRoom);
                $seance->setMovie($movie);
                $seance->setPrice(mt_rand(10, 25));
                $manager->persist($seance);
                
            }
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return array(
            MovieRoomFixture::class,
            MovieFixture::class,
        );
    }
}
