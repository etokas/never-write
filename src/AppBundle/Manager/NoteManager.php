<?php

namespace AppBundle\Manager;


use AppBundle\Entity\Note;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class NoteManager extends ManagerInterface
{
    public $manager;

    public $repository;

    /**
     * NoteManager constructor.
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
        $this->repository = $manager->getRepository(Note::class);
    }

    /**
     * @param $id
     * @return object
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $criteres
     * @return array
     */
    public function findBy(array $criteres)
    {
        return $this->repository->findBy($criteres);
    }

    public function findOneBy(array $criteres)
    {
        return $this->repository->findOneBy($criteres);
    }

    /**
     * @param $entity
     */
    public function remove($entity)
    {
        $this->manager->remove($entity);

        $this->manager->flush();
    }

    /**
     * @param $entity
     * @param bool $flush
     */
    public function persist($entity, $flush = true)
    {
        $this->manager->persist($entity);

        if ($flush) {
            $this->manager->flush();
        }
    }
}