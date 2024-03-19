<?php

namespace App\Entity\home;

use App\Repository\home\CountryRecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRecipeRepository::class)]
class CountryRecipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[ORM\ManyToOne(inversedBy: 'countryRecipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CountryCategory $countryCategory = null;




    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCountryCategory(): ?CountryCategory
    {
        return $this->countryCategory;
    }

    public function setCountryCategory(?CountryCategory $countryCategory): static
    {
        $this->countryCategory = $countryCategory;

        return $this;
    }
}
