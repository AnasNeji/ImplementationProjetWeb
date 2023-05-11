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

        if ($entity instanceof Fixture && $args->hasChangedField('termine') && $entity->isTermine() == 1) {
            $entityManager = $args->getEntityManager();
            $pariSinguliers = $entityManager->getRepository(PariSingulier::class)->findBy(['Id_fixture' => $entity->getId()]);
            if (!empty($pariSinguliers)) {
                foreach ($pariSinguliers as $pariSingulier) {
                    $PariPrincip = $pariSingulier->getPari();

                    if ($pariSingulier->updateResultat()) {
                        $PariPrincipStatus = 1;
                        $pariS = $entityManager->getRepository(PariSingulier::class)->findBy(['Id_pari' => $pariSingulier->getIdPari()]);
                        foreach ($pariS as $pari) {
                            if (!($pari->isResultat())) {
                                $PariPrincip->setResultat(0);
                                $PariPrincipStatus = 0;
                                break;
                            }
                        }
                        $PariPrincip->setResultat($PariPrincipStatus);
                        $entityManager->flush();
                    } else {
                        $PariPrincip->setResultat(0);
                        $entityManager->flush();
                    }
                }
            }
        }
    }
}