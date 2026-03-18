<?php

namespace App\Entity;

use App\Enum\StatutCommande;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

// Entité Commande : représente une commande passée par un utilisateur
#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // L'utilisateur qui a passé la commande (supprimé en cascade si l'utilisateur est supprimé)
    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Utilisateur $utilisateur = null;

    // Date automatiquement définie à la création
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCommande = null;

    // Statut de la commande (en attente, confirmée, livrée...) — voir App\Enum\StatutCommande
    #[ORM\Column(type: 'string', enumType: StatutCommande::class)]
    private StatutCommande $statut = StatutCommande::EnAttente;

    // Montant total de la commande en euros
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private string $total = '0.00';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresseLivraison = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $codePostal = null;

    // Numéro de commande lisible affiché dans les emails (ex: CMD-2026-00042)
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $reference = null;

    // Instructions spéciales du client (ex: "sans gluten svp")
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    // Liste des produits inclus dans cette commande (supprimés si la commande est supprimée)
    #[ORM\OneToMany(targetEntity: CommandeProduit::class, mappedBy: 'commande', cascade: ['persist', 'remove'])]
    private Collection $commandeProduits;

    public function __construct()
    {
        $this->dateCommande = new \DateTime();
        $this->commandeProduits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): static
    {
        $this->dateCommande = $dateCommande;
        return $this;
    }

    public function getStatut(): StatutCommande
    {
        return $this->statut;
    }

    public function setStatut(StatutCommande $statut): static
    {
        $this->statut = $statut;
        return $this;
    }

    public function getTotal(): string
    {
        return $this->total;
    }

    public function setTotal(string $total): static
    {
        $this->total = $total;
        return $this;
    }

    public function getAdresseLivraison(): ?string
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison(?string $adresseLivraison): static
    {
        $this->adresseLivraison = $adresseLivraison;
        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;
        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): static
    {
        $this->codePostal = $codePostal;
        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;
        return $this;
    }

    public function getCommandeProduits(): Collection
    {
        return $this->commandeProduits;
    }
}
