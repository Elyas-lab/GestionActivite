<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/activite')]
final class ActiviteController extends AbstractController
{
    #[Route(name: 'app_activite_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('activite/index.html.twig');
    }

    #[Route('/data', name: 'app_activite_data', methods: ['GET'])]
    public function listData(Request $request, ActiviteRepository $activiteRepository): JsonResponse
    {
        $draw = $request->query->getInt('draw');
        $start = $request->query->getInt('start');
        $length = $request->query->getInt('length');
        $search = $request->query->get('search')['value'];
        $orders = $request->query->all('order');
    
        $columns = [
            0 => 'id',
            1 => 'titre',
            2 => 'description',
            3 => 'dateDebut',
            4 => 'dateFin',
            5 => 'statut'
        ];
    
        $totalData = $activiteRepository->count([]);
    
        $query = $activiteRepository->createQueryBuilder('a');
    
        if (!empty($search)) {
            $query->where('a.titre LIKE :search OR a.description LIKE :search OR a.statut LIKE :search')
                  ->setParameter('search', '%' . $search . '%');
        }
    
        foreach ($orders as $order) {
            $orderColumn = $columns[$order['column']];
            $orderDir = $order['dir'];
            $query->addOrderBy('a.' . $orderColumn, $orderDir);
        }
    
        $query->setFirstResult($start)
              ->setMaxResults($length);
    
        $results = $query->getQuery()->getResult();
        $totalFiltered = count($results);
    
        $data = [];
        foreach ($results as $activite) {
            $data[] = [
                "id" => $activite->getId(),
                "titre" => $activite->getTitre(),
                "description" => $activite->getDescription(),
                "dateDebut" => $activite->getDateDebut() ? $activite->getDateDebut()->format('Y-m-d H:i') : 'N/A',
                "dateFin" => $activite->getDateFin() ? $activite->getDateFin()->format('Y-m-d H:i') : 'N/A',
                "statut" => $activite->getStatut(),
                "actions" => $this->renderView('activite/_actions.html.twig', ['activite' => $activite])
            ];
        }
    
        return new JsonResponse([
            'draw' => $draw,
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }

    #[Route('/new', name: 'app_activite_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $activite = new Activite();
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($activite);
            $entityManager->flush();

            return $this->redirectToRoute('app_activite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('activite/new.html.twig', [
            'activite' => $activite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_activite_show', methods: ['GET'])]
    public function show(Activite $activite): Response
    {
        return $this->render('activite/show.html.twig', [
            'activite' => $activite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_activite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Activite $activite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_activite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('activite/edit.html.twig', [
            'activite' => $activite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_activite_delete', methods: ['POST'])]
    public function delete(Request $request, Activite $activite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activite->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($activite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_activite_index', [], Response::HTTP_SEE_OTHER);
    }
}
