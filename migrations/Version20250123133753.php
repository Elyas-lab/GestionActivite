<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250123133753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite ALTER date_debut_estimee TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE activite ALTER date_fin_estimee TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE activite ALTER date_debut_reel TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE activite ALTER date_fin_reel TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE assistance ALTER date_creation TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE demande ALTER date_creation TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE historique ALTER date_historique TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE projet ALTER date_debut_estimee TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE projet ALTER date_fin_estimee TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE projet ALTER date_debut_reel TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE projet ALTER date_fin_reel TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE tache ALTER date_debut_estimee TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE tache ALTER date_fin_estimee TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE tache ALTER date_debut_reel TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE tache ALTER date_fin_reel TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE demande ALTER date_creation TYPE DATE');
        $this->addSql('ALTER TABLE activite ALTER date_debut_estimee TYPE DATE');
        $this->addSql('ALTER TABLE activite ALTER date_fin_estimee TYPE DATE');
        $this->addSql('ALTER TABLE activite ALTER date_debut_reel TYPE DATE');
        $this->addSql('ALTER TABLE activite ALTER date_fin_reel TYPE DATE');
        $this->addSql('ALTER TABLE projet ALTER date_debut_estimee TYPE DATE');
        $this->addSql('ALTER TABLE projet ALTER date_fin_estimee TYPE DATE');
        $this->addSql('ALTER TABLE projet ALTER date_debut_reel TYPE DATE');
        $this->addSql('ALTER TABLE projet ALTER date_fin_reel TYPE DATE');
        $this->addSql('ALTER TABLE tache ALTER date_debut_estimee TYPE DATE');
        $this->addSql('ALTER TABLE tache ALTER date_fin_estimee TYPE DATE');
        $this->addSql('ALTER TABLE tache ALTER date_debut_reel TYPE DATE');
        $this->addSql('ALTER TABLE tache ALTER date_fin_reel TYPE DATE');
        $this->addSql('ALTER TABLE historique ALTER date_historique TYPE DATE');
        $this->addSql('ALTER TABLE assistance ALTER date_creation TYPE DATE');
    }
}
