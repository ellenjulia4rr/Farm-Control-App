<?php

namespace App\Controller;

use App\Entity\Veterinarian;
use App\Filters\VeterinarianFilter;
use App\Forms\Filters\VeterinarianFilterType;
use App\Forms\VeterinarianType;
use App\Repository\VeterinarianRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/veterinarian')]
class VeterinarianController extends AbstractController
{
    #[Template('Veterinarian/index.html.twig')]
    #[Route('/', name: 'veterinarians_index')]
    public function indexAction(EntityManagerInterface $em, Request $request, PaginatorInterface $paginator, VeterinarianRepository $veterinarianRepository): array
    {
        $filter = new VeterinarianFilter();
        $form = $this->createForm(VeterinarianFilterType::class, $filter);
        $form->handleRequest($request);

        $veterinarios = $em->getRepository(Veterinarian::class)->getVeterinarianByFilter($filter);
        $countVeterinarians = $veterinarianRepository->getCountveterinarianByFilter($filter);

        $pagination = $paginator->paginate(
            $veterinarios,
            $request->query->getInt('page', 1),
            10
        );

        return [
            'form' => $form->createView(),
            'contagem' => $countVeterinarians[0]['qtde'],
            'pagination' => $pagination,
        ];
    }

    #[Template('Veterinarian/new.html.twig')]
    #[Route('/new', name: 'veterinarian_create')]
    public function newAction(EntityManagerInterface $em, Request $request, VeterinarianRepository $repository): array | RedirectResponse
    {
        $novoVeterinario = new Veterinarian();
        $form = $this->createForm(VeterinarianType::class, $novoVeterinario);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $dbVeterinarian = $repository->findOneBy([
                'crmv' => $novoVeterinario->getCrmv()
            ]);

            if($dbVeterinarian) {
                $form->get('crmv')->addError(new FormError('Já existe um veterinário cadastrado com esse CRMV'));
                return [
                    'form' => $form->createView()
                ];
            }

            $em->persist($novoVeterinario);
            $em->flush();
            $this->addFlash('success', 'Veterinário cadastrado com sucesso');

            return $this->redirectToRoute('veterinarians_index');
        }

        return [
            'form' => $form->createView()
        ];
    }

    #[Template('Veterinarian/edit.html.twig')]
    #[Route('/{id}/edit', name: 'veterinarian_edit')]
    public function editAction(EntityManagerInterface $em, Request $request, $id, VeterinarianRepository $repository): array | RedirectResponse
    {
        $veterinario = $em->getRepository(Veterinarian::class)->find($id);

        $form = $this->createForm(VeterinarianType::class, $veterinario);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $dbVeterinarian = $repository->getCrmvAndId($veterinario);

            if($dbVeterinarian) {
                $form->get('crmv')->addError(new FormError('Já existe um veterinário cadastrado com esse CRMV'));
                return [
                    'form' => $form->createView()
                ];
            }
            $em->flush();
            $this->addFlash('success', 'Veterinário editado com sucesso');

            return $this->redirectToRoute('veterinarians_index');
        }

        return [
            'form' => $form->createView()
        ];
    }

    #[Route('/{veterinarian}/delete', name: 'veterinarian_delete')]
    public function deleteAction(EntityManagerInterface $em, Veterinarian $veterinarian): Response
    {
        $em->remove($veterinarian);
        $em->flush();
        $this->addFlash('success', 'Veterinário deletado com sucesso');

        return $this->redirectToRoute('veterinarians_index');

    }
}