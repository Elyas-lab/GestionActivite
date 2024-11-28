<?php

namespace App\Controller\Referentiel;

use App\Entity\Referentiel\SourceDemande;
use App\Form\Referentiel\SourceDemandeType;
use App\Repository\SourceDemandeRepository;
use App\Service\_navbarExtension; // Import _navbarExtension service
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/referentiel/source_demande')]
final class SourceDemandeController extends AbstractController
{
    public function __construct(private _navbarExtension $navbarExtension) {}

    #[Route(name: 'app_source_index', methods: ['GET'])]
    public function index(SourceDemandeRepository $sourceDemandeRepository): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            'Liste des sources de demande',
            [['name' => 'Sources de demande', 'route' => 'app_source_index']]
        );

        return $this->render('referentiel/source_demande/index.html.twig', [
            'source_demandes' => $sourceDemandeRepository->findAll(),
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/new', name: 'app_source_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sourceDemande = new SourceDemande();
        $form = $this->createForm(SourceDemandeType::class, $sourceDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sourceDemande);
            $entityManager->flush();

            $this->addFlash('success', 'Source de demande créée avec succès.');

            return $this->redirectToRoute('app_source_index');
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Créer une source de demande',
            [
                ['name' => 'Sources de demande', 'route' => 'app_source_index'],
                ['name' => 'Créer', 'route' => null],
            ]
        );

        return $this->render('referentiel/source_demande/new.html.twig', [
            'form' => $form->createView(),
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/show', name: 'app_source_show', methods: ['GET'])]
    public function show(SourceDemande $sourceDemande): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            "Détails de la source de demande : {$sourceDemande->getNom()}",
            [
                ['name' => 'Sources de demande', 'route' => 'app_source_index'],
                ['name' => "Source de demande : {$sourceDemande->getNom()}", 'route' => null],
            ]
        );

        return $this->render('referentiel/source_demande/show.html.twig', [
            'source_demande' => $sourceDemande,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_source_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SourceDemande $sourceDemande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SourceDemandeType::class, $sourceDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Source de demande modifiée avec succès.');

            return $this->redirectToRoute('app_source_index');
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            "Modifier la source de demande : {$sourceDemande->getNom()}",
            [
                ['name' => 'Sources de demande', 'route' => 'app_source_index'],
                ['name' => "Modifier : {$sourceDemande->getNom()}", 'route' => null],
            ]
        );

        return $this->render('referentiel/source_demande/edit.html.twig', [
            'form' => $form->createView(),
            'source_demande' => $sourceDemande,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}', name: 'app_source_delete', methods: ['POST'])]
    public function delete(Request $request, SourceDemande $sourceDemande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sourceDemande->getId(), $request->get('_token'))) {
            $entityManager->remove($sourceDemande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_source_index', [], Response::HTTP_SEE_OTHER);
    }
}
