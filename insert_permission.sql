CREATE OR REPLACE PROCEDURE insert_permission(
    p_id IN NUMBER,
    p_nom IN VARCHAR2,
    p_description IN VARCHAR2,
    p_categorie IN VARCHAR2
)
IS
BEGIN
    INSERT INTO permission (id, nom, description, categorie)
    VALUES (p_id, p_nom, p_description, p_categorie);
    
    COMMIT;
EXCEPTION
    WHEN DUP_VAL_ON_INDEX THEN
        DBMS_OUTPUT.PUT_LINE('Duplicate ID: ' || p_id || '. Skipping insertion.');
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Error inserting permission: ' || SQLERRM);
        ROLLBACK;
END;
/

BEGIN
    insert_permission(1, 'Activite_creer_tous', 'Permission de créer des activités pour tous', 'Activite');
    insert_permission(2, 'Activite_voir_mien', 'Permission de voir ses propres activités', 'Activite');
    insert_permission(3, 'Activite_voir_tous', 'Permission de voir toutes les activités', 'Activite');
    insert_permission(4, 'Activite_modifier_mien', 'Permission de modifier ses propres activités', 'Activite');
    insert_permission(5, 'Activite_modifier_tous', 'Permission de modifier toutes les activités', 'Activite');
    insert_permission(6, 'Activite_supprimer_mien', 'Permission de supprimer ses propres activités', 'Activite');
    insert_permission(7, 'Activite_supprimer_tous', 'Permission de supprimer toutes les activités', 'Activite');
    insert_permission(8, 'Activite_acceder_mien', 'Permission d''accéder à ses propres activités', 'Activite');
    insert_permission(9, 'Activite_acceder_tous', 'Permission d''accéder à toutes les activités', 'Activite');
    insert_permission(10, 'Assistance_creer_tous', 'Permission de créer des assistances pour tous', 'Assistance');
    insert_permission(11, 'Assistance_voir_mien', 'Permission de voir ses propres assistances', 'Assistance');
    insert_permission(12, 'Assistance_voir_tous', 'Permission de voir toutes les assistances', 'Assistance');
    insert_permission(13, 'Assistance_modifier_mien', 'Permission de modifier ses propres assistances', 'Assistance');
    insert_permission(14, 'Assistance_modifier_tous', 'Permission de modifier toutes les assistances', 'Assistance');
    insert_permission(15, 'Assistance_supprimer_mien', 'Permission de supprimer ses propres assistances', 'Assistance');
    insert_permission(16, 'Assistance_supprimer_tous', 'Permission de supprimer toutes les assistances', 'Assistance');
    insert_permission(17, 'Assistance_acceder_mien', 'Permission d''accéder à ses propres assistances', 'Assistance');
    insert_permission(18, 'Assistance_acceder_tous', 'Permission d''accéder à toutes les assistances', 'Assistance');
    insert_permission(19, 'Projet_creer_tous', 'Permission de créer des projets pour tous', 'Projet');
    insert_permission(20, 'Projet_voir_mien', 'Permission de voir ses propres projets', 'Projet');
    insert_permission(21, 'Projet_voir_tous', 'Permission de voir tous les projets', 'Projet');
    insert_permission(22, 'Projet_modifier_mien', 'Permission de modifier ses propres projets', 'Projet');
    insert_permission(23, 'Projet_modifier_tous', 'Permission de modifier tous les projets', 'Projet');
    insert_permission(24, 'Projet_supprimer_mien', 'Permission de supprimer ses propres projets', 'Projet');
    insert_permission(25, 'Projet_supprimer_tous', 'Permission de supprimer tous les projets', 'Projet');
    insert_permission(26, 'Projet_acceder_mien', 'Permission d''accéder à ses propres projets', 'Projet');
    insert_permission(27, 'Projet_acceder_tous', 'Permission d''accéder à tous les projets', 'Projet');
    insert_permission(28, 'Demande_creer_tous', 'Permission de créer des demandes pour tous', 'Demande');
    insert_permission(29, 'Demande_voir_mien', 'Permission de voir ses propres demandes', 'Demande');
    insert_permission(30, 'Demande_voir_tous', 'Permission de voir toutes les demandes', 'Demande');
    insert_permission(31, 'Demande_modifier_mien', 'Permission de modifier ses propres demandes', 'Demande');
    insert_permission(32, 'Demande_modifier_tous', 'Permission de modifier toutes les demandes', 'Demande');
    insert_permission(33, 'Demande_supprimer_mien', 'Permission de supprimer ses propres demandes', 'Demande');
    insert_permission(34, 'Demande_supprimer_tous', 'Permission de supprimer toutes les demandes', 'Demande');
    insert_permission(35, 'Demande_acceder_mien', 'Permission d''accéder à ses propres demandes', 'Demande');
    insert_permission(36, 'Demande_acceder_tous', 'Permission d''accéder à toutes les demandes', 'Demande');
    insert_permission(37, 'Tache_creer_tous', 'Permission de créer des tâches pour tous', 'Tache');
    insert_permission(38, 'Tache_voir_mien', 'Permission de voir ses propres tâches', 'Tache');
    insert_permission(39, 'Tache_voir_tous', 'Permission de voir toutes les tâches', 'Tache');
    insert_permission(40, 'Tache_modifier_mien', 'Permission de modifier ses propres tâches', 'Tache');
    insert_permission(41, 'Tache_modifier_tous', 'Permission de modifier toutes les tâches', 'Tache');
    insert_permission(42, 'Tache_supprimer_mien', 'Permission de supprimer ses propres tâches', 'Tache');
    insert_permission(43, 'Tache_supprimer_tous', 'Permission de supprimer toutes les tâches', 'Tache');
    insert_permission(44, 'Tache_acceder_mien', 'Permission d''accéder à ses propres tâches', 'Tache');
    insert_permission(45, 'Tache_acceder_tous', 'Permission d''accéder à toutes les tâches', 'Tache');
    insert_permission(46, 'Referentiel_creer_tous', 'Permission de créer des référentiels pour tous', 'Referentiel');
    insert_permission(47, 'Referentiel_voir_mien', 'Permission de voir ses propres référentiels', 'Referentiel');
    insert_permission(48, 'Referentiel_voir_tous', 'Permission de voir tous les référentiels', 'Referentiel');
    insert_permission(49, 'Referentiel_modifier_mien', 'Permission de modifier ses propres référentiels', 'Referentiel');
    insert_permission(50, 'Referentiel_modifier_tous', 'Permission de modifier tous les référentiels', 'Referentiel');
    insert_permission(51, 'Referentiel_supprimer_mien', 'Permission de supprimer ses propres référentiels', 'Referentiel');
    insert_permission(52, 'Referentiel_supprimer_tous', 'Permission de supprimer tous les référentiels', 'Referentiel');
    insert_permission(53, 'Referentiel_acceder_mien', 'Permission d''accéder à ses propres référentiels', 'Referentiel');
    insert_permission(54, 'Referentiel_acceder_tous', 'Permission d''accéder à tous les référentiels', 'Referentiel');
END;
/