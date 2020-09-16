<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Forum;
use App\Entity\Discussion;
use App\Entity\Post;
use App\Repository\ForumRepository;
use App\Form\DiscussionType;
use Symfony\Component\HttpFoundation\Response;

/**
 * OpenForo ForumController
 * 
 * @author      Yohann THEPAUT (ythepaut) <contact@ythepaut.com>
 * @copyright   CC BY-NC-SA 4.0
 */
class ForumController extends AbstractController {

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
     * @param ForumRepository $repo             -   Forum repository
     * @return Response
     *
     * @Route("/forums", name="forums")
     */
    public function forums(ForumRepository $repo) {

        $forums = $repo->findAll();

        return $this->render('forum/forums.html.twig', [
            'forums' => $forums
        ]);
    }

    /**
     * Forum page rendering (<=> discussion list)
     *
     * @param Forum $forum                      -   Forum to render
     * @return Response
     *
     * @Route("/forums/{id}", name="forum")
     */
    public function forum(Forum $forum) {
        return $this->render('forum/forum.html.twig', [
            'forum' => $forum
        ]);
    }

    /**
     * New discussion page rendering
     *
     * @param Forum $forum                      -   Forum associated with the new discussion
     * @param Request $request                  -   Form POST request
     * @param EntityManagerInterface $manager   -   ObjectManager to push into database
     * @return RedirectResponse|Response
     *
     * @Route("/forums/{id}/new", name="new_discussion")
     */
    public function newDiscussion(Forum $forum, Request $request, EntityManagerInterface $manager) {

        // entities to be created 
        $discussion = new Discussion();
        $post = new Post();

        // creating form
        $form = $this->createForm(DiscussionType::class, $discussion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            // setting discussion's attributes
            $discussion->setCreationDate(new DateTime())
                       ->setStatus("OPEN")
                       ->setForum($forum);
            
            // setting post's attributes
            $post->setCreationDate(new DateTime())
                 ->setDiscussion($discussion)
                 ->setContent($discussion->getFirstPostContent());

            // pushing to database
            $manager->persist($discussion);
            $manager->persist($post);
            $manager->flush();

            // redirect to new discussion
            return $this->redirectToRoute('discussion', ['id' => $discussion->getId()]);
        
        } else {

            // rendering form page
            return $this->render('discussion/new_discussion.html.twig', [
                'form' => $form->createView()
            ]);

        }
    }

    /**
     * Discussion page rendering (<=> message list)
     *
     * @param Discussion $discussion            -   Discussion to render
     * @return Response
     *
     * @Route("/discussion/{id}", name="discussion")
     */
    public function discussion(Discussion $discussion) {
        return $this->render('discussion/discussion.html.twig', [
            'discussion' => $discussion
        ]);
    }

}
