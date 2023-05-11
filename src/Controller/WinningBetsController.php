<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PariRepository;
use App\Repository\PariSingulierRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WinningBetsController extends AbstractController
{
    #[Route('/winningbets', name: 'app_winning_bets')]
    public function index(PariRepository $pariRepository,PariSingulierRepository $pariSingulierRepository): Response
    {   $paris=$pariRepository->findByResultat(1);

        return $this->render('winning_bets/index.html.twig', [
            'paris' => $paris,'repository'=>$pariSingulierRepository

        ]);
    }
}
