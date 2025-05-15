<?php

namespace App\SearchBar;

class SearchCriteria
{
    private ?string $name = null;

    private ?string $category = null;

    private ?\DateTime $sowingPeriodSearch = null;

    private ?\DateTime $plantingPeriodSearch = null;

    private ?\DateTime $harvestPeriodSearch = null;

    private ?int $waterNeed = null;

    private ?int $sunlightNeed = null;



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

    public function getSowingPeriodSearch(): ?\DateTime
    {
        return $this->sowingPeriodSearch;
    }

    public function setSowingPeriodSearch(?\DateTime $sowingPeriodSearch): static
    {
        $this->sowingPeriodSearch = $sowingPeriodSearch;

        return $this;
    }

    public function getPlantingPeriodSearch(): ?\DateTime
    {
        return $this->plantingPeriodSearch;
    }
        public function setPlantingPeriodSearch(?\DateTime $plantingPeriodSearch): static
    {
        $this->plantingPeriodSearch = $plantingPeriodSearch;

        return $this;
    }

    public function getHarvestPeriodSearch(): ?\DateTime
    {
        return $this->harvestPeriodSearch;
    }
    public function setHarvestPeriodSearch(?\DateTime $harvestPeriodSearch): static
    {
        $this->harvestPeriodSearch = $harvestPeriodSearch;

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
}