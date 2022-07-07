<?php

namespace App\Manager;

use App\Contracts\Manager\TagManagerInterface;
use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Pagerfanta\Pagerfanta;

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
     * @inheritDoc
     */
    public function createOrUpdate(Tag $tag, bool $flush = true): void
    {
        /** @var int|null $id */
        $id = $tag->getId();
        if ($id === null) {
            $this->entityManager->persist($tag);
        }
        if ($flush === true) {
            $this->entityManager->flush();
        }
    }

    /**
     * @inheritDoc
     */
    public function findAllTags(int $limit = 10, int $page = 1): Pagerfanta
    {
        return $this->tagRepository->findAllTags($limit, $page);
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
