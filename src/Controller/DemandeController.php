<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\DemandeType;
use App\Repository\DemandeRepository;
use App\Service\_navbarExtension; // Import the _navbarExtension service
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/demande')]
final class DemandeController extends AbstractController
{
    private _navbarExtension $navbarExtension;

    public function __construct(_navbarExtension $navbarExtension)
    {
        $this->navbarExtension = $navbarExtension;
    }

    #[Route(name: 'app_demande_index', methods: ['GET'])]
    public function index(DemandeRepository $demandeRepository): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            'Demandes',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Liste des demandes', 'route' => 'app_demande_index'],
            ]
        );

        return $this->render('demande/index.html.twig', [
            'demandes' => $demandeRepository->findAll(),
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/new', name: 'app_demande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($demande);
            $entityManager->flush();

            return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Créer une demande',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Liste des demandes', 'route' => 'app_demande_index'],
                ['name' => 'Créer une demande', 'route' => null],
            ]
        );

        return $this->render('demande/new.html.twig', [
            'demande' => $demande,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/show', name: 'app_demande_show', methods: ['GET'])]
    public function show(Demande $demande): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            'Détails de la demande',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Liste des demandes', 'route' => 'app_demande_index'],
                ['name' => 'Détails de la demande', 'route' => null],
            ]
        );

        return $this->render('demande/show.html.twig', [
            'demande' => $demande,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_demande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Modifier une demande',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Liste des demandes', 'route' => 'app_demande_index'],
                ['name' => 'Modifier une demande', 'route' => null],
            ]
        );

        return $this->render('demande/edit.html.twig', [
            'demande' => $demande,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_demande_delete', methods: ['POST'])]
    public function delete(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($demande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
    }
}
