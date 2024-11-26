<?php

namespace App\Entity\Referentiel;

enum TypeElement: string
{
    case Activite = 'activite';
    case Assistance = 'assistance';
    case Demande = 'demande';
    case Projet = 'projet';
    case Tache = 'tache';
    case Utilisateur = 'utilisateur';

    public function titre(): string
    {
        return match($this)
        {
            self::Activite => 'Activité',
            self::Assistance => 'Assistance',
            self::Demande => 'Demande',
            self::Projet => 'Projet',
            self::Tache => 'Tâche',
            self::Utilisateur => 'Utilisateur',
        };
    }
}