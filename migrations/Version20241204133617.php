<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241204133617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");
        $this->addSql("ALTER SESSION SET NLS_TIMESTAMP_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");
        $this->addSql("ALTER SESSION SET NLS_TIMESTAMP_TZ_FORMAT = 'YYYY-MM-DD HH24:MI:SS TZH:TZM'");
        $this->addSql('CREATE TABLE activite_utilisateur (activite_id NUMBER(10) NOT NULL, utilisateur_id NUMBER(10) NOT NULL, PRIMARY KEY(activite_id, utilisateur_id))');
        $this->addSql('CREATE INDEX IDX_3D2F169E9B0F88B1 ON activite_utilisateur (activite_id)');
        $this->addSql('CREATE INDEX IDX_3D2F169EFB88E14F ON activite_utilisateur (utilisateur_id)');
        $this->addSql('CREATE TABLE groupe_utilisateur (groupe_id NUMBER(10) NOT NULL, utilisateur_id NUMBER(10) NOT NULL, PRIMARY KEY(groupe_id, utilisateur_id))');
        $this->addSql('CREATE INDEX IDX_92C1107D7A45358C ON groupe_utilisateur (groupe_id)');
        $this->addSql('CREATE INDEX IDX_92C1107DFB88E14F ON groupe_utilisateur (utilisateur_id)');
        $this->addSql('CREATE TABLE projet_utilisateur (projet_id NUMBER(10) NOT NULL, utilisateur_id NUMBER(10) NOT NULL, PRIMARY KEY(projet_id, utilisateur_id))');
        $this->addSql('CREATE INDEX IDX_C626378DC18272 ON projet_utilisateur (projet_id)');
        $this->addSql('CREATE INDEX IDX_C626378DFB88E14F ON projet_utilisateur (utilisateur_id)');
        $this->addSql('CREATE TABLE tache_utilisateur (tache_id NUMBER(10) NOT NULL, utilisateur_id NUMBER(10) NOT NULL, PRIMARY KEY(tache_id, utilisateur_id))');
        $this->addSql('CREATE INDEX IDX_8E15C4FDD2235D39 ON tache_utilisateur (tache_id)');
        $this->addSql('CREATE INDEX IDX_8E15C4FDFB88E14F ON tache_utilisateur (utilisateur_id)');
        $this->addSql('ALTER TABLE activite_utilisateur ADD CONSTRAINT FK_3D2F169E9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activite_utilisateur ADD CONSTRAINT FK_3D2F169EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_utilisateur ADD CONSTRAINT FK_92C1107D7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_utilisateur ADD CONSTRAINT FK_92C1107DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_utilisateur ADD CONSTRAINT FK_C626378DC18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_utilisateur ADD CONSTRAINT FK_C626378DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tache_utilisateur ADD CONSTRAINT FK_8E15C4FDD2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tache_utilisateur ADD CONSTRAINT FK_8E15C4FDFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ACTIVITE MODIFY (date_debut_reel DATE DEFAULT NULL, date_fin_reel DATE DEFAULT NULL, date_debut_estimee DATE DEFAULT NULL, date_fin_estimee DATE DEFAULT NULL)');
        $this->addSql('ALTER TABLE ASSISTANCE MODIFY (date_creation DATE DEFAULT NULL)');
        $this->addSql('ALTER TABLE DEMANDE MODIFY (date_creation DATE DEFAULT NULL)');
        $this->addSql('ALTER TABLE HISTORIQUE MODIFY (date_historique DATE DEFAULT NULL)');
        $this->addSql('ALTER TABLE PROJET MODIFY (date_debut_reel DATE DEFAULT NULL, date_fin_reel DATE DEFAULT NULL, date_debut_estimee DATE DEFAULT NULL, date_fin_estimee DATE DEFAULT NULL)');
        $this->addSql('ALTER TABLE TACHE MODIFY (date_debut_reel DATE DEFAULT NULL, date_fin_reel DATE DEFAULT NULL, date_debut_estimee DATE DEFAULT NULL, date_fin_estimee DATE DEFAULT NULL)');
        // $this->addSql('ALTER TABLE MESSENGER_MESSAGES MODIFY (id NUMBER(20) DEFAULT messenger_messages_seq.nextval, created_at TIMESTAMP(0) DEFAULT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite_utilisateur DROP CONSTRAINT FK_3D2F169E9B0F88B1');
        $this->addSql('ALTER TABLE activite_utilisateur DROP CONSTRAINT FK_3D2F169EFB88E14F');
        $this->addSql('ALTER TABLE groupe_utilisateur DROP CONSTRAINT FK_92C1107D7A45358C');
        $this->addSql('ALTER TABLE groupe_utilisateur DROP CONSTRAINT FK_92C1107DFB88E14F');
        $this->addSql('ALTER TABLE projet_utilisateur DROP CONSTRAINT FK_C626378DC18272');
        $this->addSql('ALTER TABLE projet_utilisateur DROP CONSTRAINT FK_C626378DFB88E14F');
        $this->addSql('ALTER TABLE tache_utilisateur DROP CONSTRAINT FK_8E15C4FDD2235D39');
        $this->addSql('ALTER TABLE tache_utilisateur DROP CONSTRAINT FK_8E15C4FDFB88E14F');
        $this->addSql('DROP TABLE activite_utilisateur');
        $this->addSql('DROP TABLE groupe_utilisateur');
        $this->addSql('DROP TABLE projet_utilisateur');
        $this->addSql('DROP TABLE tache_utilisateur');
        $this->addSql('ALTER TABLE assistance MODIFY (DATE_CREATION TIMESTAMP(0) DEFAULT NULL)');
        $this->addSql('ALTER TABLE historique MODIFY (DATE_HISTORIQUE DATE DEFAULT NULL)');
        $this->addSql('ALTER TABLE projet MODIFY (DATE_DEBUT_ESTIMEE DATE DEFAULT NULL, DATE_FIN_ESTIMEE DATE DEFAULT NULL, DATE_DEBUT_REEL TIMESTAMP(0) DEFAULT NULL, DATE_FIN_REEL TIMESTAMP(0) DEFAULT NULL)');
        $this->addSql('ALTER TABLE tache MODIFY (DATE_DEBUT_ESTIMEE DATE DEFAULT NULL, DATE_FIN_ESTIMEE DATE DEFAULT NULL, DATE_DEBUT_REEL TIMESTAMP(0) DEFAULT NULL, DATE_FIN_REEL TIMESTAMP(0) DEFAULT NULL)');
        $this->addSql('ALTER TABLE activite MODIFY (DATE_DEBUT_ESTIMEE DATE DEFAULT NULL, DATE_FIN_ESTIMEE DATE DEFAULT NULL, DATE_DEBUT_REEL TIMESTAMP(0) DEFAULT NULL, DATE_FIN_REEL TIMESTAMP(0) DEFAULT NULL)');
        $this->addSql('ALTER TABLE demande MODIFY (DATE_CREATION TIMESTAMP(0) DEFAULT NULL)');
        $this->addSql('ALTER TABLE messenger_messages MODIFY (ID NUMBER(20) DEFAULT NULL, CREATED_AT TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP)');
    }
}
