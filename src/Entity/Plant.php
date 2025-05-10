<?php

namespace App\Entity;

use App\Repository\PlantRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlantRepository::class)]
class Plant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 40)]
    private ?string $category = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $plantPicture = null;

    // Représente le début de la période de semis, exprimée comme une date dans une année fictive (année 2000).
    // L'année N'A AUCUNE VALEUR MÉTIER : seule le mois et le jour seront utilisés pour le calcul.
    // 
    // Exemple : "2000-03-01" signifie "1er mars de chaque année".

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $sowingPeriodStart = null;
 
    // Représente la fin de la période de semis.
    // Idem : l’année est arbitraire, seule la période dans l’année est pertinente.
    // #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $sowingPeriodEnd = null;

    // voir commentaires précédents
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $plantingPeriodStart = null;

    // voir commentaires précédents
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $plantingPeriodEnd = null;

    // voir commentaires précédents
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $harvestPeriodStart = null;

    // voir commentaires précédents
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $harvestPeriodEnd = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $germinationDetails = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $cultivationDetails = null;

    #[ORM\Column]
    private ?int $growingTime = null;

    #[ORM\Column]
    private ?int $waterNeed = null;

    #[ORM\Column]
    private ?int $sunlightNeed = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $soilNeed = null;

    #[ORM\Column]
    private ?bool $supportNeed = null;

    #[ORM\ManyToOne(inversedBy: 'plants')]
    private ?Family $family = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

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

    public function getPlantPicture(): ?string
    {
        return $this->plantPicture;
    }

    public function setPlantPicture(string $plantPicture): static
    {
        $this->plantPicture = $plantPicture;

        return $this;
    }

    public function getSowingPeriodStart(): ?\DateTime
    {
        return $this->sowingPeriodStart;
    }

    public function setSowingPeriodStart(\DateTime $sowingPeriodStart): static
    {
        $this->sowingPeriodStart = $sowingPeriodStart;

        return $this;
    }

    public function getSowingPeriodEnd(): ?\DateTime
    {
        return $this->sowingPeriodEnd;
    }

    public function setSowingPeriodEnd(\DateTime $sowingPeriodEnd): static
    {
        $this->sowingPeriodEnd = $sowingPeriodEnd;

        return $this;
    }

    public function getPlantingPeriodStart(): ?\DateTime
    {
        return $this->plantingPeriodStart;
    }

    public function setPlantingPeriodStart(\DateTime $plantingPeriodStart): static
    {
        $this->plantingPeriodStart = $plantingPeriodStart;

        return $this;
    }

    public function getPlantingPeriodEnd(): ?\DateTime
    {
        return $this->plantingPeriodEnd;
    }

    public function setPlantingPeriodEnd(\DateTime $plantingPeriodEnd): static
    {
        $this->plantingPeriodEnd = $plantingPeriodEnd;

        return $this;
    }

    public function getHarvestPeriodStart(): ?\DateTime
    {
        return $this->harvestPeriodStart;
    }

    public function setHarvestPeriodStart(\DateTime $harvestPeriodStart): static
    {
        $this->harvestPeriodStart = $harvestPeriodStart;

        return $this;
    }

    public function getHarvestPeriodEnd(): ?\DateTime
    {
        return $this->harvestPeriodEnd;
    }

    public function setHarvestPeriodEnd(\DateTime $harvestPeriodEnd): static
    {
        $this->harvestPeriodEnd = $harvestPeriodEnd;

        return $this;
    }

    public function getGerminationDetails(): ?string
    {
        return $this->germinationDetails;
    }

    public function setGerminationDetails(string $germinationDetails): static
    {
        $this->germinationDetails = $germinationDetails;

        return $this;
    }

    public function getCultivationDetails(): ?string
    {
        return $this->cultivationDetails;
    }

    public function setCultivationDetails(string $cultivationDetails): static
    {
        $this->cultivationDetails = $cultivationDetails;

        return $this;
    }

    public function getGrowingTime(): ?int
    {
        return $this->growingTime;
    }

    public function setGrowingTime(int $growingTime): static
    {
        $this->growingTime = $growingTime;

        return $this;
    }

    public function getWaterNeed(): ?int
    {
        return $this->waterNeed;
    }

    public function setWaterNeed(int $waterNeed): static
    {
        $this->waterNeed = $waterNeed;

        return $this;
    }

    public function getSunlightNeed(): ?int
    {
        return $this->sunlightNeed;
    }

    public function setSunlightNeed(int $sunlightNeed): static
    {
        $this->sunlightNeed = $sunlightNeed;

        return $this;
    }

    public function getSoilNeed(): ?string
    {
        return $this->soilNeed;
    }

    public function setSoilNeed(string $soilNeed): static
    {
        $this->soilNeed = $soilNeed;

        return $this;
    }

    public function isSupportNeed(): ?bool
    {
        return $this->supportNeed;
    }

    public function setSupportNeed(bool $supportNeed): static
    {
        $this->supportNeed = $supportNeed;

        return $this;
    }

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $family): static
    {
        $this->family = $family;

        return $this;
    }
}
