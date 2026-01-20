
-- CharacterSpecies.
insert into character_species (`id`, `name`) values
(1, 'Mercenaire'),
(2, 'Tank'),
(3, 'Soigneur'); 

-- XpNeedPerLevel.
insert into xp_need_per_levels (`level`, `xp_need`) values
(1, 100),
(2, 500),
(3, 800),
(4, 1300),
(5, 2000),
(6, 2500),
(7, 3200),
(8, 4000),
(9, 4700);

-- stats type
insert into stat_types (`id`, `name`, `weight`) values
(1, 'attaque terre', 0),
(2, 'attaque feu', 0),
(3, 'attaque eau', 0),
(4, 'attaque air', 0),
(5, 'soigne terre', 0),
(6, 'soigne feu', 0),
(7, 'soigne eau', 0),
(8, 'soigne air', 0),
(9, 'attaque soi terre', 0),
(10, 'attaque soi feu', 0),
(11, 'attaque soi eau', 0),
(12, 'attaque soi air', 0),
(13, 'soigne soi terre', 0),
(14, 'soigne soi feu', 0),
(15, 'soigne soi eau', 0),
(16, 'soigne soi air', 0),
(17, 'vol terre', 0),
(18, 'vol feu', 0),
(19, 'vol eau', 0),
(20, 'vol air', 0),
(21, '%agro terre', 0),
(22, '%agro feu', 0),
(23, '%agro eau', 0),
(24, '%agro air', 0),

(25, 'vie', 1),
(26, 'maitrise terre', 1),
(27, 'maitrise feu', 1),
(28, 'maitrise eau', 1),
(29, 'maitrise air', 1),
(30, 'dommage terre', 3),
(31, 'dommage feu', 3),
(32, 'dommage eau', 3),
(33, 'dommage air', 3),
(34, 'soin terre', 3),
(35, 'soin feu', 3),
(36, 'soin eau', 3),
(37, 'soin air', 3),
(38, 'resistance terre', 3),
(39, 'resistance feu', 3),
(40, 'resistance eau', 3),
(41, 'resistance air', 3),
(42, '%res. terre', 5),
(43, '%res. feu', 5),
(44, '%res. eau', 5),
(45, '%res. air', 5),
(46, 'esquive', 8),
(47, 'parade', 8),
(48, 'critique', 6),
(49, 'butin', 8),
(50, 'apprentissage', 8),

(51, 'carac.', 1);

-- item_categories
insert into item_categories (`id`, `name`) values
(1, 'casque'),
(2, 'armur'),
(3, 'arme'),
(4, 'bijou'),
(5, 'ressource'),
(6, 'comestible'),
(7, 'bois'),
(8, 'planche'),
(9, 'mineré'),
(10, 'lingo'),
(11, 'pierre précieuse');

-- item_rarities
insert into item_rarities (`id`, `name`) values
(1, 'commun'),
(2, 'peu commun'),
(3, 'rare'),
(4, 'legendaire'),
(5, 'mythique');

-- item_ref
insert into item_refs (`id`, `name`, `price`, `level`, `item_categorie_id`, `item_rarity_id`) values
(1, 'mucus de slime', 1, 1, 5, 1),
(2, 'noyau de slime', 3, 1, 11, 2),
(3, 'branche de petit bois', 1, 1, 5, 1),
(4, 'bois petit', 3, 1, 7, 2),
(5, 'caillou', 1, 1, 5, 1),
(6, 'mineré de plomb', 3, 1, 9, 2);
(7, 'lingo de plomb', 5, 1, 10, 2);
(8, 'planche petit', 5, 1, 8, 2);

-- mobs
insert into `stats` () values ();
set @last_id = LAST_INSERT_ID();
insert into stats_type_values (`stat_id`, `value`, `stat_type_id`) values 
(@last_id, 8, (select id from stat_types where name = 'attaque eau')),
(@last_id, 80, (select id from stat_types where name = 'vie')),
(@last_id, 1, (select id from stat_types where name = 'resistance eau')),
(@last_id, 2, (select id from stat_types where name = 'critique')),
(@last_id, 8, (select id from stat_types where name = 'esquive'));
insert into mobs (`id`, `name`, `level`, `xp_given`, `gold_given`, `stat_id`) values
(1, 'slime', 1, 100, 10, @last_id);
insert into `stats` () values ();
set @last_id = LAST_INSERT_ID();
insert into stats_type_values (`stat_id`, `value`, `stat_type_id`) values 
(@last_id, 3, (select id from stat_types where name = 'attaque terre')),
(@last_id, 3, (select id from stat_types where name = 'vol vent')),
(@last_id, 100, (select id from stat_types where name = 'vie')),
(@last_id, 4, (select id from stat_types where name = 'critique')),
(@last_id, 4, (select id from stat_types where name = 'parade'));
insert into mobs (`id`, `name`, `level`, `xp_given`, `gold_given`, `stat_id`) values
(2, 'petit bois', 1, 100, 10, @last_id);
insert into `stats` () values ();
set @last_id = LAST_INSERT_ID();
insert into stats_type_values (`stat_id`, `value`, `stat_type_id`) values 
(@last_id, 6, (select id from stat_types where name = 'attaque terre')),
(@last_id, 50, (select id from stat_types where name = 'vie')),
(@last_id, 1, (select id from stat_types where name = 'resistance terre')),
(@last_id, 1, (select id from stat_types where name = 'resistance feu')),
(@last_id, 1, (select id from stat_types where name = 'resistance vent')),
(@last_id, 1, (select id from stat_types where name = 'critique')),
(@last_id, 8, (select id from stat_types where name = 'parade'));
insert into mobs (`id`, `name`, `level`, `xp_given`, `gold_given`, `stat_id`) values
(3, 'caillasse', 1, 100, 10, @last_id);

-- loots
insert into loots (`mob_id`, `item_ref_id`, `rate`) values
(1, 1, 1.0),
(1, 2, 0.5),
(2, 3, 1.0),
(2, 4, 0.5),
(3, 5, 1.0),
(3, 6, 0.5);

-- crafts / ingredients.
insert into crafts (`id`, `item_ref_id`, `quantity`, `rate`) values
(1, 7, 1, 1.0),
(2, 8, 1, 1.0);
insert into ingredients (`craft_id`, `item_ref_id`, `quantity`) values
(1, 4, 2),
(2, 6, 2);


-- add craft item and their stats.


