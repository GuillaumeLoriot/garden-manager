<?php

namespace App\Entity;

use App\Repository\PlantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PlantRepository::class)]
class Plant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 5, max: 255, minMessage: "Trop court.", maxMessage: "Trop long.")]
    private ?string $name = null;

    #[ORM\Column(length: 40)]
    #[Assert\Length(min: 3, max: 40, minMessage: "Trop court.", maxMessage: "Trop long.")]
    private ?string $category = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 3, max: 255, minMessage: "Trop court.", maxMessage: "Trop long.")]
    private ?string $plantPicture = null;

    // représente le début de la période de semis, exprimée avec une date dans une année fictive (année 2000).
    // L'année N'A AUCUNE VALEUR MÉTIER : seule le mois et le jour seront utilisés pour les calcul.(notification feature )
    // 
    // exemple : "2000-03-01" signifie "1er mars de chaque année".

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTime $sowingPeriodStart = null;
 
    // représente la fin de la période de semis.
    // idem : l’année est arbitraire, seule la période dans l’année est pertinente.
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTime $sowingPeriodEnd = null;

    // voir commentaires précédents
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTime $plantingPeriodStart = null;

    // voir commentaires précédents
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTime $plantingPeriodEnd = null;

    // voir commentaires précédents
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTime $harvestPeriodStart = null;

    // voir commentaires précédents
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTime $harvestPeriodEnd = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $germinationDetails = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $cultivationDetails = null;

    #[ORM\Column]
    #[Assert\Range(min: 1, max: 365, notInRangeMessage: "Doit être compris entre {{ min }} et {{ max }}.")]
    private ?int $growingTime = null;

    #[ORM\Column]
    #[Assert\Range(min: 0, max: 5, notInRangeMessage: "Doit être compris entre {{ min }} et {{ max }}.")]
    private ?int $waterNeed = null;

    #[ORM\Column]
    #[Assert\Range(min: 0, max: 5, notInRangeMessage: "Doit être compris entre {{ min }} et {{ max }}.")]
    private ?int $sunlightNeed = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $soilNeed = null;

    #[ORM\Column]
    private ?bool $supportNeed = null;

    #[ORM\ManyToOne(inversedBy: 'plants')]
    private ?Family $family = null;

    /**
     * @var Collection<int, Area>
     */
    #[ORM\ManyToMany(targetEntity: Area::class, mappedBy: 'plants')]
    private Collection $areas;

    /**
     * @var Collection<int, Recipe>
     */
    #[ORM\ManyToMany(targetEntity: Recipe::class, inversedBy: 'plants')]
    private Collection $recipes;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'friendlyOf')]
    private Collection $friendlyPlants;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'friendlyPlants')]
    private Collection $friendlyOf;

    public function __construct()
    {
        $this->areas = new ArrayCollection();
        $this->recipes = new ArrayCollection();
        $this->friendlyPlants = new ArrayCollection();
        $this->friendlyOf = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Area>
     */
    public function getAreas(): Collection
    {
        return $this->areas;
    }

    public function addArea(Area $area): static
    {
        if (!$this->areas->contains($area)) {
            $this->areas->add($area);
            $area->addPlant($this);
        }

        return $this;
    }

    public function removeArea(Area $area): static
    {
        if ($this->areas->removeElement($area)) {
            $area->removePlant($this);
        }

        return $this;
    }

      public function __toString()
  {
    return $this->name;
  }

      /**
       * @return Collection<int, Recipe>
       */
      public function getRecipes(): Collection
      {
          return $this->recipes;
      }

      public function addRecipe(Recipe $recipe): static
      {
          if (!$this->recipes->contains($recipe)) {
              $this->recipes->add($recipe);
          }

          return $this;
      }

      public function removeRecipe(Recipe $recipe): static
      {
          $this->recipes->removeElement($recipe);

          return $this;
      }

      /**
       * @return Collection<int, self>
       */
      public function getFriendlyPlants(): Collection
      {
          return $this->friendlyPlants;
      }

      public function addFriendlyPlant(self $friendlyPlant): static
      {
          if (!$this->friendlyPlants->contains($friendlyPlant)) {
              $this->friendlyPlants->add($friendlyPlant);
          }

          return $this;
      }

      public function removeFriendlyPlant(self $friendlyPlant): static
      {
          $this->friendlyPlants->removeElement($friendlyPlant);

          return $this;
      }

      /**
       * @return Collection<int, self>
       */
      public function getFriendlyOf(): Collection
      {
          return $this->friendlyOf;
      }

      public function addFriendlyOf(self $friendlyOf): static
      {
          if (!$this->friendlyOf->contains($friendlyOf)) {
              $this->friendlyOf->add($friendlyOf);
              $friendlyOf->addFriendlyPlant($this);
          }

          return $this;
      }

      public function removeFriendlyOf(self $friendlyOf): static
      {
          if ($this->friendlyOf->removeElement($friendlyOf)) {
              $friendlyOf->removeFriendlyPlant($this);
          }

          return $this;
      }
}
