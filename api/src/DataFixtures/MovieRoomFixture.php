<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\MovieRoom;

class MovieRoomFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $movie_room = new MovieRoom();
        $movie_room->setNumberPlaces(250);
        $movie_room->setRoomName(rand(200, 300));
        $manager->persist($movie_room);
        $manager->flush();

        $movie_room = new MovieRoom();
        $movie_room->setNumberPlaces(300);
        $movie_room->setRoomName(rand(200, 300));
        $manager->persist($movie_room);
        $manager->flush();

        $movie_room = new MovieRoom();
        $movie_room->setNumberPlaces(160);
        $movie_room->setRoomName(rand(200, 300));
        $manager->persist($movie_room);
        $manager->flush();
    }
}
