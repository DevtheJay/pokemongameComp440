-- Create database
create database if not exists game;
use game;

-- Table: location_type
create table if not exists location_type(
    type_id int primary key auto_increment,
    type_name varchar(50) unique
);

-- Table: building_type
create table if not exists building_type(
    building_id int primary key auto_increment,
    building_name varchar(50) unique
);

-- Table: location
create table if not exists location(
    location_id int primary key auto_increment,
    location_name varchar(50),
    type_id int,
    building_id int,
    foreign key(type_id) references location_type(type_id),
    foreign key(building_id) references building_type(building_id)
);

-- Table: pokedex
create table if not exists pokedex(
    pokemon_id int primary key auto_increment,
    pokemon_name varchar(50),
    pokemon_type_1 varchar(20) not null,
    pokemon_type_2 varchar(20) default null,
    evolution_lvl int
);

-- Table: users
create table if not exists users(
    user_id int primary key auto_increment,
    nickname varchar(50),
    gender varchar(10),
    location_id int,
    foreign key(location_id) references location(location_id)
);

-- Table: items
create table if not exists items(
    item_id int primary key auto_increment,
    item_name varchar(50),
    item_description varchar(100),
    location_id int,
    foreign key(location_id) references location(location_id)
);

-- Table: moves
create table if not exists moves(
    move_id int primary key auto_increment,
    move_name varchar(50) unique,
    move_damage varchar(100),
    move_accuracy varchar(50),
    move_type varchar(50)
);

-- Table: NPCS
create table if not exists NPCS(
    npc_id int primary key auto_increment,
    npc_name varchar(50),
    location_id int,
    occupation varchar(100),
    foreign key(location_id) references location(location_id)
);

-- Table: gym
create table if not exists gym(
    gym_id int primary key auto_increment,
    gym_name varchar(50),
    npc_id int,
    location_id int,
    foreign key(location_id) references location(location_id),
    foreign key(npc_id) references NPCS(npc_id)
);

-- Table: battle
create table if not exists battle(
    battle_id int primary key auto_increment,
    participant_1 varchar(50),
    participant_2 varchar(50),
    outcome varchar(50)
);

-- Table: user_inventory
create table if not exists user_inventory(
    item_id int,
    user_id int,
    quantity int check (quantity <= 10),
    primary key (item_id, user_id),
    foreign key(item_id) references items(item_id),
    foreign key(user_id) references users(user_id)
);

-- Table: npc_inventory
create table if not exists npc_inventory(
    item_id int,
    quantity int check (quantity <= 10),
    npc_id int,
    primary key (item_id, npc_id),
    foreign key(item_id) references items(item_id),
    foreign key(npc_id) references NPCS(npc_id)
);

-- Table: npc_pokemon_inventory
create table if not exists npc_pokemon_inventory(
    entity_id int auto_increment,
    npc_id int, 
    pokemon_id int,
    pokemon_nickname varchar(12),
    pokemon_gender varchar(10) check (pokemon_gender in ('male', 'female', 'Male', 'Female')),
    pokemon_health int,
    pokemon_lvl int check (pokemon_lvl between 1 and 100),
    pokemon_status varchar(20),
    pokemon_moves_1 int,
    pokemon_moves_2 int,
    pokemon_moves_3 int,
    pokemon_moves_4 int,
    primary key (entity_id, npc_id),
    foreign key(pokemon_id) references pokedex(pokemon_id),
    foreign key(npc_id) references NPCS(npc_id),
    foreign key(pokemon_moves_1) references moves(move_id),
    foreign key(pokemon_moves_2) references moves(move_id),
    foreign key(pokemon_moves_3) references moves(move_id),
    foreign key(pokemon_moves_4) references moves(move_id)
);

-- Table: user_pokemon_inventory
create table if not exists user_pokemon_inventory(
    entity_id int auto_increment,
    user_id int, 
    pokemon_id int,
    pokemon_nickname varchar(12),
    pokemon_gender varchar(10) check (pokemon_gender in ('male', 'female', 'Male', 'Female')),
    pokemon_health int,
    pokemon_lvl int check (pokemon_lvl between 1 and 100),
    pokemon_status varchar(20),
    pokemon_moves_1 int,
    pokemon_moves_2 int,
    pokemon_moves_3 int,
    pokemon_moves_4 int,
    primary key (entity_id, user_id),
    foreign key(pokemon_id) references pokedex(pokemon_id),
    foreign key(user_id) references users(user_id),
    foreign key(pokemon_moves_1) references moves(move_id),
    foreign key(pokemon_moves_2) references moves(move_id),
    foreign key(pokemon_moves_3) references moves(move_id),
    foreign key(pokemon_moves_4) references moves(move_id)
);


-- INSERTS

INSERT INTO location_type (type_name) VALUES
('Town'),
('City'),
('Route'),
('Cave'),
('Gym'),
('Elite Four Room'),
('Other');

INSERT INTO building_type (building_name) VALUES
('Pokémon Center'),
('Poké Mart'),
('Gym'),
('House'),
('Lab'),
('Cave Entrance'),
('League Room'),
('Other');

INSERT INTO location (location_name, type_id, building_id) VALUES
('Pallet Town', 1, 4),       -- A small town with houses
('Viridian City', 2, 1),     -- Pokémon Center
('Pewter City', 2, 3),       -- Gym
('Cerulean City', 2, 3),     -- Gym
('Vermilion City', 2, 3),    -- Gym
('Lavender Town', 1, 1),     -- Pokémon Center
('Celadon City', 2, 2),      -- Poké Mart
('Fuchsia City', 2, 3),      -- Gym
('Saffron City', 2, 3),      -- Gym
('Cinnabar Island', 2, 3),   -- Gym
('Indigo Plateau', 2, 7);    -- League Room

INSERT INTO users (nickname, gender, location_id) VALUES
('Ash', 'Male', 1);       -- Starting trainer, Pallet Town

INSERT INTO NPCS (npc_name, location_id, occupation) VALUES
('Brock', 3, 'Gym Leader'),         -- Pewter City Gym Leader
('Misty', 4, 'Gym Leader'),         -- Cerulean City Gym Leader
('Lt. Surge', 5, 'Gym Leader'),     -- Vermilion City Gym Leader
('Erika', 7, 'Gym Leader'),         -- Celadon City Gym Leader
('Koga', 8, 'Gym Leader'),          -- Fuchsia City Gym Leader
('Sabrina', 9, 'Gym Leader'),       -- Saffron City Gym Leader
('Blaine', 10, 'Gym Leader'),       -- Cinnabar Island Gym Leader
('Giovanni', 2, 'Gym Leader');      -- Viridian City Gym Leader

INSERT INTO gym (gym_name, npc_id, location_id) VALUES
('Pewter City Gym', 1, 3),       -- Brock's Gym in Pewter City
('Cerulean City Gym', 2, 4),     -- Misty's Gym in Cerulean City
('Vermilion City Gym', 3, 5),    -- Lt. Surge's Gym in Vermilion City
('Celadon City Gym', 4, 7),      -- Erika's Gym in Celadon City
('Fuchsia City Gym', 5, 8),      -- Koga's Gym in Fuchsia City
('Saffron City Gym', 6, 9),      -- Sabrina's Gym in Saffron City
('Cinnabar Island Gym', 7, 10),  -- Blaine's Gym on Cinnabar Island
('Viridian City Gym', 8, 2);     -- Giovanni's Gym in Viridian City


INSERT INTO pokedex (pokemon_name, pokemon_type_1, pokemon_type_2, evolution_lvl)
VALUES
('Bulbasaur', 'Grass', 'Poison', 16),
('Ivysaur', 'Grass', 'Poison', 32),
('Venusaur', 'Grass', 'Poison', NULL),
('Charmander', 'Fire', NULL, 16),
('Charmeleon', 'Fire', NULL, 36),
('Charizard', 'Fire', 'Flying', NULL),
('Squirtle', 'Water', NULL, 16),
('Wartortle', 'Water', NULL, 36),
('Blastoise', 'Water', NULL, NULL),
('Caterpie', 'Bug', NULL, 7),
('Metapod', 'Bug', NULL, 10),
('Butterfree', 'Bug', 'Flying', NULL),
('Weedle', 'Bug', 'Poison', 7),
('Kakuna', 'Bug', 'Poison', 10),
('Beedrill', 'Bug', 'Poison', NULL),
('Pidgey', 'Normal', 'Flying', 18),
('Pidgeotto', 'Normal', 'Flying', 36),
('Pidgeot', 'Normal', 'Flying', NULL),
('Rattata', 'Normal', NULL, 20),
('Raticate', 'Normal', NULL, NULL),
('Spearow', 'Normal', 'Flying', 20),
('Fearow', 'Normal', 'Flying', NULL),
('Ekans', 'Poison', NULL, 22),
('Arbok', 'Poison', NULL, NULL),
('Pikachu', 'Electric', NULL, NULL), -- Evolves with Thunder Stone
('Raichu', 'Electric', NULL, NULL),
('Sandshrew', 'Ground', NULL, 22),
('Sandslash', 'Ground', NULL, NULL),
('Nidoran♀', 'Poison', NULL, 16),
('Nidorina', 'Poison', NULL, NULL), -- Evolves with Moon Stone
('Nidoqueen', 'Poison', 'Ground', NULL),
('Nidoran♂', 'Poison', NULL, 16),
('Nidorino', 'Poison', NULL, NULL), -- Evolves with Moon Stone
('Nidoking', 'Poison', 'Ground', NULL),
('Clefairy', 'Fairy', NULL, NULL), -- Evolves with Moon Stone
('Clefable', 'Fairy', NULL, NULL),
('Vulpix', 'Fire', NULL, NULL), -- Evolves with Fire Stone
('Ninetales', 'Fire', NULL, NULL),
('Jigglypuff', 'Normal', 'Fairy', NULL), -- Evolves with Moon Stone
('Wigglytuff', 'Normal', 'Fairy', NULL),
('Zubat', 'Poison', 'Flying', 22),
('Golbat', 'Poison', 'Flying', NULL),
('Oddish', 'Grass', 'Poison', 21),
('Gloom', 'Grass', 'Poison', NULL), -- Evolves with Leaf Stone
('Vileplume', 'Grass', 'Poison', NULL),
('Paras', 'Bug', 'Grass', 24),
('Parasect', 'Bug', 'Grass', NULL),
('Venonat', 'Bug', 'Poison', 31),
('Venomoth', 'Bug', 'Poison', NULL),
('Diglett', 'Ground', NULL, 26),
('Dugtrio', 'Ground', NULL, NULL),
('Meowth', 'Normal', NULL, 28),
('Persian', 'Normal', NULL, NULL),
('Psyduck', 'Water', NULL, 33),
('Golduck', 'Water', NULL, NULL),
('Mankey', 'Fighting', NULL, 28),
('Primeape', 'Fighting', NULL, NULL),
('Growlithe', 'Fire', NULL, NULL), -- Evolves with Fire Stone
('Arcanine', 'Fire', NULL, NULL),
('Poliwag', 'Water', NULL, 25),
('Poliwhirl', 'Water', NULL, NULL), -- Evolves with Water Stone
('Poliwrath', 'Water', 'Fighting', NULL),
('Abra', 'Psychic', NULL, 16),
('Kadabra', 'Psychic', NULL, NULL), -- Evolves via Trade
('Alakazam', 'Psychic', NULL, NULL),
('Machop', 'Fighting', NULL, 28),
('Machoke', 'Fighting', NULL, NULL), -- Evolves via Trade
('Machamp', 'Fighting', NULL, NULL),
('Bellsprout', 'Grass', 'Poison', 21),
('Weepinbell', 'Grass', 'Poison', NULL), -- Evolves with Leaf Stone
('Victreebel', 'Grass', 'Poison', NULL),
('Tentacool', 'Water', 'Poison', 30),
('Tentacruel', 'Water', 'Poison', NULL),
('Geodude', 'Rock', 'Ground', 25),
('Graveler', 'Rock', 'Ground', NULL), -- Evolves via Trade
('Golem', 'Rock', 'Ground', NULL),
('Ponyta', 'Fire', NULL, 40),
('Rapidash', 'Fire', NULL, NULL),
('Slowpoke', 'Water', 'Psychic', 37),
('Slowbro', 'Water', 'Psychic', NULL),
('Magnemite', 'Electric', 'Steel', 30),
('Magneton', 'Electric', 'Steel', NULL),
('Farfetch\'d', 'Normal', 'Flying', NULL),
('Doduo', 'Normal', 'Flying', 31),
('Dodrio', 'Normal', 'Flying', NULL),
('Seel', 'Water', NULL, 34),
('Dewgong', 'Water', 'Ice', NULL),
('Grimer', 'Poison', NULL, 38),
('Muk', 'Poison', NULL, NULL),
('Shellder', 'Water', NULL, NULL), -- Evolves with Water Stone
('Cloyster', 'Water', 'Ice', NULL),
('Gastly', 'Ghost', 'Poison', 25),
('Haunter', 'Ghost', 'Poison', NULL), -- Evolves via Trade
('Gengar', 'Ghost', 'Poison', NULL),
('Onix', 'Rock', 'Ground', NULL),
('Drowzee', 'Psychic', NULL, 26),
('Hypno', 'Psychic', NULL, NULL),
('Krabby', 'Water', NULL, 28),
('Kingler', 'Water', NULL, NULL),
('Voltorb', 'Electric', NULL, 30),
('Electrode', 'Electric', NULL, NULL),
('Exeggcute', 'Grass', 'Psychic', NULL), -- Evolves with Leaf Stone
('Exeggutor', 'Grass', 'Psychic', NULL),
('Cubone', 'Ground', NULL, 28),
('Marowak', 'Ground', NULL, NULL),
('Hitmonlee', 'Fighting', NULL, NULL),
('Hitmonchan', 'Fighting', NULL, NULL),
('Lickitung', 'Normal', NULL, NULL),
('Koffing', 'Poison', NULL, 35),
('Weezing', 'Poison', NULL, NULL),
('Rhyhorn', 'Ground', 'Rock', 42),
('Rhydon', 'Ground', 'Rock', NULL),
('Chansey', 'Normal', NULL, NULL),
('Tangela', 'Grass', NULL, NULL),
('Kangaskhan', 'Normal', NULL, NULL),
('Horsea', 'Water', NULL, 32),
('Seadra', 'Water', NULL, NULL),
('Goldeen', 'Water', NULL, 33),
('Seaking', 'Water', NULL, NULL),
('Staryu', 'Water', NULL, NULL), -- Evolves with Water Stone
('Starmie', 'Water', 'Psychic', NULL),
('Mr. Mime', 'Psychic', 'Fairy', NULL),
('Scyther', 'Bug', 'Flying', NULL),
('Jynx', 'Ice', 'Psychic', NULL),
('Electabuzz', 'Electric', NULL, NULL),
('Magmar', 'Fire', NULL, NULL),
('Pinsir', 'Bug', NULL, NULL),
('Tauros', 'Normal', NULL, NULL),
('Magikarp', 'Water', NULL, 20),
('Gyarados', 'Water', 'Flying', NULL),
('Lapras', 'Water', 'Ice', NULL),
('Ditto', 'Normal', NULL, NULL),
('Eevee', 'Normal', NULL, NULL), -- Evolves with Various Stones
('Vaporeon', 'Water', NULL, NULL),
('Jolteon', 'Electric', NULL, NULL),
('Flareon', 'Fire', NULL, NULL),
('Porygon', 'Normal', NULL, NULL),
('Omanyte', 'Rock', 'Water', 40),
('Omastar', 'Rock', 'Water', NULL),
('Kabuto', 'Rock', 'Water', 40),
('Kabutops', 'Rock', 'Water', NULL),
('Aerodactyl', 'Rock', 'Flying', NULL),
('Snorlax', 'Normal', NULL, NULL),
('Articuno', 'Ice', 'Flying', NULL),
('Zapdos', 'Electric', 'Flying', NULL),
('Moltres', 'Fire', 'Flying', NULL),
('Dratini', 'Dragon', NULL, 30),
('Dragonair', 'Dragon', NULL, 55),
('Dragonite', 'Dragon', 'Flying', NULL),
('Mewtwo', 'Psychic', NULL, NULL),
('Mew', 'Psychic', NULL, NULL);
