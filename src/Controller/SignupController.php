<?php

// src/Controller/RegistrationController.php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class SignupController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, EntityManagerInterface $entityManager,Session $session ): Response
    {   if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
        $user = new User();
        $form = $this->createForm(UserRegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Additional logic such as password hashing can be added here
            $user->setSolde(10.00);
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirect to success page or do any other actions
            $session = $request->getSession();
            $session->set('user_id', $user->getId());
            $session->set('loggedIn', true);
            return $this->redirect('/home');
        }

        return $this->render('signup/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
