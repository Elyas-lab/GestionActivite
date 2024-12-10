<?php

namespace App\Security;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Ldap\Exception\ConnectionException;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use App\Exception\NonConformityException;
use App\Exception\NotAuthorizedException;
use App\Service\UtilisateurService;

class LdapAuthenticationService
{
    private Ldap $ldap;
    private LoggerInterface $logger;
    private EntityManagerInterface $entityManager;

    public function __construct(Ldap $ldap, LoggerInterface $logger, EntityManagerInterface $entityManager, private UtilisateurService $utilisateurService)
    {
        $this->ldap = $ldap;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    /**
     * Authenticate user via LDAP and database.
     *
     * @param string $username
     * @param string $password
     * @return bool
     * @throws CustomUserMessageAuthenticationException
     * @throws NonConformityException
     * @throws NotAuthorizedException
     */
    public function authenticate(string $username, string $password): bool
    {
        // Validate username format
        if (!preg_match('/^[a-zA-Z0-9._-]+$/', $username)) {
            throw new NonConformityException('Format non conforme.');
        }

        // Check user existence in the database
        // $user = $this->entityManager->getRepository('App:Utilisateur')->findOneBy(['username' => $username]);
        // if (!$user) {
        //     throw new NotAuthorizedException('Utilisateur non autorisé.');
        // }

        // Proceed with LDAP authentication
        return $this->authenticateWithLdap($username, $password);
    }
    public function getUserDetails($username)
    {
        $details = [];
    
        try {

            // Add more detailed logging
            $this->logger->debug('Attempting to retrieve user details', [
                'username' => $username,
                'ldap_config' => $this->getLdapConfiguration()
            ]);

            $ldapConfig = $this->getLdapConfiguration();
            $this->ldap->bind($ldapConfig['bind_dn'], $ldapConfig['bind_password']);
    
            $query = $this->ldap->query($ldapConfig['base_dn'], $this->buildUserSearchFilter($username));
            $results = $query->execute();
            if ($results->count() > 0) {
                $entry = $results[0];
                
                $userDetails = [
                    'dn' => $entry->getDn(), 
                    'uid' => $entry->getAttribute('uid')[0] ?? null,
                    'cn' => $entry->getAttribute('cn')[0] ?? null                 ];
    
                $this->logger->info('Retrieved user details for username: ' . $username, ['details' => $details]);
    
                return $userDetails;
            } else {
                throw new NotAuthorizedException('User not found in LDAP.');
            }
        } catch (ConnectionException $e) {
            $this->logger->error('LDAP Connection Failed', [
                'username' => $username,
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
           throw new NotAuthorizedException('User not found in LDAP.');
        }
    }

    private function authenticateWithLdap(string $username, string $password): bool
    {
        try {
            $ldapConfig = $this->getLdapConfiguration();
            $this->ldap->bind($ldapConfig['bind_dn'], $ldapConfig['bind_password']);

            $query = $this->ldap->query($ldapConfig['base_dn'], $this->buildUserSearchFilter($username));
            $results = $query->execute();

            if ($results->count() === 0) {
                throw new NotAuthorizedException('Utilisateur non autorisé.');
            }

            $userEntry = $results[0];
            $userDn = $userEntry->getDn();

            $this->ldap->bind($userDn, $password);

            $this->logger->info('LDAP authentication successful.', ['username' => $username]);

            return true;
        } catch (ConnectionException $e) {
            $this->logger->error('LDAP connection failed.', ['error' => $e->getMessage()]);
            throw new CustomUserMessageAuthenticationException('Authentication failed.');
        }
    }

    private function getLdapConfiguration(): array
    {
        return [
            'url' => $_ENV['LDAP_HOST'] ?? 'ldap://localhost',
            'bind_dn' => $_ENV['LDAP_DN'] ?? 'cn=admin,dc=example,dc=com',
            'bind_password' => $_ENV['LDAP_PASSWORD'] ?? '',
            'base_dn' => $_ENV['LDAP_BASE_DN'] ?? 'dc=example,dc=com',
        ];
    }

    private function buildUserSearchFilter(string $username): string
    {
        $escapedUsername = addslashes($username);
        return sprintf('(|(uid=%s)(cn=%s))', $escapedUsername, $escapedUsername);
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
                $ldapDetails = $this->getUserDetails($username);
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
    
            // throw new NotAuthorizedException('Utilisateur non autorisé.');
        }
    
        return $user;
    }
}
