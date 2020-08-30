<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Forum;

/**
 * OpenForo PageController
 * 
 * @author      Yohann THEPAUT (ythepaut) <contact@ythepaut.com>
 * @copyright   CC BY-NC-SA 4.0
 */
class PageController extends AbstractController {

    /**
     * Home page rendering
     * 
     * @Route("/", name="home")
     */
    public function home() {
        return $this->render('home.html.twig');
    }

    /**
     * Forums page rendering
     * 
     * @Route("/forums", name="forums")
     */
    public function forums() {

        $repo = $this->getDoctrine()->getRepository(Forum::class);
        $forums = $repo->findAll();

        return $this->render('forums.html.twig', [
            'forums' => $forums
        ]);
    }

    /**
     * Forum page rendering
     * 
     * @Route("/forums/{id}", name="forum")
     */
    public function forum($id) {

        $repo = $this->getDoctrine()->getRepository(Forum::class);
        $forum = $repo->find($id);

        return $this->render('forum.html.twig', [
            'forum' => $forum
        ]);
    }

}
