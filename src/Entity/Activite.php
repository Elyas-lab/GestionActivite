<?php

namespace App\Entity;

use App\Entity\Referentiel\SourceDemande;
use App\Entity\Referentiel\Statut;
use App\Repository\ActiviteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActiviteRepository::class)]
class Activite
{
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
    #[ORM\ManyToMany(targetEntity: Utilisateur::class, inversedBy: 'activites')]
    private Collection $ressources;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_debut_estimmee = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_fin_estimmee = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $date_debut_reel = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $date_fin_reel = null;

    #[ORM\ManyToOne(inversedBy: 'activites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Statut $statut = null;

    #[ORM\ManyToOne(inversedBy: 'activites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Projet $projet_source = null;

    /**
     * @var Collection<int, Tache>
     */
    #[ORM\OneToMany(targetEntity: Tache::class, mappedBy: 'activite')]
    private Collection $taches;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    //... (other properties and methods)

    public function getTitre():?string{
        return $this->titre;
    }

    public function getDescription():?string{
        return $this->description;
    }

    public function getDateDebutEstimee():?\DateTimeImmutable{
        return $this->date_debut_estimmee;
    }

    public function getDateFinEstimee():?\DateTimeImmutable{
        return $this->date_fin_estimmee;
    }

    public function getDateDebutReel():?\DateTimeImmutable{
        return $this->date_debut_reel;
    }

    public function getDateFinReel():?\DateTimeImmutable{
        return $this->date_fin_reel;
    }
     public function getRessources(): Collection{
        return $this->ressources;
    }
     public function setTitre(string $titre): self{
        $this->titre = $titre;
        return $this;
    }
     public function setDescription(?string $description): self{
        $this->description = $description;
        return $this;
    }
     public function setDateDebutEstimee(?\DateTimeImmutable $date_debut_estimmee): self{
        $this->date_debut_estimmee = $date_debut_estimmee;
        return $this;
    }
     public function setDateFinEstimee(?\DateTimeImmutable $date_fin_estimmee): self{
        $this->date_fin_estimmee = $date_fin_estimmee;
        return $this;
    }
     public function setDateDebutReel(?\DateTimeImmutable $date_debut_reel): self{
        $this->date_debut_reel = $date_debut_reel;
        return $this;
    }
     public function setDateFinReel(?\DateTimeImmutable $date_fin_reel): self{
        $this->date_fin_reel = $date_fin_reel;
        return $this;
    }
     public function setStatut(?Statut $statut): self{
        $this->statut = $statut;
        return $this;
    }
     public function addRessource(Utilisateur $utilisateur): self{
        if (!$this->ressources->contains($utilisateur)) {
            $this->ressources[] = $utilisateur;
        }
        return $this;
     }
     public function removeRessource(Utilisateur $utilisateur): self{
        $this->ressources->removeElement($utilisateur);
        return $this;
    }    
    public function getStatut():?Statut{
        return $this->statut;
    }

    public function getProjetSource(): ?Projet
    {
        return $this->projet_source;
    }

    public function setProjetSource(?Projet $projet_source): static
    {
        $this->projet_source = $projet_source;

        return $this;
    }

    /**
     * @return Collection<int, Tache>
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(Tache $tach): static
    {
        if (!$this->taches->contains($tach)) {
            $this->taches->add($tach);
            $tach->setActivite($this);
        }

        return $this;
    }

    public function removeTach(Tache $tach): static
    {
        if ($this->taches->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getActivite() === $this) {
                $tach->setActivite(null);
            }
        }

        return $this;
    }

}
