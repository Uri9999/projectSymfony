<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class CategoryTableFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i <= 5; $i++) {
            $category = new Category;
            $category->setName('category '.$i);
            $manager->persist($category);
            for($j=1; $j<=5; $j++){
                $product = new Product;
                $product->setName(('product '.$j));
                $product->setPrice(mt_rand(1, 9)*100 );
                $product->setDescription('description for product '.$j);
                $product->setCategory(($category));
                $manager->persist($product);
            }
        }

        $manager->flush();

    }
}
