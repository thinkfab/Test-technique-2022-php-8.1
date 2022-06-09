<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Tag;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class TagFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = self::faker();
        for ($i = 0; $i < self::NUMBER_OF_TAGS; $i++) {
            $tag = new Tag();
            $intitule = $faker->word;
            $slug = $this->slugger->slug($intitule);
            $tag->setIntitule($intitule)
                ->setSlug($slug)
                ->setColor($faker->hexColor);
            $numberOfArticles = random_int(1, 15);
            for ($ii = 0; $ii < $numberOfArticles; $ii++) {
                /** @var Article $article */
                $article = $this->getReference(self::ARTICLE_REF . $ii);
                $tag->addArticle($article);
            }
            $manager->persist($tag);
            $manager->flush();
            $this->addReference(self::TAG_REF . $i, $tag);
        }
    }

    public function getDependencies()
    {
        return array(
            ArticleFixtures::class
        );
    }
}
