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
                'acces_Demande' => 'Permission d\'accéder à l\'entité Demande',
                'creation_Demande' => 'Permission de créer une demande',
                'modification_Demande' => 'Permission de modifier une demande',
                'suppression_Demande' => 'Permission de supprimer une demande',
            ],
            'Projet' => [
                'acces_Projet' => 'Permission d\'accéder à l\'entité Projet',
                'creation_Projet' => 'Permission de créer un projet',
                'modification_Projet' => 'Permission de modifier un projet',
                'suppression_Projet' => 'Permission de supprimer un projet',
            ],
            'Assistance' => [
                'acces_Assistance' => 'Permission d\'accéder à l\'entité Assistance',
                'creation_Assistance' => 'Permission de créer un Assistance',
                'modification_Assistance' => 'Permission de modifier un Assistance',
                'suppression_Assistance' => 'Permission de supprimer un Assistance',
            ],
            'Activité' => [
                'acces_Activité' => 'Permission d\'accéder à l\'entité Activité',
                'creation_Activité' => 'Permission de créer un Activité',
                'modification_Activité' => 'Permission de modifier un Activité',
                'suppression_Activité' => 'Permission de supprimer un Activité',
            ],
            'Tache' => [
                'acces_Tache' => 'Permission d\'accéder à l\'entité Tache',
                'creation_Tache' => 'Permission de créer un Tache',
                'modification_Tache' => 'Permission de modifier un Tache',
                'suppression_Tache' => 'Permission de supprimer un Tache',
            ],
            'Referentiel' => [
                'acces_Referentiel' => 'Permission d\'accéder à l\'entité Referentiel',
                'creation_Referentiel' => 'Permission de créer un Referentiel',
                'modification_Referentiel' => 'Permission de modifier un Referentiel',
                'suppression_Referentiel' => 'Permission de supprimer un Referentiel',
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
