<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Comment;
use App\Entity\Moderation;
use App\Entity\Movie;
use App\Entity\User;

class CommentFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = $manager->getRepository(User::class)->findAll()[0];
        $movie = $manager->getRepository(Movie::class)->findAll()[0];

        $comment = new Comment();
        $comment->setTitle('bof');
        $comment->setDescription("S'il ne fallait retenir qu'un seul Disney ce serait évidemment celui-là. Le Roi Lion est un film splendide, porteur d'une histoire et d'une morale universelles.");
        $comment->setDate(new \DateTime('2020-07-17'));
        $comment->setUserId($user);
        $comment->setMovieId($movie);
        $manager->persist($comment);

        $manager->flush();

        $user1 = $manager->getRepository(User::class)->findAll()[0];
        $movie1 = $manager->getRepository(Movie::class)->findAll()[0];

        $comment1 = new Comment();
        $comment1->setTitle('Bon film');
        $comment1->setDescription("Sympa à voir. Mais c'est juste pour les enfants. Ce film peut ennuyer les adultes malgrè la beauté des dessins.Le scénario est peut etre trop simple.");
        $comment1->setDate(new \DateTime('2020-07-17'));
        $comment1->setUserId($user1);
        $comment1->setMovieId($movie1);
        $manager->persist($comment1);
        $manager->flush();

        $moderation = new Moderation();
        $moderation->setCommentaireId($comment1);
        $moderation->setUserId($user1);
        $moderation->setCounterUserBan(0);
        $manager->persist($moderation);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixture::class,
            MovieFixture::class,
        );
    }
}
