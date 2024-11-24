<?php

namespace App\Controller\Referentiel;

use App\Entity\Referentiel\TypeDemande;
use App\Form\Referentiel\TypeDemandeType;
use App\Repository\TypeDemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/referentiel/type_demande')]
final class TypeDemandeController extends AbstractController
{
    #[Route(name: 'app_type_index', methods: ['GET'])]
    public function index(TypeDemandeRepository $typeDemandeRepository): Response
    {
        return $this->render('referentiel/type_demande/index.html.twig', [
            'type_demandes' => $typeDemandeRepository->findAll(),
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

            return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('referentiel/type_demande/new.html.twig', [
            'type_demande' => $typeDemande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_type_demande_show', methods: ['GET'])]
    public function show(TypeDemande $typeDemande): Response
    {
        return $this->render('referentiel/type_demande/show.html.twig', [
            'type_demande' => $typeDemande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeDemande $typeDemande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeDemandeType::class, $typeDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('referentiel/type_demande/edit.html.twig', [
            'type_demande' => $typeDemande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_delete', methods: ['POST'])]
    public function delete(Request $request, TypeDemande $typeDemande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeDemande->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($typeDemande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
