<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setName('Petits popcorns sucrés');
        $product->setPrice(7);
        $manager->persist($product);

        $manager->flush();


        $product = new Product();
        $product->setName('Petit popcorns salé');
        $product->setPrice(7);
        $manager->persist($product);

        $manager->flush();

        $product = new Product();
        $product->setName('Moyen popcorns sucrés');
        $product->setPrice(10);
        $manager->persist($product);

        $manager->flush();

        $product = new Product();
        $product->setName('Moyen popcorns salé');
        $product->setPrice(10);
        $manager->persist($product);

        $manager->flush();
    }

   
}
