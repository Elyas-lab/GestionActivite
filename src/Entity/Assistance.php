<?php

namespace App\Entity;

use App\Entity\Referentiel\CanalDemande;
use App\Entity\Referentiel\SourceDemande;
use App\Entity\Referentiel\Statut;
use App\Entity\Referentiel\TypeDemande;
use App\Repository\AssistanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssistanceRepository::class)]
class Assistance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: 'oracle_date',)]
    private ?\DateTime $date_creation = null;

    #[ORM\ManyToOne(inversedBy: 'assistances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SourceDemande $Source = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeDemande $type = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CanalDemande $canal = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Statut $statut = null;

    #[ORM\ManyToOne(inversedBy: 'assistances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $responsable = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource():?Demande {
        return $this->Source;
    }
    public function getType():?TypeDemande{
        return $this->type;
    }
    public function getCanal():?CanalDemande{
        return $this->canal;
    }
    public function getStatut():?Statut{
        return $this->statut;
    }
    public function setSource(?SourceDemande $source): self{
        $this->Source = $source;
        return $this;
    }
    public function setType(?TypeDemande $type): self{
        $this->type = $type;
        return $this;
    }
    public function setCanal(?CanalDemande $canal): self{
        $this->canal = $canal;
        return $this;
    }
    public function setStatut(?Statut $statut): self{
        $this->statut = $statut;
        return $this;
    }
    public function getTitre():?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self{
        $this->titre = $titre;
        return $this;
    }
    public function getDescription():?string{
        return $this->description;
    }
    public function setDescription(?string $description): self{
        $this->description = $description;
        return $this;
    }
    public function getDateCreation():?\DateTime{
        return $this->date_creation;
    }
    public function setDateCreation(?\DateTime $date_creation): self{
        $this->date_creation = $date_creation;
        return $this;
    }

    public function getResponsable(): ?Utilisateur
    {
        return $this->responsable;
    }

    public function setResponsable(?Utilisateur $responsable): static
    {
        $this->responsable = $responsable;

        return $this;
    }
    
}
