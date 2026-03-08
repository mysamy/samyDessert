<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260308223120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, produit_id INT NOT NULL, note INT NOT NULL, commentaire LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_8F91ABF0FB88E14F (utilisateur_id), INDEX IDX_8F91ABF0F347EFB (produit_id), UNIQUE INDEX UNIQ_AVIS_USER_PRODUIT (utilisateur_id, produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, date_commande DATETIME NOT NULL, statut VARCHAR(255) NOT NULL, total NUMERIC(8, 2) NOT NULL, adresse_livraison VARCHAR(255) DEFAULT NULL, ville VARCHAR(100) DEFAULT NULL, code_postal VARCHAR(10) DEFAULT NULL, INDEX IDX_6EEAA67DFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_produit (commande_id INT NOT NULL, produit_id INT NOT NULL, quantite INT NOT NULL, prix_unitaire NUMERIC(8, 2) NOT NULL, INDEX IDX_DF1E9E8782EA2E54 (commande_id), INDEX IDX_DF1E9E87F347EFB (produit_id), PRIMARY KEY(commande_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, contenu LONGTEXT NOT NULL, image_src VARCHAR(255) DEFAULT NULL, duree INT DEFAULT NULL, difficulte VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_49BB6390F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, nom VARCHAR(100) DEFAULT NULL, prenom VARCHAR(100) DEFAULT NULL, UNIQUE INDEX UNIQ_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_produit_favori (utilisateur_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_1B4556ABFB88E14F (utilisateur_id), INDEX IDX_1B4556ABF347EFB (produit_id), PRIMARY KEY(utilisateur_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_recette_favori (utilisateur_id INT NOT NULL, recette_id INT NOT NULL, INDEX IDX_F5875F68FB88E14F (utilisateur_id), INDEX IDX_F5875F6889312FE9 (recette_id), PRIMARY KEY(utilisateur_id, recette_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT FK_DF1E9E8782EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT FK_DF1E9E87F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE utilisateur_produit_favori ADD CONSTRAINT FK_1B4556ABFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_produit_favori ADD CONSTRAINT FK_1B4556ABF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_recette_favori ADD CONSTRAINT FK_F5875F68FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_recette_favori ADD CONSTRAINT FK_F5875F6889312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit ADD categorie_id INT DEFAULT NULL, ADD prix NUMERIC(8, 2) NOT NULL, ADD image_src VARCHAR(255) DEFAULT NULL, ADD disponible TINYINT(1) NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27BCF5E72D ON produit (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BCF5E72D');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0FB88E14F');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0F347EFB');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DFB88E14F');
        $this->addSql('ALTER TABLE commande_produit DROP FOREIGN KEY FK_DF1E9E8782EA2E54');
        $this->addSql('ALTER TABLE commande_produit DROP FOREIGN KEY FK_DF1E9E87F347EFB');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390F347EFB');
        $this->addSql('ALTER TABLE utilisateur_produit_favori DROP FOREIGN KEY FK_1B4556ABFB88E14F');
        $this->addSql('ALTER TABLE utilisateur_produit_favori DROP FOREIGN KEY FK_1B4556ABF347EFB');
        $this->addSql('ALTER TABLE utilisateur_recette_favori DROP FOREIGN KEY FK_F5875F68FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_recette_favori DROP FOREIGN KEY FK_F5875F6889312FE9');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_produit');
        $this->addSql('DROP TABLE recette');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_produit_favori');
        $this->addSql('DROP TABLE utilisateur_recette_favori');
        $this->addSql('DROP INDEX IDX_29A5EC27BCF5E72D ON produit');
        $this->addSql('ALTER TABLE produit DROP categorie_id, DROP prix, DROP image_src, DROP disponible, CHANGE description description LONGTEXT NOT NULL');
    }
}
