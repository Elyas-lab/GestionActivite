--
-- Create Schema Script 
--   Database Version          : 11.2.0.2.0 
--   Database Compatible Level : 11.2.0.2.0 
--   Script Compatible Level   : 11.2.0.2.0 
--   Toad Version              : 12.1.0.22 
--   DB Connect String         : XE 
--   Schema                    : GESTIONADMIN 
--   Script Created by         : GESTIONADMIN 
--   Script Created at         : 04/03/2025 10:14:45 
--   Physical Location         :  
--   Notes                     :  
--

-- Object Counts: 
--   Functions: 2       Lines of Code: 55 
--   Indexes: 63        Columns: 73         
--   Procedures: 1      Lines of Code: 19 
--   Sequences: 14 
--   Tables: 23         Columns: 101        Constraints: 144    
--   Triggers: 1 

-- "Set define off" turns off substitution variables. 
Set define off; 

--
-- CANAL_DEMANDE  (Table) 
--
CREATE TABLE GESTIONADMIN.CANAL_DEMANDE
(
  ID           NUMBER(10)                       NOT NULL,
  NOM          VARCHAR2(255 BYTE)               NOT NULL,
  DESCRIPTION  CLOB                             NOT NULL,
  IS_ACTIVE    NUMBER(1)                        NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- GROUPE  (Table) 
--
CREATE TABLE GESTIONADMIN.GROUPE
(
  ID           NUMBER(10)                       NOT NULL,
  NOM          VARCHAR2(255 BYTE)               NOT NULL,
  DESCRIPTION  VARCHAR2(255 BYTE)               DEFAULT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- MESSENGER_MESSAGES  (Table) 
--
CREATE TABLE GESTIONADMIN.MESSENGER_MESSAGES
(
  ID            NUMBER(20)                      NOT NULL,
  BODY          CLOB                            NOT NULL,
  HEADERS       CLOB                            NOT NULL,
  QUEUE_NAME    VARCHAR2(190 BYTE)              NOT NULL,
  CREATED_AT    TIMESTAMP(0)                    DEFAULT CURRENT_TIMESTAMP     NOT NULL,
  AVAILABLE_AT  TIMESTAMP(0)                    NOT NULL,
  DELIVERED_AT  TIMESTAMP(0)                    DEFAULT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );

COMMENT ON COLUMN GESTIONADMIN.MESSENGER_MESSAGES.CREATED_AT IS '(DC2Type:datetime_immutable)';

COMMENT ON COLUMN GESTIONADMIN.MESSENGER_MESSAGES.AVAILABLE_AT IS '(DC2Type:datetime_immutable)';

COMMENT ON COLUMN GESTIONADMIN.MESSENGER_MESSAGES.DELIVERED_AT IS '(DC2Type:datetime_immutable)';



--
-- PERMISSION  (Table) 
--
CREATE TABLE GESTIONADMIN.PERMISSION
(
  ID           NUMBER(10)                       NOT NULL,
  NOM          VARCHAR2(255 BYTE)               NOT NULL,
  DESCRIPTION  CLOB                             NOT NULL,
  CATEGORIE    VARCHAR2(255 BYTE)               NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- SOURCE_DEMANDE  (Table) 
--
CREATE TABLE GESTIONADMIN.SOURCE_DEMANDE
(
  ID           NUMBER(10)                       NOT NULL,
  NOM          VARCHAR2(255 BYTE)               NOT NULL,
  DESCRIPTION  CLOB                             DEFAULT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- STATUT  (Table) 
--
CREATE TABLE GESTIONADMIN.STATUT
(
  ID           NUMBER(10)                       NOT NULL,
  NOM          VARCHAR2(255 BYTE)               NOT NULL,
  DESCRIPTION  CLOB                             NOT NULL,
  IS_ACTIVE    NUMBER(1)                        NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- TYPE_DEMANDE  (Table) 
--
CREATE TABLE GESTIONADMIN.TYPE_DEMANDE
(
  ID           NUMBER(10)                       NOT NULL,
  NOM          VARCHAR2(255 BYTE)               NOT NULL,
  DESCRIPTION  CLOB                             NOT NULL,
  IS_ACTIVE    NUMBER(1)                        NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- UTILISATEUR  (Table) 
--
CREATE TABLE GESTIONADMIN.UTILISATEUR
(
  ID         NUMBER(10)                         NOT NULL,
  MATRICULE  VARCHAR2(180 BYTE)                 NOT NULL,
  NOM        VARCHAR2(255 BYTE)                 NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- UTILISATEUR_GROUPE  (Table) 
--
CREATE TABLE GESTIONADMIN.UTILISATEUR_GROUPE
(
  UTILISATEUR_ID  NUMBER(10)                    NOT NULL,
  GROUPE_ID       NUMBER(10)                    NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- ACTIVITE_ID_SEQ  (Sequence) 
--
CREATE SEQUENCE GESTIONADMIN.ACTIVITE_ID_SEQ
  START WITH 21
  MAXVALUE 9999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  CACHE 20
  NOORDER;


--
-- ASSISTANCE_ID_SEQ  (Sequence) 
--
CREATE SEQUENCE GESTIONADMIN.ASSISTANCE_ID_SEQ
  START WITH 61
  MAXVALUE 9999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  CACHE 20
  NOORDER;


--
-- CANAL_DEMANDE_ID_SEQ  (Sequence) 
--
CREATE SEQUENCE GESTIONADMIN.CANAL_DEMANDE_ID_SEQ
  START WITH 21
  MAXVALUE 9999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  CACHE 20
  NOORDER;


--
-- DEMANDE_ID_SEQ  (Sequence) 
--
CREATE SEQUENCE GESTIONADMIN.DEMANDE_ID_SEQ
  START WITH 61
  MAXVALUE 9999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  CACHE 20
  NOORDER;


--
-- GROUPE_ID_SEQ  (Sequence) 
--
CREATE SEQUENCE GESTIONADMIN.GROUPE_ID_SEQ
  START WITH 41
  MAXVALUE 9999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  CACHE 20
  NOORDER;


--
-- HISTORIQUE_ID_SEQ  (Sequence) 
--
CREATE SEQUENCE GESTIONADMIN.HISTORIQUE_ID_SEQ
  START WITH 121
  MAXVALUE 9999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  CACHE 20
  NOORDER;


--
-- MESSENGER_MESSAGES_SEQ  (Sequence) 
--
CREATE SEQUENCE GESTIONADMIN.MESSENGER_MESSAGES_SEQ
  START WITH 1
  MAXVALUE 9999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  CACHE 20
  NOORDER;


--
-- PERMISSION_ID_SEQ  (Sequence) 
--
CREATE SEQUENCE GESTIONADMIN.PERMISSION_ID_SEQ
  START WITH 215
  MAXVALUE 9999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  CACHE 20
  NOORDER;


--
-- PROJET_ID_SEQ  (Sequence) 
--
CREATE SEQUENCE GESTIONADMIN.PROJET_ID_SEQ
  START WITH 41
  MAXVALUE 9999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  CACHE 20
  NOORDER;


--
-- SOURCE_DEMANDE_ID_SEQ  (Sequence) 
--
CREATE SEQUENCE GESTIONADMIN.SOURCE_DEMANDE_ID_SEQ
  START WITH 21
  MAXVALUE 9999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  CACHE 20
  NOORDER;


--
-- STATUT_ID_SEQ  (Sequence) 
--
CREATE SEQUENCE GESTIONADMIN.STATUT_ID_SEQ
  START WITH 41
  MAXVALUE 9999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  CACHE 20
  NOORDER;


--
-- TACHE_ID_SEQ  (Sequence) 
--
CREATE SEQUENCE GESTIONADMIN.TACHE_ID_SEQ
  START WITH 21
  MAXVALUE 9999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  CACHE 20
  NOORDER;


--
-- TYPE_DEMANDE_ID_SEQ  (Sequence) 
--
CREATE SEQUENCE GESTIONADMIN.TYPE_DEMANDE_ID_SEQ
  START WITH 21
  MAXVALUE 9999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  CACHE 20
  NOORDER;


--
-- UTILISATEUR_ID_SEQ  (Sequence) 
--
CREATE SEQUENCE GESTIONADMIN.UTILISATEUR_ID_SEQ
  START WITH 61
  MAXVALUE 9999999999999999999999999999
  MINVALUE 1
  NOCYCLE
  CACHE 20
  NOORDER;


--
-- IDX_6514B6AAFB88E14F  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_6514B6AAFB88E14F ON GESTIONADMIN.UTILISATEUR_GROUPE
(UTILISATEUR_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_6514B6AA7A45358C  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_6514B6AA7A45358C ON GESTIONADMIN.UTILISATEUR_GROUPE
(GROUPE_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_75EA56E0E3BD61CE  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_75EA56E0E3BD61CE ON GESTIONADMIN.MESSENGER_MESSAGES
(AVAILABLE_AT)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_75EA56E0FB7336F0  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_75EA56E0FB7336F0 ON GESTIONADMIN.MESSENGER_MESSAGES
(QUEUE_NAME)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_75EA56E016BA31DB  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_75EA56E016BA31DB ON GESTIONADMIN.MESSENGER_MESSAGES
(DELIVERED_AT)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- UNIQ_IDENTIFIER_MATRICULE  (Index) 
--
CREATE UNIQUE INDEX GESTIONADMIN.UNIQ_IDENTIFIER_MATRICULE ON GESTIONADMIN.UTILISATEUR
(MATRICULE)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- MESSENGER_MESSAGES_AI_PK  (Trigger) 
--
CREATE OR REPLACE TRIGGER GESTIONADMIN.MESSENGER_MESSAGES_AI_PK
   BEFORE INSERT ON GESTIONADMIN.MESSENGER_MESSAGES
   FOR EACH ROW
BEGIN
   IF :NEW.ID IS NULL OR :NEW.ID = 0 THEN
      SELECT MESSENGER_MESSAGES_SEQ.NEXTVAL INTO :NEW.ID FROM DUAL;
   END IF;
END;
/


--
-- ASSISTANCE  (Table) 
--
CREATE TABLE GESTIONADMIN.ASSISTANCE
(
  ID              NUMBER(10)                    NOT NULL,
  SOURCE_ID       NUMBER(10)                    NOT NULL,
  TYPE_ID         NUMBER(10)                    NOT NULL,
  CANAL_ID        NUMBER(10)                    NOT NULL,
  STATUT_ID       NUMBER(10)                    NOT NULL,
  RESPONSABLE_ID  NUMBER(10)                    NOT NULL,
  TITRE           VARCHAR2(255 BYTE)            NOT NULL,
  DESCRIPTION     CLOB                          NOT NULL,
  DATE_CREATION   DATE                          DEFAULT NULL                  NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );

COMMENT ON COLUMN GESTIONADMIN.ASSISTANCE.DATE_CREATION IS '(DC2Type:datetime_immutable)';



--
-- DEMANDE  (Table) 
--
CREATE TABLE GESTIONADMIN.DEMANDE
(
  ID             NUMBER(10)                     NOT NULL,
  SOURCE_ID      NUMBER(10)                     NOT NULL,
  TYPE_ID        NUMBER(10)                     NOT NULL,
  CANAL_ID       NUMBER(10)                     NOT NULL,
  STATUT_ID      NUMBER(10)                     NOT NULL,
  TITRE          VARCHAR2(255 BYTE)             NOT NULL,
  DESCRIPTION    CLOB                           NOT NULL,
  DATE_CREATION  DATE                           DEFAULT NULL                  NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );

COMMENT ON COLUMN GESTIONADMIN.DEMANDE.DATE_CREATION IS '(DC2Type:datetime_immutable)';



--
-- GROUPE_PERMISSION  (Table) 
--
CREATE TABLE GESTIONADMIN.GROUPE_PERMISSION
(
  GROUPE_ID      NUMBER(10)                     NOT NULL,
  PERMISSION_ID  NUMBER(10)                     NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- GROUPE_UTILISATEUR  (Table) 
--
CREATE TABLE GESTIONADMIN.GROUPE_UTILISATEUR
(
  GROUPE_ID       NUMBER(10)                    NOT NULL,
  UTILISATEUR_ID  NUMBER(10)                    NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- HISTORIQUE  (Table) 
--
CREATE TABLE GESTIONADMIN.HISTORIQUE
(
  ID                  NUMBER(10)                NOT NULL,
  UTILISATEUR_ID      NUMBER(10)                NOT NULL,
  DATE_HISTORIQUE     DATE                      DEFAULT NULL                  NOT NULL,
  DETAILS_HISTORIQUE  VARCHAR2(1000 BYTE)       DEFAULT NULL,
  TYPE_ELEMENT        VARCHAR2(255 BYTE)        NOT NULL,
  ID_ELEMENT          NUMBER(10)                NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- PROJET  (Table) 
--
CREATE TABLE GESTIONADMIN.PROJET
(
  ID                  NUMBER(10)                NOT NULL,
  STATUT_ID           NUMBER(10)                NOT NULL,
  TITRE               VARCHAR2(255 BYTE)        NOT NULL,
  DESCRIPTION         CLOB                      DEFAULT NULL,
  DATE_DEBUT_REEL     DATE                      DEFAULT NULL,
  DATE_FIN_REEL       DATE                      DEFAULT NULL,
  DEMANDE_SOURCE_ID   NUMBER(10)                NOT NULL,
  DATE_DEBUT_ESTIMEE  DATE                      DEFAULT NULL                  NOT NULL,
  DATE_FIN_ESTIMEE    DATE                      DEFAULT NULL                  NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );

COMMENT ON COLUMN GESTIONADMIN.PROJET.DATE_DEBUT_REEL IS '(DC2Type:datetime_immutable)';

COMMENT ON COLUMN GESTIONADMIN.PROJET.DATE_FIN_REEL IS '(DC2Type:datetime_immutable)';



--
-- PROJET_UTILISATEUR  (Table) 
--
CREATE TABLE GESTIONADMIN.PROJET_UTILISATEUR
(
  PROJET_ID       NUMBER(10)                    NOT NULL,
  UTILISATEUR_ID  NUMBER(10)                    NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- UTILISATEUR_PROJET  (Table) 
--
CREATE TABLE GESTIONADMIN.UTILISATEUR_PROJET
(
  UTILISATEUR_ID  NUMBER(10)                    NOT NULL,
  PROJET_ID       NUMBER(10)                    NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_C626378DC18272  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_C626378DC18272 ON GESTIONADMIN.PROJET_UTILISATEUR
(PROJET_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_C626378DFB88E14F  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_C626378DFB88E14F ON GESTIONADMIN.PROJET_UTILISATEUR
(UTILISATEUR_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_EDBFD5ECFB88E14F  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_EDBFD5ECFB88E14F ON GESTIONADMIN.HISTORIQUE
(UTILISATEUR_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_HISTORIQUE_DATE  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_HISTORIQUE_DATE ON GESTIONADMIN.HISTORIQUE
(DATE_HISTORIQUE)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_HISTORIQUE_TYPE  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_HISTORIQUE_TYPE ON GESTIONADMIN.HISTORIQUE
(TYPE_ELEMENT, ID_ELEMENT)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_1B4F85F2C54C8C93  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_1B4F85F2C54C8C93 ON GESTIONADMIN.ASSISTANCE
(TYPE_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_1B4F85F2F6203804  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_1B4F85F2F6203804 ON GESTIONADMIN.ASSISTANCE
(STATUT_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_1B4F85F253C59D72  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_1B4F85F253C59D72 ON GESTIONADMIN.ASSISTANCE
(RESPONSABLE_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_1B4F85F268DB5B2E  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_1B4F85F268DB5B2E ON GESTIONADMIN.ASSISTANCE
(CANAL_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_1B4F85F2953C1C61  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_1B4F85F2953C1C61 ON GESTIONADMIN.ASSISTANCE
(SOURCE_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_2694D7A5C54C8C93  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_2694D7A5C54C8C93 ON GESTIONADMIN.DEMANDE
(TYPE_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_2694D7A5F6203804  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_2694D7A5F6203804 ON GESTIONADMIN.DEMANDE
(STATUT_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_2694D7A568DB5B2E  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_2694D7A568DB5B2E ON GESTIONADMIN.DEMANDE
(CANAL_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_2694D7A5953C1C61  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_2694D7A5953C1C61 ON GESTIONADMIN.DEMANDE
(SOURCE_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_31B8A622C18272  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_31B8A622C18272 ON GESTIONADMIN.UTILISATEUR_PROJET
(PROJET_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_31B8A622FB88E14F  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_31B8A622FB88E14F ON GESTIONADMIN.UTILISATEUR_PROJET
(UTILISATEUR_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_50159CA9E010E6B4  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_50159CA9E010E6B4 ON GESTIONADMIN.PROJET
(DEMANDE_SOURCE_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_50159CA9F6203804  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_50159CA9F6203804 ON GESTIONADMIN.PROJET
(STATUT_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_58A4A376FED90CCA  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_58A4A376FED90CCA ON GESTIONADMIN.GROUPE_PERMISSION
(PERMISSION_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_58A4A3767A45358C  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_58A4A3767A45358C ON GESTIONADMIN.GROUPE_PERMISSION
(GROUPE_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_92C1107DFB88E14F  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_92C1107DFB88E14F ON GESTIONADMIN.GROUPE_UTILISATEUR
(UTILISATEUR_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_92C1107D7A45358C  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_92C1107D7A45358C ON GESTIONADMIN.GROUPE_UTILISATEUR
(GROUPE_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- CUSTOM_AUTH  (Function) 
--
CREATE OR REPLACE FUNCTION GESTIONADMIN.custom_auth (p_username in VARCHAR2, p_password in VARCHAR2)
return BOOLEAN
is
  l_password varchar2(4000);
  l_stored_password varchar2(4000);
  l_expires_on date;
  l_count number;
begin
-- First, check to see if the user is in the user table
select count(*) into l_count from demo_users where user_name = p_username;
if l_count > 0 then
  -- First, we fetch the stored hashed password & expire date
  select password, expires_on into l_stored_password, l_expires_on
   from demo_users where user_name = p_username;

  -- Next, we check to see if the user's account is expired
  -- If it is, return FALSE
  if l_expires_on > sysdate or l_expires_on is null then

    -- If the account is not expired, we have to apply the custom hash
    -- function to the password
    l_password := custom_hash(p_username, p_password);

    -- Finally, we compare them to see if they are the same and return
    -- either TRUE or FALSE
    if l_password = l_stored_password then
      return true;
    else
      return false;
    end if;
  else
    return false;
  end if;
else
  -- The username provided is not in the DEMO_USERS table
  return false;
end if;
end;
/

--
-- ACTIVITE  (Table) 
--
CREATE TABLE GESTIONADMIN.ACTIVITE
(
  ID                  NUMBER(10)                NOT NULL,
  STATUT_ID           NUMBER(10)                NOT NULL,
  TITRE               VARCHAR2(255 BYTE)        NOT NULL,
  DESCRIPTION         CLOB                      DEFAULT NULL,
  DATE_DEBUT_REEL     DATE                      DEFAULT NULL,
  DATE_FIN_REEL       DATE                      DEFAULT NULL,
  PROJET_SOURCE_ID    NUMBER(10)                NOT NULL,
  DATE_DEBUT_ESTIMEE  DATE                      DEFAULT NULL                  NOT NULL,
  DATE_FIN_ESTIMEE    DATE                      DEFAULT NULL                  NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );

COMMENT ON COLUMN GESTIONADMIN.ACTIVITE.DATE_DEBUT_REEL IS '(DC2Type:datetime_immutable)';

COMMENT ON COLUMN GESTIONADMIN.ACTIVITE.DATE_FIN_REEL IS '(DC2Type:datetime_immutable)';



--
-- ACTIVITE_UTILISATEUR  (Table) 
--
CREATE TABLE GESTIONADMIN.ACTIVITE_UTILISATEUR
(
  ACTIVITE_ID     NUMBER(10)                    NOT NULL,
  UTILISATEUR_ID  NUMBER(10)                    NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- TACHE  (Table) 
--
CREATE TABLE GESTIONADMIN.TACHE
(
  ID                  NUMBER(10)                NOT NULL,
  STATUT_ID           NUMBER(10)                NOT NULL,
  TITRE               VARCHAR2(255 BYTE)        NOT NULL,
  DESCRIPTION         CLOB                      DEFAULT NULL,
  DATE_DEBUT_REEL     DATE                      DEFAULT NULL,
  DATE_FIN_REEL       DATE                      DEFAULT NULL,
  ACTIVITE_ID         NUMBER(10)                DEFAULT NULL,
  DATE_DEBUT_ESTIMEE  DATE                      DEFAULT NULL                  NOT NULL,
  DATE_FIN_ESTIMEE    DATE                      DEFAULT NULL                  NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );

COMMENT ON COLUMN GESTIONADMIN.TACHE.DATE_DEBUT_REEL IS '(DC2Type:datetime_immutable)';

COMMENT ON COLUMN GESTIONADMIN.TACHE.DATE_FIN_REEL IS '(DC2Type:datetime_immutable)';



--
-- TACHE_UTILISATEUR  (Table) 
--
CREATE TABLE GESTIONADMIN.TACHE_UTILISATEUR
(
  TACHE_ID        NUMBER(10)                    NOT NULL,
  UTILISATEUR_ID  NUMBER(10)                    NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- UTILISATEUR_ACTIVITE  (Table) 
--
CREATE TABLE GESTIONADMIN.UTILISATEUR_ACTIVITE
(
  UTILISATEUR_ID  NUMBER(10)                    NOT NULL,
  ACTIVITE_ID     NUMBER(10)                    NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- UTILISATEUR_TACHE  (Table) 
--
CREATE TABLE GESTIONADMIN.UTILISATEUR_TACHE
(
  UTILISATEUR_ID  NUMBER(10)                    NOT NULL,
  TACHE_ID        NUMBER(10)                    NOT NULL
)
TABLESPACE USERS
RESULT_CACHE (MODE DEFAULT)
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_A60EAC8AFB88E14F  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_A60EAC8AFB88E14F ON GESTIONADMIN.UTILISATEUR_ACTIVITE
(UTILISATEUR_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_A60EAC8A9B0F88B1  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_A60EAC8A9B0F88B1 ON GESTIONADMIN.UTILISATEUR_ACTIVITE
(ACTIVITE_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_B8755515B6C2FBB5  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_B8755515B6C2FBB5 ON GESTIONADMIN.ACTIVITE
(PROJET_SOURCE_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_B8755515F6203804  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_B8755515F6203804 ON GESTIONADMIN.ACTIVITE
(STATUT_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_3D2F169EFB88E14F  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_3D2F169EFB88E14F ON GESTIONADMIN.ACTIVITE_UTILISATEUR
(UTILISATEUR_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_3D2F169E9B0F88B1  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_3D2F169E9B0F88B1 ON GESTIONADMIN.ACTIVITE_UTILISATEUR
(ACTIVITE_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_554278ABD2235D39  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_554278ABD2235D39 ON GESTIONADMIN.UTILISATEUR_TACHE
(TACHE_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_554278ABFB88E14F  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_554278ABFB88E14F ON GESTIONADMIN.UTILISATEUR_TACHE
(UTILISATEUR_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_8E15C4FDD2235D39  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_8E15C4FDD2235D39 ON GESTIONADMIN.TACHE_UTILISATEUR
(TACHE_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_8E15C4FDFB88E14F  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_8E15C4FDFB88E14F ON GESTIONADMIN.TACHE_UTILISATEUR
(UTILISATEUR_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_93872075F6203804  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_93872075F6203804 ON GESTIONADMIN.TACHE
(STATUT_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


--
-- IDX_938720759B0F88B1  (Index) 
--
CREATE INDEX GESTIONADMIN.IDX_938720759B0F88B1 ON GESTIONADMIN.TACHE
(ACTIVITE_ID)
TABLESPACE USERS
PCTFREE    10
INITRANS   2
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            NEXT             1M
            MAXSIZE          UNLIMITED
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
            FLASH_CACHE      DEFAULT
            CELL_FLASH_CACHE DEFAULT
           );


-- 
-- Non Foreign Key Constraints for Table CANAL_DEMANDE 
-- 
ALTER TABLE GESTIONADMIN.CANAL_DEMANDE ADD (
  PRIMARY KEY
  (ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table GROUPE 
-- 
ALTER TABLE GESTIONADMIN.GROUPE ADD (
  PRIMARY KEY
  (ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table MESSENGER_MESSAGES 
-- 
ALTER TABLE GESTIONADMIN.MESSENGER_MESSAGES ADD (
  PRIMARY KEY
  (ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table PERMISSION 
-- 
ALTER TABLE GESTIONADMIN.PERMISSION ADD (
  PRIMARY KEY
  (ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table SOURCE_DEMANDE 
-- 
ALTER TABLE GESTIONADMIN.SOURCE_DEMANDE ADD (
  PRIMARY KEY
  (ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table STATUT 
-- 
ALTER TABLE GESTIONADMIN.STATUT ADD (
  PRIMARY KEY
  (ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table TYPE_DEMANDE 
-- 
ALTER TABLE GESTIONADMIN.TYPE_DEMANDE ADD (
  PRIMARY KEY
  (ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table UTILISATEUR 
-- 
ALTER TABLE GESTIONADMIN.UTILISATEUR ADD (
  PRIMARY KEY
  (ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table UTILISATEUR_GROUPE 
-- 
ALTER TABLE GESTIONADMIN.UTILISATEUR_GROUPE ADD (
  PRIMARY KEY
  (UTILISATEUR_ID, GROUPE_ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table ASSISTANCE 
-- 
ALTER TABLE GESTIONADMIN.ASSISTANCE ADD (
  PRIMARY KEY
  (ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table DEMANDE 
-- 
ALTER TABLE GESTIONADMIN.DEMANDE ADD (
  PRIMARY KEY
  (ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table GROUPE_PERMISSION 
-- 
ALTER TABLE GESTIONADMIN.GROUPE_PERMISSION ADD (
  PRIMARY KEY
  (GROUPE_ID, PERMISSION_ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table GROUPE_UTILISATEUR 
-- 
ALTER TABLE GESTIONADMIN.GROUPE_UTILISATEUR ADD (
  PRIMARY KEY
  (GROUPE_ID, UTILISATEUR_ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table HISTORIQUE 
-- 
ALTER TABLE GESTIONADMIN.HISTORIQUE ADD (
  PRIMARY KEY
  (ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table PROJET 
-- 
ALTER TABLE GESTIONADMIN.PROJET ADD (
  PRIMARY KEY
  (ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table PROJET_UTILISATEUR 
-- 
ALTER TABLE GESTIONADMIN.PROJET_UTILISATEUR ADD (
  PRIMARY KEY
  (PROJET_ID, UTILISATEUR_ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table UTILISATEUR_PROJET 
-- 
ALTER TABLE GESTIONADMIN.UTILISATEUR_PROJET ADD (
  PRIMARY KEY
  (UTILISATEUR_ID, PROJET_ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table ACTIVITE 
-- 
ALTER TABLE GESTIONADMIN.ACTIVITE ADD (
  PRIMARY KEY
  (ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table ACTIVITE_UTILISATEUR 
-- 
ALTER TABLE GESTIONADMIN.ACTIVITE_UTILISATEUR ADD (
  PRIMARY KEY
  (ACTIVITE_ID, UTILISATEUR_ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table TACHE 
-- 
ALTER TABLE GESTIONADMIN.TACHE ADD (
  PRIMARY KEY
  (ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table TACHE_UTILISATEUR 
-- 
ALTER TABLE GESTIONADMIN.TACHE_UTILISATEUR ADD (
  PRIMARY KEY
  (TACHE_ID, UTILISATEUR_ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table UTILISATEUR_ACTIVITE 
-- 
ALTER TABLE GESTIONADMIN.UTILISATEUR_ACTIVITE ADD (
  PRIMARY KEY
  (UTILISATEUR_ID, ACTIVITE_ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Non Foreign Key Constraints for Table UTILISATEUR_TACHE 
-- 
ALTER TABLE GESTIONADMIN.UTILISATEUR_TACHE ADD (
  PRIMARY KEY
  (UTILISATEUR_ID, TACHE_ID)
  USING INDEX
    TABLESPACE USERS
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                NEXT             1M
                MAXSIZE          UNLIMITED
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
                FLASH_CACHE      DEFAULT
                CELL_FLASH_CACHE DEFAULT
               )
  ENABLE VALIDATE);


-- 
-- Foreign Key Constraints for Table UTILISATEUR_GROUPE 
-- 
ALTER TABLE GESTIONADMIN.UTILISATEUR_GROUPE ADD (
  CONSTRAINT FK_6514B6AAFB88E14F 
  FOREIGN KEY (UTILISATEUR_ID) 
  REFERENCES GESTIONADMIN.UTILISATEUR (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.UTILISATEUR_GROUPE ADD (
  CONSTRAINT FK_6514B6AA7A45358C 
  FOREIGN KEY (GROUPE_ID) 
  REFERENCES GESTIONADMIN.GROUPE (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);


-- 
-- Foreign Key Constraints for Table ASSISTANCE 
-- 
ALTER TABLE GESTIONADMIN.ASSISTANCE ADD (
  CONSTRAINT FK_1B4F85F2C54C8C93 
  FOREIGN KEY (TYPE_ID) 
  REFERENCES GESTIONADMIN.TYPE_DEMANDE (ID)
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.ASSISTANCE ADD (
  CONSTRAINT FK_1B4F85F2F6203804 
  FOREIGN KEY (STATUT_ID) 
  REFERENCES GESTIONADMIN.STATUT (ID)
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.ASSISTANCE ADD (
  CONSTRAINT FK_1B4F85F253C59D72 
  FOREIGN KEY (RESPONSABLE_ID) 
  REFERENCES GESTIONADMIN.UTILISATEUR (ID)
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.ASSISTANCE ADD (
  CONSTRAINT FK_1B4F85F268DB5B2E 
  FOREIGN KEY (CANAL_ID) 
  REFERENCES GESTIONADMIN.CANAL_DEMANDE (ID)
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.ASSISTANCE ADD (
  CONSTRAINT FK_1B4F85F2953C1C61 
  FOREIGN KEY (SOURCE_ID) 
  REFERENCES GESTIONADMIN.SOURCE_DEMANDE (ID)
  ENABLE VALIDATE);


-- 
-- Foreign Key Constraints for Table DEMANDE 
-- 
ALTER TABLE GESTIONADMIN.DEMANDE ADD (
  CONSTRAINT FK_2694D7A5C54C8C93 
  FOREIGN KEY (TYPE_ID) 
  REFERENCES GESTIONADMIN.TYPE_DEMANDE (ID)
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.DEMANDE ADD (
  CONSTRAINT FK_2694D7A5F6203804 
  FOREIGN KEY (STATUT_ID) 
  REFERENCES GESTIONADMIN.STATUT (ID)
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.DEMANDE ADD (
  CONSTRAINT FK_2694D7A568DB5B2E 
  FOREIGN KEY (CANAL_ID) 
  REFERENCES GESTIONADMIN.CANAL_DEMANDE (ID)
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.DEMANDE ADD (
  CONSTRAINT FK_2694D7A5953C1C61 
  FOREIGN KEY (SOURCE_ID) 
  REFERENCES GESTIONADMIN.SOURCE_DEMANDE (ID)
  ENABLE VALIDATE);


-- 
-- Foreign Key Constraints for Table GROUPE_PERMISSION 
-- 
ALTER TABLE GESTIONADMIN.GROUPE_PERMISSION ADD (
  CONSTRAINT FK_58A4A376FED90CCA 
  FOREIGN KEY (PERMISSION_ID) 
  REFERENCES GESTIONADMIN.PERMISSION (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.GROUPE_PERMISSION ADD (
  CONSTRAINT FK_58A4A3767A45358C 
  FOREIGN KEY (GROUPE_ID) 
  REFERENCES GESTIONADMIN.GROUPE (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);


-- 
-- Foreign Key Constraints for Table GROUPE_UTILISATEUR 
-- 
ALTER TABLE GESTIONADMIN.GROUPE_UTILISATEUR ADD (
  CONSTRAINT FK_92C1107DFB88E14F 
  FOREIGN KEY (UTILISATEUR_ID) 
  REFERENCES GESTIONADMIN.UTILISATEUR (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.GROUPE_UTILISATEUR ADD (
  CONSTRAINT FK_92C1107D7A45358C 
  FOREIGN KEY (GROUPE_ID) 
  REFERENCES GESTIONADMIN.GROUPE (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);


-- 
-- Foreign Key Constraints for Table HISTORIQUE 
-- 
ALTER TABLE GESTIONADMIN.HISTORIQUE ADD (
  CONSTRAINT FK_EDBFD5ECFB88E14F 
  FOREIGN KEY (UTILISATEUR_ID) 
  REFERENCES GESTIONADMIN.UTILISATEUR (ID)
  ENABLE VALIDATE);


-- 
-- Foreign Key Constraints for Table PROJET 
-- 
ALTER TABLE GESTIONADMIN.PROJET ADD (
  CONSTRAINT FK_50159CA9E010E6B4 
  FOREIGN KEY (DEMANDE_SOURCE_ID) 
  REFERENCES GESTIONADMIN.DEMANDE (ID)
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.PROJET ADD (
  CONSTRAINT FK_50159CA9F6203804 
  FOREIGN KEY (STATUT_ID) 
  REFERENCES GESTIONADMIN.STATUT (ID)
  ENABLE VALIDATE);


-- 
-- Foreign Key Constraints for Table PROJET_UTILISATEUR 
-- 
ALTER TABLE GESTIONADMIN.PROJET_UTILISATEUR ADD (
  CONSTRAINT FK_C626378DC18272 
  FOREIGN KEY (PROJET_ID) 
  REFERENCES GESTIONADMIN.PROJET (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.PROJET_UTILISATEUR ADD (
  CONSTRAINT FK_C626378DFB88E14F 
  FOREIGN KEY (UTILISATEUR_ID) 
  REFERENCES GESTIONADMIN.UTILISATEUR (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);


-- 
-- Foreign Key Constraints for Table UTILISATEUR_PROJET 
-- 
ALTER TABLE GESTIONADMIN.UTILISATEUR_PROJET ADD (
  CONSTRAINT FK_31B8A622C18272 
  FOREIGN KEY (PROJET_ID) 
  REFERENCES GESTIONADMIN.PROJET (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.UTILISATEUR_PROJET ADD (
  CONSTRAINT FK_31B8A622FB88E14F 
  FOREIGN KEY (UTILISATEUR_ID) 
  REFERENCES GESTIONADMIN.UTILISATEUR (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);


-- 
-- Foreign Key Constraints for Table ACTIVITE 
-- 
ALTER TABLE GESTIONADMIN.ACTIVITE ADD (
  CONSTRAINT FK_B8755515B6C2FBB5 
  FOREIGN KEY (PROJET_SOURCE_ID) 
  REFERENCES GESTIONADMIN.PROJET (ID)
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.ACTIVITE ADD (
  CONSTRAINT FK_B8755515F6203804 
  FOREIGN KEY (STATUT_ID) 
  REFERENCES GESTIONADMIN.STATUT (ID)
  ENABLE VALIDATE);


-- 
-- Foreign Key Constraints for Table ACTIVITE_UTILISATEUR 
-- 
ALTER TABLE GESTIONADMIN.ACTIVITE_UTILISATEUR ADD (
  CONSTRAINT FK_3D2F169EFB88E14F 
  FOREIGN KEY (UTILISATEUR_ID) 
  REFERENCES GESTIONADMIN.UTILISATEUR (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.ACTIVITE_UTILISATEUR ADD (
  CONSTRAINT FK_3D2F169E9B0F88B1 
  FOREIGN KEY (ACTIVITE_ID) 
  REFERENCES GESTIONADMIN.ACTIVITE (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);


-- 
-- Foreign Key Constraints for Table TACHE 
-- 
ALTER TABLE GESTIONADMIN.TACHE ADD (
  CONSTRAINT FK_93872075F6203804 
  FOREIGN KEY (STATUT_ID) 
  REFERENCES GESTIONADMIN.STATUT (ID)
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.TACHE ADD (
  CONSTRAINT FK_938720759B0F88B1 
  FOREIGN KEY (ACTIVITE_ID) 
  REFERENCES GESTIONADMIN.ACTIVITE (ID)
  ENABLE VALIDATE);


-- 
-- Foreign Key Constraints for Table TACHE_UTILISATEUR 
-- 
ALTER TABLE GESTIONADMIN.TACHE_UTILISATEUR ADD (
  CONSTRAINT FK_8E15C4FDD2235D39 
  FOREIGN KEY (TACHE_ID) 
  REFERENCES GESTIONADMIN.TACHE (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.TACHE_UTILISATEUR ADD (
  CONSTRAINT FK_8E15C4FDFB88E14F 
  FOREIGN KEY (UTILISATEUR_ID) 
  REFERENCES GESTIONADMIN.UTILISATEUR (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);


-- 
-- Foreign Key Constraints for Table UTILISATEUR_ACTIVITE 
-- 
ALTER TABLE GESTIONADMIN.UTILISATEUR_ACTIVITE ADD (
  CONSTRAINT FK_A60EAC8AFB88E14F 
  FOREIGN KEY (UTILISATEUR_ID) 
  REFERENCES GESTIONADMIN.UTILISATEUR (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.UTILISATEUR_ACTIVITE ADD (
  CONSTRAINT FK_A60EAC8A9B0F88B1 
  FOREIGN KEY (ACTIVITE_ID) 
  REFERENCES GESTIONADMIN.ACTIVITE (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);


-- 
-- Foreign Key Constraints for Table UTILISATEUR_TACHE 
-- 
ALTER TABLE GESTIONADMIN.UTILISATEUR_TACHE ADD (
  CONSTRAINT FK_554278ABD2235D39 
  FOREIGN KEY (TACHE_ID) 
  REFERENCES GESTIONADMIN.TACHE (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);

ALTER TABLE GESTIONADMIN.UTILISATEUR_TACHE ADD (
  CONSTRAINT FK_554278ABFB88E14F 
  FOREIGN KEY (UTILISATEUR_ID) 
  REFERENCES GESTIONADMIN.UTILISATEUR (ID)
  ON DELETE CASCADE
  ENABLE VALIDATE);