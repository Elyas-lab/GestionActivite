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
            'Demande' => [
                'ACCES_Demande' => 'Permission d\'accéder à l\'entité Demande',
                'CREATION_Demande' => 'Permission de créer une demande',
                'MODIFICATION_Demande' => 'Permission de modifier une demande',
                'SUPPRESSION_Demande' => 'Permission de supprimer une demande',
            ],
            'Projet' => [
                'ACCES_Projet' => 'Permission d\'accéder à l\'entité Projet',
                'CREATION_Projet' => 'Permission de créer un projet',
                'MODIFICATION_Projet' => 'Permission de modifier un projet',
                'SUPPRESSION_Projet' => 'Permission de supprimer un projet',
            ],
            'Assistance' => [
                'ACCES_Assistance' => 'Permission d\'accéder à l\'entité Assistance',
                'CREATION_Assistance' => 'Permission de créer un Assistance',
                'MODIFICATION_Assistance' => 'Permission de modifier un Assistance',
                'SUPPRESSION_Assistance' => 'Permission de supprimer un Assistance',
            ],
            'Activité' => [
                'ACCES_Activité' => 'Permission d\'accéder à l\'entité Activité',
                'CREATION_Activité' => 'Permission de créer un Activité',
                'MODIFICATION_Activité' => 'Permission de modifier un Activité',
                'SUPPRESSION_Activité' => 'Permission de supprimer un Activité',
            ],
            'Tache' => [
                'ACCES_Tache' => 'Permission d\'accéder à l\'entité Tache',
                'CREATION_Tache' => 'Permission de créer un Tache',
                'MODIFICATION_Tache' => 'Permission de modifier un Tache',
                'SUPPRESSION_Tache' => 'Permission de supprimer un Tache',
            ],
            'Referentiel' => [
                'ACCES_Referentiel' => 'Permission d\'accéder à l\'entité Referentiel',
                'CREATION_Referentiel' => 'Permission de créer un Referentiel',
                'MODIFICATION_Referentiel' => 'Permission de modifier un Referentiel',
                'SUPPRESSION_Referentiel' => 'Permission de supprimer un Referentiel',
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
