<?php

namespace AppBundle\Listener;

use AppBundle\Entity\NoteBook;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserListener implements EventSubscriberInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_SUCCESS => 'onConfirm',
        ];
    }

    public function onConfirm(FormEvent $event)
    {
        $user = $event->getForm()->getData();

        $note = new NoteBook();

        $note->setName(NoteBook::DEFAULT_NOTEBOOK);

        $user->addNotebook($note);

        $this->manager->persist($note);

        $this->manager->flush();
    }

}