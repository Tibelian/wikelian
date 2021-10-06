<?php

namespace App\EventSubscriber;

use App\Entity\User;
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

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
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
    }

    public function prePersistedEntity(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();
        if($entity instanceof User) {
            $this->setUserPassword($entity);
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
}