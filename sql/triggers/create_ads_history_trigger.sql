CREATE TRIGGER after_ads_insert
AFTER INSERT ON ads
FOR EACH ROW
BEGIN
    INSERT INTO ads_history (ad_id, user_admin_id, user_pp_id, is_draft, accept_share_contact_infos, title, about_content, about_project_content, created_at, updated_at)
    VALUES (NEW.id, NEW.user_admin_id, NEW.user_pp_id, NEW.is_draft, NEW.accept_share_contact_infos, NEW.title, NEW.about_content, NEW.about_project_content, NEW.created_at, NEW.updated_at);
END;

CREATE TRIGGER before_ads_update
BEFORE UPDATE ON ads
FOR EACH ROW
BEGIN
    INSERT INTO ads_history (ad_id, user_admin_id, user_pp_id, is_draft, accept_share_contact_infos, title, about_content, about_project_content, created_at, updated_at)
    VALUES (OLD.id, OLD.user_admin_id, OLD.user_pp_id, OLD.is_draft, OLD.accept_share_contact_infos, OLD.title, OLD.about_content, OLD.about_project_content, OLD.created_at, OLD.updated_at);
END;

CREATE TRIGGER before_ads_delete
BEFORE DELETE ON ads
FOR EACH ROW
BEGIN
    INSERT INTO ads_history (ad_id, user_admin_id, user_pp_id, is_draft, accept_share_contact_infos, title, about_content, about_project_content, created_at, updated_at)
    VALUES (OLD.id, OLD.user_admin_id, OLD.user_pp_id, OLD.is_draft, OLD.accept_share_contact_infos, OLD.title, OLD.about_content, OLD.about_project_content, OLD.created_at, OLD.updated_at);
END;