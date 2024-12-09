<?php

namespace App\Service;

use App\Entity\Utilisateur;
use App\Entity\Referentiel\Permission as ReferentielPermission;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\CacheInterface;

class SidebarExtension
{
    private TokenStorageInterface $tokenStorage;
    private EntityManagerInterface $entityManager;
    private CacheInterface $cache;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager, CacheInterface $cache)
    {
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
        $this->cache = $cache;
    }

    public function getSidebarItems(): array
    {
        $user = $this->tokenStorage->getToken()?->getUser();

        if (!$user) {
            return [];
        }

        $permissions = $this->getUserPermissions($user);

        $menu = [
            'Activite' => [
                'route' => 'app_activite_index',
                'icon' => 'fa-tasks',
                'label' => 'Activités',
                'required_permissions' => ['Activite_voir_mien', 'Activite_voir_tous'],
            ],
            'Assistance' => [
                'route' => 'app_assistance_index',
                'icon' => 'fa-hand-holding',
                'label' => 'Assistances',
                'required_permissions' => ['Assistance_voir_mien', 'Assistance_voir_tous'],
            ],
            'Projet' => [
                'route' => 'app_projet_index',
                'icon' => 'fa-project-diagram',
                'label' => 'Projets',
                'required_permissions' => ['Projet_voir_mien', 'Projet_voir_tous'],
            ],
            'Demande' => [
                'route' => 'app_demande_index',
                'icon' => 'fa-ticket-alt',
                'label' => 'Demandes',
                'required_permissions' => ['Demande_voir_mien', 'Demande_voir_tous'],
            ],
            'Tache' => [
                'route' => 'app_tache_index',
                'icon' => 'fa-list-check',
                'label' => 'Tâches',
                'required_permissions' => ['Tache_voir_mien', 'Tache_voir_tous'],
            ],
        ];


        $result = array_filter($menu, function ($item) use ($permissions) {
            return $this->hasPermission($item['required_permissions'], $permissions);
        });
        return $result;
    }

    private function getUserPermissions($user): array
    {
        $cacheKey = 'user_permissions_' . $user->getId();

        $permissions = $this->cache->get($cacheKey, function () use ($user) {
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
        });

        return $permissions;
    }

    private function hasPermission(array $requiredPermissions, array $userPermissions): bool
    {
        foreach ($requiredPermissions as $permission) {
            if (in_array($permission, $userPermissions, true)) {
                return true;
            }
        }
        return false;
    }

    // public function canPerformAction(string $action, string $categorie, $element, $user): bool
    // {
    //     $permissions = $this->getUserPermissions($user);

    //     if (in_array("{$categorie}_{$action}_tous", $permissions, true)) {
    //         return true;
    //     }

    //     if (in_array("{$categorie}_{$action}_mien", $permissions, true)) {
    //         return $element->getOwner() === $user;
    //     }

    //     return false;
    // }
}
