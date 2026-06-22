<?php

$stats = [];

if (file_exists('visitors.log')) {

    $rows = file('visitors.log');

    foreach ($rows as $row) {

        $data = json_decode($row, true);

        if (!$data) continue;

        $region = $data['region'];

        if (!isset($stats[$region])) {
            $stats[$region] = 0;
        }

        $stats[$region]++;
    }
}

arsort($stats);

echo "<h2>Statistik Pengunjung per Provinsi</h2>";

foreach ($stats as $region => $count) {
    echo htmlspecialchars($region) . " : " . $count . "<br>";
}
?>