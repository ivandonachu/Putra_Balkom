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

else{  header("Location: logout.php");
exit;
}


if (isset($_GET['tanggal1'])) {
    $tanggal_awal = $_GET['tanggal1'];
    $tanggal_akhir = $_GET['tanggal2'];
    $tahun1 = date('Y', strtotime($tanggal_awal));
    $tahun2 = date('Y', strtotime($tanggal_akhir)); 
    $bulanx1 = date('m', strtotime($tanggal_awal)); 
    $bulan1 = ltrim($bulanx1, '0');
    $bulanx2 = date('m', strtotime($tanggal_akhir)); 
    $bulan2 = ltrim($bulanx2, '0');
    $tanggal_awal_x = date('Y-m-d', strtotime('+1 days', strtotime(  $tanggal_awal ))); 
    $tanggal_akhir_x = date('Y-m-d', strtotime('+1 days', strtotime(  $tanggal_akhir ))); 
   } 
   
   elseif (isset($_POST['tanggal1'])) {
    $tanggal_awal = $_POST['tanggal1'];
    $tanggal_akhir = $_POST['tanggal2'];
    $tahun1 = date('Y', strtotime($tanggal_awal));
    $tahun2 = date('Y', strtotime($tanggal_akhir)); 
    $bulanx1 = date('m', strtotime($tanggal_awal)); 
    $bulan1 = ltrim($bulanx1, '0');
    $bulanx2 = date('m', strtotime($tanggal_akhir)); 
    $bulan2 = ltrim($bulanx2, '0');
    $tanggal_awal_x = date('Y-m-d', strtotime('+1 days', strtotime(  $tanggal_awal ))); 
    $tanggal_akhir_x = date('Y-m-d', strtotime('+1 days', strtotime(  $tanggal_akhir ))); 
   
   }  
   
   
   
   if($tahun1 == $tahun2){
   
       if($bulan1 == 1){
           $bulan_bunga_bni = $bulan2;
           $bulan_bunga_bri = $bulan2;
       }
       else{
           $bulan_bunga_bni=0;
           $bulan_bunga_bri=0;
           for ($x = $bulan1; $x <= $bulan2; $x++) {
               $bulan_bunga_bni = $bulan_bunga_bni + 1;
               $bulan_bunga_bri = $bulan_bunga_bri + 1;
             }
             
       }
      
   
   }
   else if($tahun1 < $tahun2){
   
   if($bulan1 == 1){
       $bulan_bunga_bni = $bulan2 + 12;
       $bulan_bunga_bri = $bulan2 + 12;
   }
   else{
       $bulan_bunga_bni=0;
           $bulan_bunga_bri=0;
       $bulan2 = $bulan2 + 12;
       for ($x = $bulan1; $x <= $bulan2; $x++) {
           $bulan_bunga_bni = $bulan_bunga_bni + 1;
               $bulan_bunga_bri = $bulan_bunga_bri + 1;
         }
         
   }
   
   }
   

    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }


if ($tanggal_awal == $tanggal_akhir ) {
    //PENDAPATAN
// TOTAL PENJUALAN REFILL
$table = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS penjualan_refill FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal_x' AND kode_akun = '4-110' AND referensi = 'PBR' ");
$data_pendapatan_refill = mysqli_fetch_array($table);
$total_pendapatan_refill = $data_pendapatan_refill['penjualan_refill'];
if (!isset($data_pendapatan_refill['penjualan_refill'])) {
    $total_pendapatan_refill = 0;
}


// TOTAL PENJUALAN BAJA + ISI
$table2 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS penjualan_bajaisi FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND kode_akun = '4-120' AND referensi = 'PBR' ");
$data_pendapatan_bajaisi = mysqli_fetch_array($table2);
$total_pendapatan_bajaisi = $data_pendapatan_bajaisi['penjualan_bajaisi'];
if (!isset($data_pendapatan_bajaisi['penjualan_bajaisi'])) {
    $total_pendapatan_bajaisi = 0;
}


// TOTAL PENJUALAN KOSONG
$table3 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS penjualan_bajakosong FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND kode_akun = '4-130' AND referensi = 'PBR'");
$data_pendapatan_bajakosong = mysqli_fetch_array($table3);
$total_pendapatan_bajakosong = $data_pendapatan_bajakosong['penjualan_bajakosong'];
if (!isset($data_pendapatan_bajakosong['penjualan_bajakosong'])) {
    $total_pendapatan_bajakosong = 0;
}

$total_pendapatan = $total_pendapatan_refill;


//HARGA POKOK PENJUALAN
//TOTAL PEMBELIAN REFILL CBM
$table4 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_refill_cbm FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal' AND kode_akun = '5-110' AND referensi = 'PBR' ");
$data_pembelian_refill_cbm = mysqli_fetch_array($table4);
$total_pembelian_refill_cbm = $data_pembelian_refill_cbm['pembelian_refill_cbm'];
if (!isset($data_pembelian_refill_cbm['pembelian_refill_cbm'])) {
    $total_pembelian_refill_cbm = 0;
}
//TOTAL PEMBELIAN REFILL TK
$table5 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_refill_tk FROM riwayat_pembelian WHERE  tanggal = '$tanggal_awal' AND kode_akun = '5-110' AND referensi = 'PBR' ");
$data_pembelian_refill_tk = mysqli_fetch_array($table5);
$total_pembelian_refill_tk = $data_pembelian_refill_tk['pembelian_refill_tk'];
if (!isset($data_pembelian_refill_tk['pembelian_refill_tk'])) {
    $total_pembelian_refill_tk = 0;
}

$total_pembelian_refill = $total_pembelian_refill_cbm + $total_pembelian_refill_tk;


//TOTAL PEMBELIAN BAJA + ISI CBM
$table6 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_bajaisi_cbm FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'AND kode_akun = '5-120' AND referensi = 'PBR' ");
$data_pembelian_bajaisi_cbm = mysqli_fetch_array($table6);
$total_pembelian_bajaisi_cbm = $data_pembelian_bajaisi_cbm['pembelian_bajaisi_cbm'];
if (!isset($data_pembelian_bajaisi_cbm['pembelian_bajaisi_cbm'])) {
    $total_pembelian_bajaisi_cbm = 0;
}
//TOTAL PEMBELIAN REFILL TK
$table7 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_bajaisi_tk FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal' AND kode_akun = '5-120' AND referensi = 'PBR' ");
$data_pembelian_bajaisi_tk = mysqli_fetch_array($table7);
$total_pembelian_bajaisi_tk = $data_pembelian_bajaisi_tk['pembelian_bajaisi_tk'];
if (!isset($data_pembelian_bajaisi_tk['pembelian_bajaisi_tk'])) {
    $total_pembelian_bajaisi_tk = 0;
}

$total_pembelian_bajaisi = $total_pembelian_bajaisi_cbm + $total_pembelian_bajaisi_tk;


//TOTAL PEMBELIAN KOSONG CBM
$table8 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_bajakosong_cbm FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal' AND kode_akun = '5-130' AND referensi = 'PBR' ");
$data_pembelian_bajakosong_cbm = mysqli_fetch_array($table8);
$total_pembelian_bajakosong_cbm = $data_pembelian_bajakosong_cbm['pembelian_bajakosong_cbm'];
if (!isset($data_pembelian_bajakosong_cbm['pembelian_bajakosong_cbm'])) {
    $total_pembelian_bajakosong_cbm = 0;
}
//TOTAL PEMBELIAN KOSONG TK
$table9 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_bajakosong_tk FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal' AND kode_akun = '5-130' AND referensi = 'PBR' ");
$data_pembelian_bajakosong_tk = mysqli_fetch_array($table9);
$total_pembelian_bajakosong_tk = $data_pembelian_bajakosong_tk['pembelian_bajakosong_tk'];
if (!isset($data_pembelian_bajakosong_tk['pembelian_bajakosong_tk'])) {
    $total_pembelian_bajakosong_tk = 0;
}

$total_pembelian_bajakosong = $total_pembelian_bajakosong_cbm + $total_pembelian_bajakosong_tk;

$total_harga_pokok_penjualan = $total_pembelian_refill + $total_pembelian_bajaisi + $total_pembelian_bajakosong;

//LABA KOTOR
$laba_kotor = $total_pendapatan - $total_harga_pokok_penjualan;

//BIAYA USAHA
//GAJI
$table10 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS total_gaji FROM riwayat_penggajian WHERE tanggal = '$tanggal_awal' ");
$data_gaji = mysqli_fetch_array($table10);
$total_gaji_karyawan = $data_gaji['total_gaji'];
if (!isset($data_gaji['total_gaji'])) {
    $total_gaji_karyawan = 0;
}
//GAJI karyawan new
$table10x = mysqli_query($koneksicbm, "SELECT SUM(total_gaji_diterima) AS total_gaji_new FROM rekap_gaji_pbr  WHERE tanggal = '$tanggal_awal' ");
$data_gaji_x = mysqli_fetch_array($table10x);
$total_gaji_karyawan_new = $data_gaji_x['total_gaji_new'];
if (!isset($data_gaji_x['total_gaji_new'])) {
    $total_gaji_karyawan_new = 0;
}
//GAJI Drivver new
$table101x = mysqli_query($koneksicbm, "SELECT SUM(total_gaji_diterima) AS total_gaji_driverx FROM rekap_gaji_driver_pbr WHERE tanggal = '$tanggal_awal' ");
$data_gaji_driver = mysqli_fetch_array($table101x);
$total_gaji_driver = $data_gaji_driver['total_gaji_driverx'];
if (!isset($data_gaji_driver['total_gaji_driverx'])) {
    $total_gaji_driver = 0;
}

//ALAT TULIS KANTOR TK
$table11 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_atk_tk FROM riwayat_pengeluaran WHERE tanggal = '$tanggal_awal' AND kode_akun = '5-520' AND referensi = 'PB' OR tanggal = '$tanggal_awal' AND kode_akun = '5-520' AND referensi = 'PBR' ");
$data_pengeluaran_atk_tk = mysqli_fetch_array($table11);
$total_pengeluaran_atk_tk = $data_pengeluaran_atk_tk['total_atk_tk'];
if (!isset($data_pengeluaran_atk_tk['total_atk_tk'])) {
    $total_pengeluaran_atk_tk = 0;
}

$total_pengeluaran_atk =$total_pengeluaran_atk_tk;



//Transport /Perjalanan Dinas
$table12 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_transport FROM riwayat_pengeluaran WHERE tanggal = '$tanggal_awal' AND kode_akun = '5-530' AND referensi = 'PB' OR tanggal = '$tanggal_awal' AND kode_akun = '5-530' AND referensi = 'PBR' ");
$data_pengeluaran_transport = mysqli_fetch_array($table12);
$total_pengeluaran_transport = $data_pengeluaran_transport['total_transport'];
if (!isset($data_pengeluaran_transport['total_transport'])) {
    $total_pengeluaran_transport = 0;
}

//Biaya KANTOR
$table13 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_biaya_kantor_tk FROM riwayat_pengeluaran WHERE tanggal = '$tanggal_awal' AND kode_akun = '5-540' AND referensi = 'PB' OR tanggal = '$tanggal_awal' AND kode_akun = '5-540' AND referensi = 'PBR' ");
$data_pengeluaran_kantor_tk = mysqli_fetch_array($table13);
$total_pengeluaran_kantor_tk = $data_pengeluaran_kantor_tk['total_biaya_kantor_tk'];
if (!isset($data_pengeluaran_kantor_tk['total_biaya_kantor_tk'])) {
    $total_pengeluaran_kantor_tk = 0;
}

$total_pengeluaran_kantor =  $total_pengeluaran_kantor_tk;




//Biaya listrik $ telepon kasir toko
$table14 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_listrik_tk FROM riwayat_pengeluaran WHERE tanggal = '$tanggal_awal' AND kode_akun = '5-550' AND referensi = 'PB' OR tanggal = '$tanggal_awal' AND kode_akun = '5-550' AND referensi = 'PBR'");
$data_pengeluaran_listrik_tk = mysqli_fetch_array($table14);
$total_pengeluaran_listrik_tk = $data_pengeluaran_listrik_tk['total_listrik_tk'];
if (!isset($data_pengeluaran_listrik_tk['total_listrik_tk'])) {
    $total_pengeluaran_listrik_tk = 0;
}

$total_pengeluaran_listrik =  $total_pengeluaran_listrik_tk;

//Biaya konsumsi
$table14x = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_konsumsi_tk FROM riwayat_pengeluaran WHERE tanggal = '$tanggal_awal' AND kode_akun = '5-560' AND referensi = 'PB' OR tanggal = '$tanggal_awal' AND kode_akun = '5-560' AND referensi = 'PBR'");
$data_pengeluaran_konsumsi_tk = mysqli_fetch_array($table14x);
$total_pengeluaran_konsumsi_tk = $data_pengeluaran_konsumsi_tk['total_konsumsi_tk'];
if (!isset($data_pengeluaran_konsumsi_tk['total_konsumsi_tk'])) {
    $total_pengeluaran_konsumsi_tk = 0;
}

$total_pengeluaran_konsumsi =  $total_pengeluaran_konsumsi_tk;

//uang makan
$table18 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS uang_makan FROM riwayat_pengeluaran WHERE tanggal = '$tanggal_awal'AND kode_akun = '5-511' AND referensi = 'PB' OR tanggal = '$tanggal_awal' AND kode_akun = '5-511' AND referensi = 'PBR'");
$data_uang_makan = mysqli_fetch_array($table18);
$total_uang_makan = $data_uang_makan['uang_makan'];
if (!isset($data_uang_makan['uang_makan'])) {
    $total_uang_makan = 0;
}



//uang antar gas
$table19 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS uang_antar_gas FROM riwayat_pengeluaran WHERE tanggal = '$tanggal_awal' AND kode_akun = '5-512' AND referensi = 'PB' OR tanggal = '$tanggal_awal' AND kode_akun = '5-512' AND referensi = 'PBR'");
$data_uang_antar_gas = mysqli_fetch_array($table19);
$total_uang_anter_gas = $data_uang_antar_gas['uang_antar_gas'];
if (!isset($data_uang_antar_gas['uang_antar_gas'])) {
    $total_uang_anter_gas = 0;
}



//uang bongkar ulang
$table110 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS uang_bongkar_ulang FROM riwayat_pengeluaran WHERE tanggal = '$tanggal_awal' AND kode_akun = '5-513' AND referensi = 'PB' OR tanggal = '$tanggal_awal' AND kode_akun = '5-513' AND referensi = 'PBR'");
$data_uang_bongkar_ulang = mysqli_fetch_array($table110);
$total_uang_bongkar_ulang = $data_uang_bongkar_ulang['uang_bongkar_ulang'];
if (!isset($data_uang_bongkar_ulang['uang_bongkar_ulang'])) {
    $total_uang_bongkar_ulang = 0;
}


//uang lembur
$table111 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS uang_lembur FROM riwayat_pengeluaran WHERE tanggal = '$tanggal_awal' AND kode_akun = '5-560' AND referensi = 'PB' OR tanggal = '$tanggal_awal'AND kode_akun = '5-560' AND referensi = 'PBR'");
$data_uang_lembur = mysqli_fetch_array($table111);
$total_uang_lembur = $data_uang_lembur['uang_lembur'];
if (!isset($data_uang_lembur['uang_lembur'])) {
    $total_uang_lembur = 0;
}

//Biaya Penjualan dan Pemasaran
//pemasaran kebnerangkatan
$table15 = mysqli_query($koneksipbr, "SELECT SUM(uang_jalan) AS total_pemasaran_tk FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' AND referensi = 'PBR'");
$data_pemasaran_tk = mysqli_fetch_array($table15);
$total_biaya_pemasaran_tk = $data_pemasaran_tk['total_pemasaran_tk'];
if (!isset($data_pemasaran_tk['total_pemasaran_tk'])) {
    $total_biaya_pemasaran_tk = 0;
}


//PEMASARAN PENGELUARAN
$table15a = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_pemasaran_kasir FROM riwayat_pengeluaran WHERE tanggal = '$tanggal_awal' AND kode_akun = '5-580' AND referensi = 'PBR' OR tanggal = '$tanggal_awal' AND kode_akun = '5-580' AND referensi = 'PB'");
$data_pemasaran_kasir = mysqli_fetch_array($table15a);
$total_biaya_pemasaran_kasir = $data_pemasaran_kasir['total_pemasaran_kasir'];
if (!isset($data_pemasaran_kasir['total_pemasaran_kasir'])) {
    $total_biaya_pemasaran_kasir = 0;
}


$total_biaya_pemasaran = $total_biaya_pemasaran_tk + $total_biaya_pemasaran_kasir;




//BIAYA USAHA LAINNYATK
//kasir
$table16 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_biaya_usaha_tk FROM riwayat_pengeluaran WHERE tanggal = '$tanggal_awal' AND kode_akun = '5-590' AND referensi = 'PB'");
$data_biaya_usaha_tk = mysqli_fetch_array($table16);
$total_biaya_usaha_tk = $data_biaya_usaha_tk['total_biaya_usaha_tk'];
if (!isset($data_total_biaya_usaha_tk['total_biaya_usaha_tk'])) {
    $total_biaya_usaha_tk = 0;
}

$total_biaya_usaha =  $total_biaya_usaha_tk;


//BIAYA Perbaikan Kendaraan
//bengkel
$table17 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_bengkel) AS total_perbaikan_ken1 FROM riwayat_pengeluaran_workshop WHERE tanggal = '$tanggal_awal' ");
$data_perbaikan_ken1 = mysqli_fetch_array($table17);
$total_perbaikan_ken1 = $data_perbaikan_ken1['total_perbaikan_ken1'];
if (!isset($data_perbaikan_ken1['total_perbaikan_ken1'])) {
    $total_perbaikan_ken1 = 0;
}
//sparepa
$table177 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_sparepart) AS total_perbaikan_ken2 FROM riwayat_pengeluaran_workshop WHERE tanggal = '$tanggal_awal' ");
$data_perbaikan_ken2 = mysqli_fetch_array($table177);
$total_perbaikan_ken2 = $data_perbaikan_ken2['total_perbaikan_ken2'];
if (!isset($data_perbaikan_ken2['total_perbaikan_ken2'])) {
    $total_perbaikan_ken2 = 0;
}
//biaya pernbaikan toko
$table1777 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_perbaikan_ken3 FROM riwayat_pengeluaran WHERE tanggal = '$tanggal_awal' AND kode_akun = '5-595' AND referensi = 'PBR' OR tanggal = '$tanggal_awal' AND kode_akun = '5-595' AND referensi = 'ME'");
$data_perbaikan_ken3 = mysqli_fetch_array($table1777);
$total_perbaikan_ken3 = $data_perbaikan_ken3['total_perbaikan_ken3'];
if (!isset($data_perbaikan_ken3['total_perbaikan_ken3'])) {
    $total_perbaikan_ken3 = 0;
}


//biaya administrasi new
$table180x = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS total_kredit FROM kredit WHERE tanggal = '$tanggal_awal' AND referensi = 'PBR' ");
$data_kredit = mysqli_fetch_array($table180x);
$total_kredit_kendaraan = $data_kredit['total_kredit'];
if (!isset($data_kredit['total_kredit'])) {
    $total_kredit_kendaraan = 0;
}

$total_perbaikan_kendaraan = $total_perbaikan_ken1 + $total_perbaikan_ken2 + $total_perbaikan_ken3;

$total_biaya_usaha_final = $total_gaji_karyawan + $total_gaji_karyawan_new + $total_gaji_driver + $total_pengeluaran_atk + $total_pengeluaran_transport + $total_pengeluaran_kantor + $total_pengeluaran_listrik + $total_biaya_pemasaran + $total_biaya_usaha +
                            $total_perbaikan_kendaraan + $total_pengeluaran_konsumsi + $total_biaya_prive + $total_uang_makan + $total_uang_anter_gas + $total_uang_bongkar_ulang + $total_uang_makan + $total_kredit_kendaraan;

$laba_bersih_sebelum_pajak = $laba_kotor - $total_biaya_usaha_final;
}





else{
    //PENDAPATAN
// TOTAL PENJUALAN REFILL
$table = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS penjualan_refill FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal_x' AND '$tanggal_akhir_x'AND  referensi = 'PBR' AND kode_akun = '4-110' ");
$data_pendapatan_refill = mysqli_fetch_array($table);
$total_pendapatan_refill = $data_pendapatan_refill['penjualan_refill'];
if (!isset($data_pendapatan_refill['penjualan_refill'])) {
    $total_pendapatan_refill = 0;
}


// TOTAL PENJUALAN BAJA + ISI
$table2 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS penjualan_bajaisi FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '4-120' AND referensi = 'PBR' ");
$data_pendapatan_bajaisi = mysqli_fetch_array($table2);
$total_pendapatan_bajaisi = $data_pendapatan_bajaisi['penjualan_bajaisi'];
if (!isset($data_pendapatan_bajaisi['penjualan_bajaisi'])) {
    $total_pendapatan_bajaisi = 0;
}


// TOTAL PENJUALAN KOSONG
$table3 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS penjualan_bajakosong FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '4-130'AND referensi = 'PBR' ");
$data_pendapatan_bajakosong = mysqli_fetch_array($table3);
$total_pendapatan_bajakosong = $data_pendapatan_bajakosong['penjualan_bajakosong'];
if (!isset($data_pendapatan_bajakosong['penjualan_bajakosong'])) {
    $total_pendapatan_bajakosong = 0;
}


//transport_fee
$table18 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jml_transport_fee FROM transport_fee WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'PBR'");
$data_transport_fee = mysqli_fetch_array($table18);
$total_transport_fee = $data_transport_fee['jml_transport_fee'];
if (!isset($data_transport_fee['jml_transport_fee'])) {
    $total_transport_fee = 0;
}
//transport_fee
$tabel_transport_fee = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS transport_fee FROM pengeluaran_admin WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport Fee' AND referensi = 'PBR' ");
$data_transport_fee_admin  = mysqli_fetch_array($tabel_transport_fee);
$total_transport_fee_admin = $data_transport_fee_admin['transport_fee'];
if (!isset($data_transport_fee_admin['transport_fee'])) {
    $total_transport_fee_admin = 0;
}
$total_transport_fee = $total_transport_fee + $total_transport_fee_admin;

$total_pendapatan = $total_pendapatan_refill + $total_transport_fee ;


//HARGA POKOK PENJUALAN
//TOTAL PEMBELIAN REFILL CBM
$table4 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_refill_cbm FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-110' AND referensi = 'PBR' AND pembayaran = 'Bank BRI PBR'  ");
$data_pembelian_refill_cbm = mysqli_fetch_array($table4);
$total_pembelian_refill_cbm = $data_pembelian_refill_cbm['pembelian_refill_cbm'];
if (!isset($data_pembelian_refill_cbm['pembelian_refill_cbm'])) {
    $total_pembelian_refill_cbm = 0;
}
//TOTAL PEMBELIAN REFILL TK
$table5 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_refill_tk FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-110' AND referensi = 'PBR' ");
$data_pembelian_refill_tk = mysqli_fetch_array($table5);
$total_pembelian_refill_tk = $data_pembelian_refill_tk['pembelian_refill_tk'];
if (!isset($data_pembelian_refill_tk['pembelian_refill_tk'])) {
    $total_pembelian_refill_tk = 0;
}

$total_pembelian_refill = $total_pembelian_refill_cbm ;


//TOTAL PEMBELIAN BAJA + ISI CBM
$table6 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_bajaisi_cbm FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-120' AND referensi = 'PBR' ");
$data_pembelian_bajaisi_cbm = mysqli_fetch_array($table6);
$total_pembelian_bajaisi_cbm = $data_pembelian_bajaisi_cbm['pembelian_bajaisi_cbm'];
if (!isset($data_pembelian_bajaisi_cbm['pembelian_bajaisi_cbm'])) {
    $total_pembelian_bajaisi_cbm = 0;
}
//TOTAL PEMBELIAN REFILL TK
$table7 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_bajaisi_tk FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-120' AND referensi = 'PBR' ");
$data_pembelian_bajaisi_tk = mysqli_fetch_array($table7);
$total_pembelian_bajaisi_tk = $data_pembelian_bajaisi_tk['pembelian_bajaisi_tk'];
if (!isset($data_pembelian_bajaisi_tk['pembelian_bajaisi_tk'])) {
    $total_pembelian_bajaisi_tk = 0;
}

$total_pembelian_bajaisi = $total_pembelian_bajaisi_cbm ;


//TOTAL PEMBELIAN KOSONG CBM
$table8 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_bajakosong_cbm FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-130' AND referensi = 'PBR' ");
$data_pembelian_bajakosong_cbm = mysqli_fetch_array($table8);
$total_pembelian_bajakosong_cbm = $data_pembelian_bajakosong_cbm['pembelian_bajakosong_cbm'];
if (!isset($data_pembelian_bajakosong_cbm['pembelian_bajakosong_cbm'])) {
    $total_pembelian_bajakosong_cbm = 0;
}
//TOTAL PEMBELIAN KOSONG TK
$table9 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pembelian_bajakosong_tk FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-130' AND referensi = 'PBR' ");
$data_pembelian_bajakosong_tk = mysqli_fetch_array($table9);
$total_pembelian_bajakosong_tk = $data_pembelian_bajakosong_tk['pembelian_bajakosong_tk'];
if (!isset($data_pembelian_bajakosong_tk['pembelian_bajakosong_tk'])) {
    $total_pembelian_bajakosong_tk = 0;
}

$total_pembelian_bajakosong = $total_pembelian_bajakosong_cbm + $total_pembelian_bajakosong_tk;

$total_harga_pokok_penjualan = $total_pembelian_refill + $total_pembelian_bajaisi + $total_pembelian_bajakosong;

//LABA KOTOR
$laba_kotor = $total_pendapatan - $total_harga_pokok_penjualan;

//BIAYA USAHA
//GAJI
$table10 = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS total_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'PBR' ");
$data_gaji = mysqli_fetch_array($table10);
$total_gaji_karyawan = $data_gaji['total_gaji'];
if (!isset($data_gaji['total_gaji'])) {
    $total_gaji_karyawan = 0;
}
//GAJI karyawan new
$table10x = mysqli_query($koneksicbm, "SELECT SUM(total_gaji_diterima) AS total_gaji_new FROM rekap_gaji_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
$data_gaji_x = mysqli_fetch_array($table10x);
$total_gaji_karyawan_new = $data_gaji_x['total_gaji_new'];
if (!isset($data_gaji_x['total_gaji_new'])) {
    $total_gaji_karyawan_new = 0;
}

//GAJI Drivver new
$table101x = mysqli_query($koneksicbm, "SELECT SUM(total_gaji_diterima) AS total_gaji_driverx FROM rekap_gaji_driver_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
$data_gaji_driver = mysqli_fetch_array($table101x);
$total_gaji_driver = $data_gaji_driver['total_gaji_driverx'];
if (!isset($data_gaji_driver['total_gaji_driverx'])) {
    $total_gaji_driver = 0;
}


//BIAYA Prive
//kasir
$table16x = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_prive FROM riwayat_pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '3-500' AND referensi = 'PB' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '3-500' AND referensi = 'PBR'");
$data_biaya_prive = mysqli_fetch_array($table16x);
$total_biaya_prive = $data_biaya_prive['total_prive'];
if (!isset($data_biaya_prive['total_prive'])) {
    $total_biaya_prive = 0;
}

//ALAT TULIS KANTOR TK
$table11 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_atk_tk FROM riwayat_pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-520' AND referensi = 'PB' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-520' AND referensi = 'PBR'  ");
$data_pengeluaran_atk_tk = mysqli_fetch_array($table11);
$total_pengeluaran_atk_tk = $data_pengeluaran_atk_tk['total_atk_tk'];
if (!isset($data_pengeluaran_atk_tk['total_atk_tk'])) {
    $total_pengeluaran_atk_tk = 0;
}

//ALAT TULIS KANTOR OP NEW
$table111x = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS total_atk_op_new FROM pengeluaran_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
$data_pengeluaran_atk_op_new = mysqli_fetch_array($table111x);
$total_pengeluaran_atk_op_new = $data_pengeluaran_atk_op_new['total_atk_op_new'];
if (!isset($data_pengeluaran_atk_op_new['total_atk_op_new'])) {
    $total_pengeluaran_atk_op_new = 0;
}

$total_pengeluaran_atk = $total_pengeluaran_atk_tk + $total_pengeluaran_atk_op_new;



//Transport /Perjalanan Dinas
$table12 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_transport FROM riwayat_pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-530' AND referensi = 'PB' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-530' AND referensi = 'PBR'");
$data_pengeluaran_transport = mysqli_fetch_array($table12);
$total_pengeluaran_transport = $data_pengeluaran_transport['total_transport'];
if (!isset($data_pengeluaran_transport['total_transport'])) {
    $total_pengeluaran_transport = 0;
}
//Transport /Perjalanan Dinas new
$table12xx = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS transport_new FROM pengeluaran_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
$data_transport_new = mysqli_fetch_array($table12xx);
$total_transport_new = $data_transport_new['transport_new'];
if (!isset($data_transport_new['transport_new'])) {
    $total_transport_new = 0;
}
$total_pengeluaran_transport = $total_pengeluaran_transport + $total_transport_new;

//Biaya KANTOR
$table13 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_biaya_kantor_tk FROM riwayat_pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-540' AND referensi = 'PB' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-540' AND referensi = 'PBR'");
$data_pengeluaran_kantor_tk = mysqli_fetch_array($table13);
$total_pengeluaran_kantor_tk = $data_pengeluaran_kantor_tk['total_biaya_kantor_tk'];
if (!isset($data_pengeluaran_kantor_tk['total_biaya_kantor_tk'])) {
    $total_pengeluaran_kantor_tk = 0;
}

//Biaya Kantor new
$table133x = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS total_biaya_kantor_new FROM pengeluaran_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor'  ");
$data_pengeluaran_kantor_new = mysqli_fetch_array($table133x);
$total_pengeluaran_kantor_new = $data_pengeluaran_kantor_new['total_biaya_kantor_new'];
if (!isset($data_pengeluaran_kantor_new['total_biaya_kantor_new'])) {
    $total_pengeluaran_kantor_new = 0;
}


$total_pengeluaran_kantor = $total_pengeluaran_kantor_tk + $total_pengeluaran_kantor_new;



//Biaya listrik $ telepon kasir toko
$table14 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_listrik_tk FROM riwayat_pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-550' AND referensi = 'PB' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-550' AND referensi = 'PBR'");
$data_pengeluaran_listrik_tk = mysqli_fetch_array($table14);
$total_pengeluaran_listrik_tk = $data_pengeluaran_listrik_tk['total_listrik_tk'];
if (!isset($data_pengeluaran_listrik_tk['total_listrik_tk'])) {
    $total_pengeluaran_listrik_tk = 0;
}
//Biaya listrik $ telepon kasir new
$table144x = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS total_listrik_new FROM pengeluaran_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon'  ");
$data_pengeluaran_listrik_new = mysqli_fetch_array($table144x);
$total_pengeluaran_listrik_new = $data_pengeluaran_listrik_new['total_listrik_new'];
if (!isset($data_pengeluaran_listrik_new['total_listrik_new'])) {
    $total_pengeluaran_listrik_new = 0;
}

$total_pengeluaran_listrik =  $total_pengeluaran_listrik_tk + $total_pengeluaran_listrik_new;

//Biaya konsumsi
$table14x = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_konsumsi_tk FROM riwayat_pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-560' AND referensi = 'PB' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-560' AND referensi = 'PBR'");
$data_pengeluaran_konsumsi_tk = mysqli_fetch_array($table14x);
$total_pengeluaran_konsumsi_tk = $data_pengeluaran_konsumsi_tk['total_konsumsi_tk'];
if (!isset($data_pengeluaran_konsumsi_tk['total_konsumsi_tk'])) {
    $total_pengeluaran_konsumsi_tk = 0;
}
//Biaya konsumsi new
$table144ax = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS total_listrik_new FROM pengeluaran_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi'  ");
$data_pengeluaran_konsumsi_new = mysqli_fetch_array($table144ax);
$total_pengeluaran_konsumsi_new = $data_pengeluaran_konsumsi_new['total_listrik_new'];
if (!isset($data_pengeluaran_konsumsi_new['total_listrik_new'])) {
    $total_pengeluaran_konsumsi_new = 0;
}

$total_pengeluaran_konsumsi =  $total_pengeluaran_konsumsi_tk + $total_pengeluaran_konsumsi_new; 

//uang makan
$table18 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS uang_makan FROM riwayat_pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-511' AND referensi = 'PB' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-511' AND referensi = 'PBR'");
$data_uang_makan = mysqli_fetch_array($table18);
$total_uang_makan = $data_uang_makan['uang_makan'];
if (!isset($data_uang_makan['uang_makan'])) {
    $total_uang_makan = 0;
}



//uang antar gas
$table19 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS uang_antar_gas FROM riwayat_pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-512' AND referensi = 'PB' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-512' AND referensi = 'PBR'");
$data_uang_antar_gas = mysqli_fetch_array($table19);
$total_uang_anter_gas = $data_uang_antar_gas['uang_antar_gas'];
if (!isset($data_uang_antar_gas['uang_antar_gas'])) {
    $total_uang_anter_gas = 0;
}



//uang bongkar ulang
$table110 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS uang_bongkar_ulang FROM riwayat_pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-513' AND referensi = 'PB' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-513' AND referensi = 'PBR'");
$data_uang_bongkar_ulang = mysqli_fetch_array($table110);
$total_uang_bongkar_ulang = $data_uang_bongkar_ulang['uang_bongkar_ulang'];
if (!isset($data_uang_bongkar_ulang['uang_bongkar_ulang'])) {
    $total_uang_bongkar_ulang = 0;
}


//uang lembur
$table111 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS uang_lembur FROM riwayat_pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-514' AND referensi = 'PB' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-514' AND referensi = 'PBR'");
$data_uang_lembur = mysqli_fetch_array($table111);
$total_uang_lembur = $data_uang_lembur['uang_lembur'];
if (!isset($data_uang_lembur['uang_lembur'])) {
    $total_uang_lembur = 0;
}





//Biaya Penjualan dan Pemasaran
//pemasaran kebnerangkatan
$table15 = mysqli_query($koneksipbr, "SELECT SUM(uang_jalan) AS total_pemasaran_tk FROM riwayat_keberangkatan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'PBR'");
$data_pemasaran_tk = mysqli_fetch_array($table15);
$total_biaya_pemasaran_tk = $data_pemasaran_tk['total_pemasaran_tk'];
if (!isset($data_pemasaran_tk['total_pemasaran_tk'])) {
    $total_biaya_pemasaran_tk = 0;
}


//PEMASARAN PENGELUARAN
$table15a = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_pemasaran_kasir FROM riwayat_pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-580' AND referensi = 'PBR' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-580' AND referensi = 'PB'");
$data_pemasaran_kasir = mysqli_fetch_array($table15a);
$total_biaya_pemasaran_kasir = $data_pemasaran_kasir['total_pemasaran_kasir'];
if (!isset($data_pemasaran_kasir['total_pemasaran_kasir'])) {
    $total_biaya_pemasaran_kasir = 0;
}

//pemasaran new
$table155xx = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS total_pemasaran_new FROM pengeluaran_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Penjualan & Pemasaran' ");
$data_pemasaran_new = mysqli_fetch_array($table155xx);
$total_biaya_pemasaran_new = $data_pemasaran_new['total_pemasaran_new'];
if (!isset($data_pemasaran_new['total_pemasaran_new'])) {
    $total_biaya_pemasaran_new = 0;
}


$total_biaya_pemasaran = $total_biaya_pemasaran_tk + $total_biaya_pemasaran_kasir + $total_biaya_pemasaran_new;





//BIAYA USAHA LAINNYATK
//kasir
$table16 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_biaya_usaha_tk FROM riwayat_pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-590' AND referensi = 'PBR' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND kode_akun = '5-590' AND referensi = 'PB' ");
$data_biaya_usaha_tk = mysqli_fetch_array($table16);
$total_biaya_usaha = $data_biaya_usaha_tk['total_biaya_usaha_tk'];
if (!isset($data_biaya_usaha_tk['total_biaya_usaha_tk'])) {
    $total_biaya_usaha = 0;
}





//BIAYA Perbaikan Kendaraan
//bengkel
$table17 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_bengkel) AS total_perbaikan_ken1 FROM riwayat_pengeluaran_workshop WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
$data_perbaikan_ken1 = mysqli_fetch_array($table17);
$total_perbaikan_ken1 = $data_perbaikan_ken1['total_perbaikan_ken1'];
if (!isset($data_perbaikan_ken1['total_perbaikan_ken1'])) {
    $total_perbaikan_ken1 = 0;
}
//sparepart
$table177 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_sparepart) AS total_perbaikan_ken2 FROM riwayat_pengeluaran_workshop WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
$data_perbaikan_ken2 = mysqli_fetch_array($table177);
$total_perbaikan_ken2 = $data_perbaikan_ken2['total_perbaikan_ken2'];
if (!isset($data_perbaikan_ken2['total_perbaikan_ken2'])) {
    $total_perbaikan_ken2 = 0;
}
//biaya pernbaikan toko
$table1777 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_pengeluaran) AS total_perbaikan_ken3 FROM riwayat_pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_akun = '5-595' AND referensi = 'PBR' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_akun = '5-595' AND referensi = 'PB'");
$data_perbaikan_ken3 = mysqli_fetch_array($table1777);
$total_perbaikan_ken3 = $data_perbaikan_ken3['total_perbaikan_ken3'];
if (!isset($data_perbaikan_ken3['total_perbaikan_ken3'])) {
    $total_perbaikan_ken3 = 0;
}
//pengeluaran lainnya new
$table167xx = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS pengeluaran_lainnya_new FROM pengeluaran_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Pengeluaran Lainnya'  ");
$data_pengeluaran_lainnya_new = mysqli_fetch_array($table167xx);
$total_pengeluaran_lainnya_new = $data_pengeluaran_lainnya_new['pengeluaran_lainnya_new'];
if (!isset($data_pengeluaran_lainnya_new['pengeluaran_lainnya_new'])) {
    $total_pengeluaran_lainnya_new = 0;
}

//biaya administrasi new
$table179x = mysqli_query($koneksipbr, "SELECT SUM(jumlah) AS biaya_administrasi_new FROM pengeluaran_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Administrasi' ");
$data_biaya_administrasi_new = mysqli_fetch_array($table179x);
$total_biaya_administrasi_new = $data_biaya_administrasi_new['biaya_administrasi_new'];
if (!isset($data_biaya_administrasi_new['biaya_administrasi_new'])) {
    $total_biaya_administrasi_new = 0;
}

//biaya administrasi new
$table180x = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS total_kredit FROM kredit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'PBR' ");
$data_kredit = mysqli_fetch_array($table180x);
$total_kredit_kendaraan = $data_kredit['total_kredit'];
if (!isset($data_kredit['total_kredit'])) {
    $total_kredit_kendaraan = 0;
}
//Kredit Pengeluaran admin
$tabel_kredit = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS kredit_pbr FROM pengeluaran_admin WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Kredit' AND referensi = 'PBR' ");
$data_kredit = mysqli_fetch_array($tabel_kredit);
$total_kredit_pbr = $data_kredit['kredit_pbr'];
if (!isset($data_kredit['kredit_pbr'])) {
    $total_kredit_pbr = 0;
}
$total_kredit_kendaraan = $total_kredit_kendaraan + $total_kredit_pbr;


//buanga bank bni
$tabel_bank_bni = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS bunga_bank_bni FROM bunga_bank WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'PBR' AND nama_bank = 'Bank BNI' ");
$data_bank_bni = mysqli_fetch_array($tabel_bank_bni);
$total_bunga_bank_bni = $data_bank_bni['bunga_bank_bni'];
if (!isset($data_bank_bni['bunga_bank_bni'])) {
    $total_bunga_bank_bni = 0;
}

//buanga bank bni
$tabel_pengeluaran_admin = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS bunga_bank_bni FROM pengeluaran_admin WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Bunga Bank' AND referensi = 'PBR' ");
$data_pengeluaran_admin = mysqli_fetch_array($tabel_pengeluaran_admin);
$total_bunga_bank_bni_admin = $data_pengeluaran_admin['bunga_bank_bni'];
if (!isset($data_pengeluaran_admin['bunga_bank_bni'])) {
    $total_bunga_bank_bni_admin = 0;
}
$total_bunga_bank_bni = $total_bunga_bank_bni + $total_bunga_bank_bni_admin;


//Pajak
$tabel_pajak_admin = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS pajak FROM pengeluaran_admin WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Pajak' AND referensi = 'PBR' ");
$data_pajak_admin = mysqli_fetch_array($tabel_pajak_admin);
$total_pajak = $data_pajak_admin['pajak'];
if (!isset($data_pajak_admin['pajak'])) {
    $total_pajak = 0;
}

$total_pengeluaran_lainnya = $total_pengeluaran_lainnya_new;

//Biaya Admin
$tabel_biaya_admin = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS biaya_admin FROM pengeluaran_admin WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Admin' AND referensi = 'PBR' ");
$data_biaya_admin = mysqli_fetch_array($tabel_biaya_admin);
$total_biaya_administrasi_new_x = $data_biaya_admin['biaya_admin'];
if (!isset($data_biaya_admin['biaya_admin'])) {
    $total_biaya_administrasi_new_x = 0;
}


$total_perbaikan_kendaraan = $total_perbaikan_ken1 + $total_perbaikan_ken2 + $total_perbaikan_ken3;

$total_biaya_usaha_final = $total_gaji_karyawan + $total_gaji_karyawan_new + $total_gaji_driver + $total_pengeluaran_atk + $total_pengeluaran_transport + $total_pengeluaran_kantor + $total_pengeluaran_listrik + $total_biaya_pemasaran + $total_pengeluaran_lainnya +
                            $total_perbaikan_kendaraan + $total_biaya_usaha + $total_pengeluaran_konsumsi + $total_biaya_prive + $total_uang_makan + $total_uang_anter_gas + $total_uang_bongkar_ulang + $total_uang_makan  + $total_bunga_bank_bni + 
                             $total_biaya_administrasi_new + $total_biaya_administrasi_new_x + $total_kredit_kendaraan + $total_pajak;

$laba_bersih_sebelum_pajak = $laba_kotor - $total_biaya_usaha_final;


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

  <title>Laporan Laba Rugi PBR</title>

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
 <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsPTPBRMES">
     <div class="sidebar-brand-icon rotate-n-15">

     </div>
     <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="gambar/Logo CBM.png" ></div>
 </a>

 <!-- Divider -->
 <hr class="sidebar-divider my-0">

 
   <!-- Nav Item - Dashboard -->
 <li class="nav-item active" >
     <a class="nav-link" href="DsPTPBRMES">
         <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
         <span style="font-size: 16px;" >Dashboard</span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">
     <!-- Heading -->
     <div class="sidebar-heading" style="font-size: 15px; color:white;">
          Menu PBRMES
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
             <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.CBM/view/DsPTCBM">PT. CBM</a>
             <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/CV.PBJ/view/DsCVPBJ">CV.PBJ</a>
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
       <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
       <span style="font-size: 15px; color:white;" >Laporan Perusahan</span>
   </a>
   <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
       <div class="bg-white py-2 collapse-inner rounded">
           <h6 class="collapse-header" style="font-size: 15px;">Laporan</h6>
           <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan1">Laporan Keuangan</a>
           <a class="collapse-item" style="font-size: 15px;" href="VLPenjualan1">Laporan Penjualan</a>
           <?php if($nama == 'Nyoman Edy Susanto'){
           echo"<a class='collapse-item' style='font-size: 15px;' href='VLabaRugi'>Laba Rugi PBR</a>
                <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiMes'>Laba Rugi MES</a>";
           } ?>
           <a class="collapse-item" style="font-size: 15px;" href="VPenggunaanSaldo">Laporan Saldo</a>
           <a class="collapse-item" style="font-size: 15px;" href="VBonKaryawan">Laporan BON</a>
           <a class="collapse-item" style="font-size: 15px;" href="VRincianSAMES">Rincian SA MES</a>
           <a class="collapse-item" style="font-size: 15px;" href="VRincianSAPBR">Rincian SA PBR</a>
           <a class="collapse-item" style="font-size: 15px;" href="VKeberangkatan">Uang Jalan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaran">Pengeluaran Kasir</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Gaji Karyawan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranWorkshop">Pengeluaran Workshop</a>
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
     <?php  echo "<form  method='POST' action='VLabaRugi2' style='margin-bottom: 15px;'>" ?>
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
                    <h3 class="panel-title" align="Center"><strong>Laporan Laba Rugi PBR</strong></h3>
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
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                <tr>
                                    <td><strong>4-000</strong></td>
                                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-100</td>
                                    <td class="text-left">Penjualan Barang</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-right"></td>
                                </tr>
                                <tr>
                                    <td>4-110</td>
                                    <td class="text-left">Penjualan Refill</td>
                                    <td class="text-left"><?= formatuang($total_pendapatan_refill); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRRefillLR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-120</td>
                                    <td class="text-left">Penjualan Baja + Isi</td>
                                    <td class="text-left"><?= formatuang($total_pendapatan_bajaisi); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRBajaIsiLR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-130</td>
                                    <td class="text-left">Penjualan Baja Kosong</td>
                                    <td class="text-left"><?= formatuang($total_pendapatan_bajakosong); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRBajaKosongLR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-140</td>
                                    <td class="text-left">Transport Fee</td>
                                    <td class="text-left"><?= formatuang($total_transport_fee); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRTransportFee?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-200</td>
                                    <td class="text-left">Retur Penjualan</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>4-300</td>
                                    <td class="text-left">Potongan Penjualan</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
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
                                    <td>5-100</td>
                                    <td class="text-left">Pembelian Barang</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-110</td>
                                    <td class="text-left">Pembelian Refill</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_pembelian_refill); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPembelianCBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
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
                                    <td>5-200</td>
                                    <td class="text-left">Biaya Angkut Pembelian</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-300</td>
                                    <td class="text-left">Retur Pembelian</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-400</td>
                                    <td class="text-left">Potongan Pembelian</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
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
                                <tr>
                                    <td></td>
                                    <td class="thick-line"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="no-line text-left"></td>
                                    <td class="thick-line"></td>
                                </tr>
                                <tr>
                                    <td><strong>5-500</strong></td>
                                    <td class="text-left"><strong>BIAYA USAHA</strong></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-510</td>
                                    <td class="text-left">Gaji Karyawan</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_gaji_karyawan + $total_gaji_karyawan_new); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRGajiKaryawan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-511</td>
                                    <td class="text-left">Gaji Driver</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_gaji_driver); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRGajiDriver?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-511</td>
                                    <td class="text-left">Uang Makan</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_uang_makan); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRUangMakan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-512</td>
                                    <td class="text-left">Uang Antar Gas</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_uang_anter_gas); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRAntarGas?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-513</td>
                                    <td class="text-left">Uang Bongkar Ulang</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_uang_bongkar_ulang); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRBongkarUlang?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-514</td>
                                    <td class="text-left">Uang Lembur</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_uang_lembur); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRLembur?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>3-500</td>
                                    <td class="text-left">Prive</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_biaya_prive); ?></td>
                                    
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPrive?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-520</td>
                                    <td class="text-left">Alat Tulis Kantor</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_pengeluaran_atk); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRATKTK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-530</td>
                                    <td class="text-left">Transport / Perjalan Dinas</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_pengeluaran_transport); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRTransport?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-540</td>
                                    <td class="text-left">Biaya Kantor</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_pengeluaran_kantor); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRBiayaKantorTK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-550</td>
                                    <td class="text-left">Listrik & Telepon</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_pengeluaran_listrik); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRListrikTK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-560</td>
                                    <td class="text-left">Biaya Konsumsi</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                   <td class="text-left"><?= formatuang($total_pengeluaran_konsumsi); ?></td>
                                   <?php echo "<td class='text-right'><a href='VRincianLR/VRKonsumsi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-580</td>
                                    <td class="text-left">Biaya Penjualan & Pemasaran</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_biaya_pemasaran); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPemasaranTF?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-590</td>
                                    <td class="text-left">Pengeluaran Lainnya</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_pengeluaran_lainnya + $total_biaya_usaha); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRUsahaLainnyaTK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-591</td>
                                    <td class="text-left">Biaya Administrasi</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_biaya_administrasi_new + $total_biaya_administrasi_new_x); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRBAdministrasi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-595</td>
                                    <td class="text-left">Biaya Perbaikan Kendaraan</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_perbaikan_kendaraan); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPerbaikanKen?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-597</td>
                                    <td class="text-left">Bunga Bank</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_bunga_bank_bni); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VBungaBankBNI?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-598</td>
                                    <td class="text-left">Kredit Kendaraan</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_kredit_kendaraan); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRKreditKendaraan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-599</td>
                                    <td class="text-left">Biaya Pajak</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_pajak); ?></td>
                                    <?php echo "<td class='text-right'><a href='VRincianLR/VBiayaPajak?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                </tr>
                                <tr style="background-color:    #F0F8FF; ">
                                    <td><strong>Total Biaya Usaha</strong></td>
                                    <td class="thick-line"></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                    <td class="text-left"><?= formatuang($total_biaya_usaha_final); ?></td>
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
                                    <td><strong>5-600</strong></td>
                                    <td class="text-left"><strong>PENDAPATAN & BIAYA LAIN - LAIN</strong></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-610</td>
                                    <td class="text-left">Pendapatan Lain-lain Diluar Usaha</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                   <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr>
                                    <td>5-620</td>
                                    <td class="text-left">Biaya Lain-lain Diluar Usaha</td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                   <td class="text-left"><?= formatuang(0); ?></td>
                                    <?php echo "<td class='text-right'></td>"; ?>
                                </tr>
                                <tr style="background-color: #F0F8FF; ">
                                    <td><strong>Total Biaya lain - lain</strong></td>
                                    <td class="thick-line"></td>
                                    <td class="text-left"><?= formatuang(0); ?></td>
                                   <td class="text-left"><?= formatuang(0); ?></td>
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
                                    <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                                    <td class="thick-line"></td>
                                    <?php
                                   
                                    if ($laba_bersih_sebelum_pajak > 0) { ?>
                                    
                                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak); ?> </td>
                                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                                    <?php }
                                    else if ($laba_bersih_sebelum_pajak < 0) { ?>

                                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak); ?></td>

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