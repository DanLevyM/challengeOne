<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Review;
use App\Entity\User;
use App\Entity\Movie;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ReviewFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = $manager->getRepository(User::class)->findAll()[0];
        $userVerif = $manager->getRepository(User::class)->findAll()[1];
        $movie = $manager->getRepository(Movie::class)->findAll()[0];
        // dd($movie);
        $review = new Review();
        $review->setTitle('très bon');
        $review->setDescription('Super film vraiment trop bien');
        $review->setUserAdmin($user);
        $review->setUserAdminCheck($userVerif);
        $review->setMovie($movie);
        $manager->persist($review);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixture::class,
            MovieFixture::class
        );
    }
}
