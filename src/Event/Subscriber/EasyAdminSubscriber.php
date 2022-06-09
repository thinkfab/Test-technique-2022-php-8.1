<?php

namespace App\Event\Subscriber;

use App\Entity\Article;
use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private SluggerInterface $slugger;

    public function __construct(
        SluggerInterface $slugger
    ) {
        $this->slugger = $slugger;
    }

    public static function getSubscribedEvents(): array
    {
        return array(
            BeforeEntityPersistedEvent::class => array(array('setSlug')),
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
}
