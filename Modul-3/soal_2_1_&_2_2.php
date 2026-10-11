<?php
// Soal 2.1 - Tambah lima data dengan perulangan for, tampilkan panjang & isi array
$fruits = array("Avocado", "Blueberry", "Cherry");

// Menambah lima data baru dengan for
for ($i = 1; $i <= 5; $i++) {
    $fruits[] = "Buah Tambahan " . $i;
}

$arrlength = count($fruits);
echo "Panjang array saat ini: " . $arrlength . "<br><br>";

// Skrip perulangan asli (baris #5-#8) tidak perlu diubah
for ($x = 0; $x < $arrlength; $x++) {
    echo $fruits[$x];
    echo "<br>";
}
?>
