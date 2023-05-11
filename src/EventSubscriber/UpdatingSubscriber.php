<?php

namespace App\EventSubscriber;



use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Fixture;
use App\Entity\Pari;
use App\Entity\PariSingulier;

class UpdatingSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::preUpdate,
        ];
    }
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Fixture && $args->hasChangedField('Termine') && $entity->isTermine() == 1) {
            $entityManager = $args->getObjectManager();
            $pariSinguliers=$entityManager->getRepository(PariSingulier::class)->findBy(['Id_fixture' => $entity->getId()]);
            foreach($pariSinguliers as $pariSingulier)
            {
                $PariPrincip=$entityManager->getRepository(Pari::class)->findoneBy(['id' => $pariSingulier->getIdPari()]);


                if($pariSingulier->UpdateResultat())
                {
                    $PariPrincipStatus=1;
                    $pariS=$entityManager->getRepository(PariSingulier::class)->findBy(['Id_pari' => $pariSingulier->getIdPari()]);
                    foreach ($pariS as $pari)
                    {
                       if(!($pari->isResultat()))
                       {
                           $PariPrincip->setResultat(0);
                           $PariPrincipStatus=0;
                           break;
                       }

                    }
                    $PariPrincip->setResultat($PariPrincipStatus);
                    $entityManager->flush();


                }
                else
                {
                    $PariPrincip->setResultat(0);
                    $entityManager->flush();
                }

            }
/*            $paris = $entityManager->getRepository(Pari::class)->findBy(['fixture' => $entity]);

            foreach ($paris as $pari) {
                $pariResult = 1;
                foreach ($pari->getPariSinguliers() as $pariSingulier) {
                    if ($pariSingulier->getResultat() == 0) {
                        $pariResult = 0;
                        break;
                    }
                }

                $pari->setResultat($pariResult);
                $entityManager->persist($pari);
            }

            $entityManager->flush();*/
        }
    }
}
