<?php
// Soal 3.1 (a) - Array asosiatif $height: tambah lima data, hapus satu data,
// tampilkan nilai dengan indeks (key) terakhir
function tampilArray($nama, $arr) {
    $out = array();
    foreach ($arr as $k => $v) {
        $out[] = "\"$k\"=>\"$v\"";
    }
    echo $nama . " = (" . implode(", ", $out) . ")<br>";
}

$height = array("Andy" => "176", "Barry" => "165", "Charlie" => "170");

// Menambah lima data baru
$height["David"]  = "180";
$height["Ethan"]  = "172";
$height["Frank"]  = "168";
$height["George"] = "175";
$height["Harry"]  = "182";

tampilArray("height", $height);
echo "Nilai dengan indeks terakhir: " . end($height) . "<br><br>";

// Menghapus satu data tertentu (Barry)
unset($height["Barry"]);

tampilArray("height", $height);
echo "Nilai dengan indeks terakhir setelah dihapus: " . end($height);
?>
