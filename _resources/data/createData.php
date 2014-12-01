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

/* Seasons */
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
unset($value);

/* Teams */
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

for ($t = 1; $t <= 40; $t++)
    $data[$t - 1][] = ($t % 2) + 1;
for ($t = 41; $t <= 80; $t++)
    $data[$t - 1][] = ($t % 2) + 3;
for ($t = 81; $t <= 120; $t++)
    $data[$t - 1][] = ($t % 2) + 5;
for ($t = 121; $t <= 160; $t++)
    $data[$t - 1][] = ($t % 2) + 7;
for ($t = 161; $t <= 200; $t++)
    $data[$t - 1][] = ($t % 2) + 9;

$table = 'teams';
$columns = ['name', 'league_id'];

$inserts = createInserts($data, $table, $columns);

//echo var_dump($inserts);

foreach ($inserts as $value)
  echo $value . '<br>';

unset($data);
unset($table);
unset($columns);
unset($inserts);
unset($value);
unset($file);

/* Players */

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
unset($childTable);

/* Seasons_Teams */

$data = [];

for ($s = 1; $s <= NUM_HOCKEY_SEASONS; $s++) {
    for($t = 1; $t <= NUM_HOCKEY_TEAMS; $t++) {
        $data[] = [$s, $t];
    }
}

for ($s = 21; $s <= NUM_BASEBALL_SEASONS + 20; $s++) {
    for($t = 1; $t <= NUM_BASEBALL_TEAMS; $t++) {
        $data[] = [$s, $t];
    }
}

for ($s = 41; $s <= NUM_FOOTBALL_SEASONS + 40; $s++) {
    for($t = 1; $t <= NUM_FOOTBALL_TEAMS; $t++) {
        $data[] = [$s, $t];
    }
}

for ($s = 61; $s <= NUM_BASKETBALL_SEASONS + 60; $s++) {
    for($t = 1; $t <= NUM_BASKETBALL_TEAMS; $t++) {
        $data[] = [$s, $t];
    }
}

for ($s = 81; $s <= NUM_SOCCER_SEASONS + 80; $s++) {
    for($t = 1; $t <= NUM_SOCCER_TEAMS; $t++) {
        $data[] = [$s, $t];
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
unset($value);

/* Players_Teams */

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
unset($value);