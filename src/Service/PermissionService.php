<?php

namespace App\Service;

use App\Entity\Referentiel\Permission;
use Doctrine\ORM\EntityManagerInterface;

class PermissionService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Initialise les permissions en base de données.
     */
    public function initializePermissions(): void
    {
        $permissions = $this->getPermissionList();

        foreach ($permissions as $categorie => $items) {
            foreach ($items as $nom => $description) {
                // Vérifiez si la permission existe déjà
                $existingPermission = $this->entityManager->getRepository(Permission::class)
                    ->findOneBy(['nom' => $nom, 'Categorie' => $categorie]);

                if (!$existingPermission) {
                    // Créer une nouvelle permission
                    $permission = new Permission();
                    $permission->setNom($nom);
                    $permission->setDescription($description);
                    $permission->setCategorie($categorie);

                    $this->entityManager->persist($permission);
                }
            }
        }

        $this->entityManager->flush();
    }

    /**
     * Retourne la liste structurée des permissions à initialiser.
     */
    private function getPermissionList(): array
    {
        return [
            'Utilisateur' => [
                'ACCES' => 'Permission d’accéder à l’entité Utilisateur',
                'CREATION' => 'Permission de créer un utilisateur',
                'MODIFICATION' => 'Permission de modifier un utilisateur',
                'SUPPRESSION' => 'Permission de supprimer un utilisateur',
                'TOUS' => 'Permission de tout gérer pour Utilisateur',
            ],
            'Groupe' => [
                'ACCES' => 'Permission d’accéder à l’entité Groupe',
                'CREATION' => 'Permission de créer un groupe',
                'MODIFICATION' => 'Permission de modifier un groupe',
                'SUPPRESSION' => 'Permission de supprimer un groupe',
                'TOUS' => 'Permission de tout gérer pour Groupe',
            ],
            'Demande' => [
                'ACCES' => 'Permission d’accéder à l’entité Demande',
                'CREATION' => 'Permission de créer une demande',
                'MODIFICATION' => 'Permission de modifier une demande',
                'SUPPRESSION' => 'Permission de supprimer une demande',
                'TOUS' => 'Permission de tout gérer pour Demande',
            ],
            // Ajoutez d'autres catégories ici
        ];
    }

    /**
     * Récupère toutes les permissions par catégorie.
     */
    public function getPermissionsByCategory(): array
    {
        $permissions = $this->entityManager->getRepository(Permission::class)->findAll();
        $groupedPermissions = [];

        foreach ($permissions as $permission) {
            $groupedPermissions[$permission->getCategorie()][] = $permission;
        }

        return $groupedPermissions;
    }
}
