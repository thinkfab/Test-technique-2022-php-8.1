<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixtures extends AbstractBaseFixtures
{

    public function __construct()
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $faker = self::faker();
        for ($i = 0; $i < self::NUMBER_OF_CATEGORIE; $i++) {
            $intitule = $faker->word;
            $category = new Categorie();
            $category->setDescription($intitule);
            $category->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime));
            $category->setUpdatedAt(DateTimeImmutable::createFromMutable($faker->dateTime));

            $manager->persist($category);
            $manager->flush();
        }
    }
}
