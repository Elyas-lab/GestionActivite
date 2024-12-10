<?php

namespace App\Controller\Referentiel;

use App\Entity\Referentiel\TypeDemande;
use App\Form\Referentiel\TypeDemandeType;
use App\Repository\TypeDemandeRepository;
use App\Service\_navbarExtension; // Import _navbarExtension service
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/referentiel/type_demande')]
final class TypeDemandeController extends AbstractController
{
    public function __construct(private _navbarExtension $navbarExtension) {}

    
#[Route(name: 'app_type_index', methods: ['GET'])]
    public function index(TypeDemandeRepository $typeDemandeRepository): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            'Liste des types de demande',
            [['name' => 'Accueil', 'route' => 'app_acceuil'],['name' => 'Types de demande', 'route' => 'app_type_index']]
        );

        return $this->render('referentiel/type_demande/index.html.twig', [
            'type_demandes' => $typeDemandeRepository->findAll(),
            'navbarData' => $navbarData,
        ]);
    }

    
#[Route('/new', name: 'app_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeDemande = new TypeDemande();
        $form = $this->createForm(TypeDemandeType::class, $typeDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeDemande);
            $entityManager->flush();

            $this->addFlash('success', 'Type de demande créé avec succès.');

            return $this->redirectToRoute('app_type_index');
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Créer un type de demande',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],['name' => 'Types de demande', 'route' => 'app_type_index'],
                ['name' => 'Créer', 'route' => null],
            ]
        );

        return $this->render('referentiel/type_demande/new.html.twig', [
            'form' => $form->createView(),
            'navbarData' => $navbarData,
        ]);
    }

    
#[Route('/{id}/show', name: 'app_type_show', methods: ['GET'])]
    public function show(TypeDemande $typeDemande): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            "Détails du type de demande : {$typeDemande->getNom()}",
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],['name' => 'Types de demande', 'route' => 'app_type_index'],
                ['name' => "Type de demande : {$typeDemande->getNom()}", 'route' => null],
            ]
        );

        return $this->render('referentiel/type_demande/show.html.twig', [
            'type_demande' => $typeDemande,
            'navbarData' => $navbarData,
        ]);
    }

    
#[Route('/{id}/edit', name: 'app_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeDemande $typeDemande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeDemandeType::class, $typeDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Type de demande modifié avec succès.');

            return $this->redirectToRoute('app_type_index');
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            "Modifier le type de demande : {$typeDemande->getNom()}",
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],['name' => 'Types de demande', 'route' => 'app_type_index'],
                ['name' => "Modifier : {$typeDemande->getNom()}", 'route' => null],
            ]
        );

        return $this->render('referentiel/type_demande/edit.html.twig', [
            'form' => $form->createView(),
            'type_demande' => $typeDemande,
            'navbarData' => $navbarData,
        ]);
    }

    
#[Route('/{id}', name: 'app_type_delete', methods: ['POST'])]
    public function delete(Request $request, TypeDemande $typeDemande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeDemande->getId(), $request->get('_token'))) {
            $entityManager->remove($typeDemande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
