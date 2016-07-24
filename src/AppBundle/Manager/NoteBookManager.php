<?php

namespace AppBundle\Manager;


use AppBundle\Entity\Note;
use AppBundle\Entity\NoteBook;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class NoteBookManager extends ManagerInterface
{
    public $manager;

    public $repository;

    /** @var mixed User */
    public $user;

    /**
     * NoteManager constructor.
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager, TokenStorage $token)
    {
        $this->manager = $manager;
        $this->repository = $manager->getRepository(NoteBook::class);
        $this->user = $token->getToken()->getUser();

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
     * @param NoteBook $entity
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

    /**
     * @param NoteBook $entity
     */
    public function addNoteBook(NoteBook $entity)
    {
        $this->user->addNoteBook($entity);

        $this->persist($entity);

    }

    public function moveAndDelete(NoteBook $notebook)
    {
        $default = $this->repository->findOneBy(['name' => NoteBook::DEFAULT_NOTEBOOK]);

        foreach ($notebook->getNotes() as $note) {

            $default->addNote($note);
        }

        $this->persist($default);

        $this->remove($notebook);

        return count($notebook->getNotes());
    }

    public function notebooks()
    {
        return $this->user->getNotebooks();
    }

}