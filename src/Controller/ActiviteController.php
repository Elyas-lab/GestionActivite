<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Referentiel\TypeElement;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use App\Service\_navbarExtension;
use App\Service\HistoriqueService;
use App\Service\OracleService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/activite')]
final class ActiviteController extends AbstractController
{
    private _navbarExtension $navbarExtension;
    private OracleService $oracleService;

    public function __construct(
        _navbarExtension $navbarExtension, 
        OracleService $oracleService,
        private HistoriqueService $historiqueService
    ) {
        $this->navbarExtension = $navbarExtension;
        $this->oracleService = $oracleService;
    }

   
    #[Route('/', name: 'app_activite_index', methods: ['GET'])]
    public function index(ActiviteRepository $activiteRepository): Response
    {
        $this->oracleService->setOracleSessionParams();
        
        $activites = $activiteRepository->findAll();

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Liste des activités',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Activités', 'route' => null],
            ]
        );

        return $this->render('activite/index.html.twig', [
            'navbarData' => $navbarData,
            'activites' => $activites
        ]);
    }

    
    #[Route('/new', name: 'app_activite_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->oracleService->setOracleSessionParams();
        $activite = new Activite();
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($activite);
                $entityManager->flush();

                $this->historiqueService->addHistorique(
                    TypeElement::Activite,
                    $activite->getId(),
                    'Création d\'une nouvelle activité'
                );
            } catch(Exception $e) {
                // Log the exception
                error_log($e);
            }

            return $this->redirectToRoute('app_activite_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Créer une activité',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Activités', 'route' => 'app_activite_index'],
                ['name' => 'Créer', 'route' => null],
            ]
        );

        return $this->render('activite/new.html.twig', [
            'activite' => $activite,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    
    #[Route('/{id}/edit', name: 'app_activite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Activite $activite, EntityManagerInterface $entityManager): Response
    {
        $this->oracleService->setOracleSessionParams();
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->flush();

                $this->historiqueService->addHistorique(
                    TypeElement::Activite,
                    $activite->getId(),
                    'Modification de l\'activité'
                );
            } catch(Exception $e) {
                // Log the exception
                error_log($e);
            }

            return $this->redirectToRoute('app_activite_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Modifier une activité',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Activités', 'route' => 'app_activite_index'],
                ['name' => 'Modifier', 'route' => null],
            ]
        );

        return $this->render('activite/edit.html.twig', [
            'activite' => $activite,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    
    #[Route('/{id}', name: 'app_activite_delete', methods: ['POST'])]
    public function delete(Request $request, Activite $activite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activite->getId(), $request->request->get('_token'))) {
            try {
                $this->historiqueService->addHistorique(
                    TypeElement::Activite,
                    $activite->getId(),
                    'Suppression de l\'activité'
                );

                $entityManager->remove($activite);
                $entityManager->flush();
            } catch(Exception $e) {
                // Log the exception
                error_log($e);
            }
        }

        return $this->redirectToRoute('app_activite_index', [], Response::HTTP_SEE_OTHER);
    }

    
    #[Route('/{id}/show', name: 'app_activite_show', methods: ['GET'])]
    public function show(Activite $activite): Response
    {
        $historiques = $this->historiqueService->getHistorique(
            'Activite', 
            $activite->getId(), 
            10 // Limit to 10 entries
        );

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Détails de l\'activité',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Activités', 'route' => 'app_activite_index'],
                ['name' => 'Détails', 'route' => null],
            ]
        );

        return $this->render('activite/show.html.twig', [
            'activite' => $activite,
            'navbarData' => $navbarData,
            'historiques' => $historiques,
        ]);
    }
}