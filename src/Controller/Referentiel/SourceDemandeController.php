<?php

namespace App\Controller\Referentiel;

use App\Entity\Referentiel\SourceDemande;
use App\Form\Referentiel\SourceDemandeType;
use App\Repository\SourceDemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/referentiel/source_demande')]
final class SourceDemandeController extends AbstractController
{
    #[Route(name: 'app_source_index', methods: ['GET'])]
    public function index(SourceDemandeRepository $sourceDemandeRepository): Response
    {
        return $this->render('referentiel/source_demande/index.html.twig', [
            'source_demandes' => $sourceDemandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_source_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sourceDemande = new SourceDemande();
        $form = $this->createForm(SourceDemandeType::class, $sourceDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sourceDemande);
            $entityManager->flush();

            return $this->redirectToRoute('app_source_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('referentiel/source_demande/new.html.twig', [
            'source_demande' => $sourceDemande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_source_show', methods: ['GET'])]
    public function show(SourceDemande $sourceDemande): Response
    {
        return $this->render('referentiel/source_demande/show.html.twig', [
            'source_demande' => $sourceDemande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_source_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SourceDemande $sourceDemande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SourceDemandeType::class, $sourceDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_source_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('referentiel/source_demande/edit.html.twig', [
            'source_demande' => $sourceDemande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_source_delete', methods: ['POST'])]
    public function delete(Request $request, SourceDemande $sourceDemande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sourceDemande->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sourceDemande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_source_index', [], Response::HTTP_SEE_OTHER);
    }
}
