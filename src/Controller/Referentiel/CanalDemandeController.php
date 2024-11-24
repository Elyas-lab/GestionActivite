<?php

namespace App\Controller\Referentiel;

use App\Entity\Referentiel\CanalDemande;
use App\Form\Referentiel\CanalDemandeType;
use App\Repository\CanalDemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/referentiel/canal_demande')]
final class CanalDemandeController extends AbstractController
{
    #[Route(name: 'app_canal_index', methods: ['GET'])]
    public function index(CanalDemandeRepository $canalDemandeRepository): Response
    {
        return $this->render('referentiel/canal_demande/index.html.twig', [
            'canal_demandes' => $canalDemandeRepository->findAll(),
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

        return $this->render('referentiel/canal_demande/new.html.twig', [
            'canal_demande' => $canalDemande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_canal_show', methods: ['GET'])]
    public function show(CanalDemande $canalDemande): Response
    {
        return $this->render('referentiel/canal_demande/show.html.twig', [
            'canal_demande' => $canalDemande,
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

        return $this->render('referentiel/canal_demande/edit.html.twig', [
            'canal_demande' => $canalDemande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_canal_delete', methods: ['POST'])]
    public function delete(Request $request, CanalDemande $canalDemande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$canalDemande->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($canalDemande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_canal_index', [], Response::HTTP_SEE_OTHER);
    }
}
