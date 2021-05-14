<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProProductTableFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        //     $product = new Product();
        //     $product->setName('product ');
        //     $product->setPrice(mt_rand(1, 9) * 100);
        //     $product->setDescription('description for product ');

        //     $manager->persist($product);

        $manager->flush();
    }
}
