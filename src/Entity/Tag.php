<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[UniqueEntity('slug')]
#[ApiResource(
    collectionOperations: ['get' => ['normalization_context' => ['groups' => 'tag:list']]],
    itemOperations: ['get' => ['normalization_context' => ['groups' => 'tag:item']]],
    order: ['intitule' => 'ASC'],
    paginationEnabled: false,
)]
#[ApiFilter(SearchFilter::class, properties: ['article' => 'exact'])]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['tag:list', 'tag:item'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['tag:list', 'tag:item'])]
    private $intitule;

    #[ORM\ManyToMany(targetEntity: Article::class, inversedBy: 'tags')]
    #[Groups(['tag:list', 'tag:item'])]
    private $article;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['tag:list', 'tag:item'])]
    private $color;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['tag:list', 'tag:item'])]
    private $slug;

    public function __construct()
    {
        $this->article = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->intitule;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        $this->article->removeElement($article);

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     * @return Tag
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }
}
