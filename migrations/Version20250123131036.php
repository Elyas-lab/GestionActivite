<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250123131036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE activite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE assistance_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE canal_demande_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE demande_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE groupe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE historique_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE permission_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE projet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE source_demande_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE statut_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tache_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_demande_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE utilisateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE activite (id INT NOT NULL, statut_id INT NOT NULL, projet_source_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, date_debut_estimee DATE NOT NULL, date_fin_estimee DATE NOT NULL, date_debut_reel DATE DEFAULT NULL, date_fin_reel DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B8755515F6203804 ON activite (statut_id)');
        $this->addSql('CREATE INDEX IDX_B8755515B6C2FBB5 ON activite (projet_source_id)');
        $this->addSql('CREATE TABLE activite_utilisateur (activite_id INT NOT NULL, utilisateur_id INT NOT NULL, PRIMARY KEY(activite_id, utilisateur_id))');
        $this->addSql('CREATE INDEX IDX_3D2F169E9B0F88B1 ON activite_utilisateur (activite_id)');
        $this->addSql('CREATE INDEX IDX_3D2F169EFB88E14F ON activite_utilisateur (utilisateur_id)');
        $this->addSql('CREATE TABLE assistance (id INT NOT NULL, source_id INT NOT NULL, type_id INT NOT NULL, canal_id INT NOT NULL, statut_id INT NOT NULL, responsable_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT NOT NULL, date_creation DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1B4F85F2953C1C61 ON assistance (source_id)');
        $this->addSql('CREATE INDEX IDX_1B4F85F2C54C8C93 ON assistance (type_id)');
        $this->addSql('CREATE INDEX IDX_1B4F85F268DB5B2E ON assistance (canal_id)');
        $this->addSql('CREATE INDEX IDX_1B4F85F2F6203804 ON assistance (statut_id)');
        $this->addSql('CREATE INDEX IDX_1B4F85F253C59D72 ON assistance (responsable_id)');
        $this->addSql('CREATE TABLE canal_demande (id INT NOT NULL, nom VARCHAR(255) NOT NULL, description TEXT NOT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE demande (id INT NOT NULL, source_id INT NOT NULL, type_id INT NOT NULL, canal_id INT NOT NULL, statut_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT NOT NULL, date_creation DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2694D7A5953C1C61 ON demande (source_id)');
        $this->addSql('CREATE INDEX IDX_2694D7A5C54C8C93 ON demande (type_id)');
        $this->addSql('CREATE INDEX IDX_2694D7A568DB5B2E ON demande (canal_id)');
        $this->addSql('CREATE INDEX IDX_2694D7A5F6203804 ON demande (statut_id)');
        $this->addSql('CREATE TABLE groupe (id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE groupe_utilisateur (groupe_id INT NOT NULL, utilisateur_id INT NOT NULL, PRIMARY KEY(groupe_id, utilisateur_id))');
        $this->addSql('CREATE INDEX IDX_92C1107D7A45358C ON groupe_utilisateur (groupe_id)');
        $this->addSql('CREATE INDEX IDX_92C1107DFB88E14F ON groupe_utilisateur (utilisateur_id)');
        $this->addSql('CREATE TABLE groupe_permission (groupe_id INT NOT NULL, permission_id INT NOT NULL, PRIMARY KEY(groupe_id, permission_id))');
        $this->addSql('CREATE INDEX IDX_58A4A3767A45358C ON groupe_permission (groupe_id)');
        $this->addSql('CREATE INDEX IDX_58A4A376FED90CCA ON groupe_permission (permission_id)');
        $this->addSql('CREATE TABLE historique (id INT NOT NULL, utilisateur_id INT NOT NULL, date_historique DATE NOT NULL, details_historique VARCHAR(1000) DEFAULT NULL, type_element VARCHAR(255) NOT NULL, id_element INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EDBFD5ECFB88E14F ON historique (utilisateur_id)');
        $this->addSql('CREATE INDEX idx_historique_type ON historique (type_element, id_element)');
        $this->addSql('CREATE INDEX idx_historique_date ON historique (date_historique)');
        $this->addSql('CREATE TABLE permission (id INT NOT NULL, nom VARCHAR(255) NOT NULL, description TEXT NOT NULL, categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE projet (id INT NOT NULL, statut_id INT NOT NULL, demande_source_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, date_debut_estimee DATE NOT NULL, date_fin_estimee DATE NOT NULL, date_debut_reel DATE DEFAULT NULL, date_fin_reel DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_50159CA9F6203804 ON projet (statut_id)');
        $this->addSql('CREATE INDEX IDX_50159CA9E010E6B4 ON projet (demande_source_id)');
        $this->addSql('CREATE TABLE projet_utilisateur (projet_id INT NOT NULL, utilisateur_id INT NOT NULL, PRIMARY KEY(projet_id, utilisateur_id))');
        $this->addSql('CREATE INDEX IDX_C626378DC18272 ON projet_utilisateur (projet_id)');
        $this->addSql('CREATE INDEX IDX_C626378DFB88E14F ON projet_utilisateur (utilisateur_id)');
        $this->addSql('CREATE TABLE source_demande (id INT NOT NULL, nom VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE statut (id INT NOT NULL, nom VARCHAR(255) NOT NULL, description TEXT NOT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tache (id INT NOT NULL, statut_id INT NOT NULL, activite_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, date_debut_estimee DATE NOT NULL, date_fin_estimee DATE NOT NULL, date_debut_reel DATE DEFAULT NULL, date_fin_reel DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_93872075F6203804 ON tache (statut_id)');
        $this->addSql('CREATE INDEX IDX_938720759B0F88B1 ON tache (activite_id)');
        $this->addSql('CREATE TABLE tache_utilisateur (tache_id INT NOT NULL, utilisateur_id INT NOT NULL, PRIMARY KEY(tache_id, utilisateur_id))');
        $this->addSql('CREATE INDEX IDX_8E15C4FDD2235D39 ON tache_utilisateur (tache_id)');
        $this->addSql('CREATE INDEX IDX_8E15C4FDFB88E14F ON tache_utilisateur (utilisateur_id)');
        $this->addSql('CREATE TABLE type_demande (id INT NOT NULL, nom VARCHAR(255) NOT NULL, description TEXT NOT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE utilisateur (id INT NOT NULL, matricule VARCHAR(180) NOT NULL, nom VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_MATRICULE ON utilisateur (matricule)');
        $this->addSql('CREATE TABLE utilisateur_groupe (utilisateur_id INT NOT NULL, groupe_id INT NOT NULL, PRIMARY KEY(utilisateur_id, groupe_id))');
        $this->addSql('CREATE INDEX IDX_6514B6AAFB88E14F ON utilisateur_groupe (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_6514B6AA7A45358C ON utilisateur_groupe (groupe_id)');
        $this->addSql('CREATE TABLE utilisateur_projet (utilisateur_id INT NOT NULL, projet_id INT NOT NULL, PRIMARY KEY(utilisateur_id, projet_id))');
        $this->addSql('CREATE INDEX IDX_31B8A622FB88E14F ON utilisateur_projet (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_31B8A622C18272 ON utilisateur_projet (projet_id)');
        $this->addSql('CREATE TABLE utilisateur_activite (utilisateur_id INT NOT NULL, activite_id INT NOT NULL, PRIMARY KEY(utilisateur_id, activite_id))');
        $this->addSql('CREATE INDEX IDX_A60EAC8AFB88E14F ON utilisateur_activite (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_A60EAC8A9B0F88B1 ON utilisateur_activite (activite_id)');
        $this->addSql('CREATE TABLE utilisateur_tache (utilisateur_id INT NOT NULL, tache_id INT NOT NULL, PRIMARY KEY(utilisateur_id, tache_id))');
        $this->addSql('CREATE INDEX IDX_554278ABFB88E14F ON utilisateur_tache (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_554278ABD2235D39 ON utilisateur_tache (tache_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515B6C2FBB5 FOREIGN KEY (projet_source_id) REFERENCES projet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE activite_utilisateur ADD CONSTRAINT FK_3D2F169E9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE activite_utilisateur ADD CONSTRAINT FK_3D2F169EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assistance ADD CONSTRAINT FK_1B4F85F2953C1C61 FOREIGN KEY (source_id) REFERENCES source_demande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assistance ADD CONSTRAINT FK_1B4F85F2C54C8C93 FOREIGN KEY (type_id) REFERENCES type_demande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assistance ADD CONSTRAINT FK_1B4F85F268DB5B2E FOREIGN KEY (canal_id) REFERENCES canal_demande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assistance ADD CONSTRAINT FK_1B4F85F2F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assistance ADD CONSTRAINT FK_1B4F85F253C59D72 FOREIGN KEY (responsable_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5953C1C61 FOREIGN KEY (source_id) REFERENCES source_demande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5C54C8C93 FOREIGN KEY (type_id) REFERENCES type_demande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A568DB5B2E FOREIGN KEY (canal_id) REFERENCES canal_demande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE groupe_utilisateur ADD CONSTRAINT FK_92C1107D7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE groupe_utilisateur ADD CONSTRAINT FK_92C1107DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE groupe_permission ADD CONSTRAINT FK_58A4A3767A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE groupe_permission ADD CONSTRAINT FK_58A4A376FED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9E010E6B4 FOREIGN KEY (demande_source_id) REFERENCES demande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE projet_utilisateur ADD CONSTRAINT FK_C626378DC18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE projet_utilisateur ADD CONSTRAINT FK_C626378DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_938720759B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tache_utilisateur ADD CONSTRAINT FK_8E15C4FDD2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tache_utilisateur ADD CONSTRAINT FK_8E15C4FDFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_groupe ADD CONSTRAINT FK_6514B6AAFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_groupe ADD CONSTRAINT FK_6514B6AA7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_projet ADD CONSTRAINT FK_31B8A622FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_projet ADD CONSTRAINT FK_31B8A622C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_activite ADD CONSTRAINT FK_A60EAC8AFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_activite ADD CONSTRAINT FK_A60EAC8A9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_tache ADD CONSTRAINT FK_554278ABFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_tache ADD CONSTRAINT FK_554278ABD2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE activite_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE assistance_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE canal_demande_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE demande_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE groupe_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE historique_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE permission_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE projet_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE source_demande_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE statut_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tache_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_demande_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE utilisateur_id_seq CASCADE');
        $this->addSql('ALTER TABLE activite DROP CONSTRAINT FK_B8755515F6203804');
        $this->addSql('ALTER TABLE activite DROP CONSTRAINT FK_B8755515B6C2FBB5');
        $this->addSql('ALTER TABLE activite_utilisateur DROP CONSTRAINT FK_3D2F169E9B0F88B1');
        $this->addSql('ALTER TABLE activite_utilisateur DROP CONSTRAINT FK_3D2F169EFB88E14F');
        $this->addSql('ALTER TABLE assistance DROP CONSTRAINT FK_1B4F85F2953C1C61');
        $this->addSql('ALTER TABLE assistance DROP CONSTRAINT FK_1B4F85F2C54C8C93');
        $this->addSql('ALTER TABLE assistance DROP CONSTRAINT FK_1B4F85F268DB5B2E');
        $this->addSql('ALTER TABLE assistance DROP CONSTRAINT FK_1B4F85F2F6203804');
        $this->addSql('ALTER TABLE assistance DROP CONSTRAINT FK_1B4F85F253C59D72');
        $this->addSql('ALTER TABLE demande DROP CONSTRAINT FK_2694D7A5953C1C61');
        $this->addSql('ALTER TABLE demande DROP CONSTRAINT FK_2694D7A5C54C8C93');
        $this->addSql('ALTER TABLE demande DROP CONSTRAINT FK_2694D7A568DB5B2E');
        $this->addSql('ALTER TABLE demande DROP CONSTRAINT FK_2694D7A5F6203804');
        $this->addSql('ALTER TABLE groupe_utilisateur DROP CONSTRAINT FK_92C1107D7A45358C');
        $this->addSql('ALTER TABLE groupe_utilisateur DROP CONSTRAINT FK_92C1107DFB88E14F');
        $this->addSql('ALTER TABLE groupe_permission DROP CONSTRAINT FK_58A4A3767A45358C');
        $this->addSql('ALTER TABLE groupe_permission DROP CONSTRAINT FK_58A4A376FED90CCA');
        $this->addSql('ALTER TABLE historique DROP CONSTRAINT FK_EDBFD5ECFB88E14F');
        $this->addSql('ALTER TABLE projet DROP CONSTRAINT FK_50159CA9F6203804');
        $this->addSql('ALTER TABLE projet DROP CONSTRAINT FK_50159CA9E010E6B4');
        $this->addSql('ALTER TABLE projet_utilisateur DROP CONSTRAINT FK_C626378DC18272');
        $this->addSql('ALTER TABLE projet_utilisateur DROP CONSTRAINT FK_C626378DFB88E14F');
        $this->addSql('ALTER TABLE tache DROP CONSTRAINT FK_93872075F6203804');
        $this->addSql('ALTER TABLE tache DROP CONSTRAINT FK_938720759B0F88B1');
        $this->addSql('ALTER TABLE tache_utilisateur DROP CONSTRAINT FK_8E15C4FDD2235D39');
        $this->addSql('ALTER TABLE tache_utilisateur DROP CONSTRAINT FK_8E15C4FDFB88E14F');
        $this->addSql('ALTER TABLE utilisateur_groupe DROP CONSTRAINT FK_6514B6AAFB88E14F');
        $this->addSql('ALTER TABLE utilisateur_groupe DROP CONSTRAINT FK_6514B6AA7A45358C');
        $this->addSql('ALTER TABLE utilisateur_projet DROP CONSTRAINT FK_31B8A622FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_projet DROP CONSTRAINT FK_31B8A622C18272');
        $this->addSql('ALTER TABLE utilisateur_activite DROP CONSTRAINT FK_A60EAC8AFB88E14F');
        $this->addSql('ALTER TABLE utilisateur_activite DROP CONSTRAINT FK_A60EAC8A9B0F88B1');
        $this->addSql('ALTER TABLE utilisateur_tache DROP CONSTRAINT FK_554278ABFB88E14F');
        $this->addSql('ALTER TABLE utilisateur_tache DROP CONSTRAINT FK_554278ABD2235D39');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE activite_utilisateur');
        $this->addSql('DROP TABLE assistance');
        $this->addSql('DROP TABLE canal_demande');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE groupe_utilisateur');
        $this->addSql('DROP TABLE groupe_permission');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE projet_utilisateur');
        $this->addSql('DROP TABLE source_demande');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE tache_utilisateur');
        $this->addSql('DROP TABLE type_demande');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_groupe');
        $this->addSql('DROP TABLE utilisateur_projet');
        $this->addSql('DROP TABLE utilisateur_activite');
        $this->addSql('DROP TABLE utilisateur_tache');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
