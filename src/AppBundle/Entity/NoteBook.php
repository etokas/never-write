<?php
/**
 * Created by PhpStorm.
 * User: sylva
 * Date: 19/07/2016
 * Time: 21:31
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table(name="notebook")
 * @ORM\Entity
 */
class NoteBook
{

    const DEFAULT_NOTEBOOK = 'Default';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Note", mappedBy="notebook", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="notebooks", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add note
     *
     * @param Note $note
     *
     * @return NoteBook
     */
    public function addNote(Note $note)
    {
        $note->setNotebook($this);

        $this->notes[] = $note;

        return $this;
    }

    /**
     * Remove note
     *
     * @param Note $note
     */
    public function removeNote(Note $note)
    {
        $this->notes->removeElement($note);
    }

    /**
     * Get notes
     *
     * @return ArrayCollection
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return NoteBook
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    

    /**
     * Set user
     *
     * @param User $user
     *
     * @return NoteBook
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function isAuthor(User $user){

        return $this->getUser()->getId() == $user->getId();
    }


}
