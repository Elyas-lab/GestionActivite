<?php

namespace App\Controller\Referentiel;

use App\Entity\Referentiel\Statut;
use App\Form\Referentiel\StatutType;
use App\Repository\StatutRepository;
use App\Service\_navbarExtension; // Import _navbarExtension service
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/referentiel/statut')]
final class StatutController extends AbstractController
{
    public function __construct(private _navbarExtension $navbarExtension) {}

    #[Route(name: 'app_statut_index', methods: ['GET'])]
    public function index(StatutRepository $statutRepository): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            'Liste des statuts',
            [['name' => 'Accueil', 'route' => 'app_acceuil'],['name' => 'Statuts', 'route' => 'app_statut_index']]
        );

        return $this->render('referentiel/statut/index.html.twig', [
            'statuts' => $statutRepository->findAll(),
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/new', name: 'app_statut_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $statut = new Statut();
        $form = $this->createForm(StatutType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($statut);
            $entityManager->flush();

            $this->addFlash('success', 'Statut créé avec succès.');

            return $this->redirectToRoute('app_statut_index');
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Créer un statut',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],['name' => 'Statuts', 'route' => 'app_statut_index'],
                ['name' => 'Créer', 'route' => null],
            ]
        );

        return $this->render('referentiel/statut/new.html.twig', [
            'form' => $form->createView(),
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/show', name: 'app_statut_show', methods: ['GET'])]
    public function show(Statut $statut): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            "Détails du statut : {$statut->getNom()}",
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],['name' => 'Statuts', 'route' => 'app_statut_index'],
                ['name' => "Statut : {$statut->getNom()}", 'route' => null],
            ]
        );

        return $this->render('referentiel/statut/show.html.twig', [
            'statut' => $statut,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_statut_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Statut $statut, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StatutType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Statut modifié avec succès.');

            return $this->redirectToRoute('app_statut_index');
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            "Modifier le statut : {$statut->getNom()}",
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],['name' => 'Statuts', 'route' => 'app_statut_index'],
                ['name' => "Modifier : {$statut->getNom()}", 'route' => null],
            ]
        );

        return $this->render('referentiel/statut/edit.html.twig', [
            'form' => $form->createView(),
            'statut' => $statut,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}', name: 'app_statut_delete', methods: ['POST'])]
    public function delete(Request $request, Statut $statut, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$statut->getId(), $request->get('_token'))) {
            $entityManager->remove($statut);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_statut_index', [], Response::HTTP_SEE_OTHER);
    }
}
