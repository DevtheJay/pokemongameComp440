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
    evolution_lvl int not null
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
('Bulbasaur', 'Grass', 'Poison', 1),
('Ivysaur', 'Grass', 'Poison', 2),
('Venusaur', 'Grass', 'Poison', 3),
('Charmander', 'Fire', NULL, 1),
('Charmeleon', 'Fire', NULL, 2),
('Charizard', 'Fire', 'Flying', 3),
('Squirtle', 'Water', NULL, 1),
('Wartortle', 'Water', NULL, 2),
('Blastoise', 'Water', NULL, 3),
('Caterpie', 'Bug', NULL, 1),
('Metapod', 'Bug', NULL, 2),
('Butterfree', 'Bug', 'Flying', 3),
('Weedle', 'Bug', 'Poison', 1),
('Kakuna', 'Bug', 'Poison', 2),
('Beedrill', 'Bug', 'Poison', 3),
('Pidgey', 'Normal', 'Flying', 1),
('Pidgeotto', 'Normal', 'Flying', 2),
('Pidgeot', 'Normal', 'Flying', 3),
('Rattata', 'Normal', NULL, 1),
('Raticate', 'Normal', NULL, 2),
('Spearow', 'Normal', 'Flying', 1),
('Fearow', 'Normal', 'Flying', 2),
('Ekans', 'Poison', NULL, 1),
('Arbok', 'Poison', NULL, 2),
('Psyduck', 'Water', NULL, 1),
('Golduck', 'Water', NULL, 2),
('Machop', 'Fighting', NULL, 1),
('Machoke', 'Fighting', NULL, 2),
('Machamp', 'Fighting', NULL, 3),
('Bellsprout', 'Grass', 'Poison', 1),
('Weepinbell', 'Grass', 'Poison', 2),
('Victreebel', 'Grass', 'Poison', 3),
('Tentacool', 'Water', 'Poison', 1),
('Tentacruel', 'Water', 'Poison', 2),
('Geodude', 'Rock', 'Ground', 1),
('Graveler', 'Rock', 'Ground', 2),
('Golem', 'Rock', 'Ground', 3),
('Ponyta', 'Fire', NULL, 1),
('Rapidash', 'Fire', NULL, 2),
('Slowpoke', 'Water', 'Psychic', 1),
('Slowbro', 'Water', 'Psychic', 2),
('Magnemite', 'Electric', 'Steel', 1),
('Magneton', 'Electric', 'Steel', 2),
('Krabby', 'Water', NULL, 1),
('Kingler', 'Water', NULL, 2),
('Exeggcute', 'Grass', 'Psychic', 1),
('Exeggutor', 'Grass', 'Psychic', 2),
('Cubone', 'Ground', NULL, 1),
('Marowak', 'Ground', NULL, 2),
('Koffing', 'Poison', NULL, 1),
('Weezing', 'Poison', NULL, 2),
('Rhyhorn', 'Rock', 'Ground', 1),
('Rhydon', 'Rock', 'Ground', 2),
('Chansey', 'Normal', NULL, 1),
('Tangela', 'Grass', NULL, 1),
('Kangaskhan', 'Normal', NULL, 1),
('Horsea', 'Water', NULL, 1),
('Seadra', 'Water', NULL, 2),
('Goldeen', 'Water', NULL, 1),
('Seaking', 'Water', NULL, 2),
('Staryu', 'Water', NULL, 1),
('Starmie', 'Water', 'Psychic', 2),
('Mr. Mime', 'Psychic', 'Fairy', 1),
('Scyther', 'Bug', 'Flying', 1),
('Jynx', 'Ice', 'Psychic', 1),
('Electabuzz', 'Electric', NULL, 1),
('Magmar', 'Fire', NULL, 1),
('Pinsir', 'Bug', NULL, 1),
('Tauros', 'Normal', NULL, 1),
('Magikarp', 'Water', NULL, 1),
('Gyarados', 'Water', 'Flying', 2),
('Lapras', 'Water', 'Ice', 1),
('Ditto', 'Normal', NULL, 1),
('Eevee', 'Normal', NULL, 1),
('Vaporeon', 'Water', NULL, 2),
('Jolteon', 'Electric', NULL, 2),
('Flareon', 'Fire', NULL, 2),
('Porygon', 'Normal', NULL, 1),
('Omanyte', 'Rock', 'Water', 1),
('Omastar', 'Rock', 'Water', 2),
('Kabuto', 'Rock', 'Water', 1),
('Kabutops', 'Rock', 'Water', 2),
('Aerodactyl', 'Rock', 'Flying', 1),
('Mewtwo', 'Psychic', NULL, 1),
('Mew', 'Psychic', NULL, 1);