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

    
    $table5 = mysqli_query($koneksi,"SELECT SUM(uang_gaji) AS uang_gaji_nikan , SUM(rit) AS rit_nikan FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Nikan'");
    $data5 = mysqli_fetch_array($table5);

    $total_uang_gaji_nikan = $data5['uang_gaji_nikan'];
    if (  $total_uang_gaji_nikan == ""  ) {
      $total_uang_gaji_nikan = 0;
    }

    $total_rit_nikan = $data5['rit_nikan'];
    if (  $total_rit_nikan == ""  ) {
      $total_rit_nikan = 0;
    }

    $table6 = mysqli_query($koneksi,"SELECT SUM(uang_gaji) AS uang_gaji_kota_baru , SUM(rit) AS rit_kota_baru FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Kota Baru'");
    $data6 = mysqli_fetch_array($table6);

    $total_uang_gaji_kota_baru = $data6['uang_gaji_kota_baru'];
    if (  $total_uang_gaji_kota_baru == ""  ) {
      $total_uang_gaji_kota_baru = 0;
    }

    $total_rit_kota_baru = $data6['rit_kota_baru'];
    if (  $total_rit_kota_baru == ""  ) {
      $total_rit_kota_baru = 0;
    }

    $table7 = mysqli_query($koneksi,"SELECT SUM(uang_gaji) AS uang_gaji_batu_marta , SUM(rit) AS rit_batu_marta FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Batu Marta'");
    $data7 = mysqli_fetch_array($table7);

    $total_uang_gaji_batu_marta = $data7['uang_gaji_batu_marta'];
    if (  $total_uang_gaji_batu_marta == ""  ) {
      $total_uang_gaji_batu_marta = 0;
    }

    $total_rit_batu_marta = $data7['rit_batu_marta'];
    if (  $total_rit_batu_marta == ""  ) {
      $total_rit_batu_marta = 0;
    }

    $table9 = mysqli_query($koneksi,"SELECT SUM(uang_gaji) AS uang_gaji_bantu_tabung_pertamina , SUM(rit) AS rit_bantu_tabung_pertamina FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Bantu Tabung Pertamina'");
    $data9 = mysqli_fetch_array($table9);

    $total_uang_gaji_bantu_tabung_pertamina= $data9['uang_gaji_bantu_tabung_pertamina'];
    if (  $total_uang_gaji_bantu_tabung_pertamina == ""  ) {
      $total_uang_gaji_bantu_tabung_pertamina = 0;
    }

    $total_rit_bantu_tabung_pertamina = $data9['rit_bantu_tabung_pertamina'];
    if (  $total_rit_bantu_tabung_pertamina == ""  ) {
      $total_rit_bantu_tabung_pertamina = 0;
    }

    $table10 = mysqli_query($koneksi,"SELECT SUM(uang_gaji) AS uang_gaji_melati , SUM(rit) AS rit_melati FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Melati'");
    $data10 = mysqli_fetch_array($table10);

    $total_uang_melati= $data10['uang_gaji_melati'];
    if (  $total_uang_melati == ""  ) {
      $total_uang_melati = 0;
    }

    $total_rit_melati = $data10['rit_melati'];
    if (  $total_rit_melati == ""  ) {
      $total_rit_melati = 0;
    }

    $table11 = mysqli_query($koneksi,"SELECT SUM(uang_gaji) AS uang_gaji_lampung , SUM(rit) AS rit_lampung FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Lampung'");
    $data11 = mysqli_fetch_array($table11);

    $total_uang_lampung= $data11['uang_gaji_lampung'];
    if (  $total_uang_lampung == ""  ) {
      $total_uang_lampung = 0;
    }

    $total_rit_lampung = $data11['rit_lampung'];
    if (  $total_rit_lampung == ""  ) {
      $total_rit_lampung = 0;
    }
    
    $table8 = mysqli_query($koneksi,"SELECT bpjs_kesehatan , bpjs_ketenagakerjaan FROM driver WHERE nama_driver = '$nama_driver' ");
    $data8 = mysqli_fetch_array($table8);

    $bpjs_kesehatan = $data8['bpjs_kesehatan'];
    $bpjs_ketenagakerjaan = $data8['bpjs_ketenagakerjaan'];

    
    

    $total_gaji = $total_uang_gaji_gas_palembang + $total_gaji_nje + $total_uang_melati + $total_uang_gaji_nikan + $total_uang_gaji_kota_baru + $total_uang_gaji_batu_marta + $total_uang_gaji_bantu_tabung_pertamina + $total_uang_lampung;
    $total_gaji_diterima =  $total_uang_gaji_gas_palembang + $total_gaji_nje + $total_uang_melati + $total_uang_lampung +  $total_uang_gaji_nikan + $total_uang_gaji_kota_baru + $total_uang_gaji_batu_marta + $total_uang_gaji_bantu_tabung_pertamina - $bpjs_ketenagakerjaan;

    $table8 = mysqli_query($koneksi, "SELECT SUM(jumlah_bon) AS total_bon FROM bon_karyawan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_karyawan = '$nama_driver' ");
    $data8 = mysqli_fetch_array($table8);
    if (!isset($data8['total_bon'])) {
        $angsuran_bon_bulanan = 0;
      }
      else{
        $angsuran_bon_bulanan = $data8['total_bon'];
      }

    $query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_driver_cbm VALUES('','$tanggal','$nama_driver','Driver','$total_rit_nje','$total_gaji_nje','$total_rit_gas_palembang','$total_uang_gaji_gas_palembang'
                                                                             ,'$total_rit_nikan','$total_uang_gaji_nikan','$total_rit_kota_baru','$total_uang_gaji_kota_baru','$total_rit_batu_marta'
                                                                             ,'$total_uang_gaji_batu_marta', '$total_rit_bantu_tabung_pertamina' ,'$total_uang_gaji_bantu_tabung_pertamina' , '$total_rit_melati' ,'$total_uang_melati'
                                                                             , '$total_rit_lampung' ,'$total_uang_lampung'
                                                                             ,0,'$bpjs_kesehatan','$bpjs_ketenagakerjaan','$angsuran_bon_bulanan',0,'$total_gaji','$total_gaji_diterima','Transfer')");

}

if ($query != "") {
	echo "<script>alert('Proses Rekap Gaji Berhasil :)'); window.location='../view/VRekapGajiDriverCBM';</script>";exit;

}

?>