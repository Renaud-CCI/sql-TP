### Ads : (4 relations à trouver)
- Relation One-To-One entre ads et land_offer_ads sur ads.id = land_offer_ads.ad_id
- Relation One-to-Many entre ads et land_seek_ads sur ads.id = land_seek_ads.ad_id
- Relation Many-To-One entre ads et users sur ads.user_pp_id = users.id
- Relation One-To-Many entre ads et locationable_ads sur ads.id = locationable_ads.ad_id

### Cities : (2 relations à trouver)
- Relation One-To-Many entre cities et users sur cities.id = users.zip_code_id
- Relation Many-To-One entre cities et departments sur cities.department_code = departments.code

### Regions : (1 relation à trouver)
- Relation One-To-Many entre regions et departments sur regions.code = departments.region_code

### Departments : (2 relations à trouver)
- Relation Many-To-One entre departments et regions sur departments.region_code = regions.code
- Relation One-To-Many entre departments et cities sur departments.code = cities.department_code

### Countries : (1 relation à trouver)
- Relation One-To-Many entre countries et users sur countries.id = users.country_id

### Users : (4 relations à trouver)
- Relation One-To-Many entre users et documents sur users.id = documents.user_id
- Relation One-To-Many entre users et ads sur users.id = ads.user_pp_id
- Relation Many-To-One entre users et cities sur users.zip_code_id = cities.id
- Relation Many-To-One entre users et countries sur users.country_id = countries.id

### Documents : (1 relation à trouver)
- Relation Many-To-One entre documents et users sur documents.user_id = users.id
- Relation Many-To-One entre documents et documentables  sur documents.id = documentables

### Production_genres : (1 relation à trouver)
- Relation One-To-Many entre production_genres et productionable_genres sur production_genres.id = productionable_genres.production_genre_id
- Relation One-To-Many entre production_genres et production_genre sur production_genres.id = production_genres.parent_id

### Documentables : (??? relations à trouver 🙂)
- Relation One-To-Many entre documentables et documents
- Relation polymorphique