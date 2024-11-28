<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use App\Service\_navbarExtension; // Import _navbarExtension service
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/projet')]
final class ProjetController extends AbstractController
{
    public function __construct(private _navbarExtension $navbarExtension) {}

    #[Route(name: 'app_projet_index', methods: ['GET'])]
    public function index(ProjetRepository $projetRepository): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            'Liste des projets',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Projets', 'route' => 'app_projet_index']
            ]
        );

        return $this->render('projet/index.html.twig', [
            'projets' => $projetRepository->findAll(),
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/new', name: 'app_projet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Créer un projet',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Projets', 'route' => 'app_projet_index'],
                ['name' => 'Créer', 'route' => null],
            ]
        );

        return $this->render('projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/show', name: 'app_projet_show', methods: ['GET'])]
    public function show(Projet $projet): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            "Détails du projet : {$projet->getTitre()}",
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Projets', 'route' => 'app_projet_index'],
                ['name' => "Projet : {$projet->getTitre()}", 'route' => null],
            ]
        );

        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_projet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            "Modifier le projet : {$projet->getTitre()}",
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Projets', 'route' => 'app_projet_index'],
                ['name' => "Modifier : {$projet->getTitre()}", 'route' => null],
            ]
        );

        return $this->render('projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}', name: 'app_projet_delete', methods: ['POST'])]
    public function delete(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->get('_token'))) {
            $entityManager->remove($projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
    }
}
