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
    item_description varchar(100)
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

INSERT INTO moves (move_name, move_damage, move_accuracy, move_type)
VALUES
('Tackle', '40', '100%', 'Normal'),
('Growl', '0', '100%', 'Normal'),
('Scratch', '40', '100%', 'Normal'),
('Ember', '40', '100%', 'Fire'),
('Water Gun', '40', '100%', 'Water'),
('Thunder Shock', '40', '100%', 'Electric'),
('Quick Attack', '40', '100%', 'Normal'),
('Vine Whip', '45', '100%', 'Grass'),
('Confusion', '50', '100%', 'Psychic'),
('Peck', '35', '100%', 'Flying'),
('Razor Leaf', '55', '95%', 'Grass'),
('Bubble', '40', '100%', 'Water'),
('Thunder Wave', '0', '90%', 'Electric'),
('Flamethrower', '90', '100%', 'Fire'),
('Hydro Pump', '110', '80%', 'Water'),
('Thunderbolt', '90', '100%', 'Electric'),
('Ice Beam', '90', '100%', 'Ice'),
('Earthquake', '100', '100%', 'Ground'),
('Hyper Beam', '150', '90%', 'Normal'),
('Rock Slide', '75', '90%', 'Rock'),
('Surf', '90', '100%', 'Water'),
('SolarBeam', '120', '100%', 'Grass'),
('Psychic', '90', '100%', 'Psychic'),
('Fire Blast', '110', '85%', 'Fire'),
('Blizzard', '110', '70%', 'Ice'),
('Double Team', '0', '100%', 'Normal'),
('Body Slam', '85', '100%', 'Normal'),
('Rest', '0', '100%', 'Psychic'),
('Poison Sting', '15', '100%', 'Poison'),
('Bubble Beam', '65', '100%', 'Water'),
('Swift', '60', 'Always Hits', 'Normal'),
('Fly', '90', '95%', 'Flying'),
('Dig', '80', '100%', 'Ground'),
('Cut', '50', '95%', 'Normal'),
('Strength', '80', '100%', 'Normal'),
('Sleep Powder', '0', '75%', 'Grass'),
('Stun Spore', '0', '75%', 'Grass'),
('Leech Seed', '0', '90%', 'Grass'),
('Dragon Rage', '40', '100%', 'Dragon'),
('Seismic Toss', 'Varies', '100%', 'Fighting'),
('Wrap', '15', '90%', 'Normal'),
('Clamp', '35', '85%', 'Water'),
('Thunder', '110', '70%', 'Electric'),
('Explosion', '250', '100%', 'Normal'),
('Slash', '70', '100%', 'Normal'),
('Egg Bomb', '100', '75%', 'Normal'),
('Submission', '80', '80%', 'Fighting'),
('Mega Punch', '80', '85%', 'Normal'),
('Mega Kick', '120', '75%', 'Normal'),
('Karate Chop', '50', '100%', 'Fighting'),
('Low Kick', 'Varies', '100%', 'Fighting'),
('Horn Attack', '65', '100%', 'Normal'),
('Double Kick', '30', '100%', 'Fighting'),
('Bite', '60', '100%', 'Normal'),
('Rage', '20', '100%', 'Normal'),
('Smokescreen', '0', '100%', 'Normal'),
('Aurora Beam', '65', '100%', 'Ice'),
('Confuse Ray', '0', '100%', 'Ghost'),
('Dream Eater', '100', '100%', 'Psychic'),
('Rock Throw', '50', '90%', 'Rock'),
('Harden', '0', '100%', 'Normal'),
('Acid', '40', '100%', 'Poison'),
('Swords Dance', '0', '100%', 'Normal'),
('Spore', '0', '100%', 'Grass'),
('Gust', '40', '100%', 'Normal'),
('Wing Attack', '60', '100%', 'Flying'),
('Night Shade', 'Varies', '100%', 'Ghost'),
('Fire Spin', '35', '85%', 'Fire'),
('Splash', '0', '100%', 'Normal'),
('Transform', '0', '100%', 'Normal'),
('Recover', '0', '100%', 'Normal'),
('Barrier', '0', '100%', 'Psychic'),
('Light Screen', '0', '100%', 'Psychic'),
('Reflect', '0', '100%', 'Psychic'),
('Double-Edge', '120', '100%', 'Normal'),
('Leer', '0', '100%', 'Normal'),
('Focus Energy', '0', '100%', 'Normal'),
('Pay Day', '40', '100%', 'Normal'),
('Metronome', 'Varies', '100%', 'Normal'),
('Counter', 'Varies', '100%', 'Fighting'),
('Withdraw', '0', '100%', 'Water');


INSERT INTO items (item_name, item_description)
VALUES
('Potion', 'Restores 20 HP of a Pokémon.'),
('Super Potion', 'Restores 50 HP of a Pokémon.'),
('Hyper Potion', 'Restores 120 HP of a Pokémon.'),
('Max Potion', 'Fully restores a Pokémon\'s HP.'),
('Full Restore', 'Fully restores HP and cures all status conditions.'),
('Revive', 'Revives a fainted Pokémon with half HP.'),
('Max Revive', 'Fully revives a fainted Pokémon.'),
('Antidote', 'Cures a poisoned Pokémon.'),
('Paralyze Heal', 'Cures a paralyzed Pokémon.'),
('Burn Heal', 'Cures a burned Pokémon.'),
('Ice Heal', 'Cures a frozen Pokémon.'),
('Awakening', 'Wakes up a sleeping Pokémon.'),
('Full Heal', 'Cures all status conditions.'),
('Poké Ball', 'A device for catching wild Pokémon.'),
('Great Ball', 'A good-quality ball with a higher catch rate.'),
('Ultra Ball', 'An ultra-high-performance ball.'),
('Master Ball', 'The ultimate ball that guarantees a catch.'),
('Escape Rope', 'Allows escape from caves or dungeons.'),
('Repel', 'Repels weak wild Pokémon for 100 steps.'),
('Super Repel', 'Repels weak wild Pokémon for 200 steps.'),
('Max Repel', 'Repels weak wild Pokémon for 250 steps.'),
('Rare Candy', 'Raises a Pokémon\'s level by 1.'),
('Elixir', 'Restores 10 PP to all moves.'),
('Max Elixir', 'Fully restores PP to all moves.'),
('Ether', 'Restores 10 PP to one move.'),
('Max Ether', 'Fully restores PP to one move.'),
('X Attack', 'Raises a Pokémon\'s Attack during battle.'),
('X Defense', 'Raises a Pokémon\'s Defense during battle.'),
('X Speed', 'Raises a Pokémon\'s Speed during battle.'),
('X Special', 'Raises a Pokémon\'s Special Attack.'),
('Guard Spec.', 'Prevents stat reduction for 5 turns.'),
('HP Up', 'Permanently increases a Pokémon\'s HP.'),
('Protein', 'Permanently increases a Pokémon\'s Attack.'),
('Iron', 'Permanently increases a Pokémon\'s Defense.'),
('Carbos', 'Permanently increases a Pokémon\'s Speed.'),
('Calcium', 'Permanently increases a Pokémon\'s Special.'),
('Moon Stone', 'Evolves certain Pokémon.'),
('Fire Stone', 'Evolves certain Fire-type Pokémon.'),
('Thunder Stone', 'Evolves certain Electric-type Pokémon.'),
('Water Stone', 'Evolves certain Water-type Pokémon.'),
('Leaf Stone', 'Evolves certain Grass-type Pokémon.'),
('PP Up', 'Increases the maximum PP of a selected move.'),
('PP Max', 'Maximizes the PP of a selected move.'),
('Exp. All', 'Shares experience points among Pokémon.'),
('Bike Voucher', 'Exchange for a Bicycle at the shop.'),
('Old Rod', 'A basic fishing rod for catching Pokémon.'),
('Good Rod', 'A good-quality fishing rod for catching Pokémon.'),
('Super Rod', 'The best-quality fishing rod.'),
('Town Map', 'Displays a map of the region.'),
('TM01', 'Contains the move Mega Punch.'),
('HM01', 'Contains the move Cut.'),
('HM02', 'Contains the move Fly.'),
('HM03', 'Contains the move Surf.'),
('HM04', 'Contains the move Strength.'),
('HM05', 'Contains the move Flash.');
