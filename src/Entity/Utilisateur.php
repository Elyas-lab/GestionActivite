<?php

namespace App\Entity;

use App\Entity\Referentiel\Groupe;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_MATRICULE', fields: ['matricule'])]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $matricule = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column(nullable: true)]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, Groupe>
     */
    #[ORM\ManyToMany(targetEntity: Groupe::class, inversedBy: 'utilisateurs')]
    private Collection $groupe;

    /**
     * @var Collection<int, Assistance>
     */
    #[ORM\OneToMany(targetEntity: Assistance::class, mappedBy: 'responsable')]
    private Collection $assistances;
    
    /**
     * @var Collection<int, Projet>
     */
    #[ORM\ManyToMany(targetEntity: Projet::class, inversedBy: 'ressources')]
    private Collection $projets;   

    /**
     * @var Collection<int, Activite>
     */
    #[ORM\ManyToMany(targetEntity: Activite::class, inversedBy: 'ressources')]
    private Collection $activites;

    /**
     * @var Collection<int, Tache>
     */
    #[ORM\ManyToMany(targetEntity: Tache::class, inversedBy: 'ressources')]
    private Collection $taches;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    public function __construct()
    {
        $this->groupe = new ArrayCollection();
        $this->assistances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->matricule;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Groupe>
     */
    public function getGroupe(): Collection
    {
        return $this->groupe;
    }

    public function addGroupe(Groupe $groupe): static
    {
        if (!$this->groupe->contains($groupe)) {

            $groupe->addUtilisateur( $this);

        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): static
    {
        $this->groupe->removeElement($groupe);

        return $this;
    }

    /**
     * @return Collection<int, Assistance>
     */
    public function getAssistances(): Collection
    {
        return $this->assistances;
    }

    public function addAssistance(Assistance $assistance): static
    {
        if (!$this->assistances->contains($assistance)) {
            $this->assistances->add($assistance);
            $assistance->setResponsable($this);
        }

        return $this;
    }

    public function removeAssistance(Assistance $assistance): static
    {
        if ($this->assistances->removeElement($assistance)) {
            // set the owning side to null (unless already changed)
            if ($assistance->getResponsable() === $this) {
                $assistance->setResponsable(null);
            }
        }

        return $this;
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
     * @return Collection<int, Projet>
     */
    public function getProjets(): Collection
    {
        return $this->projets;
    }

    public function addProjet(Projet $projet): static
    {
        if (!$this->projets->contains($projet)) {
            $this->projets->add($projet);
            $projet->addRessource($this); // Ensure bidirectional consistency if Projet has a method
        }

        return $this;
    }

    public function removeProjet(Projet $projet): static
    {
        if ($this->projets->removeElement($projet)) {
            $projet->removeRessource($this); // Ensure bidirectional consistency if Projet has a method
        }

        return $this;
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
            $activite->addRessource($this); // Ensure bidirectional consistency if Activite has a method
        }

        return $this;
    }

    public function removeActivite(Activite $activite): static
    {
        if ($this->activites->removeElement($activite)) {
            $activite->removeRessource($this); // Ensure bidirectional consistency if Activite has a method
        }

        return $this;
    }

    /**
     * @return Collection<int, Tache>
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTache(Tache $tache): static
    {
        if (!$this->taches->contains($tache)) {
            $this->taches->add($tache);
            $tache->addRessource($this); // Ensure bidirectional consistency if Tache has a method
        }

        return $this;
    }

    public function removeTache(Tache $tache): static
    {
        if ($this->taches->removeElement($tache)) {
            $tache->removeRessource($this); // Ensure bidirectional consistency if Tache has a method
        }

        return $this;
    }

}
