<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Faker\Generator;

abstract class AbstractBaseFixtures extends Fixture
{
    public const NUMBER_OF_ARTICLES = 20;
    public const NUMBER_MAX_OF_COMMENT = 5;
    public const NUMBER_OF_TAGS = 10;
    public const USER_REF = 'user';
    public const ARTICLE_REF = 'article_';
    public const COMMENT_REF = '_commentaire_';
    public const TAG_REF = 'tag_';
    protected static function faker(): Generator
    {
        return Factory::create('fr_FR');
    }
}
