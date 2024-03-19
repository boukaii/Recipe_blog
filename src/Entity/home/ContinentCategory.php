<?php
// src/Entity/ContinentCategory.php
namespace App\Entity\home;

use App\Repository\home\ContinentCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContinentCategoryRepository::class)]
class ContinentCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $introduction = null;

    #[ORM\OneToMany(mappedBy: 'continentCategory', targetEntity: CountryCategory::class)]
    private Collection $countryCategories;

    public function __construct()
    {
        $this->countryCategories = new ArrayCollection();
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
     * @return Collection<int, CountryCategory>
     */
    public function getCountryCategories(): Collection
    {
        return $this->countryCategories;
    }

    public function addCountryCategory(CountryCategory $countryCategory): static
    {
        if (!$this->countryCategories->contains($countryCategory)) {
            $this->countryCategories->add($countryCategory);
            $countryCategory->setContinentCategory($this);
        }

        return $this;
    }

    public function removeCountryCategory(CountryCategory $countryCategory): static
    {
        if ($this->countryCategories->removeElement($countryCategory)) {
            // set the owning side to null (unless already changed)
            if ($countryCategory->getContinentCategory() === $this) {
                $countryCategory->setContinentCategory(null);
            }
        }

        return $this;
    }
}
