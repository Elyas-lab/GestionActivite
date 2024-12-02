<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use App\Service\_navbarExtension; // Import _navbarExtension service
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


#[Route('/utilisateur')]
final class UtilisateurController extends AbstractController
{
    public function __construct(private _navbarExtension $navbarExtension) {}

    #[Route(name: 'app_utilisateur_index', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            'Liste des utilisateurs',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Utilisateurs', 'route' => 'app_utilisateur_index']
            ]
        );

        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/new', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Créer un utilisateur',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Utilisateurs', 'route' => 'app_utilisateur_index'],
                ['name' => 'Créer', 'route' => null],
            ]
        );

        return $this->render('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}/show', name: 'app_utilisateur_show', methods: ['GET'])]
    public function show(Utilisateur $utilisateur): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            "Détails de l'utilisateur : {$utilisateur->getNom()}",
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Utilisateurs', 'route' => 'app_utilisateur_index'],
                ['name' => "Utilisateur : {$utilisateur->getNom()}", 'route' => null],
            ]
        );

        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/utilisateurs/list', name: 'app_utilisateur_list', methods: ['GET'])]
    public function list(Request $request, UtilisateurRepository $utilisateurRepository): JsonResponse
    {
        try {
            $queryBuilder = $utilisateurRepository->createQueryBuilder('u');
            
            // Total records without filtering
            $totalRecords = (clone $queryBuilder)->select('COUNT(u.id)')->getQuery()->getSingleScalarResult();
            
            // Apply search filtering
            $filteredRecords = $totalRecords;
            if ($search = $request->get('search')['value'] ?? null) {
                $queryBuilder->andWhere('u.nom LIKE :search OR u.matricule LIKE :search')
                             ->setParameter('search', '%' . $search . '%');
                // Get filtered records count
                $filteredRecords = (clone $queryBuilder)->select('COUNT(u.id)')->getQuery()->getSingleScalarResult();
            }
            
            // Pagination
            $start = $request->get('start', 0);
            $length = $request->get('length', 10);
            $queryBuilder->setFirstResult($start)->setMaxResults($length);
            
            // Fetch users
            $utilisateurs = $queryBuilder->getQuery()->getResult();
            
            $data = [];
            foreach ($utilisateurs as $utilisateur) {
                // Convert the collection to an array before applying array_map
                $groupes = $utilisateur->getGroupe()->toArray(); // Convert to array
                $data[] = [
                    'id' => $utilisateur->getId(),
                    'matricule' => $utilisateur->getMatricule(),
                    'groupes' => $groupes ? array_map(fn($g) => $g->getTitre(), $groupes) : [],
                    'nom' => $utilisateur->getNom(),
                    'detailUrl' => $this->generateUrl('app_utilisateur_show', ['id' => $utilisateur->getId()]),
                    'editUrl' => $this->generateUrl('app_utilisateur_edit', ['id' => $utilisateur->getId()])
                ];
            }
    
            return new JsonResponse([
                'draw' => $request->get('draw'),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            // Log the error (you can use Symfony's logger here)
            return new JsonResponse([
                'error' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }


    #[Route('/{id}/edit', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        $navbarData = $this->navbarExtension->generateNavbarData(
            "Modifier l'utilisateur : {$utilisateur->getNom()}",
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Utilisateurs', 'route' => 'app_utilisateur_index'],
                ['name' => "Modifier : {$utilisateur->getNom()}", 'route' => null],
            ]
        );

        return $this->render('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->get('_token'))) {
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
