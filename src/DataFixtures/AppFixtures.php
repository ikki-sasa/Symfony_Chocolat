<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_Fr');

        for ($p = 0; $p < 121; $p++) {
            $product = new Product;
            $product->setProductName("Produit n°$p");
            $product->setDescription($faker->text(255));
            $product->setImg('Orangettes6.jpg');
            $product->setPrice(mt_rand(100, 2000));
            $product->setCategoryId($faker->category);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
