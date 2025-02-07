<?php

namespace App\Entity;

use App\Entity\Referentiel\Statut;
use App\Repository\TacheRepository;
use App\Trait\DateManagementTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TacheRepository::class)]
class Tache
{

    use DateManagementTrait;

#[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer', nullable: false)]
    #[ORM\SequenceGenerator(sequenceName: 'tache_id_seq', allocationSize: 1, initialValue: 1)]
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

    #[ORM\ManyToOne(inversedBy: 'taches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Statut $statut = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    private ?Activite $activite = null;

    public function __construct()
    {
        $this->ressources = new ArrayCollection();
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
    public function setStatut(Statut $statut){
        $this->statut = $statut;
    }

    public function getActivite(): ?Activite
    {
        return $this->activite;
    }

    public function setActivite(?Activite $activite): static
    {
        $this->activite = $activite;

        return $this;
    }
}
