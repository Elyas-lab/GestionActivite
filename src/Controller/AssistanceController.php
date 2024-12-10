<?php

namespace App\Controller;

use App\Entity\Assistance;
use App\Entity\Referentiel\TypeElement;
use App\Form\AssistanceType;
use App\Repository\AssistanceRepository;
use App\Service\_navbarExtension;
use App\Service\HistoriqueService;
use App\Service\OracleService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/assistance')]
final class AssistanceController extends AbstractController
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

    #[Route('/', name: 'app_assistance_index', methods: ['GET'])]
    public function index(AssistanceRepository $assistanceRepository): Response
    {
        $this->oracleService->setOracleSessionParams();
        
        $assistances = $assistanceRepository->findAll();

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Liste des assistances',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Assistances', 'route' => null],
            ]
        );

        return $this->render('assistance/index.html.twig', [
            'navbarData' => $navbarData,
            'assistances' => $assistances
        ]);
    }

    #[Route('/new', name: 'app_assistance_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->oracleService->setOracleSessionParams();
        $assistance = new Assistance();
        $form = $this->createForm(AssistanceType::class, $assistance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($assistance);
                $entityManager->flush();

                $this->historiqueService->addHistorique(
                    TypeElement::Assistance,
                    $assistance->getId(),
                    'Création d\'une nouvelle assistance'
                );
            } catch(Exception $e) {
                // Log the exception
                error_log($e);
            }

            return $this->redirectToRoute('app_assistance_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Créer une assistance',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Assistances', 'route' => 'app_assistance_index'],
                ['name' => 'Créer', 'route' => null],
            ]
        );

        return $this->render('assistance/new.html.twig', [
            'assistance' => $assistance,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_assistance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Assistance $assistance, EntityManagerInterface $entityManager): Response
    {
        $this->oracleService->setOracleSessionParams();
        $form = $this->createForm(AssistanceType::class, $assistance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->flush();

                $this->historiqueService->addHistorique(
                    TypeElement::Assistance,
                    $assistance->getId(),
                    'Modification de l\'assistance'
                );
            } catch(Exception $e) {
                // Log the exception
                error_log($e);
            }

            return $this->redirectToRoute('app_assistance_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Modifier une assistance',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Assistances', 'route' => 'app_assistance_index'],
                ['name' => 'Modifier', 'route' => null],
            ]
        );

        return $this->render('assistance/edit.html.twig', [
            'assistance' => $assistance,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}', name: 'app_assistance_delete', methods: ['POST'])]
    public function delete(Request $request, Assistance $assistance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$assistance->getId(), $request->request->get('_token'))) {
            try {
                $this->historiqueService->addHistorique(
                    TypeElement::Assistance,
                    $assistance->getId(),
                    'Suppression de l\'assistance'
                );

                $entityManager->remove($assistance);
                $entityManager->flush();
            } catch(Exception $e) {
                // Log the exception
                error_log($e);
            }
        }

        return $this->redirectToRoute('app_assistance_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/show', name: 'app_assistance_show', methods: ['GET'])]
    public function show(Assistance $assistance): Response
    {
        $historiques = $this->historiqueService->getHistorique(
            'Assistance', 
            $assistance->getId(), 
            10 // Limit to 10 entries
        );

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Détails de l\'assistance',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Assistances', 'route' => 'app_assistance_index'],
                ['name' => 'Détails', 'route' => null],
            ]
        );

        return $this->render('assistance/show.html.twig', [
            'assistance' => $assistance,
            'navbarData' => $navbarData,
            'historiques' => $historiques,
        ]);
    }
}