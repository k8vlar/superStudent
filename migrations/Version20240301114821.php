<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240301114821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6682350831');
        $this->addSql('DROP INDEX IDX_23A0E6682350831 ON article');
        $this->addSql('ALTER TABLE article DROP matieres_id, DROP image');
        $this->addSql('ALTER TABLE user DROP libelle');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD matieres_id INT NOT NULL, ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6682350831 FOREIGN KEY (matieres_id) REFERENCES matieres (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_23A0E6682350831 ON article (matieres_id)');
        $this->addSql('ALTER TABLE user ADD libelle VARCHAR(255) NOT NULL');
    }
}
