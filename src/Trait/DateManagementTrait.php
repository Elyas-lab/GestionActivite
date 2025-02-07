<?php

namespace App\Trait;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait DateManagementTrait
{
    #[ORM\Column(type: 'datetime')]
    private ?DateTime $date_debut_estimee;

    #[ORM\Column(type: 'datetime')]
    #[Assert\Expression(
        " this.getDateDebutEstimee() <= this.getDateFinEstimee()",
        message: "La date de fin estimée doit être postérieure à la date de début estimée"
    )]
    private ?DateTime $date_fin_estimee;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $date_debut_reel ;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Assert\Expression(
        "this.getDateDebutReel() === null || this.getDateFinReel() === null || this.getDateDebutReel() <= this.getDateFinReel()",
        message: "La date de fin réelle doit être postérieure à la date de début réelle"
    )]
    private ?DateTime $date_fin_reel;

    public function getDateDebutEstimee(): ?DateTime
    {
        return $this->date_debut_estimee;
    }

    public function setDateDebutEstimee(?DateTime $date = null): self
    {
        if ($date instanceof DateTimeInterface) {
            $date = new DateTime($date->format('Y-m-d H:i:s'));
        }
        $this->date_debut_estimee = $date;
        return $this;
    }

    public function getDateFinEstimee(): ?DateTime
    {
        return $this->date_fin_estimee;
    }

    public function setDateFinEstimee(?DateTime $date = null): self
    {
        if ($date instanceof DateTimeInterface) {
            $date = new DateTime($date->format('Y-m-d H:i:s'));
        }
        $this->date_fin_estimee = $date;
        return $this;
    }

    public function getDateDebutReel(): ?DateTime
    {
        return $this->date_debut_reel;
    }

    public function setDateDebutReel(?DateTime $date = null): self
    {
        if ($date instanceof DateTimeInterface) {
            $date = new DateTime($date->format('Y-m-d H:i:s'));
        }
        $this->date_debut_reel = $date;
        return $this;
    }

    public function getDateFinReel(): ?DateTime
    {
        return $this->date_fin_reel;
    }

    public function setDateFinReel(?DateTime $date = null): self
    {
        if ($date instanceof DateTimeInterface) {
            $date = new DateTime($date->format('Y-m-d H:i:s'));
        }
        $this->date_fin_reel = $date;
        return $this;
    }

    public function formatDate(?DateTime $date): ?string
    {
        return $date ? $date->format('d/m/Y H:i') : null;
    }

    public function getDureeEstimee(): ?int
    {
        if (!$this->date_debut_estimee || !$this->date_fin_estimee) {
            return null;
        }
        return $this->date_debut_estimee->diff($this->date_fin_estimee)->days;
    }

    public function getDureeReelle(): ?int
    {
        if (!$this->date_debut_reel || !$this->date_fin_reel) {
            return null;
        }
        return $this->date_debut_reel->diff($this->date_fin_reel)->days;
    }

    public function getRetard(): ?int
    {
        if (!$this->date_fin_estimee || !$this->date_fin_reel) {
            return null;
        }
        $diff = $this->date_fin_reel->diff($this->date_fin_estimee);
        return $diff->invert ? $diff->days : 0;
    }

    public function estEnRetard(): bool
    {
        return $this->getRetard() > 0;
    }
}
