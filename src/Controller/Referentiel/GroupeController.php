<?php

namespace App\Controller\Referentiel;

use App\Entity\Referentiel\Groupe;
use App\Form\Referentiel\GroupePermissionType;
use App\Form\Referentiel\GroupeType;
use App\Repository\GroupeRepository;
use App\Service\_navbarExtension; // Import _navbarExtension service
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/referentiel/groupe')]
final class GroupeController extends AbstractController
{
    public function __construct(private _navbarExtension $navbarExtension) {}

    #[Route(name: 'app_groupe_index', methods: ['GET'])]
    public function index(GroupeRepository $groupeRepository): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            'Liste des groupes',
            [['name' => 'Groupes', 'route' => 'app_groupe_index']]
        );

        return $this->render('referentiel/groupe/index.html.twig', [
            'groupes' => $groupeRepository->findAll(),
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/new', name: 'app_groupe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $groupe = new Groupe();
        $form = $this->createForm(GroupeType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($groupe);
            $entityManager->flush();

            return $this->redirectToRoute('app_groupe_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Créer un groupe',
            [
                ['name' => 'Groupes', 'route' => 'app_groupe_index'],
                ['name' => 'Créer', 'route' => null],
            ]
        );

        return $this->render('referentiel/groupe/new.html.twig', [
            'groupe' => $groupe,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/show', name: 'app_groupe_show', methods: ['GET'])]
    public function show(Groupe $groupe): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            "Détails du groupe : {$groupe->getNom()}",
            [
                ['name' => 'Groupes', 'route' => 'app_groupe_index'],
                ['name' => "Groupe : {$groupe->getNom()}", 'route' => null],
            ]
        );

        return $this->render('referentiel/groupe/show.html.twig', [
            'groupe' => $groupe,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_groupe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Groupe $groupe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GroupeType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_groupe_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            "Modifier le groupe : {$groupe->getNom()}",
            [
                ['name' => 'Groupes', 'route' => 'app_groupe_index'],
                ['name' => "Modifier : {$groupe->getNom()}", 'route' => null],
            ]
        );

        return $this->render('referentiel/groupe/edit.html.twig', [
            'groupe' => $groupe,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/groupe/{id}/permissions', name: 'app_groupe_permission')]
    public function editPermissions(Request $request, Groupe $groupe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GroupePermissionType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            $this->addFlash('success', 'Les permissions du groupe ont été mises à jour.');
            return $this->redirectToRoute('app_groupe_index');
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            "Permissions du groupe : {$groupe->getNom()}",
            [
                ['name' => 'Groupes', 'route' => 'app_groupe_index'], 
                ['name' => "Permissions : {$groupe->getNom()}", 'route' => null],
            ]
        );

        return $this->render('referentiel/groupe/permissions.html.twig', [
            'groupe' => $groupe,
            'form' => $form->createView(),
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}', name: 'app_groupe_delete', methods: ['POST'])]
    public function delete(Request $request, Groupe $groupe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $groupe->getId(), $request->get('_token'))) {
            $entityManager->remove($groupe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_groupe_index', [], Response::HTTP_SEE_OTHER);
    }
}
