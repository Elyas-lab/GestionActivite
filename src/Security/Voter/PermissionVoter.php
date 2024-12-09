<?php
namespace App\Security\Voter;

use App\Entity\Utilisateur;
use App\Entity\Referentiel\Permission as ReferentielPermission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class PermissionVoter implements VoterInterface 
{
    private TokenStorageInterface $tokenStorage;
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function vote(TokenInterface $token, mixed $subject, array $attributes): int
    {
        // Vérifier si au moins un attribut correspond à nos permissions
        $supportedAttributes = array_filter($attributes, function($attribute) {
            return is_string($attribute) && preg_match('/^PERM_/', $attribute);
        });

        // Si aucun attribut supporté, on s'abstient
        if (empty($supportedAttributes)) {
            return self::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();

        if (!$user instanceof Utilisateur) {
            return self::ACCESS_DENIED;
        }

        $userPermissions = $this->getUserPermissions($user);

        // Vérifier si l'utilisateur a au moins une des permissions requises
        foreach ($supportedAttributes as $attribute) {
            if (in_array($attribute, $userPermissions)) {
                return self::ACCESS_GRANTED;
            }
        }

        return self::ACCESS_DENIED;
    }

    private function getUserPermissions(Utilisateur $user): array
    {
        $permissions = [];

        foreach ($user->getGroupes() as $groupe) {
            $groupPermissions = $groupe->getPermissions();

            if ($groupPermissions instanceof \Traversable) {
                $permissions = array_merge($permissions, iterator_to_array($groupPermissions));
            } elseif ($groupPermissions instanceof ReferentielPermission) {
                $permissions[] = $groupPermissions;
            }
        }

        return array_map(function(ReferentielPermission $permission) {
            return 'PERM_' . $permission->getNom();
        }, $permissions);
    }
}