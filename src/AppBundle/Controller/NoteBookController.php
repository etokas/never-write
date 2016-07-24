<?php
/**
 * Created by PhpStorm.
 * User: sylva
 * Date: 19/07/2016
 * Time: 20:13
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Note;
use AppBundle\Entity\NoteBook;
use AppBundle\Form\NoteBookType;
use AppBundle\Form\NoteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class NoteBookController
 * @package AppBundle\Controller
 * @Route("/notebooks")
 */
class NoteBookController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="notebook_index")
     */
    public function indexAction()
    {
        $manager = $this->get('notebook_manager');

        return $this->render('AppBundle:NoteBook:index.html.twig', ['notebooks' => $manager->notebooks()]);
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new", name="notebook_new")
     */
    public function newAction(Request $request)
    {
        $notebook = new NoteBook();

        $form = $this->createForm(NoteBookType::class, $notebook);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $manager = $this->get('notebook_manager');

            $manager->addNoteBook($notebook);

            return $this->redirectToRoute('notebook_index');
        }

        return $this->render('AppBundle:NoteBook:new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/update", name="notebook_update")
     */
    public function updateAction(Request $request, NoteBook $notebook)
    {
        $required = false;

        $form = $this->createForm(NoteBookType::class, $notebook);

        $form->handleRequest($request);

        $manager = $this->get('notebook_manager');


        if ($form->isSubmitted()) {

            $manager->persist($notebook);

            return $this->redirectToRoute('notebook_index');
        }

        if ($notebook->getName() == NoteBook::DEFAULT_NOTEBOOK){

            $required = true;
        }

        return $this->render('AppBundle:NoteBook:update.html.twig', ['form' => $form->createView(), 'required' => $required]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/delete", name="notebook_delete")
     */
    public function deleteAction(NoteBook $notebook)
    {
        $manager = $this->get('notebook_manager');

        $manager->remove($notebook);

        return $this->redirectToRoute('notebook_index');

    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/delete/{id}/confirm", name="notebook_confirm")
     */
    public function confirmDeleteAction(NoteBook $noteBook)
    {
        if ($noteBook->getName() == NoteBook::DEFAULT_NOTEBOOK) {

            $this->addFlash('warnnig', 'Désolé le notebook ' . NoteBook::DEFAULT_NOTEBOOK . ' ne peut être supprimer');

            return $this->redirectToRoute('notebook_index');

        }
        return $this->render('AppBundle:NoteBook:confirm.html.twig', ['notebook' => $noteBook]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/delete/{id}/move", name="notebook_move_delete")
     */
    public function moveDeleteAction(NoteBook $noteBook)
    {
        $manager = $this->get('notebook_manager');

        $count = $manager->moveAndDelete($noteBook);

        $this->addFlash('success', sprintf('%s notes ont été deplacé dans le notebook ', $count) . NoteBook::DEFAULT_NOTEBOOK);

        return $this->redirectToRoute('notebook_index');
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/view", name="notebook_view")
     */
    public function viewction(NoteBook $noteBook)
    {
        return $this->render('AppBundle:NoteBook:view.html.twig', ['notebook' => $noteBook]);
    }

}