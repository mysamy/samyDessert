<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// Entité Categorie : regroupe les produits par type (ex: Tartes, Choux, Petits fours)
#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $nom = '';

    // Liste des produits appartenant à cette catégorie
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'categorie')]
    private Collection $produits;

    #[ORM\Column(length: 100, unique: true)]
    private ?string $slug = null;

    /**
     * @var Collection<int, Recette>
     */
    #[ORM\OneToMany(targetEntity: Recette::class, mappedBy: 'categorie')]
    private Collection $recettes;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->recettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->nom;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getProduits(): Collection
    {
        return $this->produits;
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
     * @return Collection<int, Recette>
     */
    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    public function addRecette(Recette $recette): static
    {
        if (!$this->recettes->contains($recette)) {
            $this->recettes->add($recette);
            $recette->setCategorie($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            // set the owning side to null (unless already changed)
            if ($recette->getCategorie() === $this) {
                $recette->setCategorie(null);
            }
        }

        return $this;
    }
}
