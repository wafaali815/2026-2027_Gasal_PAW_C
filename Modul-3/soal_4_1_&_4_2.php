<?php
// Soal 4.1 - Tambah lima data ke $height, tampilkan semua dengan perulangan
// $height = array("Andy" => "176", "Barry" => "165", "Charlie" => "170");

// $height["David"]  = "180";
// $height["Ethan"]  = "172";
// $height["Frank"]  = "168";
// $height["George"] = "175";
// $height["Harry"]  = "182";

// $out = array();
// foreach ($height as $k => $v) {
//     $out[] = "\"$k\"=>\"$v\"";
// }
// echo "height = (" . implode(", ", $out) . ")<br><br>";

// foreach ($height as $name => $cm) {
//     echo $name . " is " . $cm . " cm tall.<br>";
// }

// Soal 4.2 - Array $weight, tampilkan seluruh data dengan struktur FOR
$weight = array("Andy" => "70", "Barry" => "65", "Charlie" => "75");

$out = array();
foreach ($weight as $k => $v) {
    $out[] = "\"$k\"=>\"$v\"";
}
echo "weight = (" . implode(", ", $out) . ")<br><br>";

$keys = array_keys($weight);
$n = count($keys);
for ($i = 0; $i < $n; $i++) {
    echo $keys[$i] . " is " . $weight[$keys[$i]] . " kg.<br>";
}
?>
