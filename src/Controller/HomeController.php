<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FixtureRepository;



    class HomeController extends AbstractController
    {
        #[Route("/home/{date}", name: 'app_home',methods: 'GET',defaults: ['format' => null])]
        public function index( FixtureRepository $fixtureRepository,$date=null): Response
        {   if($date==null)
        {
            $date=date('Y-m-d');
        }
            $fixtures_playoff = $fixtureRepository->findByDatePlayoff($date);
            $fixtures_playout = $fixtureRepository->findByDatePlayout($date);
            return $this->render('home/index.html.twig', [
                'fixtures_playoff' => $fixtures_playoff,
                'fixtures_playout' => $fixtures_playout,
                'date' => $date
            ]);
        }
    }
