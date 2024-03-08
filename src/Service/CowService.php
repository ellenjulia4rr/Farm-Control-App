<?php

namespace App\Service;

use App\Entity\Cow;
use App\Repository\CowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormError;

class CowService
{
    private CowRepository $cowRepository;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em, CowRepository $cowRepository)
    {
        $this->em = $em;
        $this->cowRepository = $cowRepository;
    }

    public function validatesCattleRegitration(Cow $cow, $form) :bool
    {
        $fazenda = $cow->getFarm();
        $birth = $cow->getBirth();

        $animalPerHectare = 18;
        $totalCows = $this->em->getRepository(Cow::class)->count(['farm' => $fazenda, 'live' => true]);
        $farmSize = $fazenda->getTamanho();

        $spaceAvailable = $farmSize * $animalPerHectare - $totalCows;

        if($spaceAvailable <= 0) {
            $form->get('farm')->addError(new FormError('A fazenda não tem espaço para mais animais.'));
            return false;
        }

        $today = new \DateTime();
        if($birth > $today) {
            $form->get('birth')->addError(new FormError('A data de nascimento não pode ser futura.'));
            return false;
        }

        $getAnimalByCode = $this->cowRepository->getCattleId($cow);

        if($getAnimalByCode) {
            $form->get('code')->addError(new FormError('Já existe um animal vivo com esse código nessa fazenda.'));
            return false;
        }
        return true;
    }

    public function slaughterCattle(int $code) :array
    {
        $cattleForSlaughter = $this->cowRepository->lookingForCattleForSlaughter($code);

        $abatedCows = [];
        foreach ($cattleForSlaughter as $cow) {
            if($cow->isLive())  {
                $cow->setLive(false);

                $this->em->persist($cow);
                $abatedCows[] = $cow;
            }
        }
        $this->em->flush();
        return $abatedCows;
    }

    public function saveCow(Cow $newCow)
    {
        $this->em->persist($newCow);
        $this->em->flush();
    }

    public function deleteCow(Cow $cow)
    {
        $this->em->remove($cow);
        $this->em->flush();
    }
}