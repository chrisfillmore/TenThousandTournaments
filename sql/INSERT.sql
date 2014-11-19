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
    INSERT INTO users (first_name, last_name, group_id)
        VALUES ('Chris', 'Fillmore', 1);
    SELECT @last_id:=id FROM users
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO admins (id)
        VALUES (@last_id);
COMMIT;

START TRANSACTION;
    INSERT INTO users (first_name, last_name, group_id)
        VALUES ('Jeremy', 'Roy', 1);
    SELECT @last_id:=id FROM users
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO admins (id)
        VALUES (@last_id);
COMMIT;

-- USERS->Referees
INSERT INTO users (first_name, last_name, group_id)
    VALUES ('Alexis', 'Dicks-Stephen', 3);

INSERT INTO users (first_name, last_name, group_id)
    VALUES ('Maziar', 'Masoudi', 3);


-- USERS->Players
START TRANSACTION;
    INSERT INTO users (first_name, last_name, group_id)
        VALUES ('Batul', 'Lamaa', 2);
    SELECT @last_id:=id FROM users
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO players (id)
        VALUES (@last_id);
COMMIT;

START TRANSACTION;
    INSERT INTO users (first_name, last_name, group_id)
        VALUES ('Jordan', 'Thiessen', 2);
    SELECT @last_id:=id FROM users
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO players (id)
        VALUES (@last_id);
COMMIT;

START TRANSACTION;
    INSERT INTO users (first_name, last_name, group_id)
        VALUES ('Abid', 'Rana', 2);
    SELECT @last_id:=id FROM users
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO players (id)
        VALUES (@last_id);
COMMIT;

START TRANSACTION;
    INSERT INTO users (first_name, last_name, group_id)
        VALUES ('Wayne', 'Gretzky', 2);
    SELECT @last_id:=id FROM users
        ORDER BY id DESC
        LIMIT 1;
    INSERT INTO players (id)
        VALUES (@last_id);
COMMIT;

-- TEAMS
INSERT INTO teams (name, date_registered, rep_user_id)
    VALUES ('Autobots', NOW(), 5);
INSERT INTO teams (name, date_registered, rep_user_id)
    VALUES ('Decepticons', NOW(), 6);


-- PLAYERS_TEAMS_DIVISIONS_SEASONS
INSERT INTO players_teams_divisions_seasons (player_id, team_id, division_id, season_id)
    VALUES (5,1,1,1);
INSERT INTO players_teams_divisions_seasons (player_id, team_id, division_id, season_id)
    VALUES (5,2,1,1);
INSERT INTO players_teams_divisions_seasons (player_id, team_id, division_id, season_id)
    VALUES (5,1,2,1);
INSERT INTO players_teams_divisions_seasons (player_id, team_id, division_id, season_id)
    VALUES (5,2,2,1);
INSERT INTO players_teams_divisions_seasons (player_id, team_id, division_id, season_id)
    VALUES (6,1,1,2);
INSERT INTO players_teams_divisions_seasons (player_id, team_id, division_id, season_id)
    VALUES (6,2,1,2);
INSERT INTO players_teams_divisions_seasons (player_id, team_id, division_id, season_id)
    VALUES (6,1,2,2);
INSERT INTO players_teams_divisions_seasons (player_id, team_id, division_id, season_id)
    VALUES (6,2,2,2);
INSERT INTO players_teams_divisions_seasons (player_id, team_id, division_id, season_id)
    VALUES (6,1,1,1);
INSERT INTO players_teams_divisions_seasons (player_id, team_id, division_id, season_id)
    VALUES (6,2,1,1);
INSERT INTO players_teams_divisions_seasons (player_id, team_id, division_id, season_id)
    VALUES (6,1,2,1);
INSERT INTO players_teams_divisions_seasons (player_id, team_id, division_id, season_id)
    VALUES (6,2,2,1);
INSERT INTO players_teams_divisions_seasons (player_id, team_id, division_id, season_id)
    VALUES (5,1,1,2);
INSERT INTO players_teams_divisions_seasons (player_id, team_id, division_id, season_id)
    VALUES (5,2,1,2);
INSERT INTO players_teams_divisions_seasons (player_id, team_id, division_id, season_id)
    VALUES (5,1,2,2);
INSERT INTO players_teams_divisions_seasons (player_id, team_id, division_id, season_id)
    VALUES (5,2,2,2);

-- ADMINS_LEAGUES_TITLES
INSERT INTO admins_leagues_titles (admin_id, league_id, title_id)
    VALUES (1, 1, 1);
INSERT INTO admins_leagues_titles (admin_id, league_id, title_id)
    VALUES (1, 2, 1);
INSERT INTO admins_leagues_titles (admin_id, league_id, title_id)
    VALUES (2, 2, 1);
INSERT INTO admins_leagues_titles (admin_id, league_id, title_id)
    VALUES (2, 2, 5);
INSERT INTO admins_leagues_titles (admin_id, league_id, title_id)
    VALUES (1, 2, 4);
INSERT INTO admins_leagues_titles (admin_id, league_id, title_id)
    VALUES (1, 1, 4);