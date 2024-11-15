CREATE VIEW ads_land_seek_ads_view AS
SELECT
    ads.id AS ad_id,
    ads.user_admin_id,
    ads.user_pp_id,
    ads.is_draft,
    ads.accept_share_contact_infos,
    ads.title,
    ads.about_content,
    ads.about_project_content,
    ads.created_at AS ad_created_at,
    ads.updated_at AS ad_updated_at,
    land_seek_ads.is_bio,
    land_seek_ads.experience_farming,
    land_seek_ads.surface_range_min,
    land_seek_ads.surface_range_max,
    land_seek_ads.created_at AS land_seek_created_at,
    land_seek_ads.updated_at AS land_seek_updated_at
FROM
    ads
JOIN
    land_seek_ads ON ads.id = land_seek_ads.ad_id;