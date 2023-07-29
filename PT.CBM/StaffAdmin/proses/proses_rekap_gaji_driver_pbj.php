<?php
session_start();
include'koneksi.php';
if(!isset($_SESSION["login"])){
	header("Location: logout.php");
	exit;
}
$id=$_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account WHERE id_karyawan = '$id'");
$data1 = mysqli_fetch_array($result1);
$id1 = $data1['id_karyawan'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Staff Admin') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$table2 = mysqli_query($koneksipbj,"SELECT * FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY nama_driver");
  

$tanggal =$_POST['tanggal'];

while($data = mysqli_fetch_array($table2)){

    $nama_driver = $data['nama_driver'];
    $nama_rute =$data['nama_rute'];
    $table3 = mysqli_query($koneksipbj,"SELECT SUM(uang_gaji) AS uang_gaji_semen, SUM(rit) AS rit_semen FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver' AND nama_rute = 'Muat Semen'");
      $data3 = mysqli_fetch_array($table3);

      $total_gaji_semen = $data3['uang_gaji_semen'];
      if (  $total_gaji_semen == ""  ) {
        $total_gaji_semen = 0;
      }
      $total_rit_semen = $data3['rit_semen'];
      if (  $total_rit_semen == ""  ) {
        $total_rit_semen = 0;
      }
      

      $table4 = mysqli_query($koneksipbj,"SELECT SUM(uang_gaji) AS uang_gaji_batu , SUM(rit) AS rit_batu FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Muat Batu'");
      $data4 = mysqli_fetch_array($table4);

      $total_gaji_batu = $data4['uang_gaji_batu'];
      if (  $total_gaji_batu == ""  ) {
        $total_gaji_batu = 0;
      }

      $total_rit_batu = $data4['rit_batu'];
      if (  $total_rit_batu == ""  ) {
        $total_rit_batu = 0;
      }

    $total_gaji = $total_gaji_semen + $total_gaji_batu - 174480;
    $total_gaji_diterima =  $total_gaji_semen + $total_gaji_batu - 174480;

    $query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_driver_pbj VALUES('','$tanggal','$nama_driver','$total_rit_semen','$total_gaji_semen','$total_rit_batu','$total_gaji_batu',0,174480,173215,'$total_gaji',
                                                                        '$total_gaji_diterima','Transfer')");

}

if ($query != "") {
	echo "<script>alert('Proses Rekap Gaji Berhasil :)'); window.location='../view/VRekapGajiDriverPBJ';</script>";exit;

}

?>