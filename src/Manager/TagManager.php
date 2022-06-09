<?php

namespace App\Manager;

use App\Contracts\Manager\TagManagerInterface;
use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use InvalidArgumentException;

final class TagManager implements TagManagerInterface
{
    private TagRepository $tagRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(Tag::class);
        if (!$repo instanceof TagRepository) {
            throw new InvalidArgumentException(sprintf(
                'The repository class for "%s" must be "%s" and given "%s"! ' .
                'Maybe look the "repositoryClass" declaration on %s ?',
                Tag::class,
                EntityManagerInterface::class,
                get_class($repo),
                Tag::class
            ));
        }
        $this->tagRepository = $repo;
    }

    /**
     * {@inheritDoc}
     */
    public function findOneBySlug(string $slug): Tag
    {
        $tag = $this->tagRepository->findOneBySlug($slug);
        if ($tag === null) {
            throw new InvalidArgumentException('There is no tag for this slug');
        }
        return $tag;
    }
}
