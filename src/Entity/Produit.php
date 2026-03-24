<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

// Entité Produit : représente un produit de pâtisserie vendu sur le site
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $nom = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    // Prix en euros (stocké en DECIMAL pour éviter les erreurs d'arrondi)
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private string $prix = '0.00';

    // Chemin ou URL de l'image du produit
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageSrc = null;

    // Indique si le produit est visible et achetable sur le site
    #[ORM\Column]
    private bool $disponible = true;

    // Catégorie du produit (ex: Tartes, Choux...)
    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'produits')]
    private ?Categorie $categorie = null;

    // Slug pour les URLs SEO-friendly (ex: macaron-framboise)
    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $slug = null;

    // Quantité disponible en stock
    #[ORM\Column]
    private int $stock = 0;

    // Recettes liées à ce produit (côté inverse de Recette.produit)
    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Recette::class)]
    private Collection $recettes;

    // Date d'ajout du produit au catalogue
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->recettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getPrix(): string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;
        return $this;
    }

    public function getImageSrc(): ?string
    {
        return $this->imageSrc;
    }

    public function setImageSrc(?string $imageSrc): static
    {
        $this->imageSrc = $imageSrc;
        return $this;
    }

    public function isDisponible(): bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): static
    {
        $this->disponible = $disponible;
        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;
        return $this;
    }

    // Retourne la recette associée (la première liée, ou null)
    public function getRecette(): ?Recette
    {
        return $this->recettes->first() ?: null;
    }

    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
