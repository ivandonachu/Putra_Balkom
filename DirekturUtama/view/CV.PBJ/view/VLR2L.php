<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
    exit;
}
$id = $_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksicbm, "SELECT * FROM super_account WHERE username = '$id'");
$data1 = mysqli_fetch_array($result1);
$nama = $data1['nama_pemilik'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Direktur Utama') {
} else {
    header("Location: logout.php");
    exit;
}



if (isset($_GET['tanggal1'])) {
    $tanggal_awal = $_GET['tanggal1'];
    $tanggal_akhir = $_GET['tanggal2'];
} elseif (isset($_POST['tanggal1'])) {
    $tanggal_awal = $_POST['tanggal1'];
    $tanggal_akhir = $_POST['tanggal2'];
} else {
    $tanggal_awal = date('Y-m-1');
    $tanggal_akhir = date('Y-m-31');
}

function formatuang($angka)
{
    $uang = "Rp " . number_format($angka, 2, ',', '.');
    return $uang;
}

if ($tanggal_awal == $tanggal_akhir) {
    // Tagihan
    $table = mysqli_query($koneksipbj, "SELECT muatan , harga_tagihan FROM riwayat_pengiriman WHERE tanggal_keluar = '$tanggal_awal'");

    $total_tagihan = 0;
    while ($data = mysqli_fetch_array($table)) {
        $muatan = $data['muatan'];
        $harga_tagihan = $data['harga_tagihan'];

        $total_tagihan = $total_tagihan + ($muatan * $harga_tagihan);
    }
    //pengiriman
    $table2 = mysqli_query($koneksipbj, "SELECT SUM(uj_tagihan) AS total_uj, SUM(gaji_tagihan) AS total_gaji FROM riwayat_pengiriman WHERE tanggal = '$tanggal_awal'");
    $data2 = mysqli_fetch_array($table2);
    $total_uj = $data2['total_uj'];
    $total_gaji = $data2['total_gaji'];


    //pengeluran Pul Biaya Kantor
    $table3 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM riwayat_oprasional a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal = '$tanggal_awal' AND a.kode_akun = '5-540' ");
    $data3 = mysqli_fetch_array($table3);
    $jml_biaya_kantor = $data3['jumlah_biaya_kantor'];
    if (!isset($data3['jumlah_biaya_kantor'])) {
        $jml_biaya_kantor = 0;
    }

    //pengeluran Pul Listrik & Telepon
    $table4 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_listrik FROM riwayat_oprasional a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal = '$tanggal_awal' AND a.kode_akun = '5-550' ");
    $data4 = mysqli_fetch_array($table4);
    $jml_listrik = $data4['jumlah_listrik'];
    if (!isset($data4['jumlah_listrikr'])) {
        $jml_listrik = 0;
    }

    //pengeluran Biaya Sewa
    $table5 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_sewa FROM riwayat_oprasional a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal = '$tanggal_awal' AND a.kode_akun = '5-570' ");
    $data5 = mysqli_fetch_array($table5);
    $jml_sewa = $data5['jumlah_sewa'];
    if (!isset($data5['jumlah_sewa'])) {
        $jml_sewa = 0;
    }

    //pengeluran Alat Tulis Kantor
    $table6 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_atk FROM riwayat_oprasional a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal = '$tanggal_awal' AND a.kode_akun = '5-520' ");
    $data6 = mysqli_fetch_array($table6);
    $jml_atk = $data6['jumlah_atk'];
    if (!isset($data6['jumlah_atk'])) {
        $jml_atk = 0;
    }

    //pengeluran perbaikan
    $table7 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS total_pembelian_sparepart FROM riwayat_oprasional a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal = '$tanggal_awal' AND a.kode_akun = '5-595' ");
    $data7 = mysqli_fetch_array($table7);
    $jml_pembelian = $data7['total_pembelian_sparepart'];
    if (!isset($data7['total_pembelian_sparepart'])) {
        $jml_pembelian = 0;
    }

    $table8 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_perbaikan FROM riwayat_oprasional a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal = '$tanggal_awal' AND a.kode_akun = '5-596' ");
    $data8 = mysqli_fetch_array($table8);
    $jml_perbaikan = $data8['jumlah_perbaikan'];
    if (!isset($data8['jumlah_perbaikan'])) {
        $jml_perbaikan = 0;
    }
} else {

    // Penjualan kadek dan etty
    $table = mysqli_query($koneksipbj, "SELECT no_do FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $pendapatan_penjualan_kadek =0;
    //kadek
    while($data = mysqli_fetch_array($table)){
        $no_do_pembelian = $data['no_do'];
        $tablex = mysqli_query($koneksipbj, "SELECT jumlah FROM penjualan_sl WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_do = '$no_do_pembelian' AND status_bayar != 'Bon' ");

        if(mysqli_num_rows($tablex) === 1 ){
            $datax = mysqli_fetch_array($tablex);
               $jumlah = $datax['jumlah'];
               $pendapatan_penjualan_kadek = $pendapatan_penjualan_kadek + $jumlah;
              }
       
    }
    
    //ety
    $tablee = mysqli_query($koneksipbj, "SELECT no_do FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $pendapatan_penjualan_ety = 0;
    while($datae = mysqli_fetch_array($tablee)){
        $no_do_pembelian = $datae['no_do'];
        $tablex2 = mysqli_query($koneksipbj, "SELECT jumlah FROM penjualan_s WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_do = '$no_do_pembelian' AND status_bayar  != 'Bon' ");

        if(mysqli_num_rows($tablex2) === 1 ){
            $datax2 = mysqli_fetch_array($tablex2);
            $jumlahx = $datax2['jumlah'];
            $pendapatan_penjualan_ety = $pendapatan_penjualan_ety + $jumlahx;
              }
       
    }

        
    



    //Untung angkutan / pranko
    $table1 = mysqli_query($koneksipbj, "SELECT no_polisi, kota, qty FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'Pranko' ");
    $total_angkutan_edy = 0;
    $total_angkutan_rama = 0;
    $total_angkutan_aril = 0;
    $total_angkutan_reni = 0;
    while($data1 = mysqli_fetch_array($table1)){
        $no_polisi = trim($data1["no_polisi"]);
        $no_polisi_ts = str_replace(" ", "" , $no_polisi);
        $kota = $data1['kota'];
        $qty = $data1['qty'];
        
        //kak nyoman
        if($kota == 'Kab Ogn Kmrg Ulu Tim'){
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut = $qty * $tarif;
            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if(isset($data2p['status_kendaraan'])){
                $pemilik = $data2p['status_kendaraan'];
            }
            
            
            if($pemilik == 'Bapak Nyoman Edi' ){
                $total_angkutan_edy = $total_angkutan_edy + $total_angkut;
            }
            else if($pemilik == 'Bapak Rama'){
                $total_angkutan_rama = $total_angkutan_rama + $total_angkut;
            }
            else if($pemilik == 'Bapak Aril'){
                $total_angkutan_aril = $total_angkutan_aril + $total_angkut;
            }
            else if($pemilik == 'Mbak Reni'){
                $total_angkutan_reni = $total_angkutan_reni + $total_angkut;
            }
          
        }
        else if ($kota == 'Mesuji'){
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut = $qty * $tarif;
            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if(isset($data2p['status_kendaraan'])){
                $pemilik = $data2p['status_kendaraan'];
            }
            
            if($pemilik == 'Bapak Nyoman Edi' ){
                $total_angkutan_edy = $total_angkutan_edy + $total_angkut;
            }
        }
        else if ($kota == 'Kab Tlg Bwg'){
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut = $qty * $tarif;
            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if(isset($data2p['status_kendaraan'])){
                $pemilik = $data2p['status_kendaraan'];
            }

            if($pemilik == 'Bapak Nyoman Edi' ){
                $total_angkutan_edy = $total_angkutan_edy + $total_angkut;
            }
        }
        else if ($kota == 'Kab Tlg Bwg Barat'){
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut = $qty * $tarif;
            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if(isset($data2p['status_kendaraan'])){
                $pemilik = $data2p['status_kendaraan'];
            }
            
            if($pemilik == 'Bapak Nyoman Edi' ){
                $total_angkutan_edy = $total_angkutan_edy + $total_angkut;
            }
        }

    }

    // pembelian kadek dan etty

    $table = mysqli_query($koneksipbj, "SELECT no_do FROM penjualan_sl WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $pembelian_kadek =0;
    //kadek
    while($data = mysqli_fetch_array($table)){
        $no_do_pembelian = $data['no_do'];
        $tablex = mysqli_query($koneksipbj, "SELECT jumlah FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_do = '$no_do_pembelian' ");
        $datax = mysqli_fetch_array($tablex);
        if(isset($datax['jumlah'])){
            $jumlah = $datax['jumlah'];
            $pembelian_kadek = $pembelian_kadek + $jumlah;
        }

       
    }
    
    //ety
    $tabell = mysqli_query($koneksipbj, "SELECT no_do FROM penjualan_s WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $pembelian_ety = 0;
    while($datae = mysqli_fetch_array($tabell)){
        $no_do_pembelian = $datae['no_do'];
        $tablell2 = mysqli_query($koneksipbj, "SELECT jumlah FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_do = '$no_do_pembelian' ");
        $datax2 = mysqli_fetch_array($tablell2);
        if(isset($datax2['jumlah'])){
            $jumlahx = $datax2['jumlah'];
            $pembelian_ety = $pembelian_ety + $jumlahx;
        }

        
    }

    // piutang kadek dan etty
    $tabler = mysqli_query($koneksipbj, "SELECT no_do FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $piutang_penjualan_kadek =0;
    //kadek
    while($data = mysqli_fetch_array($tabler)){
        $no_do_pembelian = $data['no_do'];
        $tablexr = mysqli_query($koneksipbj, "SELECT jumlah FROM penjualan_sl WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_do = '$no_do_pembelian' AND status_bayar = 'Bon' ");
        $datax = mysqli_fetch_array($tablexr);
        if(isset($datax['jumlah'])){
            $jumlah = $datax['jumlah'];
            $piutang_penjualan_kadek = $piutang_penjualan_kadek + $jumlah;
        }

       
    }
    
    //ety
    $tableer = mysqli_query($koneksipbj, "SELECT no_do FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $piutang_penjualan_ety = 0;
    while($datae = mysqli_fetch_array($tableer)){
        $no_do_pembelian = $datae['no_do'];
        $tablex2r = mysqli_query($koneksipbj, "SELECT jumlah FROM penjualan_s WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_do = '$no_do_pembelian' AND status_bayar  = 'Bon' ");
        $datax2 = mysqli_fetch_array($tablex2r);
        if(isset($datax2['jumlah'])){
            $jumlahx = $datax2['jumlah'];
            $piutang_penjualan_ety = $piutang_penjualan_ety + $jumlahx;
        }

        
    }

    //pengiriman ety
    $table2 = mysqli_query($koneksipbj, "SELECT SUM(uj) AS total_uj, SUM(ug) AS total_gaji, SUM(om) AS total_om FROM pengiriman_s WHERE 
                                        tanggal_antar  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data2 = mysqli_fetch_array($table2);
    $total_uj = $data2['total_uj'];
    $total_gaji = $data2['total_gaji'];
    $total_om = $data2['total_om'];

     //pengiriman kadek
     $table2sl = mysqli_query($koneksipbj, "SELECT SUM(uj) AS total_uj, SUM(ug) AS total_gaji, SUM(om) AS total_om FROM pengiriman_sl WHERE 
     tanggal_antar  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data2sl = mysqli_fetch_array($table2sl);
    $total_uj_sl = $data2['total_uj'];
    $total_gaji_sl = $data2['total_gaji'];
    $total_om_sl = $data2['total_om'];

    //Biaya Kantor etty
    $table3s = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM keuangan_s WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
    $data3s = mysqli_fetch_array($table3s);
    $jml_biaya_kantor_s = $data3s['jumlah_biaya_kantor'];
    if (!isset($data3s['jumlah_biaya_kantor'])) {
        $jml_biaya_kantor_s = 0;
    }
    //Biaya Kantor kadek
    $table3sl = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM keuangan_sl  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
    $data3sl = mysqli_fetch_array($table3sl);
    $jml_biaya_kantor_sl = $data3sl['jumlah_biaya_kantor'];
    if (!isset($data3sl['jumlah_biaya_kantor'])) {
        $jml_biaya_kantor_sl = 0;
    }

    //Listrik & Telepon etty
    $table4s = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_listrik FROM keuangan_s  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon'");
    $data4s = mysqli_fetch_array($table4s);
    $jml_listrik_s = $data4s['jumlah_listrik'];
    if (!isset($data4s['jumlah_listrikr'])) {
        $jml_listrik_s = 0;
    }

    //Listrik & Telepon kadek
    $table4sl = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_listrik FROM keuangan_sl  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon'");
    $data4sl = mysqli_fetch_array($table4sl);
    $jml_listrik_sl = $data4sl['jumlah_listrik'];
    if (!isset($data4sl['jumlah_listrikr'])) {
        $jml_listrik_sl = 0;
    }

    //Trasnport/Perjalan Dinas etty
    $table5s = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_transport FROM keuangan_s  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
    $data5s = mysqli_fetch_array($table5s);
    $jml_transport_s = $data5s['jumlah_transport'];
    if (!isset($data5['jumlah_transport'])) {
        $jml_transport_s = 0;
    }

     //Trasnport/Perjalan Dinas kadek
     $table5sl = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_transport FROM keuangan_sl  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
     $data5sl = mysqli_fetch_array($table5s);
     $jml_transport_sl = $data5s['jumlah_transport'];
     if (!isset($data5['jumlah_transport'])) {
         $jml_transport_sl = 0;
     }

    //Alat Tulis Kantor etty
    $table6s = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_atk FROM keuangan_s  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
    $data6s = mysqli_fetch_array($table6s);
    $jml_atk_s = $data6s['jumlah_atk'];
    if (!isset($data6s['jumlah_atk'])) {
        $jml_atk_s = 0;
    }

    //Alat Tulis Kantor kadek
    $table6sl = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_atk FROM keuangan_sl  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
    $data6sl = mysqli_fetch_array($table6sl);
    $jml_atk_sl = $data6sl['jumlah_atk'];
    if (!isset($data6sl['jumlah_atk'])) {
        $jml_atk_sl = 0;
    }

    //pengeluran perbaikan
    $table7 = mysqli_query($koneksipbj, "SELECT SUM(jumlah_sparepart) AS total_pembelian_sparepart FROM riwayat_pengeluaran_workshop_s
                                         WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data7 = mysqli_fetch_array($table7);
    $jml_pembelian_sparepart = $data7['total_pembelian_sparepart'];
    if (!isset($data7['total_pembelian_sparepart'])) {
        $jml_pembelian_sparepart = 0;
    }


    $table8 = mysqli_query($koneksipbj, "SELECT SUM(jumlah_bengkel) AS jumlah_perbaikan FROM riwayat_pengeluaran_workshop_s
                                         WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data8 = mysqli_fetch_array($table8);
    $jml_perbaikan = $data8['jumlah_perbaikan'];
    if (!isset($data8['jumlah_perbaikan'])) {
        $jml_perbaikan = 0;
    }

    //gaji karaywan
    $table8 = mysqli_query($koneksipbj, "SELECT jumlah  FROM keuangan_s WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Gaji Karyawan' ");
    $data8 = mysqli_fetch_array($table8);
    
    if(isset($data8['jumlah'])){
  
        $gaji_karyawan = $data8['jumlah'];
    }
    if (!isset($data8['jumlah'])) {
        $gaji_karyawan = 0;
    }
}
$total_pendapatan = $pendapatan_penjualan_ety + $pendapatan_penjualan_kadek + $total_angkutan_edy + $total_angkutan_rama + $total_angkutan_aril + $total_angkutan_reni + $piutang_penjualan_ety + $piutang_penjualan_kadek;
$laba_kotor = $total_pendapatan - ($pembelian_ety + $pembelian_kadek);
$total_biaya_usaha_final =  $total_uj + $total_gaji + $total_om +$jml_listrik_s + $jml_transport_s + $jml_atk_s+ $jml_perbaikan + $jml_pembelian_sparepart + 
                            $total_uj_sl + $total_gaji_sl + $total_om_sl +$jml_listrik_sl + $jml_transport_sl + $jml_atk_sl;
$laba_bersih_sebelum_pajak =  $laba_kotor - $total_biaya_usaha_final;

?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laba Rugi CV PBJ</title>

    <!-- Custom fonts for this template-->
    <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsCVPBJ">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3"> <img style="margin-top: 50px;" src="../gambar/Logo PBJ.PNG"></div>
            </a>
            <br>

            <br>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="DsCVPBJ">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 16px;">Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading" style="font-size: 15px; color:white;">
                Menu CV.PBJ
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1" 15 aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">List Perusahaan</span>
                </a>
                <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Perusahaan</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.CBM/view/DsPTCBM">PT.CBM</a>
                        <a class="collapse-item" style="font-size: 15px;" href="DsPBJ">CV.PBJ</a>
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
                    <span style="font-size: 15px; color:white;" >Laporan Etty</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Laporan</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VLR2">Laba Rugi</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Laporan Penjualan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Laporan Pengiriman</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VKeuangan">Laporan Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluran">Laporan Pengeluaran</a>
    
                    </div>
                </div>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3"
                  15  aria-expanded="true" aria-controls="collapseTwo3">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Laporan Kadek</span>
                </a>
                <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Laporan</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VLR2L">Laba Rugi</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenjualanL">Laporan Penjualan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenebusanL">Laporan Penebusan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengirimanL">Laporan Pengiriman</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VKeuanganL">Laporan Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranL">Laporan Pengeluaran</a>
    
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
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
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
                                <span class="mr-2 d-none d-lg-inline  small" style="color:white;"><?php echo "$nama"; ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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
                    <?php echo "<form  method='POST' action='VLR2L' style='margin-bottom: 15px;'>" ?>
                    <div>
                        <div align="left" style="margin-left: 20px;">
                            <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1">
                            <span>-</span>
                            <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
                            <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm">Lihat</button>
                        </div>
                    </div>
                    </form>

                    <br>
                    <br>
                    <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title" align="Center"><strong>Laba Rugi CV PBJ</strong></h3>
                                </div>

                                <div>

                                </div>



                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed" style="color : black;">
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
                                                    <td class="text-left">Penjualan As Kadek</td>
                                                    <td class="text-left"><?= formatuang($pendapatan_penjualan_kadek); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPenjualanKDK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-101</td>
                                                    <td class="text-left">Penjualan As Ety</td>
                                                    <td class="text-left"><?= formatuang($pendapatan_penjualan_ety); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPenjualanETY?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-100</td>
                                                    <td class="text-left">Piutang Penjualan As Kadek</td>
                                                    <td class="text-left"><?= formatuang($piutang_penjualan_kadek); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPiutangKDK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-101</td>
                                                    <td class="text-left">Piutang Penjualan As Ety</td>
                                                    <td class="text-left"><?= formatuang($piutang_penjualan_ety); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPiutangETY?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-102</td>
                                                    <td class="text-left">Pranko Nyoman Edy</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_edy); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPrankoEDY?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-103</td>
                                                    <td class="text-left">Pranko Bli Rama</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_rama); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPrankoRAMA?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-103</td>
                                                    <td class="text-left">Pranko Pak Aril</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_aril); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPrankoARIL?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-103</td>
                                                    <td class="text-left">Pranko Yuk Reni</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_reni); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPrankoRENI?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
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
                                                    <td class="text-left">Pembelian Barang Etty</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($pembelian_ety); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPembelianETY?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-100</td>
                                                    <td class="text-left">Pembelian Barang Kadek</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($pembelian_kadek); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPembelianKDK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr style="background-color:    #F0F8FF;  ">
                                                    <td><strong>Total Harga Pokok Penjualan</strong></td>
                                                    <td class="thick-line"></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($pembelian_ety + $pembelian_kadek); ?></td>
                                                    <td class="thick-line"></td>
                                                </tr>
                                                <tr style="background-color: navy;  color:white;">
                                                    <td><strong>TOTAL LABA KOTOR</strong></td>
                                                    <td class="thick-line"></td>
                                                    <td class="no-line text-left"><?= formatuang($laba_kotor); ?> </td>
                                                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
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
                                                    <td>5-511</td>
                                                    <td class="text-left">Gaji Driver</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_gaji + $total_gaji_sl); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRGaji?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-5111</td>
                                                    <td class="text-left">Gaji Karyawan</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($gaji_karyawan); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRGajiKaryawan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-512</td>
                                                    <td class="text-left">Uang Jalan</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_uj + $total_uj_sl); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRUJ?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-513</td>
                                                    <td class="text-left">Ongkos Mobil</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om + $total_om_sl); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VROM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-540</td>
                                                    <td class="text-left">Biaya Kantor</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($jml_biaya_kantor_s + $jml_biaya_kantor_sl); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRBiayaKantor?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-550</td>
                                                    <td class="text-left">Listrik & Telepon</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($jml_listrik_s + $jml_listrik_sl); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRListrik?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-570</td>
                                                    <td class="text-left">Transport / Perjalanan Dinas</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($jml_transport_s + $jml_transport_sl); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRTransport?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-580</td>
                                                    <td class="text-left">Alat Tulis Kantor</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($jml_atk_s + $jml_atk_sl); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRATK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>

                                                <tr>
                                                    <td>5-595</td>
                                                    <td class="text-left">Biaya Perbaikan Kendaraan</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($jml_perbaikan); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPerbaikan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-596</td>
                                                    <td class="text-left">Pembelian Sparepart</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($jml_pembelian_sparepart); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPembelian?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
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
                                                    <?php } else if ($laba_bersih_sebelum_pajak < 0) { ?>

                                                        <td class="no-line text-left"><?= formatuang(0); ?></td>
                                                        <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak); ?></td>

                                                    <?php } else if ($total_tagihan == 0) { ?>

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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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