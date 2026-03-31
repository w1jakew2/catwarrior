<?php
header("Content-Type: text/plain; charset=utf-8");

if (!isset($_GET['nimi']) || !isset($_GET['pisteet']) || !isset($_GET['taso'])) {
    echo "ERROR: missing parameters";
    exit;
}

$nimi = trim($_GET['nimi']);
$pisteet = intval($_GET['pisteet']);
$taso = intval($_GET['taso']);

$filename = "pisteet.txt";
$lines = file_exists($filename) ? file($filename, FILE_IGNORE_NEW_LINES) : [];

$found = false;
$new_lines = [];

foreach ($lines as $line) {
    list($n, $p, $t) = explode(":", $line);

    if ($n === $nimi) {
        // Pelaajalla on jo tulos → päivitä vain jos parempi
        if ($pisteet > intval($p)) {
            $new_lines[] = $nimi . ":" . $pisteet . ":" . $taso;
        } else {
            $new_lines[] = $line;
        }
        $found = true;
    } else {
        $new_lines[] = $line;
    }
}

// Jos pelaajaa ei löytynyt → lisää uusi rivi
if (!$found) {
    $new_lines[] = $nimi . ":" . $pisteet . ":" . $taso;
}

// Kirjoita koko tiedosto uudelleen
file_put_contents($filename, implode("\n", $new_lines) . "\n", LOCK_EX);

echo "OK";
?>
