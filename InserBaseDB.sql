
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
(1, 'vie', 1),
(2, 'maitrise terre', 1),
(3, 'maitrise feu', 1),
(4, 'maitrise eau', 1),
(5, 'maitrise air', 1),
(6, 'dommage terre', 3),
(7, 'dommage feu', 3),
(8, 'dommage eau', 3),
(9, 'dommage air', 3),
(10, 'soin terre', 3),
(11, 'soin feu', 3),
(12, 'soin eau', 3),
(13, 'soin air', 3),
(14, 'resistance terre', 3),
(15, 'resistance feu', 3),
(16, 'resistance eau', 3),
(17, 'resistance air', 3),
(18, '%res. terre', 5),
(19, '%res. feu', 5),
(20, '%res. eau', 5),
(21, '%res. air', 5),
(22, 'esquive', 8),
(23, 'parade', 8),
(24, 'critique', 6),
(25, 'butin', 8),
(26, 'apprentissage', 8);

-- item_categories
insert into item_categories (`id`, `name`) values
(1, 'casque'),
(2, 'armur'),
(3, 'arme'),
(4, 'botte'),
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
(3, 'rare commun'),
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

-- mobs
insert into `stats` () values ();
insert into mobs (`id`, `name`, `level`, `xp_given`, `gold_given`, `stat_id`) values
(1, 'slime', 1, 100, 10, LAST_INSERT_ID());
insert into `stats` () values ();
insert into mobs (`id`, `name`, `level`, `xp_given`, `gold_given`, `stat_id`) values
(2, 'petit bois', 1, 100, 10, LAST_INSERT_ID());
insert into `stats` () values ();
insert into mobs (`id`, `name`, `level`, `xp_given`, `gold_given`, `stat_id`) values
(3, 'caillasse', 1, 100, 10, LAST_INSERT_ID());

-- loots
insert into loots (`mob_id`, `item_ref_id`, `rate`) values
(1, 1, 1.0),
(1, 2, 0.5),
(2, 3, 1.0),
(2, 4, 0.5),
(3, 5, 1.0),
(3, 6, 0.5);