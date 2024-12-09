<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use App\Security\LdapAuthenticationService;
use Psr\Log\LoggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class UserAuthenticationService
{
    private $entityManager;
    private $ldapAuthService;

    public function __construct(
        EntityManagerInterface $entityManager, 
        LdapAuthenticationService $ldapAuthService,
        private LoggerInterface $logger,
        private UtilisateurService $utilisateurService
    ) {
        $this->entityManager = $entityManager;
        $this->ldapAuthService = $ldapAuthService;
    }

    public function authenticate(string $username, string $password): bool
    {
        // Validation initiale du nom d'utilisateur et du mot de passe
        if (empty($username) || empty($password)) {
            throw new BadCredentialsException('Nom d\'utilisateur ou mot de passe vide.');
        }
    
        // Recherche de l'utilisateur avec gestion d'erreur améliorée
        try {
            $user = $this->entityManager->getRepository(Utilisateur::class)
                ->findOneBy(['matricule' => $username]);
    
            // Si l'utilisateur n'existe pas localement, tenter l'authentification LDAP
            if (!$user) {
                try {
                    $ldapSuccess = $this->ldapAuthService->authenticate($username, $password);
                    if ($ldapSuccess) {
                        // Optionnel : Créer un utilisateur local après authentification LDAP
                        return true;
                    }
                } catch (\Exception $ldapException) {
                    // Log de l'erreur LDAP
                    throw new BadCredentialsException('Échec de l\'authentification LDAP : ' . $ldapException->getMessage());
                }
            }
    
            // Vérification du mot de passe local
            if ($user && password_verify($password, $user->getPassword())) {
                return true;
            }
    
            // Si aucune authentification n'a réussi
            throw new BadCredentialsException('Authentification échouée.');
    
        } catch (\Exception $e) {
            // Gestion générique des erreurs
            throw new BadCredentialsException('Erreur durant l\'authentification : ' . $e->getMessage());
        }
    }
    
    public function getUser(string $username): ?Utilisateur
    {
        // Recherche de l'utilisateur avec plus de flexibilité
        $user = $this->entityManager->getRepository(Utilisateur::class)
            ->createQueryBuilder('u')
            ->where('u.matricule = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    
        if (!$user) {
            // Tentative de récupération des détails LDAP
            try {
                $ldapDetails = $this->ldapAuthService->getUserDetails($username);
                if ($ldapDetails) {
                    $user = new Utilisateur();
                    $user->setMatricule($ldapDetails['uid'] ?? $username);
                    $user->setNom($ldapDetails['cn'] ?? 'Unknown');
                    $user->setPassword('temp');
                    $user= $this->utilisateurService->createUser($user);
                
                    return $user;
                }
            } catch (\Exception $e) {
                // Log de l'erreur de récupération LDAP
            }
    
            throw new AccessDeniedException('Utilisateur non autorisé.');
        }
    
        return $user;
    }
}