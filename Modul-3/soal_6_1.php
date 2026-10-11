<?php
// Soal 6.1 - Array function

// array_push()
$a = array("A");
echo "Array awal: (\"A\")<br>";
array_push($a, "B");
echo "Hasil array_push: " . implode(" ", $a) . "<br><br>";

// array_merge()
$b1 = array("A", "B");
$b2 = array("C");
echo "Array awal: (\"A\", \"B\") digabung dengan (\"C\")<br>";
echo "Hasil array_merge: " . implode(" ", array_merge($b1, $b2)) . "<br><br>";

// array_values()
$c = array("x" => 1, "y" => 2);
echo "Array awal: (\"x\" => 1, \"y\" => 2)<br>";
echo "Hasil array_values: " . implode(" ", array_values($c)) . "<br><br>";

// array_search()
$d = array("A", "B", "C");
echo "Mencari \"B\" pada array: (\"A\", \"B\", \"C\")<br>";
echo "Hasil array_search: " . array_search("B", $d) . "<br><br>";

// array_filter() - membuang nilai yang dianggap kosong (false, "", 0, null)
$e = array(0, 1, false, 2, "", 3, "array");
echo "Array awal: (0, 1, false, 2, \"\", 3, \"array\")<br>";
echo "Hasil array_filter: " . implode(" ", array_filter($e)) . "<br><br>";

// sort() dan rsort() - array terindeks
$f = array(3, 1, 2);
echo "Array awal: (3, 1, 2)<br>";
sort($f);
echo "Hasil sort: " . implode(" ", $f) . "<br>";
rsort($f);
echo "Hasil rsort: " . implode(" ", $f) . "<br><br>";

// asort(), ksort(), arsort(), krsort() - array asosiatif
$g = array("Peter" => 35, "Ben" => 37, "Joe" => 43);
echo "Array awal: (\"Peter\"=>35, \"Ben\"=>37, \"Joe\"=>43)<br>";

function cetak($label, $arr) {
    echo $label;
    foreach ($arr as $k => $v) {
        echo " $k=> $v,";
    }
    echo "<br>";
}

$t = $g; asort($t);  cetak("Hasil asort:", $t);
$t = $g; ksort($t);  cetak("Hasil ksort:", $t);
$t = $g; arsort($t); cetak("Hasil arsort:", $t);
$t = $g; krsort($t); cetak("Hasil krsort:", $t);
?>
