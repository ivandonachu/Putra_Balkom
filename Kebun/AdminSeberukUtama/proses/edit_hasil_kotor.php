
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
if ($jabatan_valid == 'Admin Seberuk Utama') {

}

else{  header("Location: logout.php");
exit;
}

$penyadap_1 =$_POST['penyadap_1'];
$hasil_kotor_1 = $_POST['hasil_kotor_1'];
$penyadap_2 =$_POST['penyadap_2'];
$hasil_kotor_2 = $_POST['hasil_kotor_2'];
$penyadap_3 =$_POST['penyadap_3'];
$hasil_kotor_3 = $_POST['hasil_kotor_3'];
$penyadap_4 =$_POST['penyadap_4'];
$hasil_kotor_4 = $_POST['hasil_kotor_4'];
$penyadap_5 =$_POST['penyadap_5'];
$hasil_kotor_5 = $_POST['hasil_kotor_5'];
$penyadap_6 =$_POST['penyadap_6'];
$hasil_kotor_6 = $_POST['hasil_kotor_6'];
$penyadap_7 =$_POST['penyadap_7'];
$hasil_kotor_7 = $_POST['hasil_kotor_7'];
$penyadap_8 =$_POST['penyadap_8'];
$hasil_kotor_8 = $_POST['hasil_kotor_8'];
$penyadap_9 =$_POST['penyadap_9'];
$hasil_kotor_9 = $_POST['hasil_kotor_9'];
$penyadap_10 =$_POST['penyadap_10'];
$hasil_kotor_10 = $_POST['hasil_kotor_10'];


	$query1 = mysqli_query($koneksi,"UPDATE list_gaji_penyadap_seberuk SET hasil_kotor = '$hasil_kotor_1' WHERE nama_penyadap = '$penyadap_1'");
    $query2 = mysqli_query($koneksi,"UPDATE list_gaji_penyadap_seberuk SET hasil_kotor = '$hasil_kotor_2' WHERE nama_penyadap = '$penyadap_2'");
    $query3 = mysqli_query($koneksi,"UPDATE list_gaji_penyadap_seberuk SET hasil_kotor = '$hasil_kotor_3' WHERE nama_penyadap = '$penyadap_3'");
    $query4 = mysqli_query($koneksi,"UPDATE list_gaji_penyadap_seberuk SET hasil_kotor = '$hasil_kotor_4' WHERE nama_penyadap = '$penyadap_4'");
    $query5 = mysqli_query($koneksi,"UPDATE list_gaji_penyadap_seberuk SET hasil_kotor = '$hasil_kotor_5' WHERE nama_penyadap = '$penyadap_5'");
    $query6 = mysqli_query($koneksi,"UPDATE list_gaji_penyadap_seberuk SET hasil_kotor = '$hasil_kotor_6' WHERE nama_penyadap = '$penyadap_6'");
    $query7 = mysqli_query($koneksi,"UPDATE list_gaji_penyadap_seberuk SET hasil_kotor = '$hasil_kotor_7' WHERE nama_penyadap = '$penyadap_7'");
    $query8 = mysqli_query($koneksi,"UPDATE list_gaji_penyadap_seberuk SET hasil_kotor = '$hasil_kotor_8' WHERE nama_penyadap = '$penyadap_8'");
    $query9 = mysqli_query($koneksi,"UPDATE list_gaji_penyadap_seberuk SET hasil_kotor = '$hasil_kotor_9' WHERE nama_penyadap = '$penyadap_9'");
    $query10 = mysqli_query($koneksi,"UPDATE list_gaji_penyadap_seberuk SET hasil_kotor = '$hasil_kotor_10' WHERE nama_penyadap = '$penyadap_10'");



	echo "<script>alert('Data Berhasil di Ubah :)'); window.location='../view/VListGajiPenyadap';</script>";exit;



?>