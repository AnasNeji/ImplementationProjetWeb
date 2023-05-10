<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class DisconnectController extends AbstractController
{
    #[Route('/disconnect',name:'delete_session')]
    public function delete_session(Session $session):Response
    {
        $session->clear();
        return($this->redirect("/home"));
    }
}
