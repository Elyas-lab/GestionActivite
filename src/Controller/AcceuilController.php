<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Service\_navbarExtension; // Importation du service _navbarExtension
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class AcceuilController extends AbstractController
{
    private _navbarExtension $navbarExtension;

    public function __construct(_navbarExtension $navbarExtension)
    {
        $this->navbarExtension = $navbarExtension;
    }

    #[Route('/', name: 'app_acceuil')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Génération des données de la navbar
        $navbarData = $this->navbarExtension->generateNavbarData(
            'Tableau de bord',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
            ]
        );

        // Création d'utilisateur (optionnel, commenté ici pour éviter de générer un utilisateur à chaque appel)
        // $user = $this->createUser($entityManager, $passwordHasher);

        return $this->render('Index/index.html.twig', [
            'controller_name' => 'AcceuilController',
            'navbarData' => $navbarData,
            // 'message' => 'Nouvel utilisateur créé avec l\'ID : ' . $user->getId(),
        ]);
    }

    private function createUser(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Utilisateur
    {
        $user = new Utilisateur();
        $user->setMatricule('12346');
        $user->setNom('Doe');
        $user->setRoles(['ROLE_USER']);

        // Hachage du mot de passe
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            'motdepasse123'
        );
        $user->setPassword($hashedPassword);

        // Persistance de l'utilisateur dans la base de données
        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }
}
