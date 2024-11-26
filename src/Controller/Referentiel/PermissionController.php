<?php

namespace App\Controller\Referentiel;

use App\Entity\Referentiel\Permission;
use App\Form\Referentiel\PermissionType;
use App\Repository\PermissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/referentiel/permission')]
final class PermissionController extends AbstractController
{
    #[Route(name: 'app_permission_index', methods: ['GET'])]
    public function index(PermissionRepository $permissionRepository): Response
    {
        return $this->render('referentiel/permission/index.html.twig', [
            'permissions' => $permissionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_permission_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $permission = new Permission();
        $form = $this->createForm(PermissionType::class, $permission);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($permission);
            $entityManager->flush();
    
            $this->addFlash('success', 'Permission créée avec succès.');
    
            return $this->redirectToRoute('app_permission_index');
        }
    
        return $this->render('referentiel/permission/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/edit/{id}', name: 'app_permission_edit')]
    public function edit(Permission $permission, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PermissionType::class, $permission);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            $this->addFlash('success', 'Permission modifiée avec succès.');
    
            return $this->redirectToRoute('app_permission_index');
        }
    
        return $this->render('referentiel/permission/edit.html.twig', [
            'form' => $form->createView(),
            'permission' => $permission,
        ]);
    }
    
    
        #[Route('/{id}/show', name: 'app_permission_show', methods: ['GET'])]
        public function show(Permission $permission): Response
        {
            return $this->render('referentiel/permission/show.html.twig', [
                'permission' => $permission,
            ]);
        }
    
    #[Route('/{id}', name: 'app_permission_delete', methods: ['POST'])]
    public function delete(Request $request, Permission $permission, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$permission->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($permission);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_permission_index', [], Response::HTTP_SEE_OTHER);
    }
}
