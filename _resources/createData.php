<?php

$division = 1;
$player = 1;
$season = 1;
$team = 1;

$data = [];

for ($d = $division++; $d <= 6; $d++) {
    for ($p = $player++; $p <= 6; $p++) {
        for ($s = $season++; $s <= 6; $s++) {
            for ($t = $team++; $t <= 6; $t++) {
                $data[] = [$d, $p, $s, $t];
            }
            $data[] = [$d, $p, $s, $t];
        }
        $data[] = [$d, $p, $s, $t];
    }
    $data[] = [$d, $p, $s, $t];
}

$inserts = [];

foreach ($data as $key => $values) {
    $inserts[$key] =
            'INSERT INTO divisions_players_seasons_teams ' .
            '(division_id, player_id, season_id, team_id) ' .
            'VALUES (';
    foreach ($values as $key2 => $value) {
        $inserts[$key] .= $value;
        if ($key2 < count($values) - 1)
            $inserts[$key] .= ',';
    }
    $inserts[$key] .= ');';
}

foreach ($inserts as $value)
    echo $value . '<br>';