<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
    exit;
}
$id = $_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account WHERE id_karyawan = '$id'");
$data1 = mysqli_fetch_array($result1);
$id1 = $data1['id_karyawan'];
$foto_profile = $data1['foto_profile'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Kasir Semen') {
} else {
    header("Location: logout.php");
    exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];



if (isset($_GET['tanggal1'])) {
    $tanggal_awal = $_GET['tanggal1'];
    $tanggal_akhir = $_GET['tanggal2'];
    $bulan_sebelum = date('Y-m-d', strtotime('-3 day', strtotime($tanggal_awal)));
    $bulan_sesudah =  date('Y-m-d', strtotime('+1 day', strtotime($tanggal_akhir)));
} elseif (isset($_POST['tanggal1'])) {
    $tanggal_awal = $_POST['tanggal1'];
    $tanggal_akhir = $_POST['tanggal2'];
    $bulan_sebelum = date('Y-m-d', strtotime('-3 day', strtotime($tanggal_awal)));
    $bulan_sesudah =  date('Y-m-d', strtotime('+1 day', strtotime($tanggal_akhir)));
} else {
    $tanggal_awal = date('Y-m-1');
    $tanggal_akhir = date('Y-m-31');

    $bulan_sebelum = date('Y-m-d', strtotime('-3 day', strtotime($tanggal_awal)));
    $bulan_sesudah =  date('Y-m-d', strtotime('+1 day', strtotime($tanggal_akhir)));
}

if ($tanggal_awal == $tanggal_akhir) {
    $table = mysqli_query($koneksi, "SELECT * FROM penjualan_s WHERE tanggal_do = '$tanggal_akhir' ORDER BY no_penjualan ASC");
} else {

    $table = mysqli_query($koneksi, "SELECT * FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'Pranko'  ");

    //Untung angkutan / pranko
    $table1 = mysqli_query($koneksi, "SELECT no_polisi, kota, qty, tujuan FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'Pranko'  ");
    $total_angkutan_edy = 0;
    $total_angkutan_edy_okut = 0;
    $total_angkutan_edy_okus = 0;
    $total_angkutan_edy_md_kota = 0;
    $total_angkutan_edy_mesuji = 0;
    $total_angkutan_edy_tlg_bwg = 0;
    $total_angkutan_edy_way_kanan = 0;
    $total_angkutan_rama = 0;
    $total_angkutan_rama_okut = 0;
    $total_angkutan_rama_okus = 0;
    $total_angkutan_rama_md_kota = 0;
    $total_angkutan_rama_mesuji = 0;
    $total_angkutan_rama_tlg_bwg = 0;
    $total_angkutan_rama_way_kanan = 0;
    $total_map = 0;
    $total_angkutan_map_okut = 0;
    $total_angkutan_map_okus = 0;
    $total_angkutan_map_md_kota = 0;
    $total_angkutan_map_mesuji = 0;
    $total_angkutan_map_tlg_bwg = 0;
    $total_angkutan_map_way_kanan = 0;
    $total_eki_bangunan = 0;
    $total_angkutan_eki_okut = 0;
    $total_angkutan_eki_okus = 0;
    $total_angkutan_eki_md_kota = 0;
    $total_angkutan_eki_mesuji = 0;
    $total_angkutan_eki_tlg_bwg = 0;
    $total_angkutan_eki_way_kanan = 0;
    while ($data1 = mysqli_fetch_array($table1)) {


        $kota = $data1['kota'];
        $qty = $data1['qty'];
        $tujuan = $data1['tujuan'];

        //kak nyoman
        if ($kota == 'Kab Ogn Kmrg Ulu Tim' || $kota == 'KAB OKU TIMUR') {
            //BMU 10ton
            if ($qty >= 200 && $qty <= 300) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif = $data3p['tarif_600'];
                $total_angkut_bmu = $qty * $tarif;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_angkutan_edy = $total_angkutan_edy + $total_angkut_bmu;
                $total_angkutan_edy_okut = $total_angkutan_edy_okut + $total_angkut_bmu;
            } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_angkutan_rama = $total_angkutan_rama + $total_angkut_bmu;
                $total_angkutan_rama_okut = $total_angkutan_rama_okut + $total_angkut_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_map = $total_map + $total_angkut_bmu;
                $total_angkutan_map_okut = $total_angkutan_map_okut + $total_angkut_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_eki_bangunan = $total_eki_bangunan + $total_angkut_bmu;
                $total_angkutan_eki_okut = $total_angkutan_eki_okut + $total_angkut_bmu;
            }
        } else if ($kota == 'Kab Mesuji' || $kota == 'KAB MESUJI') {

            //BMU 20ton
            if ($qty >= 200 && $qty <= 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif = $data3p['tarif_600'];
                $total_angkut_bmu = $qty * $tarif;
            }




            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            }
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }


            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_angkutan_edy = $total_angkutan_edy + $total_angkut_bmu;
                $total_angkutan_edy_mesuji = $total_angkutan_edy_mesuji + $total_angkut_bmu;
            } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_angkutan_rama = $total_angkutan_rama + $total_angkut_bmu;
                $total_angkutan_rama_mesuji = $total_angkutan_rama_mesuji + $total_angkut_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_map = $total_map + $total_angkut_bmu;
                $total_angkutan_map_mesuji = $total_angkutan_map_mesuji + $total_angkut_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_eki_bangunan = $total_eki_bangunan + $total_angkut_bmu;
                $total_angkutan_eki_mesuji = $total_angkutan_eki_mesuji + $total_angkut_bmu;
            }
        } else if ($kota == 'Kab Tlg Bwg' || $kota == 'KAB. TULANG BAWANG') {
            //BMU 10ton
            if ($qty >= 200 && $qty <= 300) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif = $data3p['tarif_600'];
                $total_angkut_bmu = $qty * $tarif;
            }

            $total_angkut_bmu = $qty * $tarif;
            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_angkutan_edy = $total_angkutan_edy + $total_angkut_bmu;
                $total_angkutan_edy_tlg_bwg = $total_angkutan_edy_tlg_bwg + $total_angkut_bmu;
            } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_angkutan_rama = $total_angkutan_rama + $total_angkut_bmu;
                $total_angkutan_rama_tlg_bwg = $total_angkutan_rama_tlg_bwg + $total_angkut_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_map = $total_map + $total_angkut_bmu;
                $total_angkutan_map_tlg_bwg = $total_angkutan_map_tlg_bwg + $total_angkut_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_eki_bangunan = $total_eki_bangunan + $total_angkut_bmu;
                $total_angkutan_eki_tlg_bwg = $total_angkutan_eki_tlg_bwg + $total_angkut_bmu;
            }
        } else if ($kota == 'KAB WAY KANAN') {
            //BMU 10ton
            if ($qty >= 200 && $qty <= 300) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif = $data3p['tarif_600'];
                $total_angkut_bmu = $qty * $tarif;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_angkutan_edy = $total_angkutan_edy + $total_angkut_bmu;
                $total_angkutan_edy_way_kanan = $total_angkutan_edy_way_kanan + $total_angkut_bmu;
            } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_angkutan_rama = $total_angkutan_rama + $total_angkut_bmu;
                $total_angkutan_rama_way_kanan = $total_angkutan_rama_way_kanan + $total_angkut_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_map = $total_map + $total_angkut_bmu;
                $total_angkutan_map_way_kanan = $total_angkutan_map_way_kanan + $total_angkut_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_eki_bangunan = $total_eki_bangunan + $total_angkut_bmu;
                $total_angkutan_eki_way_kanan = $total_angkutan_eki_way_kanan + $total_angkut_bmu;
            }
        } else if ($kota == 'Kab OKU Selatan' || $kota == 'KAB OKU SELATAN' || $kota == 'Kab Ogn Kmrg Ulu Sel') {
            if (
                $tujuan == 'TK BESI 88' || $tujuan == 'TB BERKAH' || $tujuan == 'EKA JAYA' || $tujuan == 'ANUGRAH' ||
                $tujuan == 'TB MANDIRI JAYA' || $tujuan == 'ANEKA JAYA' || $tujuan == 'ANEKA BAUT' || $tujuan == 'SUMBER ANUGRAH' || $tujuan == 'RIZKY' || $tujuan == 'PUTRA LIWA'
            ) {

                //BMU 10ton
                if ($qty >= 200 && $qty <= 300) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif = $data3p['tarif_200'];
                    $total_angkut_bmu = $qty * $tarif;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif = $data3p['tarif_400'];
                    $total_angkut_bmu = $qty * $tarif;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif = $data3p['tarif_600'];
                    $total_angkut_bmu = $qty * $tarif;
                }
            } else {

                //BMU 10ton
                if ($qty >= 200 && $qty <= 300) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif = $data3p['tarif_200'];
                    $total_angkut_bmu = $qty * $tarif;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif = $data3p['tarif_400'];
                    $total_angkut_bmu = $qty * $tarif;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif = $data3p['tarif_600'];
                    $total_angkut_bmu = $qty * $tarif;
                }
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if (
                $tujuan == 'TK BESI 88' || $tujuan == 'TB BERKAH' || $tujuan == 'EKA JAYA' || $tujuan == 'ANUGRAH' ||
                $tujuan == 'TB MANDIRI JAYA' || $tujuan == 'ANEKA JAYA' || $tujuan == 'ANEKA BAUT' || $tujuan == 'SUMBER ANUGRAH' || $tujuan == 'RIZKY' || $tujuan == 'PUTRA LIWA'
            ) {

                if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                    $total_angkutan_edy = $total_angkutan_edy + $total_angkut_bmu;
                    $total_angkutan_edy_md_kota = $total_angkutan_edy_md_kota + $total_angkut_bmu;
                } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                    $total_angkutan_rama = $total_angkutan_rama + $total_angkut_bmu;
                    $total_angkutan_rama_md_kota = $total_angkutan_rama_md_kota + $total_angkut_bmu;
                } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                    $total_map = $total_map + $total_angkut_bmu;
                    $total_angkutan_map_md_kota = $total_angkutan_map_md_kota + $total_angkut_bmu;
                } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                    $total_eki_bangunan = $total_eki_bangunan + $total_angkut_bmu;
                    $total_angkutan_eki_md_kota = $total_angkutan_eki_md_kota + $total_angkut_bmu;
                }
            } else {

                if ($pemilik == 'Bapak Nyoman Edi') {
                    $total_angkutan_edy = $total_angkutan_edy + $total_angkut_bmu;
                    $total_angkutan_edy_okus = $total_angkutan_edy_okus + $total_angkut_bmu;
                } else if ($pemilik == 'Bapak Rama') {
                    $total_angkutan_rama = $total_angkutan_rama + $total_angkut_bmu;
                    $total_angkutan_rama_okus = $total_angkutan_rama_okus + $total_angkut_bmu;
                } else if ($pemilik == 'MAP') {
                    $total_map = $total_map + $total_angkut_bmu;
                    $total_angkutan_map_okus = $total_angkutan_map_okus + $total_angkut_bmu;
                } else if ($pemilik == 'Eki Bangunan') {
                    $total_eki_bangunan = $total_eki_bangunan + $total_angkut_bmu;
                    $total_angkutan_eki_okus = $total_angkutan_eki_okus + $total_angkut_bmu;
                }
            }
        }
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

    <title>Rincian BMU</title>

    <!-- Custom fonts for this template-->
    <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="../DsKasirSemen">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="margin-top: 50px; height: 100px; width: 110px; " src="../gambar/Logo PBJ.PNG" ></div>
</a>
<br>

<br>
<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active" >
    <a class="nav-link" href="../DsKasirSemen">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         KASIR SEMEN
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Kasir</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Kasir</h6>
            <a class="collapse-item" style="font-size: 15px;" href="../VPenjualan">Penjualan Semen</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VPiutang">Piutang Semen</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VPengiriman">Pengiriman</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VLKeuangan">Laporan Keuangan</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VRekapDoPenjualan">Rekap Do Penjualan</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VRitDriver">Laporan Rit</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VFilePBJ">File PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VRekapTagihan">Rekap Tagihan</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VRekapPiutang">Rekap Piutang</a>
        </div>
    </div>
</li>
<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
      15  aria-expanded="true" aria-controls="collapseTwo1">
        <i class="fas fa-truck-moving" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Menu SDM</span>
    </a>
    <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">SDM</h6>
            <a class="collapse-item" style="font-size: 15px;" href="../VKendaraan">Kendaraan</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VDriverSemen">List Driver</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VTokoDO">List Toko DO</a>
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

                <!-- Top content -->
                <div>


                    <!-- Name Page -->
                    <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">

                        <div align="left">
                            <?php echo "<a href='../VRekapTagihan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><button type='button' class='btn btn-primary'>Kembali</button></a>"; ?>
                        </div>


                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
                            </div>
                        </div>

                        <br>
                        <hr>
                        <br>

                        <br>

                        <h5 align='center'>Rekap Pranko BMU Eki Bangunan</h5>
                        <!-- Tabel -->
                        <div align='center' style="overflow-x: auto">
                            <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>NO DO</th>
                                        <th>Tujuan</th>
                                        <th>Tipe</th>
                                        <th>Kota</th>
                                        <th>Material</th>
                                        <th>QTY</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th>Driver</th>
                                        <th>No Polisi</th>
                                        <th>Ket</th>
                                        <th>File</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $no_urut = 0;
                                    $total_pembelian = 0;
                                    $total = 0;
                                    function formatuang($angka)
                                    {
                                        $uang = "Rp " . number_format($angka, 2, ',', '.');
                                        return $uang;
                                    }


                                    ?>

                                    <?php while ($data = mysqli_fetch_array($table)) {

                                        $kota = $data['kota'];
                                        $qty = $data['qty'];
                                        $no_polisi = trim($data["no_polisi"]);
                                        $no_polisi_ts = str_replace(" ", "", $no_polisi);
                                        $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
                                        $data2p = mysqli_fetch_array($table2p);
                                        if (isset($data2p['status_kendaraan'])) {
                                            $pemilik = $data2p['status_kendaraan'];
                                            $kontrak = $data2p['kontrak'];
                                        } else {
                                            $pemilik = "";
                                            $kontrak  = "";
                                        }



                                        $no_pembelian = $data['no_pembelian'];
                                        $tanggal = $data['tanggal'];
                                        $tipe_semen = $data['tipe_semen'];
                                        $tujuan = $data['tujuan'];
                                        $kota = $data['kota'];
                                        $no_do = $data['no_do'];
                                        $material = $data['material'];
                                        $qty = $data['qty'];
                                        $harga = $data['harga'];
                                        $jumlah = $data['jumlah'];
                                        $driver = $data['driver'];
                                        $no_polisi = $data['no_polisi'];
                                        $tipe_bayar = $data['tipe_bayar'];
                                        $tempo = $data['tempo'];
                                        $keterangan = $data['keterangan'];
                                        $file_bukti = $data['file_bukti'];

                                        $no_urut = $no_urut + 1;

                                          //kak nyoman
                                          if ($kota == 'Kab Ogn Kmrg Ulu Tim' || $kota == 'KAB OKU TIMUR') {
                                            //BMU 10ton
                                            if ($qty >= 200 && $qty <= 300) {
                                
                                                $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                                                $data3p = mysqli_fetch_array($table3p);
                                                $tarifx = $data3p['tarif_200'];
                                      
                                            }
                                            //BMU 20ton
                                            else if ($qty > 300 && $qty <= 500) {
                                
                                                $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                                                $data3p = mysqli_fetch_array($table3p);
                                                $tarifx = $data3p['tarif_400'];
                                       
                                            }
                                            //BMU 30ton
                                            else if ($qty > 500) {
                                
                                                $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                                                $data3p = mysqli_fetch_array($table3p);
                                                $tarifx = $data3p['tarif_600'];
                                   
                                            }
                                        } else if ($kota == 'Kab Mesuji' || $kota == 'KAB MESUJI') {
                                
                                            //BMU 20ton
                                            if ($qty >= 200 && $qty <= 500) {
                                
                                                $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                                                $data3p = mysqli_fetch_array($table3p);
                                                $tarifx = $data3p['tarif_400'];
                                  
                                            }
                                            //BMU 30ton
                                            else if ($qty > 500) {
                                
                                                $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                                                $data3p = mysqli_fetch_array($table3p);
                                                $tarifx = $data3p['tarif_600'];
                                       
                                            }
                                        } else if ($kota == 'Kab Tlg Bwg' || $kota == 'KAB. TULANG BAWANG') {
                                            //BMU 10ton
                                            if ($qty >= 200 && $qty <= 300) {
                                
                                                $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                                                $data3p = mysqli_fetch_array($table3p);
                                                $tarifx = $data3p['tarif_200'];
                                
                                            }
                                            //BMU 20ton
                                            else if ($qty > 300 && $qty <= 500) {
                                
                                                $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                                                $data3p = mysqli_fetch_array($table3p);
                                                $tarifx = $data3p['tarif_400'];
                                            
                                            }
                                            //BMU 30ton
                                            else if ($qty > 500) {
                                
                                                $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                                                $data3p = mysqli_fetch_array($table3p);
                                                $tarifx = $data3p['tarif_600'];
                                          
                                            }
                                        } else if ($kota == 'KAB WAY KANAN') {
                                            //BMU 10ton
                                            if ($qty >= 200 && $qty <= 300) {
                                
                                                $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                                                $data3p = mysqli_fetch_array($table3p);
                                                $tarifx = $data3p['tarif_200'];
                                           
                                            }
                                            //BMU 20ton
                                            else if ($qty > 300 && $qty <= 500) {
                                
                                                $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                                                $data3p = mysqli_fetch_array($table3p);
                                                $tarifx = $data3p['tarif_400'];
                                              
                                            }
                                            //BMU 30ton
                                            else if ($qty > 500) {
                                
                                                $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                                                $data3p = mysqli_fetch_array($table3p);
                                                $tarifx = $data3p['tarif_600'];
                                          
                                            }
                                
                                        } else if ($kota == 'Kab OKU Selatan' || $kota == 'KAB OKU SELATAN' || $kota == 'Kab Ogn Kmrg Ulu Sel') {
                                            if (
                                                $tujuan == 'TK BESI 88' || $tujuan == 'TB BERKAH' || $tujuan == 'EKA JAYA' || $tujuan == 'ANUGRAH' ||
                                                $tujuan == 'TB MANDIRI JAYA' || $tujuan == 'ANEKA JAYA' || $tujuan == 'ANEKA BAUT' || $tujuan == 'SUMBER ANUGRAH' || $tujuan == 'RIZKY' || $tujuan == 'PUTRA LIWA'
                                            ) {
                                
                                                //BMU 10ton
                                                if ($qty >= 200 && $qty <= 300) {
                                
                                                    $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                                                    $data3p = mysqli_fetch_array($table3p);
                                                    $tarifx = $data3p['tarif_200'];
                                                 
                                                }
                                                //BMU 20ton
                                                else if ($qty > 300 && $qty <= 500) {
                                
                                                    $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                                                    $data3p = mysqli_fetch_array($table3p);
                                                    $tarifx = $data3p['tarif_400'];
                                
                                                }
                                                //BMU 30ton
                                                else if ($qty > 500) {
                                
                                                    $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                                                    $data3p = mysqli_fetch_array($table3p);
                                                    $tarifx = $data3p['tarif_600'];
                                           
                                                }
                                            } else {
                                
                                                //BMU 10ton
                                                if ($qty >= 200 && $qty <= 300) {
                                
                                                    $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                                                    $data3p = mysqli_fetch_array($table3p);
                                                    $tarifx = $data3p['tarif_200'];
                                                
                                                }
                                                //BMU 20ton
                                                else if ($qty > 300 && $qty <= 500) {
                                
                                                    $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                                                    $data3p = mysqli_fetch_array($table3p);
                                                    $tarifx = $data3p['tarif_400'];
                                               
                                                }
                                                //BMU 30ton
                                                else if ($qty > 500) {
                                
                                                    $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                                                    $data3p = mysqli_fetch_array($table3p);
                                                    $tarifx = $data3p['tarif_600'];
                                                  
                                                }
                                            }
                            
                                        }


                                        if ($pemilik == "Eki Bangunan" && $kontrak == 'BMU') {
                                            $jumlah = $qty * $tarifx;
                                            $total = $total + $jumlah;

                                                                                    echo "<tr>
                                            <td style='font-size: 14px'>$no_urut</td>
                                            <td style='font-size: 14px'>$tanggal</td>
                                            <td style='font-size: 14px'>$no_do</td>
                                            <td style='font-size: 14px'>$tujuan</td>
                                            <td style='font-size: 14px'>$tipe_semen</td>
                                            <td style='font-size: 14px'>$kota</td>
                                            <td style='font-size: 14px'>$material</td>
                                            <td style='font-size: 14px'>$qty</td>
                                            <td style='font-size: 14px'>"; ?> <?= formatuang($tarifx); ?> <?php echo "</td>
                                            <td style='font-size: 14px'>" ?> <?= formatuang($jumlah); ?> <?php echo "</td>
                                            <td style='font-size: 14px'>" ?> <?= formatuang($total); ?> <?php echo "</td>
                                            <td style='font-size: 14px'>$driver</td>
                                            <td style='font-size: 14px'>$no_polisi</td>
                                            <td style='font-size: 14px'>$keterangan</td>
                                            <td style='font-size: 14px'>"; ?> <a download="/CV.PBJ/AdminSemen/file_admin_semen/<?= $file_bukti ?>" href="/CV.PBJ/AdminSemen/file_admin_semen/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
                                            "; ?>




                                        <?php echo  " </tr>";
                                        }
                                    }
                                        ?>

                                </tbody>
                            </table>
                        </div>
                        <br>
                        <hr>
                        <br>

                        <br>

                        <br>
                        <hr>
                        <br>

                        <div class="row" style="margin-right: 20px; margin-left: 20px;">
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Total Tagihan OKU Timur</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_angkutan_eki_okut) ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Total Tagihan OKU Selatan</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_angkutan_eki_okus) ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Total Tagihan Muara Dua Kota</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_angkutan_eki_md_kota) ?></div>
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
                        <hr>
                        <br>


                        <div class="row" style="margin-right: 20px; margin-left: 20px;">
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Total Tagihan Tulang Bawang</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_angkutan_eki_tlg_bwg) ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Total Tagihan Way Kanan</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_angkutan_eki_way_kanan) ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Total Tagihan Mesuji</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_angkutan_eki_mesuji) ?></div>
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
                        <hr>
                        <br>
                        <div class="row" style="margin-right: 20px; margin-left: 20px;">
                            <div class="col-xl-12 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Total Tagihan BMU Global</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_eki_bangunan) ?></div>
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
            var table = $('#example').DataTable({
                lengthChange: true,
                buttons: ['excel']
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
        });
    </script>

    <script>
        function createOptions(number) {
            var options = [],
                _options;

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

        $('#special').on('click', function() {
            mySelect.find('option:selected').prop('disabled', true);
            mySelect.selectpicker('refresh');
        });

        $('#special2').on('click', function() {
            mySelect.find('option:disabled').prop('disabled', false);
            mySelect.selectpicker('refresh');
        });

        $('#basic2').selectpicker({
            liveSearch: true,
            maxOptions: 1
        });
    </script>

    <script>
        function sum() {
            var banyak_barang = document.getElementById('qty').value;
            var harga = document.getElementById('harga').value;
            var result = parseInt(banyak_barang) * parseInt(harga);
            if (!isNaN(result)) {
                document.getElementById('jumlah').value = result;
            }
        }
    </script>


</body>

</html>