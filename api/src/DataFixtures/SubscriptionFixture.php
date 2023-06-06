<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Subscription;
use App\Entity\User;

class SubscriptionFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = $manager->getRepository(User::class)->findAll()[0];
        $now = new \DateTime();
        $nextMonth = clone $now;
        $nextMonth->add(new \DateInterval('P1M'));

        $subscription = new Subscription();
        $subscription->setType('Offre Découverte');
        $subscription->setFormality('Mensuel');
        $subscription->setPrice(7);
        $subscription->setStartedAt($now);
        $endAt = clone $now;
        $endAt->add(new \DateInterval('P1M'));
        $subscription->setEndAt($endAt);
        $subscription->setUserSub($user);
        $manager->persist($subscription);
        $manager->flush();


        $subscription = new Subscription();
        $subscription->setType('Offre Drol');
        $subscription->setFormality('Annuel');
        $subscription->setPrice(20);
        $subscription->setStartedAt($now);
        $endAt = clone $now;
        $endAt->add(new \DateInterval('P1Y'));
        $subscription->setEndAt($endAt);
        $subscription->setUserSub($user);
        $manager->persist($subscription);
        $manager->flush();


        $subscription = new Subscription();
        $subscription->setType('Offre Découverte');
        $subscription->setFormality('Mensuel');
        $subscription->setPrice(7);
        $subscription->setStartedAt($now);
        $endAt = clone $now;
        $endAt->add(new \DateInterval('P1M'));
        $subscription->setEndAt($endAt);
        $subscription->setUserSub($user);
        $manager->persist($subscription);
        $manager->flush();

        $subscription = new Subscription();
        $subscription->setType('Offre Drol');
        $subscription->setFormality('Annuel');
        $subscription->setPrice(20);
        $subscription->setStartedAt($now);
        $endAt = clone $now;
        $endAt->add(new \DateInterval('P1Y'));
        $subscription->setEndAt($endAt);
        $subscription->setUserSub($user);
        $manager->persist($subscription);
        $manager->flush();
    }
}
