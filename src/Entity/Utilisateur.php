<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

// Entité Utilisateur : représente un compte client sur le site
// Implémente UserInterface et PasswordAuthenticatedUserInterface pour Symfony Security
#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_EMAIL', fields: ['email'])]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // L'email sert aussi d'identifiant de connexion (voir getUserIdentifier)
    #[ORM\Column(length: 180)]
    private string $email = '';

    // Rôles Symfony (ex: ROLE_USER, ROLE_ADMIN) — ROLE_USER est toujours ajouté automatiquement
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column]
    private string $password = '';

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $prenom = null;

    // Produits mis en favoris par l'utilisateur
    #[ORM\ManyToMany(targetEntity: Produit::class)]
    #[ORM\JoinTable(name: 'utilisateur_produit_favori')]
    private Collection $produitsFavoris;

    // Recettes mises en favoris par l'utilisateur
    #[ORM\ManyToMany(targetEntity: Recette::class)]
    #[ORM\JoinTable(name: 'utilisateur_recette_favori')]
    private Collection $recettesFavoris;

    public function __construct()
    {
        $this->produitsFavoris = new ArrayCollection();
        $this->recettesFavoris = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void {}

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getProduitsFavoris(): Collection
    {
        return $this->produitsFavoris;
    }

    public function addProduitFavori(Produit $produit): static
    {
        if (!$this->produitsFavoris->contains($produit)) {
            $this->produitsFavoris->add($produit);
        }
        return $this;
    }

    public function removeProduitFavori(Produit $produit): static
    {
        $this->produitsFavoris->removeElement($produit);
        return $this;
    }

    public function getRecettesFavoris(): Collection
    {
        return $this->recettesFavoris;
    }

    public function addRecetteFavori(Recette $recette): static
    {
        if (!$this->recettesFavoris->contains($recette)) {
            $this->recettesFavoris->add($recette);
        }
        return $this;
    }

    public function removeRecetteFavori(Recette $recette): static
    {
        $this->recettesFavoris->removeElement($recette);
        return $this;
    }
}
