<?php
/**
 * Created by PhpStorm.
 * User: sylva
 * Date: 19/07/2016
 * Time: 18:14
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\NoteBook;


class HomeController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Page:home.html.twig');
    }

}