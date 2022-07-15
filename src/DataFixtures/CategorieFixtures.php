<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;

class CategorieFixtures extends AbstractBaseFixtures
{

    public function load(ObjectManager $manager): void
    {
        $faker = self::faker();

        for ($i = 0; $i < self::NUMBER_OF_CATEGORIES; $i++) {
            $intitule = "Categorie #$i : ";
            $categorie = new Categorie();
            $categorie
                ->setIntitule($intitule)
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime))
                ->setUpdatedAt(DateTimeImmutable::createFromMutable($faker->dateTime));
            $manager->persist($categorie);
            $manager->flush();
            $this->addReference(self::CATEGORY_REF . $i, $categorie);
        }
    }

}
