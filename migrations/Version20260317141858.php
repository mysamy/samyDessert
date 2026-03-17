<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260317141858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis ADD is_valide TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE categorie ADD slug VARCHAR(100) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497DD634989D9B62 ON categorie (slug)');
        $this->addSql('ALTER TABLE commande ADD reference VARCHAR(50) DEFAULT NULL, ADD notes LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD slug VARCHAR(255) DEFAULT NULL, ADD stock INT NOT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29A5EC27989D9B62 ON produit (slug)');
        $this->addSql('ALTER TABLE recette ADD categorie_id INT DEFAULT NULL, ADD portions INT DEFAULT NULL, ADD slug VARCHAR(255) DEFAULT NULL, ADD is_published TINYINT(1) NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_49BB6390989D9B62 ON recette (slug)');
        $this->addSql('CREATE INDEX IDX_49BB6390BCF5E72D ON recette (categorie_id)');
        $this->addSql('ALTER TABLE utilisateur ADD telephone VARCHAR(20) DEFAULT NULL, ADD adresse VARCHAR(255) DEFAULT NULL, ADD ville VARCHAR(100) DEFAULT NULL, ADD code_postal VARCHAR(10) DEFAULT NULL, ADD is_verified TINYINT(1) NOT NULL, ADD verification_token VARCHAR(64) DEFAULT NULL, CHANGE mot_de_passe password VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP telephone, DROP adresse, DROP ville, DROP code_postal, DROP is_verified, DROP verification_token, CHANGE password mot_de_passe VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390BCF5E72D');
        $this->addSql('DROP INDEX UNIQ_49BB6390989D9B62 ON recette');
        $this->addSql('DROP INDEX IDX_49BB6390BCF5E72D ON recette');
        $this->addSql('ALTER TABLE recette DROP categorie_id, DROP portions, DROP slug, DROP is_published, DROP updated_at');
        $this->addSql('DROP INDEX UNIQ_29A5EC27989D9B62 ON produit');
        $this->addSql('ALTER TABLE produit DROP slug, DROP stock, DROP created_at');
        $this->addSql('ALTER TABLE commande DROP reference, DROP notes');
        $this->addSql('DROP INDEX UNIQ_497DD634989D9B62 ON categorie');
        $this->addSql('ALTER TABLE categorie DROP slug');
        $this->addSql('ALTER TABLE avis DROP is_valide');
    }
}
