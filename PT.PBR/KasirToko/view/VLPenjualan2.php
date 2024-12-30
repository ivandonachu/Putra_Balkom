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
$foto_profile = $data1['foto_profile'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Kasir') {

}

else{  header("Location: logout.php");
exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];

if (isset($_GET['tanggal1'])) {
 $tanggal_awal = $_GET['tanggal1'];
 $tanggal_akhir = $_GET['tanggal2'];
} 

elseif (isset($_POST['tanggal1'])) {
 $tanggal_awal = $_POST['tanggal1'];
 $tanggal_akhir = $_POST['tanggal2'];
}  

if ($tanggal_awal == $tanggal_akhir) {
    $table = mysqli_query($koneksi, "SELECT * FROM riwayat_penjualan a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun INNER JOIN baja c ON a.kode_baja=c.kode_baja
     WHERE tanggal = '$tanggal_awal'");
    $table2 = mysqli_query($koneksi, "SELECT * FROM inventory a INNER JOIN baja b ON a.kode_baja=b.kode_baja WHERE b.kode_baja != 'L03K01' AND b.kode_baja != 'L12K01' AND b.kode_baja != 'B05K01' AND b.kode_baja != 'B12K01'");
    $sql_bon = mysqli_query($koneksi, "SELECT * FROM riwayat_penjualan a INNER JOIN piutang_dagang b ON a.no_transaksi=b.no_transaksi INNER JOIN baja c ON a.kode_baja=c.kode_baja
        WHERE status_piutang = 'Sudah di Bayar' AND tanggal = '$tanggal_awal' ");


//GUDANG GUDANG GUDANG GUDANG GUDANGGUDANG
//GUDANG
//patokan stok awal
    $table35 = mysqli_query($koneksi, "SELECT MAX(no_laporan) FROM laporan_inventory WHERE referensi = 'GD' ");
    $data35 = mysqli_fetch_array($table35);
    $no_laporan_gd = $data35['MAX(no_laporan)'];

//3KG ISI TK
//3KG isi keluar
//baja isi LPG 3kg
    $table36 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_3_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L03K01' ");
    $data_penjualan_3_gd = mysqli_fetch_array($table36);
    $total_penjualan_3_gd= $data_penjualan_3_gd['penjualan_3_gd'];
    if (!isset($data_penjualan_3_gd['penjualan_3_gd'])) {
        $total_penjualan_3_gd = 0;
    }
//3KG isi Masuk
//baja isi LPG 3kg
    $table37 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_3_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K01' ");
    $data_pembelian_3_gd = mysqli_fetch_array($table37);
    $total_pembelian_3_gd = $data_pembelian_3_gd['pembelian_3_gd'];
    if (!isset($data_pembelian_3_gd['pembelian_3_gd'])) {
        $total_pembelian_3_gd = 0;
    }
//konfirmasi retur
    $tabelgd1 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_3_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K11'  ");
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
    $table40 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_3ksg_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L03K10'  ");
    $data_penjualan_3ksg_gd = mysqli_fetch_array($table40);
    $total_penjualan_3ksg_gd = $data_penjualan_3ksg_gd['penjualan_3ksg_gd'];
    if (!isset($data_penjualan_3ksg_gd['penjualan_3ksg_gd'])) {
        $total_penjualan_3ksg_gd = 0;
    }
//baja kosong LPG 3kg Masuk
    $table41 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_3ksg_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L03K10'  ");
    $data_pembelian_3ksg_gd = mysqli_fetch_array($table41);
    $total_pembelian_3ksg_gd = $data_pembelian_3ksg_gd['pembelian_3ksg_gd'];
    if (!isset($data_pembelian_3_gd['pembelian_3ksg_gd'])) {
        $total_pembelian_3ksg_gd = 0;
    }
//konfirmasi retur
    $tabelgd3 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_3ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K10'");
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
    $table44 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_12_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L12K01'  ");
    $data_penjualan_12_gd = mysqli_fetch_array($table44);
    $total_penjualan_12_gd = $data_penjualan_12_gd['penjualan_12_gd'];
    if (!isset($data_penjualan_12_gd['penjualan_12_gd'])) {
        $total_penjualan_12_gd = 0;
    }
//baja isi LPG 12kg Masuk
    $table45 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_12_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L12K01' ");
    $data_pembelian_12_gd = mysqli_fetch_array($table45);
    $total_pembelian_12_gd = $data_pembelian_12_gd['pembelian_12_gd'];
    if (!isset($data_pembelian_12_gd['pembelian_12_gd'])) {
        $total_pembelian_12_gd = 0;
    }
//konfirmasi retur
    $tabelgd5 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_12_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L12K11'  ");
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
    $table48 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_12ksg_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L12K10' ");
    $data_penjualan_12ksg_gd = mysqli_fetch_array($table48);
    $total_penjualan_12ksg_gd= $data_penjualan_12ksg_gd['penjualan_12ksg_gd'];
    if (!isset($data_penjualan_12ksg_gd['penjualan_12ksg_gd'])) {
        $total_penjualan_12ksg_gd = 0;
    }
//baja kosong LPG 12kg Masuk
    $table49 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_12ksg_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L12K10'  ");
    $data_pembelian_12ksg_gd = mysqli_fetch_array($table49);
    $total_pembelian_12ksg_gd = $data_pembelian_12ksg_gd['pembelian_12ksg_gd'];
    if (!isset($data_pembelian_12ksg_gd['pembelian_12ksg_gd'])) {
        $total_pembelian_12ksg_gd = 0;
    }
//konfirmasi retur
    $tabelgd7 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_12ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L12K10'  ");
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
    $table52 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b05_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B05K01'  ");
    $data_penjualan_b05_gd = mysqli_fetch_array($table52);
    $total_penjualan_b05_gd= $data_penjualan_b05_gd['penjualan_b05_gd'];
    if (!isset($data_penjualan_b05_gd['penjualan_b05_gd'])) {
        $total_penjualan_b05_gd = 0;
    }
//baja isi BG 5,5kg Masuk
    $table53 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b05_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B05K01'  ");
    $data_pembelian_b05_gd = mysqli_fetch_array($table53);
    $total_pembelian_b05_gd = $data_pembelian_b05_gd['pembelian_b05_gd'];
    if (!isset($data_pembelian_b05_gd['pembelian_b05_gd'])) {
        $total_pembelian_b05_gd = 0;
    }
//konfirmasi retur
    $tabelgd9 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b05_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B05K11'  ");
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
    $table56 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b05ksg_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B05K10' ");
    $data_penjualan_b05ksg_gd = mysqli_fetch_array($table56);
    $total_penjualan_b05ksg_gd= $data_penjualan_b05ksg_gd['penjualan_b05ksg_gd'];
    if (!isset($data_penjualan_b05ksg_gd['penjualan_b05ksg_gd'])) {
        $total_penjualan_b05ksg_gd = 0;
    }
//baja kosong BG 5,5 KG Masuk
    $table57 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b05ksg_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B05K10'");
    $data_pembelian_b05ksg_gd = mysqli_fetch_array($table57);
    $total_pembelian_b05ksg_gd = $data_pembelian_b05ksg_gd['pembelian_b05ksg_gd'];
    if (!isset($data_pembelian_b05ksg_gd['pembelian_b05ksg_gd'])) {
        $total_pembelian_b05ksg_gd = 0;
    }
//konfirmasi retur
    $tabelgd11 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b05ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B05K10'  ");
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
    $table60 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b12_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B12K01' ");
    $data_penjualan_b12_gd = mysqli_fetch_array($table60);
    $total_penjualan_b12_gd= $data_penjualan_b12_gd['penjualan_b12_gd'];
    if (!isset($data_penjualan_b12_gd['penjualan_b12_gd'])) {
        $total_penjualan_b12_gd = 0;
    }
//baja isi BG 12kg Masuk
    $table61 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b12_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B12K01' ");
    $data_pembelian_b12_gd = mysqli_fetch_array($table61);
    $total_pembelian_b12_gd = $data_pembelian_b12_gd['pembelian_b12_gd'];
    if (!isset($data_pembelian_b12_gd['pembelian_b12_gd'])) {
        $total_pembelian_b12_gd = 0;
    }
//konfirmasi retur
    $tabelgd13 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b12_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B12K11'  ");
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
    $table64 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b12ksg_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B12K10'  ");
    $data_penjualan_b12ksg_gd = mysqli_fetch_array($table64);
    $total_penjualan_b12ksg_gd= $data_penjualan_b12ksg_gd['penjualan_b12ksg_gd'];
    if (!isset($data_penjualan_b12ksg_gd['penjualan_b12ksg_gd'])) {
        $total_penjualan_b12ksg_gd = 0;
    }
//baja kosong BG 12kg Masuk
    $table65 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b12ksg_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B12K10' ");
    $data_pembelian_b12ksg_gd = mysqli_fetch_array($table65);
    $total_pembelian_b12ksg_gd = $data_pembelian_b12ksg_gd['pembelian_b12ksg_gd'];
    if (!isset($data_pembelian_b12ksg_gd['pembelian_b12ksg_gd'])) {
        $total_pembelian_b12ksg_gd = 0;
    }
//konfirmasi retur
    $tabelgd15 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b12ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B12K10'  ");
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
     WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $table2 = mysqli_query($koneksi, "SELECT * FROM inventory a INNER JOIN baja b ON a.kode_baja=b.kode_baja WHERE b.kode_baja != 'L03K01' AND b.kode_baja != 'L12K01' AND b.kode_baja != 'B05K01' AND b.kode_baja != 'B12K01'");
     $sql_bon = mysqli_query($koneksi, "SELECT * FROM riwayat_penjualan a INNER JOIN piutang_dagang b ON a.no_transaksi=b.no_transaksi INNER JOIN baja c ON a.kode_baja=c.kode_baja
        WHERE  status_piutang = 'Sudah di Bayar' AND tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");




//GUDANG GUDANG GUDANG GUDANG GUDANGGUDANG
//GUDANG
//patokan stok awal
    $table35 = mysqli_query($koneksi, "SELECT no_laporan FROM laporan_inventory WHERE referensi = 'GD'  AND tanggal = '$tanggal_awal' ");
    $data35 = mysqli_fetch_array($table35);
    $no_laporan_gd = $data35['no_laporan'];

//3KG ISI TK
//3KG isi keluar
//baja isi LPG 3kg
    $table36 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_3_gd FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'L03K01'  ");
    $data_penjualan_3_gd = mysqli_fetch_array($table36);
    $total_penjualan_3_gd= $data_penjualan_3_gd['penjualan_3_gd'];
    if (!isset($data_penjualan_3_gd['penjualan_3_gd'])) {
        $total_penjualan_3_gd = 0;
    }
//3KG isi Masuk
//baja isi LPG 3kg
    $table37 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_3_gd FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K01'  ");
    $data_pembelian_3_gd = mysqli_fetch_array($table37);
    $total_pembelian_3_gd = $data_pembelian_3_gd['pembelian_3_gd'];
    if (!isset($data_pembelian_3_gd['pembelian_3_gd'])) {
        $total_pembelian_3_gd = 0;
    }
//konfirmasi retur
    $tabelgd1 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_3_gd FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K11' ");
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
    $table40 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_3ksg_gd FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'L03K10'  ");
    $data_penjualan_3ksg_gd = mysqli_fetch_array($table40);
    $total_penjualan_3ksg_gd = $data_penjualan_3ksg_gd['penjualan_3ksg_gd'];
    if (!isset($data_penjualan_3ksg_gd['penjualan_3ksg_gd'])) {
        $total_penjualan_3ksg_gd = 0;
    }
//baja kosong LPG 3kg Masuk
    $table41 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_3ksg_gd FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'L03K10'  ");
    $data_pembelian_3ksg_gd = mysqli_fetch_array($table41);
    $total_pembelian_3ksg_gd = $data_pembelian_3ksg_gd['pembelian_3ksg_gd'];
    if (!isset($data_pembelian_3_gd['pembelian_3ksg_gd'])) {
        $total_pembelian_3ksg_gd = 0;
    }
//konfirmasi retur
    $tabelgd3 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_3ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L03K10'  ");
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
    $table44 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_12_gd FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'L12K01'  ");
    $data_penjualan_12_gd = mysqli_fetch_array($table44);
    $total_penjualan_12_gd = $data_penjualan_12_gd['penjualan_12_gd'];
    if (!isset($data_penjualan_12_gd['penjualan_12_gd'])) {
        $total_penjualan_12_gd = 0;
    }
//baja isi LPG 12kg Masuk
    $table45 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_12_gd FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'L12K01' ");
    $data_pembelian_12_gd = mysqli_fetch_array($table45);
    $total_pembelian_12_gd = $data_pembelian_12_gd['pembelian_12_gd'];
    if (!isset($data_pembelian_12_gd['pembelian_12_gd'])) {
        $total_pembelian_12_gd = 0;
    }
//konfirmasi retur
    $tabelgd5 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_12_gd FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L12K11'  ");
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
    $table48 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_12ksg_gd FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'L12K10'  ");
    $data_penjualan_12ksg_gd = mysqli_fetch_array($table48);
    $total_penjualan_12ksg_gd= $data_penjualan_12ksg_gd['penjualan_12ksg_gd'];
    if (!isset($data_penjualan_12ksg_gd['penjualan_12ksg_gd'])) {
        $total_penjualan_12ksg_gd = 0;
    }
//baja kosong LPG 12kg Masuk
    $table49 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_12ksg_gd FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L12K10'  ");
    $data_pembelian_12ksg_gd = mysqli_fetch_array($table49);
    $total_pembelian_12ksg_gd = $data_pembelian_12ksg_gd['pembelian_12ksg_gd'];
    if (!isset($data_pembelian_12ksg_gd['pembelian_12ksg_gd'])) {
        $total_pembelian_12ksg_gd = 0;
    }
//konfirmasi retur
    $tabelgd7 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_12ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'L12K10'  ");
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
    $table52 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b05_gd FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B05K01' ");
    $data_penjualan_b05_gd = mysqli_fetch_array($table52);
    $total_penjualan_b05_gd= $data_penjualan_b05_gd['penjualan_b05_gd'];
    if (!isset($data_penjualan_b05_gd['penjualan_b05_gd'])) {
        $total_penjualan_b05_gd = 0;
    }
//baja isi BG 5,5kg Masuk
    $table53 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b05_gd FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B05K01'  ");
    $data_pembelian_b05_gd = mysqli_fetch_array($table53);
    $total_pembelian_b05_gd = $data_pembelian_b05_gd['pembelian_b05_gd'];
    if (!isset($data_pembelian_b05_gd['pembelian_b05_gd'])) {
        $total_pembelian_b05_gd = 0;
    }
//konfirmasi retur
    $tabelgd9 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b05_gd FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B05K11'  ");
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
    $table56 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b05ksg_gd FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B05K10'  ");
    $data_penjualan_b05ksg_gd = mysqli_fetch_array($table56);
    $total_penjualan_b05ksg_gd= $data_penjualan_b05ksg_gd['penjualan_b05ksg_gd'];
    if (!isset($data_penjualan_b05ksg_gd['penjualan_b05ksg_gd'])) {
        $total_penjualan_b05ksg_gd = 0;
    }
//baja kosong BG 5,5 KG Masuk
    $table57 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b05ksg_gd FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B05K10' ");
    $data_pembelian_b05ksg_gd = mysqli_fetch_array($table57);
    $total_pembelian_b05ksg_gd = $data_pembelian_b05ksg_gd['pembelian_b05ksg_gd'];
    if (!isset($data_pembelian_b05ksg_gd['pembelian_b05ksg_gd'])) {
        $total_pembelian_b05ksg_gd = 0;
    }
//konfirmasi retur
    $tabelgd11 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b05ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B05K10' ");
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
    $table60 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b12_gd FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B12K01' ");
    $data_penjualan_b12_gd = mysqli_fetch_array($table60);
    $total_penjualan_b12_gd= $data_penjualan_b12_gd['penjualan_b12_gd'];
    if (!isset($data_penjualan_b12_gd['penjualan_b12_gd'])) {
        $total_penjualan_b12_gd = 0;
    }
//baja isi BG 12kg Masuk
    $table61 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b12_gd FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B12K01'  ");
    $data_pembelian_b12_gd = mysqli_fetch_array($table61);
    $total_pembelian_b12_gd = $data_pembelian_b12_gd['pembelian_b12_gd'];
    if (!isset($data_pembelian_b12_gd['pembelian_b12_gd'])) {
        $total_pembelian_b12_gd = 0;
    }
//konfirmasi retur
    $tabelgd13 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b12_gd FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B12K11'  ");
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
    $table64 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_b12ksg_gd FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B12K10'  ");
    $data_penjualan_b12ksg_gd = mysqli_fetch_array($table64);
    $total_penjualan_b12ksg_gd= $data_penjualan_b12ksg_gd['penjualan_b12ksg_gd'];
    if (!isset($data_penjualan_b12ksg_gd['penjualan_b12ksg_gd'])) {
        $total_penjualan_b12ksg_gd = 0;
    }
//baja kosong BG 12kg Masuk
    $table65 = mysqli_query($koneksi, "SELECT SUM(qty) AS pembelian_b12ksg_gd FROM riwayat_pembelian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_baja = 'B12K10'  ");
    $data_pembelian_b12ksg_gd = mysqli_fetch_array($table65);
    $total_pembelian_b12ksg_gd = $data_pembelian_b12ksg_gd['pembelian_b12ksg_gd'];
    if (!isset($data_pembelian_b12ksg_gd['pembelian_b12ksg_gd'])) {
        $total_pembelian_b12ksg_gd = 0;
    }
//konfirmasi retur
    $tabelgd15 = mysqli_query($koneksi, "SELECT SUM(qty) AS retur_b12ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_baja = 'B12K10'  ");
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

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Laporan Penjualan MES/PBR</title>

  <!-- Custom fonts for this template-->
  <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
  href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
  rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/sbadmin/vendor/bootstrap/css/bootstrap.min.css">
  <!-- Custom styles for this template-->
  <link href="/sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Link Tabel -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="/bootstrap-select/dist/css/bootstrap-select.css">

  <!-- Link datepicker -->

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

             <!-- Sidebar -->
        <ul class="navbar-nav  sidebar sidebar-dark accordion" style=" background-color: #004445" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKasirToko.php">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="margin-top: 50px; height: 110px; width: 120px; " src="../gambar/Logo CBM.PNG" ></div>
</a>
<br> <br>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active" >
    <a class="nav-link" href="DsKasirToko.php">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu Kasir Toko
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Transaksi</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Transaksi</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VPenjualan1">Penjualan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaran1">Pengeluaran</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKeuanganPBR">Keuangan PBR</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKeuanganMES">Keuangan MES</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPembelian1">Pembelian</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan1">Laporan Keuangan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPenggunaanSaldo">Laporan Saldo</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRiwayatDeposit1">Riwayat Deposit</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRiwayatBonPembelian1">Riwayat Bon </a>
            <a class="collapse-item" style="font-size: 15px;" href="VBonKaryawan">Bon Karyawan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Gaji Karyawan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitDriverMES">Laporan Rit MES</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitDriverPBR">Laporan Rit PBR</a>
        </div>
    </div>
</li>

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
    aria-expanded="true" aria-controls="collapseUtilities">
    <i class="fas fa-dolly-flatbed" style="font-size: 15px; color:white;"></i>
    <span style="font-size: 15px; color:white;">Pencatatan Inventory</span>
</a>
<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
data-parent="#accordionSidebar">
<div class="bg-white py-2 collapse-inner rounded">
    <h6 class="collapse-header" style="font-size: 15px;">Menu Inventory</h6>
    <a class="collapse-item" href="VInventoryPerusahaan" style="font-size: 15px;">Inventory Perusahaan</a>
    <a class="collapse-item" style="font-size: 15px;" href="VRiwayatPeminjaman1">Riwayat Peminjaman</a>
    <a class="collapse-item" href="VKonfirmasiRetur" style="font-size: 15px;">Konfirmasi Retur</a>
    <a class="collapse-item" href="VKeberangkatan" style="font-size: 15px;">Keberangkatan</a>
    <a class="collapse-item" href="VReturPangkalan" style="font-size: 15px;">Retur Pangkalan</a>
</div>
</div>
</li>
<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilitiesx"
    aria-expanded="true" aria-controls="collapseUtilitiesx">
    <i class="fas fa-clipboard-list" style="font-size: 15px; color:white;"></i>
    <span style="font-size: 15px; color:white;">Administrasi</span>
</a>
<div id="collapseUtilitiesx" class="collapse" aria-labelledby="headingUtilities"
data-parent="#accordionSidebar">
<div class="bg-white py-2 collapse-inner rounded">
    <h6 class="collapse-header" style="font-size: 15px;">Menu Administrasi</h6>
    <a class="collapse-item" style="font-size: 15px;" href="VPangkalan">Pangkalan</a>
    <a class="collapse-item" style="font-size: 15px;" href="VKaryawan">Karyawan</a>
    <a class="collapse-item" style="font-size: 15px;" href="VDriver">Driver</a>
    <a class="collapse-item" href="VRute" style="font-size: 15px;">Rute</a>
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
      <?php echo "<a href='VLPenjualanpbr2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Laporan Penjualan MES/PBR</h5></a>"; ?>

      <!-- Sidebar Toggle (Topbar) -->
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>



    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">


        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline  small"  style="color:white;"><?php echo "$nama"; ?></span>
                    <img class="img-profile rounded-circle" src="/assets/img/foto_profile/<?= $foto_profile; ?>"><!-- link foto profile --> 
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
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

<!-- Top content -->
<div>   


  <!-- Name Page -->
  <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
  <?php  echo "<form  method='POST' action='VLPenjualan2'>" ?>
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
<?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
<br>
<br>
<!-- Keterangan Penjualan -->
<!-- Penjaulan Isi -->
        <div class="row" style="margin-right: 20px; margin-left: 20px;">
            <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Penjualan Elpiji 3 Kg Isi</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=    $total_penjualan_3_gd  ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Penjualan Elpiji 12 Kg Isi</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=   $total_penjualan_12_gd ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Penjualan Bright Gas 5,5 Kg Isi</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_penjualan_b05_gd ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Penjualan Bright Gas 12 Kg Isi</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=   $total_penjualan_b12_gd ?> </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <br>
                        <br>
<!-- Tabel -->    
<div style="overflow-x: auto" align = 'center' >
  <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>REF</th>
      <th>Akun</th>
      <th>Barang</th>
      <th>Penyaluran</th>
      <th>Nama</th>
      <th>Pembayaran</th>
      <th>QTY</th>
      <th>Harga</th>
      <th>Jumlah</th>    
      <th>Keterangan</th>
      <th>File</th>
  </tr>
</thead>
<tbody>
    <?php
    $total_mes = 0;
    $total_briva_mes = 0;
    $total_transfer_mes = 0;
    $total_cash_mes = 0;
    $L03_mes = 0;
    $B05_mes = 0;
    $B12_mes = 0;
    $L12_mes = 0;
    $L03_cash_mes = 0;
    $B05_cash_mes = 0;
    $B12_cash_mes = 0;
    $L12_cash_mes = 0;

    $total_pbr = 0;
    $total_briva_pbr = 0;
    $total_transfer_pbr = 0;
    $total_cash_pbr = 0;
    $L03_pbr = 0;
    $B05_pbr = 0;
    $B12_pbr = 0;
    $L12_pbr = 0;
    $L03_cash_pbr = 0;
    $B05_cash_pbr = 0;
    $B12_cash_pbr = 0;
    $L12_cash_pbr = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
  }

  ?>

  <?php while($data = mysqli_fetch_array($table)){
      $no_transaksi = $data['no_transaksi'];
      $tanggal =$data['tanggal'];
      $referensi = $data['referensi'];
      $nama_akun = $data['nama_akun'];
      $nama_baja = $data['nama_baja'];
      $penyaluran = $data['penyaluran'];
      $nama = $data['nama'];
      $pembayaran = $data['pembayaran'];
      $qty = $data['qty'];
      $harga = $data['harga'];
      $jumlah = $data['jumlah'];
      $keterangan = $data['keterangan'];
      $file_bukti = $data['file_bukti'];
      
      if($referensi == 'MES' ){
            $total_mes = $total_mes + $jumlah;

        if($pembayaran == 'Cash' OR $pembayaran =='Deposit' ){
            $total_cash_mes = $total_cash_mes + $jumlah;
          }
          else if($pembayaran == 'Briva' ){
            $total_briva_mes = $total_briva_mes + $jumlah;
          }
          else if($pembayaran == 'Transfer' ){
            $total_transfer_mes = $total_transfer_mes + $jumlah;
          }

        if ($pembayaran == 'Cash' OR $pembayaran =='Deposit') {
            if ($nama_baja == 'Elpiji 3 Kg Isi' || $nama_baja == 'Elpiji 3 Kg Baja + Isi' || $nama_baja == 'Elpiji 3 Kg Baja Kosong') {
            $L03_cash_mes = $L03_cash_mes + $jumlah;
        }
        elseif ($nama_baja == 'Elpiji 12 Kg Isi' || $nama_baja == 'Elpiji 12 Kg Baja + Isi' || $nama_baja == 'Elpiji 12 Kg Baja Kosong') {
            $L12_cash_mes = $L12_cash_mes + $jumlah;
        }
        elseif ($nama_baja == 'Bright Gas 5,5 Kg Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja + Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja Kosong') {
            $B05_cash_mes = $B05_cash_mes + $jumlah;
        }
        elseif ($nama_baja == 'Bright Gas 12 Kg Isi' || $nama_baja == 'Bright Gas 12 Kg Baja + Isi' || $nama_baja == 'Bright Gas 12 Kg Baja Kosong') {
            $B12_cash_mes = $B12_cash_mes + $jumlah;
        }
            }
        else if ($pembayaran == 'Bon') {
            $sql_bon = mysqli_query($koneksi, "SELECT * FROM piutang_dagang WHERE no_transaksi = '$no_transaksi' ");
            $data_bon = mysqli_fetch_array($sql_bon);
            $jumlah_bon = $data_bon['jumlah_bayar'];
            if ($nama_baja == 'Elpiji 3 Kg Isi' || $nama_baja == 'Elpiji 3 Kg Baja + Isi' || $nama_baja == 'Elpiji 3 Kg Baja Kosong') {
            $L03_cash_mes = $L03_cash_mes + $jumlah_bon;
        }
        elseif ($nama_baja == 'Elpiji 12 Kg Isi' || $nama_baja == 'Elpiji 12 Kg Baja + Isi' || $nama_baja == 'Elpiji 12 Kg Baja Kosong') {
            $L12_cash_mes = $L12_cash_mes + $jumlah_bon;
        }
        elseif ($nama_baja == 'Bright Gas 5,5 Kg Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja + Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja Kosong') {
            $B05_cash_mes = $B05_cash_mes + $jumlah_bon;
        }
        elseif ($nama_baja == 'Bright Gas 12 Kg Isi' || $nama_baja == 'Bright Gas 12 Kg Baja + Isi' || $nama_baja == 'Bright Gas 12 Kg Baja Kosong') {
            $B12_cash_mes = $B12_cash_mes + $jumlah_bon;
        }
        }
        else{
            if ($nama_baja == 'Elpiji 3 Kg Isi' || $nama_baja == 'Elpiji 3 Kg Baja + Isi' || $nama_baja == 'Elpiji 3 Kg Baja Kosong') {
            $L03_mes = $L03_mes + $jumlah;
        }
        elseif ($nama_baja == 'Elpiji 12 Kg Isi' || $nama_baja == 'Elpiji 12 Kg Baja + Isi' || $nama_baja == 'Elpiji 12 Kg Baja Kosong') {
            $L12_mes = $L12_mes + $jumlah;
        }
        elseif ($nama_baja == 'Bright Gas 5,5 Kg Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja + Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja Kosong') {
            $B05_mes = $B05_mes + $jumlah;
        }
        elseif ($nama_baja == 'Bright Gas 12 Kg Isi' || $nama_baja == 'Bright Gas 12 Kg Baja + Isi' || $nama_baja == 'Bright Gas 12 Kg Baja Kosong') {
            $B12_mes = $B12_mes + $jumlah;
        }
        }
      }
      else{
        $total_pbr = $total_pbr + $jumlah;

  if($pembayaran == 'Cash' OR $pembayaran =='Deposit' ){
      $total_cash_pbr = $total_cash_pbr + $jumlah;
    }
    else if($pembayaran == 'Briva' ){
      $total_briva_pbr = $total_briva_pbr + $jumlah;
    }
    else if($pembayaran == 'Transfer' ){
      $total_transfer_pbr = $total_transfer_pbr + $jumlah;
    }

  if ($pembayaran == 'Cash' OR $pembayaran =='Deposit') {
      if ($nama_baja == 'Elpiji 3 Kg Isi' || $nama_baja == 'Elpiji 3 Kg Baja + Isi' || $nama_baja == 'Elpiji 3 Kg Baja Kosong') {
      $L03_cash_pbr = $L03_cash_pbr + $jumlah;
  }
  elseif ($nama_baja == 'Elpiji 12 Kg Isi' || $nama_baja == 'Elpiji 12 Kg Baja + Isi' || $nama_baja == 'Elpiji 12 Kg Baja Kosong') {
      $L12_cash_pbr = $L12_cash_pbr + $jumlah;
  }
  elseif ($nama_baja == 'Bright Gas 5,5 Kg Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja + Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja Kosong') {
      $B05_cash_pbr = $B05_cash_pbr + $jumlah;
  }
  elseif ($nama_baja == 'Bright Gas 12 Kg Isi' || $nama_baja == 'Bright Gas 12 Kg Baja + Isi' || $nama_baja == 'Bright Gas 12 Kg Baja Kosong') {
      $B12_cash_pbr = $B12_cash_pbr + $jumlah;
  }
      }
  else if ($pembayaran == 'Bon') {
      $sql_bon = mysqli_query($koneksi, "SELECT * FROM piutang_dagang WHERE no_transaksi = '$no_transaksi' ");
      $data_bon = mysqli_fetch_array($sql_bon);
      $jumlah_bon = $data_bon['jumlah_bayar'];
      if ($nama_baja == 'Elpiji 3 Kg Isi' || $nama_baja == 'Elpiji 3 Kg Baja + Isi' || $nama_baja == 'Elpiji 3 Kg Baja Kosong') {
      $L03_cash_pbr = $L03_cash_pbr + $jumlah_bon;
  }
  elseif ($nama_baja == 'Elpiji 12 Kg Isi' || $nama_baja == 'Elpiji 12 Kg Baja + Isi' || $nama_baja == 'Elpiji 12 Kg Baja Kosong') {
      $L12_cash_pbr = $L12_cash_pbr + $jumlah_bon;
  }
  elseif ($nama_baja == 'Bright Gas 5,5 Kg Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja + Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja Kosong') {
      $B05_cash_pbr = $B05_cash_pbr + $jumlah_bon;
  }
  elseif ($nama_baja == 'Bright Gas 12 Kg Isi' || $nama_baja == 'Bright Gas 12 Kg Baja + Isi' || $nama_baja == 'Bright Gas 12 Kg Baja Kosong') {
      $B12_cash_pbr = $B12_cash_pbr + $jumlah_bon;
  }
  }
  else{
      if ($nama_baja == 'Elpiji 3 Kg Isi' || $nama_baja == 'Elpiji 3 Kg Baja + Isi' || $nama_baja == 'Elpiji 3 Kg Baja Kosong') {
      $L03_pbr = $L03_pbr + $jumlah;
  }
  elseif ($nama_baja == 'Elpiji 12 Kg Isi' || $nama_baja == 'Elpiji 12 Kg Baja + Isi' || $nama_baja == 'Elpiji 12 Kg Baja Kosong') {
      $L12_pbr = $L12_pbr + $jumlah;
  }
  elseif ($nama_baja == 'Bright Gas 5,5 Kg Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja + Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja Kosong') {
      $B05_pbr = $B05_pbr + $jumlah;
  }
  elseif ($nama_baja == 'Bright Gas 12 Kg Isi' || $nama_baja == 'Bright Gas 12 Kg Baja + Isi' || $nama_baja == 'Bright Gas 12 Kg Baja Kosong') {
      $B12_pbr = $B12_pbr + $jumlah;
  }
  }
      }


$nama_baja1 = "Pembayaran Selain Penjualan";


echo "<tr>
<td style='font-size: 14px'>$no_transaksi</td>
<td style='font-size: 14px'>$tanggal</td>
<td style='font-size: 14px'>$referensi</td>
<td style='font-size: 14px'>$nama_akun</td>
";
if ($nama_akun == "Pendapatan Lain-lain Diluar Usaha") { 
    echo "<td style='font-size: 14px'>$nama_baja1</td>";  
}
else { echo " <td style='font-size: 14px'>$nama_baja</td>";}
echo "
<td style='font-size: 14px'>$penyaluran</td>
<td style='font-size: 14px'>$nama</td>
<td style='font-size: 14px'>$pembayaran</td>
<td style='font-size: 14px'>$qty</td>
<td style='font-size: 14px'>";?> <?= formatuang($harga); ?> <?php echo "</td>
<td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
<td style='font-size: 14px'>$keterangan</td>
<td style='font-size: 14px'>"; ?> <a download="../file_toko/<?= $file_bukti ?>" href="../file_toko/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
"; ?>


<?php echo  "  </tr>";
}
?>

</tbody>
</table>
</div>
  </div>
<br>
<br>
<br>
<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h3 align = 'center'>Pendapatan PBR</h3>
  <!-- Tabel -->    
  <table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
    <thead>
      <tr>
        <th>Total Seluruh</th>
        <th>Total Briva</th>
        <th>Total Tranfer</th>
        <th>Total Cash</th>
      </tr>
    </thead>
    <tbody>

      <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($total_pbr); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($total_briva_pbr); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($total_transfer_pbr); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($total_cash_pbr); ?> <?php echo "</td>

      </tr>";

      ?>

    </tbody>
  </table>
</div>
<br>
<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">

  <!-- Tabel -->    
  <table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
    <thead>
      <tr>
        <th>Total Elpiji 3 KG</th>
        <th>Total Bright Gas 5,5 KG</th>
        <th>Total Bright Gas 12 KG</th>
        <th>Total Elpiji 12 KG</th>
        <th>Cash Elpiji 3 KG</th>
        <th>Cash Bright Gas 5,5 KG</th>
        <th>Cash Bright Gas 12 KG</th>
        <th>Cash Elpiji 12 KG</th>
      </tr>
    </thead>
    <tbody>

      <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($L03_pbr + $L03_cash_pbr); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($B05_pbr + $B05_cash_pbr); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($B12_pbr + $B12_cash_pbr); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($L12_pbr + $L12_cash_pbr); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($L03_cash_pbr); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($B05_cash_pbr); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($B12_cash_pbr); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($L12_cash_pbr); ?> <?php echo "</td>

      </tr>";

      ?>

    </tbody>
  </table>
</div>
<br>
<br>
<br>
<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h3 align = 'center'>Pendapatan MES</h3>
  <!-- Tabel -->    
  <table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
    <thead>
      <tr>
        <th>Total Seluruh</th>
        <th>Total Briva</th>
        <th>Total Tranfer</th>
        <th>Total Cash</th>
      </tr>
    </thead>
    <tbody>

      <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($total_mes); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($total_briva_mes); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($total_transfer_mes); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($total_cash_mes); ?> <?php echo "</td>

      </tr>";

      ?>

    </tbody>
  </table>
</div>
<br>
<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">

  <!-- Tabel -->    
  <table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
    <thead>
      <tr>
        <th>Total Elpiji 3 KG</th>
        <th>Total Bright Gas 5,5 KG</th>
        <th>Total Bright Gas 12 KG</th>
        <th>Total Elpiji 12 KG</th>
        <th>Cash Elpiji 3 KG</th>
        <th>Cash Bright Gas 5,5 KG</th>
        <th>Cash Bright Gas 12 KG</th>
        <th>Cash Elpiji 12 KG</th>
      </tr>
    </thead>
    <tbody>

      <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($L03_mes + $L03_cash_mes); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($B05_mes + $B05_cash_mes); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($B12_mes + $B12_cash_mes); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($L12_mes + $L12_cash_mes); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($L03_cash_mes); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($B05_cash_mes); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($B12_cash_mes); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($L12_cash_mes); ?> <?php echo "</td>

      </tr>";

      ?>

    </tbody>
  </table>
</div>
<br>
<br>
<br>

<div class="pinggir1" style="margin-right: 20px; margin-left: 20px; color:black;">
    <h5 align="center" >Inventory</h3>
        <!-- Tabel -->    
        <table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
           <thead>
            <tr>
              <th>Baja</th>
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
          $gudang = $data2['gudang'];
          $dipinjam = $data2['dipinjam'];
          $passive = $data2['passive'];
          $global = $gudang;
          $total =  $gudang + $dipinjam + $passive;
          echo "<tr>
          <td style='font-size: 14px'>$nama_baja</td>
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


<div class="pinggir1" style="margin-right: 20px; margin-left: 20px; color:black;">


    <h5 align="center" >Rekapitulasi Baja Gudang</h5>
    <!-- Tabel -->    
    <table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
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
        <td><?= $total_penjualan_3_gd  + $total_retur_3_gd ?></td>
        <td><?= $total_pembelian_3_gd + $total_brangkat_3 + $total_brangkat_3_rtr ?></td>
        <td><?= $stok_awal_3kg_isi_gd - ($total_penjualan_3_gd  + $total_retur_3_gd) + ($total_pembelian_3_gd + $total_brangkat_3 + $total_brangkat_3_rtr) ?></td>
    </tr>
    <tr>
        <td>Elpiji 3 Kg Kosong</td>
        <td><?= $stok_awal_3kg_ksg_gd ?></td>
        <td><?= $total_penjualan_3ksg_gd + $total_pembelian_3_gd + $total_retur_3ksg_gd + $total_brangkat_3 ?></td>
        <td><?= $total_pembelian_3ksg_gd + $total_penjualan_3_gd ?></td>
        <td><?= $stok_awal_3kg_ksg_gd - ($total_penjualan_3ksg_gd + $total_pembelian_3_gd + $total_retur_3ksg_gd + $total_brangkat_3) + ($total_pembelian_3ksg_gd + $total_penjualan_3_gd) ?></td>
    </tr>
    <tr>
        <td>Elpiji 3 Kg Retur</td>
        <td><?= $stok_awal_3_rt_gd ?></td>
        <td><?=  $total_brangkat_3_rtr ?></td>
        <td><?= $total_retur_3_gd + $total_retur_3ksg_gd ?></td>
        <td><?= $stok_awal_3_rt_gd - ($total_brangkat_3_rtr) + ($total_retur_3_gd + $total_retur_3ksg_gd)?></td>
    </tr>
    <tr>
        <td>Elpiji 12 Kg baja + Isi</td>
        <td><?= $stok_awal_12kg_isi_gd ?></td>
        <td><?= $total_penjualan_12_gd  + $total_retur_12_gd ?></td>
        <td><?= $total_pembelian_12_gd  + $total_brangkat_12 + $total_brangkat_12_rtr ?></td>
        <td><?= $stok_awal_12kg_isi_gd - ($total_penjualan_12_gd  + $total_retur_12_gd) + ($total_pembelian_12_gd  + $total_brangkat_12 + $total_brangkat_12_rtr)?></td>
    </tr>
    <tr>
        <td>Elpiji 12 Kg Kosong</td>
        <td><?= $stok_awal_12kg_ksg_gd ?></td>
        <td><?= $total_penjualan_12ksg_gd + $total_pembelian_12_gd + $total_retur_12ksg_gd + $total_brangkat_12 ?></td>
        <td><?= $total_pembelian_12ksg_gd + $total_penjualan_12_gd  ?></td>
        <td><?= $stok_awal_12kg_ksg_gd - ($total_penjualan_12ksg_gd + $total_pembelian_12_gd + $total_retur_12ksg_gd + $total_brangkat_12) + ($total_pembelian_12ksg_gd + $total_penjualan_12_gd)?></td>
    </tr>
    <tr>
        <td>Elpiji 12 Kg Retur</td>
        <td><?= $stok_awal_12_rt_gd ?></td>
        <td><?= $total_brangkat_12_rtr ?></td>
        <td><?= $total_retur_12_gd + $total_retur_12ksg_gd ?></td>
        <td><?= $stok_awal_12_rt_gd - ($total_brangkat_12_rtr) + ($total_retur_12_gd + $total_retur_12ksg_gd)?></td>
    </tr>
    <tr>
        <td>Bright Gas 5,5 Kg baja + Isi</td>
        <td><?= $stok_awal_b05_isi_gd ?></td>
        <td><?= $total_penjualan_b05_gd + $total_retur_b05_gd ?></td>
        <td><?= $total_pembelian_b05_gd + $total_brangkat_b05 + $total_brangkat_b05_rtr ?></td>
        <td><?= $stok_awal_b05_isi_gd - ($total_penjualan_b05_gd + $total_retur_b05_gd) + ($total_pembelian_b05_gd + $total_brangkat_b05 + $total_brangkat_b05_rtr)?></td>
    </tr>
    <tr>
        <td>Bright Gas 5,5 Kg Kosong</td>
        <td><?= $stok_awal_b05_ksg_gd ?></td>
        <td><?= $total_penjualan_b05ksg_gd + $total_pembelian_b05_gd + $total_retur_b05ksg_gd + $total_brangkat_b05 ?></td>
        <td><?= $total_pembelian_b05ksg_gd + $total_penjualan_b05_gd  ?></td>
        <td><?= $stok_awal_b05_ksg_gd - ($total_penjualan_b05ksg_gd + $total_pembelian_b05_gd + $total_retur_b05ksg_gd + $total_brangkat_b05) + ($total_pembelian_b05ksg_gd + $total_penjualan_b05_gd)?></td>
    </tr>
    <tr>
        <td>Bright Gas 5,5 Kg Retur</td>
        <td><?= $stok_awal_b05_rt_gd ?></td>
        <td><?=  $total_brangkat_b05_rtr ?></td>
        <td><?= $total_retur_b05_gd + $total_retur_b05ksg_gd  ?></td>
        <td><?= $stok_awal_b05_rt_gd - ($total_brangkat_b05_rtr) + ($total_retur_b05_gd + $total_retur_b05ksg_gd)?></td>
    </tr>
    <tr>
        <td>Bright Gas 12 Kg baja + Isi</td>
        <td><?= $stok_awal_b12_isi_gd ?></td>
        <td><?= $total_penjualan_b12_gd  + $total_retur_b12_gd  ?></td>
        <td><?= $total_pembelian_b12_gd  + $total_brangkat_b12 + $total_brangkat_b12_rtr ?></td>
        <td><?= $stok_awal_b12_isi_gd - ($total_penjualan_b12_gd  + $total_retur_b12_gd) + ($total_pembelian_b12_gd  + $total_brangkat_b12 + $total_brangkat_b12_rtr)?></td>
    </tr>
    <tr>
        <td>Bright Gas 12 Kg Kosong</td>
        <td><?= $stok_awal_b12_ksg_gd ?></td>
        <td><?= $total_penjualan_b12ksg_gd + $total_pembelian_b12_gd + $total_retur_b12ksg_gd + $total_brangkat_b12 ?></td>
        <td><?= $total_pembelian_b12ksg_gd + $total_penjualan_b12_gd  ?></td>
        <td><?= $stok_awal_b12_ksg_gd - ($total_penjualan_b12ksg_gd + $total_pembelian_b12_gd + $total_retur_b12ksg_gd + $total_brangkat_b12) + ($total_pembelian_b12ksg_gd + $total_penjualan_b12_gd)?></td>
    </tr>
    <tr>
        <td>Bright Gas 12 Kg Retur</td>
        <td><?= $stok_awal_b12_rt_gd ?></td>
        <td><?=  $total_brangkat_b12_rtr ?></td>
        <td><?= $total_retur_b12_gd + $total_retur_b12ksg_gd  ?></td>
        <td><?= $stok_awal_b12_rt_gd - ($total_brangkat_b12_rtr) + ($total_retur_b12_gd + $total_retur_b12ksg_gd )?></td>
    </tr>
</tbody>
</table>
</div>



<br>
<br>

<div class="pinggir1" style="margin-right: 20px; margin-left: 20px; color:black;">
    <h5 align="center" >Total Seluruh Baja</h5>
    <!-- Tabel -->    
    <table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
       <thead>
        <tr>
          <th>Nama Baja</th>
          <th>Jumlah Gudang</th>
      </tr>
  </thead>
  <tbody>
    <tr>
        <td>Elpiji 3 Kg</td>
        <td><?= $stok_akhir_3kg_isi_gd + $stok_akhir_3kg_ksg_gd + $stok_akhir_3kg_rt_gd ?></td>
    </tr>
    <tr>
        <td>Elpiji 12 Kg</td>
        <td><?= $stok_akhir_12kg_isi_gd + $stok_akhir_12kg_ksg_gd + $stok_akhir_12_rt_gd ?></td>
    </tr>
    <tr>
        <td>Bright Gas 5,5 </td>
        <td><?= $stok_akhir_b05_isi_gd + $stok_akhir_b05_ksg_gd + $stok_akhir_b05_rt_gd ?></td>
    </tr>
    <tr>
        <td>Bright Gas 12 Kg </td>
        <td><?= $stok_akhir_b12_isi_gd + $stok_akhir_b12_ksg_gd + $stok_akhir_b12_rt_gd  ?></td>
    </tr>
</tbody>
</table>
</div>
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
                  echo "<td align='center'> <img  style='height: 55px; width: 190px;'' src=''> </td>";
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
              echo "<td align='center'> <img  style='height: 55px; width: 190px;'' src=''> </td>";
          }
          else{
            echo "<td align='center'>  </td>";
        }
    }
    
    ?>
    
</tr>
<tr>
  <td align="center" style="font-weight: bold; text-decoration: underline;">Okta</td>
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
              echo "<td align='center'> <img  style='height: 55px; width: 190px;'' src=''> </td>";
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
          echo "<td align='center'> <img  style='height: 55px; width: 190px;'' src=''> </td>";
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<script src="/sbadmin/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="/sbadmin/js/sb-admin-2.min.js"></script>
<script src="/bootstrap-select/dist/js/bootstrap-select.js"></script>
<!-- Tabel -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

<script>
  $(document).ready(function() {
    var table = $('#example').DataTable( {
      lengthChange: false,
      buttons: [ 'copy', 'excel', 'csv', 'pdf', 'colvis' ]
  } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>
<script>
  function createOptions(number) {
    var options = [], _options;

    for (var i = 0; i < number; i++) {
      var option = '<option value="' + i + '">Option ' + i + '</option>';
      options.push(option);
  }

  _options = options.join('');

  $('#number')[0].innerHTML = _options;
  $('#number-multiple')[0].innerHTML = _options;

  $('#number2')[0].innerHTML = _options;
  $('#number2-multiple')[0].innerHTML = _options;
}

var mySelect = $('#first-disabled2');

createOptions(4000);

$('#special').on('click', function () {
    mySelect.find('option:selected').prop('disabled', true);
    mySelect.selectpicker('refresh');
});

$('#special2').on('click', function () {
    mySelect.find('option:disabled').prop('disabled', false);
    mySelect.selectpicker('refresh');
});

$('#basic2').selectpicker({
    liveSearch: true,
    maxOptions: 1
});
</script>


</body>

</html>