-- SPORTS
INSERT INTO sports (name)
    VALUES ('Hockey');
INSERT INTO sports (name)
    VALUES ('Baseball');
INSERT INTO sports (name)
    VALUES ('Football');
INSERT INTO sports (name)
    VALUES ('Basketball');
INSERT INTO sports (name)
    VALUES ('Soccer');
INSERT INTO sports (name)
    VALUES ('Lacrosse');
INSERT INTO sports (name)
    VALUES ('Rugby');
INSERT INTO sports (name)
    VALUES ('Ultimate');

-- LEAGUES
INSERT INTO leagues (name, sport_id)
    VALUES ('Toronto Recreational Hockey', 1);
INSERT INTO leagues (name, sport_id)
    VALUES ('Toronto Leisure Ball', 2);
INSERT INTO leagues (name, sport_id)
    VALUES ('Senior\'s Hockey League', 1);
INSERT INTO leagues (name, sport_id)
    VALUES ('Football Toronto', 3);

-- SEASONS
INSERT INTO seasons (year, league_id)
    VALUES (2014, 1);
INSERT INTO seasons (year, league_id)
    VALUES (2013, 1);
INSERT INTO seasons (year, league_id)
    VALUES (2014, 2);

-- DIVISIONS
INSERT INTO divisions (name, rank)
    VALUES ('Molson Canadian', 1);
INSERT INTO divisions (name, rank)
    VALUES ('Labbatt Blue', 2);
INSERT INTO divisions (name, rank)
    VALUES ('Creemore Springs', 3);

-- TITLES & GROUPS
START TRANSACTION;
    INSERT INTO titles (name)
        VALUES ('League Administrator');
    SELECT @last_id:=id FROM titles
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO groups (title_id)
        VALUES (@last_id);
COMMIT;

START TRANSACTION;
    INSERT INTO titles (name)
        VALUES ('Players');
    SELECT @last_id:=id FROM titles
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO groups (title_id)
        VALUES (@last_id);
COMMIT;

START TRANSACTION;
    INSERT INTO titles (name)
        VALUES ('Referees');
    SELECT @last_id:=id FROM titles
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO groups (title_id)
        VALUES (@last_id);
COMMIT;

START TRANSACTION;
    INSERT INTO titles (name)
        VALUES ('Chief Statistician');
    SELECT @last_id:=id FROM titles
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO groups (title_id)
        VALUES (@last_id);
COMMIT;

START TRANSACTION;
    INSERT INTO titles (name)
        VALUES ('Chief Disciplinarian');
    SELECT @last_id:=id FROM titles
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO groups (title_id)
        VALUES (@last_id);
COMMIT;

-- USERS->Administrators
START TRANSACTION;
    INSERT INTO users (first_name, last_name)
        VALUES ('Chris', 'Fillmore');
    SELECT @last_id:=id FROM users
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO admins (id)
        VALUES (@last_id);
COMMIT;

START TRANSACTION;
    INSERT INTO users (first_name, last_name)
        VALUES ('Jeremy', 'Roy');
    SELECT @last_id:=id FROM users
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO admins (id)
        VALUES (@last_id);
COMMIT;

-- USERS->Referees
START TRANSACTION;
    INSERT INTO users (first_name, last_name)
        VALUES ('Alexis', 'Dicks-Stephen');
    SELECT @last_id:=id FROM users
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO referees (id)
        VALUES (@last_id);
COMMIT;

START TRANSACTION;
    INSERT INTO users (first_name, last_name)
        VALUES ('Maziar', 'Masoudi');
    SELECT @last_id:=id FROM users
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO referees (id)
        VALUES (@last_id);
COMMIT;

-- USERS->Players
START TRANSACTION;
    INSERT INTO users (first_name, last_name)
        VALUES ('Batul', 'Lamaa');
    SELECT @last_id:=id FROM users
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO players (id)
        VALUES (@last_id);
COMMIT;

START TRANSACTION;
    INSERT INTO users (first_name, last_name)
        VALUES ('Jordan', 'Thiessen');
    SELECT @last_id:=id FROM users
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO players (id)
        VALUES (@last_id);
COMMIT;

START TRANSACTION;
    INSERT INTO users (first_name, last_name)
        VALUES ('Abid', 'Rana');
    SELECT @last_id:=id FROM users
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO players (id)
        VALUES (@last_id);
COMMIT;

START TRANSACTION;
    INSERT INTO users (first_name, last_name)
        VALUES ('Wayne', 'Gretzky');
    SELECT @last_id:=id FROM users
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO players (id)
        VALUES (@last_id);
COMMIT;

-- TEAMS
INSERT INTO teams (name, date_registered, rep_player_id)
    VALUES ('Autobots', NOW(), 5);
INSERT INTO teams (name, date_registered, rep_player_id)
    VALUES ('Decepticons', NOW(), 6);


-- PLAYERS_TEAMS_DIVISIONS_SEASONS
INSERT INTO divisions_players_seasons_teams (division_id, player_id, season_id, team_id)
    VALUES (1,5,1,1);
INSERT INTO divisions_players_seasons_teams (division_id, player_id, season_id, team_id)
    VALUES (1,5,1,2);
INSERT INTO divisions_players_seasons_teams (division_id, player_id, season_id, team_id)
    VALUES (2,5,1,1);
INSERT INTO divisions_players_seasons_teams (division_id, player_id, season_id, team_id)
    VALUES (2,5,1,2);
INSERT INTO divisions_players_seasons_teams (division_id, player_id, season_id, team_id)
    VALUES (1,6,2,1);
INSERT INTO divisions_players_seasons_teams (division_id, player_id, season_id, team_id)
    VALUES (1,6,2,2);
INSERT INTO divisions_players_seasons_teams (division_id, player_id, season_id, team_id)
    VALUES (2,6,2,1);
INSERT INTO divisions_players_seasons_teams (division_id, player_id, season_id, team_id)
    VALUES (2,6,2,2);
INSERT INTO divisions_players_seasons_teams (division_id, player_id, season_id, team_id)
    VALUES (1,6,1,1);
INSERT INTO divisions_players_seasons_teams (division_id, player_id, season_id, team_id)
    VALUES (1,6,1,2);
INSERT INTO divisions_players_seasons_teams (division_id, player_id, season_id, team_id)
    VALUES (2,6,1,1);
INSERT INTO divisions_players_seasons_teams (division_id, player_id, season_id, team_id)
    VALUES (2,6,1,2);
INSERT INTO divisions_players_seasons_teams (division_id, player_id, season_id, team_id)
    VALUES (1,5,2,1);
INSERT INTO divisions_players_seasons_teams (division_id, player_id, season_id, team_id)
    VALUES (1,5,2,2);
INSERT INTO divisions_players_seasons_teams (division_id, player_id, season_id, team_id)
    VALUES (2,5,2,1);
INSERT INTO divisions_players_seasons_teams (division_id, player_id, season_id, team_id)
    VALUES (2,5,2,2);

-- ROLES
INSERT INTO roles (title_id)
    VALUES (1);
INSERT INTO roles (title_id)
    VALUES (4);
INSERT INTO roles (title_id)
    VALUES (5);

-- ADMINS_LEAGUES_ROLES
INSERT INTO admins_leagues_roles (admin_id, league_id, role_id)
    VALUES (1, 1, 1);
INSERT INTO admins_leagues_roles (admin_id, league_id, role_id)
    VALUES (1, 2, 1);
INSERT INTO admins_leagues_roles (admin_id, league_id, role_id)
    VALUES (2, 2, 1);
INSERT INTO admins_leagues_roles (admin_id, league_id, role_id)
    VALUES (2, 2, 3);
INSERT INTO admins_leagues_roles (admin_id, league_id, role_id)
    VALUES (1, 2, 2);
INSERT INTO admins_leagues_roles (admin_id, league_id, role_id)
    VALUES (1, 1, 2);