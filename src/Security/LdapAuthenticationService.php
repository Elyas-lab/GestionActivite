<?php
namespace App\Security;

use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Ldap\Exception\ConnectionException;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class LdapAuthenticationService
{
    private Ldap $ldap;
    private LoggerInterface $logger;

    public function __construct(Ldap $ldap, LoggerInterface $logger)
    {
        $this->ldap = $ldap;
        $this->logger = $logger;
    }

    /**
     * Authenticate user via LDAP
     *
     * @param string $username Username to authenticate
     * @param string $password User's password
     * @return bool Authentication result
     * @throws CustomUserMessageAuthenticationException
     */
    public function authenticateWithLdap(string $username, string $password): bool
    {
        // Prevent empty username/password
        if (empty($username) || empty($password)) {
            throw new CustomUserMessageAuthenticationException('Username and password cannot be empty');
        }

        // LDAP configuration from environment with robust defaults
        $ldapConfig = $this->getLdapConfiguration();

        try {
            // Create detailed LDAP connection options
            $connectionOptions = [
                'url' => $ldapConfig['url'],
                'bind_dn' => $ldapConfig['bind_dn'],
                'bind_password' => $ldapConfig['bind_password'],
                'version' => 3,
                'optionals' => [
                    'protocol_version' => 3,
                    'referrals' => false,
                ]
            ];

            // Enable detailed logging
            $this->logger->info('LDAP Authentication Attempt', [
                'username' => $username,
                'ldap_url' => $ldapConfig['url']
            ]);

            // Create LDAP connection
            $ldap = Ldap::create('ext_ldap', $connectionOptions);

            // Bind with admin credentials
            $ldap->bind($ldapConfig['bind_dn'], $ldapConfig['bind_password']);

            // Search for user
            $query = $ldap->query($ldapConfig['base_dn'], $this->buildUserSearchFilter($username));
            $results = $query->execute();

            // Check if user exists
            if ($results->count() === 0) {
                $this->logger->warning('User not found in LDAP', ['username' => $username]);
                throw new CustomUserMessageAuthenticationException('Invalid username');
            }

            // Get user's full DN
            $userEntry = $results[0];
            $userDn = $userEntry->getDn();

            // Attempt to bind with user credentials
            $ldap->bind($userDn, $password);

            $this->logger->info('LDAP Authentication Successful', [
                'username' => $username,
                'user_dn' => $userDn
            ]);

            return true;

        } catch (ConnectionException $e) {
            $this->logger->error('LDAP Connection Failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new CustomUserMessageAuthenticationException('LDAP Authentication failed: ' . $e->getMessage());
        } catch (Exception $e) {
            $this->logger->critical('Unexpected LDAP Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new CustomUserMessageAuthenticationException('Authentication process failed');
        }
    }

    /**
     * Retrieve user details from LDAP
     *
     * @param string $username Username to search
     * @return array|null User details
     */
    public function getUserDetails(string $username): ?array
    {
        $ldapConfig = $this->getLdapConfiguration();

        try {
            $ldap = Ldap::create('ext_ldap', [
                'url' => $ldapConfig['url'],
                'bind_dn' => $ldapConfig['bind_dn'],
                'bind_password' => $ldapConfig['bind_password']
            ]);

            $ldap->bind($ldapConfig['bind_dn'], $ldapConfig['bind_password']);

            $query = $ldap->query($ldapConfig['base_dn'], $this->buildUserSearchFilter($username));
            $results = $query->execute();

            if ($results->count() === 0) {
                return null;
            }

            $entry = $results[0];
            return $this->extractUserAttributes($entry);

        } catch (ConnectionException $e) {
            $this->logger->error('LDAP User Details Query Failed', [
                'message' => $e->getMessage(),
                'username' => $username
            ]);
            throw new CustomUserMessageAuthenticationException('LDAP query failed: ' . $e->getMessage());
        }
    }

    /**
     * Get LDAP configuration with environment variables
     *
     * @return array LDAP configuration
     */
    private function getLdapConfiguration(): array
    {
        return [
            'url' => $_ENV['LDAP_HOST'] ?? 'ldap://localhost',
            'port' => $_ENV['LDAP_PORT'] ?? 389,
            'bind_dn' => $_ENV['LDAP_BIND_DN'] ?? 'cn=admin,dc=example,dc=com',
            'bind_password' => $_ENV['LDAP_BIND_PASSWORD'] ?? '',
            'base_dn' => $_ENV['LDAP_BASE_DN'] ?? 'dc=example,dc=com',
        ];
    }

    /**
     * Build a flexible user search filter
     *
     * @param string $username Username to search
     * @return string LDAP search filter
     */
    private function buildUserSearchFilter(string $username): string
    {
        // Support multiple username attributes
        $filters = [
            "(uid={$username})",
            "(sAMAccountName={$username})",
            "(cn={$username})",
            "(mail={$username})"
        ];

        return '(|' . implode('', $filters) . ')';
    }

    /**
     * Extract user attributes safely
     *
     * @param object $entry LDAP entry
     * @return array Extracted user attributes
     */
    private function extractUserAttributes($entry): array
    {
        return [
            'uid' => $this->getSingleAttribute($entry, 'uid'),
            'cn' => $this->getSingleAttribute($entry, 'cn'),
            'sn' => $this->getSingleAttribute($entry, 'sn'),
            'mail' => $this->getSingleAttribute($entry, 'mail'),
            'dn' => $entry->getDn()
        ];
    }

    /**
     * Safely retrieve a single attribute value
     *
     * @param object $entry LDAP entry
     * @param string $attribute Attribute name
     * @return string|null Attribute value
     */
    private function getSingleAttribute($entry, string $attribute): ?string
    {
        try {
            $values = $entry->getAttribute($attribute);
            return $values[0] ?? null;
        } catch (Exception $e) {
            return null;
        }
    }
}