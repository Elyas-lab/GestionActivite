<?php

namespace App\Entity\Referentiel;

use App\Entity\Assistance;
use App\Entity\Demande;
use App\Repository\SourceDemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SourceDemandeRepository::class)]
class SourceDemande
{
#[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer', nullable: false)]
    #[ORM\SequenceGenerator(sequenceName: 'source_demande_id_seq', allocationSize: 1, initialValue: 1)]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Demande>
     */
    #[ORM\OneToMany(targetEntity: Demande::class, mappedBy: 'Source')]
    private Collection $demandes;

        /**
     * @var Collection<int, Demande>
     */
    #[ORM\OneToMany(targetEntity: Assistance::class, mappedBy: 'Source')]
    private Collection $assistances;

    #[ORM\Column(type: Types::TEXT,nullable: true)]
    private ?string $description = null;

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
        $this->assistances = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): static
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes->add($demande);
            $demande->setSource($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): static
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getSource() === $this) {
                $demande->setSource(null);
            }
        }

        return $this;
    }

        /**
     * @return Collection<int, assistance>
     */
    public function getassistances(): Collection
    {
        return $this->assistances;
    }

    public function addassistance(Assistance $assistance): static
    {
        if (!$this->assistances->contains($assistance)) {
            $this->assistances->add($assistance);
            $assistance->setSource($this);
        }

        return $this;
    }

    public function removeassistance(assistance $assistance): static
    {
        if ($this->assistances->removeElement($assistance)) {
            // set the owning side to null (unless already changed)
            if ($assistance->getSource() === $this) {
                $assistance->setSource(null);
            }
        }

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
}
