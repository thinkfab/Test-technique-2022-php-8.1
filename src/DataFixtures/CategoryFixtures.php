<?php

namespace App\DataFixtures;

use App\Entity\Category;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends AbstractBaseFixtures
{
    public function load(ObjectManager $manager): void
    {
        $faker = self::faker();
        for ($i = 0; $i < 15; $i++) {
            $date = DateTimeImmutable::createFromMutable($faker->dateTime);
            $title = "Categorie #$i : " . $faker->word;
            $category = new Category();
            $category
                ->setTitle($title)
                ->setCreatedAt($date);
            $manager->persist($category);
            $manager->flush();
            $this->addReference(self::CATEGORY_REF . $i, $category);
        }
    }
}
