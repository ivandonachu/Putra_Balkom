<?php
session_start();
include'koneksi.php';
if(!isset($_SESSION["login"])){
  header("Location: logout.php");
  exit;
}
$id=$_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksicbm, "SELECT * FROM super_account WHERE username = '$id'");
$data1 = mysqli_fetch_array($result1);
$nama = $data1['nama_pemilik'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Direktur Utama') {

}

else{ header("Location: logout.php");
exit;
}



if (isset($_GET['tanggal1'])) {
 $tanggal_awal = $_GET['tanggal1'];
 $tanggal_akhir = $_GET['tanggal2'];
 $bulan_sebelum_awal = date('Y-m-d', strtotime('-1 month', strtotime($tanggal_awal))); 
 $bulan_sebelum_akhir =  date('Y-m-d', strtotime('-1 month', strtotime($tanggal_akhir))); 
 $lokasi = $_GET['lokasi'];
} 

elseif (isset($_POST['tanggal1'])) {
 $tanggal_awal = $_POST['tanggal1'];
 $tanggal_akhir = $_POST['tanggal2'];
 $bulan_sebelum_awal = date('Y-m-d', strtotime('-1 month', strtotime($tanggal_awal))); 
 $bulan_sebelum_akhir =  date('Y-m-d', strtotime('-1 month', strtotime($tanggal_akhir))); 
 $lokasi = $_POST['lokasi'];
} 


function formatuang($angka){
  $uang = "Rp " . number_format($angka,2,',','.');
  return $uang;
}

function formatjumlah($angka){
    $uang =  number_format($angka,2,',','.');
    return $uang;
  }

if ($tanggal_awal == $tanggal_akhir) {



  // Penjualan Pertamax
  $table = mysqli_query($koneksiperta, "SELECT qty , harga FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal' AND nama_barang = 'Pertamax' AND b.lokasi = '$lokasi' ");
  
  $total_pertamax=0;
  while($data = mysqli_fetch_array($table)){
    $qty = $data['qty'];
    $harga = $data['harga'];
    $uang_diskon = $data['uang_diskon'];
    $total_pertamax = ($total_pertamax + ($qty * $harga)) - $uang_diskon ;

  }

   // Penjualan Dexlite
  $table2 = mysqli_query($koneksiperta, "SELECT qty , harga FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal' AND nama_barang = 'Dexlite' AND b.lokasi = '$lokasi' ");
  
  $total_dexlite=0;
  while($data2 = mysqli_fetch_array($table2)){
    $qty = $data2['qty'];
    $harga = $data2['harga'];
    $uang_diskon = $data['uang_diskon'];
    $total_dexlite = ($total_dexlite + ($qty * $harga)) - $uang_diskon ;

  }

  //ngecor Pertamax

  $tablex1 = mysqli_query($koneksiperta, "SELECT SUM(total) AS total_cor FROM ngecor  WHERE tanggal = '$tanggal_awal' AND nama_barang = 'Pertamax' AND lokasi_cor = '$lokasi' ");
  
  $datax1 = mysqli_fetch_array($tablex1);
  $total_ngecor_max = $datax1['total_cor'];


  //ngecor Dexlite
  $tablex2 = mysqli_query($koneksiperta, "SELECT SUM(total) AS total_cor FROM ngecor  WHERE tanggal = '$tanggal_awal' AND nama_barang = 'Dexlite' AND lokasi_cor = '$lokasi' ");

  $datax2 = mysqli_fetch_array($tablex2);
  $total_ngecor_dex = $datax1['total_cor'];



  //dividen pertamax
$table100 = mysqli_query($koneksiperta, "SELECT  SUM(qty) AS total_terjual FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_barang = 'Pertamax' AND b.lokasi = '$lokasi' ");
$data100 = mysqli_fetch_array($table100);
$total_terjual = $data100['total_terjual'];

if($lokasi == 'Bedilan' ){
    $dividen_pertamax = $total_terjual * 150;
}
elseif($lokasi == 'Sumber Jaya' || $lokasi == 'Nusa Bakti'){
    $dividen_pertamax = $total_terjual * 50;
}
else{
    $dividen_pertamax = 0;
}

//dividen Dexlite
$table101 = mysqli_query($koneksiperta, "SELECT  SUM(qty) AS total_terjual FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_barang = 'Dexlite' AND b.lokasi = '$lokasi' ");
$data101 = mysqli_fetch_array($table101);
$total_terjual = $data101['total_terjual'];

if($lokasi == 'Bedilan' ){
    $dividen_Dexlite = $total_terjual * 150;
}
elseif($lokasi == 'Sumber Jaya' || $lokasi == 'Nusa Bakti'){
    $dividen_Dexlite = $total_terjual * 50;
}
else{
    $dividen_Dexlite = 0;
}


  $total_pendapatan = $total_pertamax + $total_dexlite + $total_cor_pertamax + $total_cor_dexlite - ($dividen_pertamax + $dividen_Dexlite);


    // Pembelian Pertamax
  $table3 = mysqli_query($koneksiperta, "SELECT qty , harga FROM pembelian  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal' AND nama_barang = 'Pertamax' AND b.lokasi = '$lokasi' ");
  
  $total_pertamax_b=0;
  while($data3 = mysqli_fetch_array($table3)){
    $qty = $data3['qty'];
    $harga = $data3['harga'];
    $pembelian_pertamax = $pembelian_pertamax + $qty;
    $total_pertamax_b = $total_pertamax_b + ($qty * $harga);

  }

   // Pembelian Dexlite
  $table4 = mysqli_query($koneksiperta, "SELECT qty , harga FROM pembelian  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal' AND nama_barang = 'Dexlite'  AND b.lokasi = '$lokasi' ");
  
  $total_dexlite_b=0;
  while($data4 = mysqli_fetch_array($table4)){
    $qty = $data4['qty'];
    $harga = $data4['harga'];
    $pembelian_dexlite = $pembelian_dexlite + $qty;
    $total_dexlite_b = $total_dexlite_b + ($qty * $harga);

  }

  $total_harga_pokok_penjualan = $total_pertamax_b + $total_dexlite_b;
  $laba_kotor = $total_pendapatan - $total_harga_pokok_penjualan;

  //pengeluran Biaya Kantor
   $table3 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE   tanggal = '$tanggal_awal' AND nama_akun = 'Biaya Kantor' AND b.lokasi = '$lokasi'  ");
   $data3 = mysqli_fetch_array($table3);
   $jml_biaya_kantor = $data3['jumlah_biaya_kantor'];
    if (!isset($data3['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor = 0;
    }

   //pengeluran Listrik & Telepon
   $table4 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE  tanggal = '$tanggal_awal' AND nama_akun = 'Listrik & Telepon' AND b.lokasi = '$lokasi'  ");
   $data4 = mysqli_fetch_array($table4);
   $jml_listrik = $data4['jumlah_listrik'];
    if (!isset($data4['jumlah_listrikr'])) {
    $jml_listrik = 0;
    }

   //pengeluran Biaya Sewa
   $table5 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE  tanggal = '$tanggal_awal' AND nama_akun = 'Biaya Sewa'  AND b.lokasi = '$lokasi'  ");
   $data5 = mysqli_fetch_array($table5);
   $jml_sewa = $data5['jumlah_sewa'];
    if (!isset($data5['jumlah_sewa'])) {
    $jml_sewa = 0;
    }

   //pengeluran Alat Tulis Kantor
   $table6 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE   tanggal = '$tanggal_awal' AND nama_akun = 'Alat Tulis Kantor'  ");
   $data6 = mysqli_fetch_array($table6);
   $jml_atk = $data6['jumlah_atk'];
    if (!isset($data6['jumlah_atk'])) {
    $jml_atk = 0;
    }

    $total_biaya_usaha_final = $jml_biaya_kantor + $jml_listrik + $jml_sewa + $jml_sewa;

    $laba_bersih_sebelum_pajak = $laba_kotor - $total_biaya_usaha_final;

}

else{



  // Penjualan Pertamax
  $table = mysqli_query($koneksiperta, "SELECT qty , harga FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_barang = 'Pertamax' AND b.lokasi = '$lokasi' ");
  
  $total_pertamax=0;
  $pertamax_terjual=0;
  while($data = mysqli_fetch_array($table)){
    $qty = $data['qty'];
    $harga = $data['harga'];
    $uang_diskon = $data['uang_diskon'];
    $pertamax_terjual = $pertamax_terjual + $qty;
    $total_pertamax = ($total_pertamax + ($qty * $harga)) - $uang_diskon ;


  }

   // Penjualan Dexlite
  $table2 = mysqli_query($koneksiperta, "SELECT qty , harga FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_barang = 'Dexlite' AND b.lokasi = '$lokasi' ");
  
  $total_dexlite=0;
  $dexlite_terjual = 0;
  while($data2 = mysqli_fetch_array($table2)){
    $qty = $data2['qty'];
    $harga = $data2['harga'];
    $uang_diskon = $data['uang_diskon'];
    $dexlite_terjual = $dexlite_terjual + $qty;
    $total_dexlite = ($total_dexlite + ($qty * $harga)) - $uang_diskon ;
  }
   //ngecor Pertamax
   $tablex1 = mysqli_query($koneksiperta, "SELECT SUM(total) AS total_cor, SUM(jumlah) AS qty_cor FROM ngecor  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_barang = 'Pertamax' AND lokasi_cor = '$lokasi' ");
  
   $datax1 = mysqli_fetch_array($tablex1);
   
   $total_ngecor_max = $datax1['total_cor'];
   $qty_ngecor_max = $datax1['qty_cor'];
 
   //ngecor Dexlite
   $tablex2 = mysqli_query($koneksiperta, "SELECT SUM(total) AS total_cor , SUM(jumlah) AS qty_cor FROM ngecor  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_barang = 'Dexlite' AND lokasi_cor = '$lokasi' ");
 
   $datax2 = mysqli_fetch_array($tablex2);
   $total_ngecor_dex = $datax2['total_cor'];
   $qty_ngecor_dex = $datax2['qty_cor'];


   //Sisa stok pertamax

   $tabley1 = mysqli_query($koneksiperta, "SELECT MAX(no_penjualan) AS penjualan_akhir FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_barang = 'Pertamax' AND b.lokasi = '$lokasi' ");

   $datay1 = mysqli_fetch_array($tabley1);
   $no_penjualan_akhir_max = $datay1['penjualan_akhir'];

   $tabley12 = mysqli_query($koneksiperta, "SELECT stok_akhir, sonding_akhir, harga FROM penjualan WHERE no_penjualan = '$no_penjualan_akhir_max' ");
   $datay12 = mysqli_fetch_array($tabley12);
   $sonding_akhir_max = $datay12['sonding_akhir'];
   $stok_akhir_max = $datay12['stok_akhir'];
   $harga_stok_akhir_max = $datay12['harga'];
   $total_uang_stok_max = $sonding_akhir_max * $harga_stok_akhir_max;

   //Sisa stok Dexlite
   $tabley2 = mysqli_query($koneksiperta, "SELECT MAX(no_penjualan) AS penjualan_akhir FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_barang = 'Dexlite' AND b.lokasi = '$lokasi' ");

   $datay2 = mysqli_fetch_array($tabley2);
   $no_penjualan_akhir_dex = $datay2['penjualan_akhir'];

   $tabley22 = mysqli_query($koneksiperta, "SELECT stok_akhir,sonding_akhir, harga FROM penjualan WHERE no_penjualan = '$no_penjualan_akhir_dex' ");
   $datay22 = mysqli_fetch_array($tabley22);
   $sonding_akhir_dex = $datay22['sonding_akhir'];
   $stok_akhir_dex = $datay22['stok_akhir'];
   $harga_stok_akhir_dex = $datay22['harga'];
   $total_uang_stok_dex = $sonding_akhir_dex * $harga_stok_akhir_dex;

  // setoran
  $tablex32= mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS jumlah_setoran FROM setoran a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND b.lokasi = '$lokasi'  ");
  $datax32 = mysqli_fetch_array($tablex32);
  $jumlah_setoran = $datax32['jumlah_setoran'];
   if (!isset($datax32['jumlah_setoran'])) {
   $jumlah_setoran = 0;
   }
  
  //dividen pertamax
  $table100 = mysqli_query($koneksiperta, "SELECT  SUM(qty) AS total_terjual FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_barang = 'Pertamax' AND b.lokasi = '$lokasi' ");
  $data100 = mysqli_fetch_array($table100);
  $total_terjual = $data100['total_terjual'];
  
  if($lokasi == 'Bedilan' ){
      $dividen_pertamax = $total_terjual * 150;
  }
  elseif($lokasi == 'Sumber Jaya' || $lokasi == 'Nusa Bakti'){
      $dividen_pertamax = $total_terjual * 50;
  }
  else{
      $dividen_pertamax = 0;
  }
  
  //dividen Dexlite
  $table101 = mysqli_query($koneksiperta, "SELECT  SUM(qty) AS total_terjual FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_barang = 'Dexlite' AND b.lokasi = '$lokasi' ");
  $data101 = mysqli_fetch_array($table101);
  $total_terjual = $data101['total_terjual'];
  
  if($lokasi == 'Bedilan' ){
      $dividen_Dexlite = $total_terjual * 150;
  }
  elseif($lokasi == 'Sumber Jaya' || $lokasi == 'Nusa Bakti'){
      $dividen_Dexlite = $total_terjual * 50;
  }
  else{
      $dividen_Dexlite = 0;
  }


  $total_pendapatan_max = $total_pertamax  + $total_ngecor_max + $total_uang_stok_max;
  $total_pendapatan_dex = $total_dexlite + $total_ngecor_dex  + $total_uang_stok_dex;


    // Pembelian Pertamax
  $table3 = mysqli_query($koneksiperta, "SELECT qty , harga FROM pembelian  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_barang = 'Pertamax' AND b.lokasi = '$lokasi' ");
  
  $total_pertamax_b=0;
  $pembelian_pertamax =0;
  while($data3 = mysqli_fetch_array($table3)){
    $qty = $data3['qty'];
    $harga = $data3['harga'];
    $pembelian_pertamax = $pembelian_pertamax + $qty;
    $total_pertamax_b = $total_pertamax_b + ($qty * $harga);

  }

   // Pembelian Dexlite
  $table4 = mysqli_query($koneksiperta, "SELECT qty , harga FROM pembelian  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_barang = 'Dexlite'  AND b.lokasi = '$lokasi'  ");
  
  $total_dexlite_b=0;
  $pembelian_dexlite =0;
  while($data4 = mysqli_fetch_array($table4)){
    $qty = $data4['qty'];
    $harga = $data4['harga'];
    $pembelian_dexlite = $pembelian_dexlite + $qty;
    $total_dexlite_b = $total_dexlite_b + ($qty * $harga);

  }


  $laba_kotor_dex = $total_pendapatan_dex - $total_dexlite_b;
  $laba_kotor_max = $total_pendapatan_max - $total_pertamax_b;
  //pengeluran Biaya Kantor
   $table32= mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' AND b.lokasi = '$lokasi'  ");
   $data32 = mysqli_fetch_array($table32);
   $jml_biaya_kantor = $data32['jumlah_biaya_kantor'];
    if (!isset($data32['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor = 0;
    }

   //pengeluran Listrik & Telepon
   $table42 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' AND b.lokasi = '$lokasi'  ");
   $data42 = mysqli_fetch_array($table42);
   $jml_listrik = $data42['jumlah_listrik'];
    if (!isset($data42['jumlah_listrik'])) {
    $jml_listrik = 0;
    }

   //pengeluran Biaya Sewa
   $table5 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa'  AND b.lokasi = '$lokasi'  ");
   $data5 = mysqli_fetch_array($table5);
   $jml_sewa = $data5['jumlah_sewa'];
    if (!isset($data5['jumlah_sewa'])) {
    $jml_sewa = 0;
    }

   //pengeluran Alat Tulis Kantor
   $table6 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' AND b.lokasi = '$lokasi'   ");
   $data6 = mysqli_fetch_array($table6);
   $jml_atk = $data6['jumlah_atk'];
    if (!isset($data6['jumlah_atk'])) {
    $jml_atk = 0;
    }
    //pengeluran Gaji
   $table7 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS jumlah_gaji FROM pengeluaran a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Gaji Karyawan'  AND b.lokasi = '$lokasi'  ");
   $data7 = mysqli_fetch_array($table7);
   $jml_gaji = $data7['jumlah_gaji'];
    if (!isset($data7['jumlah_gaji'])) {
    $jml_gaji = 0;
    }

    //pengeluran perjalanan dinas
   $table8 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport & Perjalanan Dinas'  AND b.lokasi = '$lokasi'  ");
   $data8 = mysqli_fetch_array($table8);
   $jml_transport = $data8['jumlah_transport'];
    if (!isset($data8['jumlah_transport'])) {
    $jml_transport = 0;
    }

    //pengeluran konsumsi
   $table9 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi'  AND b.lokasi = '$lokasi'  ");
   $data9 = mysqli_fetch_array($table9);
   $jml_konsumsi = $data9['jumlah_konsumsi'];
    if (!isset($data9['jumlah_konsumsi'])) {
    $jml_konsumsi = 0;
    }

    $total_biaya_usaha_final = $jml_biaya_kantor + $jml_listrik + $jml_atk + $jml_sewa + $jumlah_gaji + $jumlah_transport + $jumlah_konsumsi;


    $laba_bersih_sebelum_pajak = $laba_kotor_dex + $laba_kotor_max - $total_biaya_usaha_final;

    $total_losis_max = abs($stok_akhir_max - $sonding_akhir_max);
    $total_uang_losis_max = $total_losis_max * $harga_stok_akhir_max;

    $total_losis_dex = abs($stok_akhir_dex - $sonding_akhir_dex);
    $total_uang_losis_dex = $total_losis_dex * $harga_stok_akhir_dex;
    
}


?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan Penjualan Pertashop </title>

    <!-- Custom fonts for this template-->
    <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Custom styles for this template-->
    <link href="/sbadmin/css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

 <!-- Sidebar -->
 <ul class="navbar-nav  sidebar sidebar-dark accordion" style=" background-color: #004445" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsPertashop">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
</a>

<!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu Pertashop
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >List Perusahaan</span>
    </a>
    <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Perusahaan</h6>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.CBM/view/DsPTCBM">PT.CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/CV.PBJ/view/DsCVPBJ">CV.PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BatuBara/view/DsCVPBJ">Transport BB</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.BALSRI/view/DsPTBALSRI">PT.BALSRI</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.MESPBR/view/DsPTPBRMES">PT. MES & PBR</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/Kebun/view/DsKebun">Kebun</a>
            <a class="collapse-item" style="font-size: 15px;" href="DsPertashop">Pertashop</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.STRE/view/DsPTSTRE">PT.Sri Trans Energi</a>
        </div>
    </div>
</li>
 <!-- Nav Item - Pages Collapse Menu -->
 <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
                  15  aria-expanded="true" aria-controls="collapseOne">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Laporan</span>
                </a>
                <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Laporan</h6>
                        <?php if($nama == 'Nyoman Edy Susanto'){
                          echo"<a class='collapse-item' style='font-size: 15px;' href='VLabaRugiPs'>Laba Rugi</a>";
                        } ?>
                        <a class="collapse-item" style="font-size: 15px;" href="Setoran">Setoran</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLPenjualan">Lap Penjualan Pertamax</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLPenjualanDex">Lap Penjualan Dexlite</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VCorPertamax">Lap Ngecor Pertamax</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VCorDexlite">Lap Ngecor Dexlite</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLPengeluaran">Laporan Pengeluran</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan">Laporan Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPembelian">Laporan Pembelian</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VAbsensi">Absensi</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VGrafikPenjualan">Grafik Penjualan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VGrafikPenjualanPagi">Grafik Jual Pagi</a>
                    </div>
                </div>
            </li>


<!-- Divider -->
<hr class="sidebar-divider">




<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>



</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light  topbar mb-4 static-top shadow" style="background-color:#2C7873;">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>


            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small"
                        placeholder="Search for..." aria-label="Search"
                        aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>




        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline  small"  style="color:white;"><?php echo "$nama"; ?></span>
            <img class="img-profile rounded-circle"
            src="img/undraw_profile.svg">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="userDropdown">
        <a class="dropdown-item" href="VProfile">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
        </a>
        <a class="dropdown-item" href="VSetting">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            Settings
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="logout" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
        </a>
    </div>
</li>

</ul>

</nav>
<!-- End of Topbar -->
<div class="container" style="color : black;">
    <?php  echo "<form  method='POST' action='VLabaRugiPs' style='margin-bottom: 15px;'>" ?>
    <div>
      <div align="left" style="margin-left: 20px;"> 
        <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1"> 
        <span>-</span>
        <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
        <select id="lokasi" name="lokasi"s>
            <?php
            include 'koneksi.php';
            $result = mysqli_query($koneksiperta, "SELECT * FROM pertashop");   

            while ($data2 = mysqli_fetch_array($result)){
              $nama_driver = $data2['lokasi'];


              echo "<option> $nama_driver </option> ";
              
            }
            ?>
          </select>
        <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm" >Lihat</button>
      </div>
    </div>
  </form>

<br>
<br>
<?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
<br>
<br>
<br>
<div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title" align="Center"><strong>Laba Rugi Kotor Pertamax <?php echo $lokasi ?></strong></h3>
                </div>

                <div>
                    
                </div>



                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed"  style="color : black;">
                            <thead>
                                <tr>
                                    <td><strong>Akun</strong></td>
                                    <td class="text-left"><strong>Nama Akun</strong></td>
                                    <td class="text-left"><strong>Jumlah</strong></td>
                                    <td class="text-left"><strong>Debit</strong></td>
                                    <td class="text-left"><strong>Kredit</strong></td>
                                    <td class="text-right"><strong>Aksi</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                <tr>
                                    <td><strong>4-000</strong></td>
                                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-100</td>
                                    <td class="text-left">Penjualan Pertamax</td>
                                    <td class="text-left"><?=formatjumlah($pertamax_terjual)?> Liter</td>
                                    <td class="text-left"><?= formatuang($total_pertamax); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                  
                                    <?php echo "<td class='thick-line'><a href='VRincianLRPs/VRPenPertamax?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'>Rincian</a></td>"; ?>
                                </tr>
                                
                                <tr>
                                    <td>4-110</td>
                                    <td class="text-left">Sisa Stok Pertamax</td>
                                    <td class="text-left"><?=formatjumlah($sonding_akhir_max) ?> Liter</td>
                                    <td class="text-left"><?= formatuang($total_uang_stok_max); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                  
                                    <?php echo "<td class='thick-line'></td>"; ?>
                                </tr>


                                <tr>
                                    <td>4-112</td>
                                    <td class="text-left">Total Ngecor Pertamax</td>
                                    <td class="text-left"><?=formatjumlah($qty_ngecor_max)?> Liter</td>
                                    <td class="text-left"><?= formatuang($total_ngecor_max); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    
                                    <?php echo "<td class='thick-line'><a href='VRincianLRPs/VRCorPertamax?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'>Rincian</a></td>"; ?>
                                </tr>
 
                                <tr style="background-color:     #F0F8FF; ">
                                    <td><strong>Total Pendapatan + Cor + Stok</strong></td>
                                    <td class="text-left"></td>
                                    <td class="no-line text-left"><?= formatjumlah($qty_ngecor_max + $pertamax_terjual + $sonding_akhir_max ); ?> Liter</td>
                                    <td class="no-line text-left"><?= formatuang($total_pendapatan_max); ?></td>
                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                     <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr style="background-color:     #F0F8FF; ">
                                    <td><strong>Total Losis</strong></td>
                                    <td class="text-left"></td>
                                    <td class="no-line text-left"><?= formatjumlah($total_losis_max ); ?> Liter</td>
                                    <td class="no-line text-left"><?= formatuang($total_uang_losis_max); ?></td>
                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                     <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="thick-line"></td>
                                    <td class="text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr>
                                    <td><strong>5-000</strong></td>
                                    <td class="text-left"><strong>HARGA POKOK PENJUALAN</strong></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-100</td>
                                    <td class="text-left">Pembelian Pertamax</td>
                                    <td class="text-left"><?=formatjumlah($pembelian_pertamax)?> Liter</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_pertamax_b); ?></td>
                                    <?php echo "<td class='thick-line'><a href='VRincianLRPs/VRPembPertamax?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'>Rincian</a></td>"; ?>
                                </tr>
                            
                                <tr style="background-color:    #F0F8FF;  ">
                                    <td><strong>Total Harga Pokok Penjualan</strong></td>
                                    <td class="text-left"></td>
                                    <td class="thick-line"></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_pertamax_b); ?></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="thick-line"></td>
                                    <td class="text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr style="background-color: navy;  color:white;">
                                    <td><strong>LABA KOTOR</strong></td>
                                    <td class="text-left"></td>
                                    <td class="thick-line"></td>
                                    <?php
                                   
                                    if ($laba_kotor_max > 0) { ?>
                                    
                                    <td class="no-line text-left"><?= formatuang($laba_kotor_max); ?> </td>
                                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                                    <?php }
                                    else if ($laba_kotor_max < 0) { ?>

                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <td class="no-line text-left"><?= formatuang($laba_kotor_max); ?></td>
                                    <?php }
                                    else if ($laba_kotor_max == 0) { ?>

                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <?php }
                                    ?>


                                    <td class="thick-line"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>
    <hr>
    <br>
    <br>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title" align="Center"><strong>Laba Rugi Kotor Dexlite <?php echo $lokasi ?></strong></h3>
                </div>

                <div>
                    
                </div>



                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed"  style="color : black;">
                            <thead>
                                <tr>
                                    <td><strong>Akun</strong></td>
                                    <td class="text-left"><strong>Nama Akun</strong></td>
                                    <td class="text-left"><strong>Jumlah</strong></td>
                                    <td class="text-left"><strong>Debit</strong></td>
                                    <td class="text-left"><strong>Kredit</strong></td>
                                    <td class="text-right"><strong>Aksi</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                <tr>
                                    <td><strong>4-000</strong></td>
                                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-101</td>
                                    <td class="text-left">Penjualan Dexlite</td>
                                    <td class="text-left"><?=formatjumlah($dexlite_terjual)?> Liter</td>
                                    <td class="text-left"><?= formatuang($total_dexlite); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                 
                                    <?php echo "<td class='thick-line'><a href='VRincianLRPs/VRPenDexlite?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'>Rincian</a></td>"; ?>
                                </tr>
                                
                                <tr>
                                    <td>4-111</td>
                                    <td class="text-left">Sisa Stok Dexlite</td>
                                    <td class="text-left"><?=formatjumlah($sonding_akhir_dex)?> Liter</td>
                                    <td class="text-left"><?= formatuang($total_uang_stok_dex); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    
                                    <?php echo "<td class='thick-line'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-112</td>
                                    <td class="text-left">Total Ngecor Dexlite</td>
                                    <td class="text-left"><?=formatjumlah($qty_ngecor_dex)?> Liter</td>
                                    <td class="text-left"><?= formatuang($total_ngecor_dex); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    
                                    <?php echo "<td class='thick-line'><a href='VRincianLRPs/VRCorDexlite?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'>Rincian</a></td>"; ?>
                                </tr>

                            
                           
                                <tr style="background-color:     #F0F8FF; ">
                                    <td><strong>Total Pendapatan + Cor + Sisa Stok</strong></td>
                                    <td class="text-left"></td>
                                    <td class="no-line text-left"><?= formatjumlah($qty_ngecor_dex + $dexlite_terjual + $sonding_akhir_dex ); ?> Liter</td>
                                    <td class="no-line text-left"><?= formatuang($total_pendapatan_dex); ?></td>
                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                     <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr style="background-color:     #F0F8FF; ">
                                    <td><strong>Total Losis</strong></td>
                                    <td class="text-left"></td>
                                    <td class="no-line text-left"><?= formatjumlah($total_losis_dex ); ?> Liter</td>
                                    <td class="no-line text-left"><?= formatuang($total_uang_losis_dex); ?></td>
                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                     <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="thick-line"></td>
                                    <td class="text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr>
                                    <td><strong>5-000</strong></td>
                                    <td class="text-left"><strong>HARGA POKOK PENJUALAN</strong></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-110</td>
                                    <td class="text-left">Pembelian Dexlite</td>
                                    <td class="text-left"><?=formatjumlah($pembelian_dexlite)?> Liter</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_dexlite_b); ?></td>
                                    <?php echo "<td class='thick-line'><a href='VRincianLRPs/VRPembDexlite?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'>Rincian</a></td>"; ?>
                                   
                                </tr>
                            
                                <tr style="background-color:    #F0F8FF;  ">
                                    <td><strong>Total Harga Pokok Penjualan Dex</strong></td>
                                    <td class="text-left"></td>
                                    <td class="thick-line"></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_dexlite_b); ?></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="thick-line"></td>
                                    <td class="text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr style="background-color: navy;  color:white;">
                                    <td><strong>LABA KOTOR</strong></td>
                                    <td class="text-left"></td>
                                    <td class="thick-line"></td>
                                    <?php
                                   
                                    if ($laba_kotor_dex > 0) { ?>
                                    
                                    <td class="no-line text-left"><?= formatuang($laba_kotor_dex); ?> </td>
                                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                                    <?php }
                                    else if ($laba_kotor_dex < 0) { ?>

                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <td class="no-line text-left"><?= formatuang($laba_kotor_dex); ?></td>
                                    <?php }
                                    else if ($laba_kotor_dex == 0) { ?>

                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <?php }
                                    ?>


                                    <td class="thick-line"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>
    <hr>
    <br>
    <br>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title" align="Center"><strong>Laba Rugi <?php echo $lokasi ?></strong></h3>
                </div>

                <div>
                    
                </div>



                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed"  style="color : black;">
                            <thead>
                                <tr>
                                    <td><strong>Akun</strong></td>
                                    <td class="text-left"><strong>Nama Akun</strong></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"><strong>Debit</strong></td>
                                    <td class="text-left"><strong>Kredit</strong></td>
                                    
                                    <td class="text-right"><strong>Aksi</strong></td>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                <tr>
                                    <td><strong>4-000</strong></td>
                                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-101</td>
                                    <td class="text-left">Laba Kotor Pertamax</td>
                                    <td class="text-left"></td>
                                    <td class="text-left"><?= formatuang($laba_kotor_max); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='thick-line'></td>"; ?>
                                </tr>   
                                <tr>
                                    <td>4-101</td>
                                    <td class="text-left">Laba Kotor Dexlite</td>
                                    <td class="text-left"></td>
                                    <td class="text-left"><?= formatuang($laba_kotor_dex); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='thick-line'></td>"; ?>
                                </tr>                            
                           
                                <tr style="background-color:     #F0F8FF; ">
                                    <td><strong>Total Laba Kotor</strong></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <td class="no-line text-left"><?= formatuang($laba_kotor_max + $laba_kotor_dex); ?></td>
                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                     <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr style="background-color:     #F0F8FF; ">
                                    <td><strong>Total Setoran</strong></td>
                                    <td class="text-left"></td>
                                    <td class="thick-line"></td>
                                    <td class="no-line text-left"><?= formatuang($jumlah_setoran); ?></td>
                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='thick-line'><a href='VRincianLRPs/VRSetoran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="thick-line"></td>
                                    <td class="text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="thick-line"></td>
                                </tr>
                               
                                <tr style="background-color: navy;  color:white;">
                                    <td><strong>LABA KOTOR</strong></td>
                                    <td class="text-left"></td>
                                    <td class="thick-line"></td>
                                    <?php
                                   
                                    if ($laba_kotor_max + $laba_kotor_dex > 0) { ?>
                                    
                                    <td class="no-line text-left"><?= formatuang($laba_kotor_max + $laba_kotor_dex); ?> </td>
                                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                                    <?php }
                                    else if ($laba_kotor_max + $laba_kotor_dex < 0) { ?>

                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <td class="no-line text-left"><?= formatuang($laba_kotor_max + $laba_kotor_dex); ?></td>
                                    <?php }
                                    else if ($laba_kotor_max + $laba_kotor_dex == 0) { ?>

                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <?php }
                                    ?>


                                    <td class="thick-line"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="thick-line"></td>
                                    <td class="text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr>
                                    <td><strong>5-500</strong></td>
                                    <td class="text-left"><strong>BIAYA USAHA</strong></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-510</td>
                                    <td class="text-left">GAJI</td>
                                    <td class="text-left"></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?=  formatuang($jml_gaji); ?></td>
                                    <?php echo "<td class='thick-line'><a href='VRincianLRPs/VRGajiKaryawan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'>Rincian</a></td>"; ?>
                                    
                                </tr>
                                <tr>
                                    <td>5-520</td>
                                    <td class="text-left">Alat Tulis Kantor</td>
                                    <td class="text-left"></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($jml_atk); ?></td>
                                    <?php echo "<td class='thick-line'><a href='VRincianLRPs/VRATK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'>Rincian</a></td>"; ?>
                                   
                                </tr>
                                <tr>
                                    <td>5-540</td>
                                    <td class="text-left">Biaya Kantor</td>
                                    <td class="text-left"></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($jml_biaya_kantor); ?></td>
                                    <?php echo "<td class='thick-line'><a href='VRincianLRPs/VRBiayaKantor?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'>Rincian</a></td>"; ?>
                                   
                                </tr>
                                <tr>
                                    <td>5-550</td>
                                    <td class="text-left">Listrik & Telepon</td>
                                    <td class="text-left"></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($jml_listrik); ?></td>
                                    <?php echo "<td class='thick-line'><a href='VRincianLRPs/VRListrik?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'>Rincian</a></td>"; ?>
                                   
                                </tr>
                                <tr>
                                    <td>5-590</td>
                                    <td class="text-left">Biaya Sewa</td>
                                    <td class="text-left"></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($jml_sewa); ?></td>
                                    <?php echo "<td class='thick-line'><a href='VRincianLRPs/VRSewa?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'>Rincian</a></td>"; ?>
                                  
                                </tr>
                                <tr>
                                    <td>5-591</td>
                                    <td class="text-left">Transport & Perjalanan Dinas</td>
                                    <td class="text-left"></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($jml_transport); ?></td>
                                    <?php echo "<td class='thick-line'><a href='VRincianLRPs/VRSewa?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'>Rincian</a></td>"; ?>
                                  
                                </tr>
                                <tr>
                                    <td>5-592</td>
                                    <td class="text-left">Biaya Konsumsi</td>
                                    <td class="text-left"></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($jml_konsumsi); ?></td>
                                    <?php echo "<td class='thick-line'><a href='VRincianLRPs/VRSewa?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'>Rincian</a></td>"; ?>
                                  
                                </tr>
                                <tr style="background-color:    #F0F8FF; ">
                                    <td><strong>Total Biaya Usaha</strong></td>
                                    <td class="text-left"></td>
                                    <td class="thick-line"></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_biaya_usaha_final); ?></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="thick-line"></td>
                                    <td class="text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr style="background-color: navy;  color:white;">
                                    <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                                    <td class="text-left"></td>
                                    <td class="thick-line"></td>
                                    <?php
                                   
                                    if ($laba_bersih_sebelum_pajak > 0) { ?>
                                    
                                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak )?> </td>
                                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                                    <?php }
                                    else if ($laba_bersih_sebelum_pajak < 0) { ?>

                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak); ?></td>

                                    <?php }
                                    else if ($laba_bersih_sebelum_pajak == 0) { ?>

                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <?php }
                                    ?>
                                    <td class="thick-line"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="footer" style="background-color:#2C7873; height: 55px; padding-top: 15px; ">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span style="color:white; font-size: 12px;">Copyright &copy; PutraBalkomCorp 2021</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"></span>
            </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="logout">Logout</a>
        </div>
    </div>
</div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="/sbadmin/vendor/jquery/jquery.min.js"></script>
<script src="/sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="/sbadmin/js/sb-admin-2.min.js"></script>

</body>

</html>