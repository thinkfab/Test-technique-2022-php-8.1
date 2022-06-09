<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Commentaire;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = self::faker();
        for ($i = 0; $i < self::NUMBER_OF_ARTICLES; $i++) {
            $numberOfComment = random_int(0, self::NUMBER_MAX_OF_COMMENT);
            /** @var Article $article */
            $article = $this->getReference(self::ARTICLE_REF . $i);
            for ($ii = 0; $ii < $numberOfComment; $ii++) {
                $comment = new Commentaire();
                $comment->setArticle($article)
                    ->setUsername($faker->userName)
                    ->setContent($faker->sentence(20, true))
                    ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime));
                $manager->persist($comment);
                $manager->flush();
                $this->addReference(self::ARTICLE_REF . $i . self::COMMENT_REF . $ii, $comment);
            }
        }
    }

    public function getDependencies()
    {
        return array(
            ArticleFixtures::class
        );
    }
}
