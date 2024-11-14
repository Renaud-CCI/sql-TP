CREATE PROCEDURE create_ad(
    IN p_name VARCHAR(255) COLLATE utf8mb4_unicode_ci,
    IN p_first_name VARCHAR(255) COLLATE utf8mb4_unicode_ci,
    IN p_email VARCHAR(255) COLLATE utf8mb4_unicode_ci,
    IN p_password VARCHAR(255) COLLATE utf8mb4_unicode_ci,
    IN p_country VARCHAR(255) COLLATE utf8mb4_unicode_ci,
    IN p_zip_code VARCHAR(255) COLLATE utf8mb4_unicode_ci,
    IN p_is_draft TINYINT,
    IN p_accept_share_contact_infos TINYINT,
    IN p_title VARCHAR(255) COLLATE utf8mb4_unicode_ci,
    IN p_about_content VARCHAR(1000) COLLATE utf8mb4_unicode_ci,
    IN p_about_project_content VARCHAR(1000) COLLATE utf8mb4_unicode_ci,
    IN p_is_bio TINYINT,
    IN p_experience_farming TEXT COLLATE utf8mb4_unicode_ci,
    IN p_surface_range_min INT,
    IN p_surface_range_max INT,
    IN p_document_name VARCHAR(255) COLLATE utf8mb4_unicode_ci,
    IN p_document_path VARCHAR(255) COLLATE utf8mb4_unicode_ci,
    IN p_document_type VARCHAR(255) COLLATE utf8mb4_unicode_ci,
    IN p_document_size INT,
    IN p_production_types TEXT COLLATE utf8mb4_unicode_ci
)
BEGIN
    DECLARE v_user_id INT;
    DECLARE v_ad_id INT;
    DECLARE v_document_id INT;
    DECLARE v_country_id INT;
    DECLARE v_zip_code_id INT;

    -- Obtenir les IDs pour le pays et le code postal
    SELECT id INTO v_country_id FROM countries WHERE name_fr_fr = p_country COLLATE utf8mb4_unicode_ci LIMIT 1;
    SELECT id INTO v_zip_code_id FROM cities WHERE zip_code = p_zip_code COLLATE utf8mb4_unicode_ci LIMIT 1;

    -- Insérer un utilisateur
    INSERT INTO users (name, first_name, email, password, country_id, zip_code_id, created_at, updated_at)
    VALUES (p_name, p_first_name, p_email, p_password, v_country_id, v_zip_code_id, NOW(), NOW());
    SET v_user_id = LAST_INSERT_ID();

    -- Insérer une annonce
    INSERT INTO ads (user_admin_id, user_pp_id, is_draft, accept_share_contact_infos, title, about_content, about_project_content, created_at, updated_at)
    VALUES (v_user_id, v_user_id, p_is_draft, p_accept_share_contact_infos, p_title, p_about_content, p_about_project_content, NOW(), NOW());
    SET v_ad_id = LAST_INSERT_ID();

    -- Insérer les détails de la recherche de foncier
    INSERT INTO land_seek_ads (ad_id, is_bio, experience_farming, surface_range_min, surface_range_max, created_at, updated_at)
    VALUES (v_ad_id, p_is_bio, p_experience_farming, p_surface_range_min, p_surface_range_max, NOW(), NOW());

    -- Insérer le document
    INSERT INTO documents (name, path, type, size, user_id, created_at, updated_at)
    VALUES (p_document_name, p_document_path, p_document_type, p_document_size, v_user_id, NOW(), NOW());
    SET v_document_id = LAST_INSERT_ID();

    -- Insérer dans la table documentables
    INSERT INTO documentables (document_id, documentable_id, documentable_type, created_at, updated_at)
    VALUES (v_document_id, v_ad_id, 'ads', NOW(), NOW());

    -- Insérer les types de productions
    IF p_production_types IS NOT NULL AND p_production_types != '' THEN
        SET @sql = CONCAT('INSERT INTO productionable_genres (production_genre_id, productionable_genre_id, productionable_genre_type, created_at, updated_at) ',
                          'SELECT id, ', v_ad_id, ', "land_seek_ads", NOW(), NOW() FROM production_genres WHERE FIND_IN_SET(name, "', p_production_types, '")');
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
    END IF;
END;