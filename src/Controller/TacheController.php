<?php

namespace App\Controller;

use App\Entity\Referentiel\TypeElement as ReferentielTypeElement;
use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\TacheRepository;
use App\Service\_navbarExtension;
use App\Service\HistoriqueService;
use App\Service\OracleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tache')]
final class TacheController extends AbstractController
{
    private _navbarExtension $navbarExtension;
    private OracleService $oracleService;
    private HistoriqueService $historiqueService; // Ajout du service historique

    public function __construct(
        _navbarExtension $navbarExtension, 
        OracleService $oracleService,
        HistoriqueService $historiqueService // Injection du service historique
    ) {
        $this->navbarExtension = $navbarExtension;
        $this->oracleService = $oracleService;
        $this->historiqueService = $historiqueService; // Stockage du service historique
    }

    // Méthode privée pour récupérer le TypeElement pour les tâches
    private function getTacheTypeElement(): ReferentielTypeElement
    {
        // Vous devrez implémenter cette logique selon votre modèle
        // Par exemple, en récupérant le TypeElement depuis un repository
        // ou en le créant s'il n'existe pas
        return ReferentielTypeElement::Tache;// Retourne un objet TypeElement spécifique aux tâches
    }

    #[Route(name: 'app_tache_index', methods: ['GET'])]
    public function index(TacheRepository $tacheRepository): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            'Liste des tâches',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Tâches', 'route' => 'app_tache_index']
            ]
        );

        return $this->render('tache/index.html.twig', [
            'taches' => $tacheRepository->findAll(),
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/new', name: 'app_tache_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->oracleService->setOracleSessionParams();
        $tache = new Tache();
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tache);
            $entityManager->flush();

            // Ajout d'une entrée dans l'historique
            $this->historiqueService->addHistorique(
                $this->getTacheTypeElement(),
                $tache->getId(),
                "Création d'une nouvelle tâche : {$tache->getTitre()}"
            );

            return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Créer une tâche',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Tâches', 'route' => 'app_tache_index'],
                ['name' => 'Créer', 'route' => null],
            ]
        );

        return $this->render('tache/new.html.twig', [
            'tache' => $tache,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tache_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tache $tache, EntityManagerInterface $entityManager): Response
    {
        $this->oracleService->setOracleSessionParams();
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // Ajout d'une entrée dans l'historique
            $this->historiqueService->addHistorique(
                $this->getTacheTypeElement(),
                $tache->getId(),
                "Modification de la tâche : {$tache->getTitre()}"
            );

            return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            "Modifier la tâche : {$tache->getTitre()}",
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Tâches', 'route' => 'app_tache_index'],
                ['name' => "Modifier : {$tache->getTitre()}", 'route' => null],
            ]
        );

        return $this->render('tache/edit.html.twig', [
            'tache' => $tache,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}', name: 'app_tache_delete', methods: ['POST'])]
    public function delete(Request $request, Tache $tache, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tache->getId(), $request->get('_token'))) {
            // Ajout d'une entrée dans l'historique avant la suppression
            $this->historiqueService->addHistorique(
                $this->getTacheTypeElement(),
                $tache->getId(),
                "Suppression de la tâche : {$tache->getTitre()}"
            );

            $entityManager->remove($tache);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/show', name: 'app_tache_show', methods: ['GET'])]
    public function show(Tache $tache): Response
    {
        // Récupérer l'historique de la tâche
        $historiques = $this->historiqueService->getHistorique(
            'Tache', 
            $tache->getId(), 
            10 // Limiter à 10 entrées
        );

        $navbarData = $this->navbarExtension->generateNavbarData(
            "Détails de la tâche : {$tache->getTitre()}",
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Tâches', 'route' => 'app_tache_index'],
                ['name' => "Tâche : {$tache->getTitre()}", 'route' => null],
            ]
        );

        return $this->render('tache/show.html.twig', [
            'tache' => $tache,
            'navbarData' => $navbarData,
            'historiques' => $historiques, // Passer l'historique à la vue
        ]);
    }
}