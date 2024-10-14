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
    $table3 = mysqli_query($koneksipbr,"SELECT SUM(uang_gaji) AS uang_gaji_ppe, SUM(rit) AS rit_ppe FROM laporan_rit_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver' AND nama_rute = 'PPE'");
      $data3 = mysqli_fetch_array($table3);
      $total_gaji_ppe = $data3['uang_gaji_ppe'];
      if (  $total_gaji_ppe == ""  ) {
        $total_gaji_ppe = 0;
      }
      $total_rit_ppe = $data3['rit_ppe'];
      if (  $total_rit_ppe == ""  ) {
        $total_rit_ppe = 0;
      }
      

      $table4 = mysqli_query($koneksipbr,"SELECT SUM(uang_gaji) AS uang_gaji_pap , SUM(rit) AS rit_pap FROM laporan_rit_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'PAP'");
      $data4 = mysqli_fetch_array($table4);

      $total_gaji_pap = $data4['uang_gaji_pap'];
      if (  $total_gaji_pap == ""  ) {
        $total_gaji_pap = 0;
      }

      $total_rit_pap = $data4['rit_pap'];
      if (  $total_rit_pap == ""  ) {
        $total_rit_pap = 0;
      }

      $table5 = mysqli_query($koneksipbr,"SELECT SUM(uang_gaji) AS uang_gaji_nje , SUM(rit) AS rit_nje FROM laporan_rit_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'NJE'");
      $data5 = mysqli_fetch_array($table5);

      $total_gaji_nje = $data5['uang_gaji_nje'];
      if (  $total_gaji_nje == ""  ) {
        $total_gaji_nje = 0;
      }

      $total_rit_nje = $data5['rit_nje'];
      if (  $total_rit_nje == ""  ) {
        $total_rit_nje = 0;
      }

      $table8 = mysqli_query($koneksipbr,"SELECT bpjs_kesehatan , bpjs_ketenagakerjaan FROM driver WHERE nama_driver = '$nama_driver' ");
      $data8 = mysqli_fetch_array($table8);
  
  

      if($nama_driver == 'TOLIP WIJAYADI' || $nama_driver == 'Wayan Edi' || $nama_driver == 'JUHARSA'){
        $bpjs_kesehatan = 0;
        $bpjs_ketenagakerjaan = 0;
      }else{
        $bpjs_kesehatan = $data8['bpjs_kesehatan'];
        $bpjs_ketenagakerjaan = $data8['bpjs_ketenagakerjaan'];
      }

    $total_gaji = $total_gaji_ppe + $total_gaji_pap + $total_gaji_nje;
    $total_gaji_diterima =  $total_gaji_ppe + $total_gaji_pap + $total_gaji_nje - $bpjs_ketenagakerjaan;

    $table6 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_bon) AS total_bon FROM bon_karyawan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'PBR' AND nama_karyawan = '$nama_driver' ");
    $data6 = mysqli_fetch_array($table6);
    if (!isset($data6['total_bon'])) {
        $angsuran_bon_bulanan = 0;
      }
      else{
        $angsuran_bon_bulanan = $data6['total_bon'];
      }


    $query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_driver_pbr VALUES('','$tanggal','$nama_driver','Driver','$total_rit_ppe','$total_gaji_ppe','$total_rit_pap','$total_gaji_pap','$total_rit_nje','$total_gaji_nje','$bpjs_kesehatan','$bpjs_ketenagakerjaan',0,'$angsuran_bon_bulanan','$total_gaji',
                                                                        '$total_gaji_diterima','Transfer')");

}

if ($query != "") {
	echo "<script>alert('Proses Rekap Gaji Berhasil :)'); window.location='../view/VRekapGajiDriverPBR';</script>";exit;

}

?>