<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use App\Security\LdapAuthenticationService;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class UserAuthenticationService
{
    private $entityManager;
    private $ldapAuthService;

    public function __construct(
        EntityManagerInterface $entityManager, 
        LdapAuthenticationService $ldapAuthService
    ) {
        $this->entityManager = $entityManager;
        $this->ldapAuthService = $ldapAuthService;
    }

    public function authenticate(string $username, string $password): bool
    {
        // Vérifier d'abord si l'utilisateur existe localement
        $user = $this->entityManager->getRepository(Utilisateur::class)
            ->findOneBy(['matricule' => $username]);

        // Si l'utilisateur n'existe pas localement, refuser l'accès
        if (!$user) {
                $ldapSuccess = $this->ldapAuthService->authenticateWithLdap($username, $password);
                if ($ldapSuccess) {
                    return true;
                }
        }else if(password_verify($password, $user->getPassword())) {
            // Tenter l'authentification via LDAP
            return true;
        }
        else{
        throw new BadCredentialsException('Authentification échouée.');
        return false;
       }
}

    public function getUser(string $username): Utilisateur
    {
        $user = $this->entityManager->getRepository(Utilisateur::class)
            ->findOneBy(['matricule' => $username]);

        if (!$user) {
            throw new AccessDeniedException('Utilisateur non autorisé.');
        }

        return $user;
    }
}