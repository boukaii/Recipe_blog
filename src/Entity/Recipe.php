<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategoryRecipe $categoryRecipe = null;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: RecipeDetails::class, orphanRemoval: true)]
    private Collection $recipeDetails;

    public function __construct()
    {
        $this->recipeDetails = new ArrayCollection();
    }

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

    public function getCategoryRecipe(): ?CategoryRecipe
    {
        return $this->categoryRecipe;
    }

    public function setCategoryRecipe(?CategoryRecipe $categoryRecipe): static
    {
        $this->categoryRecipe = $categoryRecipe;

        return $this;
    }

    /**
     * @return Collection<int, RecipeDetails>
     */
    public function getRecipeDetails(): Collection
    {
        return $this->recipeDetails;
    }

    public function addRecipeDetail(RecipeDetails $recipeDetail): static
    {
        if (!$this->recipeDetails->contains($recipeDetail)) {
            $this->recipeDetails->add($recipeDetail);
            $recipeDetail->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeDetail(RecipeDetails $recipeDetail): static
    {
        if ($this->recipeDetails->removeElement($recipeDetail)) {
            // set the owning side to null (unless already changed)
            if ($recipeDetail->getRecipe() === $this) {
                $recipeDetail->setRecipe(null);
            }
        }

        return $this;
    }
}
