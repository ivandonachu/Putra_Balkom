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
$table2 = mysqli_query($koneksipbr,"SELECT * FROM laporan_rit_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY nama_driver");
  

$tanggal =$_POST['tanggal'];

while($data = mysqli_fetch_array($table2)){

    $nama_driver = $data['nama_driver'];
    $nama_rute =$data['nama_rute'];
    $table3 = mysqli_query($koneksipbr,"SELECT SUM(uang_gaji) AS uang_gaji_nje, SUM(rit) AS rit_nje FROM laporan_rit_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver' AND nama_rute = 'NJE'");
      $data3 = mysqli_fetch_array($table3);
      $total_gaji_nje = $data3['uang_gaji_nje'];
      if (  $total_gaji_nje == ""  ) {
        $total_gaji_nje = 0;
      }
      $total_rit_nje = $data3['rit_nje'];
      if (  $total_rit_nje == ""  ) {
        $total_rit_nje = 0;
      }
      

      $table4 = mysqli_query($koneksipbr,"SELECT SUM(uang_gaji) AS uang_gaji_pep , SUM(rit) AS rit_pep FROM laporan_rit_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'PPE'");
      $data4 = mysqli_fetch_array($table4);

      $total_gaji_pep = $data4['uang_gaji_pep'];
      if (  $total_gaji_pep == ""  ) {
        $total_gaji_pep = 0;
      }

      $total_rit_pep = $data4['rit_pep'];
      if (  $total_rit_pep == ""  ) {
        $total_rit_pep = 0;
      }
    $total_gaji = $total_gaji_nje + $total_gaji_pep;
    $total_gaji_diterima =  $total_gaji_nje + $total_gaji_pep - 203560;

    $query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_driver_pbr VALUES('','$tanggal','$nama_driver','Driver','$total_rit_nje','$total_gaji_nje','$total_rit_pep','$total_gaji_pep',173215,203560,0,'$total_gaji',
                                                                        '$total_gaji_diterima','Transfer')");

}

if ($query != "") {
	echo "<script>alert('Proses Rekap Gaji Berhasil :)'); window.location='../view/VRekapGajiDriverPBR';</script>";exit;

}

?>