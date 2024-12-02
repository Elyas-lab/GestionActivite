-- Drop the sequence if it exists
BEGIN
   EXECUTE IMMEDIATE 'DROP SEQUENCE MESSENGER_MESSAGES_SEQ';
EXCEPTION
   WHEN OTHERS THEN
      IF SQLCODE != -2289 THEN -- Ignore "sequence does not exist" error
         RAISE;
      END IF;
END;
/

-- Create the sequence for the ID column
CREATE SEQUENCE MESSENGER_MESSAGES_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1;

-- Drop the table if it exists
BEGIN
   EXECUTE IMMEDIATE 'DROP TABLE MESSENGER_MESSAGES';
EXCEPTION
   WHEN OTHERS THEN
      IF SQLCODE != -942 THEN -- Ignore "table does not exist" error
         RAISE;
      END IF;
END;
/

-- Create the MESSENGER_MESSAGES table
CREATE TABLE MESSENGER_MESSAGES (
    id NUMBER(20) NOT NULL,
    body CLOB NOT NULL,
    headers CLOB NOT NULL,
    queue_name VARCHAR2(190) NOT NULL,
    created_at TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP NOT NULL,
    available_at TIMESTAMP(0) NOT NULL,
    delivered_at TIMESTAMP(0) DEFAULT NULL,
    PRIMARY KEY(id)
);

-- Create the trigger to automatically assign a sequence value to the ID column
CREATE OR REPLACE TRIGGER MESSENGER_MESSAGES_AI_PK
   BEFORE INSERT ON MESSENGER_MESSAGES
   FOR EACH ROW
BEGIN
   IF :NEW.ID IS NULL OR :NEW.ID = 0 THEN
      SELECT MESSENGER_MESSAGES_SEQ.NEXTVAL INTO :NEW.ID FROM DUAL;
   END IF;
END;
/

-- Create indexes
CREATE INDEX IDX_75EA56E0FB7336F0 ON MESSENGER_MESSAGES (queue_name);
CREATE INDEX IDX_75EA56E0E3BD61CE ON MESSENGER_MESSAGES (available_at);
CREATE INDEX IDX_75EA56E016BA31DB ON MESSENGER_MESSAGES (delivered_at);

-- Add comments for columns (outside of any PL/SQL block)
COMMENT ON COLUMN MESSENGER_MESSAGES.created_at IS '(DC2Type:datetime_immutable)';
COMMENT ON COLUMN MESSENGER_MESSAGES.available_at IS '(DC2Type:datetime_immutable)';
COMMENT ON COLUMN MESSENGER_MESSAGES.delivered_at IS '(DC2Type:datetime_immutable)';
