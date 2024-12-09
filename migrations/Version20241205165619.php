<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241205165619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE ASSISTANCE (ID NUMBER(10) NOT NULL, SOURCE_ID NUMBER(10) NOT NULL, TYPE_ID NUMBER(10) NOT NULL, CANAL_ID NUMBER(10) NOT NULL, STATUT_ID NUMBER(10) NOT NULL, RESPONSABLE_ID NUMBER(10) NOT NULL, TITRE VARCHAR2(255) NOT NULL, DESCRIPTION CLOB NOT NULL, DATE_CREATION TIMESTAMP(0) NOT NULL, PRIMARY KEY(ID))');
        $this->addSql('CREATE INDEX idx_1b4f85f253c59d72 ON ASSISTANCE (RESPONSABLE_ID)');
        $this->addSql('CREATE INDEX idx_1b4f85f268db5b2e ON ASSISTANCE (CANAL_ID)');
        $this->addSql('CREATE INDEX idx_1b4f85f2953c1c61 ON ASSISTANCE (SOURCE_ID)');
        $this->addSql('CREATE INDEX idx_1b4f85f2c54c8c93 ON ASSISTANCE (TYPE_ID)');
        $this->addSql('CREATE INDEX idx_1b4f85f2f6203804 ON ASSISTANCE (STATUT_ID)');
        $this->addSql('COMMENT ON COLUMN ASSISTANCE.DATE_CREATION IS \'(DC2Type:datetime_immutable)\'');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE UTILISATEUR (ID NUMBER(10) NOT NULL, MATRICULE VARCHAR2(180) NOT NULL, PASSWORD VARCHAR2(255) NOT NULL, NOM VARCHAR2(255) NOT NULL, PRIMARY KEY(ID))');
        $this->addSql('CREATE UNIQUE INDEX uniq_identifier_matricule ON UTILISATEUR (MATRICULE)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE GROUPE_UTILISATEUR (GROUPE_ID NUMBER(10) NOT NULL, UTILISATEUR_ID NUMBER(10) NOT NULL, PRIMARY KEY(GROUPE_ID, UTILISATEUR_ID))');
        $this->addSql('CREATE INDEX idx_92c1107d7a45358c ON GROUPE_UTILISATEUR (GROUPE_ID)');
        $this->addSql('CREATE INDEX idx_92c1107dfb88e14f ON GROUPE_UTILISATEUR (UTILISATEUR_ID)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE UTILISATEUR_GROUPE (UTILISATEUR_ID NUMBER(10) NOT NULL, GROUPE_ID NUMBER(10) NOT NULL, PRIMARY KEY(UTILISATEUR_ID, GROUPE_ID))');
        $this->addSql('CREATE INDEX idx_6514b6aa7a45358c ON UTILISATEUR_GROUPE (GROUPE_ID)');
        $this->addSql('CREATE INDEX idx_6514b6aafb88e14f ON UTILISATEUR_GROUPE (UTILISATEUR_ID)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE MESSENGER_MESSAGES (ID NUMBER(20) NOT NULL, BODY CLOB NOT NULL, HEADERS CLOB NOT NULL, QUEUE_NAME VARCHAR2(190) NOT NULL, CREATED_AT TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP NOT NULL, AVAILABLE_AT TIMESTAMP(0) NOT NULL, DELIVERED_AT TIMESTAMP(0) DEFAULT NULL NULL, PRIMARY KEY(ID))');
        $this->addSql('CREATE INDEX idx_75ea56e016ba31db ON MESSENGER_MESSAGES (DELIVERED_AT)');
        $this->addSql('CREATE INDEX idx_75ea56e0e3bd61ce ON MESSENGER_MESSAGES (AVAILABLE_AT)');
        $this->addSql('CREATE INDEX idx_75ea56e0fb7336f0 ON MESSENGER_MESSAGES (QUEUE_NAME)');
        $this->addSql('COMMENT ON COLUMN MESSENGER_MESSAGES.CREATED_AT IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN MESSENGER_MESSAGES.AVAILABLE_AT IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN MESSENGER_MESSAGES.DELIVERED_AT IS \'(DC2Type:datetime_immutable)\'');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE GROUPE_PERMISSION (GROUPE_ID NUMBER(10) NOT NULL, PERMISSION_ID NUMBER(10) NOT NULL, PRIMARY KEY(GROUPE_ID, PERMISSION_ID))');
        $this->addSql('CREATE INDEX idx_58a4a3767a45358c ON GROUPE_PERMISSION (GROUPE_ID)');
        $this->addSql('CREATE INDEX idx_58a4a376fed90cca ON GROUPE_PERMISSION (PERMISSION_ID)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE TYPE_DEMANDE (ID NUMBER(10) NOT NULL, NOM VARCHAR2(255) NOT NULL, DESCRIPTION CLOB NOT NULL, IS_ACTIVE NUMBER(1) NOT NULL, PRIMARY KEY(ID))');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE PERMISSION (ID NUMBER(10) NOT NULL, NOM VARCHAR2(255) NOT NULL, DESCRIPTION CLOB NOT NULL, CATEGORIE VARCHAR2(255) NOT NULL, PRIMARY KEY(ID))');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE GROUPE (ID NUMBER(10) NOT NULL, NOM VARCHAR2(255) NOT NULL, DESCRIPTION VARCHAR2(255) DEFAULT NULL NULL, PRIMARY KEY(ID))');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE ACTIVITE_UTILISATEUR (ACTIVITE_ID NUMBER(10) NOT NULL, UTILISATEUR_ID NUMBER(10) NOT NULL, PRIMARY KEY(ACTIVITE_ID, UTILISATEUR_ID))');
        $this->addSql('CREATE INDEX idx_3d2f169e9b0f88b1 ON ACTIVITE_UTILISATEUR (ACTIVITE_ID)');
        $this->addSql('CREATE INDEX idx_3d2f169efb88e14f ON ACTIVITE_UTILISATEUR (UTILISATEUR_ID)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE PROJET (ID NUMBER(10) NOT NULL, STATUT_ID NUMBER(10) NOT NULL, TITRE VARCHAR2(255) NOT NULL, DESCRIPTION CLOB DEFAULT NULL NULL, DATE_DEBUT_REEL TIMESTAMP(0) DEFAULT NULL NULL, DATE_FIN_REEL TIMESTAMP(0) DEFAULT NULL NULL, DEMANDE_SOURCE_ID NUMBER(10) NOT NULL, DATE_DEBUT_ESTIMEE DATE NOT NULL, DATE_FIN_ESTIMEE DATE NOT NULL, PRIMARY KEY(ID))');
        $this->addSql('CREATE INDEX idx_50159ca9e010e6b4 ON PROJET (DEMANDE_SOURCE_ID)');
        $this->addSql('CREATE INDEX idx_50159ca9f6203804 ON PROJET (STATUT_ID)');
        $this->addSql('COMMENT ON COLUMN PROJET.DATE_DEBUT_REEL IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN PROJET.DATE_FIN_REEL IS \'(DC2Type:datetime_immutable)\'');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE UTILISATEUR_TACHE (UTILISATEUR_ID NUMBER(10) NOT NULL, TACHE_ID NUMBER(10) NOT NULL, PRIMARY KEY(UTILISATEUR_ID, TACHE_ID))');
        $this->addSql('CREATE INDEX idx_554278abd2235d39 ON UTILISATEUR_TACHE (TACHE_ID)');
        $this->addSql('CREATE INDEX idx_554278abfb88e14f ON UTILISATEUR_TACHE (UTILISATEUR_ID)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE PROJET_UTILISATEUR (PROJET_ID NUMBER(10) NOT NULL, UTILISATEUR_ID NUMBER(10) NOT NULL, PRIMARY KEY(PROJET_ID, UTILISATEUR_ID))');
        $this->addSql('CREATE INDEX idx_c626378dc18272 ON PROJET_UTILISATEUR (PROJET_ID)');
        $this->addSql('CREATE INDEX idx_c626378dfb88e14f ON PROJET_UTILISATEUR (UTILISATEUR_ID)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE TACHE_UTILISATEUR (TACHE_ID NUMBER(10) NOT NULL, UTILISATEUR_ID NUMBER(10) NOT NULL, PRIMARY KEY(TACHE_ID, UTILISATEUR_ID))');
        $this->addSql('CREATE INDEX idx_8e15c4fdd2235d39 ON TACHE_UTILISATEUR (TACHE_ID)');
        $this->addSql('CREATE INDEX idx_8e15c4fdfb88e14f ON TACHE_UTILISATEUR (UTILISATEUR_ID)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE ACTIVITE (ID NUMBER(10) NOT NULL, STATUT_ID NUMBER(10) NOT NULL, TITRE VARCHAR2(255) NOT NULL, DESCRIPTION CLOB DEFAULT NULL NULL, DATE_DEBUT_REEL TIMESTAMP(0) DEFAULT NULL NULL, DATE_FIN_REEL TIMESTAMP(0) DEFAULT NULL NULL, PROJET_SOURCE_ID NUMBER(10) NOT NULL, DATE_DEBUT_ESTIMEE DATE NOT NULL, DATE_FIN_ESTIMEE DATE NOT NULL, PRIMARY KEY(ID))');
        $this->addSql('CREATE INDEX idx_b8755515b6c2fbb5 ON ACTIVITE (PROJET_SOURCE_ID)');
        $this->addSql('CREATE INDEX idx_b8755515f6203804 ON ACTIVITE (STATUT_ID)');
        $this->addSql('COMMENT ON COLUMN ACTIVITE.DATE_DEBUT_REEL IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN ACTIVITE.DATE_FIN_REEL IS \'(DC2Type:datetime_immutable)\'');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE TACHE (ID NUMBER(10) NOT NULL, STATUT_ID NUMBER(10) NOT NULL, TITRE VARCHAR2(255) NOT NULL, DESCRIPTION CLOB DEFAULT NULL NULL, DATE_DEBUT_REEL TIMESTAMP(0) DEFAULT NULL NULL, DATE_FIN_REEL TIMESTAMP(0) DEFAULT NULL NULL, ACTIVITE_ID NUMBER(10) DEFAULT NULL NULL, DATE_DEBUT_ESTIMEE DATE NOT NULL, DATE_FIN_ESTIMEE DATE NOT NULL, PRIMARY KEY(ID))');
        $this->addSql('CREATE INDEX idx_938720759b0f88b1 ON TACHE (ACTIVITE_ID)');
        $this->addSql('CREATE INDEX idx_93872075f6203804 ON TACHE (STATUT_ID)');
        $this->addSql('COMMENT ON COLUMN TACHE.DATE_DEBUT_REEL IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN TACHE.DATE_FIN_REEL IS \'(DC2Type:datetime_immutable)\'');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE UTILISATEUR_ACTIVITE (UTILISATEUR_ID NUMBER(10) NOT NULL, ACTIVITE_ID NUMBER(10) NOT NULL, PRIMARY KEY(UTILISATEUR_ID, ACTIVITE_ID))');
        $this->addSql('CREATE INDEX idx_a60eac8a9b0f88b1 ON UTILISATEUR_ACTIVITE (ACTIVITE_ID)');
        $this->addSql('CREATE INDEX idx_a60eac8afb88e14f ON UTILISATEUR_ACTIVITE (UTILISATEUR_ID)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE CANAL_DEMANDE (ID NUMBER(10) NOT NULL, NOM VARCHAR2(255) NOT NULL, DESCRIPTION CLOB NOT NULL, IS_ACTIVE NUMBER(1) NOT NULL, PRIMARY KEY(ID))');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE STATUT (ID NUMBER(10) NOT NULL, NOM VARCHAR2(255) NOT NULL, DESCRIPTION CLOB NOT NULL, IS_ACTIVE NUMBER(1) NOT NULL, PRIMARY KEY(ID))');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE UTILISATEUR_PROJET (UTILISATEUR_ID NUMBER(10) NOT NULL, PROJET_ID NUMBER(10) NOT NULL, PRIMARY KEY(UTILISATEUR_ID, PROJET_ID))');
        $this->addSql('CREATE INDEX idx_31b8a622c18272 ON UTILISATEUR_PROJET (PROJET_ID)');
        $this->addSql('CREATE INDEX idx_31b8a622fb88e14f ON UTILISATEUR_PROJET (UTILISATEUR_ID)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE DEMANDE (ID NUMBER(10) NOT NULL, SOURCE_ID NUMBER(10) NOT NULL, TYPE_ID NUMBER(10) NOT NULL, CANAL_ID NUMBER(10) NOT NULL, STATUT_ID NUMBER(10) NOT NULL, TITRE VARCHAR2(255) NOT NULL, DESCRIPTION CLOB NOT NULL, DATE_CREATION TIMESTAMP(0) NOT NULL, PRIMARY KEY(ID))');
        $this->addSql('CREATE INDEX idx_2694d7a568db5b2e ON DEMANDE (CANAL_ID)');
        $this->addSql('CREATE INDEX idx_2694d7a5953c1c61 ON DEMANDE (SOURCE_ID)');
        $this->addSql('CREATE INDEX idx_2694d7a5c54c8c93 ON DEMANDE (TYPE_ID)');
        $this->addSql('CREATE INDEX idx_2694d7a5f6203804 ON DEMANDE (STATUT_ID)');
        $this->addSql('COMMENT ON COLUMN DEMANDE.DATE_CREATION IS \'(DC2Type:datetime_immutable)\'');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE SOURCE_DEMANDE (ID NUMBER(10) NOT NULL, NOM VARCHAR2(255) NOT NULL, DESCRIPTION CLOB DEFAULT NULL NULL, PRIMARY KEY(ID))');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('CREATE TABLE HISTORIQUE (ID NUMBER(10) NOT NULL, UTILISATEUR_ID NUMBER(10) NOT NULL, DATE_HISTORIQUE DATE NOT NULL, DETAILS_HISTORIQUE VARCHAR2(1000) DEFAULT NULL NULL, TYPE_ELEMENT VARCHAR2(255) NOT NULL, ID_ELEMENT NUMBER(10) NOT NULL, PRIMARY KEY(ID))');
        $this->addSql('CREATE INDEX idx_edbfd5ecfb88e14f ON HISTORIQUE (UTILISATEUR_ID)');
        $this->addSql('CREATE INDEX idx_historique_date ON HISTORIQUE (DATE_HISTORIQUE)');
        $this->addSql('CREATE INDEX idx_historique_type ON HISTORIQUE (TYPE_ELEMENT, ID_ELEMENT)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE ASSISTANCE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE UTILISATEUR');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE GROUPE_UTILISATEUR');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE UTILISATEUR_GROUPE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE MESSENGER_MESSAGES');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE GROUPE_PERMISSION');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE TYPE_DEMANDE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE PERMISSION');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE GROUPE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE ACTIVITE_UTILISATEUR');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE PROJET');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE UTILISATEUR_TACHE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE PROJET_UTILISATEUR');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE TACHE_UTILISATEUR');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE ACTIVITE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE TACHE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE UTILISATEUR_ACTIVITE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE CANAL_DEMANDE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE STATUT');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE UTILISATEUR_PROJET');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE DEMANDE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE SOURCE_DEMANDE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\OraclePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\OraclePlatform'."
        );

        $this->addSql('DROP TABLE HISTORIQUE');
    }
}
