<?php

namespace App\Controller\Referentiel;

use App\Entity\Referentiel\CanalDemande;
use App\Form\Referentiel\CanalDemandeType;
use App\Repository\CanalDemandeRepository;
use App\Service\_navbarExtension; // Import _navbarExtension service
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/referentiel/canal_demande')]
final class CanalDemandeController extends AbstractController
{
    public function __construct(private _navbarExtension $navbarExtension) {}

    #[Route(name: 'app_canal_index', methods: ['GET'])]
    public function index(CanalDemandeRepository $canalDemandeRepository): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            'Liste des canaux de demande',
            [['name' => 'Accueil', 'route' => 'app_acceuil'],['name' => 'Canaux de demande', 'route' => 'app_canal_index']]
        );

        return $this->render('referentiel/canal_demande/index.html.twig', [
            'canal_demandes' => $canalDemandeRepository->findAll(),
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/new', name: 'app_canal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $canalDemande = new CanalDemande();
        $form = $this->createForm(CanalDemandeType::class, $canalDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($canalDemande);
            $entityManager->flush();

            return $this->redirectToRoute('app_canal_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Créer un canal de demande',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],['name' => 'Canaux de demande', 'route' => 'app_canal_index'],
                ['name' => 'Créer', 'route' => null],
            ]
        );

        return $this->render('referentiel/canal_demande/new.html.twig', [
            'canal_demande' => $canalDemande,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/show', name: 'app_canal_show', methods: ['GET'])]
    public function show(CanalDemande $canalDemande): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            "Détails du canal de demande : {$canalDemande->getNom()}",
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],['name' => 'Canaux de demande', 'route' => 'app_canal_index'],
                ['name' => "Canal : {$canalDemande->getNom()}", 'route' => null],
            ]
        );

        return $this->render('referentiel/canal_demande/show.html.twig', [
            'canal_demande' => $canalDemande,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_canal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CanalDemande $canalDemande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CanalDemandeType::class, $canalDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_canal_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            "Modifier le canal de demande : {$canalDemande->getNom()}",
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],['name' => 'Canaux de demande', 'route' => 'app_canal_index'],
                ['name' => "Modifier : {$canalDemande->getNom()}", 'route' => null],
            ]
        );

        return $this->render('referentiel/canal_demande/edit.html.twig', [
            'canal_demande' => $canalDemande,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}', name: 'app_canal_delete', methods: ['POST'])]
    public function delete(Request $request, CanalDemande $canalDemande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $canalDemande->getId(), $request->get('_token'))) {
            $entityManager->remove($canalDemande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_canal_index', [], Response::HTTP_SEE_OTHER);
    }
}
