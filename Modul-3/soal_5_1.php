<?php
// Soal 5.1 - Array multidimensi
function tampilData($label, $arr) {
    echo $label . "<br>students = (<br>";
    $n = count($arr);
    for ($i = 0; $i < $n; $i++) {
        $row = "(\"" . $arr[$i][0] . "\", \"" . $arr[$i][1] . "\", \"" . $arr[$i][2] . "\")";
        echo $row . ($i < $n - 1 ? "," : "") . "<br>";
    }
    echo ")<br><br>";
}

$students = array(
    array("Alex",    "220401", "0812345678"),
    array("Bianca",  "220402", "0812345687"),
    array("Candice", "220403", "0812345665")
);

tampilData("Data awal:", $students);

// Menambah lima data lain
$students[] = array("Daniel", "220404", "0812345611");
$students[] = array("Elena",  "220405", "0812345622");
$students[] = array("Fiona",  "220406", "0812345633");
$students[] = array("Gabe",   "220407", "0812345644");
$students[] = array("Hannah", "220408", "0812345655");

tampilData("Data setelah ditambah 5 data lain:", $students);

// Tampilkan dalam bentuk tabel
echo "<table border='1' cellpadding='2' cellspacing='0'>";
echo "<tr><th>Name</th><th>NIM</th><th>Mobile</th></tr>";
foreach ($students as $s) {
    echo "<tr><td>" . $s[0] . "</td><td>" . $s[1] . "</td><td>" . $s[2] . "</td></tr>";
}
echo "</table>";
?>
