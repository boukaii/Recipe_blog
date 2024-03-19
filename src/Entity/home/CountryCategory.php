<?php
// src/Entity/CountryCategory.php
namespace App\Entity\home;

use App\Repository\home\CountryCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryCategoryRepository::class)]
class CountryCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'countryCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ContinentCategory $continentCategory = null;

    #[ORM\OneToMany(mappedBy: 'countryCategory', targetEntity: CountryRecipe::class, orphanRemoval: true)]
    private Collection $countryRecipes;

    public function __construct()
    {
        $this->countryRecipes = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getContinentCategory(): ?ContinentCategory
    {
        return $this->continentCategory;
    }

    public function setContinentCategory(?ContinentCategory $continentCategory): static
    {
        $this->continentCategory = $continentCategory;

        return $this;
    }

    /**
     * @return Collection<int, CountryRecipe>
     */
    public function getCountryRecipes(): Collection
    {
        return $this->countryRecipes;
    }

    public function addCountryRecipe(CountryRecipe $countryRecipe): static
    {
        if (!$this->countryRecipes->contains($countryRecipe)) {
            $this->countryRecipes->add($countryRecipe);
            $countryRecipe->setCountryCategory($this);
        }

        return $this;
    }

    public function removeCountryRecipe(CountryRecipe $countryRecipe): static
    {
        if ($this->countryRecipes->removeElement($countryRecipe)) {
            // set the owning side to null (unless already changed)
            if ($countryRecipe->getCountryCategory() === $this) {
                $countryRecipe->setCountryCategory(null);
            }
        }

        return $this;
    }
}
