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
$table2 = mysqli_query($koneksikebun,"SELECT * FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY nama_driver");

$tanggal =$_POST['tanggal'];

while($data2 = mysqli_fetch_array($table2)){

    $nama_driver = $data2['nama_driver'];
    $nama_rute =$data2['nama_rute'];
    //sawit dabuk
    $table3 = mysqli_query($koneksikebun,"SELECT SUM(uang_gaji) AS uang_gaji_sawit_dabuk, SUM(rit) AS rit_sawit_dabuk FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver' AND nama_rute = 'Muat Sawit Dabuk'");
    $data3 = mysqli_fetch_array($table3);
    $total_gaji_sawit_dabuk = $data3['uang_gaji_sawit_dabuk'];
    if (  $total_gaji_sawit_dabuk == ""  ) {
      $total_gaji_sawit_dabuk = 0;
    }
    $total_rit_sawit_dabuk = $data3['rit_sawit_dabuk'];
    if (  $total_rit_sawit_dabuk == ""  ) {
      $total_rit_sawit_dabuk = 0;
    }
    
    //pupuk_kepalembang

    $table4 = mysqli_query($koneksikebun,"SELECT SUM(uang_gaji) AS uang_gaji_pupuk_gudang , SUM(rit) AS rit_pupuk_gudang FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Muat Pupuk Ke Gudang'");
    $data4 = mysqli_fetch_array($table4);

    $total_gaji_pupuk_kegudang = $data4['uang_gaji_pupuk_gudang'];
    if (  $total_gaji_pupuk_kegudang == ""  ) {
      $total_gaji_pupuk_kegudang = 0;
    }

    $total_rit_pupuk_kegudang = $data4['rit_pupuk_gudang'];
    if (  $total_rit_pupuk_kegudang == ""  ) {
      $total_rit_pupuk_kegudang = 0;
    }


    //getah palembang
    $table5 = mysqli_query($koneksikebun,"SELECT SUM(uang_gaji) AS uang_gaji_getah_palembang , SUM(rit) AS rit_getah_palembang FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Muat Getah Palembang'");
    $data5 = mysqli_fetch_array($table5);

    $total_gaji_getah_palembang = $data5['uang_gaji_getah_palembang'];
    if (  $total_gaji_getah_palembang == ""  ) {
      $total_gaji_getah_palembang = 0;
    }

    $total_rit_getah_palembang = $data5['rit_getah_palembang'];
    if (  $total_rit_getah_palembang == ""  ) {
      $total_rit_getah_palembang = 0;
    }

    //muat nipah
    $table6 = mysqli_query($koneksikebun,"SELECT SUM(uang_gaji) AS uang_gaji_muat_nipah , SUM(rit) AS rit_muat_nipah FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Muat Nipah'");
    $data6 = mysqli_fetch_array($table6);

    $total_gaji_muat_nipah = $data6['uang_gaji_muat_nipah'];
    if (  $total_gaji_muat_nipah == ""  ) {
      $total_gaji_muat_nipah = 0;
    }

    $total_rit_muat_nipah = $data6['rit_muat_nipah'];
    if (  $total_rit_muat_nipah == ""  ) {
      $total_rit_muat_nipah = 0;
    }

    // kebun lengkiti
    $table7 = mysqli_query($koneksikebun,"SELECT SUM(uang_gaji) AS uang_gaji_kebun_lengkiti , SUM(rit) AS rit_kebun_lengkiti FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Muat Pupuk Kebun Lengkiti'");
    $data7 = mysqli_fetch_array($table7);

    $total_gaji_kebun_lengkiti = $data7['uang_gaji_kebun_lengkiti'];
    if (  $total_gaji_kebun_lengkiti == ""  ) {
      $total_gaji_kebun_lengkiti = 0;
    }

    $total_rit_kebun_lengkiti = $data7['rit_kebun_lengkiti'];
    if (  $total_rit_kebun_lengkiti == ""  ) {
      $total_rit_kebun_lengkiti = 0;
    }
          // muat batu
          $table8 = mysqli_query($koneksikebun,"SELECT SUM(uang_gaji) AS uang_gaji_batu , SUM(rit) AS rit_batu FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Muat Batu'");
          $data8 = mysqli_fetch_array($table8);
    
          $total_gaji_batu = $data8['uang_gaji_batu'];
          if (  $total_gaji_batu == ""  ) {
            $total_gaji_batu = 0;
          }
    
          $total_rit_batu = $data8['rit_batu'];
          if (  $total_rit_batu == ""  ) {
            $total_rit_batu = 0;
          }

    $total_gaji = $total_gaji_sawit_dabuk + $total_gaji_getah_palembang + $total_gaji_pupuk_kegudang + $total_gaji_muat_nipah + $total_gaji_kebun_lengkiti + $total_gaji_batu;
    $total_gaji_diterima = $total_gaji_sawit_dabuk + $total_gaji_getah_palembang + $total_gaji_pupuk_kegudang + $total_gaji_muat_nipah + $total_gaji_kebun_lengkiti + $total_gaji_batu;


$query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_driver_kebun VALUES('','$tanggal','$nama_driver','Driver','$total_rit_sawit_dabuk','$total_gaji_sawit_dabuk','$total_rit_getah_palembang','$total_gaji_getah_palembang','$total_rit_pupuk_kegudang','$total_gaji_pupuk_kegudang',
                                                                        '$total_rit_muat_nipah','$total_gaji_muat_nipah','$total_rit_kebun_lengkiti','$total_gaji_kebun_lengkiti','$total_rit_batu','$total_gaji_batu','$total_gaji','$total_gaji_diterima','Transfer')");

}

if ($query != "") {
	echo "<script>alert('Proses Rekap Gaji Berhasil :)'); window.location='../view/VRekapGajiDriverKebun';</script>";exit;

}

?>