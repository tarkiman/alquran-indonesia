<?php
header('Content-Type: text/html; charset=utf-8');

$json = file_get_contents('https://al-quran-8d642.firebaseio.com/data.json?print=pretty');
$obj = json_decode($json);

foreach ($obj as $i) {

    $con = mysqli_connect("localhost", "root", "", "al-quran") or die("could not connect database");
    $con->set_charset("utf8");

    $json2 = file_get_contents('https://al-quran-8d642.firebaseio.com/surat/' . $i->nomor . '.json?print=pretty');
    $obj2 = json_decode($json2);

    foreach ($obj2 as $r) {

        $stmt = $con->prepare("insert into ayat (ar, arti, nomor, tr, id_surat) values (?,?,?,?,?)");
        $stmt->bind_param("sssss", $r->ar, $r->id, $r->nomor, $r->tr, $i->nomor);

        $stmt->execute();
        $stmt->close();
    }

    $con->close();
}
// echo mysqli_error($con);
