<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209121740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ACTIVITE MODIFY (date_debut_reel DATE DEFAULT NULL, date_fin_reel DATE DEFAULT NULL, date_debut_estimee DATE DEFAULT NULL, date_fin_estimee DATE DEFAULT NULL)');
        $this->addSql('ALTER TABLE ASSISTANCE MODIFY (date_creation DATE DEFAULT NULL)');
        $this->addSql('ALTER TABLE DEMANDE MODIFY (date_creation DATE DEFAULT NULL)');
        $this->addSql('ALTER TABLE HISTORIQUE MODIFY (date_historique DATE DEFAULT NULL)');
        $this->addSql('ALTER TABLE PROJET MODIFY (date_debut_reel DATE DEFAULT NULL, date_fin_reel DATE DEFAULT NULL, date_debut_estimee DATE DEFAULT NULL, date_fin_estimee DATE DEFAULT NULL)');
        $this->addSql('ALTER TABLE TACHE MODIFY (date_debut_reel DATE DEFAULT NULL, date_fin_reel DATE DEFAULT NULL, date_debut_estimee DATE DEFAULT NULL, date_fin_estimee DATE DEFAULT NULL)');
        //$this->addSql('ALTER TABLE MESSENGER_MESSAGES MODIFY (id NUMBER(20) DEFAULT messenger_messages_seq.nextval, created_at TIMESTAMP(0) DEFAULT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messenger_messages MODIFY (ID NUMBER(20) DEFAULT NULL, CREATED_AT TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP)');
        $this->addSql('ALTER TABLE activite MODIFY (DATE_DEBUT_ESTIMEE DATE DEFAULT NULL, DATE_FIN_ESTIMEE DATE DEFAULT NULL, DATE_DEBUT_REEL TIMESTAMP(0) DEFAULT NULL, DATE_FIN_REEL TIMESTAMP(0) DEFAULT NULL)');
        $this->addSql('ALTER TABLE projet MODIFY (DATE_DEBUT_ESTIMEE DATE DEFAULT NULL, DATE_FIN_ESTIMEE DATE DEFAULT NULL, DATE_DEBUT_REEL TIMESTAMP(0) DEFAULT NULL, DATE_FIN_REEL TIMESTAMP(0) DEFAULT NULL)');
        $this->addSql('ALTER TABLE assistance MODIFY (DATE_CREATION TIMESTAMP(0) DEFAULT NULL)');
        $this->addSql('ALTER TABLE tache MODIFY (DATE_DEBUT_ESTIMEE DATE DEFAULT NULL, DATE_FIN_ESTIMEE DATE DEFAULT NULL, DATE_DEBUT_REEL TIMESTAMP(0) DEFAULT NULL, DATE_FIN_REEL TIMESTAMP(0) DEFAULT NULL)');
        $this->addSql('ALTER TABLE demande MODIFY (DATE_CREATION TIMESTAMP(0) DEFAULT NULL)');
        $this->addSql('ALTER TABLE historique MODIFY (DATE_HISTORIQUE DATE DEFAULT NULL)');
    }
}
