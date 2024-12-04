<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class UserAuthenticationService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function authenticate(string $username, string $password): bool
    {
        // Chercher l'utilisateur par son nom d'utilisateur
        $user = $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['matricule' => $username]);

        if (!$user || !password_verify($password, $user->getPassword())) {
            // dd( password_verify($password, $user->getPassword()));
            throw new BadCredentialsException('Mot de passe éroné.');
        }

        return true;
    }

    public function getUser(string $username): Utilisateur
    {
        $user = $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['matricule' => $username]);

        if (!$user) {
            throw new BadCredentialsException('Utilisateur not found.');
        }

        return $user;
    }
}
