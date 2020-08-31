<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Forum;
use App\Entity\Discussion;
use App\Repository\ForumRepository;

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
     * Forums page rendering (<=> forum list)
     * 
     * @Route("/forums", name="forums")
     */
    public function forums(ForumRepository $repo) {

        $forums = $repo->findAll();

        return $this->render('forums.html.twig', [
            'forums' => $forums
        ]);
    }

    /**
     * Forum page rendering (<=> discussion list)
     * 
     * @Route("/forums/{id}", name="forum")
     */
    public function forum(Forum $forum) {
        return $this->render('forum.html.twig', [
            'forum' => $forum
        ]);
    }

    /**
     * Discussion page rendering (<=> message list)
     * 
     * @Route("/discussion/{id}", name="discussion")
     */
    public function discussion(Discussion $discussion) {
        return $this->render('discussion.html.twig', [
            'discussion' => $discussion
        ]);
    }

}
