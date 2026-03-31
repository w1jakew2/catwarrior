<?php
header("Content-Type: application/json; charset=utf-8");

$tiedosto = "pisteet.txt";
$tulokset = [];

if (file_exists($tiedosto)) {
    $rivit = file($tiedosto, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($rivit as $rivi) {
        list($nimi, $pisteet, $taso) = explode(":", $rivi);
        $tulokset[] = [
            "nimi" => $nimi,
            "pisteet" => intval($pisteet),
            "taso" => intval($taso)
        ];
    }
}

usort($tulokset, function($a, $b) {
    return $b["pisteet"] - $a["pisteet"];
});

echo json_encode(array_slice($tulokset, 0, 5));
?>
