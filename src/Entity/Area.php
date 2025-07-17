<?php

namespace App\Entity;

use App\Repository\AreaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AreaRepository::class)]
class Area
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'areas')]
    private ?User $user = null;

    /**
     * @var Collection<int, Plant>
     */
    #[ORM\ManyToMany(targetEntity: Plant::class, inversedBy: 'areas')]
    private Collection $plants;

    /**
     * @var Collection<int, JournalEntry>
     */
    #[ORM\OneToMany(targetEntity: JournalEntry::class, mappedBy: 'area')]
    private Collection $journalEntries;

    public function __construct()
    {
        $this->plants = new ArrayCollection();
        $this->journalEntries = new ArrayCollection();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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
        }

        return $this;
    }

    public function removePlant(Plant $plant): static
    {
        $this->plants->removeElement($plant);

        return $this;
    }

      public function __toString()
  {
    return $this->name;
  }

      /**
       * @return Collection<int, JournalEntry>
       */
      public function getJournalEntries(): Collection
      {
          return $this->journalEntries;
      }

      public function addJournalEntry(JournalEntry $journalEntry): static
      {
          if (!$this->journalEntries->contains($journalEntry)) {
              $this->journalEntries->add($journalEntry);
              $journalEntry->setArea($this);
          }

          return $this;
      }

      public function removeJournalEntry(JournalEntry $journalEntry): static
      {
          if ($this->journalEntries->removeElement($journalEntry)) {
              // set the owning side to null (unless already changed)
              if ($journalEntry->getArea() === $this) {
                  $journalEntry->setArea(null);
              }
          }

          return $this;
      }
}
