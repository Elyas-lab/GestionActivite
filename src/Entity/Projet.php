<?php

namespace App\Entity;

use App\Entity\Referentiel\Statut;
use App\Repository\ProjetRepository;
use App\Trait\DateManagementTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    use DateManagementTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\ManyToMany(targetEntity: Utilisateur::class)]
    private Collection $ressources;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Statut $statut = null;

    /**
     * @var Collection<int, Activite>
     */
    #[ORM\OneToMany(targetEntity: Activite::class, mappedBy: 'projet_source', orphanRemoval: true)]
    private Collection $activites;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Demande $demande_source = null;

    public function __construct()
    {
        $this->ressources = new ArrayCollection();
        $this->activites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    //... (other properties and methods)

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getRessources(): Collection
    {
        return $this->ressources;
    }
    public function setTitre(string $titre): self
    {
        $this->titre = $titre;
        return $this;
    }
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }
    public function setStatut(?Statut $statut): self
    {
        $this->statut = $statut;
        return $this;
    }
    public function addRessource(Utilisateur $utilisateur): self
    {
        if (!$this->ressources->contains($utilisateur)) {
            $this->ressources[] = $utilisateur;
        }
        return $this;
    }
    public function removeRessource(Utilisateur $utilisateur): self
    {
        $this->ressources->removeElement($utilisateur);
        return $this;
    }
    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    /**
     * @return Collection<int, Activite>
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activite $activite): static
    {
        if (!$this->activites->contains($activite)) {
            $this->activites->add($activite);
            $activite->setProjetSource($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): static
    {
        if ($this->activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getProjetSource() === $this) {
                $activite->setProjetSource(null);
            }
        }

        return $this;
    }

    public function getDemandeSource(): ?Demande
    {
        return $this->demande_source;
    }

    public function setDemandeSource(?Demande $demande_source): static
    {
        $this->demande_source = $demande_source;

        return $this;
    }
}
