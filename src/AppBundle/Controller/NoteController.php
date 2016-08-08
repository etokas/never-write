<?php 

namespace AppBundle\Controller;

use AppBundle\Entity\Note;
use AppBundle\Entity\NoteBook;
use AppBundle\Form\NoteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/notes")
 * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
 */
class NoteController extends Controller 
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/new", name="note_new")
     */
    public function newAction(Request $request, NoteBook $noteBook)
    {
        $note = new Note();

        $form = $this->createForm(NoteType::class, $note);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $manager = $this->get('note_manager');

            $noteBook->addNote($note);

            $manager->persist($noteBook);

            return $this->redirectToRoute('notebook_view', ['id' => $noteBook->getId()]);
        }

        return $this->render('AppBundle:Note:new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/delete/{id_notebook}", name="note_delete")
     */
    public function deleteAction(Note $note, $id_notebook)
    {
        $manager = $this->get('note_manager');

        $manager->remove($note);

        return $this->redirectToRoute('notebook_view', ['id' => $id_notebook]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/view", name="note_view")
     */
    public function viewAction(Note $note)
    {
        return $this->render('AppBundle:Note:view.html.twig');

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/update/{id_notebook}", name="note_update")
     */
    public function updateAction(Request $request, Note $note, $id_notebook)
    {
        $form = $this->createForm(NoteType::class, $note);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $manager = $this->get('note_manager');

            $manager->persist($note);

            return $this->redirectToRoute('notebook_view', ['id' => $id_notebook]);
        }

        return $this->render('AppBundle:Note:update.html.twig', ['form' => $form->createView()]);

    }

}