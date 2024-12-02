<?php

namespace App\Controller;

use App\Entity\Assistance;
use App\Form\AssistanceType;
use App\Repository\AssistanceRepository;
use App\Service\_navbarExtension; // Import the NavbarExtension service
use App\Service\OracleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/assistance')]
final class AssistanceController extends AbstractController
{
    private _navbarExtension $navbarExtension;
    private OracleService $oracleService; // Add this property

    // Update the constructor to include OracleService
    public function __construct(
        _navbarExtension $navbarExtension, 
        OracleService $oracleService
    ) {
        $this->navbarExtension = $navbarExtension;
        $this->oracleService = $oracleService; // Store the OracleService
    }


    #[Route(name: 'app_assistance_index', methods: ['GET'])]
    public function index(AssistanceRepository $assistanceRepository): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            'Assistances',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Liste des assistances', 'route' => 'app_assistance_index'],
            ]
        );

        return $this->render('assistance/index.html.twig', [
            'assistances' => $assistanceRepository->findAll(),
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/new', name: 'app_assistance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->oracleService->setOracleSessionParams();
        $assistance = new Assistance();
        $form = $this->createForm(AssistanceType::class, $assistance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($assistance);
            $entityManager->flush();

            return $this->redirectToRoute('app_assistance_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Créer une assistance',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Liste des assistances', 'route' => 'app_assistance_index'],
                ['name' => 'Créer une assistance', 'route' => null],
            ]
        );

        return $this->render('assistance/new.html.twig', [
            'assistance' => $assistance,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/show', name: 'app_assistance_show', methods: ['GET'])]
    public function show(Assistance $assistance): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            'Détails de l\'assistance',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Liste des assistances', 'route' => 'app_assistance_index'],
                ['name' => 'Détails de l\'assistance', 'route' => null],
            ]
        );

        return $this->render('assistance/show.html.twig', [
            'assistance' => $assistance,
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
            $entityManager->flush();

            return $this->redirectToRoute('app_assistance_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Modifier une assistance',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Liste des assistances', 'route' => 'app_assistance_index'],
                ['name' => 'Modifier une assistance', 'route' => null],
            ]
        );

        return $this->render('assistance/edit.html.twig', [
            'assistance' => $assistance,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_assistance_delete', methods: ['POST'])]
    public function delete(Request $request, Assistance $assistance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$assistance->getId(), $request->request->get('_token'))) {
            $entityManager->remove($assistance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_assistance_index', [], Response::HTTP_SEE_OTHER);
    }
}
