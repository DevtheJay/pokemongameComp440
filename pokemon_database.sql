-- Create database
create database if not exists game;
use game;

-- Table: pokedex
create table if not exists pokedex(
    pokemon_id int primary key auto_increment,
    pokemon_name varchar(50),
    pokemon_type_1 varchar(20) not null,
    pokemon_type_2 varchar(20) default null,
    evolution_lvl int not null
);

-- Table: location
create table if not exists location(
    location_id int primary key,
    location_name varchar(50),
    location_type varchar(50),
    building_type varchar(50)
);

-- Table: users
create table if not exists users(
    user_id int primary key,
    nickname varchar(50),
    gender varchar(10),
    location_id int,
    foreign key(location_id) references location(location_id)
);

-- Table: items
create table if not exists items(
    item_id int primary key,
    item_name varchar(50),
    item_description varchar(100),
    location_id int,
    foreign key(location_id) references location(location_id)
);

-- Table: moves
create table if not exists moves(
    move_id int primary key,
    move_name varchar(50) unique,
    move_damage varchar(100),
    move_accuracy varchar(50),
    move_type varchar(50)
);

-- Table: NPCS
create table if not exists NPCS(
    npc_id int primary key,
    npc_name varchar(50),
    location_id int,
    occupation varchar(100),
    foreign key(location_id) references location(location_id)
);

-- Table: gym
create table if not exists gym(
    gym_id int primary key,
    gym_name varchar(50),
    npc_id int,
    location_id int,
    foreign key(location_id) references location(location_id),
    foreign key(npc_id) references NPCS(npc_id)
);

-- Table: battle
create table if not exists battle(
    battle_id int primary key,
    participant_1 varchar(50),
    participant_2 varchar(50),
    outcome varchar(50)
);



-- Table: user_inventory
create table if not exists user_inventory(
    item_id int,
    item_name varchar(50),
    quantity int check (quantity <= 10),
    user_id int,
    primary key (item_id, user_id),
    foreign key(item_id) references items(item_id),
    foreign key(user_id) references users(user_id)
);


-- Table: npc_inventory
create table if not exists npc_inventory(
    item_id int,
    item_name varchar(50),
    quantity int check (quantity <= 10),
    onwer_id int,
    primary key (item_id, npc_id),
    foreign key(item_id) references items(item_id),
    foreign key(npc_id) references NPCS(npc_id)
);
-- Table: pokemon_inventory
create table if not exists npc_pokemon_inventory(
    entity_id int,
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
    foreign key(pokemon_moves_1, pokemon_moves_2, pokemon_moves_3, pokemon_moves_4) references moves(move_id)
);


create table if not exists user_pokemon_inventory(
    entity_id int,
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
    foreign key(user_id) references user(user_id)
    foreign key(pokemon_moves_1, pokemon_moves_2, pokemon_moves_3, pokemon_moves_4) references moves(move_id)
);


INSERT INTO pokedex (pokemon_name, pokemon_type_1, pokemon_type_2, P_E_L)
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


