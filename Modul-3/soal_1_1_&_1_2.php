<?php
// Soal 1.1 - Tambah lima data baru, tampilkan nilai dengan indeks tertinggi
$fruits = array("Avocado", "Blueberry", "Cherry");

// Menambahkan lima data baru
array_push($fruits, "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

echo "fruits = (\"" . implode("\", \"", $fruits) . "\")<br>";

// Indeks tertinggi = jumlah data - 1
$lastIndex = count($fruits) - 1;
echo "Nilai dengan indeks tertinggi: " . $fruits[$lastIndex];
?>
