<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

// Entité Produit : représente un produit de pâtisserie vendu sur le site
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[Vich\Uploadable]
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

    // Fichier image uploadé (non persisté en base, géré par VichUploader)
    #[Vich\UploadableField(mapping: 'produit_image', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    // Nom du fichier image stocké dans public/uploads/produits/
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageName = null;

    // Date de dernière modification (requis par VichUploader pour détecter les changements)
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    // Indique si le produit est visible et achetable sur le site
    #[ORM\Column]
    private bool $disponible = true;

    // Catégorie du produit (ex: Tartes, Choux...)
    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'produits')]
    private ?Categorie $categorie = null;

    // Slug pour les URLs SEO-friendly (ex: macaron-framboise)
    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $slug = null;

    // Recette liée à ce produit (nullable — pas encore publiée)
    #[ORM\OneToOne(mappedBy: 'produit', targetEntity: Recette::class)]
    private ?Recette $recette = null;

    // Date d'ajout du produit au catalogue
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
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

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): static
    {
        $this->imageFile = $imageFile;
        if ($imageFile !== null) {
            $this->updatedAt = new \DateTime();
        }
        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): static
    {
        $this->imageName = $imageName;
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

    public function getRecette(): ?Recette
    {
        return $this->recette;
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
