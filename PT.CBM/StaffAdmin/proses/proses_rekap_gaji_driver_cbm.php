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
$table2 = mysqli_query($koneksi,"SELECT * FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY nama_driver");
  

$tanggal =$_POST['tanggal'];

while($data = mysqli_fetch_array($table2)){

    $nama_driver = $data['nama_driver'];
    $nama_rute =$data['nama_rute'];
    $table3 = mysqli_query($koneksi,"SELECT SUM(uang_gaji) AS uang_gaji_nje, SUM(rit) AS rit_nje FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver' AND nama_rute = 'NJE'");
    $data3 = mysqli_fetch_array($table3);
    $total_gaji_nje = $data3['uang_gaji_nje'];
    if (  $total_gaji_nje == ""  ) {
      $total_gaji_nje = 0;
    }
    $total_rit_nje = $data3['rit_nje'];
    if (  $total_rit_nje == ""  ) {
      $total_rit_nje = 0;
    }
    

    $table4 = mysqli_query($koneksi,"SELECT SUM(uang_gaji) AS uang_gaji_gas_palembang , SUM(rit) AS rit_gas_palembang FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Gas Palembang'");
    $data4 = mysqli_fetch_array($table4);

    $total_uang_gaji_gas_palembang = $data4['uang_gaji_gas_palembang'];
    if (  $total_uang_gaji_gas_palembang == ""  ) {
      $total_uang_gaji_gas_palembang = 0;
    }

    $total_rit_gas_palembang = $data4['rit_gas_palembang'];
    if (  $total_rit_gas_palembang == ""  ) {
      $total_rit_gas_palembang = 0;
    }
    $total_gaji = $total_gaji_nje + $total_uang_gaji_gas_palembang;
    $total_gaji_diterima =  $total_gaji_nje + $total_uang_gaji_gas_palembang - 203560;

    $table5 = mysqli_query($koneksi, "SELECT SUM(jumlah_bon) AS total_bon FROM bon_karyawan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_karyawan = '$nama_driver' ");
    $data5 = mysqli_fetch_array($table5);
    if (!isset($data5['total_bon'])) {
        $angsuran_bon_bulanan = 0;
      }
      else{
        $angsuran_bon_bulanan = $data5['total_bon'];
      }

    $query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_driver_cbm VALUES('','$tanggal','$nama_driver','Driver','$total_rit_nje','$total_gaji_nje','$total_rit_gas_palembang','$total_uang_gaji_gas_palembang',173215,203560,'$angsuran_bon_bulanan','$total_gaji',
                                                                        '$total_gaji_diterima','Transfer')");

}

if ($query != "") {
	echo "<script>alert('Proses Rekap Gaji Berhasil :)'); window.location='../view/VRekapGajiDriverCBM';</script>";exit;

}

?>