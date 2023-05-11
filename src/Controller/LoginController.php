<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(ManagerRegistry $doctrine, Request $request): Response
    {
        $check = $request->request->all();

        if (!$check) {
            return $this->render('login/index.html.twig', [
                'emailnon' => '',
                'passwordnon' => ''
            ]);
        }

        $data = $request->request;
        $repo = $doctrine->getRepository(User::class);
        $user = $repo->findOneBy(['Login' => $data->get('Login')]);

        if ($user) {
            if ($data->get('Password') == $user->getPassword()) {
                $session = $request->getSession();
                $session->set('user_id', $user->getId());
                $session->set('loggedIn', true);
            } else {
                $passwordnon = 'non';
                return $this->render("login/index.html.twig", [
                    'emailnon' => '',
                    'passwordnon' => $passwordnon
                ]);
            }
        } else {
            $emailnon = 'non';
            return $this->render("login/index.html.twig", [
                'emailnon' => $emailnon,
                'passwordnon' => ''
            ]);
        }

        return $this->redirectToRoute('app_home');
    }
}
