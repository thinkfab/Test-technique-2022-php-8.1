<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = self::faker();
        /** @var User $user */
        $user = $this->getReference(self::USER_REF);
        for ($i = 0; $i < self::NUMBER_OF_ARTICLES; $i++) {
            $titre = "Article #$i : " . $faker->word;
            $slug = $this->slugger->slug($titre);
            $article = new Article();
            $article->setTitre($titre)
                ->setSlug($slug)
                ->setContent($faker->sentence(50, true))
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime))
                ->setIsPublished(true)
                ->setUser($user);
            $manager->persist($article);
            $manager->flush();
            $this->addReference(self::ARTICLE_REF . $i, $article);
        }
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}
