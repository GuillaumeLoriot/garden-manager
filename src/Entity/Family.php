<?php

namespace App\Entity;

use App\Repository\FamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FamilyRepository::class)]
class Family
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $characteristics = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $history = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $mainUse = null;

    #[ORM\Column(length: 60)]
    private ?string $slug = null;

    /**
     * @var Collection<int, Plant>
     */
    #[ORM\OneToMany(targetEntity: Plant::class, mappedBy: 'family')]
    private Collection $plants;

    #[ORM\Column(length: 255)]
    private ?string $familyPicture = null;

    public function __construct()
    {
        $this->plants = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCharacteristics(): ?string
    {
        return $this->characteristics;
    }

    public function setCharacteristics(string $characteristics): static
    {
        $this->characteristics = $characteristics;

        return $this;
    }

    public function getHistory(): ?string
    {
        return $this->history;
    }

    public function setHistory(string $history): static
    {
        $this->history = $history;

        return $this;
    }

    public function getMainUse(): ?string
    {
        return $this->mainUse;
    }

    public function setMainUse(string $mainUse): static
    {
        $this->mainUse = $mainUse;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Plant>
     */
    public function getPlants(): Collection
    {
        return $this->plants;
    }

    public function addPlant(Plant $plant): static
    {
        if (!$this->plants->contains($plant)) {
            $this->plants->add($plant);
            $plant->setFamily($this);
        }

        return $this;
    }

    public function removePlant(Plant $plant): static
    {
        if ($this->plants->removeElement($plant)) {
            // set the owning side to null (unless already changed)
            if ($plant->getFamily() === $this) {
                $plant->setFamily(null);
            }
        }

        return $this;
    }

    public function getFamilyPicture(): ?string
    {
        return $this->familyPicture;
    }

    public function setFamilyPicture(string $familyPicture): static
    {
        $this->familyPicture = $familyPicture;

        return $this;
    }

    public function __toString()
  {
    return $this->name;
  }
}
