<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ConnectionType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * OpenForo AccountController
 *
 * @author      Yohann THEPAUT (ythepaut) <contact@ythepaut.com>
 * @copyright   CC BY-NC-SA 4.0
 */
class AccountController extends AbstractController {

    /**
     * Login page rendering
     *
     * @return RedirectResponse|Response
     *
     * @Route("/login", name="login")
     */
    public function login() {
        // rendering form page
        return $this->render('account/login.html.twig');

    }


    /**
     * Register page rendering
     *
     * @param Request $request                  -   Form POST request
     * @param EntityManagerInterface $manager   -   ObjectManager to push into database
     * @param UserPasswordEncoderInterface $encoder Used to hash user password
     * @return RedirectResponse|Response
     *
     * @Route("/register", name="register")
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) {

        // entity to be created
        $user = new User();

        // creating form
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // setting user's attribute
            //TODO IMPORTANT
            //$user->setPasswd($encoder->encodePassword($user, $user->getPasswd()));

            // pushing to database
            $manager->persist($user);
            $manager->flush();

            // redirect to new discussion
            return $this->redirectToRoute('login');

        } else {

            // rendering form page
            return $this->render('account/register.html.twig', [
                'form' => $form->createView()
            ]);

        }
    }
}
