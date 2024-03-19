<?php

namespace App\Controller;

use App\Entity\Farm;
use App\Filters\FarmFilter;
use App\Forms\FarmType;
use App\Forms\Filters\FarmFilterType;
use App\Repository\FarmRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/farm')]
class FarmController extends AbstractController
{
    #[Template('Farm/index.html.twig')]
    #[Route('/', name: 'farms_index')]
    public function indexAction(EntityManagerInterface $em, Request $request, PaginatorInterface $paginator, FarmRepository $farmRepository): array
    {
        $filter = new FarmFilter();
        $form = $this->createForm(FarmFilterType::class, $filter);
        $form->handleRequest($request);

        $fazendas = $em->getRepository(Farm::class)->getFarmsByFilter($filter);
        $countFarms = $farmRepository->getCountFarmsByFilter($filter);

        $pagination = $paginator->paginate(
            $fazendas,
            $request->query->getInt('page', 1),
            10
        );

        return [
            'form' => $form->createView(),
            'contagem' => $countFarms[0]['qtde'],
            'pagination' => $pagination
        ];
    }

    #[Template('Farm/new.html.twig')]
    #[Route('/new', name: 'farm_create')]
    public function newAction(EntityManagerInterface $em, Request $request, FarmRepository $repository): array |RedirectResponse
    {
        $novaFazenda = new Farm();
        $form = $this->createForm(FarmType::class, $novaFazenda);
        $form->handleRequest($request);

        try {
            if($form->isSubmitted() && $form->isValid()) {
                $dbFarm = $repository->findOneBy([
                    'nome' => $novaFazenda->getNome()
                ]);

                if($dbFarm) {
                    $form->get('nome')->addError(new FormError('Já existe uma fazenda cadastrada com esse Nome'));
                    return [
                        'form' => $form->createView()
                    ];
                }
                $em->persist($novaFazenda);
                $em->flush();
                $this->addFlash('success', 'Fazenda cadastrada com sucesso');

                return $this->redirectToRoute('farms_index');
            }
        } catch (\Exception $exception) {
            $this->addFlash('error', 'Ocorreu um erro ao tentar cadastrar a fazenda!');
        }

        return [
            'form' => $form->createView()
        ];
    }

    #[Template('Farm/edit.html.twig')]
    #[Route('/{farm}/edit', name: 'farm_edit')]
    public function editAtion(EntityManagerInterface $em, Request $request, Farm $farm, FarmRepository $repository) : array | RedirectResponse
    {

        try {
            $fazenda = $em->getRepository(Farm::class)->find($farm);

            $form = $this->createForm(FarmType::class, $fazenda);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {

                $dbFarm = $repository->getnameAndId($fazenda);

                if($dbFarm) {
                    $form->get('nome')->addError(new FormError('Já existe uma fazenda cadastrada com essa nome'));
                    return [
                        'form' => $form->createView()
                    ];
                }
                $em->flush();
                $this->addFlash('success', 'Fazenda editada com sucesso');

                return $this->redirectToRoute('farms_index');
            }
        } catch (\Exception $exception) {
            $this->addFlash('error', 'Ocorreu um erro ao tentar editar fazenda');
        }

        return [
            'form' => $form->createView()
        ];
    }

    #[Route('/{farm}/delete', name: 'farm_delete')]
    public function deleteAction(EntityManagerInterface $em, Farm $farm) : RedirectResponse
    {
        try {
            $em->remove($farm);
            $em->flush();

            $this->addFlash('success', 'Fazenda deletada com sucesso');
        } catch (ForeignKeyConstraintViolationException $exception) {
            $this->addFlash('error', 'Não foi possível excluir a fazenda porque existem bovinos associados a ela. ');
        }

        return $this->redirectToRoute('farms_index');
    }
}