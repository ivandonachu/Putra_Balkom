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
if ($jabatan_valid == 'Manager') {

}

else{  header("Location: logout.php");
exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];


 $tanggal_awal = $_POST['tanggal1'];
 $tanggal_akhir = $_POST['tanggal2'];

 if ($tanggal_awal == $tanggal_akhir) {
    $table = mysqli_query($koneksi, "SELECT * FROM riwayat_penjualan a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun INNER JOIN baja c ON a.kode_baja=c.kode_baja
     WHERE tanggal = '$tanggal_awal' ORDER BY no_transaksi DESC ");
    $table2 = mysqli_query($koneksi, "SELECT * FROM inventory a INNER JOIN baja b ON a.kode_baja=b.kode_baja WHERE b.kode_baja != 'L03K01' AND b.kode_baja != 'L12K01' AND b.kode_baja != 'B05K01' AND b.kode_baja != 'B12K01'");
    
    
    
    //patokan stok awal
    $table3 = mysqli_query($koneksi, "SELECT MAX(no_laporan) FROM laporan_inventory WHERE referensi = 'TK' ");
    $data3 = mysqli_fetch_array($table3);
    $no_laporan_tk = $data3['MAX(no_laporan)'];
    
    //3KG ISI TK
    //3KG isi keluar
    //baja isi LPG 3kg
    $table111 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_3_tk FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K01' AND referensi = 'TK' ");
    $data_penjualan_3_tk = mysqli_fetch_array($table111);
    $total_penjualan_3_tk= $data_penjualan_3_tk['penjualan_3_tk'];
    if (!isset($data_penjualan_3_tk['penjualan_3_tk'])) {
        $total_penjualan_3_tk = 0;
    }
    //3KG isi Masuk
    //baja isi LPG 3kg
    $table222 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_3_tk FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K01' AND referensi = 'TK' ");
    $data_pembelian_3_tk = mysqli_fetch_array($table222);
    $total_pembelian_3_tk = $data_pembelian_3_tk['pembelian_3_tk'];
    if (!isset($data_pembelian_3_tk['pembelian_3_tk'])) {
        $total_pembelian_3_tk = 0;
    }
    //konfirmasi retur
    $tabel1 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_3_tk FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K11' AND referensi = 'TK' ");
    $data_retur_3_tk = mysqli_fetch_array($tabel1);
    $total_retur_3_tk = $data_retur_3_tk['retur_3_tk'];
    if (!isset($data_retur_3_tk['retur_3_tk'])) {
        $total_retur_3_tk = 0;
    }
    //Perpindahan baja masuk
    $tabel2 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_3_tk FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K11' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_3_tk = mysqli_fetch_array($tabel2);
    $total_perpindahan_3_tk = $data_perpindahan_3_tk['perpindahan_3_tk'];
    if (!isset($data_perpindahan_3_tk['perpindahan_3_tk'])) {
        $total_perpindahan_3_tk = 0;
    }
    //Perpindahan baja Keluar
    $tabel3 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_3_tkx FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K11' AND lokasi_awal = 'Toko'  ");
    $data_perpindahan_3_tkx = mysqli_fetch_array($tabel3);
    $total_perpindahan_3_tkx = $data_perpindahan_3_tkx['perpindahan_3_tkx'];
    if (!isset($data_perpindahan_3_tkx['perpindahan_3_tkx'])) {
        $total_perpindahan_3_tkx = 0;
    }
    //stok awal 3kg isi
    $table4 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $data4 = mysqli_fetch_array($table4);
    $stok_awal_3kg_isi_tk = $data4['L03K11'];
    //stok akhir 3kg isi
    $table5 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
    $data5 = mysqli_fetch_array($table5);
    $stok_akhir_3kg_isi_tk = $data5['toko'];
    
    
    //3KG KOSONG TK
    //baja kosong LPG 3kg Keluar
    $table6 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_3ksg_tk FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K10' AND referensi = 'TK' ");
    $data_penjualan_3ksg_tk = mysqli_fetch_array($table6);
    $total_penjualan_3ksg_tk= $data_penjualan_3ksg_tk['penjualan_3ksg_tk'];
    if (!isset($data_penjualan_3ksg_tk['penjualan_3ksg_tk'])) {
        $total_penjualan_3ksg_tk = 0;
    }
    //baja kosong LPG 3kg Masuk
    $table7 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_3ksg_tk FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K10' AND referensi = 'TK' ");
    $data_pembelian_3ksg_tk = mysqli_fetch_array($table7);
    $total_pembelian_3ksg_tk = $data_pembelian_3ksg_tk['pembelian_3ksg_tk'];
    if (!isset($data_pembelian_3_tk['pembelian_3ksg_tk'])) {
        $total_pembelian_3ksg_tk = 0;
    }
    //konfirmasi retur
    $tabel4 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_3ksg_tk FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K10' AND referensi = 'TK' ");
    $data_retur_3ksg_tk = mysqli_fetch_array($tabel4);
    $total_retur_3ksg_tk = $data_retur_3ksg_tk['retur_3ksg_tk'];
    if (!isset($data_retur_3ksg_tk['retur_3ksg_tk'])) {
        $total_retur_3ksg_tk = 0;}
    //Perpindahan baja masuk
    $tabel5 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_3ksg_tk FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K10' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_3ksg_tk = mysqli_fetch_array($tabel5);
    $total_perpindahan_3ksg_tk = $data_perpindahan_3ksg_tk['perpindahan_3ksg_tk'];
    if (!isset($data_perpindahan_3ksg_tk['perpindahan_3ksg_tk'])) {
        $total_perpindahan_3ksg_tk = 0;}
    //Perpindahan baja Keluar
    $tabel6 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_3ksg_tkx FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K10' AND lokasi_awal = 'Toko'  ");
    $data_perpindahan_3ksg_tkx = mysqli_fetch_array($tabel6);
    $total_perpindahan_3ksg_tkx = $data_perpindahan_3ksg_tkx['perpindahan_3ksg_tkx'];
    if (!isset($data_perpindahan_3ksg_tkx['perpindahan_3ksg_tkx'])) {
        $total_perpindahan_3ksg_tkx = 0;}
    //stok awal 3kg kosong
    $table9 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $data9 = mysqli_fetch_array($table9);
    $stok_awal_3kg_ksg_tk = $data9['L03K10'];
    //stok akhir 3kg kosong
    $table10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
    $data10 = mysqli_fetch_array($table10);
    $stok_akhir_3kg_ksg_tk = $data10['toko'];
    
    
    //3KG RETUR 
    //Perpindahan baja masuk
    $tabelr1 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_3rt_tk FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K00' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_3rt_tk = mysqli_fetch_array($tabelr1);
    $total_perpindahan_3rt_tk = $data_perpindahan_3rt_tk['perpindahan_3rt_tk'];
    if (!isset($data_perpindahan_3rt_tk['perpindahan_3rt_tk'])) {
        $total_perpindahan_3rt_tk = 0;}
    //Perpindahan baja Keluar
    $tabelr2 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_3rt_tkx FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K00' AND lokasi_awal = 'Toko'  ");
    $data_perpindahan_3rt_tkx = mysqli_fetch_array($tabelr2);
    $total_perpindahan_3rt_tkx = $data_perpindahan_3rt_tkx['perpindahan_3rt_tkx'];
    if (!isset($data_perpindahan_3rt_tkx['perpindahan_3rt_tkx'])) {
        $total_perpindahan_3rt_tkx = 0;}
    //stok awal 3kg retur
    $tab1 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $dat1 = mysqli_fetch_array($tab1);
    $stok_awal_3kg_rt_tk = $dat1['L03K00'];
    //stok akhir 3kg retur
    $tab2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K00'");
    $dat2 = mysqli_fetch_array($tab2);
    $stok_akhir_3kg_rt_tk = $dat2['toko'];
    
    
    //LPG 12KG ISI
    //baja isi LPG 12kg Keluar
    $table11 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_12_tk FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L12K01' AND referensi = 'TK' ");
    $data_penjualan_12_tk = mysqli_fetch_array($table11);
    $total_penjualan_12_tk= $data_penjualan_12_tk['penjualan_12_tk'];
    if (!isset($data_penjualan_12_tk['penjualan_12_tk'])) {
        $total_penjualan_12_tk = 0;
    }
    //baja isi LPG 12kg Masuk
    $table12 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_12_tk FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L12K01' AND referensi = 'TK' ");
    $data_pembelian_12_tk = mysqli_fetch_array($table12);
    $total_pembelian_12_tk = $data_pembelian_12_tk['pembelian_12_tk'];
    if (!isset($data_pembelian_12_tk['pembelian_12_tk'])) {
        $total_pembelian_12_tk = 0;
    }
    //konfirmasi retur
    $tabel7 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_12_tk FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L12K11' AND referensi = 'TK' ");
    $data_retur_12_tk = mysqli_fetch_array($tabel7);
    $total_retur_12_tk = $data_retur_12_tk['retur_12_tk'];
    if (!isset($data_retur_12_tk['retur_12_tk'])) {
        $total_retur_12_tk = 0;}
    //Perpindahan baja masuk
    $tabel8 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_12_tk FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L12K11' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_12_tk = mysqli_fetch_array($tabel8);
    $total_perpindahan_12_tk = $data_perpindahan_12_tk['perpindahan_12_tk'];
    if (!isset($data_perpindahan_12_tk['perpindahan_12_tk'])) {
        $total_perpindahan_12_tk = 0;}
    //Perpindahan baja Keluar
    $tabel9 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_12_tkx FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L12K11' AND lokasi_awal = 'Toko' ");
    $data_perpindahan_12_tkx = mysqli_fetch_array($tabel9);
    $total_perpindahan_12_tkx = $data_perpindahan_12_tkx['perpindahan_12_tkx'];
    if (!isset($data_perpindahan_12_tkx['perpindahan_12_tkx'])) {
        $total_perpindahan_12_tkx = 0;}
    //stok awal 12kg isi
    $table13 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $data13 = mysqli_fetch_array($table13);
    $stok_awal_12kg_isi_tk = $data13['L12K11'];
    //stok akhir 12kg isi
    $table14 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
    $data14 = mysqli_fetch_array($table14);
    $stok_akhir_12kg_isi_tk = $data14['toko'];
    
    
    
    
    //LPG 12KG kOSONG
    //baja kosong LPG 12kg Keluar
    $table15 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_12ksg_tk FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L12K10' AND referensi = 'TK' ");
    $data_penjualan_12ksg_tk = mysqli_fetch_array($table15);
    $total_penjualan_12ksg_tk= $data_penjualan_12ksg_tk['penjualan_12ksg_tk'];
    if (!isset($data_penjualan_12ksg_tk['penjualan_12ksg_tk'])) {
        $total_penjualan_12ksg_tk = 0;
    }
    //baja kosong LPG 12kg Masuk
    $table16 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_12ksg_tk FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L12K10' AND referensi = 'TK' ");
    $data_pembelian_12ksg_tk = mysqli_fetch_array($table16);
    $total_pembelian_12ksg_tk = $data_pembelian_12ksg_tk['pembelian_12ksg_tk'];
    if (!isset($data_pembelian_12ksg_tk['pembelian_12ksg_tk'])) {
        $total_pembelian_12ksg_tk = 0;
    }
    //konfirmasi retur
    $tabel10 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_12ksg_tk FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L12K10' AND referensi = 'TK' ");
    $data_retur_12ksg_tk = mysqli_fetch_array($tabel10);
    $total_retur_12ksg_tk = $data_retur_12ksg_tk['retur_12ksg_tk'];
    if (!isset($data_retur_12ksg_tk['retur_12ksg_tk'])) {
        $total_retur_12ksg_tk = 0;}
    //Perpindahan baja masuk
    $tabel11 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_12ksg_tk FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L12K10' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_12ksg_tk = mysqli_fetch_array($tabel11);
    $total_perpindahan_12ksg_tk = $data_perpindahan_12ksg_tk['perpindahan_12ksg_tk'];
    if (!isset($data_perpindahan_12ksg_tk['perpindahan_12ksg_tk'])) {
        $total_perpindahan_12ksg_tk = 0;}
    //Perpindahan baja Keluar
    $tabel12 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_12ksg_tkx FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L12K10' AND lokasi_awal = 'Toko'  ");
    $data_perpindahan_12ksg_tkx = mysqli_fetch_array($tabel12);
    $total_perpindahan_12ksg_tkx = $data_perpindahan_12ksg_tkx['perpindahan_12ksg_tkx'];
    if (!isset($data_perpindahan_12ksg_tkx['perpindahan_12ksg_tkx'])) {
        $total_perpindahan_3ksg_tkx = 0;}
    //stok awal 12kg kosong
    $table17 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $data17 = mysqli_fetch_array($table17);
    $stok_awal_12kg_ksg_tk = $data17['L12K10'];
    //stok akhir 12kg kosong
    $table18 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
    $data18 = mysqli_fetch_array($table18);
    $stok_akhir_12kg_ksg_tk = $data18['toko'];
    
    
    //12KG RETUR 
    //Perpindahan baja masuk
    $tabelr3 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_12rt_tk FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L12K00' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_12rt_tk = mysqli_fetch_array($tabelr3);
    $total_perpindahan_12rt_tk = $data_perpindahan_12rt_tk['perpindahan_12rt_tk'];
    if (!isset($data_perpindahan_12rt_tk['perpindahan_12rt_tk'])) {
        $total_perpindahan_12rt_tk = 0;}
    //Perpindahan baja Keluar
    $tabelr4 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_12rt_tkx FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L12K00' AND lokasi_awal = 'Toko'  ");
    $data_perpindahan_12rt_tkx = mysqli_fetch_array($tabelr4);
    $total_perpindahan_12rt_tkx = $data_perpindahan_12rt_tkx['perpindahan_12rt_tkx'];
    if (!isset($data_perpindahan_12rt_tkx['perpindahan_12rt_tkx'])) {
        $total_perpindahan_12rt_tkx = 0;}
    //stok awal 12kg retur
    $tab3 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $dat3 = mysqli_fetch_array($tab3);
    $stok_awal_12kg_rt_tk = $dat3['L12K00'];
    //stok akhir 12kg retur
    $tab4 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K00'");
    $dat4 = mysqli_fetch_array($tab4);
    $stok_akhir_12kg_rt_tk = $dat4['toko'];
    
    
    //BG 5,5 ISI
    //baja isi BG 5,5kg Keluar
    $table19 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b05_tk FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B05K01' AND referensi = 'TK' ");
    $data_penjualan_b05_tk = mysqli_fetch_array($table19);
    $total_penjualan_b05_tk= $data_penjualan_b05_tk['penjualan_b05_tk'];
    if (!isset($data_penjualan_b05_tk['penjualan_b05_tk'])) {
        $total_penjualan_b05_tk = 0;
    }
    //baja isi BG 5,5kg Masuk
    $table20 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b05_tk FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B05K01' AND referensi = 'TK' ");
    $data_pembelian_b05_tk = mysqli_fetch_array($table20);
    $total_pembelian_b05_tk = $data_pembelian_b05_tk['pembelian_b05_tk'];
    if (!isset($data_pembelian_b05_tk['pembelian_b05_tk'])) {
        $total_pembelian_b05_tk = 0;
    }
    //konfirmasi retur
    $tabel13 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b05_tk FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B05K11' AND referensi = 'TK' ");
    $data_retur_b05_tk = mysqli_fetch_array($tabel13);
    $total_retur_b05_tk = $data_retur_b05_tk['retur_b05_tk'];
    if (!isset($data_retur_b05_tk['retur_b05_tk'])) {
        $total_retur_b05_tk = 0;}
    //Perpindahan baja masuk
    $tabel14 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b05_tk FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B05K11' AND lokasi_awal = 'Gudang'");
    $data_perpindahan_b05_tk = mysqli_fetch_array($tabel14);
    $total_perpindahan_b05_tk = $data_perpindahan_b05_tk['perpindahan_b05_tk'];
    if (!isset($data_perpindahan_b05_tk['perpindahan_b05_tk'])) {
        $total_perpindahan_b05_tk = 0;}
    //Perpindahan baja Keluar
    $tabel15 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b05_tkx FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B05K11' AND lokasi_awal = 'Toko' ");
    $data_perpindahan_b05_tkx = mysqli_fetch_array($tabel15);
    $total_perpindahan_b05_tkx = $data_perpindahan_b05_tkx['perpindahan_b05_tkx'];
    if (!isset($data_perpindahan_b05_tkx['perpindahan_b05_tkx'])) {
        $total_perpindahan_b05_tkx = 0;}
    //stok awal 5,5kg isi
    $table21 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $data21 = mysqli_fetch_array($table21);
    $stok_awal_55_isi_tk = $data21['B05K11'];
    //stok akhir 5,5kg isi
    $table22 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
    $data22 = mysqli_fetch_array($table22);
    $stok_akhir_55_isi_tk = $data22['toko'];
    
    
    
    //BG 5,5 Kosong 
    //baja kosong BG 5,5kg Keluar
    $table23 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b05ksg_tk FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B05K10' AND referensi = 'TK' ");
    $data_penjualan_b05ksg_tk = mysqli_fetch_array($table23);
    $total_penjualan_b05ksg_tk= $data_penjualan_b05ksg_tk['penjualan_b05ksg_tk'];
    if (!isset($data_penjualan_b05ksg_tk['penjualan_b05ksg_tk'])) {
        $total_penjualan_b05ksg_tk = 0;
    }
    //baja kosong BG 5,5 KG Masuk
    $table24 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b05ksg_tk FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B05K10' AND referensi = 'TK' ");
    $data_pembelian_b05ksg_tk = mysqli_fetch_array($table24);
    $total_pembelian_b05ksg_tk = $data_pembelian_b05ksg_tk['pembelian_b05ksg_tk'];
    if (!isset($data_pembelian_b05ksg_tk['pembelian_b05ksg_tk'])) {
        $total_pembelian_b05ksg_tk = 0;
    }
    //konfirmasi retur
    $tabel16 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b05ksg_tk FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B05K10' AND referensi = 'TK' ");
    $data_retur_b05ksg_tk = mysqli_fetch_array($tabel16);
    $total_retur_b05ksg_tk = $data_retur_b05ksg_tk['retur_b05ksg_tk'];
    if (!isset($data_retur_b05ksg_tk['retur_b05ksg_tk'])) {
        $total_retur_b05ksg_tk = 0;}
    //Perpindahan baja masuk
    $tabel17 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b05ksg_tk FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B05K10' AND lokasi_awal = 'Gudang'  ");
    $data_perpindahan_b05ksg_tk = mysqli_fetch_array($tabel17);
    $total_perpindahan_b05ksg_tk = $data_perpindahan_b05ksg_tk['perpindahan_b05ksg_tk'];
    if (!isset($data_perpindahan_b05ksg_tk['perpindahan_b05ksg_tk'])) {
        $total_perpindahan_b05ksg_tk = 0;} 
    //Perpindahan baja Keluar
    $tabel18 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b05ksg_tkx FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B05K10' AND lokasi_awal = 'Toko' ");
    $data_perpindahan_b05ksg_tkx = mysqli_fetch_array($tabel18);
    $total_perpindahan_b05ksg_tkx = $data_perpindahan_b05ksg_tkx['perpindahan_b05ksg_tkx'];
    if (!isset($data_perpindahan_b05ksg_tkx['perpindahan_b05ksg_tkx'])) {
        $total_perpindahan_b05ksg_tkx = 0;}
    //stok awal 5,5kg kosong
    $table25 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $data25 = mysqli_fetch_array($table25);
    $stok_awal_55_ksg_tk = $data25['B05K10'];
    //stok akhir 5,5kg kosong
    $table26 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
    $data26 = mysqli_fetch_array($table26);
    $stok_akhir_55_ksg_tk = $data26['toko'];
    
    
    
    //B05KG RETUR 
    //Perpindahan baja masuk
    $tabelr5 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b05rt_tk FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B05K00' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_b05rt_tk = mysqli_fetch_array($tabelr5);
    $total_perpindahan_b05rt_tk = $data_perpindahan_b05rt_tk['perpindahan_b05rt_tk'];
    if (!isset($data_perpindahan_b05rt_tk['perpindahan_b05rt_tk'])) {
        $total_perpindahan_b05rt_tk = 0;}
    //Perpindahan baja Keluar
    $tabelr6 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b05rt_tkx FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B05K00' AND lokasi_awal = 'Toko'  ");
    $data_perpindahan_b05rt_tkx = mysqli_fetch_array($tabelr6);
    $total_perpindahan_b05rt_tkx = $data_perpindahan_b05rt_tkx['perpindahan_b05rt_tkx'];
    if (!isset($data_perpindahan_b05rt_tkx['perpindahan_b05rt_tkx'])) {
        $total_perpindahan_b05rt_tkx = 0;}
    //stok awal 5,5kg retur
    $tab5 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $dat5 = mysqli_fetch_array($tab5);
    $stok_awal_b05_rt_tk = $dat5['B05K00'];
    //stok akhir 5,5kg retur
    $tab6 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K00'");
    $dat6 = mysqli_fetch_array($tab6);
    $stok_akhir_b05_rt_tk = $dat6['toko'];
    
    
    
    //BG 12KG ISI
    //baja isi BG 12kg keluar
    $table27 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b12_tk FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B12K01' AND referensi = 'TK' ");
    $data_penjualan_b12_tk = mysqli_fetch_array($table27);
    $total_penjualan_b12_tk= $data_penjualan_b12_tk['penjualan_b12_tk'];
    if (!isset($data_penjualan_b12_tk['penjualan_b12_tk'])) {
        $total_penjualan_b12_tk = 0;
    }
    //baja isi BG 12kg Masuk
    $table28 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b12_tk FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B12K01' AND referensi = 'TK' ");
    $data_pembelian_b12_tk = mysqli_fetch_array($table28);
    $total_pembelian_b12_tk = $data_pembelian_b12_tk['pembelian_b12_tk'];
    if (!isset($data_pembelian_b12_tk['pembelian_b12_tk'])) {
        $total_pembelian_b12_tk = 0;
    }
    //konfirmasi retur
    $tabel19 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b12_tk FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B12K11' AND referensi = 'TK' ");
    $data_retur_b12_tk = mysqli_fetch_array($tabel19);
    $total_retur_b12_tk = $data_retur_b12_tk['retur_b12_tk'];
    if (!isset($data_retur_b12_tk['retur_b12_tk'])) {
        $total_retur_b12_tk = 0;}
    //Perpindahan baja masuk
    $tabel20 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b12_tk FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B12K11' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_b12_tk = mysqli_fetch_array($tabel20);
    $total_perpindahan_b12_tk = $data_perpindahan_b12_tk['perpindahan_b12_tk'];
    if (!isset($data_perpindahan_b12_tk['perpindahan_b12_tk'])) {
        $total_perpindahan_b12_tk = 0;}
    //Perpindahan baja Keluar
    $tabel21 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b12_tkx FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B12K11' AND lokasi_awal = 'Toko' ");
    $data_perpindahan_b12_tkx = mysqli_fetch_array($tabel21);
    $total_perpindahan_b12_tkx = $data_perpindahan_b12_tkx['perpindahan_b12_tkx'];
    if (!isset($data_perpindahan_b12_tkx['perpindahan_b12_tkx'])) {
        $total_perpindahan_b12_tkx = 0;}
    //stok awal 12kg isi
    $table29 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $data29 = mysqli_fetch_array($table29);
    $stok_awal_b12_isi_tk = $data29['B12K11'];
    //stok akhir 12kg isi
    $table30 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
    $data30 = mysqli_fetch_array($table30);
    $stok_akhir_b12_isi_tk = $data30['toko'];
    
    
    
    //BG 12KH KOSONG
    //baja kosong BG 12kg KELUAR
    $table31 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b12ksg_tk FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B12K10' AND referensi = 'TK' ");
    $data_penjualan_b12ksg_tk = mysqli_fetch_array($table31);
    $total_penjualan_b12ksg_tk= $data_penjualan_b12ksg_tk['penjualan_b12ksg_tk'];
    if (!isset($data_penjualan_b12ksg_tk['penjualan_b12ksg_tk'])) {
        $total_penjualan_b12ksg_tk = 0;
    }
    //baja kosong BG 12kg Masuk
    $table32 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b12ksg_tk FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B12K10' AND referensi = 'TK' ");
    $data_pembelian_b12ksg_tk = mysqli_fetch_array($table32);
    $total_pembelian_b12ksg_tk = $data_pembelian_b12ksg_tk['pembelian_b12ksg_tk'];
    if (!isset($data_pembelian_b12ksg_tk['pembelian_b12ksg_tk'])) {
        $total_pembelian_b12ksg_tk = 0;
    }
    //konfirmasi retur
    $tabel22 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b12ksg_tk FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B12K10' AND referensi = 'TK' ");
    $data_retur_b12ksg_tk = mysqli_fetch_array($tabel22);
    $total_retur_b12ksg_tk = $data_retur_b12ksg_tk['retur_b12ksg_tk'];
    if (!isset($data_retur_b1ksg_tk['retur_b12ksg_tk'])) {
        $total_retur_b12ksg_tk = 0;}
    //Perpindahan baja masuk
    $tabel23 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b12ksg_tk FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B12K10' AND lokasi_awal = 'Gudang'  ");
    $data_perpindahan_b12ksg_tk = mysqli_fetch_array($tabel23);
    $total_perpindahan_b12ksg_tk = $data_perpindahan_b12ksg_tk['perpindahan_b12ksg_tk'];
    if (!isset($data_perpindahan_b12ksg_tk['perpindahan_b12ksg_tk'])) {
        $total_perpindahan_b12ksg_tk = 0;}
    //Perpindahan baja Keluar
    $tabel24 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b12ksg_tkx FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B12K10' AND lokasi_awal = 'Toko' ");
    $data_perpindahan_b12ksg_tkx = mysqli_fetch_array($tabel24);
    $total_perpindahan_b12ksg_tkx = $data_perpindahan_b12ksg_tkx['perpindahan_b12ksg_tkx'];
    if (!isset($data_perpindahan_b12ksg_tkx['perpindahan_b12ksg_tkx'])) {
        $total_perpindahan_b12ksg_tkx = 0;}
    //stok awal 5,5kg kosong
    $table33 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $data33 = mysqli_fetch_array($table33);
    $stok_awal_b12_ksg_tk = $data33['B05K10'];
    //stok akhir 5,5kg kosong
    $table34 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
    $data34 = mysqli_fetch_array($table34);
    $stok_akhir_b12_ksg_tk = $data34['toko'];
    
    
    //B12KG RETUR 
    //Perpindahan baja masuk
    $tabelr7 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b12rt_tk FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B12K00' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_b12rt_tk = mysqli_fetch_array($tabelr7);
    $total_perpindahan_b12rt_tk = $data_perpindahan_b12rt_tk['perpindahan_b12rt_tk'];
    if (!isset($data_perpindahan_b12rt_tk['perpindahan_b12rt_tk'])) {
        $total_perpindahan_b12rt_tk = 0;}
    //Perpindahan baja Keluar
    $tabelr8 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b12rt_tkx FROM riwayat_perpindahan_baja WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B12K00' AND lokasi_awal = 'Toko'  ");
    $data_perpindahan_b12rt_tkx = mysqli_fetch_array($tabelr8);
    $total_perpindahan_b12rt_tkx = $data_perpindahan_b12rt_tkx['perpindahan_b12rt_tkx'];
    if (!isset($data_perpindahan_b12rt_tkx['perpindahan_b12rt_tkx'])) {
        $total_perpindahan_b12rt_tkx = 0;}
    //stok awal 5,5kg retur
    $tab7 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $dat7 = mysqli_fetch_array($tab7);
    $stok_awal_b12_rt_tk = $dat7['B12K00'];
    //stok akhir 5,5kg retur
    $tab8 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K00'");
    $dat8 = mysqli_fetch_array($tab8);
    $stok_akhir_b12_rt_tk = $dat8['toko'];
    
    
    
    
    
    
    //GUDANG GUDANG GUDANG GUDANG GUDANGGUDANG
    //GUDANG
    //patokan stok awal
    $table35 = mysqli_query($koneksi, "SELECT MAX(no_laporan) FROM laporan_inventory WHERE referensi = 'GD' ");
    $data35 = mysqli_fetch_array($table35);
    $no_laporan_gd = $data35['MAX(no_laporan)'];
    
    //3KG ISI TK
    //3KG isi keluar
    //baja isi LPG 3kg
    $table36 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_3_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L03K01' AND referensi = 'GD' ");
    $data_penjualan_3_gd = mysqli_fetch_array($table36);
    $total_penjualan_3_gd= $data_penjualan_3_gd['penjualan_3_gd'];
    if (!isset($data_penjualan_3_gd['penjualan_3_gd'])) {
        $total_penjualan_3_gd = 0;
    }
    //3KG isi Masuk
    //baja isi LPG 3kg
    $table37 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_3_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K01' AND referensi = 'CBM' ");
    $data_pembelian_3_gd = mysqli_fetch_array($table37);
    $total_pembelian_3_gd = $data_pembelian_3_gd['pembelian_3_gd'];
    if (!isset($data_pembelian_3_gd['pembelian_3_gd'])) {
        $total_pembelian_3_gd = 0;
    }
    //konfirmasi retur
    $tabelgd1 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_3_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K11' AND referensi = 'GD' ");
    $data_retur_3_gd = mysqli_fetch_array($tabelgd1);
    $total_retur_3_gd = $data_retur_3_gd['retur_3_gd'];
    if (!isset($data_retur_3_gd['retur_3_gd'])) {
        $total_retur_3_gd = 0;
    }
    //Keberangkatan
    $tabelgd2 = mysqli_query($koneksi, "SELECT SUM(L03K11) AS brangkat_3 FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' ");
    $data_brangkat_3 = mysqli_fetch_array($tabelgd2);
    $total_brangkat_3 = $data_brangkat_3['brangkat_3'];
    if (!isset($data_brangkat_3['brangkat_3'])) {
        $total_brangkat_3 = 0;
    }
    //stok awal 3kg isi
    $table38 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data38 = mysqli_fetch_array($table38);
    $stok_awal_3kg_isi_gd = $data38['L03K11'];
    //stok akhir 3kg isi
    $table39 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
    $data39 = mysqli_fetch_array($table39);
    $stok_akhir_3kg_isi_gd = $data39['gudang'];
    
    
    //3KG KOSONG TK
    //baja kosong LPG 3kg Keluar
    $table40 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_3ksg_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L03K10' AND referensi = 'GD' ");
    $data_penjualan_3ksg_gd = mysqli_fetch_array($table40);
    $total_penjualan_3ksg_gd = $data_penjualan_3ksg_gd['penjualan_3ksg_gd'];
    if (!isset($data_penjualan_3ksg_gd['penjualan_3ksg_gd'])) {
        $total_penjualan_3ksg_gd = 0;
    }
    //baja kosong LPG 3kg Masuk
    $table41 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_3ksg_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L03K10' AND referensi = 'CBM' ");
    $data_pembelian_3ksg_gd = mysqli_fetch_array($table41);
    $total_pembelian_3ksg_gd = $data_pembelian_3ksg_gd['pembelian_3ksg_gd'];
    if (!isset($data_pembelian_3_gd['pembelian_3ksg_gd'])) {
        $total_pembelian_3ksg_gd = 0;
    }
    //konfirmasi retur
    $tabelgd3 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_3ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K10' AND referensi = 'GD' ");
    $data_retur_3ksg_gd = mysqli_fetch_array($tabelgd3);
    $total_retur_3ksg_gd = $data_retur_3ksg_gd['retur_3ksg_gd'];
    if (!isset($data_retur_3ksg_gd['retur_3ksg_gd'])) {
        $total_retur_3ksg_gd = 0;
    }
    //stok awal 3kg kosong
    $table42 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data42 = mysqli_fetch_array($table42);
    $stok_awal_3kg_ksg_gd = $data42['L03K10'];
    //stok akhir 3kg kosong
    $table43 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
    $data43 = mysqli_fetch_array($table43);
    $stok_akhir_3kg_ksg_gd = $data43['gudang'];
    
    
    
    //3kg retur
    //stok awal 3kg retur
    $tabgd1 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $datgd1 = mysqli_fetch_array($tabgd1);
    $stok_awal_3_rt_gd = $datgd1['L03K00'];
    //stok akhir 3kg retur
    $tabgd2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K00'");
    $datgd2 = mysqli_fetch_array($tabgd2);
    $stok_akhir_3kg_rt_gd = $datgd2['gudang'];
    //KEBERANGKATAN
    $tabelgd4 = mysqli_query($koneksi, "SELECT SUM(L03K00) AS brangkat_3_rtr FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' ");
    $data_brangkat_3_rtr = mysqli_fetch_array($tabelgd4);
    $total_brangkat_3_rtr = $data_brangkat_3_rtr['brangkat_3_rtr'];
    if (!isset($data_brangkat_3_rtr['brangkat_3_rtr'])) {
        $total_brangkat_3_rtr = 0;
    }
    
    
    
    
    //LPG 12KG ISI
    //baja isi LPG 12kg Keluar
    $table44 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_12_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L12K01' AND referensi = 'GD' ");
    $data_penjualan_12_gd = mysqli_fetch_array($table44);
    $total_penjualan_12_gd = $data_penjualan_12_gd['penjualan_12_gd'];
    if (!isset($data_penjualan_12_gd['penjualan_12_gd'])) {
        $total_penjualan_12_gd = 0;
    }
    //baja isi LPG 12kg Masuk
    $table45 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_12_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L12K01' AND referensi = 'CBM' ");
    $data_pembelian_12_gd = mysqli_fetch_array($table45);
    $total_pembelian_12_gd = $data_pembelian_12_gd['pembelian_12_gd'];
    if (!isset($data_pembelian_12_gd['pembelian_12_gd'])) {
        $total_pembelian_12_gd = 0;
    }
    //konfirmasi retur
    $tabelgd5 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_12_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L12K11' AND referensi = 'GD' ");
    $data_retur_12_gd = mysqli_fetch_array($tabelgd5);
    $total_retur_12_gd = $data_retur_12_gd['retur_12_gd'];
    if (!isset($data_retur_12_gd['retur_12_gd'])) {
        $total_retur_12_gd = 0;
    }
    //Keberangkatan
    $tabelgd6 = mysqli_query($koneksi, "SELECT SUM(L12K11) AS brangkat_12 FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' ");
    $data_brangkat_12 = mysqli_fetch_array($tabelgd6);
    $total_brangkat_12 = $data_brangkat_12['brangkat_12'];
    if (!isset($data_brangkat_12['brangkat_12'])) {
        $total_brangkat_12 = 0;
    }
    //stok awal 12kg isi
    $table46 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data46 = mysqli_fetch_array($table46);
    $stok_awal_12kg_isi_gd = $data46['L12K11'];
    //stok akhir 12kg isi
    $table47 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
    $data47 = mysqli_fetch_array($table47);
    $stok_akhir_12kg_isi_gd = $data47['gudang'];
    
    
    //LPG 12KG kOSONG
    //baja kosong LPG 12kg Keluar
    $table48 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_12ksg_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L12K10' AND referensi = 'GD' ");
    $data_penjualan_12ksg_gd = mysqli_fetch_array($table48);
    $total_penjualan_12ksg_gd= $data_penjualan_12ksg_gd['penjualan_12ksg_gd'];
    if (!isset($data_penjualan_12ksg_gd['penjualan_12ksg_gd'])) {
        $total_penjualan_12ksg_gd = 0;
    }
    //baja kosong LPG 12kg Masuk
    $table49 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_12ksg_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L12K10' AND referensi = 'CBM' ");
    $data_pembelian_12ksg_gd = mysqli_fetch_array($table49);
    $total_pembelian_12ksg_gd = $data_pembelian_12ksg_gd['pembelian_12ksg_gd'];
    if (!isset($data_pembelian_12ksg_gd['pembelian_12ksg_gd'])) {
        $total_pembelian_12ksg_gd = 0;
    }
    //konfirmasi retur
    $tabelgd7 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_12ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L12K10' AND referensi = 'GD' ");
    $data_retur_12ksg_gd = mysqli_fetch_array($tabelgd7);
    $total_retur_12ksg_gd = $data_retur_12ksg_gd['retur_12ksg_gd'];
    if (!isset($data_retur_12ksg_gd['retur_12ksg_gd'])) {
        $total_retur_12ksg_gd = 0;
    }
    //stok awal 12kg kosong
    $table50 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data50 = mysqli_fetch_array($table50);
    $stok_awal_12kg_ksg_gd = $data50['L12K10'];
    //stok akhir 12kg kosong
    $table51 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
    $data51 = mysqli_fetch_array($table51);
    $stok_akhir_12kg_ksg_gd  = $data51['gudang'];
    
    
    
    // LPG12kg retur
    //stok awal 3kg retur
    $tabgd3 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $datgd3 = mysqli_fetch_array($tabgd3);
    $stok_awal_12_rt_gd = $datgd3['L12K00'];
    //stok akhir 3kg retur
    $tabgd4 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K00'");
    $datgd4 = mysqli_fetch_array($tabgd4);
    $stok_akhir_12_rt_gd = $datgd4['gudang'];
    //keberangkatan
    $tabelgd8 = mysqli_query($koneksi, "SELECT SUM(L12K00) AS brangkat_12_rtr FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' ");
    $data_brangkat_12_rtr = mysqli_fetch_array($tabelgd8);
    $total_brangkat_12_rtr = $data_brangkat_12_rtr['brangkat_12_rtr'];
    if (!isset($data_brangkat_12_rtr['brangkat_12_rtr'])) {
        $total_brangkat_12_rtr = 0;
    }
    
    
    
    //BG 5,5 ISI
    //baja isi BG 5,5kg Keluar
    $table52 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b05_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B05K01' AND referensi = 'GD' ");
    $data_penjualan_b05_gd = mysqli_fetch_array($table52);
    $total_penjualan_b05_gd= $data_penjualan_b05_gd['penjualan_b05_gd'];
    if (!isset($data_penjualan_b05_gd['penjualan_b05_gd'])) {
        $total_penjualan_b05_gd = 0;
    }
    //baja isi BG 5,5kg Masuk
    $table53 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b05_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B05K01' AND referensi = 'CBM' ");
    $data_pembelian_b05_gd = mysqli_fetch_array($table53);
    $total_pembelian_b05_gd = $data_pembelian_b05_gd['pembelian_b05_gd'];
    if (!isset($data_pembelian_b05_gd['pembelian_b05_gd'])) {
        $total_pembelian_b05_gd = 0;
    }
    //konfirmasi retur
    $tabelgd9 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b05_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B05K11' AND referensi = 'GD' ");
    $data_retur_b05_gd = mysqli_fetch_array($tabelgd9);
    $total_retur_b05_gd = $data_retur_b05_gd['retur_b05_gd'];
    if (!isset($data_retur_b05_gd['retur_b05_gd'])) {
        $total_retur_b05_gd = 0;
    }
    //Keberangkatan
    $tabelgd10 = mysqli_query($koneksi, "SELECT SUM(B05K11) AS brangkat_b05 FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' ");
    $data_brangkat_b05 = mysqli_fetch_array($tabelgd10);
    $total_brangkat_b05 = $data_brangkat_b05['brangkat_b05'];
    if (!isset($data_brangkat_b05['brangkat_b05'])) {
        $total_brangkat_b05 = 0;
    }
    //stok awal 5,5kg isi
    $table54 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data54 = mysqli_fetch_array($table54);
    $stok_awal_b05_isi_gd = $data54['B05K11'];
    //stok akhir 5,5kg isi
    $table55 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
    $data55 = mysqli_fetch_array($table55);
    $stok_akhir_b05_isi_gd = $data55['gudang'];
    
    
    
    //BG 5,5 Kosong 
    //baja kosong BG 5,5kg Keluar
    $table56 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b05ksg_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B05K10' AND referensi = 'GD' ");
    $data_penjualan_b05ksg_gd = mysqli_fetch_array($table56);
    $total_penjualan_b05ksg_gd= $data_penjualan_b05ksg_gd['penjualan_b05ksg_gd'];
    if (!isset($data_penjualan_b05ksg_gd['penjualan_b05ksg_gd'])) {
        $total_penjualan_b05ksg_gd = 0;
    }
    //baja kosong BG 5,5 KG Masuk
    $table57 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b05ksg_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B05K10' AND referensi = 'CBM' ");
    $data_pembelian_b05ksg_gd = mysqli_fetch_array($table57);
    $total_pembelian_b05ksg_gd = $data_pembelian_b05ksg_gd['pembelian_b05ksg_gd'];
    if (!isset($data_pembelian_b05ksg_gd['pembelian_b05ksg_gd'])) {
        $total_pembelian_b05ksg_gd = 0;
    }
    //konfirmasi retur
    $tabelgd11 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b05ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B05K10' AND referensi = 'GD' ");
    $data_retur_b05ksg_gd = mysqli_fetch_array($tabelgd11);
    $total_retur_b05ksg_gd = $data_retur_b05ksg_gd['retur_b05ksg_gd'];
    if (!isset($data_retur_b05ksg_gd['retur_b05ksg_gd'])) {
        $total_retur_b05ksg_gd = 0;
    }
    //stok awal 5,5kg kosong
    $table58 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data58 = mysqli_fetch_array($table58);
    $stok_awal_b05_ksg_gd = $data58['B05K10'];
    //stok akhir 5,5kg kosong
    $table59 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
    $data59 = mysqli_fetch_array($table59);
    $stok_akhir_b05_ksg_gd = $data59['gudang'];
    
    
    
    // BG 55 kg retur
    //stok awal 3kg retur
    $tabgd5 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $datgd5 = mysqli_fetch_array($tabgd5);
    $stok_awal_b05_rt_gd = $datgd5['B05K00'];
    //stok akhir 3kg retur
    $tabgd6 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K00'");
    $datgd6 = mysqli_fetch_array($tabgd6);
    $stok_akhir_b05_rt_gd = $datgd6['gudang'];
    //keberangkatan
    $tabelgd12 = mysqli_query($koneksi, "SELECT SUM(B05K00) AS brangkat_b05_rtr FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' ");
    $data_brangkat_b05_rtr = mysqli_fetch_array($tabelgd12);
    $total_brangkat_b05_rtr = $data_brangkat_b05_rtr['brangkat_b05_rtr'];
    if (!isset($data_brangkat_b05_rtr['brangkat_b05_rtr'])) {
        $total_brangkat_b05_rtr = 0;
    }
    
    
    
    //BG 12KG ISI
    //baja isi BG 12kg keluar
    $table60 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b12_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B12K01' AND referensi = 'GD' ");
    $data_penjualan_b12_gd = mysqli_fetch_array($table60);
    $total_penjualan_b12_gd= $data_penjualan_b12_gd['penjualan_b12_gd'];
    if (!isset($data_penjualan_b12_gd['penjualan_b12_gd'])) {
        $total_penjualan_b12_gd = 0;
    }
    //baja isi BG 12kg Masuk
    $table61 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b12_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B12K01' AND referensi = 'CBM' ");
    $data_pembelian_b12_gd = mysqli_fetch_array($table61);
    $total_pembelian_b12_gd = $data_pembelian_b12_gd['pembelian_b12_gd'];
    if (!isset($data_pembelian_b12_gd['pembelian_b12_gd'])) {
        $total_pembelian_b12_gd = 0;
    }
    //konfirmasi retur
    $tabelgd13 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b12_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B12K11' AND referensi = 'GD' ");
    $data_retur_b12_gd = mysqli_fetch_array($tabelgd13);
    $total_retur_b12_gd = $data_retur_b12_gd['retur_b12_gd'];
    if (!isset($data_retur_b12_gd['retur_b12_gd'])) {
        $total_retur_b12_gd = 0;
    }
    //Keberangkatan
    $tabelgd14 = mysqli_query($koneksi, "SELECT SUM(B12K11) AS brangkat_b12 FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' ");
    $data_brangkat_b12 = mysqli_fetch_array($tabelgd14);
    $total_brangkat_b12 = $data_brangkat_b12['brangkat_b12'];
    if (!isset($data_brangkat_b12['brangkat_b12'])) {
        $total_brangkat_b12 = 0;
    }
    //stok awal 12kg isi
    $table62 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data62 = mysqli_fetch_array($table62);
    $stok_awal_b12_isi_gd = $data62['B12K11'];
    //stok akhir 12kg isi
    $table63 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
    $data63 = mysqli_fetch_array($table63);
    $stok_akhir_b12_isi_gd = $data63['gudang'];
    
    
    
    //BG 12KH KOSONG
    //baja kosong BG 12kg KELUAR
    $table64 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b12ksg_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B12K10' AND referensi = 'GD' ");
    $data_penjualan_b12ksg_gd = mysqli_fetch_array($table64);
    $total_penjualan_b12ksg_gd= $data_penjualan_b12ksg_gd['penjualan_b12ksg_gd'];
    if (!isset($data_penjualan_b12ksg_gd['penjualan_b12ksg_gd'])) {
        $total_penjualan_b12ksg_gd = 0;
    }
    //baja kosong BG 12kg Masuk
    $table65 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b12ksg_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B12K10' AND referensi = 'CBM' ");
    $data_pembelian_b12ksg_gd = mysqli_fetch_array($table65);
    $total_pembelian_b12ksg_gd = $data_pembelian_b12ksg_gd['pembelian_b12ksg_gd'];
    if (!isset($data_pembelian_b12ksg_gd['pembelian_b12ksg_gd'])) {
        $total_pembelian_b12ksg_gd = 0;
    }
    //konfirmasi retur
    $tabelgd15 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b12ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B12K10' AND referensi = 'GD' ");
    $data_retur_b12ksg_gd = mysqli_fetch_array($tabelgd15);
    $total_retur_b12ksg_gd = $data_retur_b12ksg_gd['retur_b12ksg_gd'];
    if (!isset($data_retur_b12ksg_gd['retur_b12ksg_gd'])) {
        $total_retur_b12ksg_gd = 0;
    }
    //stok awal 5,5kg kosong
    $table66 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data66 = mysqli_fetch_array($table66);
    $stok_awal_b12_ksg_gd = $data66['B12K10'];
    //stok akhir 5,5kg kosong
    $table67 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
    $data67 = mysqli_fetch_array($table67);
    $stok_akhir_b12_ksg_gd = $data67['gudang'];
    
    
    
    
    // BG 55 kg retur
    //stok awal 3kg retur
    $tabgd7 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $datgd7 = mysqli_fetch_array($tabgd7);
    $stok_awal_b12_rt_gd = $datgd7['B12K00'];
    //stok akhir 3kg retur
    $tabgd8 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K00'");
    $datgd8 = mysqli_fetch_array($tabgd8);
    $stok_akhir_b12_rt_gd = $datgd8['gudang'];
    //keberangkatan
    $tabelgd16 = mysqli_query($koneksi, "SELECT SUM(B12K00) AS brangkat_b12_rtr FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' ");
    $data_brangkat_b12_rtr = mysqli_fetch_array($tabelgd16);
    $total_brangkat_b12_rtr = $data_brangkat_b12_rtr['brangkat_b12_rtr'];
    if (!isset($data_brangkat_b12_rtr['brangkat_b12_rtr'])) {
        $total_brangkat_b12_rtr = 0;
    }
    
    }
    
    
    
    
    
    
    
    //elseeeeeeee
    else{
    $table = mysqli_query($koneksi, "SELECT * FROM riwayat_penjualan a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun INNER JOIN baja c ON a.kode_baja=c.kode_baja
     WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY tanggal ASC");
    $table2 = mysqli_query($koneksi, "SELECT * FROM inventory a INNER JOIN baja b ON a.kode_baja=b.kode_baja WHERE b.kode_baja != 'L03K01' AND b.kode_baja != 'L12K01' AND b.kode_baja != 'B05K01' AND b.kode_baja != 'B12K01'");
    
    
    
    //patokan stok awal
    $table3 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE referensi = 'TK' AND tanggal = '$tanggal_awal' ");
    $data3 = mysqli_fetch_array($table3);
    $no_laporan_tk = $data3['no_laporan'];
    
    //3KG ISI TK
    //3KG isi keluar
    //baja isi LPG 3kg
    $table111 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_3_tk FROM riwayat_penjualan WHERE  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K01' AND referensi = 'TK' ");
    $data_penjualan_3_tk = mysqli_fetch_array($table111);
    $total_penjualan_3_tk= $data_penjualan_3_tk['penjualan_3_tk'];
    if (!isset($data_penjualan_3_tk['penjualan_3_tk'])) {
        $total_penjualan_3_tk = 0;
    }
    //3KG isi Masuk
    //baja isi LPG 3kg
    $table222 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_3_tk FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K01' AND referensi = 'TK' ");
    $data_pembelian_3_tk = mysqli_fetch_array($table222);
    $total_pembelian_3_tk = $data_pembelian_3_tk['pembelian_3_tk'];
    if (!isset($data_pembelian_3_tk['pembelian_3_tk'])) {
        $total_pembelian_3_tk = 0;
    }
    //konfirmasi retur
    $tabel1 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_3_tk FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K11' AND referensi = 'TK' ");
    $data_retur_3_tk = mysqli_fetch_array($tabel1);
    $total_retur_3_tk = $data_retur_3_tk['retur_3_tk'];
    if (!isset($data_retur_3_tk['retur_3_tk'])) {
        $total_retur_3_tk = 0;
    }
    //Perpindahan baja masuk
    $tabel2 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_3_tk FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K11' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_3_tk = mysqli_fetch_array($tabel2);
    $total_perpindahan_3_tk = $data_perpindahan_3_tk['perpindahan_3_tk'];
    if (!isset($data_perpindahan_3_tk['perpindahan_3_tk'])) {
        $total_perpindahan_3_tk = 0;
    }
    //Perpindahan baja Keluar
    $tabel3 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_3_tkx FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K11' AND lokasi_awal = 'Toko'  ");
    $data_perpindahan_3_tkx = mysqli_fetch_array($tabel3);
    $total_perpindahan_3_tkx = $data_perpindahan_3_tkx['perpindahan_3_tkx'];
    if (!isset($data_perpindahan_3_tkx['perpindahan_3_tkx'])) {
        $total_perpindahan_3_tkx = 0;
    }
    //stok awal 3kg isi
    $table4 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $data4 = mysqli_fetch_array($table4);
    $stok_awal_3kg_isi_tk = $data4['L03K11'];
    //stok akhir 3kg isi
    $table5 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
    $data5 = mysqli_fetch_array($table5);
    $stok_akhir_3kg_isi_tk = $data5['toko'];
    
    
    //3KG KOSONG TK
    //baja kosong LPG 3kg Keluar
    $table6 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_3ksg_tk FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K10' AND referensi = 'TK' ");
    $data_penjualan_3ksg_tk = mysqli_fetch_array($table6);
    $total_penjualan_3ksg_tk= $data_penjualan_3ksg_tk['penjualan_3ksg_tk'];
    if (!isset($data_penjualan_3ksg_tk['penjualan_3ksg_tk'])) {
        $total_penjualan_3ksg_tk = 0;
    }
    //baja kosong LPG 3kg Masuk
    $table7 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_3ksg_tk FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K10' AND referensi = 'TK' ");
    $data_pembelian_3ksg_tk = mysqli_fetch_array($table7);
    $total_pembelian_3ksg_tk = $data_pembelian_3ksg_tk['pembelian_3ksg_tk'];
    if (!isset($data_pembelian_3_tk['pembelian_3ksg_tk'])) {
        $total_pembelian_3ksg_tk = 0;
    }
    //konfirmasi retur
    $tabel4 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_3ksg_tk FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K10' AND referensi = 'TK' ");
    $data_retur_3ksg_tk = mysqli_fetch_array($tabel4);
    $total_retur_3ksg_tk = $data_retur_3ksg_tk['retur_3ksg_tk'];
    if (!isset($data_retur_3ksg_tk['retur_3ksg_tk'])) {
        $total_retur_3ksg_tk = 0;}
    //Perpindahan baja masuk
    $tabel5 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_3ksg_tk FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K10' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_3ksg_tk = mysqli_fetch_array($tabel5);
    $total_perpindahan_3ksg_tk = $data_perpindahan_3ksg_tk['perpindahan_3ksg_tk'];
    if (!isset($data_perpindahan_3ksg_tk['perpindahan_3ksg_tk'])) {
        $total_perpindahan_3ksg_tk = 0;}
    //Perpindahan baja Keluar
    $tabel6 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_3ksg_tkx FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K10' AND lokasi_awal = 'Toko'  ");
    $data_perpindahan_3ksg_tkx = mysqli_fetch_array($tabel6);
    $total_perpindahan_3ksg_tkx = $data_perpindahan_3ksg_tkx['perpindahan_3ksg_tkx'];
    if (!isset($data_perpindahan_3ksg_tkx['perpindahan_3ksg_tkx'])) {
        $total_perpindahan_3ksg_tkx = 0;}
    //stok awal 3kg kosong
    $table9 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $data9 = mysqli_fetch_array($table9);
    $stok_awal_3kg_ksg_tk = $data9['L03K10'];
    //stok akhir 3kg kosong
    $table10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
    $data10 = mysqli_fetch_array($table10);
    $stok_akhir_3kg_ksg_tk = $data10['toko'];
    
    
    //3KG RETUR 
    //Perpindahan baja masuk
    $tabelr1 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_3rt_tk FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K00' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_3rt_tk = mysqli_fetch_array($tabelr1);
    $total_perpindahan_3rt_tk = $data_perpindahan_3rt_tk['perpindahan_3rt_tk'];
    if (!isset($data_perpindahan_3rt_tk['perpindahan_3rt_tk'])) {
        $total_perpindahan_3rt_tk = 0;}
    //Perpindahan baja Keluar
    $tabelr2 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_3rt_tkx FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K00' AND lokasi_awal = 'Toko'  ");
    $data_perpindahan_3rt_tkx = mysqli_fetch_array($tabelr2);
    $total_perpindahan_3rt_tkx = $data_perpindahan_3rt_tkx['perpindahan_3rt_tkx'];
    if (!isset($data_perpindahan_3rt_tkx['perpindahan_3rt_tkx'])) {
        $total_perpindahan_3rt_tkx = 0;}
    //stok awal 3kg retur
    $tab1 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $dat1 = mysqli_fetch_array($tab1);
    $stok_awal_3kg_rt_tk = $dat1['L03K00'];
    //stok akhir 3kg retur
    $tab2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K00'");
    $dat2 = mysqli_fetch_array($tab2);
    $stok_akhir_3kg_rt_tk = $dat2['toko'];
    
    
    //LPG 12KG ISI
    //baja isi LPG 12kg Keluar
    $table11 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_12_tk FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L12K01' AND referensi = 'TK' ");
    $data_penjualan_12_tk = mysqli_fetch_array($table11);
    $total_penjualan_12_tk= $data_penjualan_12_tk['penjualan_12_tk'];
    if (!isset($data_penjualan_12_tk['penjualan_12_tk'])) {
        $total_penjualan_12_tk = 0;
    }
    //baja isi LPG 12kg Masuk
    $table12 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_12_tk FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'L12K01' AND referensi = 'TK' ");
    $data_pembelian_12_tk = mysqli_fetch_array($table12);
    $total_pembelian_12_tk = $data_pembelian_12_tk['pembelian_12_tk'];
    if (!isset($data_pembelian_12_tk['pembelian_12_tk'])) {
        $total_pembelian_12_tk = 0;
    }
    //konfirmasi retur
    $tabel7 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_12_tk FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L12K11' AND referensi = 'TK' ");
    $data_retur_12_tk = mysqli_fetch_array($tabel7);
    $total_retur_12_tk = $data_retur_12_tk['retur_12_tk'];
    if (!isset($data_retur_12_tk['retur_12_tk'])) {
        $total_retur_12_tk = 0;}
    //Perpindahan baja masuk
    $tabel8 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_12_tk FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L12K11' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_12_tk = mysqli_fetch_array($tabel8);
    $total_perpindahan_12_tk = $data_perpindahan_12_tk['perpindahan_12_tk'];
    if (!isset($data_perpindahan_12_tk['perpindahan_12_tk'])) {
        $total_perpindahan_12_tk = 0;}
    //Perpindahan baja Keluar
    $tabel9 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_12_tkx FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L12K11' AND lokasi_awal = 'Toko' ");
    $data_perpindahan_12_tkx = mysqli_fetch_array($tabel9);
    $total_perpindahan_12_tkx = $data_perpindahan_12_tkx['perpindahan_12_tkx'];
    if (!isset($data_perpindahan_12_tkx['perpindahan_12_tkx'])) {
        $total_perpindahan_12_tkx = 0;}
    //stok awal 12kg isi
    $table13 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $data13 = mysqli_fetch_array($table13);
    $stok_awal_12kg_isi_tk = $data13['L12K11'];
    //stok akhir 12kg isi
    $table14 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
    $data14 = mysqli_fetch_array($table14);
    $stok_akhir_12kg_isi_tk = $data14['toko'];
    
    
    
    
    //LPG 12KG kOSONG
    //baja kosong LPG 12kg Keluar
    $table15 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_12ksg_tk FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'L12K10' AND referensi = 'TK' ");
    $data_penjualan_12ksg_tk = mysqli_fetch_array($table15);
    $total_penjualan_12ksg_tk= $data_penjualan_12ksg_tk['penjualan_12ksg_tk'];
    if (!isset($data_penjualan_12ksg_tk['penjualan_12ksg_tk'])) {
        $total_penjualan_12ksg_tk = 0;
    }
    //baja kosong LPG 12kg Masuk
    $table16 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_12ksg_tk FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'L12K10' AND referensi = 'TK' ");
    $data_pembelian_12ksg_tk = mysqli_fetch_array($table16);
    $total_pembelian_12ksg_tk = $data_pembelian_12ksg_tk['pembelian_12ksg_tk'];
    if (!isset($data_pembelian_12ksg_tk['pembelian_12ksg_tk'])) {
        $total_pembelian_12ksg_tk = 0;
    }
    //konfirmasi retur
    $tabel10 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_12ksg_tk FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L12K10' AND referensi = 'TK' ");
    $data_retur_12ksg_tk = mysqli_fetch_array($tabel10);
    $total_retur_12ksg_tk = $data_retur_12ksg_tk['retur_12ksg_tk'];
    if (!isset($data_retur_12ksg_tk['retur_12ksg_tk'])) {
        $total_retur_12ksg_tk = 0;}
    //Perpindahan baja masuk
    $tabel11 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_12ksg_tk FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L12K10' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_12ksg_tk = mysqli_fetch_array($tabel11);
    $total_perpindahan_12ksg_tk = $data_perpindahan_12ksg_tk['perpindahan_12ksg_tk'];
    if (!isset($data_perpindahan_12ksg_tk['perpindahan_12ksg_tk'])) {
        $total_perpindahan_12ksg_tk = 0;}
    //Perpindahan baja Keluar
    $tabel12 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_12ksg_tkx FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L12K10' AND lokasi_awal = 'Toko'  ");
    $data_perpindahan_12ksg_tkx = mysqli_fetch_array($tabel12);
    $total_perpindahan_12ksg_tkx = $data_perpindahan_12ksg_tkx['perpindahan_12ksg_tkx'];
    if (!isset($data_perpindahan_12ksg_tkx['perpindahan_12ksg_tkx'])) {
        $total_perpindahan_3ksg_tkx = 0;}
    //stok awal 12kg kosong
    $table17 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $data17 = mysqli_fetch_array($table17);
    $stok_awal_12kg_ksg_tk = $data17['L12K10'];
    //stok akhir 12kg kosong
    $table18 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
    $data18 = mysqli_fetch_array($table18);
    $stok_akhir_12kg_ksg_tk = $data18['toko'];
    
    
    //12KG RETUR 
    //Perpindahan baja masuk
    $tabelr3 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_12rt_tk FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L12K00' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_12rt_tk = mysqli_fetch_array($tabelr3);
    $total_perpindahan_12rt_tk = $data_perpindahan_12rt_tk['perpindahan_12rt_tk'];
    if (!isset($data_perpindahan_12rt_tk['perpindahan_12rt_tk'])) {
        $total_perpindahan_12rt_tk = 0;}
    //Perpindahan baja Keluar
    $tabelr4 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_12rt_tkx FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L12K00' AND lokasi_awal = 'Toko'  ");
    $data_perpindahan_12rt_tkx = mysqli_fetch_array($tabelr4);
    $total_perpindahan_12rt_tkx = $data_perpindahan_12rt_tkx['perpindahan_12rt_tkx'];
    if (!isset($data_perpindahan_12rt_tkx['perpindahan_12rt_tkx'])) {
        $total_perpindahan_12rt_tkx = 0;}
    //stok awal 12kg retur
    $tab3 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $dat3 = mysqli_fetch_array($tab3);
    $stok_awal_12kg_rt_tk = $dat3['L12K00'];
    //stok akhir 12kg retur
    $tab4 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K00'");
    $dat4 = mysqli_fetch_array($tab4);
    $stok_akhir_12kg_rt_tk = $dat4['toko'];
    
    
    //BG 5,5 ISI
    //baja isi BG 5,5kg Keluar
    $table19 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b05_tk FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B05K01' AND referensi = 'TK' ");
    $data_penjualan_b05_tk = mysqli_fetch_array($table19);
    $total_penjualan_b05_tk= $data_penjualan_b05_tk['penjualan_b05_tk'];
    if (!isset($data_penjualan_b05_tk['penjualan_b05_tk'])) {
        $total_penjualan_b05_tk = 0;
    }
    //baja isi BG 5,5kg Masuk
    $table20 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b05_tk FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B05K01' AND referensi = 'TK' ");
    $data_pembelian_b05_tk = mysqli_fetch_array($table20);
    $total_pembelian_b05_tk = $data_pembelian_b05_tk['pembelian_b05_tk'];
    if (!isset($data_pembelian_b05_tk['pembelian_b05_tk'])) {
        $total_pembelian_b05_tk = 0;
    }
    //konfirmasi retur
    $tabel13 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b05_tk FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B05K11' AND referensi = 'TK' ");
    $data_retur_b05_tk = mysqli_fetch_array($tabel13);
    $total_retur_b05_tk = $data_retur_b05_tk['retur_b05_tk'];
    if (!isset($data_retur_b05_tk['retur_b05_tk'])) {
        $total_retur_b05_tk = 0;}
    //Perpindahan baja masuk
    $tabel14 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b05_tk FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B05K11' AND lokasi_awal = 'Gudang'");
    $data_perpindahan_b05_tk = mysqli_fetch_array($tabel14);
    $total_perpindahan_b05_tk = $data_perpindahan_b05_tk['perpindahan_b05_tk'];
    if (!isset($data_perpindahan_b05_tk['perpindahan_b05_tk'])) {
        $total_perpindahan_b05_tk = 0;}
    //Perpindahan baja Keluar
    $tabel15 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b05_tkx FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B05K11' AND lokasi_awal = 'Toko' ");
    $data_perpindahan_b05_tkx = mysqli_fetch_array($tabel15);
    $total_perpindahan_b05_tkx = $data_perpindahan_b05_tkx['perpindahan_b05_tkx'];
    if (!isset($data_perpindahan_b05_tkx['perpindahan_b05_tkx'])) {
        $total_perpindahan_b05_tkx = 0;}
    //stok awal 5,5kg isi
    $table21 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $data21 = mysqli_fetch_array($table21);
    $stok_awal_55_isi_tk = $data21['B05K11'];
    //stok akhir 5,5kg isi
    $table22 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
    $data22 = mysqli_fetch_array($table22);
    $stok_akhir_55_isi_tk = $data22['toko'];
    
    
    
    //BG 5,5 Kosong 
    //baja kosong BG 5,5kg Keluar
    $table23 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b05ksg_tk FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B05K10' AND referensi = 'TK' ");
    $data_penjualan_b05ksg_tk = mysqli_fetch_array($table23);
    $total_penjualan_b05ksg_tk= $data_penjualan_b05ksg_tk['penjualan_b05ksg_tk'];
    if (!isset($data_penjualan_b05ksg_tk['penjualan_b05ksg_tk'])) {
        $total_penjualan_b05ksg_tk = 0;
    }
    //baja kosong BG 5,5 KG Masuk
    $table24 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b05ksg_tk FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B05K10' AND referensi = 'TK' ");
    $data_pembelian_b05ksg_tk = mysqli_fetch_array($table24);
    $total_pembelian_b05ksg_tk = $data_pembelian_b05ksg_tk['pembelian_b05ksg_tk'];
    if (!isset($data_pembelian_b05ksg_tk['pembelian_b05ksg_tk'])) {
        $total_pembelian_b05ksg_tk = 0;
    }
    //konfirmasi retur
    $tabel16 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b05ksg_tk FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B05K10' AND referensi = 'TK' ");
    $data_retur_b05ksg_tk = mysqli_fetch_array($tabel16);
    $total_retur_b05ksg_tk = $data_retur_b05ksg_tk['retur_b05ksg_tk'];
    if (!isset($data_retur_b05ksg_tk['retur_b05ksg_tk'])) {
        $total_retur_b05ksg_tk = 0;}
    //Perpindahan baja masuk
    $tabel17 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b05ksg_tk FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B05K10' AND lokasi_awal = 'Gudang'  ");
    $data_perpindahan_b05ksg_tk = mysqli_fetch_array($tabel17);
    $total_perpindahan_b05ksg_tk = $data_perpindahan_b05ksg_tk['perpindahan_b05ksg_tk'];
    if (!isset($data_perpindahan_b05ksg_tk['perpindahan_b05ksg_tk'])) {
        $total_perpindahan_b05ksg_tk = 0;} 
    //Perpindahan baja Keluar
    $tabel18 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b05ksg_tkx FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B05K10' AND lokasi_awal = 'Toko' ");
    $data_perpindahan_b05ksg_tkx = mysqli_fetch_array($tabel18);
    $total_perpindahan_b05ksg_tkx = $data_perpindahan_b05ksg_tkx['perpindahan_b05ksg_tkx'];
    if (!isset($data_perpindahan_b05ksg_tkx['perpindahan_b05ksg_tkx'])) {
        $total_perpindahan_b05ksg_tkx = 0;}
    //stok awal 5,5kg kosong
    $table25 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $data25 = mysqli_fetch_array($table25);
    $stok_awal_55_ksg_tk = $data25['B05K10'];
    //stok akhir 5,5kg kosong
    $table26 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
    $data26 = mysqli_fetch_array($table26);
    $stok_akhir_55_ksg_tk = $data26['toko'];
    
    
    
    //B05KG RETUR 
    //Perpindahan baja masuk
    $tabelr5 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b05rt_tk FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B05K00' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_b05rt_tk = mysqli_fetch_array($tabelr5);
    $total_perpindahan_b05rt_tk = $data_perpindahan_b05rt_tk['perpindahan_b05rt_tk'];
    if (!isset($data_perpindahan_b05rt_tk['perpindahan_b05rt_tk'])) {
        $total_perpindahan_b05rt_tk = 0;}
    //Perpindahan baja Keluar
    $tabelr6 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b05rt_tkx FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B05K00' AND lokasi_awal = 'Toko'  ");
    $data_perpindahan_b05rt_tkx = mysqli_fetch_array($tabelr6);
    $total_perpindahan_b05rt_tkx = $data_perpindahan_b05rt_tkx['perpindahan_b05rt_tkx'];
    if (!isset($data_perpindahan_b05rt_tkx['perpindahan_b05rt_tkx'])) {
        $total_perpindahan_b05rt_tkx = 0;}
    //stok awal 5,5kg retur
    $tab5 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $dat5 = mysqli_fetch_array($tab5);
    $stok_awal_b05_rt_tk = $dat5['B05K00'];
    //stok akhir 5,5kg retur
    $tab6 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K00'");
    $dat6 = mysqli_fetch_array($tab6);
    $stok_akhir_b05_rt_tk = $dat6['toko'];
    
    
    
    //BG 12KG ISI
    //baja isi BG 12kg keluar
    $table27 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b12_tk FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B12K01' AND referensi = 'TK' ");
    $data_penjualan_b12_tk = mysqli_fetch_array($table27);
    $total_penjualan_b12_tk= $data_penjualan_b12_tk['penjualan_b12_tk'];
    if (!isset($data_penjualan_b12_tk['penjualan_b12_tk'])) {
        $total_penjualan_b12_tk = 0;
    }
    //baja isi BG 12kg Masuk
    $table28 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b12_tk FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B12K01' AND referensi = 'TK' ");
    $data_pembelian_b12_tk = mysqli_fetch_array($table28);
    $total_pembelian_b12_tk = $data_pembelian_b12_tk['pembelian_b12_tk'];
    if (!isset($data_pembelian_b12_tk['pembelian_b12_tk'])) {
        $total_pembelian_b12_tk = 0;
    }
    //konfirmasi retur
    $tabel19 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b12_tk FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B12K11' AND referensi = 'TK' ");
    $data_retur_b12_tk = mysqli_fetch_array($tabel19);
    $total_retur_b12_tk = $data_retur_b12_tk['retur_b12_tk'];
    if (!isset($data_retur_b12_tk['retur_b12_tk'])) {
        $total_retur_b12_tk = 0;}
    //Perpindahan baja masuk
    $tabel20 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b12_tk FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B12K11' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_b12_tk = mysqli_fetch_array($tabel20);
    $total_perpindahan_b12_tk = $data_perpindahan_b12_tk['perpindahan_b12_tk'];
    if (!isset($data_perpindahan_b12_tk['perpindahan_b12_tk'])) {
        $total_perpindahan_b12_tk = 0;}
    //Perpindahan baja Keluar
    $tabel21 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b12_tkx FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B12K11' AND lokasi_awal = 'Toko' ");
    $data_perpindahan_b12_tkx = mysqli_fetch_array($tabel21);
    $total_perpindahan_b12_tkx = $data_perpindahan_b12_tkx['perpindahan_b12_tkx'];
    if (!isset($data_perpindahan_b12_tkx['perpindahan_b12_tkx'])) {
        $total_perpindahan_b12_tkx = 0;}
    //stok awal 12kg isi
    $table29 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $data29 = mysqli_fetch_array($table29);
    $stok_awal_b12_isi_tk = $data29['B12K11'];
    //stok akhir 12kg isi
    $table30 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
    $data30 = mysqli_fetch_array($table30);
    $stok_akhir_b12_isi_tk = $data30['toko'];
    
    
    
    //BG 12KH KOSONG
    //baja kosong BG 12kg KELUAR
    $table31 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b12ksg_tk FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B12K10' AND referensi = 'TK' ");
    $data_penjualan_b12ksg_tk = mysqli_fetch_array($table31);
    $total_penjualan_b12ksg_tk= $data_penjualan_b12ksg_tk['penjualan_b12ksg_tk'];
    if (!isset($data_penjualan_b12ksg_tk['penjualan_b12ksg_tk'])) {
        $total_penjualan_b12ksg_tk = 0;
    }
    //baja kosong BG 12kg Masuk
    $table32 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b12ksg_tk FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B12K10' AND referensi = 'TK' ");
    $data_pembelian_b12ksg_tk = mysqli_fetch_array($table32);
    $total_pembelian_b12ksg_tk = $data_pembelian_b12ksg_tk['pembelian_b12ksg_tk'];
    if (!isset($data_pembelian_b12ksg_tk['pembelian_b12ksg_tk'])) {
        $total_pembelian_b12ksg_tk = 0;
    }
    //konfirmasi retur
    $tabel22 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b12ksg_tk FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B12K10' AND referensi = 'TK' ");
    $data_retur_b12ksg_tk = mysqli_fetch_array($tabel22);
    $total_retur_b12ksg_tk = $data_retur_b12ksg_tk['retur_b12ksg_tk'];
    if (!isset($data_retur_b1ksg_tk['retur_b12ksg_tk'])) {
        $total_retur_b12ksg_tk = 0;}
    //Perpindahan baja masuk
    $tabel23 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b12ksg_tk FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B12K10' AND lokasi_awal = 'Gudang'  ");
    $data_perpindahan_b12ksg_tk = mysqli_fetch_array($tabel23);
    $total_perpindahan_b12ksg_tk = $data_perpindahan_b12ksg_tk['perpindahan_b12ksg_tk'];
    if (!isset($data_perpindahan_b12ksg_tk['perpindahan_b12ksg_tk'])) {
        $total_perpindahan_b12ksg_tk = 0;}
    //Perpindahan baja Keluar
    $tabel24 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b12ksg_tkx FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B12K10' AND lokasi_awal = 'Toko' ");
    $data_perpindahan_b12ksg_tkx = mysqli_fetch_array($tabel24);
    $total_perpindahan_b12ksg_tkx = $data_perpindahan_b12ksg_tkx['perpindahan_b12ksg_tkx'];
    if (!isset($data_perpindahan_b12ksg_tkx['perpindahan_b12ksg_tkx'])) {
        $total_perpindahan_b12ksg_tkx = 0;}
    //stok awal 5,5kg kosong
    $table33 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $data33 = mysqli_fetch_array($table33);
    $stok_awal_b12_ksg_tk = $data33['B05K10'];
    //stok akhir 5,5kg kosong
    $table34 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
    $data34 = mysqli_fetch_array($table34);
    $stok_akhir_b12_ksg_tk = $data34['toko'];
    
    
    //B12KG RETUR 
    //Perpindahan baja masuk
    $tabelr7 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b12rt_tk FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B12K00' AND lokasi_awal = 'Gudang' ");
    $data_perpindahan_b12rt_tk = mysqli_fetch_array($tabelr7);
    $total_perpindahan_b12rt_tk = $data_perpindahan_b12rt_tk['perpindahan_b12rt_tk'];
    if (!isset($data_perpindahan_b12rt_tk['perpindahan_b12rt_tk'])) {
        $total_perpindahan_b12rt_tk = 0;}
    //Perpindahan baja Keluar
    $tabelr8 = mysqli_query($koneksi, "SELECT SUM(qty) AS perpindahan_b12rt_tkx FROM riwayat_perpindahan_baja WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B12K00' AND lokasi_awal = 'Toko'  ");
    $data_perpindahan_b12rt_tkx = mysqli_fetch_array($tabelr8);
    $total_perpindahan_b12rt_tkx = $data_perpindahan_b12rt_tkx['perpindahan_b12rt_tkx'];
    if (!isset($data_perpindahan_b12rt_tkx['perpindahan_b12rt_tkx'])) {
        $total_perpindahan_b12rt_tkx = 0;}
    //stok awal 5,5kg retur
    $tab7 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_tk'");
    $dat7 = mysqli_fetch_array($tab7);
    $stok_awal_b12_rt_tk = $dat7['B12K00'];
    //stok akhir 5,5kg retur
    $tab8 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K00'");
    $dat8 = mysqli_fetch_array($tab8);
    $stok_akhir_b12_rt_tk = $dat8['toko'];
    
    
    
    
    
    
    //GUDANG GUDANG GUDANG GUDANG GUDANGGUDANG
    //GUDANG
    //patokan stok awal
    $table35 = mysqli_query($koneksi, "SELECT no_laporan FROM laporan_inventory WHERE referensi = 'GD'  AND tanggal = '$tanggal_awal' ");
    $data35 = mysqli_fetch_array($table35);
    $no_laporan_gd = $data35['no_laporan'];
    
    //3KG ISI TK
    //3KG isi keluar
    //baja isi LPG 3kg
    $table36 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_3_gd FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'L03K01' AND referensi = 'GD' ");
    $data_penjualan_3_gd = mysqli_fetch_array($table36);
    $total_penjualan_3_gd= $data_penjualan_3_gd['penjualan_3_gd'];
    if (!isset($data_penjualan_3_gd['penjualan_3_gd'])) {
        $total_penjualan_3_gd = 0;
    }
    //3KG isi Masuk
    //baja isi LPG 3kg
    $table37 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_3_gd FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K01' AND referensi = 'CBM' ");
    $data_pembelian_3_gd = mysqli_fetch_array($table37);
    $total_pembelian_3_gd = $data_pembelian_3_gd['pembelian_3_gd'];
    if (!isset($data_pembelian_3_gd['pembelian_3_gd'])) {
        $total_pembelian_3_gd = 0;
    }
    //konfirmasi retur
    $tabelgd1 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_3_gd FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K11' AND referensi = 'GD' ");
    $data_retur_3_gd = mysqli_fetch_array($tabelgd1);
    $total_retur_3_gd = $data_retur_3_gd['retur_3_gd'];
    if (!isset($data_retur_3_gd['retur_3_gd'])) {
        $total_retur_3_gd = 0;
    }
    //Keberangkatan
    $tabelgd2 = mysqli_query($koneksi, "SELECT SUM(L03K11) AS brangkat_3 FROM riwayat_keberangkatan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    $data_brangkat_3 = mysqli_fetch_array($tabelgd2);
    $total_brangkat_3 = $data_brangkat_3['brangkat_3'];
    if (!isset($data_brangkat_3['brangkat_3'])) {
        $total_brangkat_3 = 0;
    }
    //stok awal 3kg isi
    $table38 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data38 = mysqli_fetch_array($table38);
    $stok_awal_3kg_isi_gd = $data38['L03K11'];
    //stok akhir 3kg isi
    $table39 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
    $data39 = mysqli_fetch_array($table39);
    $stok_akhir_3kg_isi_gd = $data39['gudang'];
    
    
    //3KG KOSONG TK
    //baja kosong LPG 3kg Keluar
    $table40 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_3ksg_gd FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'L03K10' AND referensi = 'GD' ");
    $data_penjualan_3ksg_gd = mysqli_fetch_array($table40);
    $total_penjualan_3ksg_gd = $data_penjualan_3ksg_gd['penjualan_3ksg_gd'];
    if (!isset($data_penjualan_3ksg_gd['penjualan_3ksg_gd'])) {
        $total_penjualan_3ksg_gd = 0;
    }
    //baja kosong LPG 3kg Masuk
    $table41 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_3ksg_gd FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'L03K10' AND referensi = 'CBM' ");
    $data_pembelian_3ksg_gd = mysqli_fetch_array($table41);
    $total_pembelian_3ksg_gd = $data_pembelian_3ksg_gd['pembelian_3ksg_gd'];
    if (!isset($data_pembelian_3_gd['pembelian_3ksg_gd'])) {
        $total_pembelian_3ksg_gd = 0;
    }
    //konfirmasi retur
    $tabelgd3 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_3ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K10' AND referensi = 'GD' ");
    $data_retur_3ksg_gd = mysqli_fetch_array($tabelgd3);
    $total_retur_3ksg_gd = $data_retur_3ksg_gd['retur_3ksg_gd'];
    if (!isset($data_retur_3ksg_gd['retur_3ksg_gd'])) {
        $total_retur_3ksg_gd = 0;
    }
    //stok awal 3kg kosong
    $table42 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data42 = mysqli_fetch_array($table42);
    $stok_awal_3kg_ksg_gd = $data42['L03K10'];
    //stok akhir 3kg kosong
    $table43 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
    $data43 = mysqli_fetch_array($table43);
    $stok_akhir_3kg_ksg_gd = $data43['gudang'];
    
    
    
    //3kg retur
    //stok awal 3kg retur
    $tabgd1 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $datgd1 = mysqli_fetch_array($tabgd1);
    $stok_awal_3_rt_gd = $datgd1['L03K00'];
    //stok akhir 3kg retur
    $tabgd2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K00'");
    $datgd2 = mysqli_fetch_array($tabgd2);
    $stok_akhir_3kg_rt_gd = $datgd2['gudang'];
    //KEBERANGKATAN
    $tabelgd4 = mysqli_query($koneksi, "SELECT SUM(L03K00) AS brangkat_3_rtr FROM riwayat_keberangkatan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    $data_brangkat_3_rtr = mysqli_fetch_array($tabelgd4);
    $total_brangkat_3_rtr = $data_brangkat_3_rtr['brangkat_3_rtr'];
    if (!isset($data_brangkat_3_rtr['brangkat_3_rtr'])) {
        $total_brangkat_3_rtr = 0;
    }
    
    
    
    
    //LPG 12KG ISI
    //baja isi LPG 12kg Keluar
    $table44 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_12_gd FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'L12K01' AND referensi = 'GD' ");
    $data_penjualan_12_gd = mysqli_fetch_array($table44);
    $total_penjualan_12_gd = $data_penjualan_12_gd['penjualan_12_gd'];
    if (!isset($data_penjualan_12_gd['penjualan_12_gd'])) {
        $total_penjualan_12_gd = 0;
    }
    //baja isi LPG 12kg Masuk
    $table45 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_12_gd FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'L12K01' AND referensi = 'CBM' ");
    $data_pembelian_12_gd = mysqli_fetch_array($table45);
    $total_pembelian_12_gd = $data_pembelian_12_gd['pembelian_12_gd'];
    if (!isset($data_pembelian_12_gd['pembelian_12_gd'])) {
        $total_pembelian_12_gd = 0;
    }
    //konfirmasi retur
    $tabelgd5 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_12_gd FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L12K11' AND referensi = 'GD' ");
    $data_retur_12_gd = mysqli_fetch_array($tabelgd5);
    $total_retur_12_gd = $data_retur_12_gd['retur_12_gd'];
    if (!isset($data_retur_12_gd['retur_12_gd'])) {
        $total_retur_12_gd = 0;
    }
    //Keberangkatan
    $tabelgd6 = mysqli_query($koneksi, "SELECT SUM(L12K11) AS brangkat_12 FROM riwayat_keberangkatan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    $data_brangkat_12 = mysqli_fetch_array($tabelgd6);
    $total_brangkat_12 = $data_brangkat_12['brangkat_12'];
    if (!isset($data_brangkat_12['brangkat_12'])) {
        $total_brangkat_12 = 0;
    }
    //stok awal 12kg isi
    $table46 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data46 = mysqli_fetch_array($table46);
    $stok_awal_12kg_isi_gd = $data46['L12K11'];
    //stok akhir 12kg isi
    $table47 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
    $data47 = mysqli_fetch_array($table47);
    $stok_akhir_12kg_isi_gd = $data47['gudang'];
    
    
    //LPG 12KG kOSONG
    //baja kosong LPG 12kg Keluar
    $table48 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_12ksg_gd FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'L12K10' AND referensi = 'GD' ");
    $data_penjualan_12ksg_gd = mysqli_fetch_array($table48);
    $total_penjualan_12ksg_gd= $data_penjualan_12ksg_gd['penjualan_12ksg_gd'];
    if (!isset($data_penjualan_12ksg_gd['penjualan_12ksg_gd'])) {
        $total_penjualan_12ksg_gd = 0;
    }
    //baja kosong LPG 12kg Masuk
    $table49 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_12ksg_gd FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L12K10' AND referensi = 'CBM' ");
    $data_pembelian_12ksg_gd = mysqli_fetch_array($table49);
    $total_pembelian_12ksg_gd = $data_pembelian_12ksg_gd['pembelian_12ksg_gd'];
    if (!isset($data_pembelian_12ksg_gd['pembelian_12ksg_gd'])) {
        $total_pembelian_12ksg_gd = 0;
    }
    //konfirmasi retur
    $tabelgd7 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_12ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L12K10' AND referensi = 'GD' ");
    $data_retur_12ksg_gd = mysqli_fetch_array($tabelgd7);
    $total_retur_12ksg_gd = $data_retur_12ksg_gd['retur_12ksg_gd'];
    if (!isset($data_retur_12ksg_gd['retur_12ksg_gd'])) {
        $total_retur_12ksg_gd = 0;
    }
    //stok awal 12kg kosong
    $table50 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data50 = mysqli_fetch_array($table50);
    $stok_awal_12kg_ksg_gd = $data50['L12K10'];
    //stok akhir 12kg kosong
    $table51 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
    $data51 = mysqli_fetch_array($table51);
    $stok_akhir_12kg_ksg_gd  = $data51['gudang'];
    
    
    
    // LPG12kg retur
    //stok awal 3kg retur
    $tabgd3 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $datgd3 = mysqli_fetch_array($tabgd3);
    $stok_awal_12_rt_gd = $datgd3['L12K00'];
    //stok akhir 3kg retur
    $tabgd4 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K00'");
    $datgd4 = mysqli_fetch_array($tabgd4);
    $stok_akhir_12_rt_gd = $datgd4['gudang'];
    //keberangkatan
    $tabelgd8 = mysqli_query($koneksi, "SELECT SUM(L12K00) AS brangkat_12_rtr FROM riwayat_keberangkatan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    $data_brangkat_12_rtr = mysqli_fetch_array($tabelgd8);
    $total_brangkat_12_rtr = $data_brangkat_12_rtr['brangkat_12_rtr'];
    if (!isset($data_brangkat_12_rtr['brangkat_12_rtr'])) {
        $total_brangkat_12_rtr = 0;
    }
    
    
    
    //BG 5,5 ISI
    //baja isi BG 5,5kg Keluar
    $table52 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b05_gd FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B05K01' AND referensi = 'GD' ");
    $data_penjualan_b05_gd = mysqli_fetch_array($table52);
    $total_penjualan_b05_gd= $data_penjualan_b05_gd['penjualan_b05_gd'];
    if (!isset($data_penjualan_b05_gd['penjualan_b05_gd'])) {
        $total_penjualan_b05_gd = 0;
    }
    //baja isi BG 5,5kg Masuk
    $table53 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b05_gd FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B05K01' AND referensi = 'CBM' ");
    $data_pembelian_b05_gd = mysqli_fetch_array($table53);
    $total_pembelian_b05_gd = $data_pembelian_b05_gd['pembelian_b05_gd'];
    if (!isset($data_pembelian_b05_gd['pembelian_b05_gd'])) {
        $total_pembelian_b05_gd = 0;
    }
    //konfirmasi retur
    $tabelgd9 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b05_gd FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B05K11' AND referensi = 'GD' ");
    $data_retur_b05_gd = mysqli_fetch_array($tabelgd9);
    $total_retur_b05_gd = $data_retur_b05_gd['retur_b05_gd'];
    if (!isset($data_retur_b05_gd['retur_b05_gd'])) {
        $total_retur_b05_gd = 0;
    }
    //Keberangkatan
    $tabelgd10 = mysqli_query($koneksi, "SELECT SUM(B05K11) AS brangkat_b05 FROM riwayat_keberangkatan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    $data_brangkat_b05 = mysqli_fetch_array($tabelgd10);
    $total_brangkat_b05 = $data_brangkat_b05['brangkat_b05'];
    if (!isset($data_brangkat_b05['brangkat_b05'])) {
        $total_brangkat_b05 = 0;
    }
    //stok awal 5,5kg isi
    $table54 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data54 = mysqli_fetch_array($table54);
    $stok_awal_b05_isi_gd = $data54['B05K11'];
    //stok akhir 5,5kg isi
    $table55 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
    $data55 = mysqli_fetch_array($table55);
    $stok_akhir_b05_isi_gd = $data55['gudang'];
    
    
    
    //BG 5,5 Kosong 
    //baja kosong BG 5,5kg Keluar
    $table56 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b05ksg_gd FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B05K10' AND referensi = 'GD' ");
    $data_penjualan_b05ksg_gd = mysqli_fetch_array($table56);
    $total_penjualan_b05ksg_gd= $data_penjualan_b05ksg_gd['penjualan_b05ksg_gd'];
    if (!isset($data_penjualan_b05ksg_gd['penjualan_b05ksg_gd'])) {
        $total_penjualan_b05ksg_gd = 0;
    }
    //baja kosong BG 5,5 KG Masuk
    $table57 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b05ksg_gd FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B05K10' AND referensi = 'CBM' ");
    $data_pembelian_b05ksg_gd = mysqli_fetch_array($table57);
    $total_pembelian_b05ksg_gd = $data_pembelian_b05ksg_gd['pembelian_b05ksg_gd'];
    if (!isset($data_pembelian_b05ksg_gd['pembelian_b05ksg_gd'])) {
        $total_pembelian_b05ksg_gd = 0;
    }
    //konfirmasi retur
    $tabelgd11 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b05ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B05K10' AND referensi = 'GD' ");
    $data_retur_b05ksg_gd = mysqli_fetch_array($tabelgd11);
    $total_retur_b05ksg_gd = $data_retur_b05ksg_gd['retur_b05ksg_gd'];
    if (!isset($data_retur_b05ksg_gd['retur_b05ksg_gd'])) {
        $total_retur_b05ksg_gd = 0;
    }
    //stok awal 5,5kg kosong
    $table58 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data58 = mysqli_fetch_array($table58);
    $stok_awal_b05_ksg_gd = $data58['B05K10'];
    //stok akhir 5,5kg kosong
    $table59 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
    $data59 = mysqli_fetch_array($table59);
    $stok_akhir_b05_ksg_gd = $data59['gudang'];
    
    
    
    // BG 55 kg retur
    //stok awal 3kg retur
    $tabgd5 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $datgd5 = mysqli_fetch_array($tabgd5);
    $stok_awal_b05_rt_gd = $datgd5['B05K00'];
    //stok akhir 3kg retur
    $tabgd6 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K00'");
    $datgd6 = mysqli_fetch_array($tabgd6);
    $stok_akhir_b05_rt_gd = $datgd6['gudang'];
    //keberangkatan
    $tabelgd12 = mysqli_query($koneksi, "SELECT SUM(B05K00) AS brangkat_b05_rtr FROM riwayat_keberangkatan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    $data_brangkat_b05_rtr = mysqli_fetch_array($tabelgd12);
    $total_brangkat_b05_rtr = $data_brangkat_b05_rtr['brangkat_b05_rtr'];
    if (!isset($data_brangkat_b05_rtr['brangkat_b05_rtr'])) {
        $total_brangkat_b05_rtr = 0;
    }
    
    
    
    //BG 12KG ISI
    //baja isi BG 12kg keluar
    $table60 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b12_gd FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B12K01' AND referensi = 'GD' ");
    $data_penjualan_b12_gd = mysqli_fetch_array($table60);
    $total_penjualan_b12_gd= $data_penjualan_b12_gd['penjualan_b12_gd'];
    if (!isset($data_penjualan_b12_gd['penjualan_b12_gd'])) {
        $total_penjualan_b12_gd = 0;
    }
    //baja isi BG 12kg Masuk
    $table61 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b12_gd FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B12K01' AND referensi = 'CBM' ");
    $data_pembelian_b12_gd = mysqli_fetch_array($table61);
    $total_pembelian_b12_gd = $data_pembelian_b12_gd['pembelian_b12_gd'];
    if (!isset($data_pembelian_b12_gd['pembelian_b12_gd'])) {
        $total_pembelian_b12_gd = 0;
    }
    //konfirmasi retur
    $tabelgd13 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b12_gd FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B12K11' AND referensi = 'GD' ");
    $data_retur_b12_gd = mysqli_fetch_array($tabelgd13);
    $total_retur_b12_gd = $data_retur_b12_gd['retur_b12_gd'];
    if (!isset($data_retur_b12_gd['retur_b12_gd'])) {
        $total_retur_b12_gd = 0;
    }
    //Keberangkatan
    $tabelgd14 = mysqli_query($koneksi, "SELECT SUM(B12K11) AS brangkat_b12 FROM riwayat_keberangkatan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    $data_brangkat_b12 = mysqli_fetch_array($tabelgd14);
    $total_brangkat_b12 = $data_brangkat_b12['brangkat_b12'];
    if (!isset($data_brangkat_b12['brangkat_b12'])) {
        $total_brangkat_b12 = 0;
    }
    //stok awal 12kg isi
    $table62 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data62 = mysqli_fetch_array($table62);
    $stok_awal_b12_isi_gd = $data62['B12K11'];
    //stok akhir 12kg isi
    $table63 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
    $data63 = mysqli_fetch_array($table63);
    $stok_akhir_b12_isi_gd = $data63['gudang'];
    
    
    
    //BG 12KH KOSONG
    //baja kosong BG 12kg KELUAR
    $table64 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b12ksg_gd FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B12K10' AND referensi = 'GD' ");
    $data_penjualan_b12ksg_gd = mysqli_fetch_array($table64);
    $total_penjualan_b12ksg_gd= $data_penjualan_b12ksg_gd['penjualan_b12ksg_gd'];
    if (!isset($data_penjualan_b12ksg_gd['penjualan_b12ksg_gd'])) {
        $total_penjualan_b12ksg_gd = 0;
    }
    //baja kosong BG 12kg Masuk
    $table65 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b12ksg_gd FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B12K10' AND referensi = 'CBM' ");
    $data_pembelian_b12ksg_gd = mysqli_fetch_array($table65);
    $total_pembelian_b12ksg_gd = $data_pembelian_b12ksg_gd['pembelian_b12ksg_gd'];
    if (!isset($data_pembelian_b12ksg_gd['pembelian_b12ksg_gd'])) {
        $total_pembelian_b12ksg_gd = 0;
    }
    //konfirmasi retur
    $tabelgd15 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b12ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B12K10' AND referensi = 'GD' ");
    $data_retur_b12ksg_gd = mysqli_fetch_array($tabelgd15);
    $total_retur_b12ksg_gd = $data_retur_b12ksg_gd['retur_b12ksg_gd'];
    if (!isset($data_retur_b12ksg_gd['retur_b12ksg_gd'])) {
        $total_retur_b12ksg_gd = 0;
    }
    //stok awal 5,5kg kosong
    $table66 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data66 = mysqli_fetch_array($table66);
    $stok_awal_b12_ksg_gd = $data66['B12K10'];
    //stok akhir 5,5kg kosong
    $table67 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
    $data67 = mysqli_fetch_array($table67);
    $stok_akhir_b12_ksg_gd = $data67['gudang'];
    
    
    
    
    // BG 55 kg retur
    //stok awal 3kg retur
    $tabgd7 = mysqli_query($koneksi, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $datgd7 = mysqli_fetch_array($tabgd7);
    $stok_awal_b12_rt_gd = $datgd7['B12K00'];
    //stok akhir 3kg retur
    $tabgd8 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K00'");
    $datgd8 = mysqli_fetch_array($tabgd8);
    $stok_akhir_b12_rt_gd = $datgd8['gudang'];
    //keberangkatan
    $tabelgd16 = mysqli_query($koneksi, "SELECT SUM(B12K00) AS brangkat_b12_rtr FROM riwayat_keberangkatan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    $data_brangkat_b12_rtr = mysqli_fetch_array($tabelgd16);
    $total_brangkat_b12_rtr = $data_brangkat_b12_rtr['brangkat_b12_rtr'];
    if (!isset($data_brangkat_b12_rtr['brangkat_b12_rtr'])) {
        $total_brangkat_b12_rtr = 0;
    }
    
    }

    setlocale(LC_ALL, 'id_ID');

 ?>
 <!DOCTYPE html>
 <html lang="en">

 <head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Laporan Penjualan CBM</title>

  <!-- Custom fonts for this template-->
  <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link

  rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/sbadmin/vendor/bootstrap/css/bootstrap.min.css">
  <!-- Custom styles for this template-->

  <!-- Link Tabel -->


  <!-- Link datepicker -->

</head>

  <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">


<!-- Tabel -->    

<div class="row">
    <div  align='left' class="col-md-6">
            <img src="../gambar/KopSurat.png" style="height: 90px; width: 230px;">
    </div>
    <div align='right' class="col-md-6">
        <h9 style='font-size: 12px' >Alamat : Dsn. 01 RT/RW 03/01 Desa Suka Maju</h9><br>
        <h9 style='font-size: 12px' > Kec. Buay Madang Timur Kab. OKU Timur 32361 Sum-Sel </h9><br>
        <h9 style='font-size: 12px' > Email : ptcahayabumimusi@gmail.com | Telp/Hp. 0812 2160 0689</h9>

    </div>

</div>



<style>       
    hr{
        height: 2px;
        background-color: black;
        border: none;
    }
</style>
<hr>
<h5 align='center'>PENJUALAN HARIAN</h5>
<?php 
if($tanggal_awal == $tanggal_akhir){
  echo"<h6 align='center'> "?> <?= formattanggal($tanggal_awal); echo"</h6>";
}
else{
   
    echo"<h6 align='center'>Priode"?> <?= formattanggal($tanggal_awal); echo" Sampai";  formattanggal($tanggal_akhir); echo"  </h6>";
}
?>
<br>
<table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width: 100%; ">
  <thead align = 'center' >  
    <tr>
      <th>No</th>
    
      <th>REF</th>
  
      <th>Barang</th>
      <th>Penyaluran</th>
      <th>Nama</th>
      <th>Pembayaran</th>
      <th>QTY</th>
      <th>Harga</th>
      <th>Jumlah</th>    
      <th>Keterangan</th>
    

    </tr>
  </thead>
  <tbody>
    <?php
    $L03 = 0;
    $B05 = 0;
    $B12 = 0;
    $L12 = 0;
    $L03_cash = 0;
    $B05_cash = 0;
    $B12_cash = 0;
    $L12_cash = 0;
    $urut = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }
    
    function formattanggal($date){
        

        $newDate = date(" d F Y", strtotime($date));
        switch(date("l"))
    {
        case 'Monday':$nmh="Senin";break; 
        case 'Tuesday':$nmh="Selasa";break; 
        case 'Wednesday':$nmh="Rabu";break; 
        case 'Thursday':$nmh="Kamis";break; 
        case 'Friday':$nmh="Jum'at";break; 
        case 'Saturday':$nmh="Sabtu";break; 
        case 'Sunday':$nmh="minggu";break; 
    }
    echo $nmh.","."$newDate";
       }
    ?>

    <?php while($data = mysqli_fetch_array($table)){
      $no_transaksi = $data['no_transaksi'];

      $referensi = $data['referensi'];
 
      $nama_baja = $data['nama_baja'];
      $penyaluran = $data['penyaluran'];
      $nama = $data['nama'];
      $pembayaran = $data['pembayaran'];
      $qty = $data['qty'];
      $harga = $data['harga'];
      $jumlah = $data['jumlah'];
      $urut = $urut + 1;
      $keterangan = $data['keterangan'];
      $file_bukti = $data['file_bukti'];

      if ($pembayaran == 'Cash' OR $pembayaran =='Deposit') {
        if ($nama_baja == 'Elpiji 3 Kg Isi' || $nama_baja == 'Elpiji 3 Kg Baja + Isi' || $nama_baja == 'Elpiji 3 Kg Baja Kosong') {
          $L03_cash = $L03_cash + $jumlah;
        }
        elseif ($nama_baja == 'Elpiji 12 Kg Isi' || $nama_baja == 'Elpiji 12 Kg Baja + Isi' || $nama_baja == 'Elpiji 12 Kg Baja Kosong') {
          $L12_cash = $L12_cash + $jumlah;
        }
        elseif ($nama_baja == 'Bright Gas 5,5 Kg Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja + Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja Kosong') {
          $B05_cash = $B05_cash + $jumlah;
        }
        elseif ($nama_baja == 'Bright Gas 12 Kg Isi' || $nama_baja == 'Bright Gas 12 Kg Baja + Isi' || $nama_baja == 'Bright Gas 12 Kg Baja Kosong') {
          $B12_cash = $B12_cash + $jumlah;
        }
      }
      else{
        if ($nama_baja == 'Elpiji 3 Kg Isi' || $nama_baja == 'Elpiji 3 Kg Baja + Isi' || $nama_baja == 'Elpiji 3 Kg Baja Kosong') {
          $L03 = $L03 + $jumlah;
        }
        elseif ($nama_baja == 'Elpiji 12 Kg Isi' || $nama_baja == 'Elpiji 12 Kg Baja + Isi' || $nama_baja == 'Elpiji 12 Kg Baja Kosong') {
          $L12 = $L12 + $jumlah;
        }
        elseif ($nama_baja == 'Bright Gas 5,5 Kg Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja + Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja Kosong') {
          $B05 = $B05 + $jumlah;
        }
        elseif ($nama_baja == 'Bright Gas 12 Kg Isi' || $nama_baja == 'Bright Gas 12 Kg Baja + Isi' || $nama_baja == 'Bright Gas 12 Kg Baja Kosong') {
          $B12 = $B12 + $jumlah;
        }
      }




      echo "<tr align = 'center'>
      <td style='font-size: 14px'>$urut</td>
      <td style='font-size: 14px'>$referensi</td>
      <td style='font-size: 14px'>$nama_baja</td>
      <td style='font-size: 14px'>$penyaluran</td>
      <td style='font-size: 14px'>$nama</td>
      <td style='font-size: 14px'>$pembayaran</td>
      <td style='font-size: 14px'>$qty</td>
      <td style='font-size: 14px'>";?> <?= formatuang($harga); ?> <?php echo "</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
      <td style='font-size: 14px'>$keterangan</td>
    
      </tr>";
  }
  ?>

</tbody>
</table>
</div>
<br>
<br>
<br>
<div  class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h5 align="center" >Laporan Keuangan</h3>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Elpiji 3 KG</th>
      <th>Bright Gas 5,5 KG</th>
      <th>Bright Gas 12 KG</th>
      <th>Elpiji 12 KG</th>
      <th>Cash Elpiji 3 KG</th>
      <th>Cash Bright Gas 5,5 KG</th>
      <th>Cash Bright Gas 12 KG</th>
      <th>Cash Elpiji 12 KG</th>
    </tr>
  </thead>
  <tbody>

    <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($L03); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($B05); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($B12); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($L12); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($L03_cash); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($B05_cash); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($B12_cash); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($L12_cash); ?> <?php echo "</td>

        </tr>";
  
  ?>

</tbody>
</table>
</div>
<br>
<br>
<br>
<?php
/*
  <div class="pinggir1" style="margin-right: 20px; margin-left: 20px; color:black;">
<h5 align="center" >Inventory</h3>
<!-- Tabel -->    
<table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
   <thead>
    <tr>
      <th>Baja</th>
      <th>Toko</th>
      <th>Gudang</th>
      <th>Global</th>
      <th>Di Pinjam</th>
      <th>Pasiv</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>

    <?php while($data2 = mysqli_fetch_array($table2)){
      $nama_baja = $data2['nama_baja'];
      $toko =$data2['toko'];
      $gudang = $data2['gudang'];
      $dipinjam = $data2['dipinjam'];
      $passive = $data2['passive'];
      $global = $toko + $gudang;
      $total = $toko + $gudang + $dipinjam + $passive;
      echo "<tr>
      <td style='font-size: 14px'>$nama_baja</td>
      <td style='font-size: 14px'>$toko</td>
      <td style='font-size: 14px'>$gudang</td>
      <td style='font-size: 14px'>$global</td>
      <td style='font-size: 14px'>$dipinjam</td> 
      <td style='font-size: 14px'>$passive</td> 
      <td style='font-size: 14px'>$total</td> 
        </tr>";
  }
  ?>

</tbody>
</table>
</div>
<br>
    <br>
</div>
 
 <div class="pinggir1" style="margin-right: 20px; margin-left: 20px; color:black;">

<div class="row">
    <div class="col-md-6">
    
<h5 align="center" >Rekapitulasi Baja Toko</h5>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
   <thead>
    <tr>
      <th>Nama Baja</th>
      <th>Stok Awal</th>
      <th>Keluar</th>
      <th>Masuk</th>
      <th>Stok Akhir</th>
    </tr>
  </thead>
  <tbody>
    <tr>
        <td>Elpiji 3 Kg baja + Isi</td>
        <td><?= $stok_awal_3kg_isi_tk ?></td>
        <td><?= $total_penjualan_3_tk + $total_perpindahan_3_tkx + $total_retur_3_tk ?></td>
        <td><?= $total_pembelian_3_tk + $total_perpindahan_3_tk  ?></td>
        <td><?= $stok_akhir_3kg_isi_tk ?></td>
    </tr>
    <tr>
        <td>Elpiji 3 Kg Kosong</td>
        <td><?= $stok_awal_3kg_ksg_tk ?></td>
        <td><?= $total_penjualan_3ksg_tk + $total_pembelian_3_tk + $total_perpindahan_3ksg_tkx + $total_retur_3ksg_tk ?></td>
        <td><?= $total_pembelian_3ksg_tk + $total_penjualan_3_tk + $total_perpindahan_3ksg_tk ?></td>
        <td><?= $stok_akhir_3kg_ksg_tk ?></td>
    </tr>
    <tr>
        <td>Elpiji 3 Kg Retur</td>
        <td><?= $stok_awal_3kg_rt_tk ?></td>
        <td><?= $total_perpindahan_3rt_tkx ?></td>
        <td><?= $total_retur_3ksg_tk + $total_retur_3_tk + $total_perpindahan_3rt_tk  ?></td>
        <td><?= $stok_akhir_3kg_rt_tk ?></td>
    </tr>
    <tr>
        <td>Elpiji 12 Kg baja + Isi</td>
        <td><?= $stok_awal_12kg_isi_tk ?></td>
        <td><?= $total_penjualan_12_tk + $total_perpindahan_12_tkx + $total_retur_12_tk ?></td>
        <td><?= $total_pembelian_12_tk + $total_perpindahan_12_tk ?></td>
        <td><?= $stok_akhir_12kg_isi_tk ?></td>
    </tr>
    <tr>
        <td>Elpiji 12 Kg Kosong</td>
        <td><?= $stok_awal_12kg_ksg_tk ?></td>
        <td><?= $total_penjualan_12ksg_tk + $total_pembelian_12_tk + $total_perpindahan_12ksg_tkx + $total_retur_12ksg_tk ?></td>
        <td><?= $total_pembelian_12ksg_tk + $total_penjualan_12_tk + $total_perpindahan_12ksg_tk ?></td>
        <td><?= $stok_akhir_12kg_ksg_tk ?></td>
    </tr>
    <tr>
        <td>Elpiji 12 Kg Retur</td>
        <td><?= $stok_awal_12kg_rt_tk ?></td>
        <td><?= $total_perpindahan_12rt_tkx ?></td>
        <td><?= $total_retur_12ksg_tk + $total_retur_12_tk + $total_perpindahan_12rt_tk ?></td>
        <td><?= $stok_akhir_12kg_rt_tk ?></td>
    </tr>
    <tr>
        <td>Bright Gas 5,5 Kg baja + Isi</td>
        <td><?= $stok_awal_55_isi_tk ?></td>
        <td><?= $total_penjualan_b05_tk + $total_perpindahan_b05_tkx + $total_retur_b05_tk ?></td>
        <td><?= $total_pembelian_b05_tk + $total_perpindahan_b05_tk ?></td>
        <td><?= $stok_akhir_55_isi_tk ?></td>
    </tr>
    <tr>
        <td>Bright Gas 5,5 Kg Kosong</td>
        <td><?= $stok_awal_55_ksg_tk ?></td>
        <td><?= $total_penjualan_b05ksg_tk + $total_pembelian_b05_tk + $total_perpindahan_b05ksg_tkx + $total_retur_b05ksg_tk ?></td>
        <td><?= $total_pembelian_b05ksg_tk + $total_penjualan_b05_tk + $total_perpindahan_b05ksg_tk ?></td>
        <td><?= $stok_akhir_55_ksg_tk ?></td>
    </tr>
    <tr>
        <td>Bright Gas 5,5 Kg Retur</td>
        <td><?= $stok_awal_b05_rt_tk ?></td>
        <td><?= $total_perpindahan_b05rt_tkx ?></td>
        <td><?= $total_retur_b05ksg_tk + $total_retur_b05_tk + $total_perpindahan_b05rt_tk ?></td>
        <td><?= $stok_akhir_b05_rt_tk ?></td>
    </tr>
    <tr>
        <td>Bright Gas 12 Kg baja + Isi</td>
        <td><?= $stok_awal_b12_isi_tk ?></td>
        <td><?= $total_penjualan_b12_tk + $total_perpindahan_b12_tkx + $total_retur_b12_tk?></td>
        <td><?= $total_pembelian_b12_tk + $total_perpindahan_b05_tk ?></td>
        <td><?= $stok_akhir_b12_isi_tk ?></td>
    </tr>
    <tr>
        <td>Bright Gas 12 Kosong</td>
        <td><?= $stok_awal_b12_ksg_tk ?></td>
        <td><?= $total_penjualan_b12ksg_tk + $total_pembelian_b12_tk + $total_perpindahan_b12ksg_tkx + $total_retur_b12ksg_tk ?></td>
        <td><?= $total_pembelian_b12ksg_tk + $total_pembelian_b12_tk + $total_perpindahan_b05ksg_tk ?></td>
        <td><?= $stok_akhir_b12_ksg_tk ?></td>
    </tr>
    <tr>
        <td>Bright Gas 12 Kg Retur</td>
        <td><?= $stok_awal_b12_rt_tk ?></td>
        <td><?= $total_perpindahan_b12rt_tkx ?></td>
        <td><?= $total_retur_b12ksg_tk + $total_retur_b12_tk + $total_perpindahan_b12rt_tk ?></td>
        <td><?= $stok_akhir_b12_rt_tk ?></td>
    </tr>

</tbody>
</table>
</div>

    <div class="col-md-6">
        

<h5 align="center" >Rekapitulasi Baja Gudang</h5>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
   <thead>
    <tr>
      <th>Nama Baja</th>
      <th>Stok Awal</th>
      <th>Keluar</th>
      <th>Masuk</th>
      <th>Stok Akhir</th>
    </tr>
  </thead>
  <tbody>
    <tr>
        <td>Elpiji 3 Kg baja + Isi</td>
        <td><?= $stok_awal_3kg_isi_gd ?></td>
        <td><?= $total_penjualan_3_gd + $total_perpindahan_3_tk + $total_retur_3_gd ?></td>
        <td><?= $total_pembelian_3_gd + $total_perpindahan_3_tkx + $total_brangkat_3 + $total_brangkat_3_rtr ?></td>
        <td><?= $stok_akhir_3kg_isi_gd ?></td>
    </tr>
    <tr>
        <td>Elpiji 3 Kg Kosong</td>
        <td><?= $stok_awal_3kg_ksg_gd ?></td>
        <td><?= $total_penjualan_3ksg_gd + $total_pembelian_3_gd + $total_perpindahan_3ksg_tk + $total_retur_3ksg_gd + $total_brangkat_3 ?></td>
        <td><?= $total_pembelian_3ksg_gd + $total_penjualan_3_gd + $total_perpindahan_3ksg_tkx ?></td>
        <td><?= $stok_akhir_3kg_ksg_gd ?></td>
    </tr>
    <tr>
        <td>Elpiji 3 Kg Retur</td>
        <td><?= $stok_awal_3_rt_gd ?></td>
        <td><?= $total_perpindahan_3rt_tk + $total_brangkat_3_rtr ?></td>
        <td><?= $total_retur_3_gd + $total_retur_3ksg_gd + $total_perpindahan_3rt_tkx ?></td>
        <td><?= $stok_akhir_3kg_rt_gd ?></td>
    </tr>
    <tr>
        <td>Elpiji 12 Kg baja + Isi</td>
        <td><?= $stok_awal_12kg_isi_gd ?></td>
        <td><?= $total_penjualan_12_gd + $total_perpindahan_12_tk + $total_retur_12_gd ?></td>
        <td><?= $total_pembelian_12_gd + $total_perpindahan_12_tkx + $total_brangkat_12 + $total_brangkat_12_rtr ?></td>
        <td><?= $stok_akhir_12kg_isi_gd ?></td>
    </tr>
    <tr>
        <td>Elpiji 12 Kg Kosong</td>
        <td><?= $stok_awal_12kg_ksg_gd ?></td>
        <td><?= $total_penjualan_12ksg_gd + $total_pembelian_12_gd + $total_perpindahan_12ksg_tk + $total_retur_12ksg_gd + $total_brangkat_12 ?></td>
        <td><?= $total_pembelian_12ksg_gd + $total_penjualan_12_gd + $total_perpindahan_12ksg_tkx ?></td>
        <td><?= $stok_akhir_12kg_ksg_gd ?></td>
    </tr>
    <tr>
        <td>Elpiji 12 Kg Retur</td>
        <td><?= $stok_awal_12_rt_gd ?></td>
        <td><?= $total_perpindahan_12rt_tk + $total_brangkat_12_rtr ?></td>
        <td><?= $total_retur_12_gd + $total_retur_12ksg_gd + $total_perpindahan_12rt_tkx ?></td>
        <td><?= $stok_akhir_12_rt_gd ?></td>
    </tr>
    <tr>
        <td>Bright Gas 5,5 Kg baja + Isi</td>
        <td><?= $stok_awal_b05_isi_gd ?></td>
        <td><?= $total_penjualan_b05_gd + $total_perpindahan_b05_tk + $total_retur_b05_gd ?></td>
        <td><?= $total_pembelian_b05_gd + $total_perpindahan_b05_tkx + $total_brangkat_b05 + $total_brangkat_b05_rtr ?></td>
        <td><?= $stok_akhir_b05_isi_gd ?></td>
    </tr>
    <tr>
        <td>Bright Gas 5,5 Kg Kosong</td>
        <td><?= $stok_awal_b05_ksg_gd ?></td>
        <td><?= $total_penjualan_b05ksg_gd + $total_pembelian_b05_gd + $total_perpindahan_b05ksg_tk + $total_retur_b05ksg_gd + $total_brangkat_b05 ?></td>
        <td><?= $total_pembelian_b05ksg_gd + $total_penjualan_b05_gd + $total_perpindahan_b05ksg_tkx ?></td>
        <td><?= $stok_akhir_b05_ksg_gd ?></td>
    </tr>
    <tr>
        <td>Bright Gas 5,5 Kg Retur</td>
        <td><?= $stok_awal_b05_rt_gd ?></td>
        <td><?= $total_perpindahan_b05_tk + $total_brangkat_b05_rtr ?></td>
        <td><?= $total_retur_b05_gd + $total_retur_b05ksg_gd + $total_perpindahan_b05rt_tkx ?></td>
        <td><?= $stok_akhir_b05_rt_gd ?></td>
    </tr>
    <tr>
        <td>Bright Gas 12 Kg baja + Isi</td>
        <td><?= $stok_awal_b12_isi_gd ?></td>
        <td><?= $total_penjualan_b12_gd + $total_perpindahan_b12_tk + $total_retur_b12_gd  ?></td>
        <td><?= $total_pembelian_b12_gd + $total_perpindahan_b12_tkx + $total_brangkat_b12 + $total_brangkat_b12_rtr ?></td>
        <td><?= $stok_akhir_b12_isi_gd ?></td>
    </tr>
    <tr>
        <td>Bright Gas 12 Kg Kosong</td>
        <td><?= $stok_awal_b12_ksg_gd ?></td>
        <td><?= $total_penjualan_b12ksg_gd + $total_pembelian_b12_gd + $total_perpindahan_b12ksg_tk + $total_retur_b12ksg_gd + $total_brangkat_b12 ?></td>
        <td><?= $total_pembelian_b12ksg_gd + $total_penjualan_b12_gd + $total_perpindahan_b12ksg_tkx ?></td>
        <td><?= $stok_akhir_b12_ksg_gd ?></td>
    </tr>
    <tr>
        <td>Bright Gas 12 Kg Retur</td>
        <td><?= $stok_awal_b12_rt_gd ?></td>
        <td><?= $total_perpindahan_b12_tk + $total_brangkat_b12_rtr ?></td>
        <td><?= $total_retur_b12_gd + $total_retur_b12ksg_gd + $total_perpindahan_b12rt_tkx ?></td>
        <td><?= $stok_akhir_b12_rt_gd ?></td>
    </tr>
</tbody>
</table>
    </div>
</div>

</div>*/ ?>
<br>
<br>

<!-- Tanda Konfirmasi  -->
  <div class="pinggir1" style="margin-right: 20px; margin-left: 20px; color:black;">
 
<div class="row" align="center">
  <div class="col-md-4">
    <table>
      <thead>
        <tr>
          <td align="center">Dibuat,</td>
        </tr>
        <tr>
            <?php 
                if ($tanggal_awal == $tanggal_akhir) {
                    
                    $kasir =  mysqli_query($koneksi, "SELECT kasir FROM konfirmasi_laporan WHERE tanggal = '$tanggal_awal'AND kasir = '1' ");
                if ( mysqli_num_rows($kasir) === 1 ) {
                      echo "<td align='center'> <img src='../gambar/TTDKasir.png' style='height: 55px; width: 190px;'' > </td>";
                         }
                         else{
                    echo "<td align='center'>  </td>";
                        }
                   
                }
                else{
                   
                    $kasir3  =  mysqli_query($koneksi, "SELECT kasir FROM konfirmasi_laporan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
                    $x=0;
                    $y=0;
                    $z=0;
                    while ($data4 = mysqli_fetch_array($kasir3)) {
                        $kasir11 = $data4['kasir'];
                     $x = $x+1;

                     if ($kasir11 == 1) {
                            $y = $y+1;
                        }   

                    }
                    if ( $y == $x ) {
                      echo "<td align='center'> <img  src='../gambar/TTDKasir.png' style='height: 55px; width: 190px;'> </td>";
                         }
                         else{
                    echo "<td align='center'>  </td>";
                        }
                }
                
            ?>
          
        </tr>
        <tr>
          <td align="center" style="font-weight: bold; text-decoration: underline;">Lilis Magdalena</td>
        </tr>
        <tr>
          <td align="center" style="font-weight: bold; font-style: italic;">Kasir</td>
        </tr>
      </thead>
    </table>
  </div>

  <div class="col-md-4">
    <table>
      <thead>
        <tr>
          <td align="center">Diperiksa,</td>
        </tr>
        <tr>
          <?php 
                if ($tanggal_awal == $tanggal_akhir) {
                    
                    $kasir =  mysqli_query($koneksi, "SELECT manager FROM konfirmasi_laporan WHERE tanggal = '$tanggal_awal'AND manager = '1' ");
                if ( mysqli_num_rows($kasir) === 1 ) {
                      echo "<td align='center'> <img src='../gambar/TTDManager.png' style='height: 55px; width: 190px;' > </td>";
                         }
                         else{
                    echo "<td align='center'>  </td>";
                        }
                   
                }
                else{
                   
                    $kasir3  =  mysqli_query($koneksi, "SELECT manager FROM konfirmasi_laporan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
                    $x=0;
                    $y=0;
                    $z=0;
                    while ($data4 = mysqli_fetch_array($kasir3)) {
                        $kasir11 = $data4['manager'];
                     $x = $x+1;

                     if ($kasir11 == 1) {
                            $y = $y+1;
                        }   

                    }
                    if ( $y == $x ) {
                      echo "<td align='center'> <img src='../gambar/TTDKasir.png'  style='height: 55px; width: 190px;' > </td>";
                         }
                         else{
                    echo "<td align='center'>  </td>";
                        }
                }
                
            ?>
        </tr> 
        <tr>
          <td align="center" style="font-weight: bold; text-decoration: underline;"> Made Suarte</td>
        </tr>
        <tr>
          <td align="center" style="font-weight: bold; font-style: italic;"> Manager</td>
        </tr>
      </thead>
    </table>
  </div>

  <div class="col-md-4">
    <table>
      <thead>
        <tr>
          <td align="center">Disetujui,</td>
        </tr>
        <tr>
          <?php 
                if ($tanggal_awal == $tanggal_akhir) {
                    
                    $kasir =  mysqli_query($koneksi, "SELECT direktur FROM konfirmasi_laporan WHERE tanggal = '$tanggal_awal'AND direktur = '1' ");
                if ( mysqli_num_rows($kasir) === 1 ) {
                      echo "<td align='center'> <img  style='height: 55px; width: 190px;'' src=''> </td>";
                         }
                         else{
                    echo "<td align='center'>  </td>";
                        }
                   
                }
                else{
                   
                    $kasir3  =  mysqli_query($koneksi, "SELECT direktur FROM konfirmasi_laporan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
                    $x=0;
                    $y=0;
                    $z=0;
                    while ($data4 = mysqli_fetch_array($kasir3)) {
                        $kasir11 = $data4['direktur'];
                     $x = $x+1;

                     if ($kasir11 == 1) {
                            $y = $y+1;
                        }   

                    }
                    if ( $y == $x ) {
                      echo "<td align='center'> <img  style='height: 55px; width: 190px;'' src=''> </td>";
                         }
                         else{
                    echo "<td align='center'>  </td>";
                        }
                }
                
            ?>
        </tr>
        <tr>
          <td align="center" style="font-weight: bold; text-decoration: underline;">Merry Yolanda D</td>
        </tr>
        <tr>
          <td align="center" style="font-weight: bold; font-style: italic;"> Komisaris</td>
        </tr>
      </thead>
    </table>
  </div>  
</div>
</div>
</div>


<!-- Bootstrap core JavaScript-->

<script src="/sbadmin/vendor/bootstrap/js/bootstrap.min.js"></script>



</body>

</html>