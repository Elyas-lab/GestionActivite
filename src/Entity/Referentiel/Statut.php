<?php
namespace App\Entity\Referentiel;

use App\Entity\Activite;
use App\Entity\Tache;
use App\Repository\StatutRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatutRepository::class)]
class Statut
{
#[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer', nullable: false)]
    #[ORM\SequenceGenerator(sequenceName: 'statut_id_seq', allocationSize: 1, initialValue: 1)]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\OneToMany(targetEntity: Activite::class, mappedBy: 'statut')]
    private Collection $activites;

    #[ORM\OneToMany(targetEntity: Tache::class, mappedBy: 'statut')]
    private Collection $taches;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    // Le getter 'isActive' est correct pour un champ booléen
    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    // Renommer 'setIsActive' en 'setIsActive' pour correspondre à la convention de nommage
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
