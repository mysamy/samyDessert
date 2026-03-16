<?php

namespace App\Entity;

use App\Enum\Difficulte;
use App\Repository\RecetteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

// Entité Recette : représente une recette de pâtisserie publiée sur le site
#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $titre = '';

    // Courte description affichée dans les listes et les cartes
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    // Contenu complet de la recette (étapes, ingrédients...)
    #[ORM\Column(type: Types::TEXT)]
    private string $contenu = '';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageSrc = null;

    // Durée en minutes
    #[ORM\Column(nullable: true)]
    private ?int $duree = null;

    // Niveau de difficulté — voir App\Enum\Difficulte
    #[ORM\Column(type: 'string', enumType: Difficulte::class, nullable: true)]
    private ?Difficulte $difficulte = null;

    // Produit associé à la recette (optionnel)
    #[ORM\ManyToOne(targetEntity: Produit::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Produit $produit = null;

    // Date de publication automatiquement définie à la création
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    private ?Categorie $categorie = null;

    // Nombre de portions que la recette produit
    #[ORM\Column(nullable: true)]
    private ?int $portions = null;

    // Slug pour les URLs SEO-friendly (ex: tarte-au-citron-meringuee)
    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $slug = null;

    // Indique si la recette est visible sur le site
    #[ORM\Column]
    private bool $isPublished = false;

    // Date de dernière modification
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;
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

    public function getContenu(): string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;
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

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): static
    {
        $this->duree = $duree;
        return $this;
    }

    public function getDifficulte(): ?Difficulte
    {
        return $this->difficulte;
    }

    public function setDifficulte(?Difficulte $difficulte): static
    {
        $this->difficulte = $difficulte;
        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;
        return $this;
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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getPortions(): ?int
    {
        return $this->portions;
    }

    public function setPortions(?int $portions): static
    {
        $this->portions = $portions;
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

    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): static
    {
        $this->isPublished = $isPublished;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    // Retourne la durée formatée (ex: "1h30" ou "45 min")
    public function getTemps(): ?string
    {
        if ($this->duree === null) return null;
        if ($this->duree < 60) return $this->duree . ' min';
        $h = intdiv($this->duree, 60);
        $m = $this->duree % 60;
        return $m > 0 ? $h . 'h' . str_pad($m, 2, '0', STR_PAD_LEFT) : $h . 'h';
    }
}
