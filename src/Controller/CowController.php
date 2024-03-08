<?php

namespace App\Controller;

use App\Entity\Cow;
use App\Filters\CowFilter;
use App\Forms\CowType;
use App\Forms\Filters\CowFilterType;
use App\Repository\CowRepository;
use App\Service\CowService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cow')]
class CowController extends AbstractController
{
    #[Template('Cow/index.html.twig')]
    #[Route('/', name: 'cows_index')]
    public function indexAction(EntityManagerInterface $em, Request $request, PaginatorInterface $paginator, CowRepository $cowRepository): array
    {
        $filter = new CowFilter();
        $filter->setLive('VIVO');

        $form = $this->createForm(CowFilterType::class, $filter);
        $form->handleRequest($request);

        $cows = $cowRepository->getCowsByFilter($filter);
        $countCows = $cowRepository->getCountCowsByFilter($filter);

        $pagination = $paginator->paginate(
            $cows,
            $request->query->getInt('page', 1),
            10
        );
        return [
            'form' => $form->createView(),
            'contagem' => $countCows[0]['qtde'],
            'pagination' => $pagination
            ];
    }

    #[Template('Cow/new.html.twig')]
    #[Route('/new', name: 'cow_create')]
    public function newAction(Request $request, CowService $cowService) : array | RedirectResponse
    {
        $newCow = new Cow();
        $form = $this->createForm(CowType::class, $newCow);
        $form->handleRequest($request);

        if (
            $form->isSubmitted() and
            $form->isValid() and
            $cowService->validatesCattleRegitration($newCow, $form)
        ) {
            $newCow->setLive(true);
            $cowService->saveCow($newCow);
            $this->addFlash('success', 'Bovino cadastrado com sucesso');

            return $this->redirectToRoute('cows_index');
        }
        return [
            'form' => $form->createView()
        ];
    }

    #[Template('Cow/edit.html.twig')]
    #[Route('/{id}/edit', name: 'cow_edit')]
    public function editAction(EntityManagerInterface $em, Request $request, $id, CowService $cowService): array | RedirectResponse
    {
        $cow = $em->getRepository(Cow::class)->find($id);

        $form = $this->createForm(CowType::class, $cow);
        $form->handleRequest($request);

        if (
            $form->isSubmitted() and
            $form->isValid() and
            $cowService->validatesCattleRegitration($cow, $form)
        ) {
            $cow->setLive(true);
            $cowService->saveCow($cow);
            $this->addFlash('success', 'Bovino editado com sucesso');

            return $this->redirectToRoute('cows_index');
        }
        return [
            'form' => $form->createView()
        ];
    }

    #[Route('/{cow}/delete', name: 'cow_delete')]
    public function deleteAction(CowService $cowService, Cow $cow): Response
    {
        $cowService->deleteCow($cow);
        $this->addFlash('success', 'Bovino deletado com sucesso');

        return $this->redirectToRoute('cows_index');
    }

    #[Template('Cow/slaughter.html.twig')]
    #[Route('{cow}/slaughter', name: 'cows_slaughter')]
    public function slaughterAction(CowService $service, Cow $cow) :Response
    {
        $service->slaughterCattle($cow->getCode());
        $this->addFlash('success', 'Bovino abatido com sucesso');

        return $this->redirectToRoute('cows_index');
    }
}