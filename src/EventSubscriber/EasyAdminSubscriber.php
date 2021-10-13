<?php

namespace App\EventSubscriber;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    
    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordEncoder;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['prePersistedEntity'],
            BeforeEntityUpdatedEvent::class => ['preUpdateEntity'],
        ];
    }

    public function preUpdateEntity(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();
        if($entity instanceof User) {
            $this->setUserPassword($entity);
        }
        if($entity instanceof Post) {
            $this->persistTaxonomies($entity);
        }
    }

    public function prePersistedEntity(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();
        if($entity instanceof User) {
            $this->setUserPassword($entity);
        }
        if($entity instanceof Post) {
            $this->persistTaxonomies($entity);
        }
    }

    private function setUserPassword(User $user)
    {
        if ( !empty($user->getPlainPassword()) )
        {
            $newPassword = $this->passwordEncoder->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($newPassword);
            $user->eraseCredentials();
        }
    }

    private function persistTaxonomies(Post $_post)
    {
        // cascade taxonomies -- without using doctrine annotation
        foreach($_post->getTaxonomies() as $_taxonomy)
        {
            $this->entityManager->persist($_taxonomy);
        }
    }

}