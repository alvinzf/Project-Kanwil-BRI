<?php
// if (isset($_POST["refresh"])) {
require_once('./config.php');

$truncate = "TRUNCATE TABLE pemenuhan_casa_debitur";

if ($mysqli->query($truncate) === TRUE) {
    $type = "eror";
    $message = "Kesalahan Terjadi, silahkan coba lagi";
}

$fetch = "SELECT 
d.kode_kanca, 
d.nama_kanca, 
d.pn_ao, 
d.nama_ao, 
d.cif, 
d.nama_debitur, 
SUM(d.plafond) AS total_plafond, 
SUM(d.os) AS total_os, 
p.pn_fo, 
p.nama_fo 
FROM debitur d 
INNER JOIN `pairing-fo` p ON d.pn_ao = p.pn_ao 
GROUP BY d.kode_kanca, d.nama_kanca, d.pn_ao, d.nama_ao, d.cif, d.nama_debitur, p.pn_fo, p.nama_fo;";
$result = mysqli_query($mysqli, $fetch);


$truncate = "TRUNCATE TABLE pemenuhan_casa_debitur";

if ($mysqli->query($truncate) === TRUE) {
    $type = "eror";
    $message = "Kesalahan Terjadi, silahkan coba lagi";
}

while ($data = mysqli_fetch_array($result)) {
    $kode_kanca = $data['kode_kanca'];
    $nama_kanca = $data['nama_kanca'];
    $pn_ao = $data['pn_ao'];
    $nama_ao = $data['nama_ao'];
    $cif = $data['cif'];
    $nama_debitur = $data['nama_debitur'];
    $plafond = $data['total_plafond'];
    $os = $data['total_os'];
    $plafond_temp = (int)$data['total_plafond'];
    $os_temp = (int)$data['total_os'];

    if ($plafond_temp < 1000000000) {

        $syarat_casa = ($plafond_temp * 3) / 100;
    } else {
        $syarat_casa = ($plafond_temp * 5) / 100;
    }
    $syarat_casa = (int)($syarat_casa);

    $pn_fo = $data['pn_fo'];
    $nama_fo = $data['nama_fo'];
    $query = "INSERT INTO pemenuhan_casa_debitur(kode_kanca, nama_kanca, pn_ao, nama_ao, cif, nama_debitur, plafond, os, syarat_casa, pn_fo, nama_fo) VALUES('$kode_kanca', '$nama_kanca', '$pn_ao', '$nama_ao', '$cif', '$nama_debitur', '$plafond', '$os', '$syarat_casa', '$pn_fo', '$nama_fo' )";
    if ($mysqli->query($query) === TRUE) {
        $type = "success";
        $message = "Data berhasil diimport";
    } else {
        $type = "error";
        echo "<script>alert('Gagal mengambil Data');</script>";
    }
}
// echo "<script>alert('Refresh Berhasil');</script>";
header("Location: http://vyzyz/Dev/index.php");
?>

// }