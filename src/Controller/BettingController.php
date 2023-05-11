<?php

namespace App\Controller;
use App\Entity\PariSingulier;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
use App\Entity\User;
use App\Entity\Pari;
use App\Entity\Fixture;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
class BettingController extends AbstractController
{
    #[Route('/Bet/{id}', name: 'betting')]
    public function index(EntityManagerInterface $entityManager,$id,Request $request,SessionInterface $session)
    {
        if (!$session->get('loggedIn')) {
            return $this->redirectToRoute('app_login');
        }

        $matches = $entityManager->getRepository(Fixture::class)->findBy([
            'Encours' => 0,
            'Termine' => 0,
        ],
            ['Date' => 'ASC']);

        return $this->render('bettingpage.html.twig', ['matches' => $matches]);
    }


    #[Route('Bet/updatebet/{param}/{montant}', name: 'update_bet')]
    public function updatebet(EntityManagerInterface $entityManager, $param,$montant,SessionInterface $session)
    {
        $currentDate=new DateTime();
        $pari=new Pari();
        //creating user until relinking with the current one
        $usr=$entityManager->getRepository(User::class)->findById($session->get('user_id'));

        $pari->setIdUser($usr[0]);
        $pari->setResultat(0);
        $pari->setMontantParie($montant);
        $pari->setDateCreation($currentDate);
        $entityManager->persist($pari);


        $tab=explode(',',$param);
        foreach($tab as $col){
            $one=explode('-',$col);
            $id=$one[0];
            $choix=$one[1];
            $fxt=$entityManager->getRepository(Fixture::class)->find($id);
            $pariSingulier = new PariSingulier();
            $pariSingulier->setIdPari($pari);
            $pariSingulier->setChoix($choix);
            $pariSingulier->setResultat(0);
            $pariSingulier->setIdFixture($fxt);
            $entityManager->persist($pariSingulier);
        }
        $tab=null;

        if ($usr[0]->getSolde() < $montant) {
            $this->addFlash('error', 'Your balance is not sufficient for this bet!');
        } else {
            $usr[0]->setSolde($usr[0]->getSolde()-$montant);
            $entityManager->flush();

            $this->addFlash('success', 'Your bet has been placed successfully!');
        }

        return $this->redirectToRoute('betting',['id'=>'1']);
    }


}
