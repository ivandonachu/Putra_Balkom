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
$foto_profile = $data1['foto_profile'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Direktur Utama') {

}

else{  header("Location: logout.php");
exit;
}


if (isset($_GET['tanggal1'])) {
    $tanggal_awal = $_GET['tanggal1'];
    $tanggal_akhir = $_GET['tanggal2'];
   } 
   
   elseif (isset($_POST['tanggal1'])) {
    $tanggal_awal = $_POST['tanggal1'];
    $tanggal_akhir = $_POST['tanggal2'];
   }  
   
   else{
       $tanggal_awal = date('Y-m-1');
     $tanggal_akhir = date('Y-m-31');
     }



    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }


if ($tanggal_awal == $tanggal_akhir ) {
  //PENDAPATAN
// TOTAL PENJUALAN REFILL
$table = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS penjualan_refill FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND kode_akun = '4-110' AND kode_baja != 'L03K01' AND kode_baja != 'L03K10' AND kode_baja != 'L03K11' AND kode_baja != 'L03K00' ");
$data_pendapatan_refill = mysqli_fetch_array($table);
$total_pendapatan_refill = $data_pendapatan_refill['penjualan_refill'];
if (!isset($data_pendapatan_refill['penjualan_refill'])) {
    $total_pendapatan_refill = 0;
}


// TOTAL Pendapatan lain - lain
$table1x = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS pendapatan_lain FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'AND kode_akun = '5-610' ");
$data_pendapatan_lain = mysqli_fetch_array($table1x);
$total_pendapatan_lain = $data_pendapatan_lain['pendapatan_lain'];
if (!isset($data_pendapatan_lain['pendapatan_lain'])) {
    $total_pendapatan_lain = 0;
}



// TOTAL PENJUALAN BAJA + ISI
$table2 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS penjualan_bajaisi FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'AND kode_akun = '4-120' ");
$data_pendapatan_bajaisi = mysqli_fetch_array($table2);
$total_pendapatan_bajaisi = $data_pendapatan_bajaisi['penjualan_bajaisi'];
if (!isset($data_pendapatan_bajaisi['penjualan_bajaisi'])) {
    $total_pendapatan_bajaisi = 0;
}


// TOTAL PENJUALAN KOSONG
$table3 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS penjualan_bajakosong FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'AND kode_akun = '4-130' ");
$data_pendapatan_bajakosong = mysqli_fetch_array($table3);
$total_pendapatan_bajakosong = $data_pendapatan_bajakosong['penjualan_bajakosong'];
if (!isset($data_pendapatan_bajakosong['penjualan_bajakosong'])) {
    $total_pendapatan_bajakosong = 0;
}

//transport_fee
$table18 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jml_transport_fee FROM transport_fee WHERE tanggal = '$tanggal_awal' AND referensi = 'CBM'");
$data_transport_fee = mysqli_fetch_array($table18);
$total_transport_fee = $data_transport_fee['jml_transport_fee'];
if (!isset($data_transport_fee['jml_transport_fee'])) {
    $total_transport_fee = 0;
}

$total_pendapatan = $total_pendapatan_refill + $total_transport_fee ;


//HARGA POKOK PENJUALAN
//TOTAL PEMBELIAN REFILL CBM
$table4 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS pembelian_refill_cbm FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'AND kode_akun = '5-110' AND referensi = 'CBM' ");
$data_pembelian_refill_cbm = mysqli_fetch_array($table4);
$total_pembelian_refill_cbm = $data_pembelian_refill_cbm['pembelian_refill_cbm'];
if (!isset($data_pembelian_refill_cbm['pembelian_refill_cbm'])) {
    $total_pembelian_refill_cbm = 0;
}
//TOTAL PEMBELIAN REFILL TK
$table5 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS pembelian_refill_tk FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'AND kode_akun = '5-110' AND referensi = 'TK' ");
$data_pembelian_refill_tk = mysqli_fetch_array($table5);
$total_pembelian_refill_tk = $data_pembelian_refill_tk['pembelian_refill_tk'];
if (!isset($data_pembelian_refill_tk['pembelian_refill_tk'])) {
    $total_pembelian_refill_tk = 0;
}

$total_pembelian_refill = $total_pembelian_refill_cbm + $total_pembelian_refill_tk;


//TOTAL PEMBELIAN BAJA + ISI CBM
$table6 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS pembelian_bajaisi_cbm FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'AND kode_akun = '5-120' AND referensi = 'CBM' ");
$data_pembelian_bajaisi_cbm = mysqli_fetch_array($table6);
$total_pembelian_bajaisi_cbm = $data_pembelian_bajaisi_cbm['pembelian_bajaisi_cbm'];
if (!isset($data_pembelian_bajaisi_cbm['pembelian_bajaisi_cbm'])) {
    $total_pembelian_bajaisi_cbm = 0;
}
//TOTAL PEMBELIAN REFILL TK
$table7 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS pembelian_bajaisi_tk FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'AND kode_akun = '5-120' AND referensi = 'TK' ");
$data_pembelian_bajaisi_tk = mysqli_fetch_array($table7);
$total_pembelian_bajaisi_tk = $data_pembelian_bajaisi_tk['pembelian_bajaisi_tk'];
if (!isset($data_pembelian_bajaisi_tk['pembelian_bajaisi_tk'])) {
    $total_pembelian_bajaisi_tk = 0;
}

$total_pembelian_bajaisi = $total_pembelian_bajaisi_cbm + $total_pembelian_bajaisi_tk;


//TOTAL PEMBELIAN KOSONG CBM
$table8 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS pembelian_bajakosong_cbm FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'AND kode_akun = '5-130' AND referensi = 'CBM' ");
$data_pembelian_bajakosong_cbm = mysqli_fetch_array($table8);
$total_pembelian_bajakosong_cbm = $data_pembelian_bajakosong_cbm['pembelian_bajakosong_cbm'];
if (!isset($data_pembelian_bajakosong_cbm['pembelian_bajakosong_cbm'])) {
    $total_pembelian_bajakosong_cbm = 0;
}
//TOTAL PEMBELIAN KOSONG TK
$table9 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS pembelian_bajakosong_tk FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'AND kode_akun = '5-130' AND referensi = 'TK' ");
$data_pembelian_bajakosong_tk = mysqli_fetch_array($table9);
$total_pembelian_bajakosong_tk = $data_pembelian_bajakosong_tk['pembelian_bajakosong_tk'];
if (!isset($data_pembelian_bajakosong_tk['pembelian_bajakosong_tk'])) {
    $total_pembelian_bajakosong_tk = 0;
}




$total_pembelian_bajakosong = $total_pembelian_bajakosong_cbm + $total_pembelian_bajakosong_tk;

$total_harga_pokok_penjualan = $total_pembelian_refill + $total_pembelian_bajaisi + $total_pembelian_bajakosong;

//LABA KOTOR
$laba_kotor = $total_pendapatan - $total_harga_pokok_penjualan;


}





else{
    //PENDAPATAN
// TOTAL PENJUALAN REFILL cbm
$table = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS penjualan_refill FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_akun = '4-110' AND kode_baja != 'L03K01' ");
$data_pendapatan_refill = mysqli_fetch_array($table);
$total_pendapatan_refill = $data_pendapatan_refill['penjualan_refill'];
if (!isset($data_pendapatan_refill['penjualan_refill'])) {
    $total_pendapatan_refill = 0;
}
// TOTAL PENJUALAN REFILL pbr
$table_pbr = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS penjualan_refill_pbr FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND  referensi = 'PBR' AND kode_akun = '4-110' AND kode_baja != 'L03K01' ");
$data_pendapatan_refill_pbr = mysqli_fetch_array($table_pbr);
$total_pendapatan_refill_pbr = $data_pendapatan_refill_pbr['penjualan_refill_pbr'];
if (!isset($data_pendapatan_refill_pbr['penjualan_refill_pbr'])) {
    $total_pendapatan_refill_pbr = 0;
}

// TOTAL PENJUALAN REFILL mes
$table_mes = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS penjualan_refill_mes FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND  referensi = 'MES' AND kode_akun = '4-110' AND kode_baja != 'L03K01' ");
$data_pendapatan_refill_mes = mysqli_fetch_array($table_mes);
$total_pendapatan_refill_mes = $data_pendapatan_refill_mes['penjualan_refill_mes'];
if (!isset($data_pendapatan_refill_mes['penjualan_refill_mes'])) {
    $total_pendapatan_refill_mes = 0;
}



// TOTAL PENJUALAN BAJA + ISI cbm
$table2 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS penjualan_bajaisi FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '4-120' AND kode_baja != 'L03K11' ");
$data_pendapatan_bajaisi = mysqli_fetch_array($table2);
$total_pendapatan_bajaisi = $data_pendapatan_bajaisi['penjualan_bajaisi'];
if (!isset($data_pendapatan_bajaisi['penjualan_bajaisi'])) {
    $total_pendapatan_bajaisi = 0;
}
// TOTAL PENJUALAN BAJA + ISI pbr
$table2_pbr = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS riwayat_penjualan_pbr FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND  referensi = 'PBR' AND kode_akun = '4-120' AND kode_baja != 'L03K11' ");
$data_pendapatan_bajaisi_pbr = mysqli_fetch_array($table2_pbr);
$total_pendapatan_bajaisi_pbr = $data_pendapatan_bajaisi_pbr['riwayat_penjualan_pbr'];
if (!isset($data_pendapatan_bajaisi_pbr['riwayat_penjualan_pbr'])) {
    $total_pendapatan_bajaisi_pbr = 0;
}
// TOTAL PENJUALAN BAJA + ISI mes
$table2_mes = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS riwayat_penjualan_mes FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND  referensi = 'MES' AND kode_akun = '4-120' AND kode_baja != 'L03K11' ");
$data_pendapatan_bajaisi_mes = mysqli_fetch_array($table2_mes);
$total_pendapatan_bajaisi_mes = $data_pendapatan_bajaisi_mes['riwayat_penjualan_mes'];
if (!isset($data_pendapatan_bajaisi_mes['riwayat_penjualan_mes'])) {
    $total_pendapatan_bajaisi_mes = 0;
}


// TOTAL PENJUALAN KOSONG cbm
$table3 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS penjualan_bajakosong FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '4-130' AND kode_baja != 'L03K10'  ");
$data_pendapatan_bajakosong = mysqli_fetch_array($table3);
$total_pendapatan_bajakosong = $data_pendapatan_bajakosong['penjualan_bajakosong'];
if (!isset($data_pendapatan_bajakosong['penjualan_bajakosong'])) {
    $total_pendapatan_bajakosong = 0;
}
// TOTAL PENJUALAN KOSONG pbr
$table3_pbr = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS penjualan_bajakosong_pbr FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND  referensi = 'PBR' AND kode_akun = '4-130' AND kode_baja != 'L03K10'  ");
$data_pendapatan_bajakosong_pbr = mysqli_fetch_array($table3_pbr);
$total_pendapatan_bajakosong_pbr = $data_pendapatan_bajakosong_pbr['penjualan_bajakosong_pbr'];
if (!isset($data_pendapatan_bajakosong_pbr['penjualan_bajakosong_pbr'])) {
    $total_pendapatan_bajakosong_pbr = 0;
}
// TOTAL PENJUALAN KOSONG pbr
$table3_mes = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS penjualan_bajakosong_mes FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND  referensi = 'MES' AND kode_akun = '4-130' AND kode_baja != 'L03K10' ");
$data_pendapatan_bajakosong_mes = mysqli_fetch_array($table3_mes);
$total_pendapatan_bajakosong_mes = $data_pendapatan_bajakosong_mes['penjualan_bajakosong_mes'];
if (!isset($data_pendapatan_bajakosong_mes['penjualan_bajakosong_mes'])) {
    $total_pendapatan_bajakosong_mes = 0;
}

$total_pendapatan = $total_pendapatan_refill + $total_pendapatan_refill_pbr + $total_pendapatan_refill_mes + $total_pendapatan_bajaisi + $total_pendapatan_bajaisi_pbr + $total_pendapatan_bajaisi_mes + $total_pendapatan_bajakosong + $total_pendapatan_bajakosong_pbr + $total_pendapatan_bajakosong_mes ;




//HARGA POKOK PENJUALAN

//TOTAL PEMBELIAN REFILL CBM
$table4 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS pembelian_refill_cbm FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-110' AND referensi = 'CBM'  AND kode_baja != 'L03K01' ");
$data_pembelian_refill_cbm = mysqli_fetch_array($table4);
$total_pembelian_refill_cbm = $data_pembelian_refill_cbm['pembelian_refill_cbm'];
if (!isset($data_pembelian_refill_cbm['pembelian_refill_cbm'])) {
    $total_pembelian_refill_cbm = 0;
}
//TOTAL PEMBELIAN REFILL PBR
$table4_pbr = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_refill_pbr FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-110' AND referensi = 'PBR' AND pembayaran = 'Bank BRI PBR' AND kode_baja != 'L03K01'  ");
$data_pembelian_refill_pbr = mysqli_fetch_array($table4_pbr);
$total_pembelian_refill_pbr = $data_pembelian_refill_pbr['pembelian_refill_pbr'];
if (!isset($data_pembelian_refill_pbr['pembelian_refill_pbr'])) {
    $total_pembelian_refill_pbr = 0;
}
//TOTAL PEMBELIAN REFILL MES
$table4_mes = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_refill_mes FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-110' AND referensi = 'MES' AND pembayaran = 'Bank BRI MES' AND kode_baja != 'L03K01' ");
$data_pembelian_refill_mes = mysqli_fetch_array($table4_mes);
$total_pembelian_refill_mes = $data_pembelian_refill_mes['pembelian_refill_mes'];
if (!isset($data_pembelian_refill_mes['pembelian_refill_mes'])) {
    $total_pembelian_refill_mes = 0;
}
//PEMBELIAN REFILL ADMIN
$tabel_pembayaran_refill = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS pembayaran_refill FROM pengeluaran_admin WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND nama_akun = 'Pembayaran Non PSO'");
$data_pembayaran_refill = mysqli_fetch_array($tabel_pembayaran_refill);
$total_pembayaran_refill = $data_pembayaran_refill['pembayaran_refill'];
if (!isset($data_pembayaran_refill['pembayaran_refill'])) {
    $total_pembayaran_refill = 0;
}

$total_pembelian_refill = $total_pembelian_refill_cbm + $total_pembelian_refill_mes + $total_pembelian_refill_pbr +  $total_pembayaran_refill;


//TOTAL PEMBELIAN BAJA + ISI CBM
$table6 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS pembelian_bajaisi_cbm FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-120' AND referensi = 'CBM' AND kode_baja != 'L03K11' ");
$data_pembelian_bajaisi_cbm = mysqli_fetch_array($table6);
$total_pembelian_bajaisi_cbm = $data_pembelian_bajaisi_cbm['pembelian_bajaisi_cbm'];
if (!isset($data_pembelian_bajaisi_cbm['pembelian_bajaisi_cbm'])) {
    $total_pembelian_bajaisi_cbm = 0;
}
//TOTAL PEMBELIAN BAJA + ISI PBR
$table6pbr = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_bajaisi_pbr FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-120' AND referensi = 'PBR'  AND pembayaran = 'Bank BRI PBR' AND kode_baja != 'L03K11' ");
$data_pembelian_bajaisi_pbr = mysqli_fetch_array($table6pbr);
$total_pembelian_bajaisi_pbr = $data_pembelian_bajaisi_pbr['pembelian_bajaisi_pbr'];
if (!isset($data_pembelian_bajaisi_pbr['pembelian_bajaisi_pbr'])) {
    $total_pembelian_bajaisi_pbr = 0;
}
//TOTAL PEMBELIAN BAJA + ISI MES
$table6mes = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_bajaisi_mes FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-120' AND referensi = 'MES'  AND pembayaran = 'Bank BRI MES' AND kode_baja != 'L03K11' ");
$data_pembelian_bajaisi_mes = mysqli_fetch_array($table6mes);
$total_pembelian_bajaisi_mes = $data_pembelian_bajaisi_mes['pembelian_bajaisi_mes'];
if (!isset($data_pembelian_bajaisi_mes['pembelian_bajaisi_mes'])) {
    $total_pembelian_bajaisi_mes = 0;
}


$total_pembelian_bajaisi = $total_pembelian_bajaisi_cbm + $total_pembelian_bajaisi_pbr + $total_pembelian_bajaisi_mes;


//TOTAL PEMBELIAN KOSONG CBM
$table8 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS pembelian_bajakosong_cbm FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-130' AND referensi = 'CBM' AND kode_baja != 'L03K10' ");
$data_pembelian_bajakosong_cbm = mysqli_fetch_array($table8);
$total_pembelian_bajakosong_cbm = $data_pembelian_bajakosong_cbm['pembelian_bajakosong_cbm'];
if (!isset($data_pembelian_bajakosong_cbm['pembelian_bajakosong_cbm'])) {
    $total_pembelian_bajakosong_cbm = 0;
}
//TOTAL PEMBELIAN KOSONG PBR
$table8pbr = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_bajakosong_pbr FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-130' AND referensi = 'PBR'  AND pembayaran = 'Bank BRI PBR' AND kode_baja != 'L03K10' ");
$data_pembelian_bajakosong_pbr = mysqli_fetch_array($table8pbr);
$total_pembelian_bajakosong_pbr = $data_pembelian_bajakosong_pbr['pembelian_bajakosong_pbr'];
if (!isset($data_pembelian_bajakosong_pbr['pembelian_bajakosong_pbr'])) {
    $total_pembelian_bajakosong_pbr = 0;
}
//TOTAL PEMBELIAN KOSONG MES
$table8mes = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_bajakosong_mes FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-130' AND referensi = 'MES'  AND pembayaran = 'Bank BRI MES' AND kode_baja != 'L03K10' ");
$data_pembelian_bajakosong_mes = mysqli_fetch_array($table8mes);
$total_pembelian_bajakosong_mes = $data_pembelian_bajakosong_mes['pembelian_bajakosong_mes'];
if (!isset($data_pembelian_bajakosong_mes['pembelian_bajakosong_mes'])) {
    $total_pembelian_bajakosong_mes = 0;
}


$total_pembelian_bajakosong = $total_pembelian_bajakosong_cbm + $total_pembelian_bajakosong_pbr + $total_pembelian_bajakosong_pbr;
$total_harga_pokok_penjualan = $total_pembelian_refill + $total_pembelian_bajaisi + $total_pembelian_bajakosong;

//sisa stok inventory
//TOTAL Inventory cbm
$table_inventory_cbm = mysqli_query($koneksicbm, "SELECT *  FROM laporan_inventory WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'GD' ORDER BY no_laporan DESC LIMIT 1");
$data_inventory_cbm = mysqli_fetch_array($table_inventory_cbm);
$total_stok_12bg = $data_inventory_cbm['B12K11'];
$total_stok_12lpg = $data_inventory_cbm['L12K11'];
$total_stok_55bg = $data_inventory_cbm['B05K11'];
$table_inventory_pbr = mysqli_query($koneksipbr, "SELECT *  FROM laporan_inventory WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'GD'  ORDER BY no_laporan DESC LIMIT 1");
$data_inventory_pbr = mysqli_fetch_array($table_inventory_pbr);
$total_stok_12bg_pbr = $data_inventory_pbr['B12K11'];
$total_stok_12lpg_pbr = $data_inventory_pbr['L12K11'];
$total_stok_55bg_pbr = $data_inventory_pbr['B05K11'];

//harga beli non pso
$table_harga_beli = mysqli_query($koneksicbm, "SELECT *  FROM pengeluaran_admin WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Pembayaran Non PSO' ORDER BY no_pengeluaran DESC LIMIT 1");
$data_harga_beli = mysqli_fetch_array($table_harga_beli);
$harga_12kg = $data_harga_beli['harga_beli_12'];
$harga_55kg = $data_harga_beli['harga_beli_55'];

$uang_stok_cbm = ($total_stok_12bg * $harga_12kg) + ($total_stok_12lpg * $harga_12kg) + ($total_stok_55bg * $harga_55kg);
$uang_stok_pbr = ($total_stok_12bg_pbr * $harga_12kg) + ($total_stok_12lpg_pbr * $harga_12kg) + ($total_stok_55bg_pbr * $harga_55kg);
$total_harga_pokok_penjualan = $total_harga_pokok_penjualan - ($uang_stok_cbm + $uang_stok_pbr);

//LABA KOTOR
$laba_kotor = $total_pendapatan - $total_harga_pokok_penjualan;

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

  <title>Laba Rugi Non PSO</title>

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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsPTCBM.php">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="gambar/Logo CBM.png" ></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">


  <!-- Nav Item - Dashboard -->
<li class="nav-item active" >
    <a class="nav-link" href="DsPTCBM">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

     <!-- Divider -->
     <hr class="sidebar-divider">
                <!-- Heading -->
                <div class="sidebar-heading" style="font-size: 15px; color:white;">
                     Menu PT. CBM
                </div>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
                  15  aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-building" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >List Company</span>
                </a>
                <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Company</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="DsPTCBM">PT. CBM</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/CV.PBJ/view/DsCVPBJ">PT.PBJ</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BatuBara/view/DsCVPBJ">Transport BB</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.BALSRI/view/DsPTBALSRI">PT.BALSRI</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.MESPBR/view/DsPTPBRMES">PT. MES & PBR</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/Kebun/view/DsKebun">Kebun</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PERTASHOP/view/DsPertashop">Pertashop</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.STRE/view/DsPTSTRE">PT.Sri Trans Energi</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BALSRI_JBB/view/DsBALSRIJBB">BALSRI JBB</a>
                    </div>
                </div>
            </li>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                  15  aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-clipboard-list" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Laporan Perusahan</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Laporan</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan1">Laporan Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLPenjualan1">Laporan Penjualan</a>
                        
                        <?php if($nama == 'Nyoman Edy Susanto'){
                        echo"<a class='collapse-item' style='font-size: 15px;' href='VLabaRugi'>Laba Rugi</a>";
                        } ?>
                        <a class="collapse-item" style="font-size: 15px;" href="VSaldoBaru">Laporan Saldo</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VBonKaryawan">Laporan BON </a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRincianSA">Alokasi SA </a>
                         <a class="collapse-item" style="font-size: 15px;" href="VUangPBJ">Uang PBJ</a>
                         <a class="collapse-item" style="font-size: 15px;" href="VKeberangkatan">Uang Jalan</a>
                         <a class="collapse-item" style="font-size: 15px;" href="VPengeluaran">Pengeluaran Kasir</a>
                         <a class="collapse-item" style="font-size: 15px;" href="VKasKecil">Kas Kecil</a>
                         <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Gaji Karyawan</a>
                         <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranWorkshop">Pengeluaran Workshop</a>
                    </div>
                </div>
            </li>
            
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2"
                  15  aria-expanded="true" aria-controls="collapseTwo2">
                    <i class="fas fa-file-alt" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Daftar SDM</span>
                </a>
                <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">SDM</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VAset">Aset</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VDokumen">Dokumen</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VSeluruhKaryawan">List Karyawan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VSuratKeluarMasuk">Surat Keluar Masuk</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VKontrakKerja">Kontrak Kerja</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VSuratIzin">Surat Izin</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo4"
                  15  aria-expanded="true" aria-controls="collapseTwo4">
                    <i class="fas fa-file-alt" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Rekap Gaji</span>
                </a>
                <div id="collapseTwo4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">SDM</h6>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiCBM">Rekap Gaji CBM</a>
                        <a class="collapse-item" style="font-size: 12pxx;" href="VRekapGajiDriverCBM">Rekap Gaji Driver CBM</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiDriverKebun">Rekap Gaji Driver Kebun</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiMES">Rekap Gaji MES</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiDriverMES">Rekap Gaji Driver MES</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiPBR">Rekap Gaji PBR</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiDriverPBR">Rekap Gaji Driver PBR</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiPBJ">Rekap Gaji PBJ</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiDriverPBJ">Rekap Gaji Driver PBJ</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiBalsri">Rekap Gaji Balsri</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiDriverBalsri">Rekap Gaji Driver Balsri</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo5"
                  15  aria-expanded="true" aria-controls="collapseTwo5">
                    <i class="fas fa-file-alt" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Pengeluaran</span>
                </a>
                <div id="collapseTwo5" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">SDM</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranCBM">Pengeluaran CBM</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranMES">Pengeluaran MES</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPBR">Pengeluaran PBR</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranKebun">Pengeluaran Kebun</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMocashCBM">Mocash CBM</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMocashMES">Mocash MES</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMocashPBR">Mocash PBR</a>
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
                        <?php echo "<a href='VLabaRugi2'><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Laba Rugi Non PSO</h5></a>"; ?>
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
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline  small"  style="color:white;"><?php echo "$nama"; ?></span>
                <img class="img-profile rounded-circle" src="/assets/img/foto_profile/<?= $foto_profile; ?>"><!-- link foto profile --> 
                </a>
                <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="VProfile">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
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
     <?php  echo "<form  method='POST' action='VLRNonPSO' style='margin-bottom: 15px;'>" ?>
    <div>
      <div align="left" style="margin-left: 20px;"> 
        <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1"> 
        <span>-</span>
        <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
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
                    <h3 class="panel-title" align="Center"><strong>Laba Rugi Non PSO</strong></h3>
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
                                    <td class="text-left"><strong>Debit</strong></td>
                                    <td class="text-left"><strong>Kredit</strong></td>
                                    <td class="text-right"><strong>Aksi</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>4-100</td>
                                    <td class="text-left">Penjualan Barang</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-right"></td>
                                </tr>
                                <tr>
                                    <td>4-110</td>
                                    <td class="text-left">Penjualan Refill CBM</td>
                                    <td class="text-left"><?= formatuang($total_pendapatan_refill); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRRefillLR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-110</td>
                                    <td class="text-left">Penjualan Refill MES</td>
                                    <td class="text-left"><?= formatuang($total_pendapatan_refill_mes); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRRefillLR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-110</td>
                                    <td class="text-left">Penjualan Refill PBR</td>
                                    <td class="text-left"><?= formatuang($total_pendapatan_refill_pbr); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRRefillLR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-120</td>
                                    <td class="text-left">Penjualan Baja + Isi CBM</td>
                                    <td class="text-left"><?= formatuang($total_pendapatan_bajaisi); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRBajaIsiLR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-120</td>
                                    <td class="text-left">Penjualan Baja + Isi MES</td>
                                    <td class="text-left"><?= formatuang($total_pendapatan_bajaisi_mes); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRBajaIsiLR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-120</td>
                                    <td class="text-left">Penjualan Baja + Isi PBR</td>
                                    <td class="text-left"><?= formatuang($total_pendapatan_bajaisi_pbr); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRBajaIsiLR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-130</td>
                                    <td class="text-left">Penjualan Baja Kosong CBM</td>
                                    <td class="text-left"><?= formatuang($total_pendapatan_bajakosong); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRBajaKosongLR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-130</td>
                                    <td class="text-left">Penjualan Baja Kosong MES</td>
                                    <td class="text-left"><?= formatuang($total_pendapatan_bajakosong_mes); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRBajaKosongLR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-130</td>
                                    <td class="text-left">Penjualan Baja Kosong PBR</td>
                                    <td class="text-left"><?= formatuang($total_pendapatan_bajakosong_pbr); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRBajaKosongLR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>

                                <tr style="background-color:     #F0F8FF; ">
                                    <td><strong>Total Pendapatan</strong></td>
                                    <td class="thick-line"></td>
                                    <td class="no-line text-left"><?= formatuang($total_pendapatan); ?></td>
                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="thick-line"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr>
                                    <td><strong>5-000</strong></td>
                                    <td class="text-left"><strong>HARGA POKOK PENJUALAN</strong></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-110</td>
                                    <td class="text-left">Pembelian Refill</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_pembelian_refill); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPembelianBarang?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-120</td>
                                    <td class="text-left">Pembelian Baja + Isi</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_pembelian_bajaisi); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPembelianBIsi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-130</td>
                                    <td class="text-left">Pembelian Baja Kosong</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_pembelian_bajakosong); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPembelianBKosong?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-140</td>
                                    <td class="text-left">Sisa Stok CBM</td>
                                    <td class="text-left"><?= formatuang($uang_stok_cbm); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRTransportFee?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>      
                                <tr>
                                    <td>4-140</td>
                                    <td class="text-left">Sisa Stok MES & PBR</td>
                                    <td class="text-left"><?= formatuang($uang_stok_pbr); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRTransportFee?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>      
                            
                                <tr style="background-color:    #F0F8FF;  ">
                                    <td><strong>Total Harga Pokok Penjualan</strong></td>
                                    <td class="thick-line"></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_harga_pokok_penjualan); ?></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="thick-line"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr style="background-color: navy;  color:white;">
                                    <td><strong>LABA KOTOR</strong></td>
                                    <td class="thick-line"></td>
                                    <?php
                                   
                                    if ($laba_kotor > 0) { ?>
                                    
                                    <td class="no-line text-left"><?= formatuang($laba_kotor); ?> </td>
                                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                                    <?php }
                                    else if ($laba_kotor < 0) { ?>

                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <td class="no-line text-left"><?= formatuang($laba_kotor); ?></td>
                                    <?php }
                                    else if ($laba_kotor == 0) { ?>

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
                <span aria-hidden="true">×</span>
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