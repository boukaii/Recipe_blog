<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $introduction = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: CategoryRecipe::class)]
    private Collection $CategoryRecipes;

    public function __construct()
    {
        $this->CategoryRecipes = new ArrayCollection();
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

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): static
    {
        $this->introduction = $introduction;

        return $this;
    }

    /**
     * @return Collection<int, CategoryRecipe>
     */
    public function getCategoryRecipes(): Collection
    {
        return $this->CategoryRecipes;
    }

    public function addArticle(CategoryRecipe $CategoryRecipe): static
    {
        if (!$this->CategoryRecipes->contains($CategoryRecipe)) {
            $this->CategoryRecipes->add($CategoryRecipe);
            $CategoryRecipe->setCategorie($this);
        }

        return $this;
    }

    public function removeArticle(CategoryRecipe $CategoryRecipe): static
    {
        if ($this->CategoryRecipes->removeElement($CategoryRecipe)) {
            // set the owning side to null (unless already changed)
            if ($CategoryRecipe->getCategorie() === $this) {
                $CategoryRecipe->setCategorie(null);
            }
        }

        return $this;
    }
}
