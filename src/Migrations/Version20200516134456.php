<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200516134456 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_media (id INT AUTO_INCREMENT NOT NULL, fb VARCHAR(255) DEFAULT NULL, linkedin VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne_cours (personne_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_E92B9DF5A21BD112 (personne_id), INDEX IDX_E92B9DF57ECF78B0 (cours_id), PRIMARY KEY(personne_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personne_cours ADD CONSTRAINT FK_E92B9DF5A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personne_cours ADD CONSTRAINT FK_E92B9DF57ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personne ADD section_id INT DEFAULT NULL, ADD social_media_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFD823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EF64AE4959 FOREIGN KEY (social_media_id) REFERENCES social_media (id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EFD823E37A ON personne (section_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCEC9EF64AE4959 ON personne (social_media_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE personne_cours DROP FOREIGN KEY FK_E92B9DF57ECF78B0');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EF64AE4959');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EFD823E37A');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE social_media');
        $this->addSql('DROP TABLE personne_cours');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP INDEX IDX_FCEC9EFD823E37A ON personne');
        $this->addSql('DROP INDEX UNIQ_FCEC9EF64AE4959 ON personne');
        $this->addSql('ALTER TABLE personne DROP section_id, DROP social_media_id');
    }
}
