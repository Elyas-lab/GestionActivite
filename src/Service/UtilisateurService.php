<?php
namespace App\Service;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurService {
    private $passwordHasher;
    private $entityManager;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    public function createUser(Utilisateur $utilisateur)
    {
        // Get the plain password
        $plainPassword = $utilisateur->getPassword();
        
        if (!$utilisateur->getPassword()) {
            throw new \InvalidArgumentException('Le mot de passe ne peut pas être vide.');
        }
        // Hash the password
        $hashedPassword = $this->passwordHasher->hashPassword(
            $utilisateur,
            $plainPassword
        );

        // Set the hashed password
        $utilisateur->setPassword($hashedPassword);

        // Persist and flush
        $this->entityManager->persist($utilisateur);
        $this->entityManager->flush();
    }

}
