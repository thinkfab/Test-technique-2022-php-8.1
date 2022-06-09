<?php

namespace App\Event\Subscriber;

use App\Contracts\Service\ArticleServiceInterface;
use App\Entity\Article;
use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private SluggerInterface $slugger;
    private ArticleServiceInterface $articleService;

    public function __construct(
        SluggerInterface $slugger,
        ArticleServiceInterface $articleService
    ) {
        $this->slugger = $slugger;
        $this->articleService = $articleService;
    }

    public static function getSubscribedEvents(): array
    {
        return array(
            BeforeEntityPersistedEvent::class => array(array('setSlug'), array('setContentBionic')),
        );
    }

    public function setSlug(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        if ($entity instanceof Article) {
            $slug = $this->slugger->slug($entity->getTitre());
            $entity->setSlug($slug);
        }
        if ($entity instanceof Tag) {
            $slug = $this->slugger->slug($entity->getIntitule());
            $entity->setSlug($slug);
        }
    }

    public function setContentBionic(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        if (!($entity instanceof Article)) {
            return;
        }
        $content = $entity->getContent();
//        $contentBionic = $this->articleService->generateBionicContent($content);
        $contentBionic = $content;
        $entity->setContent($contentBionic);
    }
}
