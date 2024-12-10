<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use App\Service\_navbarExtension; // Import _navbarExtension service
use App\Service\UtilisateurService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;



#[Route('/utilisateur')]
final class UtilisateurController extends AbstractController
{
    public function __construct(private _navbarExtension $navbarExtension) {}

    
#[Route(name: 'app_utilisateur_index', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            'Liste des utilisateurs',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Utilisateurs', 'route' => 'app_utilisateur_index']
            ]
        );

        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
            'navbarData' => $navbarData,
        ]);
    }

    
#[Route('/new', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UtilisateurService $utilisateurService): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Utilise le service pour créer un utilisateur
                $utilisateurService->createUser($utilisateur);
                $this->addFlash('success', 'Utilisateur créé avec succès.');
    
                return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de la création de l’utilisateur : ' . $e->getMessage());
            }
        }
    
        $navbarData = $this->navbarExtension->generateNavbarData(
            'Créer un utilisateur',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Utilisateurs', 'route' => 'app_utilisateur_index'],
                ['name' => 'Créer', 'route' => null],
            ]
        );
    
        return $this->render('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
            'navbarData' => $navbarData,
        ]);
    }
    

    
#[Route('/{id}/show', name: 'app_utilisateur_show', methods: ['GET'])]
    public function show(Utilisateur $utilisateur): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            "Détails de l'utilisateur : {$utilisateur->getNom()}",
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Utilisateurs', 'route' => 'app_utilisateur_index'],
                ['name' => "Utilisateur : {$utilisateur->getNom()}", 'route' => null],
            ]
        );

        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
            'navbarData' => $navbarData,
        ]);
    }

    
#[Route('/{id}/edit', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            "Modifier l'utilisateur : {$utilisateur->getNom()}",
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Utilisateurs', 'route' => 'app_utilisateur_index'],
                ['name' => "Modifier : {$utilisateur->getNom()}", 'route' => null],
            ]
        );

        return $this->render('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    
#[Route('/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->get('_token'))) {
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
