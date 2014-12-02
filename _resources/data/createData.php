<?php

// Constants
define('NUM_LEAGUES', 10);
define('NUM_TEAMS', 200);
define('NUM_PLAYERS', 2000);
define('NUM_SEASONS', 200);
define('NUM_HOCKEY_SEASONS', 20);
define('NUM_BASEBALL_SEASONS', 20);
define('NUM_FOOTBALL_SEASONS', 20);
define('NUM_BASKETBALL_SEASONS', 20);
define('NUM_SOCCER_SEASONS', 20);
define('NUM_HOCKEY_TEAMS', 40);
define('NUM_BASEBALL_TEAMS', 40);
define('NUM_FOOTBALL_TEAMS', 40);
define('NUM_BASKETBALL_TEAMS', 40);
define('NUM_SOCCER_TEAMS', 40);
define('NUM_HOCKEY_LEAGUES', 2);
define('NUM_BASEBALL_LEAGUES', 2);
define('NUM_FOOTBALL_LEAGUES', 2);
define('NUM_BASKETBALL_LEAGUES', 2);
define('NUM_SOCCER_LEAGUES', 2);
define('NUM_LOCATIONS', 312);

// Create a basic INSERT statement
function createInsert(array $values, $table, array $columns) {
    foreach ($values as $key => $value)
      $values[$key] = addslashes(trim($value));
    $insert =
            'INSERT INTO ' . $table . ' (' .
            implode(',', $columns) . ') ' .
            'VALUES (\'' .
            implode('\',\'', $values) . '\');';
    return $insert;
}

// Get an array of INSERT statements
function createInserts(array $data, $table, array $columns) {
    $inserts = [];
    foreach ($data as $values)
        $inserts[] = createInsert($values, $table, $columns);
    return $inserts;
}

// Create a TRANSACTION, for when you need to enter into two tables at once
function createTransactions(array $data, $parentTable, $columns, $childTable) {
    $transactions = [];
    foreach ($data as $values) {
        $transactions[] =
                'START TRANSACTION; ' .
                createInsert($values, $parentTable, $columns) .
                'SELECT @last_id:=id FROM ' . $parentTable . ' ' .
                'ORDER BY id DESC LIMIT 1; ' .
                'INSERT INTO ' . $childTable . ' (id) VALUES (@last_id); ' .
                'COMMIT;';
    }
    return $transactions;
}

/* Seasons 
$data = [];

for ($l = 1; $l <= NUM_LEAGUES; $l++) {
    for ($s = 9; $s >= 0; $s--) {
        $year = 2014 - $s;
        $data[] = [$year, $l];
    }
}

$table = 'seasons';
$columns = ['year', 'league_id'];

$inserts = createInserts($data, $table, $columns);

foreach ($inserts as $value)
    echo $value . '<br>';

unset($data);
unset($table);
unset($columns);
unset($inserts);
unset($value);*/

/* Teams 
$sports =
        [
            'hockey' => 1,
            'baseball' => 2,
            'football' => 3,
            'basketball' => 4,
            'soccer' => 5,
        ];
$team_name_files =
        [
            $sports['hockey'] => 'hockey_team_names.txt',
            $sports['baseball'] => 'baseball_team_names.txt',
            $sports['football'] => 'football_team_names.txt',
            $sports['basketball'] => 'basketball_team_names.txt',
            $sports['soccer'] => 'soccer_team_names.txt'
        ];

$data = [];

foreach ($team_name_files as $team_name_file) {
  $file = file($team_name_file);
  foreach ($file as $line)
    $data[] = [$line];
}

for ($t = 1; $t <= NUM_HOCKEY_TEAMS; $t++)
    $data[$t - 1][] = $t / (NUM_HOCKEY_TEAMS / 2) <= 1 ? 1 : 2;
for ($t = 41; $t <= NUM_BASEBALL_TEAMS + 40; $t++)
    $data[$t - 1][] = $t / ((NUM_BASEBALL_TEAMS + 40) / 2) <= 1 ? 3 : 4;
for ($t = 81; $t <= NUM_FOOTBALL_TEAMS + 80; $t++)
    $data[$t - 1][] = $t / ((NUM_FOOTBALL_TEAMS + 80) / 2) <= 1 ? 5 : 6; 
for ($t = 121; $t <= NUM_BASEBALL_TEAMS + 120; $t++)
    $data[$t - 1][] = $t / ((NUM_BASEBALL_TEAMS + 120) / 2) <= 1 ? 7 : 8;
for ($t = 161; $t <= NUM_SOCCER_TEAMS + 160; $t++)
    $data[$t - 1][] = $t / ((NUM_SOCCER_TEAMS + 160) / 2) <= 1 ? 9 : 10;

$table = 'teams';
$columns = ['name', 'league_id'];

$inserts = createInserts($data, $table, $columns);

foreach ($inserts as $value)
  echo $value . '<br>';

unset($data);
unset($table);
unset($columns);
unset($inserts);
unset($value);
unset($file);*/

/* Players 

$user_name_file = 'user_names.txt';

$data = [];

$file = file($user_name_file);
foreach ($file as $line) {
    $name = explode(' ', $line);
    $data[] = [$name[0], $name[1]];
}

$parentTable = 'users';
$columns = ['first_name', 'last_name'];
$childTable = 'players';

$inserts = createTransactions($data, $parentTable, $columns, $childTable);

foreach ($inserts as $value)
  echo $value . '<br>';

unset($data);
unset($parentTable);
unset($columns);
unset($inserts);
unset($value);
unset($file);
unset($childTable); */

/* Seasons_Teams 

$data = [];

for ($s = 1; $s <= NUM_HOCKEY_SEASONS; $s++) {    
    if ($s / 10 <= 1) {
        for ($t = 1; $t <= NUM_HOCKEY_TEAMS / 2; $t++) {
            $data[] = [$s, $t];
        }
    } else {
        for ($t = 21; $t <= NUM_HOCKEY_TEAMS; $t++) {
            $data[] = [$s, $t];
        }
    }
}

for ($s = 21; $s <= NUM_BASEBALL_SEASONS + 20; $s++) {    
    if ($s / 30 <= 1) {
        for ($t = 41; $t <= NUM_BASEBALL_TEAMS / 2 + 40; $t++) {
            $data[] = [$s, $t];
        }
    } else {
        for ($t = 61; $t <= NUM_BASEBALL_TEAMS + 40; $t++) {
            $data[] = [$s, $t];
        }
    }
}

for ($s = 41; $s <= NUM_FOOTBALL_SEASONS + 40; $s++) {    
    if ($s / 50 <= 1 ) {
        for ($t = 81; $t <= NUM_FOOTBALL_TEAMS / 2 + 80; $t++) {
            $data[] = [$s, $t];
        }
    } else {
        for ($t = 101; $t <= NUM_FOOTBALL_TEAMS + 80; $t++) {
            $data[] = [$s, $t];
        }
    }
}

for ($s = 61; $s <= NUM_BASKETBALL_SEASONS + 60; $s++) {    
    if ($s / 70 <= 1) {
        for ($t = 121; $t <= NUM_BASKETBALL_TEAMS / 2 + 120; $t++) {
            $data[] = [$s, $t];
        }
    } else {
        for ($t = 141; $t <= NUM_BASKETBALL_TEAMS + 120; $t++) {
            $data[] = [$s, $t];
        }
    }
}

for ($s = 81; $s <= NUM_SOCCER_SEASONS + 80; $s++) {    
    if ($s / 90 <= 1) {
        for ($t = 161; $t <= NUM_SOCCER_TEAMS / 2 + 160; $t++) {
            $data[] = [$s, $t];
        }
    } else {
        for ($t = 181; $t <= NUM_SOCCER_TEAMS + 160; $t++) {
            $data[] = [$s, $t];
        }
    }
}

$table = 'seasons_teams';
$columns = ['season_id', 'team_id'];

$inserts = createInserts($data, $table, $columns);

foreach ($inserts as $value)
    echo $value . '<br>';

unset($data);
unset($table);
unset($columns);
unset($inserts);
unset($value);*/

/* Players_Teams 

$players_per_team = NUM_PLAYERS / NUM_TEAMS;
define('PLAYERS_PER_TEAM', $players_per_team);

$data = [];

$position = 1;
for ($t = 0; $t < NUM_TEAMS; $t++) {
    for ($num_players_this_team = 1; $num_players_this_team <= PLAYERS_PER_TEAM; $num_players_this_team++) {
        $p = $t * PLAYERS_PER_TEAM + $num_players_this_team;
        $data[] = [$p, $t + 1];
    }
}

$table = 'players_teams';
$columns = ['player_id', 'team_id'];

$inserts = createInserts($data, $table, $columns);

foreach ($inserts as $value)
    echo $value . '<br>';

unset($data);
unset($table);
unset($columns);
unset($inserts);
unset($value);*/

/* Locations 
$suffixes = ['Centre', 'Complex', 'Plaza', 'Sportsplex', 'Field', 'Arena'];

define('LOCATIONS_FILE', 'location_names.txt');
$locations = file(LOCATIONS_FILE);

$data = [];

foreach ($locations as $value) {
    $data[] = [$value];
}

$table = 'locations';
$columns = ['name'];

$inserts = createInserts($data, $table, $columns);

foreach ($inserts as $value)
    echo $value . '<br>';

unset($data);
unset($table);
unset($columns);
unset($inserts);
unset($value);*/

/* Games 

$game =
        [
            'home_team_id' => null,
            'away_team_id' => null,
            'date_time' => null,
            'location_id' => null,
            'season_id' => null
        ];

$data = [];

function seasonYear($id) {
    $years =
            [
                1 => 2005,
                2 => 2006,
                3 => 2007,
                4 => 2008,
                5 => 2009,
                6 => 2010,
                7 => 2011,
                8 => 2012,
                9 => 2013,
                0 => 2014,
            ];
    $i = $id % 10;
    return $years[$i];
}

function teamSeasonBracket($s) {
    if ($s >= 1 && $s <= 10) return [1, 20];
    if ($s >= 11 && $s <= 20) return [21, 40];
    if ($s >= 21 && $s <= 30) return [41, 60];
    if ($s >= 31 && $s <= 40) return [61, 80];
    if ($s >= 41 && $s <= 50) return [81, 100];
    if ($s >= 51 && $s <= 60) return [101, 120];
    if ($s >= 61 && $s <= 70) return [121, 140];
    if ($s >= 71 && $s <= 80) return [141, 160];
    if ($s >= 81 && $s <= 90) return [161, 180];
    if ($s >= 91 && $s <= 100) return [181, 200];
}

for ($s = 1; $s <= NUM_SEASONS; $s++) {
    $year = seasonYear($s);
    $game['season_id'] = $s;
    $range = teamSeasonBracket($s);
    for ($h_t = $range[0]; $h_t <= $range[1]; $h_t++) {
        $game['home_team_id'] = $h_t;
        $i = $h_t % 20;
        $start = $h_t - $i + 1;
        if ($start >= $h_t && $i != 1) $start = $start - 20;
        for ($a_t = $start; $a_t < $start + 20; $a_t++) {
            if ($a_t == $h_t) continue;
            $game['location_id'] = rand(1, NUM_LOCATIONS);
            $date_time = rand(strtotime($year . '-01-01'), strtotime($year . '-12-31'));
            $game['date_time'] = date('Y-m-d H:00:00', $date_time);
            $game['away_team_id'] = $a_t;
            $data[] = $game;
        }
    }
}

$table = 'games';
$columns = array_keys($game);

$inserts = createInserts($data, $table, $columns);

foreach ($inserts as $value)
    echo $value . '<br>';

unset($data);
unset($table);
unset($columns);
unset($inserts);
unset($value); */

/* GROUPS_USERS */

$data = [];

for ($p = 1; $p <= NUM_PLAYERS; $p++)
    $data[] = [$p, 2];

$table = 'groups_users';
$columns = ['user_id', 'group_id'];

$inserts = createInserts($data, $table, $columns);

foreach ($inserts as $value)
    echo $value . '<br>';

unset($data);
unset($table);
unset($columns);
unset($inserts);
unset($value);