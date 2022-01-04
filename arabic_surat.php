<?php
header('Content-Type: text/html; charset=utf-8');

$con = mysqli_connect("localhost", "root", "", "al-quran") or die("could not connect database");
$con->set_charset("utf8");
$json = file_get_contents('https://al-quran-8d642.firebaseio.com/data.json?print=pretty');
$obj = json_decode($json);

foreach ($obj as $r) {

    $stmt = $con->prepare("insert into surat (arti, asma, audio, ayat, keterangan, nama, nomor, rukuk, type, urut) values (?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssssss", $r->arti, $r->asma, $r->audio, $r->ayat, $r->keterangan, $r->nama, $r->nomor, $r->rukuk, $r->type, $r->urut);

    $stmt->execute();
    $stmt->close();
}
echo mysqli_error($con);
