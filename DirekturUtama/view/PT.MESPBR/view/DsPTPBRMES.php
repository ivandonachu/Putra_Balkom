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

$tanggal_awal = date('y-m-d');

   $table = mysqli_query($koneksipbr, "SELECT * FROM riwayat_penjualan a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun INNER JOIN baja c ON a.kode_baja=c.kode_baja
     WHERE tanggal = '$tanggal_awal'");
    $table2 = mysqli_query($koneksipbr, "SELECT * FROM inventory a INNER JOIN baja b ON a.kode_baja=b.kode_baja WHERE b.kode_baja != 'L03K01' AND b.kode_baja != 'L12K01' AND b.kode_baja != 'B05K01' AND b.kode_baja != 'B12K01'  ORDER BY a.no_inventory DESC");
   
    $sql_bon = mysqli_query($koneksipbr, "SELECT * FROM riwayat_penjualan a INNER JOIN piutang_dagang b ON a.no_transaksi=b.no_transaksi INNER JOIN baja c ON a.kode_baja=c.kode_baja
        WHERE status_piutang = 'Sudah di Bayar' AND tanggal = '$tanggal_awal' ");


//GUDANG GUDANG GUDANG GUDANG GUDANGGUDANG
//GUDANG
//patokan stok awal
    $table35 = mysqli_query($koneksipbr, "SELECT MAX(no_laporan) FROM laporan_inventory WHERE referensi = 'GD' ");
    $data35 = mysqli_fetch_array($table35);
    $no_laporan_gd = $data35['MAX(no_laporan)'];

//3KG ISI TK
//3KG isi keluar
//baja isi LPG 3kg
    $table36 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS penjualan_3_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L03K01' ");
    $data_penjualan_3_gd = mysqli_fetch_array($table36);
    $total_penjualan_3_gd= $data_penjualan_3_gd['penjualan_3_gd'];
    if (!isset($data_penjualan_3_gd['penjualan_3_gd'])) {
        $total_penjualan_3_gd = 0;
    }
//3KG isi Masuk
//baja isi LPG 3kg
    $table37 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS pembelian_3_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K01' ");
    $data_pembelian_3_gd = mysqli_fetch_array($table37);
    $total_pembelian_3_gd = $data_pembelian_3_gd['pembelian_3_gd'];
    if (!isset($data_pembelian_3_gd['pembelian_3_gd'])) {
        $total_pembelian_3_gd = 0;
    }
//konfirmasi retur
    $tabelgd1 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS retur_3_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K11'  ");
    $data_retur_3_gd = mysqli_fetch_array($tabelgd1);
    $total_retur_3_gd = $data_retur_3_gd['retur_3_gd'];
    if (!isset($data_retur_3_gd['retur_3_gd'])) {
        $total_retur_3_gd = 0;
    }
//Keberangkatan
    $tabelgd2 = mysqli_query($koneksipbr, "SELECT SUM(L03K11) AS brangkat_3 FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' ");
    $data_brangkat_3 = mysqli_fetch_array($tabelgd2);
    $total_brangkat_3 = $data_brangkat_3['brangkat_3'];
    if (!isset($data_brangkat_3['brangkat_3'])) {
        $total_brangkat_3 = 0;
    }
//stok awal 3kg isi
    $table38 = mysqli_query($koneksipbr, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data38 = mysqli_fetch_array($table38);
    $stok_awal_3kg_isi_gd = $data38['L03K11'];

//stok akhir 3kg isi
    $table39 = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
    $data39 = mysqli_fetch_array($table39);
    $stok_akhir_3kg_isi_gd = $data39['gudang'];


//3KG KOSONG TK
//baja kosong LPG 3kg Keluar
    $table40 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS penjualan_3ksg_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L03K10'  ");
    $data_penjualan_3ksg_gd = mysqli_fetch_array($table40);
    $total_penjualan_3ksg_gd = $data_penjualan_3ksg_gd['penjualan_3ksg_gd'];
    if (!isset($data_penjualan_3ksg_gd['penjualan_3ksg_gd'])) {
        $total_penjualan_3ksg_gd = 0;
    }
//baja kosong LPG 3kg Masuk
    $table41 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS pembelian_3ksg_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L03K10'  ");
    $data_pembelian_3ksg_gd = mysqli_fetch_array($table41);
    $total_pembelian_3ksg_gd = $data_pembelian_3ksg_gd['pembelian_3ksg_gd'];
    if (!isset($data_pembelian_3_gd['pembelian_3ksg_gd'])) {
        $total_pembelian_3ksg_gd = 0;
    }
//konfirmasi retur
    $tabelgd3 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS retur_3ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L03K10'");
    $data_retur_3ksg_gd = mysqli_fetch_array($tabelgd3);
    $total_retur_3ksg_gd = $data_retur_3ksg_gd['retur_3ksg_gd'];
    if (!isset($data_retur_3ksg_gd['retur_3ksg_gd'])) {
        $total_retur_3ksg_gd = 0;
    }
//stok awal 3kg kosong
    $table42 = mysqli_query($koneksipbr, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data42 = mysqli_fetch_array($table42);
    $stok_awal_3kg_ksg_gd = $data42['L03K10'];
//stok akhir 3kg kosong
    $table43 = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
    $data43 = mysqli_fetch_array($table43);
    $stok_akhir_3kg_ksg_gd = $data43['gudang'];



//3kg retur
//stok awal 3kg retur
    $tabgd1 = mysqli_query($koneksipbr, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $datgd1 = mysqli_fetch_array($tabgd1);
    $stok_awal_3_rt_gd = $datgd1['L03K00'];
//stok akhir 3kg retur
    $tabgd2 = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L03K00'");
    $datgd2 = mysqli_fetch_array($tabgd2);
    $stok_akhir_3kg_rt_gd = $datgd2['gudang'];
//KEBERANGKATAN
    $tabelgd4 = mysqli_query($koneksipbr, "SELECT SUM(L03K00) AS brangkat_3_rtr FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' ");
    $data_brangkat_3_rtr = mysqli_fetch_array($tabelgd4);
    $total_brangkat_3_rtr = $data_brangkat_3_rtr['brangkat_3_rtr'];
    if (!isset($data_brangkat_3_rtr['brangkat_3_rtr'])) {
        $total_brangkat_3_rtr = 0;
    }




//LPG 12KG ISI
//baja isi LPG 12kg Keluar
    $table44 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS penjualan_12_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L12K01'  ");
    $data_penjualan_12_gd = mysqli_fetch_array($table44);
    $total_penjualan_12_gd = $data_penjualan_12_gd['penjualan_12_gd'];
    if (!isset($data_penjualan_12_gd['penjualan_12_gd'])) {
        $total_penjualan_12_gd = 0;
    }
//baja isi LPG 12kg Masuk
    $table45 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS pembelian_12_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L12K01' ");
    $data_pembelian_12_gd = mysqli_fetch_array($table45);
    $total_pembelian_12_gd = $data_pembelian_12_gd['pembelian_12_gd'];
    if (!isset($data_pembelian_12_gd['pembelian_12_gd'])) {
        $total_pembelian_12_gd = 0;
    }
//konfirmasi retur
    $tabelgd5 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS retur_12_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L12K11'  ");
    $data_retur_12_gd = mysqli_fetch_array($tabelgd5);
    $total_retur_12_gd = $data_retur_12_gd['retur_12_gd'];
    if (!isset($data_retur_12_gd['retur_12_gd'])) {
        $total_retur_12_gd = 0;
    }
//Keberangkatan
    $tabelgd6 = mysqli_query($koneksipbr, "SELECT SUM(L12K11) AS brangkat_12 FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' ");
    $data_brangkat_12 = mysqli_fetch_array($tabelgd6);
    $total_brangkat_12 = $data_brangkat_12['brangkat_12'];
    if (!isset($data_brangkat_12['brangkat_12'])) {
        $total_brangkat_12 = 0;
    }
//stok awal 12kg isi
    $table46 = mysqli_query($koneksipbr, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data46 = mysqli_fetch_array($table46);
    $stok_awal_12kg_isi_gd = $data46['L12K11'];
//stok akhir 12kg isi
    $table47 = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
    $data47 = mysqli_fetch_array($table47);
    $stok_akhir_12kg_isi_gd = $data47['gudang'];


//LPG 12KG kOSONG
//baja kosong LPG 12kg Keluar
    $table48 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS penjualan_12ksg_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L12K10' ");
    $data_penjualan_12ksg_gd = mysqli_fetch_array($table48);
    $total_penjualan_12ksg_gd= $data_penjualan_12ksg_gd['penjualan_12ksg_gd'];
    if (!isset($data_penjualan_12ksg_gd['penjualan_12ksg_gd'])) {
        $total_penjualan_12ksg_gd = 0;
    }
//baja kosong LPG 12kg Masuk
    $table49 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS pembelian_12ksg_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'L12K10'  ");
    $data_pembelian_12ksg_gd = mysqli_fetch_array($table49);
    $total_pembelian_12ksg_gd = $data_pembelian_12ksg_gd['pembelian_12ksg_gd'];
    if (!isset($data_pembelian_12ksg_gd['pembelian_12ksg_gd'])) {
        $total_pembelian_12ksg_gd = 0;
    }
//konfirmasi retur
    $tabelgd7 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS retur_12ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'L12K10'  ");
    $data_retur_12ksg_gd = mysqli_fetch_array($tabelgd7);
    $total_retur_12ksg_gd = $data_retur_12ksg_gd['retur_12ksg_gd'];
    if (!isset($data_retur_12ksg_gd['retur_12ksg_gd'])) {
        $total_retur_12ksg_gd = 0;
    }
//stok awal 12kg kosong
    $table50 = mysqli_query($koneksipbr, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data50 = mysqli_fetch_array($table50);
    $stok_awal_12kg_ksg_gd = $data50['L12K10'];
//stok akhir 12kg kosong
    $table51 = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
    $data51 = mysqli_fetch_array($table51);
    $stok_akhir_12kg_ksg_gd  = $data51['gudang'];



// LPG12kg retur
//stok awal 3kg retur
    $tabgd3 = mysqli_query($koneksipbr, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $datgd3 = mysqli_fetch_array($tabgd3);
    $stok_awal_12_rt_gd = $datgd3['L12K00'];
//stok akhir 3kg retur
    $tabgd4 = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L12K00'");
    $datgd4 = mysqli_fetch_array($tabgd4);
    $stok_akhir_12_rt_gd = $datgd4['gudang'];
//keberangkatan
    $tabelgd8 = mysqli_query($koneksipbr, "SELECT SUM(L12K00) AS brangkat_12_rtr FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' ");
    $data_brangkat_12_rtr = mysqli_fetch_array($tabelgd8);
    $total_brangkat_12_rtr = $data_brangkat_12_rtr['brangkat_12_rtr'];
    if (!isset($data_brangkat_12_rtr['brangkat_12_rtr'])) {
        $total_brangkat_12_rtr = 0;
    }



//BG 5,5 ISI
//baja isi BG 5,5kg Keluar
    $table52 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS penjualan_b05_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B05K01'  ");
    $data_penjualan_b05_gd = mysqli_fetch_array($table52);
    $total_penjualan_b05_gd= $data_penjualan_b05_gd['penjualan_b05_gd'];
    if (!isset($data_penjualan_b05_gd['penjualan_b05_gd'])) {
        $total_penjualan_b05_gd = 0;
    }
//baja isi BG 5,5kg Masuk
    $table53 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS pembelian_b05_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B05K01'  ");
    $data_pembelian_b05_gd = mysqli_fetch_array($table53);
    $total_pembelian_b05_gd = $data_pembelian_b05_gd['pembelian_b05_gd'];
    if (!isset($data_pembelian_b05_gd['pembelian_b05_gd'])) {
        $total_pembelian_b05_gd = 0;
    }
//konfirmasi retur
    $tabelgd9 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS retur_b05_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B05K11'  ");
    $data_retur_b05_gd = mysqli_fetch_array($tabelgd9);
    $total_retur_b05_gd = $data_retur_b05_gd['retur_b05_gd'];
    if (!isset($data_retur_b05_gd['retur_b05_gd'])) {
        $total_retur_b05_gd = 0;
    }
//Keberangkatan
    $tabelgd10 = mysqli_query($koneksipbr, "SELECT SUM(B05K11) AS brangkat_b05 FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' ");
    $data_brangkat_b05 = mysqli_fetch_array($tabelgd10);
    $total_brangkat_b05 = $data_brangkat_b05['brangkat_b05'];
    if (!isset($data_brangkat_b05['brangkat_b05'])) {
        $total_brangkat_b05 = 0;
    }
//stok awal 5,5kg isi
    $table54 = mysqli_query($koneksipbr, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data54 = mysqli_fetch_array($table54);
    $stok_awal_b05_isi_gd = $data54['B05K11'];
//stok akhir 5,5kg isi
    $table55 = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
    $data55 = mysqli_fetch_array($table55);
    $stok_akhir_b05_isi_gd = $data55['gudang'];



//BG 5,5 Kosong 
//baja kosong BG 5,5kg Keluar
    $table56 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS penjualan_b05ksg_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B05K10' ");
    $data_penjualan_b05ksg_gd = mysqli_fetch_array($table56);
    $total_penjualan_b05ksg_gd= $data_penjualan_b05ksg_gd['penjualan_b05ksg_gd'];
    if (!isset($data_penjualan_b05ksg_gd['penjualan_b05ksg_gd'])) {
        $total_penjualan_b05ksg_gd = 0;
    }
//baja kosong BG 5,5 KG Masuk
    $table57 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS pembelian_b05ksg_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B05K10'");
    $data_pembelian_b05ksg_gd = mysqli_fetch_array($table57);
    $total_pembelian_b05ksg_gd = $data_pembelian_b05ksg_gd['pembelian_b05ksg_gd'];
    if (!isset($data_pembelian_b05ksg_gd['pembelian_b05ksg_gd'])) {
        $total_pembelian_b05ksg_gd = 0;
    }
//konfirmasi retur
    $tabelgd11 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS retur_b05ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B05K10'  ");
    $data_retur_b05ksg_gd = mysqli_fetch_array($tabelgd11);
    $total_retur_b05ksg_gd = $data_retur_b05ksg_gd['retur_b05ksg_gd'];
    if (!isset($data_retur_b05ksg_gd['retur_b05ksg_gd'])) {
        $total_retur_b05ksg_gd = 0;
    }
//stok awal 5,5kg kosong
    $table58 = mysqli_query($koneksipbr, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data58 = mysqli_fetch_array($table58);
    $stok_awal_b05_ksg_gd = $data58['B05K10'];
//stok akhir 5,5kg kosong
    $table59 = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
    $data59 = mysqli_fetch_array($table59);
    $stok_akhir_b05_ksg_gd = $data59['gudang'];



// BG 55 kg retur
//stok awal 3kg retur
    $tabgd5 = mysqli_query($koneksipbr, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $datgd5 = mysqli_fetch_array($tabgd5);
    $stok_awal_b05_rt_gd = $datgd5['B05K00'];
//stok akhir 3kg retur
    $tabgd6 = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B05K00'");
    $datgd6 = mysqli_fetch_array($tabgd6);
    $stok_akhir_b05_rt_gd = $datgd6['gudang'];
//keberangkatan
    $tabelgd12 = mysqli_query($koneksipbr, "SELECT SUM(B05K00) AS brangkat_b05_rtr FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' ");
    $data_brangkat_b05_rtr = mysqli_fetch_array($tabelgd12);
    $total_brangkat_b05_rtr = $data_brangkat_b05_rtr['brangkat_b05_rtr'];
    if (!isset($data_brangkat_b05_rtr['brangkat_b05_rtr'])) {
        $total_brangkat_b05_rtr = 0;
    }



//BG 12KG ISI
//baja isi BG 12kg keluar
    $table60 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS penjualan_b12_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B12K01' ");
    $data_penjualan_b12_gd = mysqli_fetch_array($table60);
    $total_penjualan_b12_gd= $data_penjualan_b12_gd['penjualan_b12_gd'];
    if (!isset($data_penjualan_b12_gd['penjualan_b12_gd'])) {
        $total_penjualan_b12_gd = 0;
    }
//baja isi BG 12kg Masuk
    $table61 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS pembelian_b12_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B12K01' ");
    $data_pembelian_b12_gd = mysqli_fetch_array($table61);
    $total_pembelian_b12_gd = $data_pembelian_b12_gd['pembelian_b12_gd'];
    if (!isset($data_pembelian_b12_gd['pembelian_b12_gd'])) {
        $total_pembelian_b12_gd = 0;
    }
//konfirmasi retur
    $tabelgd13 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS retur_b12_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B12K11'  ");
    $data_retur_b12_gd = mysqli_fetch_array($tabelgd13);
    $total_retur_b12_gd = $data_retur_b12_gd['retur_b12_gd'];
    if (!isset($data_retur_b12_gd['retur_b12_gd'])) {
        $total_retur_b12_gd = 0;
    }
//Keberangkatan
    $tabelgd14 = mysqli_query($koneksipbr, "SELECT SUM(B12K11) AS brangkat_b12 FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' ");
    $data_brangkat_b12 = mysqli_fetch_array($tabelgd14);
    $total_brangkat_b12 = $data_brangkat_b12['brangkat_b12'];
    if (!isset($data_brangkat_b12['brangkat_b12'])) {
        $total_brangkat_b12 = 0;
    }
//stok awal 12kg isi
    $table62 = mysqli_query($koneksipbr, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data62 = mysqli_fetch_array($table62);
    $stok_awal_b12_isi_gd = $data62['B12K11'];
//stok akhir 12kg isi
    $table63 = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
    $data63 = mysqli_fetch_array($table63);
    $stok_akhir_b12_isi_gd = $data63['gudang'];



//BG 12KH KOSONG
//baja kosong BG 12kg KELUAR
    $table64 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS penjualan_b12ksg_gd FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B12K10'  ");
    $data_penjualan_b12ksg_gd = mysqli_fetch_array($table64);
    $total_penjualan_b12ksg_gd= $data_penjualan_b12ksg_gd['penjualan_b12ksg_gd'];
    if (!isset($data_penjualan_b12ksg_gd['penjualan_b12ksg_gd'])) {
        $total_penjualan_b12ksg_gd = 0;
    }
//baja kosong BG 12kg Masuk
    $table65 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS pembelian_b12ksg_gd FROM riwayat_pembelian WHERE tanggal = '$tanggal_awal'  AND kode_baja = 'B12K10' ");
    $data_pembelian_b12ksg_gd = mysqli_fetch_array($table65);
    $total_pembelian_b12ksg_gd = $data_pembelian_b12ksg_gd['pembelian_b12ksg_gd'];
    if (!isset($data_pembelian_b12ksg_gd['pembelian_b12ksg_gd'])) {
        $total_pembelian_b12ksg_gd = 0;
    }
//konfirmasi retur
    $tabelgd15 = mysqli_query($koneksipbr, "SELECT SUM(qty) AS retur_b12ksg_gd FROM riwayat_konfirmasi_retur WHERE tanggal = '$tanggal_awal' AND kode_baja = 'B12K10'  ");
    $data_retur_b12ksg_gd = mysqli_fetch_array($tabelgd15);
    $total_retur_b12ksg_gd = $data_retur_b12ksg_gd['retur_b12ksg_gd'];
    if (!isset($data_retur_b12ksg_gd['retur_b12ksg_gd'])) {
        $total_retur_b12ksg_gd = 0;
    }
//stok awal 5,5kg kosong
    $table66 = mysqli_query($koneksipbr, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $data66 = mysqli_fetch_array($table66);
    $stok_awal_b12_ksg_gd = $data66['B12K10'];
//stok akhir 5,5kg kosong
    $table67 = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
    $data67 = mysqli_fetch_array($table67);
    $stok_akhir_b12_ksg_gd = $data67['gudang'];




// BG 55 kg retur
//stok awal 3kg retur
    $tabgd7 = mysqli_query($koneksipbr, "SELECT * FROM laporan_inventory WHERE no_laporan = '$no_laporan_gd'");
    $datgd7 = mysqli_fetch_array($tabgd7);
    $stok_awal_b12_rt_gd = $datgd7['B12K00'];
//stok akhir 3kg retur
    $tabgd8 = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B12K00'");
    $datgd8 = mysqli_fetch_array($tabgd8);
    $stok_akhir_b12_rt_gd = $datgd8['gudang'];
//keberangkatan
    $tabelgd16 = mysqli_query($koneksipbr, "SELECT SUM(B12K00) AS brangkat_b12_rtr FROM riwayat_keberangkatan WHERE tanggal = '$tanggal_awal' ");
    $data_brangkat_b12_rtr = mysqli_fetch_array($tabelgd16);
    $total_brangkat_b12_rtr = $data_brangkat_b12_rtr['brangkat_b12_rtr'];
    if (!isset($data_brangkat_b12_rtr['brangkat_b12_rtr'])) {
        $total_brangkat_b12_rtr = 0;
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

    <title>Dashboard PT MES/PBR</title>

    <!-- Custom fonts for this template-->
    <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
    <script type="text/javascript">
    window.setTimeout("waktu()",1000);
    function waktu() {
        var tanggal = new Date();
        setTimeout("waktu()",1000);
        document.getElementById("jam").innerHTML = tanggal.getHours();
        document.getElementById("menit").innerHTML = tanggal.getMinutes();
        document.getElementById("detik").innerHTML = tanggal.getSeconds();
    }
</script>

</head>

<style>
    #jam-digital{overflow:hidden}
    #hours{float:left; width:50px; height:30px; background-color:#008B8B; margin-right:25px}
    #minute{float:left; width:50px; height:30px; background-color:  #008B8B; margin-right:25px}
    #second{float:left; width:50px; height:30px; background-color: #008B8B;}
    #jam-digital p{color:#FFF; font-size: 22px; text-align:center}
</style>

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
<div class="row">
        <div class="col-sm-9">
        </div>
        <div class="col-sm-3" style="color: black; font-size: 18px;">
        <script type='text/javascript'>
    
            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
            var date = new Date();
            var day = date.getDate();
            var month = date.getMonth();
            var thisDay = date.getDay(),
                thisDay = myDays[thisDay];
            var yy = date.getYear();
            var year = (yy < 1000) ? yy + 1900 : yy;
            document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
       
        </script>
    </div>
</div> 

        <div class="row">
        <div class="col-sm-9">
        </div>
        <div class="col-sm-3">
            <div id="jam-digital">
                <div id="hours"><p id="jam"></p> </div> 
                <div id="minute"><p id="menit"> </p></div>
                <div id="second"><p id="detik"> </p></div>
            </div>
        </div>
    </div>
<br>
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
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=   $total_penjualan_3_gd  ?></div>
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
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  $total_penjualan_12_gd ?></div>
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
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=   $total_penjualan_b05_gd ?></div>
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
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=    $total_penjualan_b12_gd ?> </div>
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
<!-- Pendapatan Penjaulan Isi -->
    <?php
    $L03 = 0;
    $B05 = 0;
    $B12 = 0;
    $L12 = 0;
    $L03_cash = 0;
    $B05_cash = 0;
    $B12_cash = 0;
    $L12_cash = 0;
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
      }}
 ?>
    <div class="pinggir1" style="margin-right: 20px; margin-left: 20px; color:black;">
<h5 align="center" >Pendapatan Hari ini</h5>
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
        <td><?= $stok_akhir_3kg_isi_gd ?></td>
    </tr>
    <tr>
        <td>Elpiji 3 Kg Kosong</td>
        <td><?= $stok_awal_3kg_ksg_gd ?></td>
        <td><?= $total_penjualan_3ksg_gd + $total_pembelian_3_gd + $total_retur_3ksg_gd + $total_brangkat_3 ?></td>
        <td><?= $total_pembelian_3ksg_gd + $total_penjualan_3_gd ?></td>
        <td><?= $stok_akhir_3kg_ksg_gd ?></td>
    </tr>
    <tr>
        <td>Elpiji 3 Kg Retur</td>
        <td><?= $stok_awal_3_rt_gd ?></td>
        <td><?=  $total_brangkat_3_rtr ?></td>
        <td><?= $total_retur_3_gd + $total_retur_3ksg_gd ?></td>
        <td><?= $stok_akhir_3kg_rt_gd ?></td>
    </tr>
    <tr>
        <td>Elpiji 12 Kg baja + Isi</td>
        <td><?= $stok_awal_12kg_isi_gd ?></td>
        <td><?= $total_penjualan_12_gd  + $total_retur_12_gd ?></td>
        <td><?= $total_pembelian_12_gd  + $total_brangkat_12 + $total_brangkat_12_rtr ?></td>
        <td><?= $stok_akhir_12kg_isi_gd ?></td>
    </tr>
    <tr>
        <td>Elpiji 12 Kg Kosong</td>
        <td><?= $stok_awal_12kg_ksg_gd ?></td>
        <td><?= $total_penjualan_12ksg_gd + $total_pembelian_12_gd + $total_retur_12ksg_gd + $total_brangkat_12 ?></td>
        <td><?= $total_pembelian_12ksg_gd + $total_penjualan_12_gd  ?></td>
        <td><?= $stok_akhir_12kg_ksg_gd ?></td>
    </tr>
    <tr>
        <td>Elpiji 12 Kg Retur</td>
        <td><?= $stok_awal_12_rt_gd ?></td>
        <td><?= $total_brangkat_12_rtr ?></td>
        <td><?= $total_retur_12_gd + $total_retur_12ksg_gd ?></td>
        <td><?= $stok_akhir_12_rt_gd ?></td>
    </tr>
    <tr>
        <td>Bright Gas 5,5 Kg baja + Isi</td>
        <td><?= $stok_awal_b05_isi_gd ?></td>
        <td><?= $total_penjualan_b05_gd + $total_retur_b05_gd ?></td>
        <td><?= $total_pembelian_b05_gd + $total_brangkat_b05 + $total_brangkat_b05_rtr ?></td>
        <td><?= $stok_akhir_b05_isi_gd ?></td>
    </tr>
    <tr>
        <td>Bright Gas 5,5 Kg Kosong</td>
        <td><?= $stok_awal_b05_ksg_gd ?></td>
        <td><?= $total_penjualan_b05ksg_gd + $total_pembelian_b05_gd + $total_retur_b05ksg_gd + $total_brangkat_b05 ?></td>
        <td><?= $total_pembelian_b05ksg_gd + $total_penjualan_b05_gd  ?></td>
        <td><?= $stok_akhir_b05_ksg_gd ?></td>
    </tr>
    <tr>
        <td>Bright Gas 5,5 Kg Retur</td>
        <td><?= $stok_awal_b05_rt_gd ?></td>
        <td><?=  $total_brangkat_b05_rtr ?></td>
        <td><?= $total_retur_b05_gd + $total_retur_b05ksg_gd  ?></td>
        <td><?= $stok_akhir_b05_rt_gd ?></td>
    </tr>
    <tr>
        <td>Bright Gas 12 Kg baja + Isi</td>
        <td><?= $stok_awal_b12_isi_gd ?></td>
        <td><?= $total_penjualan_b12_gd  + $total_retur_b12_gd  ?></td>
        <td><?= $total_pembelian_b12_gd  + $total_brangkat_b12 + $total_brangkat_b12_rtr ?></td>
        <td><?= $stok_akhir_b12_isi_gd ?></td>
    </tr>
    <tr>
        <td>Bright Gas 12 Kg Kosong</td>
        <td><?= $stok_awal_b12_ksg_gd ?></td>
        <td><?= $total_penjualan_b12ksg_gd + $total_pembelian_b12_gd + $total_retur_b12ksg_gd + $total_brangkat_b12 ?></td>
        <td><?= $total_pembelian_b12ksg_gd + $total_penjualan_b12_gd  ?></td>
        <td><?= $stok_akhir_b12_ksg_gd ?></td>
    </tr>
    <tr>
        <td>Bright Gas 12 Kg Retur</td>
        <td><?= $stok_awal_b12_rt_gd ?></td>
        <td><?=  + $total_brangkat_b12_rtr ?></td>
        <td><?= $total_retur_b12_gd + $total_retur_b12ksg_gd  ?></td>
        <td><?= $stok_akhir_b12_rt_gd ?></td>
    </tr>
</tbody>
</table>
</div>

<br>
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
</div>
<br>
<br>
</div>
<br>

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