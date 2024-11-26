<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241125125502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur_projet (utilisateur_id NUMBER(10) NOT NULL, projet_id NUMBER(10) NOT NULL, PRIMARY KEY(utilisateur_id, projet_id))');
        $this->addSql('CREATE INDEX IDX_31B8A622FB88E14F ON utilisateur_projet (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_31B8A622C18272 ON utilisateur_projet (projet_id)');
        $this->addSql('CREATE TABLE utilisateur_activite (utilisateur_id NUMBER(10) NOT NULL, activite_id NUMBER(10) NOT NULL, PRIMARY KEY(utilisateur_id, activite_id))');
        $this->addSql('CREATE INDEX IDX_A60EAC8AFB88E14F ON utilisateur_activite (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_A60EAC8A9B0F88B1 ON utilisateur_activite (activite_id)');
        $this->addSql('CREATE TABLE utilisateur_tache (utilisateur_id NUMBER(10) NOT NULL, tache_id NUMBER(10) NOT NULL, PRIMARY KEY(utilisateur_id, tache_id))');
        $this->addSql('CREATE INDEX IDX_554278ABFB88E14F ON utilisateur_tache (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_554278ABD2235D39 ON utilisateur_tache (tache_id)');
        $this->addSql('ALTER TABLE utilisateur_projet ADD CONSTRAINT FK_31B8A622FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_projet ADD CONSTRAINT FK_31B8A622C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_activite ADD CONSTRAINT FK_A60EAC8AFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_activite ADD CONSTRAINT FK_A60EAC8A9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_tache ADD CONSTRAINT FK_554278ABFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_tache ADD CONSTRAINT FK_554278ABD2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE TACHE_UTILISATEUR DROP CONSTRAINT FK_8E15C4FDD2235D39');
        $this->addSql('ALTER TABLE TACHE_UTILISATEUR DROP CONSTRAINT FK_8E15C4FDFB88E14F');
        $this->addSql('ALTER TABLE ACTIVITE_UTILISATEUR DROP CONSTRAINT FK_3D2F169E9B0F88B1');
        $this->addSql('ALTER TABLE ACTIVITE_UTILISATEUR DROP CONSTRAINT FK_3D2F169EFB88E14F');
        $this->addSql('DROP TABLE TACHE_UTILISATEUR');
        $this->addSql('DROP TABLE ACTIVITE_UTILISATEUR');
        $this->addSql('ALTER TABLE ACTIVITE MODIFY (date_debut_reel TIMESTAMP(0) DEFAULT NULL, date_fin_reel TIMESTAMP(0) DEFAULT NULL)');
        $this->addSql('ALTER TABLE PROJET MODIFY (date_debut_reel TIMESTAMP(0) DEFAULT NULL, date_fin_reel TIMESTAMP(0) DEFAULT NULL)');
        $this->addSql('ALTER TABLE TACHE MODIFY (date_debut_reel TIMESTAMP(0) DEFAULT NULL, date_fin_reel TIMESTAMP(0) DEFAULT NULL)');
        $this->addSql('CREATE TABLE messenger_messages (id NUMBER(20) DEFAULT messenger_messages_seq.nextval NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR2(190) NOT NULL, created_at TIMESTAMP(0) NOT NULL, available_at TIMESTAMP(0) NOT NULL, delivered_at TIMESTAMP(0) DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('DECLARE
          constraints_Count NUMBER;
        BEGIN
          SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count
            FROM USER_CONSTRAINTS
           WHERE TABLE_NAME = \'MESSENGER_MESSAGES\'
             AND CONSTRAINT_TYPE = \'P\';
          IF constraints_Count = 0 OR constraints_Count = \'\' THEN
            EXECUTE IMMEDIATE \'ALTER TABLE MESSENGER_MESSAGES ADD CONSTRAINT MESSENGER_MESSAGES_AI_PK PRIMARY KEY (ID)\';
          END IF;
        END;');
        $this->addSql('CREATE SEQUENCE MESSENGER_MESSAGES_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE TRIGGER MESSENGER_MESSAGES_AI_PK
           BEFORE INSERT
           ON MESSENGER_MESSAGES
           FOR EACH ROW
        DECLARE
           last_Sequence NUMBER;
           last_InsertID NUMBER;
        BEGIN
           IF (:NEW.ID IS NULL OR :NEW.ID = 0) THEN
              SELECT MESSENGER_MESSAGES_SEQ.NEXTVAL INTO :NEW.ID FROM DUAL;
           ELSE
              SELECT NVL(Last_Number, 0) INTO last_Sequence
                FROM User_Sequences
               WHERE Sequence_Name = \'MESSENGER_MESSAGES_SEQ\';
              SELECT :NEW.ID INTO last_InsertID FROM DUAL;
              WHILE (last_InsertID > last_Sequence) LOOP
                 SELECT MESSENGER_MESSAGES_SEQ.NEXTVAL INTO last_Sequence FROM DUAL;
              END LOOP;
              SELECT MESSENGER_MESSAGES_SEQ.NEXTVAL INTO last_Sequence FROM DUAL;
           END IF;
        END;');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE TACHE_UTILISATEUR (TACHE_ID NUMBER(10) NOT NULL, UTILISATEUR_ID NUMBER(10) NOT NULL, PRIMARY KEY(TACHE_ID, UTILISATEUR_ID))');
        $this->addSql('CREATE INDEX idx_8e15c4fdd2235d39 ON TACHE_UTILISATEUR (TACHE_ID)');
        $this->addSql('CREATE INDEX idx_8e15c4fdfb88e14f ON TACHE_UTILISATEUR (UTILISATEUR_ID)');
        $this->addSql('CREATE TABLE ACTIVITE_UTILISATEUR (ACTIVITE_ID NUMBER(10) NOT NULL, UTILISATEUR_ID NUMBER(10) NOT NULL, PRIMARY KEY(ACTIVITE_ID, UTILISATEUR_ID))');
        $this->addSql('CREATE INDEX idx_3d2f169e9b0f88b1 ON ACTIVITE_UTILISATEUR (ACTIVITE_ID)');
        $this->addSql('CREATE INDEX idx_3d2f169efb88e14f ON ACTIVITE_UTILISATEUR (UTILISATEUR_ID)');
        $this->addSql('ALTER TABLE TACHE_UTILISATEUR ADD CONSTRAINT FK_8E15C4FDD2235D39 FOREIGN KEY (TACHE_ID) REFERENCES TACHE (ID) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE TACHE_UTILISATEUR ADD CONSTRAINT FK_8E15C4FDFB88E14F FOREIGN KEY (UTILISATEUR_ID) REFERENCES UTILISATEUR (ID) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ACTIVITE_UTILISATEUR ADD CONSTRAINT FK_3D2F169E9B0F88B1 FOREIGN KEY (ACTIVITE_ID) REFERENCES ACTIVITE (ID) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ACTIVITE_UTILISATEUR ADD CONSTRAINT FK_3D2F169EFB88E14F FOREIGN KEY (UTILISATEUR_ID) REFERENCES UTILISATEUR (ID) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_projet DROP CONSTRAINT FK_31B8A622FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_projet DROP CONSTRAINT FK_31B8A622C18272');
        $this->addSql('ALTER TABLE utilisateur_activite DROP CONSTRAINT FK_A60EAC8AFB88E14F');
        $this->addSql('ALTER TABLE utilisateur_activite DROP CONSTRAINT FK_A60EAC8A9B0F88B1');
        $this->addSql('ALTER TABLE utilisateur_tache DROP CONSTRAINT FK_554278ABFB88E14F');
        $this->addSql('ALTER TABLE utilisateur_tache DROP CONSTRAINT FK_554278ABD2235D39');
        $this->addSql('DROP TABLE utilisateur_projet');
        $this->addSql('DROP TABLE utilisateur_activite');
        $this->addSql('DROP TABLE utilisateur_tache');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE activite MODIFY (DATE_DEBUT_REEL TIMESTAMP(0) DEFAULT NULL, DATE_FIN_REEL TIMESTAMP(0) DEFAULT NULL)');
        $this->addSql('ALTER TABLE tache MODIFY (DATE_DEBUT_REEL TIMESTAMP(0) DEFAULT NULL, DATE_FIN_REEL TIMESTAMP(0) DEFAULT NULL)');
        $this->addSql('ALTER TABLE projet MODIFY (DATE_DEBUT_REEL TIMESTAMP(0) DEFAULT NULL, DATE_FIN_REEL TIMESTAMP(0) DEFAULT NULL)');
    }
}
