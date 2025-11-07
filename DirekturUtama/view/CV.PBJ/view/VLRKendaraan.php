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
$foto_profile = $data1['foto_profile'];
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
} else {

    //kota bumi
    $tabel_kotabumi = mysqli_query($koneksipbj, "SELECT no_polisi, driver, qty FROM pembelian_kota_bumi WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

    $total_angkutan_edy_bmu_kb = 0;
    $total_angkutan_soma_bmu_kb = 0;
    $total_angkutan_rama_bmu_kb = 0;
    $total_angkutan_map_bmu_kb = 0;
    $total_angkutan_berkah_bmu_kb = 0;
    $total_angkutan_eki_bangunan_bmu_kb = 0;
    $total_angkutan_syafuan_bmu_kb = 0;
    $total_angkutan_yanti_bmu_kb = 0;
    $total_angkutan_nengah_bmu_kb = 0;
    $total_angkutan_joko_bmu_kb = 0;
    $total_angkutan_samsul_bmu_kb = 0;
    $total_angkutan_wayan_bmu_kb = 0;
    $total_angkutan_besi88_bmu_kb = 0;
    $total_angkutan_dedi_bmu_kb = 0;
    $total_angkutan_rony_bmu_kb = 0;
    $total_angkutan_azzahra_bmu_kb = 0;
    $total_angkutan_sony_bmu_kb = 0;
    $total_angkutan_ahmad_bmu_kb = 0;
    $total_angkutan_gm_bmu_kb = 0;
    $total_angkutan_samsun_bmu_kb = 0;

    while ($data1 = mysqli_fetch_array($tabel_kotabumi)) {

        $no_polisi_ts = $data1['no_polisi'];
        $qty = $data1['qty'];
        $driver = $data1['driver'];

        if ($qty >= 1 && $qty <= 300) {

            $total_angkut_bmu_kotabumi = $qty * 8149;
        } else if ($qty > 300 && $qty <= 500) {

            $total_angkut_bmu_kotabumi = $qty * 7238;
        } else if ($qty > 500) {

            $total_angkut_bmu_kotabumi = $qty * 7238;
        }

        $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
        $data2p = mysqli_fetch_array($table2p);
        if (isset($data2p['status_kendaraan'])) {
            $pemilik = $data2p['status_kendaraan'];
            $kontrak = $data2p['kontrak'];
        } else {
            $pemilik = '';
            $kontrak = '';
        }



        if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
            $total_angkutan_edy_bmu_kb = $total_angkutan_edy_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
            $total_angkutan_rama_bmu_kb = $total_angkutan_rama_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
            $total_angkutan_map_bmu_kb = $total_angkutan_map_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
            $total_angkutan_eki_bangunan_bmu_kb = $total_angkutan_eki_bangunan_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
            $total_angkutan_soma_bmu_kb = $total_angkutan_soma_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
            $total_angkutan_berkah_bmu_kb = $total_angkutan_berkah_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
            $total_angkutan_syafuan_bmu_kb = $total_angkutan_syafuan_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
            $total_angkutan_yanti_bmu_kb = $total_angkutan_yanti_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
            $total_angkutan_nengah_bmu_kb = $total_angkutan_nengah_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
            $total_angkutan_joko_bmu_kb = $total_angkutan_joko_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
            $total_angkutan_samsul_bmu_kb = $total_angkutan_samsul_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
            $total_angkutan_besi88_bmu_kb = $total_angkutan_besi88_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
            $total_angkutan_wayan_bmu_kb = $total_angkutan_wayan_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
            $total_angkutan_dedi_bmu_kb = $total_angkutan_dedi_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
            $total_angkutan_rony_bmu_kb = $total_angkutan_rony_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
            $total_angkutan_azzahra_bmu_kb = $total_angkutan_azzahra_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
            $total_angkutan_sony_bmu_kb = $total_angkutan_sony_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
            $total_angkutan_ahmad_bmu_kb = $total_angkutan_ahmad_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
            $total_angkutan_gm_bmu_kb = $total_angkutan_gm_bmu_kb + $total_angkut_bmu_kotabumi;
        } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
            $total_angkutan_samsun_bmu_kb = $total_angkutan_samsun_bmu_kb + $total_angkut_bmu_kotabumi;
        }
    }
    $total_tagihan_kotabumi = $total_angkutan_edy_bmu_kb + $total_angkutan_rama_bmu_kb + $total_angkutan_soma_bmu_kb + $total_angkutan_berkah_bmu_kb +  $total_angkutan_map_bmu_kb + $total_angkutan_eki_bangunan_bmu_kb + $total_angkutan_syafuan_bmu_kb
        + $total_angkutan_yanti_bmu_kb + $total_angkutan_nengah_bmu_kb + $total_angkutan_joko_bmu_kb + $total_angkutan_samsul_bmu_kb +  $total_angkutan_wayan_bmu_kb + $total_angkutan_besi88_bmu_kb
        + $total_angkutan_dedi_bmu_kb + $total_angkutan_rony_bmu_kb + $total_angkutan_azzahra_bmu_kb + $total_angkutan_sony_bmu_kb + $total_angkutan_ahmad_bmu_kb + $total_angkutan_gm_bmu_kb + $total_angkutan_samsun_bmu_kb;

    //lamteng
    $tabel_lamteng = mysqli_query($koneksipbj, "SELECT no_polisi, driver, qty FROM pembelian_lamteng WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

    $total_angkutan_edy_bmu_lamteng = 0;
    $total_angkutan_rama_bmu_lamteng = 0;
    $total_angkutan_soma_bmu_lamteng = 0;
    $total_angkutan_berkah_bmu_lamteng = 0;
    $total_angkutan_map_bmu_lamteng = 0;
    $total_angkutan_eki_bangunan_bmu_lamteng = 0;
    $total_angkutan_syafuan_bmu_lamteng = 0;
    $total_angkutan_yanti_bmu_lamteng = 0;
    $total_angkutan_nengah_bmu_lamteng = 0;
    $total_angkutan_joko_bmu_lamteng = 0;
    $total_angkutan_samsul_bmu_lamteng = 0;
    $total_angkutan_wayan_bmu_lamteng = 0;
    $total_angkutan_besi88_bmu_lamteng = 0;
    $total_angkutan_dedi_bmu_lamteng = 0;
    $total_angkutan_rony_bmu_lamteng = 0;
    $total_angkutan_azzahra_bmu_lamteng = 0;
    $total_angkutan_sony_bmu_lamteng = 0;
    $total_angkutan_ahmad_bmu_lamteng = 0;
    $total_angkutan_gm_bmu_lamteng = 0;
    $total_angkutan_samsun_bmu_lamteng = 0;

    while ($data1 = mysqli_fetch_array($tabel_lamteng)) {

        $no_polisi_ts = $data1['no_polisi'];
        $qty = $data1['qty'];
        $driver = $data1['driver'];

        if ($qty >= 1 && $qty <= 300) {

            $total_angkut_bmu_lamteng = $qty * 9062;
        } else if ($qty > 300 && $qty <= 500) {

            $total_angkut_bmu_lamteng = $qty * 7283;
        } else if ($qty > 500) {

            $total_angkut_bmu_lamteng = $qty * 7283;
        }

        $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
        $data2p = mysqli_fetch_array($table2p);
        if (isset($data2p['status_kendaraan'])) {
            $pemilik = $data2p['status_kendaraan'];
            $kontrak = $data2p['kontrak'];
        } else {
            $pemilik = '';
            $kontrak = '';
        }



        if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
            $total_angkutan_edy_bmu_lamteng = $total_angkutan_edy_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
            $total_angkutan_rama_bmu_lamteng = $total_angkutan_rama_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
            $total_angkutan_map_bmu_lamteng = $total_angkutan_map_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
            $total_angkutan_eki_bangunan_bmu_lamteng = $total_angkutan_eki_bangunan_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
            $total_angkutan_soma_bmu_lamteng = $total_angkutan_soma_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
            $total_angkutan_berkah_bmu_lamteng = $total_angkutan_berkah_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
            $total_angkutan_syafuan_bmu_lamteng = $total_angkutan_syafuan_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
            $total_angkutan_yanti_bmu_lamteng = $total_angkutan_yanti_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
            $total_angkutan_nengah_bmu_lamteng = $total_angkutan_nengah_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
            $total_angkutan_joko_bmu_lamteng = $total_angkutan_joko_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
            $total_angkutan_samsul_bmu_lamteng = $total_angkutan_samsul_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
            $total_angkutan_besi88_bmu_lamteng = $total_angkutan_besi88_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
            $total_angkutan_wayan_bmu_lamteng = $total_angkutan_wayan_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
            $total_angkutan_dedi_bmu_lamteng = $total_angkutan_dedi_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
            $total_angkutan_rony_bmu_lamteng = $total_angkutan_rony_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
            $total_angkutan_azzahra_bmu_lamteng = $total_angkutan_azzahra_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
            $total_angkutan_sony_bmu_lamteng = $total_angkutan_sony_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
            $total_angkutan_ahmad_bmu_lamteng = $total_angkutan_ahmad_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
            $total_angkutan_gm_bmu_lamteng = $total_angkutan_gm_bmu_lamteng + $total_angkut_bmu_lamteng;
        } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
            $total_angkutan_samsun_bmu_lamteng = $total_angkutan_samsun_bmu_lamteng + $total_angkut_bmu_lamteng;
        }
    }

    $total_tagihan_lamteng = $total_angkutan_edy_bmu_lamteng + $total_angkutan_rama_bmu_lamteng + $total_angkutan_soma_bmu_lamteng + $total_angkutan_berkah_bmu_lamteng +  $total_angkutan_map_bmu_lamteng + $total_angkutan_eki_bangunan_bmu_lamteng + $total_angkutan_syafuan_bmu_lamteng
        + $total_angkutan_yanti_bmu_lamteng + $total_angkutan_nengah_bmu_lamteng + $total_angkutan_joko_bmu_lamteng + $total_angkutan_samsul_bmu_lamteng +  $total_angkutan_wayan_bmu_lamteng + $total_angkutan_besi88_bmu_lamteng
        + $total_angkutan_dedi_bmu_lamteng + $total_angkutan_rony_bmu_lamteng + $total_angkutan_azzahra_bmu_lamteng + $total_angkutan_sony_bmu_lamteng + $total_angkutan_ahmad_bmu_lamteng + $total_angkutan_gm_bmu_lamteng + $total_angkutan_samsun_bmu_lamteng;

    //Untung angkutan / pranko
    $table1 = mysqli_query($koneksipbj, "SELECT no_polisi, kota, qty, tujuan FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'Pranko' OR  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'FRC'  ");
    $total_angkutan_edy_rli = 0;
    $total_angkutan_edy_bmu = 0;
    $total_angkutan_rama_bmu = 0;
    $total_angkutan_eki_bangunan_bmu = 0;
    $total_angkutan_soma_bmu = 0;
    $total_angkutan_berkah_bmu = 0;
    $total_angkutan_syafuan_bmu = 0;
    $total_angkutan_yanti_bmu = 0;
    $total_angkutan_nengah_bmu = 0;
    $total_angkutan_joko_bmu = 0;
    $total_angkutan_map_bmu = 0;
    $total_angkutan_samsul_bmu = 0;
    $total_angkutan_wayan_bmu = 0;
    $total_angkutan_besi88_bmu = 0;
    $total_angkutan_dedi_bmu = 0;
    $total_angkutan_rony_bmu = 0;
    $total_angkutan_azzahra_bmu = 0;
    $total_angkutan_sony_bmu = 0;
    $total_angkutan_ahmad_bmu = 0;
    $total_angkutan_gm_bmu = 0;
    $total_angkutan_samsun_bmu = 0;

    while ($data1 = mysqli_fetch_array($table1)) {


        $kota = $data1['kota'];
        $qty = $data1['qty'];
        $tujuan = $data1['tujuan'];

        //kak nyoman
        if ($kota == 'KAB OKU TIMUR') {

            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_angkut_bmu = $qty * $tarif_600;
            }



            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);


            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                $total_angkutan_edy_rli = $total_angkutan_edy_rli + $total_angkut_rli;
            } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_angkutan_edy_bmu = $total_angkutan_edy_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_angkutan_rama_bmu = $total_angkutan_rama_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_angkutan_map_bmu = $total_angkutan_map_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_angkutan_eki_bangunan_bmu = $total_angkutan_eki_bangunan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                $total_angkutan_soma_bmu = $total_angkutan_soma_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                $total_angkutan_berkah_bmu = $total_angkutan_berkah_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                $total_angkutan_syafuan_bmu = $total_angkutan_syafuan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                $total_angkutan_yanti_bmu = $total_angkutan_yanti_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                $total_angkutan_nengah_bmu = $total_angkutan_nengah_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                $total_angkutan_joko_bmu = $total_angkutan_joko_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                $total_angkutan_samsul_bmu = $total_angkutan_samsul_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                $total_angkutan_besi88_bmu = $total_angkutan_besi88_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                $total_angkutan_wayan_bmu = $total_angkutan_wayan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                $total_angkutan_dedi_bmu = $total_angkutan_dedi_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                $total_angkutan_rony_bmu = $total_angkutan_rony_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                $total_angkutan_azzahra_bmu = $total_angkutan_azzahra_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                $total_angkutan_sony_bmu = $total_angkutan_sony_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                $total_angkutan_ahmad_bmu = $total_angkutan_ahmad_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                $total_angkutan_gm_bmu = $total_angkutan_gm_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                $total_angkutan_samsun_bmu = $total_angkutan_samsun_bmu + $total_angkut_bmu;
            }
        } else if ($kota == 'KAB MESUJI') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;


            //BMU 20ton
            if ($qty >= 1 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_angkut_bmu = $qty * $tarif_600;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            $pemilik = 0;
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                $total_angkutan_edy_rli = $total_angkutan_edy_rli + $total_angkut_rli;
            } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_angkutan_edy_bmu = $total_angkutan_edy_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_angkutan_rama_bmu = $total_angkutan_rama_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_angkutan_map_bmu = $total_angkutan_map_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_angkutan_eki_bangunan_bmu = $total_angkutan_eki_bangunan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                $total_angkutan_soma_bmu = $total_angkutan_soma_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                $total_angkutan_berkah_bmu = $total_angkutan_berkah_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                $total_angkutan_syafuan_bmu = $total_angkutan_syafuan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                $total_angkutan_yanti_bmu = $total_angkutan_yanti_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                $total_angkutan_nengah_bmu = $total_angkutan_nengah_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                $total_angkutan_joko_bmu = $total_angkutan_joko_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                $total_angkutan_samsul_bmu = $total_angkutan_samsul_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                $total_angkutan_besi88_bmu = $total_angkutan_besi88_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                $total_angkutan_wayan_bmu = $total_angkutan_wayan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                $total_angkutan_dedi_bmu = $total_angkutan_dedi_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                $total_angkutan_rony_bmu = $total_angkutan_rony_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                $total_angkutan_azzahra_bmu = $total_angkutan_azzahra_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                $total_angkutan_sony_bmu = $total_angkutan_sony_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                $total_angkutan_ahmad_bmu = $total_angkutan_ahmad_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                $total_angkutan_gm_bmu = $total_angkutan_gm_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                $total_angkutan_samsun_bmu = $total_angkutan_samsun_bmu + $total_angkut_bmu;
            }
        } else if ($kota == 'KAB. TULANG BAWANG') {


            if ($tujuan == 'GDG PT PBJ TUBA 3') {


                //BMU 10ton
                if ($qty >= 1 && $qty <= 300) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = 'RAWAJITU SELATAN' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_angkut_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = 'RAWAJITU SELATAN' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_400 = $data3p['tarif_400'];
                    $total_angkut_bmu = $qty * $tarif_400;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = 'RAWAJITU SELATAN' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_600 = $data3p['tarif_600'];
                    $total_angkut_bmu = $qty * $tarif_600;
                }

                $no_polisi = trim($data1["no_polisi"]);
                $no_polisi_ts = str_replace(" ", "", $no_polisi);

                $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
                $data2p = mysqli_fetch_array($table2p);
                if (isset($data2p['status_kendaraan'])) {
                    $pemilik = $data2p['status_kendaraan'];
                    $kontrak = $data2p['kontrak'];
                } else {
                    $pemilik = '';
                    $kontrak = '';
                }

                if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                    $total_angkutan_edy_rli = $total_angkutan_edy_rli + $total_angkut_rli;
                } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                    $total_angkutan_edy_bmu = $total_angkutan_edy_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                    $total_angkutan_rama_bmu = $total_angkutan_rama_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                    $total_angkutan_map_bmu = $total_angkutan_map_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                    $total_angkutan_eki_bangunan_bmu = $total_angkutan_eki_bangunan_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                    $total_angkutan_soma_bmu = $total_angkutan_soma_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                    $total_angkutan_berkah_bmu = $total_angkutan_berkah_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                    $total_angkutan_syafuan_bmu = $total_angkutan_syafuan_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                    $total_angkutan_yanti_bmu = $total_angkutan_yanti_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                    $total_angkutan_nengah_bmu = $total_angkutan_nengah_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                    $total_angkutan_joko_bmu = $total_angkutan_joko_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                    $total_angkutan_samsul_bmu = $total_angkutan_samsul_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                    $total_angkutan_besi88_bmu = $total_angkutan_besi88_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                    $total_angkutan_wayan_bmu = $total_angkutan_wayan_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                    $total_angkutan_dedi_bmu = $total_angkutan_dedi_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                    $total_angkutan_rony_bmu = $total_angkutan_rony_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                    $total_angkutan_azzahra_bmu = $total_angkutan_azzahra_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                    $total_angkutan_sony_bmu = $total_angkutan_sony_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                    $total_angkutan_ahmad_bmu = $total_angkutan_ahmad_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                    $total_angkutan_gm_bmu = $total_angkutan_gm_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                    $total_angkutan_samsun_bmu = $total_angkutan_samsun_bmu + $total_angkut_bmu;
                }
            } else {
                //RLI
                $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
                $data1p = mysqli_fetch_array($table1p);
                $tarif = $data1p['tarif_pranko'];
                $total_angkut_rli = $qty * $tarif;

                //BMU 10ton
                if ($qty >= 1 && $qty <= 300) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_angkut_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_400 = $data3p['tarif_400'];
                    $total_angkut_bmu = $qty * $tarif_400;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_600 = $data3p['tarif_600'];
                    $total_angkut_bmu = $qty * $tarif_600;
                }

                $no_polisi = trim($data1["no_polisi"]);
                $no_polisi_ts = str_replace(" ", "", $no_polisi);

                $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
                $data2p = mysqli_fetch_array($table2p);
                if (isset($data2p['status_kendaraan'])) {
                    $pemilik = $data2p['status_kendaraan'];
                    $kontrak = $data2p['kontrak'];
                } else {
                    $pemilik = '';
                    $kontrak = '';
                }

                if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                    $total_angkutan_edy_rli = $total_angkutan_edy_rli + $total_angkut_rli;
                } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                    $total_angkutan_edy_bmu = $total_angkutan_edy_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                    $total_angkutan_rama_bmu = $total_angkutan_rama_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                    $total_angkutan_map_bmu = $total_angkutan_map_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                    $total_angkutan_eki_bangunan_bmu = $total_angkutan_eki_bangunan_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                    $total_angkutan_soma_bmu = $total_angkutan_soma_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                    $total_angkutan_berkah_bmu = $total_angkutan_berkah_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                    $total_angkutan_syafuan_bmu = $total_angkutan_syafuan_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                    $total_angkutan_yanti_bmu = $total_angkutan_yanti_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                    $total_angkutan_nengah_bmu = $total_angkutan_nengah_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                    $total_angkutan_joko_bmu = $total_angkutan_joko_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                    $total_angkutan_samsul_bmu = $total_angkutan_samsul_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                    $total_angkutan_besi88_bmu = $total_angkutan_besi88_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                    $total_angkutan_wayan_bmu = $total_angkutan_wayan_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                    $total_angkutan_dedi_bmu = $total_angkutan_dedi_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                    $total_angkutan_rony_bmu = $total_angkutan_rony_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                    $total_angkutan_azzahra_bmu = $total_angkutan_azzahra_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                    $total_angkutan_sony_bmu = $total_angkutan_sony_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                    $total_angkutan_ahmad_bmu = $total_angkutan_ahmad_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                    $total_angkutan_gm_bmu = $total_angkutan_gm_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                    $total_angkutan_samsun_bmu = $total_angkutan_samsun_bmu + $total_angkut_bmu;
                }
            }
        } else if ($kota == 'KAB WAY KANAN') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_angkut_bmu = $qty * $tarif_600;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                $total_angkutan_edy_rli = $total_angkutan_edy_rli + $total_angkut_rli;
            } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_angkutan_edy_bmu = $total_angkutan_edy_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_angkutan_rama_bmu = $total_angkutan_rama_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_angkutan_map_bmu = $total_angkutan_map_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_angkutan_eki_bangunan_bmu = $total_angkutan_eki_bangunan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                $total_angkutan_soma_bmu = $total_angkutan_soma_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                $total_angkutan_berkah_bmu = $total_angkutan_berkah_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                $total_angkutan_syafuan_bmu = $total_angkutan_syafuan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                $total_angkutan_yanti_bmu = $total_angkutan_yanti_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                $total_angkutan_nengah_bmu = $total_angkutan_nengah_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                $total_angkutan_joko_bmu = $total_angkutan_joko_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Kustomo' && $kontrak == 'BMU') {
                $total_angkutan_kustomo_bmu = $total_angkutan_kustomo_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                $total_angkutan_besi88_bmu = $total_angkutan_besi88_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                $total_angkutan_wayan_bmu = $total_angkutan_wayan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                $total_angkutan_dedi_bmu = $total_angkutan_dedi_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                $total_angkutan_rony_bmu = $total_angkutan_rony_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                $total_angkutan_azzahra_bmu = $total_angkutan_azzahra_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                $total_angkutan_sony_bmu = $total_angkutan_sony_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                $total_angkutan_ahmad_bmu = $total_angkutan_ahmad_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                $total_angkutan_gm_bmu = $total_angkutan_gm_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                $total_angkutan_samsun_bmu = $total_angkutan_samsun_bmu + $total_angkut_bmu;
            }
        } else if ($kota == 'KAB OKU SELATAN') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;


            if ($tujuan == 'GDG PT PBA MUARA DUA') {

                //BMU 10ton
                if ($qty >= 1 && $qty <= 300) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_angkut_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_400 = $data3p['tarif_400'];
                    $total_angkut_bmu = $qty * $tarif_400;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_600 = $data3p['tarif_600'];
                    $total_angkut_bmu = $qty * $tarif_600;
                }

                $no_polisi = trim($data1["no_polisi"]);
                $no_polisi_ts = str_replace(" ", "", $no_polisi);

                $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
                $data2p = mysqli_fetch_array($table2p);
                if (isset($data2p['status_kendaraan'])) {
                    $pemilik = $data2p['status_kendaraan'];
                    $kontrak = $data2p['kontrak'];
                } else {
                    $pemilik = '';
                    $kontrak = '';
                }
                if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                    $total_angkutan_edy_rli = $total_angkutan_edy_rli + $total_angkut_rli;
                } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                    $total_angkutan_edy_bmu = $total_angkutan_edy_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                    $total_angkutan_rama_bmu = $total_angkutan_rama_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                    $total_angkutan_map_bmu = $total_angkutan_map_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                    $total_angkutan_eki_bangunan_bmu = $total_angkutan_eki_bangunan_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                    $total_angkutan_soma_bmu = $total_angkutan_soma_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                    $total_angkutan_berkah_bmu = $total_angkutan_berkah_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                    $total_angkutan_syafuan_bmu = $total_angkutan_syafuan_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                    $total_angkutan_yanti_bmu = $total_angkutan_yanti_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                    $total_angkutan_nengah_bmu = $total_angkutan_nengah_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                    $total_angkutan_joko_bmu = $total_angkutan_joko_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                    $total_angkutan_samsul_bmu = $total_angkutan_samsul_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                    $total_angkutan_besi88_bmu = $total_angkutan_besi88_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                    $total_angkutan_wayan_bmu = $total_angkutan_wayan_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                    $total_angkutan_dedi_bmu = $total_angkutan_dedi_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                    $total_angkutan_rony_bmu = $total_angkutan_rony_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                    $total_angkutan_azzahra_bmu = $total_angkutan_azzahra_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                    $total_angkutan_sony_bmu = $total_angkutan_sony_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                    $total_angkutan_ahmad_bmu = $total_angkutan_ahmad_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                    $total_angkutan_gm_bmu = $total_angkutan_gm_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                    $total_angkutan_samsun_bmu = $total_angkutan_samsun_bmu + $total_angkut_bmu;
                }
            } else {
                //BMU 10ton
                if ($qty >= 1 && $qty <= 300) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_angkut_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_angkut_bmu = $qty * $tarif_200;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_angkut_bmu = $qty * $tarif_200;
                }




                $no_polisi = trim($data1["no_polisi"]);
                $no_polisi_ts = str_replace(" ", "", $no_polisi);

                $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
                $data2p = mysqli_fetch_array($table2p);
                if (isset($data2p['status_kendaraan'])) {
                    $pemilik = $data2p['status_kendaraan'];
                    $kontrak = $data2p['kontrak'];
                } else {
                    $pemilik = '';
                    $kontrak = '';
                }

                if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                    $total_angkutan_edy_rli = $total_angkutan_edy_rli + $total_angkut_rli;
                } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                    $total_angkutan_edy_bmu = $total_angkutan_edy_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                    $total_angkutan_rama_bmu = $total_angkutan_rama_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                    $total_angkutan_map_bmu = $total_angkutan_map_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                    $total_angkutan_eki_bangunan_bmu = $total_angkutan_eki_bangunan_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                    $total_angkutan_soma_bmu = $total_angkutan_soma_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                    $total_angkutan_berkah_bmu = $total_angkutan_berkah_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                    $total_angkutan_syafuan_bmu = $total_angkutan_syafuan_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                    $total_angkutan_yanti_bmu = $total_angkutan_yanti_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                    $total_angkutan_nengah_bmu = $total_angkutan_nengah_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                    $total_angkutan_joko_bmu = $total_angkutan_joko_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                    $total_angkutan_samsul_bmu = $total_angkutan_samsul_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                    $total_angkutan_besi88_bmu = $total_angkutan_besi88_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                    $total_angkutan_wayan_bmu = $total_angkutan_wayan_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                    $total_angkutan_dedi_bmu = $total_angkutan_dedi_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                    $total_angkutan_rony_bmu = $total_angkutan_rony_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                    $total_angkutan_azzahra_bmu = $total_angkutan_azzahra_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                    $total_angkutan_sony_bmu = $total_angkutan_sony_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                    $total_angkutan_ahmad_bmu = $total_angkutan_ahmad_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                    $total_angkutan_gm_bmu = $total_angkutan_gm_bmu + $total_angkut_bmu;
                } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                    $total_angkutan_samsun_bmu = $total_angkutan_samsun_bmu + $total_angkut_bmu;
                }
            }
        } else if ($kota == 'KAB. OGAN KOM ULU') {


            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif_400;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                $total_angkutan_edy_rli = $total_angkutan_edy_rli + $total_angkut_rli;
            } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_angkutan_edy_bmu = $total_angkutan_edy_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_angkutan_rama_bmu = $total_angkutan_rama_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_angkutan_map_bmu = $total_angkutan_map_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_angkutan_eki_bangunan_bmu = $total_angkutan_eki_bangunan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                $total_angkutan_soma_bmu = $total_angkutan_soma_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                $total_angkutan_berkah_bmu = $total_angkutan_berkah_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                $total_angkutan_syafuan_bmu = $total_angkutan_syafuan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                $total_angkutan_yanti_bmu = $total_angkutan_yanti_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                $total_angkutan_nengah_bmu = $total_angkutan_nengah_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                $total_angkutan_joko_bmu = $total_angkutan_joko_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                $total_angkutan_samsul_bmu = $total_angkutan_samsul_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                $total_angkutan_besi88_bmu = $total_angkutan_besi88_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                $total_angkutan_wayan_bmu = $total_angkutan_wayan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                $total_angkutan_dedi_bmu = $total_angkutan_dedi_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                $total_angkutan_rony_bmu = $total_angkutan_rony_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                $total_angkutan_azzahra_bmu = $total_angkutan_azzahra_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                $total_angkutan_sony_bmu = $total_angkutan_sony_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                $total_angkutan_ahmad_bmu = $total_angkutan_ahmad_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                $total_angkutan_gm_bmu = $total_angkutan_gm_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                $total_angkutan_samsun_bmu = $total_angkutan_samsun_bmu + $total_angkut_bmu;
            }
        } else if ($kota == 'KAB. LAMPUNG BARAT') {


            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                $total_angkutan_edy_rli = $total_angkutan_edy_rli + $total_angkut_rli;
            } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_angkutan_edy_bmu = $total_angkutan_edy_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_angkutan_rama_bmu = $total_angkutan_rama_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_angkutan_map_bmu = $total_angkutan_map_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_angkutan_eki_bangunan_bmu = $total_angkutan_eki_bangunan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                $total_angkutan_soma_bmu = $total_angkutan_soma_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                $total_angkutan_berkah_bmu = $total_angkutan_berkah_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                $total_angkutan_syafuan_bmu = $total_angkutan_syafuan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                $total_angkutan_yanti_bmu = $total_angkutan_yanti_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                $total_angkutan_nengah_bmu = $total_angkutan_nengah_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                $total_angkutan_joko_bmu = $total_angkutan_joko_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                $total_angkutan_samsul_bmu = $total_angkutan_samsul_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                $total_angkutan_besi88_bmu = $total_angkutan_besi88_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                $total_angkutan_wayan_bmu = $total_angkutan_wayan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                $total_angkutan_dedi_bmu = $total_angkutan_dedi_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                $total_angkutan_rony_bmu = $total_angkutan_rony_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                $total_angkutan_azzahra_bmu = $total_angkutan_azzahra_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                $total_angkutan_sony_bmu = $total_angkutan_sony_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                $total_angkutan_ahmad_bmu = $total_angkutan_ahmad_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                $total_angkutan_gm_bmu = $total_angkutan_gm_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                $total_angkutan_samsun_bmu = $total_angkutan_samsun_bmu + $total_angkut_bmu;
            }
        } else if ($kota == 'KAB.PESISIR BARAT') {


            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                $total_angkutan_edy_rli = $total_angkutan_edy_rli + $total_angkut_rli;
            } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_angkutan_edy_bmu = $total_angkutan_edy_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_angkutan_rama_bmu = $total_angkutan_rama_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_angkutan_map_bmu = $total_angkutan_map_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_angkutan_eki_bangunan_bmu = $total_angkutan_eki_bangunan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                $total_angkutan_soma_bmu = $total_angkutan_soma_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                $total_angkutan_berkah_bmu = $total_angkutan_berkah_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                $total_angkutan_syafuan_bmu = $total_angkutan_syafuan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                $total_angkutan_yanti_bmu = $total_angkutan_yanti_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                $total_angkutan_nengah_bmu = $total_angkutan_nengah_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                $total_angkutan_joko_bmu = $total_angkutan_joko_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                $total_angkutan_samsul_bmu = $total_angkutan_samsul_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                $total_angkutan_besi88_bmu = $total_angkutan_besi88_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                $total_angkutan_wayan_bmu = $total_angkutan_wayan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                $total_angkutan_dedi_bmu = $total_angkutan_dedi_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                $total_angkutan_rony_bmu = $total_angkutan_rony_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                $total_angkutan_azzahra_bmu = $total_angkutan_azzahra_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                $total_angkutan_sony_bmu = $total_angkutan_sony_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                $total_angkutan_ahmad_bmu = $total_angkutan_ahmad_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                $total_angkutan_gm_bmu = $total_angkutan_gm_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                $total_angkutan_samsun_bmu = $total_angkutan_samsun_bmu + $total_angkut_bmu;
            }
        } else if ($kota == 'KAB. LAMPUNG TIMUR') {


            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_angkut_bmu = $qty * $tarif_600;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                $total_angkutan_edy_rli = $total_angkutan_edy_rli + $total_angkut_rli;
            } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_angkutan_edy_bmu = $total_angkutan_edy_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_angkutan_rama_bmu = $total_angkutan_rama_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_angkutan_map_bmu = $total_angkutan_map_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_angkutan_eki_bangunan_bmu = $total_angkutan_eki_bangunan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                $total_angkutan_soma_bmu = $total_angkutan_soma_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                $total_angkutan_berkah_bmu = $total_angkutan_berkah_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                $total_angkutan_syafuan_bmu = $total_angkutan_syafuan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                $total_angkutan_yanti_bmu = $total_angkutan_yanti_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                $total_angkutan_nengah_bmu = $total_angkutan_nengah_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                $total_angkutan_joko_bmu = $total_angkutan_joko_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                $total_angkutan_samsul_bmu = $total_angkutan_samsul_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                $total_angkutan_besi88_bmu = $total_angkutan_besi88_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                $total_angkutan_wayan_bmu = $total_angkutan_wayan_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                $total_angkutan_dedi_bmu = $total_angkutan_dedi_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                $total_angkutan_rony_bmu = $total_angkutan_rony_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                $total_angkutan_azzahra_bmu = $total_angkutan_azzahra_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                $total_angkutan_sony_bmu = $total_angkutan_sony_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                $total_angkutan_ahmad_bmu = $total_angkutan_ahmad_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                $total_angkutan_gm_bmu = $total_angkutan_gm_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                $total_angkutan_samsun_bmu = $total_angkutan_samsun_bmu + $total_angkut_bmu;
            }
        }
    }


    $total_pendapatan_rli = $total_angkutan_edy_rli;
    $total_pendapatan_bmu = $total_angkutan_edy_bmu + $total_angkutan_rama_bmu + $total_angkutan_eki_bangunan_bmu + $total_angkutan_soma_bmu + $total_angkutan_berkah_bmu + $total_angkutan_syafuan_bmu + $total_angkutan_yanti_bmu +
        $total_angkutan_nengah_bmu + $total_angkutan_joko_bmu + $total_angkutan_wayan_bmu + $total_angkutan_samsul_bmu + $total_angkutan_besi88_bmu + $total_angkutan_dedi_bmu + $total_angkutan_rony_bmu + $total_angkutan_azzahra_bmu
        + $total_angkutan_sony_bmu + $total_angkutan_ahmad_bmu + $total_angkutan_gm_bmu + $total_angkutan_samsun_bmu;




    //pengeluaran

    //biaya perbaikan kendaraan 1
    $table_perbaikan_1 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS biaya_perbaikan_1 FROM keuangan_sl WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Perbaikan Kendaraan' ");
    $data_perbaikan_1 = mysqli_fetch_array($table_perbaikan_1);
    $biaya_perbaikan_1 = $data_perbaikan_1['biaya_perbaikan_1'];
    if (!isset($data_perbaikan_1['biaya_perbaikan_1'])) {
        $biaya_perbaikan_1 = 0;
    }

    //biaya perbaikan kendaraan 2
    $table_perbaikan_2 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS biaya_perbaikan_2 FROM keuangan_s WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Perbaikan Kendaraan' ");
    $data_perbaikan_2 = mysqli_fetch_array($table_perbaikan_2);
    $biaya_perbaikan_2 = $data_perbaikan_2['biaya_perbaikan_2'];
    if (!isset($data_perbaikan_2['biaya_perbaikan_2'])) {
        $biaya_perbaikan_2 = 0;
    }


    //pengeluran perbaikan yani
    $table7 = mysqli_query($koneksipbj, "SELECT SUM(jumlah_sparepart) AS total_pembelian_sparepart FROM riwayat_pengeluaran_workshop_s
        WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data7 = mysqli_fetch_array($table7);
    $jml_pembelian_sparepart = $data7['total_pembelian_sparepart'];
    if (!isset($data7['total_pembelian_sparepart'])) {
        $jml_pembelian_sparepart = 0;
    }


    //pengiriman 1
    $table2 = mysqli_query($koneksipbj, "SELECT no_polisi, driver, sum(uj) as total_uj, sum(ug) as total_ug, sum(om) as total_om  FROM pengiriman_s WHERE tanggal_antar  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'Pranko' GROUP BY no_polisi ");
    $data2 = mysqli_fetch_array($table2);
    $total_uj = 0;
    $total_gaji = 0;
    $total_om = 0;

    while ($data2 = mysqli_fetch_array($table2)) {
        $no_polisi = $data2['no_polisi'];
        $uj = $data2['total_uj'];
        $ug = $data2['total_ug'];
        $om = $data2['total_om'];
        if (
            $no_polisi == 'BG8521YB' || $no_polisi == 'BG8251YC' || $no_polisi == 'BG8694YA' || $no_polisi == 'BG8930VA' || $no_polisi == 'BG8221YD' || $no_polisi == 'BG8223YD' || $no_polisi == 'BG8224YD' ||
            $no_polisi == 'BG8225YD' || $no_polisi == 'BG8226YD' || $no_polisi == 'BG8227YD' || $no_polisi == 'BG8101YB' || $no_polisi == 'BG8376YB' || $no_polisi == 'BG8970YB' || $no_polisi == 'BG8405YB' ||
            $no_polisi == 'BG8965V' || $no_polisi == 'BG8966V' || $no_polisi == 'BG8884UY'  || $no_polisi == 'BG8083FP'  || $no_polisi == 'BE8917ACU' || $no_polisi == 'BE8943ACU' || $no_polisi == 'BE8946ACU' ||
            $no_polisi == 'BE8931ACU' || $no_polisi == 'BE8920ACU' || $no_polisi == 'BE8940ACU' || $no_polisi == 'BE8928ACU' || $no_polisi == 'BE8934ACU' || $no_polisi == 'BE8925ACU' || $no_polisi == 'BE8937ACU' ||
            $no_polisi == 'BE8528AUE' || $no_polisi == 'BE8537AUE' || $no_polisi == 'BG8381ZQ' || $no_polisi == 'BG8541VD' || $no_polisi == 'BG8544VD' || $no_polisi == 'BG8535VD' || $no_polisi == 'BG8542VD' ||
            $no_polisi == 'BG8540VD' || $no_polisi == 'BG8149YH' || $no_polisi == 'BG8150YH' || $no_polisi == 'BG8147YH' || $no_polisi == 'BG8148YH' || $no_polisi == 'BE8310LU' || $no_polisi == 'BE8314LU' ||
            $no_polisi == 'BG8101YA' || $no_polisi == 'BG1712XL' || $no_polisi == 'BG1722XL' || $no_polisi == 'BG8969YB' || $no_polisi == 'BG1711XL' || $no_polisi == 'BG8218YH' || $no_polisi == 'BG8302XB' ||
            $no_polisi == 'BG8301XB' || $no_polisi == 'BG8300XB' || $no_polisi == 'BG8755XB' || $no_polisi == 'BG8754XB'
        ) {
            $total_uj = $total_uj + $uj;
            $total_gaji = $total_gaji + $ug;
            $total_om = $total_om + $om;
        } else {
        }
    }

    //pengiriman 2
    $table2sl = mysqli_query($koneksipbj, "SELECT no_polisi, driver, sum(uj) as total_uj_sl, sum(ug) as total_ug_sl, sum(om) as total_om_sl  FROM pengiriman_sl WHERE tanggal_antar  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'Pranko'  GROUP BY no_polisi ");
    $data2sl = mysqli_fetch_array($table2sl);
    $total_uj_sl = 0;
    $total_gaji_sl = 0;
    $total_om_sl = 0;

    while ($data2sl = mysqli_fetch_array($table2sl)) {
        $no_polisi = $data2sl['no_polisi'];
        $uj = $data2sl['total_uj_sl'];
        $ug = $data2sl['total_ug_sl'];
        $om = $data2sl['total_om_sl'];
        if (
            $no_polisi == 'BG8521YB' || $no_polisi == 'BG8251YC' || $no_polisi == 'BG8694YA' || $no_polisi == 'BG8930VA' || $no_polisi == 'BG8221YD' || $no_polisi == 'BG8223YD' || $no_polisi == 'BG8224YD' ||
            $no_polisi == 'BG8225YD' || $no_polisi == 'BG8226YD' || $no_polisi == 'BG8227YD' || $no_polisi == 'BG8101YB' || $no_polisi == 'BG8376YB' || $no_polisi == 'BG8970YB' || $no_polisi == 'BG8405YB' ||
            $no_polisi == 'BG8965V' || $no_polisi == 'BG8966V' || $no_polisi == 'BG8884UY'  || $no_polisi == 'BG8083FP'  || $no_polisi == 'BE8917ACU' || $no_polisi == 'BE8943ACU' || $no_polisi == 'BE8946ACU' ||
            $no_polisi == 'BE8931ACU' || $no_polisi == 'BE8920ACU' || $no_polisi == 'BE8940ACU' || $no_polisi == 'BE8928ACU' || $no_polisi == 'BE8934ACU' || $no_polisi == 'BE8925ACU' || $no_polisi == 'BE8937ACU' ||
            $no_polisi == 'BE8528AUE' || $no_polisi == 'BE8537AUE' || $no_polisi == 'BG8381ZQ' || $no_polisi == 'BG8541VD' || $no_polisi == 'BG8544VD' || $no_polisi == 'BG8535VD' || $no_polisi == 'BG8542VD' ||
            $no_polisi == 'BG8540VD' || $no_polisi == 'BG8149YH' || $no_polisi == 'BG8150YH' || $no_polisi == 'BG8147YH' || $no_polisi == 'BG8148YH' || $no_polisi == 'BE8310LU' || $no_polisi == 'BE8314LU' ||
            $no_polisi == 'BG8101YA' || $no_polisi == 'BG1712XL' || $no_polisi == 'BG1722XL' || $no_polisi == 'BG8969YB' || $no_polisi == 'BG1711XL' || $no_polisi == 'BG8218YH' || $no_polisi == 'BG8302XB' ||
            $no_polisi == 'BG8301XB' || $no_polisi == 'BG8300XB' || $no_polisi == 'BG8755XB' || $no_polisi == 'BG8754XB'
        ) {
            $total_uj_sl = $total_uj_sl + $uj;
            $total_gaji_sl = $total_gaji_sl + $ug;
            $total_om_sl = $total_om_sl + $om;
        } else {
        }
    }


    //pengiriman 1 bs
    $table2x = mysqli_query($koneksipbj, "SELECT no_polisi, driver, SUM(bs) as total_bs  FROM pengiriman_s WHERE tanggal_antar  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'Pranko' GROUP BY no_polisi ");
    $total_bs = 0;

    while ($data2x = mysqli_fetch_array($table2x)) {
        $no_polisi = $data2x['no_polisi'];
        $bs = $data2x['total_bs'];
        if (
            $no_polisi != 'BG8521YB' || $no_polisi != 'BG8251YC' || $no_polisi != 'BG8694YA' || $no_polisi != 'BG8930VA' || $no_polisi != 'BG8221YD' || $no_polisi != 'BG8223YD' || $no_polisi != 'BG8224YD' ||
            $no_polisi != 'BG8225YD' || $no_polisi != 'BG8226YD' || $no_polisi != 'BG8227YD' || $no_polisi != 'BG8101YB' || $no_polisi != 'BG8376YB' || $no_polisi != 'BG8970YB' || $no_polisi != 'BG8405YB' ||
            $no_polisi != 'BG8965V' || $no_polisi != 'BG8966V' || $no_polisi != 'BG8884UY'  || $no_polisi != 'BG8083FP'  || $no_polisi != 'BE8917ACU' || $no_polisi != 'BE8943ACU' || $no_polisi != 'BE8946ACU' ||
            $no_polisi != 'BE8931ACU' || $no_polisi != 'BE8920ACU' || $no_polisi != 'BE8940ACU' || $no_polisi != 'BE8928ACU' || $no_polisi != 'BE8934ACU' || $no_polisi != 'BE8925ACU' || $no_polisi != 'BE8937ACU' ||
            $no_polisi != 'BE8528AUE' || $no_polisi != 'BE8537AUE' || $no_polisi != 'BG8381ZQ' || $no_polisi != 'BG8541VD' || $no_polisi != 'BG8544VD' || $no_polisi != 'BG8535VD' || $no_polisi != 'BG8542VD' ||
            $no_polisi != 'BG8540VD' || $no_polisi != 'BG8149YH' || $no_polisi != 'BG8150YH' || $no_polisi != 'BG8147YH' || $no_polisi != 'BG8148YH' || $no_polisi != 'BE8310LU' || $no_polisi != 'BE8314LU' ||
            $no_polisi != 'BG8101YA' || $no_polisi != 'BG1712XL' || $no_polisi != 'BG1722XL' || $no_polisi != 'BG8969YB' || $no_polisi != 'BG1711XL' || $no_polisi != 'BG8218YH' || $no_polisi != 'BG8302XB' ||
            $no_polisi != 'BG8301XB' || $no_polisi != 'BG8300XB' || $no_polisi != 'BG8755XB' || $no_polisi != 'BG8754XB'
        ) {
            $total_bs = $total_bs + $bs;
        } else {
        }
    }

    //pengiriman 2 bs
    $table2slx = mysqli_query($koneksipbj, "SELECT no_polisi, driver, SUM(bs) as total_bs_sl FROM pengiriman_sl WHERE tanggal_antar  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'Pranko' GROUP BY no_polisi");
    $total_bs_sl = 0;

    while ($data2slx = mysqli_fetch_array($table2slx)) {
        $no_polisi = $data2slx['no_polisi'];
        $bs = $data2slx['total_bs_sl'];
        if (
            $no_polisi != 'BG8521YB' || $no_polisi != 'BG8251YC' || $no_polisi != 'BG8694YA' || $no_polisi != 'BG8930VA' || $no_polisi != 'BG8221YD' || $no_polisi != 'BG8223YD' || $no_polisi != 'BG8224YD' ||
            $no_polisi != 'BG8225YD' || $no_polisi != 'BG8226YD' || $no_polisi != 'BG8227YD' || $no_polisi != 'BG8101YB' || $no_polisi != 'BG8376YB' || $no_polisi != 'BG8970YB' || $no_polisi != 'BG8405YB' ||
            $no_polisi != 'BG8965V' || $no_polisi != 'BG8966V' || $no_polisi != 'BG8884UY'  || $no_polisi != 'BG8083FP'  || $no_polisi != 'BE8917ACU' || $no_polisi != 'BE8943ACU' || $no_polisi != 'BE8946ACU' ||
            $no_polisi != 'BE8931ACU' || $no_polisi != 'BE8920ACU' || $no_polisi != 'BE8940ACU' || $no_polisi != 'BE8928ACU' || $no_polisi != 'BE8934ACU' || $no_polisi != 'BE8925ACU' || $no_polisi != 'BE8937ACU' ||
            $no_polisi != 'BE8528AUE' || $no_polisi != 'BE8537AUE' || $no_polisi != 'BG8381ZQ' || $no_polisi != 'BG8541VD' || $no_polisi != 'BG8544VD' || $no_polisi != 'BG8535VD' || $no_polisi != 'BG8542VD' ||
            $no_polisi != 'BG8540VD' || $no_polisi != 'BG8149YH' || $no_polisi != 'BG8150YH' || $no_polisi != 'BG8147YH' || $no_polisi != 'BG8148YH' || $no_polisi != 'BE8310LU' || $no_polisi != 'BE8314LU' ||
            $no_polisi != 'BG8101YA' || $no_polisi != 'BG1712XL' || $no_polisi != 'BG1722XL' || $no_polisi != 'BG8969YB' || $no_polisi != 'BG1711XL' || $no_polisi != 'BG8218YH' || $no_polisi != 'BG8302XB' ||
            $no_polisi != 'BG8301XB' || $no_polisi != 'BG8300XB' || $no_polisi != 'BG8755XB' || $no_polisi != 'BG8754XB'
        ) {
            $total_bs_sl = $total_bs_sl + $bs;
        } else {
        }
    }


    /*Biaya tarikan etty
    $table_tarikan_s = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_biaya_tarikan FROM keuangan_s WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Tarikan' ");
    $data_tarikan_s = mysqli_fetch_array($table_tarikan_s);
    $jml_biaya_tarikan_s = $data_tarikan_s['jumlah_biaya_tarikan'];
    if (!isset($data_tarikan_s['jumlah_biaya_tarikan'])) {
        $jml_biaya_tarikan_s = 0;
    }
    //Biaya tarikan kadek
    $table_tarikan_sl = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_biaya_tarikan FROM keuangan_sl  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Tarikan' ");
    $data_tarikan_sl = mysqli_fetch_array($table_tarikan_sl);
    $jml_biaya_tarikan_sl = $data_tarikan_sl['jumlah_biaya_tarikan'];
    if (!isset($data_tarikan_sl['jumlah_biaya_tarikan'])) {
        $jml_biaya_tarikan_sl = 0;
    }
    }*/


    //Krdit Kendaraan
    $table_kredit_kendaraan = mysqli_query($koneksipbj, "SELECT SUM(jumlah_bayar) AS jumlah_kredit_kendaraan FROM kredit_kendaraan  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data_kredit_kendaraan = mysqli_fetch_array($table_kredit_kendaraan);
    $total_kredit_kendaraan = $data_kredit_kendaraan['jumlah_kredit_kendaraan'];
    if (!isset($data_kredit_kendaraan['jumlah_kredit_kendaraan'])) {
        $total_kredit_kendaraan = 0;
    }


    //Ongkos KSO

    //kota bumi 
    $tabel_om_kotabumi = mysqli_query($koneksipbj, "SELECT no_polisi, driver, qty FROM pembelian_kota_bumi WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

    $total_om_edy_bmu_kb = 0;
    $total_om_soma_bmu_kb = 0;
    $total_om_rama_bmu_kb = 0;
    $total_om_map_bmu_kb = 0;
    $total_om_berkah_bmu_kb = 0;
    $total_om_eki_bangunan_bmu_kb = 0;
    $total_om_syafuan_bmu_kb = 0;
    $total_om_yanti_bmu_kb = 0;
    $total_om_nengah_bmu_kb = 0;
    $total_om_joko_bmu_kb = 0;
    $total_om_samsul_bmu_kb = 0;
    $total_om_wayan_bmu_kb = 0;
    $total_om_besi88_bmu_kb = 0;
    $total_om_dedi_bmu_kb = 0;
    $total_om_rony_bmu_kb = 0;
    $total_om_azzahra_bmu_kb = 0;
    $total_om_sony_bmu_kb = 0;
    $total_om_ahmad_bmu_kb = 0;
    $total_om_gm_bmu_kb = 0;
    $total_om_samsun_bmu_kb = 0;

    while ($data1 = mysqli_fetch_array($tabel_om_kotabumi)) {

        $no_polisi_ts = $data1['no_polisi'];
        $qty = $data1['qty'];
        $driver = $data1['driver'];

        if ($qty >= 1 && $qty <= 300) {

            $total_om_bmu_kotabumi = $qty * 7500;
        } else if ($qty > 300 && $qty <= 500) {

            $total_om_bmu_kotabumi = $qty * 6500;
        } else if ($qty > 500) {

            $total_om_bmu_kotabumi = $qty * 6500;
        }

        $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
        $data2p = mysqli_fetch_array($table2p);
        if (isset($data2p['status_kendaraan'])) {
            $pemilik = $data2p['status_kendaraan'];
            $kontrak = $data2p['kontrak'];
        } else {
            $pemilik = '';
            $kontrak = '';
        }



        if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
            $total_om_edy_bmu_kb = $total_om_edy_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
            $total_om_map_bmu_kb = $total_om_map_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
            $total_om_eki_bangunan_bmu_kb = $total_om_eki_bangunan_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
            $total_om_soma_bmu_kb = $total_om_soma_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
            $total_om_berkah_bmu_kb = $total_om_berkah_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
            $total_om_syafuan_bmu_kb = $total_om_syafuan_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
            $total_om_yanti_bmu_kb = $total_om_yanti_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
            $total_om_nengah_bmu_kb = $total_om_nengah_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
            $total_om_joko_bmu_kb = $total_om_joko_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
            $total_om_samsul_bmu_kb = $total_om_samsul_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
            $total_om_besi88_bmu_kb = $total_om_besi88_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
            $total_om_wayan_bmu_kb = $total_om_wayan_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
            $total_om_dedi_bmu_kb = $total_om_dedi_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
            $total_om_rony_bmu_kb = $total_om_rony_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
            $total_om_azzahra_bmu_kb = $total_om_azzahra_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
            $total_om_sony_bmu_kb = $total_om_sony_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
            $total_om_ahmad_bmu_kb = $total_om_ahmad_bmu_kb + $total_om_bmu_kotabumi;
        } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
            $total_om_samsun_bmu_kb = $total_om_samsun_bmu_kb + $total_om_bmu_kotabumi;
        }
    }
    $total_om_kotabumi = $total_om_rama_bmu_kb + $total_om_soma_bmu_kb + $total_om_berkah_bmu_kb +  $total_om_map_bmu_kb + $total_om_eki_bangunan_bmu_kb + $total_om_syafuan_bmu_kb
        + $total_om_yanti_bmu_kb + $total_om_nengah_bmu_kb + $total_om_joko_bmu_kb + $total_om_samsul_bmu_kb +  $total_om_wayan_bmu_kb + $total_om_besi88_bmu_kb
        + $total_om_dedi_bmu_kb + $total_om_rony_bmu_kb + $total_om_azzahra_bmu_kb + $total_om_sony_bmu_kb + $total_om_ahmad_bmu_kb + $total_om_gm_bmu_kb + $total_om_samsun_bmu_kb;


    //lamteng
    $tabel_om_lamteng = mysqli_query($koneksipbj, "SELECT no_polisi, driver, qty FROM pembelian_lamteng WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

    $total_om_edy_bmu_lamteng = 0;
    $total_om_rama_bmu_lamteng = 0;
    $total_om_soma_bmu_lamteng = 0;
    $total_om_berkah_bmu_lamteng = 0;
    $total_om_map_bmu_lamteng = 0;
    $total_om_eki_bangunan_bmu_lamteng = 0;
    $total_om_syafuan_bmu_lamteng = 0;
    $total_om_yanti_bmu_lamteng = 0;
    $total_om_nengah_bmu_lamteng = 0;
    $total_om_joko_bmu_lamteng = 0;
    $total_om_samsul_bmu_lamteng = 0;
    $total_om_wayan_bmu_lamteng = 0;
    $total_om_besi88_bmu_lamteng = 0;
    $total_om_dedi_bmu_lamteng = 0;
    $total_om_rony_bmu_lamteng = 0;
    $total_om_azzahra_bmu_lamteng = 0;
    $total_om_sony_bmu_lamteng = 0;
    $total_om_ahmad_bmu_lamteng = 0;
    $total_om_gm_bmu_lamteng = 0;
    $total_om_samsun_bmu_lamteng = 0;

    while ($data1 = mysqli_fetch_array($tabel_om_lamteng)) {

        $no_polisi_ts = $data1['no_polisi'];
        $qty = $data1['qty'];
        $driver = $data1['driver'];

        if ($qty >= 1 && $qty <= 300) {

            $total_om_bmu_lamteng = $qty * 8500;
        } else if ($qty > 300 && $qty <= 500) {

            $total_om_bmu_lamteng = $qty * 7500;
        } else if ($qty > 500) {

            $total_om_bmu_lamteng = $qty * 7500;
        }

        $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
        $data2p = mysqli_fetch_array($table2p);
        if (isset($data2p['status_kendaraan'])) {
            $pemilik = $data2p['status_kendaraan'];
            $kontrak = $data2p['kontrak'];
        } else {
            $pemilik = '';
            $kontrak = '';
        }



        if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
            $total_om_edy_bmu_lamteng = $total_om_edy_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
            $total_om_map_bmu_lamteng = $total_om_map_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
            $total_om_eki_bangunan_bmu_lamteng = $total_om_eki_bangunan_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
            $total_om_soma_bmu_lamteng = $total_om_soma_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
            $total_om_berkah_bmu_lamteng = $total_om_berkah_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
            $total_om_syafuan_bmu_lamteng = $total_om_syafuan_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
            $total_om_yanti_bmu_lamteng = $total_om_yanti_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
            $total_om_nengah_bmu_lamteng = $total_om_nengah_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
            $total_om_joko_bmu_lamteng = $total_om_joko_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
            $total_om_samsul_bmu_lamteng = $total_om_samsul_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
            $total_om_besi88_bmu_lamteng = $total_om_besi88_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
            $total_om_wayan_bmu_lamteng = $total_om_wayan_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
            $total_om_dedi_bmu_lamteng = $total_om_dedi_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
            $total_om_rony_bmu_lamteng = $total_om_rony_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
            $total_om_azzahra_bmu_lamteng = $total_om_azzahra_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
            $total_om_sony_bmu_lamteng = $total_om_sony_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
            $total_om_ahmad_bmu_lamteng = $total_om_ahmad_bmu_lamteng + $total_om_bmu_lamteng;
        } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
            $total_om_samsun_bmu_lamteng = $total_om_samsun_bmu_lamteng + $total_om_bmu_lamteng;
        }
    }

    $total_om_lamteng =  $total_om_rama_bmu_lamteng + $total_om_soma_bmu_lamteng + $total_om_berkah_bmu_lamteng +  $total_om_map_bmu_lamteng + $total_om_eki_bangunan_bmu_lamteng + $total_om_syafuan_bmu_lamteng
        + $total_om_yanti_bmu_lamteng + $total_om_nengah_bmu_lamteng + $total_om_joko_bmu_lamteng + $total_om_samsul_bmu_lamteng +  $total_om_wayan_bmu_lamteng + $total_om_besi88_bmu_lamteng
        + $total_om_dedi_bmu_lamteng + $total_om_rony_bmu_lamteng + $total_om_azzahra_bmu_lamteng + $total_om_sony_bmu_lamteng + $total_om_ahmad_bmu_lamteng + $total_om_gm_bmu_lamteng + $total_om_samsun_bmu_lamteng;


//OM angkutan / pranko
    $table1_om = mysqli_query($koneksipbj, "SELECT no_polisi, kota, qty, tujuan FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'Pranko' OR  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'FRC'  ");
    $total_om_edy_rli = 0;
    $total_om_edy_bmu = 0;
    $total_om_rama_bmu = 0;
    $total_om_eki_bangunan_bmu = 0;
    $total_om_soma_bmu = 0;
    $total_om_berkah_bmu = 0;
    $total_om_syafuan_bmu = 0;
    $total_om_yanti_bmu = 0;
    $total_om_nengah_bmu = 0;
    $total_om_joko_bmu = 0;
    $total_om_map_bmu = 0;
    $total_om_samsul_bmu = 0;
    $total_om_wayan_bmu = 0;
    $total_om_besi88_bmu = 0;
    $total_om_dedi_bmu = 0;
    $total_om_rony_bmu = 0;
    $total_om_azzahra_bmu = 0;
    $total_om_sony_bmu = 0;
    $total_om_ahmad_bmu = 0;
    $total_om_gm_bmu = 0;
    $total_om_samsun_bmu = 0;

    while ($data1 = mysqli_fetch_array($table1_om)) {


        $kota = $data1['kota'];
        $qty = $data1['qty'];
        $tujuan = $data1['tujuan'];

        //kak nyoman
        if ($kota == 'KAB OKU TIMUR') {

            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_om_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_om_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_om_bmu = $qty * $tarif_600;
            }



            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);


            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                $total_om_edy_rli = $total_om_edy_rli + $total_om_rli;
            } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_om_edy_bmu = $total_om_edy_bmu + $total_om_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_om_map_bmu = $total_om_map_bmu + $total_om_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_om_eki_bangunan_bmu = $total_om_eki_bangunan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                $total_om_soma_bmu = $total_om_soma_bmu + $total_om_bmu;
            } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                $total_om_berkah_bmu = $total_om_berkah_bmu + $total_om_bmu;
            } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                $total_om_syafuan_bmu = $total_om_syafuan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                $total_om_yanti_bmu = $total_om_yanti_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                $total_om_nengah_bmu = $total_om_nengah_bmu + $total_om_bmu;
            } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                $total_om_joko_bmu = $total_om_joko_bmu + $total_om_bmu;
            } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                $total_om_samsul_bmu = $total_om_samsul_bmu + $total_om_bmu;
            } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                $total_om_besi88_bmu = $total_om_besi88_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                $total_om_wayan_bmu = $total_om_wayan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                $total_om_dedi_bmu = $total_om_dedi_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                $total_om_rony_bmu = $total_om_rony_bmu + $total_om_bmu;
            } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                $total_om_azzahra_bmu = $total_om_azzahra_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                $total_om_sony_bmu = $total_om_sony_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                $total_om_ahmad_bmu = $total_om_ahmad_bmu + $total_om_bmu;
            } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                $total_om_samsun_bmu = $total_om_samsun_bmu + $total_om_bmu;
            }
        } else if ($kota == 'KAB MESUJI') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_om_rli = $qty * $tarif;


            //BMU 20ton
            if ($qty >= 1 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_om_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_om_bmu = $qty * $tarif_600;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            $pemilik = 0;
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                $total_om_edy_rli = $total_om_edy_rli + $total_om_rli;
            } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_om_edy_bmu = $total_om_edy_bmu + $total_om_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_om_map_bmu = $total_om_map_bmu + $total_om_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_om_eki_bangunan_bmu = $total_om_eki_bangunan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                $total_om_soma_bmu = $total_om_soma_bmu + $total_om_bmu;
            } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                $total_om_berkah_bmu = $total_om_berkah_bmu + $total_om_bmu;
            } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                $total_om_syafuan_bmu = $total_om_syafuan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                $total_om_yanti_bmu = $total_om_yanti_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                $total_om_nengah_bmu = $total_om_nengah_bmu + $total_om_bmu;
            } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                $total_om_joko_bmu = $total_om_joko_bmu + $total_om_bmu;
            } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                $total_om_samsul_bmu = $total_om_samsul_bmu + $total_om_bmu;
            } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                $total_om_besi88_bmu = $total_om_besi88_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                $total_om_wayan_bmu = $total_om_wayan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                $total_om_dedi_bmu = $total_om_dedi_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                $total_om_rony_bmu = $total_om_rony_bmu + $total_om_bmu;
            } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                $total_om_azzahra_bmu = $total_om_azzahra_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                $total_om_sony_bmu = $total_om_sony_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                $total_om_ahmad_bmu = $total_om_ahmad_bmu + $total_om_bmu;
            } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                $total_om_samsun_bmu = $total_om_samsun_bmu + $total_om_bmu;
            }
        } else if ($kota == 'KAB. TULANG BAWANG') {


            if ($tujuan == 'GDG PT PBJ TUBA 3') {


                //BMU 10ton
                if ($qty >= 1 && $qty <= 300) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso WHERE nama_wilayah  = 'RAWAJITU SELATAN' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_om_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso WHERE nama_wilayah  = 'RAWAJITU SELATAN' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_400 = $data3p['tarif_400'];
                    $total_om_bmu = $qty * $tarif_400;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_kso WHERE nama_wilayah  = 'RAWAJITU SELATAN' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_600 = $data3p['tarif_600'];
                    $total_om_bmu = $qty * $tarif_600;
                }

                $no_polisi = trim($data1["no_polisi"]);
                $no_polisi_ts = str_replace(" ", "", $no_polisi);

                $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
                $data2p = mysqli_fetch_array($table2p);
                if (isset($data2p['status_kendaraan'])) {
                    $pemilik = $data2p['status_kendaraan'];
                    $kontrak = $data2p['kontrak'];
                } else {
                    $pemilik = '';
                    $kontrak = '';
                }

                if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                    $total_om_edy_rli = $total_om_edy_rli + $total_om_rli;
                } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                    $total_om_edy_bmu = $total_om_edy_bmu + $total_om_bmu;
                } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                    $total_om_map_bmu = $total_om_map_bmu + $total_om_bmu;
                } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                    $total_om_eki_bangunan_bmu = $total_om_eki_bangunan_bmu + $total_om_bmu;
                } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                    $total_om_soma_bmu = $total_om_soma_bmu + $total_om_bmu;
                } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                    $total_om_berkah_bmu = $total_om_berkah_bmu + $total_om_bmu;
                } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                    $total_om_syafuan_bmu = $total_om_syafuan_bmu + $total_om_bmu;
                } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                    $total_om_yanti_bmu = $total_om_yanti_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                    $total_om_nengah_bmu = $total_om_nengah_bmu + $total_om_bmu;
                } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                    $total_om_joko_bmu = $total_om_joko_bmu + $total_om_bmu;
                } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                    $total_om_samsul_bmu = $total_om_samsul_bmu + $total_om_bmu;
                } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                    $total_om_besi88_bmu = $total_om_besi88_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                    $total_om_wayan_bmu = $total_om_wayan_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                    $total_om_dedi_bmu = $total_om_dedi_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                    $total_om_rony_bmu = $total_om_rony_bmu + $total_om_bmu;
                } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                    $total_om_azzahra_bmu = $total_om_azzahra_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                    $total_om_sony_bmu = $total_om_sony_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                    $total_om_ahmad_bmu = $total_om_ahmad_bmu + $total_om_bmu;
                } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                    $total_om_samsun_bmu = $total_om_samsun_bmu + $total_om_bmu;
                }
            } else {
                //RLI
                $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
                $data1p = mysqli_fetch_array($table1p);
                $tarif = $data1p['tarif_pranko'];
                $total_om_rli = $qty * $tarif;

                //BMU 10ton
                if ($qty >= 1 && $qty <= 300) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_om_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_400 = $data3p['tarif_400'];
                    $total_om_bmu = $qty * $tarif_400;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_600 = $data3p['tarif_600'];
                    $total_om_bmu = $qty * $tarif_600;
                }

                $no_polisi = trim($data1["no_polisi"]);
                $no_polisi_ts = str_replace(" ", "", $no_polisi);

                $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
                $data2p = mysqli_fetch_array($table2p);
                if (isset($data2p['status_kendaraan'])) {
                    $pemilik = $data2p['status_kendaraan'];
                    $kontrak = $data2p['kontrak'];
                } else {
                    $pemilik = '';
                    $kontrak = '';
                }

                if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                    $total_om_edy_rli = $total_om_edy_rli + $total_om_rli;
                } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                    $total_om_edy_bmu = $total_om_edy_bmu + $total_om_bmu;
                } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                    $total_om_map_bmu = $total_om_map_bmu + $total_om_bmu;
                } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                    $total_om_eki_bangunan_bmu = $total_om_eki_bangunan_bmu + $total_om_bmu;
                } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                    $total_om_soma_bmu = $total_om_soma_bmu + $total_om_bmu;
                } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                    $total_om_berkah_bmu = $total_om_berkah_bmu + $total_om_bmu;
                } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                    $total_om_syafuan_bmu = $total_om_syafuan_bmu + $total_om_bmu;
                } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                    $total_om_yanti_bmu = $total_om_yanti_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                    $total_om_nengah_bmu = $total_om_nengah_bmu + $total_om_bmu;
                } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                    $total_om_joko_bmu = $total_om_joko_bmu + $total_om_bmu;
                } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                    $total_om_samsul_bmu = $total_om_samsul_bmu + $total_om_bmu;
                } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                    $total_om_besi88_bmu = $total_om_besi88_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                    $total_om_wayan_bmu = $total_om_wayan_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                    $total_om_dedi_bmu = $total_om_dedi_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                    $total_om_rony_bmu = $total_om_rony_bmu + $total_om_bmu;
                } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                    $total_om_azzahra_bmu = $total_om_azzahra_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                    $total_om_sony_bmu = $total_om_sony_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                    $total_om_ahmad_bmu = $total_om_ahmad_bmu + $total_om_bmu;
                } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                    $total_om_samsun_bmu = $total_om_samsun_bmu + $total_om_bmu;
                }
            }
        } else if ($kota == 'KAB WAY KANAN') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_om_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_om_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_om_bmu = $qty * $tarif_600;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                $total_om_edy_rli = $total_om_edy_rli + $total_om_rli;
            } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_om_edy_bmu = $total_om_edy_bmu + $total_om_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_om_map_bmu = $total_om_map_bmu + $total_om_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_om_eki_bangunan_bmu = $total_om_eki_bangunan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                $total_om_soma_bmu = $total_om_soma_bmu + $total_om_bmu;
            } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                $total_om_berkah_bmu = $total_om_berkah_bmu + $total_om_bmu;
            } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                $total_om_syafuan_bmu = $total_om_syafuan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                $total_om_yanti_bmu = $total_om_yanti_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                $total_om_nengah_bmu = $total_om_nengah_bmu + $total_om_bmu;
            } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                $total_om_joko_bmu = $total_om_joko_bmu + $total_om_bmu;
            } else if ($pemilik == 'Kustomo' && $kontrak == 'BMU') {
                $total_om_kustomo_bmu = $total_om_kustomo_bmu + $total_om_bmu;
            } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                $total_om_besi88_bmu = $total_om_besi88_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                $total_om_wayan_bmu = $total_om_wayan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                $total_om_dedi_bmu = $total_om_dedi_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                $total_om_rony_bmu = $total_om_rony_bmu + $total_om_bmu;
            } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                $total_om_azzahra_bmu = $total_om_azzahra_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                $total_om_sony_bmu = $total_om_sony_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                $total_om_ahmad_bmu = $total_om_ahmad_bmu + $total_om_bmu;
            } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                $total_om_samsun_bmu = $total_om_samsun_bmu + $total_om_bmu;
            }
        } else if ($kota == 'KAB OKU SELATAN') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_om_rli = $qty * $tarif;


            if ($tujuan == 'GDG PT PBA MUARA DUA') {

                //BMU 10ton
                if ($qty >= 1 && $qty <= 300) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso WHERE nama_wilayah  = 'MUARA DUA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_om_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso WHERE nama_wilayah  = 'MUARA DUA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_400 = $data3p['tarif_400'];
                    $total_om_bmu = $qty * $tarif_400;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_kso WHERE nama_wilayah  = 'MUARA DUA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_600 = $data3p['tarif_600'];
                    $total_om_bmu = $qty * $tarif_600;
                }

                $no_polisi = trim($data1["no_polisi"]);
                $no_polisi_ts = str_replace(" ", "", $no_polisi);

                $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
                $data2p = mysqli_fetch_array($table2p);
                if (isset($data2p['status_kendaraan'])) {
                    $pemilik = $data2p['status_kendaraan'];
                    $kontrak = $data2p['kontrak'];
                } else {
                    $pemilik = '';
                    $kontrak = '';
                }
                if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                    $total_om_edy_rli = $total_om_edy_rli + $total_om_rli;
                } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                    $total_om_edy_bmu = $total_om_edy_bmu + $total_om_bmu;
                } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                    $total_om_map_bmu = $total_om_map_bmu + $total_om_bmu;
                } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                    $total_om_eki_bangunan_bmu = $total_om_eki_bangunan_bmu + $total_om_bmu;
                } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                    $total_om_soma_bmu = $total_om_soma_bmu + $total_om_bmu;
                } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                    $total_om_berkah_bmu = $total_om_berkah_bmu + $total_om_bmu;
                } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                    $total_om_syafuan_bmu = $total_om_syafuan_bmu + $total_om_bmu;
                } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                    $total_om_yanti_bmu = $total_om_yanti_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                    $total_om_nengah_bmu = $total_om_nengah_bmu + $total_om_bmu;
                } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                    $total_om_joko_bmu = $total_om_joko_bmu + $total_om_bmu;
                } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                    $total_om_samsul_bmu = $total_om_samsul_bmu + $total_om_bmu;
                } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                    $total_om_besi88_bmu = $total_om_besi88_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                    $total_om_wayan_bmu = $total_om_wayan_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                    $total_om_dedi_bmu = $total_om_dedi_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                    $total_om_rony_bmu = $total_om_rony_bmu + $total_om_bmu;
                } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                    $total_om_azzahra_bmu = $total_om_azzahra_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                    $total_om_sony_bmu = $total_om_sony_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                    $total_om_ahmad_bmu = $total_om_ahmad_bmu + $total_om_bmu;
                } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                    $total_om_samsun_bmu = $total_om_samsun_bmu + $total_om_bmu;
                }
            } else {
                //BMU 10ton
                if ($qty >= 1 && $qty <= 300) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_om_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_om_bmu = $qty * $tarif_200;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_om_bmu = $qty * $tarif_200;
                }




                $no_polisi = trim($data1["no_polisi"]);
                $no_polisi_ts = str_replace(" ", "", $no_polisi);

                $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
                $data2p = mysqli_fetch_array($table2p);
                if (isset($data2p['status_kendaraan'])) {
                    $pemilik = $data2p['status_kendaraan'];
                    $kontrak = $data2p['kontrak'];
                } else {
                    $pemilik = '';
                    $kontrak = '';
                }

                if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                    $total_om_edy_rli = $total_om_edy_rli + $total_om_rli;
                } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                    $total_om_edy_bmu = $total_om_edy_bmu + $total_om_bmu;
                } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                    $total_om_map_bmu = $total_om_map_bmu + $total_om_bmu;
                } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                    $total_om_eki_bangunan_bmu = $total_om_eki_bangunan_bmu + $total_om_bmu;
                } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                    $total_om_soma_bmu = $total_om_soma_bmu + $total_om_bmu;
                } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                    $total_om_berkah_bmu = $total_om_berkah_bmu + $total_om_bmu;
                } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                    $total_om_syafuan_bmu = $total_om_syafuan_bmu + $total_om_bmu;
                } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                    $total_om_yanti_bmu = $total_om_yanti_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                    $total_om_nengah_bmu = $total_om_nengah_bmu + $total_om_bmu;
                } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                    $total_om_joko_bmu = $total_om_joko_bmu + $total_om_bmu;
                } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                    $total_om_samsul_bmu = $total_om_samsul_bmu + $total_om_bmu;
                } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                    $total_om_besi88_bmu = $total_om_besi88_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                    $total_om_wayan_bmu = $total_om_wayan_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                    $total_om_dedi_bmu = $total_om_dedi_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                    $total_om_rony_bmu = $total_om_rony_bmu + $total_om_bmu;
                } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                    $total_om_azzahra_bmu = $total_om_azzahra_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                    $total_om_sony_bmu = $total_om_sony_bmu + $total_om_bmu;
                } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                    $total_om_ahmad_bmu = $total_om_ahmad_bmu + $total_om_bmu;
                } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                    $total_om_samsun_bmu = $total_om_samsun_bmu + $total_om_bmu;
                }
            }
        } else if ($kota == 'KAB. OGAN KOM ULU') {


            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_om_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_om_bmu = $qty * $tarif_400;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                $total_om_edy_rli = $total_om_edy_rli + $total_om_rli;
            } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_om_edy_bmu = $total_om_edy_bmu + $total_om_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_om_map_bmu = $total_om_map_bmu + $total_om_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_om_eki_bangunan_bmu = $total_om_eki_bangunan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                $total_om_soma_bmu = $total_om_soma_bmu + $total_om_bmu;
            } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                $total_om_berkah_bmu = $total_om_berkah_bmu + $total_om_bmu;
            } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                $total_om_syafuan_bmu = $total_om_syafuan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                $total_om_yanti_bmu = $total_om_yanti_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                $total_om_nengah_bmu = $total_om_nengah_bmu + $total_om_bmu;
            } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                $total_om_joko_bmu = $total_om_joko_bmu + $total_om_bmu;
            } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                $total_om_samsul_bmu = $total_om_samsul_bmu + $total_om_bmu;
            } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                $total_om_besi88_bmu = $total_om_besi88_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                $total_om_wayan_bmu = $total_om_wayan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                $total_om_dedi_bmu = $total_om_dedi_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                $total_om_rony_bmu = $total_om_rony_bmu + $total_om_bmu;
            } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                $total_om_azzahra_bmu = $total_om_azzahra_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                $total_om_sony_bmu = $total_om_sony_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                $total_om_ahmad_bmu = $total_om_ahmad_bmu + $total_om_bmu;
            } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                $total_om_samsun_bmu = $total_om_samsun_bmu + $total_om_bmu;
            }
        } else if ($kota == 'KAB. LAMPUNG BARAT') {


            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_bmu = $qty * $tarif_200;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_bmu = $qty * $tarif_200;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                $total_om_edy_rli = $total_om_edy_rli + $total_om_rli;
            } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_om_edy_bmu = $total_om_edy_bmu + $total_om_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_om_map_bmu = $total_om_map_bmu + $total_om_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_om_eki_bangunan_bmu = $total_om_eki_bangunan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                $total_om_soma_bmu = $total_om_soma_bmu + $total_om_bmu;
            } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                $total_om_berkah_bmu = $total_om_berkah_bmu + $total_om_bmu;
            } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                $total_om_syafuan_bmu = $total_om_syafuan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                $total_om_yanti_bmu = $total_om_yanti_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                $total_om_nengah_bmu = $total_om_nengah_bmu + $total_om_bmu;
            } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                $total_om_joko_bmu = $total_om_joko_bmu + $total_om_bmu;
            } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                $total_om_samsul_bmu = $total_om_samsul_bmu + $total_om_bmu;
            } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                $total_om_besi88_bmu = $total_om_besi88_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                $total_om_wayan_bmu = $total_om_wayan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                $total_om_dedi_bmu = $total_om_dedi_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                $total_om_rony_bmu = $total_om_rony_bmu + $total_om_bmu;
            } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                $total_om_azzahra_bmu = $total_om_azzahra_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                $total_om_sony_bmu = $total_om_sony_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                $total_om_ahmad_bmu = $total_om_ahmad_bmu + $total_om_bmu;
            } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                $total_om_samsun_bmu = $total_om_samsun_bmu + $total_om_bmu;
            }
        } else if ($kota == 'KAB.PESISIR BARAT') {


            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_bmu = $qty * $tarif_200;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_bmu = $qty * $tarif_200;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                $total_om_edy_rli = $total_om_edy_rli + $total_om_rli;
            } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_om_edy_bmu = $total_om_edy_bmu + $total_om_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_om_map_bmu = $total_om_map_bmu + $total_om_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_om_eki_bangunan_bmu = $total_om_eki_bangunan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                $total_om_soma_bmu = $total_om_soma_bmu + $total_om_bmu;
            } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                $total_om_berkah_bmu = $total_om_berkah_bmu + $total_om_bmu;
            } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                $total_om_syafuan_bmu = $total_om_syafuan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                $total_om_yanti_bmu = $total_om_yanti_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                $total_om_nengah_bmu = $total_om_nengah_bmu + $total_om_bmu;
            } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                $total_om_joko_bmu = $total_om_joko_bmu + $total_om_bmu;
            } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                $total_om_samsul_bmu = $total_om_samsul_bmu + $total_om_bmu;
            } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                $total_om_besi88_bmu = $total_om_besi88_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                $total_om_wayan_bmu = $total_om_wayan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                $total_om_dedi_bmu = $total_om_dedi_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                $total_om_rony_bmu = $total_om_rony_bmu + $total_om_bmu;
            } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                $total_om_azzahra_bmu = $total_om_azzahra_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                $total_om_sony_bmu = $total_om_sony_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                $total_om_ahmad_bmu = $total_om_ahmad_bmu + $total_om_bmu;
            } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                $total_om_samsun_bmu = $total_om_samsun_bmu + $total_om_bmu;
            }
        } else if ($kota == 'KAB. LAMPUNG TIMUR') {


            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_om_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_kso WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_om_bmu = $qty * $tarif_600;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI') {
                $total_om_edy_rli = $total_om_edy_rli + $total_om_rli;
            } else if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'BMU') {
                $total_om_edy_bmu = $total_om_edy_bmu + $total_om_bmu;
            } else if ($pemilik == 'MAP' && $kontrak == 'BMU') {
                $total_om_map_bmu = $total_om_map_bmu + $total_om_bmu;
            } else if ($pemilik == 'Eki Bangunan' && $kontrak == 'BMU') {
                $total_om_eki_bangunan_bmu = $total_om_eki_bangunan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                $total_om_soma_bmu = $total_om_soma_bmu + $total_om_bmu;
            } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                $total_om_berkah_bmu = $total_om_berkah_bmu + $total_om_bmu;
            } else if ($pemilik == 'Syafuan' && $kontrak == 'BMU') {
                $total_om_syafuan_bmu = $total_om_syafuan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Bu Yanti' && $kontrak == 'BMU') {
                $total_om_yanti_bmu = $total_om_yanti_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Nengah' && $kontrak == 'BMU') {
                $total_om_nengah_bmu = $total_om_nengah_bmu + $total_om_bmu;
            } else if ($pemilik == 'Joko' && $kontrak == 'BMU') {
                $total_om_joko_bmu = $total_om_joko_bmu + $total_om_bmu;
            } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                $total_om_samsul_bmu = $total_om_samsul_bmu + $total_om_bmu;
            } else if ($pemilik == 'TB Besi 88' && $kontrak == 'BMU') {
                $total_om_besi88_bmu = $total_om_besi88_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Wayan' && $kontrak == 'BMU') {
                $total_om_wayan_bmu = $total_om_wayan_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Dedi' && $kontrak == 'BMU') {
                $total_om_dedi_bmu = $total_om_dedi_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Rony' && $kontrak == 'BMU') {
                $total_om_rony_bmu = $total_om_rony_bmu + $total_om_bmu;
            } else if ($pemilik == 'Azzahra' && $kontrak == 'BMU') {
                $total_om_azzahra_bmu = $total_om_azzahra_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Sony' && $kontrak == 'BMU') {
                $total_om_sony_bmu = $total_om_sony_bmu + $total_om_bmu;
            } else if ($pemilik == 'Pak Ahmad' && $kontrak == 'BMU') {
                $total_om_ahmad_bmu = $total_om_ahmad_bmu + $total_om_bmu;
            } else if ($pemilik == 'Samsun Taman' && $kontrak == 'BMU') {
                $total_om_samsun_bmu = $total_om_samsun_bmu + $total_om_bmu;
            }
        }
    }


    $total_om_rli = $total_om_edy_rli;
    $total_seluruh_om_bmu =  $total_om_eki_bangunan_bmu + $total_om_soma_bmu + $total_om_berkah_bmu + $total_om_syafuan_bmu + $total_om_yanti_bmu +
        $total_om_nengah_bmu + $total_om_joko_bmu + $total_om_wayan_bmu + $total_om_samsul_bmu + $total_om_besi88_bmu + $total_om_dedi_bmu + $total_om_rony_bmu + $total_om_azzahra_bmu
        + $total_om_sony_bmu + $total_om_ahmad_bmu + $total_om_samsun_bmu;


        
    //Ongkos KSO khusus

    //kota bumi 
    $tabel_om_khusus_kotabumi = mysqli_query($koneksipbj, "SELECT no_polisi, driver, qty FROM pembelian_kota_bumi WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

    $total_om_khusus_rama_bmu_kb = 0;
    $total_om_khusus_gm_bmu_kb = 0;


    while ($data1 = mysqli_fetch_array($tabel_om_khusus_kotabumi)) {

        $no_polisi_ts = $data1['no_polisi'];
        $qty = $data1['qty'];
        $driver = $data1['driver'];

        if ($qty >= 1 && $qty <= 300) {

            $total_om_khusus_bmu_kotabumi = $qty * 7500;
        } else if ($qty > 300 && $qty <= 500) {

            $total_om_khusus_bmu_kotabumi = $qty * 6500;
        } else if ($qty > 500) {

            $total_om_khusus_bmu_kotabumi = $qty * 6500;
        }

        $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
        $data2p = mysqli_fetch_array($table2p);
        if (isset($data2p['status_kendaraan'])) {
            $pemilik = $data2p['status_kendaraan'];
            $kontrak = $data2p['kontrak'];
        } else {
            $pemilik = '';
            $kontrak = '';
        }



        if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
            $total_om_khusus_rama_bmu_kb = $total_om_khusus_rama_bmu_kb + $total_om_khusus_bmu_kotabumi;
        } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
            $total_om_khusus_gm_bmu_kb = $total_om_khusus_gm_bmu_kb + $total_om_khusus_bmu_kotabumi;
        } 

    }
    $total_om_khusus_kotabumi = $total_om_khusus_rama_bmu_kb  + $total_om_khusus_gm_bmu_kb;


    //lamteng
    $tabel_om_khusus_lamteng = mysqli_query($koneksipbj, "SELECT no_polisi, driver, qty FROM pembelian_lamteng WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

    $total_om_khusus_rama_bmu_lamteng = 0;
    $total_om_khusus_gm_bmu_lamteng = 0;

    while ($data1 = mysqli_fetch_array($tabel_om_khusus_lamteng)) {

        $no_polisi_ts = $data1['no_polisi'];
        $qty = $data1['qty'];
        $driver = $data1['driver'];

        if ($qty >= 1 && $qty <= 300) {

            $total_om_khusus_bmu_lamteng = $qty * 8500;
        } else if ($qty > 300 && $qty <= 500) {

            $total_om_khusus_bmu_lamteng = $qty * 7500;
        } else if ($qty > 500) {

            $total_om_khusus_bmu_lamteng = $qty * 7500;
        }

        $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
        $data2p = mysqli_fetch_array($table2p);
        if (isset($data2p['status_kendaraan'])) {
            $pemilik = $data2p['status_kendaraan'];
            $kontrak = $data2p['kontrak'];
        } else {
            $pemilik = '';
            $kontrak = '';
        }



        if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
            $total_om_khusus_rama_bmu_lamteng = $total_om_khusus_rama_bmu_lamteng + $total_om_khusus_bmu_lamteng;
        } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
            $total_om_khusus_gm_bmu_lamteng = $total_om_khusus_gm_bmu_lamteng + $total_om_khusus_bmu_lamteng;
        } 
    }

    $total_om_khusus_lamteng =  $total_om_khusus_rama_bmu_lamteng  + $total_om_khusus_gm_bmu_lamteng;


//OM angkutan / pranko
    $table1_om = mysqli_query($koneksipbj, "SELECT no_polisi, kota, qty, tujuan FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'Pranko' OR  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'FRC'  ");

    $total_om_khusus_rama_bmu = 0;
    $total_om_khusus_gm_bmu = 0;

    while ($data1 = mysqli_fetch_array($table1_om)) {


        $kota = $data1['kota'];
        $qty = $data1['qty'];
        $tujuan = $data1['tujuan'];

        //kak nyoman
        if ($kota == 'KAB OKU TIMUR') {

            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_om_khusus_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_khusus_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_om_khusus_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_om_khusus_bmu = $qty * $tarif_600;
            }



            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);


            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_om_khusus_rama_bmu = $total_om_khusus_rama_bmu + $total_om_khusus_bmu;
            } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                $total_om_khusus_gm_bmu = $total_om_khusus_gm_bmu + $total_om_khusus_bmu;
            } 

        } else if ($kota == 'KAB MESUJI') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_om_khusus_rli = $qty * $tarif;


            //BMU 20ton
            if ($qty >= 1 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_om_khusus_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_om_khusus_bmu = $qty * $tarif_600;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            $pemilik = 0;
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_om_khusus_rama_bmu = $total_om_khusus_rama_bmu + $total_om_khusus_bmu;
            } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                $total_om_khusus_gm_bmu = $total_om_khusus_gm_bmu + $total_om_khusus_bmu;
            } 

        } else if ($kota == 'KAB. TULANG BAWANG') {


            if ($tujuan == 'GDG PT PBJ TUBA 3') {


                //BMU 10ton
                if ($qty >= 1 && $qty <= 300) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso_khusus WHERE nama_wilayah  = 'RAWAJITU SELATAN' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_om_khusus_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso_khusus WHERE nama_wilayah  = 'RAWAJITU SELATAN' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_400 = $data3p['tarif_400'];
                    $total_om_khusus_bmu = $qty * $tarif_400;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_kso_khusus WHERE nama_wilayah  = 'RAWAJITU SELATAN' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_600 = $data3p['tarif_600'];
                    $total_om_khusus_bmu = $qty * $tarif_600;
                }

                $no_polisi = trim($data1["no_polisi"]);
                $no_polisi_ts = str_replace(" ", "", $no_polisi);

                $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
                $data2p = mysqli_fetch_array($table2p);
                if (isset($data2p['status_kendaraan'])) {
                    $pemilik = $data2p['status_kendaraan'];
                    $kontrak = $data2p['kontrak'];
                } else {
                    $pemilik = '';
                    $kontrak = '';
                }

                if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                    $total_om_khusus_rama_bmu = $total_om_khusus_rama_bmu + $total_om_khusus_bmu;
                } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                    $total_om_khusus_gm_bmu = $total_om_khusus_gm_bmu + $total_om_khusus_bmu;
                } 
                
            } else {
                //RLI
                $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
                $data1p = mysqli_fetch_array($table1p);
                $tarif = $data1p['tarif_pranko'];
                $total_om_khusus_rli = $qty * $tarif;

                //BMU 10ton
                if ($qty >= 1 && $qty <= 300) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_om_khusus_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_400 = $data3p['tarif_400'];
                    $total_om_khusus_bmu = $qty * $tarif_400;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_600 = $data3p['tarif_600'];
                    $total_om_khusus_bmu = $qty * $tarif_600;
                }

                $no_polisi = trim($data1["no_polisi"]);
                $no_polisi_ts = str_replace(" ", "", $no_polisi);

                $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
                $data2p = mysqli_fetch_array($table2p);
                if (isset($data2p['status_kendaraan'])) {
                    $pemilik = $data2p['status_kendaraan'];
                    $kontrak = $data2p['kontrak'];
                } else {
                    $pemilik = '';
                    $kontrak = '';
                }

                if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                    $total_om_khusus_rama_bmu = $total_om_khusus_rama_bmu + $total_om_khusus_bmu;
                } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                    $total_om_khusus_gm_bmu = $total_om_khusus_gm_bmu + $total_om_khusus_bmu;
                } 

            }
        } else if ($kota == 'KAB WAY KANAN') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_om_khusus_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_khusus_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_om_khusus_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_om_khusus_bmu = $qty * $tarif_600;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_om_khusus_rama_bmu = $total_om_khusus_rama_bmu + $total_om_khusus_bmu;
            } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                $total_om_khusus_gm_bmu = $total_om_khusus_gm_bmu + $total_om_khusus_bmu;
            } 

        } else if ($kota == 'KAB OKU SELATAN') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_om_khusus_rli = $qty * $tarif;


            if ($tujuan == 'GDG PT PBA MUARA DUA') {

                //BMU 10ton
                if ($qty >= 1 && $qty <= 300) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso_khusus WHERE nama_wilayah  = 'MUARA DUA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_om_khusus_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso_khusus WHERE nama_wilayah  = 'MUARA DUA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_400 = $data3p['tarif_400'];
                    $total_om_khusus_bmu = $qty * $tarif_400;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_kso_khusus WHERE nama_wilayah  = 'MUARA DUA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_600 = $data3p['tarif_600'];
                    $total_om_khusus_bmu = $qty * $tarif_600;
                }

                $no_polisi = trim($data1["no_polisi"]);
                $no_polisi_ts = str_replace(" ", "", $no_polisi);

                $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
                $data2p = mysqli_fetch_array($table2p);
                if (isset($data2p['status_kendaraan'])) {
                    $pemilik = $data2p['status_kendaraan'];
                    $kontrak = $data2p['kontrak'];
                } else {
                    $pemilik = '';
                    $kontrak = '';
                }
                if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                    $total_om_khusus_rama_bmu = $total_om_khusus_rama_bmu + $total_om_khusus_bmu;
                } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                    $total_om_khusus_gm_bmu = $total_om_khusus_gm_bmu + $total_om_khusus_bmu;
                } 

            } else {
                //BMU 10ton
                if ($qty >= 1 && $qty <= 300) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_om_khusus_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_om_khusus_bmu = $qty * $tarif_200;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_om_khusus_bmu = $qty * $tarif_200;
                }




                $no_polisi = trim($data1["no_polisi"]);
                $no_polisi_ts = str_replace(" ", "", $no_polisi);

                $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
                $data2p = mysqli_fetch_array($table2p);
                if (isset($data2p['status_kendaraan'])) {
                    $pemilik = $data2p['status_kendaraan'];
                    $kontrak = $data2p['kontrak'];
                } else {
                    $pemilik = '';
                    $kontrak = '';
                }

                if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                    $total_om_khusus_rama_bmu = $total_om_khusus_rama_bmu + $total_om_khusus_bmu;
                } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                    $total_om_khusus_gm_bmu = $total_om_khusus_gm_bmu + $total_om_khusus_bmu;
                } 

            }
        } else if ($kota == 'KAB. OGAN KOM ULU') {


            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_khusus_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_om_khusus_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_om_khusus_bmu = $qty * $tarif_400;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_om_khusus_rama_bmu = $total_om_khusus_rama_bmu + $total_om_khusus_bmu;
            } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                $total_om_khusus_gm_bmu = $total_om_khusus_gm_bmu + $total_om_khusus_bmu;
            } 

        } else if ($kota == 'KAB. LAMPUNG BARAT') {


            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_khusus_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_khusus_bmu = $qty * $tarif_200;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_khusus_bmu = $qty * $tarif_200;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_om_khusus_rama_bmu = $total_om_khusus_rama_bmu + $total_om_khusus_bmu;
            } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                $total_om_khusus_gm_bmu = $total_om_khusus_gm_bmu + $total_om_khusus_bmu;
            } 

        } else if ($kota == 'KAB.PESISIR BARAT') {


            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_khusus_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_khusus_bmu = $qty * $tarif_200;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_khusus_bmu = $qty * $tarif_200;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_om_khusus_rama_bmu = $total_om_khusus_rama_bmu + $total_om_khusus_bmu;
            } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                $total_om_khusus_gm_bmu = $total_om_khusus_gm_bmu + $total_om_khusus_bmu;
            } 

        } else if ($kota == 'KAB. LAMPUNG TIMUR') {


            //BMU 10ton
            if ($qty >= 1 && $qty <= 300) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_om_khusus_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_om_khusus_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_kso_khusus WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_om_khusus_bmu = $qty * $tarif_600;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Rama' && $kontrak == 'BMU') {
                $total_om_khusus_rama_bmu = $total_om_khusus_rama_bmu + $total_om_khusus_bmu;
            } else if ($pemilik == 'GM Balkom' && $kontrak == 'BMU') {
                $total_om_khusus_gm_bmu = $total_om_khusus_gm_bmu + $total_om_khusus_bmu;
            } 

        }
    }



    $total_seluruh_om_khusus_bmu = $total_om_khusus_rama_bmu + $total_om_khusus_gm_bmu;



    $laba_kotor_sebelum_pajak = $total_pendapatan_bmu +  $total_tagihan_kotabumi + $total_tagihan_lamteng;

    $pph_23 = ($laba_kotor_sebelum_pajak * 2) / 100;

    $pajak = ($laba_kotor_sebelum_pajak * 11) / 100;


    $laba_kotor = (($laba_kotor_sebelum_pajak + $pajak) - $pph_23);

    $total_biaya_usaha_final = $total_gaji + $total_gaji_sl + $total_uj + $total_uj_sl + $biaya_perbaikan_1 + $biaya_perbaikan_2 + $total_kredit_kendaraan + $total_seluruh_om_bmu + $total_om_lamteng + $total_om_kotabumi + $total_seluruh_om_khusus_bmu
                                + $total_om_khusus_kotabumi + $total_om_khusus_lamteng;

    $laba_bersih_sebelum_pajak = $laba_kotor - $total_biaya_usaha_final;

    $table1001 =  mysqli_query($koneksipbj, "SELECT no_polisi FROM kendaraan_sl WHERE status_kendaraan = 'Bapak Nyoman Edi' AND kontrak = 'BMU' ");
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

    <title>Laba Rugi Kendaraan</title>

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
                <div class="sidebar-brand-text mx-3"> <img style="margin-top: 50px; height: 100px; width: 110px; " src="../gambar/Logo PBJ.png"></div>
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
                Menu CV.PBJ (Semen)
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1" 15 aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-building" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">List Company</span>
                </a>
                <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Company</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.CBM/view/DsPTCBM">PT.CBM</a>
                        <a class="collapse-item" style="font-size: 15px;" href="DsPBJ">CV.PBJ</a>
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
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" 15 aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-clipboard-list" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">Report Etty</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Report</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Laporan Penjualan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Laporan Pengiriman</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VKeuangan">Laporan Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluran">Laporan Pengeluaran</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranWorkshop">Pengeluaran Workshop</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3" 15 aria-expanded="true" aria-controls="collapseTwo3">
                    <i class="fa fa-clipboard-list" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">Report Made Dani</span>
                </a>
                <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Report</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenjualanL">Laporan Penjualan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenebusanL">Laporan Penebusan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VSewaHiBlow">Sewa Hiblow</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengirimanL">Laporan Pengiriman</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VKeuanganL">Laporan Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranL">Laporan Pengeluaran</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VTonasePembelian">Tonase Pembelian</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo4xx" 15 aria-expanded="true" aria-controls="collapseTwo4xx">
                    <i class="fa fa-clipboard-list" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">Report Gudang</span>
                </a>
                <div id="collapseTwo4xx" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Report</h6>

                        <a class="collapse-item" style="font-size: 15px;" href="VStokMasuk">Laporan Stok Masuk</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VStokKeluar">Laporan Stok Keluar</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VStokHarian">Laporan Stok Harian</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan">Laporan Keuangan</a>

                    </div>
                </div>
            </li>
            <?php if ($nama == 'Nyoman Edy Susanto') {
                echo "
            <!-- Nav Item - Pages Collapse Menu -->
            <li class='nav-item'>
                <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapseTwo4' 15 aria-expanded='true' aria-controls='collapseTwo4'>
                    <i class='fa fa-clipboard-list' style='font-size: 15px; color:white;'></i>
                    <span style='font-size: 15px; color:white;'>Report Laba Rugi</span>
                </a>
                <div id='collapseTwo4' class='collapse' aria-labelledby='headingTwo' data-parent='#accordionSidebar'>
                    <div class='bg-white py-2 collapse-inner rounded'>
                        <h6 class='collapse-header' style='font-size: 15px;'>Report</h6>
                        <a class='collapse-item' style='font-size: 15px;' href='VLR2LBaru'>Laba Rugi</a>
                        <a class='collapse-item' style='font-size: 15px;' href='VLR2L'>Laba Rugi Back Up</a>
                        <a class='collapse-item' style='font-size: 15px;' href='VLRKendaraan'>Laba Rugi Kendaraan</a>
                        <a class='collapse-item' style='font-size: 15px;' href='VRekapanTagihan'>Rekap Tagihan</a>
                        <a class='collapse-item' style='font-size: 15px;' href='VRekapanHarga'>Rekapan Harga</a>
                        <a class='collapse-item' style='font-size: 15px;' href='VRekapSparepart'>Rekap Sparepart</a>
                        <a class='collapse-item' style='font-size: 15px;' href='VRekapPiutang'>Rekap Piutang</a>
                        <a class='collapse-item' style='font-size: 15px;' href='VPenjualanRegion'>Penjualan Per Region</a>
                    </div>
                </div>
            </li>";
            } ?>






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
                <div class="container" style="color : black;">
                    <?php echo "<form  method='POST' action='VLRKendaraan' style='margin-bottom: 15px;'>" ?>
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
                    <hr>
                    <br>
                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title" align="Center"><strong>Laba Rugi Transport PT PBJ</strong></h3>
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
                                                    <td>4-101</td>
                                                    <td class="text-left">Tagihan BMU Bapak Edy</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_edy_bmu + $total_angkutan_edy_bmu_kb + $total_angkutan_edy_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanEdyBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-102</td>
                                                    <td class="text-left">Tagihan RLI Bapak Edy</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_edy_rli); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanEdy?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-103</td>
                                                    <td class="text-left">Tagihan BMU Bapak Rama</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_rama_bmu + $total_angkutan_rama_bmu_kb + $total_angkutan_rama_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanRamaBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-104</td>
                                                    <td class="text-left">Tagihan BMU Eki Bangunan</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_eki_bangunan_bmu + $total_angkutan_eki_bangunan_bmu_kb + $total_angkutan_eki_bangunan_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanEkiBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-105</td>
                                                    <td class="text-left">Tagihan BMU Soma</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_soma_bmu + $total_angkutan_soma_bmu_kb + $total_angkutan_soma_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanSomaBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-106</td>
                                                    <td class="text-left">Tagihan BMU Berkah</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_berkah_bmu + $total_angkutan_berkah_bmu_kb + $total_angkutan_berkah_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanBerkahBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-107</td>
                                                    <td class="text-left">Tagihan BMU Syafuan</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_syafuan_bmu + $total_angkutan_syafuan_bmu_kb + $total_angkutan_syafuan_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanSyafuanBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-108</td>
                                                    <td class="text-left">Tagihan BMU Yanti</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_yanti_bmu + $total_angkutan_yanti_bmu_kb + $total_angkutan_yanti_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanYantiBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-109</td>
                                                    <td class="text-left">Tagihan BMU Nengah</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_nengah_bmu + $total_angkutan_nengah_bmu_kb + $total_angkutan_nengah_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanNengahBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-110</td>
                                                    <td class="text-left">Tagihan BMU Joko</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_joko_bmu + $total_angkutan_joko_bmu_kb + $total_angkutan_joko_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanJokoBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-111</td>
                                                    <td class="text-left">Tagihan BMU Samsul</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_samsul_bmu + $total_angkutan_samsul_bmu_kb + $total_angkutan_samsul_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanSamsulBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-112</td>
                                                    <td class="text-left">Tagihan BMU Pak Wayan</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_wayan_bmu + $total_angkutan_wayan_bmu_kb + $total_angkutan_wayan_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanWayanBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-113</td>
                                                    <td class="text-left">Tagihan BMU Pak Dedi</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_dedi_bmu + $total_angkutan_dedi_bmu_kb + $total_angkutan_dedi_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanDediBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-114</td>
                                                    <td class="text-left">Tagihan BMU Pak Rony</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_rony_bmu + $total_angkutan_rony_bmu_kb + $total_angkutan_rony_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanRonyBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-115</td>
                                                    <td class="text-left">Tagihan BMU Az zahra</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_azzahra_bmu + $total_angkutan_azzahra_bmu_kb + $total_angkutan_azzahra_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanAzzahraBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-116</td>
                                                    <td class="text-left">Tagihan BMU Pak Ahmad</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_ahmad_bmu + $total_angkutan_ahmad_bmu_kb + $total_angkutan_ahmad_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanAhmadBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-117</td>
                                                    <td class="text-left">Tagihan BMU GM Balkom</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_gm_bmu + $total_angkutan_gm_bmu_kb + $total_angkutan_gm_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanGMBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-118</td>
                                                    <td class="text-left">Tagihan BMU Samsun Taman</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_samsun_bmu + $total_angkutan_samsun_bmu_kb + $total_angkutan_samsun_bmu_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanSamsunBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-119</td>
                                                    <td class="text-left">Total Tagihan BMU Global</td>
                                                    <td class="text-left"><?= formatuang($total_pendapatan_bmu); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanGlobal?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-120</td>
                                                    <td class="text-left">Total Tagihan BMU Kota Bumi</td>
                                                    <td class="text-left"><?= formatuang($total_tagihan_kotabumi); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanKBBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-121</td>
                                                    <td class="text-left">Total Tagihan BMU Lamteng</td>
                                                    <td class="text-left"><?= formatuang($total_tagihan_lamteng); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanLamteng?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
                                                </tr>
                                                <tr style="background-color: navy;  color:white;">
                                                    <td><strong>TOTAL LABA KOTOR</strong></td>
                                                    <td class="thick-line"></td>
                                                    <td class="no-line text-left"><?= formatuang($laba_kotor_sebelum_pajak); ?> </td>
                                                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                                                    <td class="thick-line"></td>
                                                </tr>
                                                <tr style="background-color: navy;  color:white;">
                                                    <td><strong>PPN 11%</strong></td>
                                                    <td class="thick-line"></td>
                                                    <td class="no-line text-left"><?= formatuang($pajak); ?> </td>
                                                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                                                    <td class="thick-line"></td>
                                                </tr>
                                                <tr style="background-color: navy;  color:white;">
                                                    <td><strong>PPH 23 2%</strong></td>
                                                    <td class="thick-line"></td>
                                                    <td class="no-line text-left"><?= formatuang($pph_23); ?> </td>
                                                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                                                    <td class="thick-line"></td>
                                                </tr>
                                                <tr style="background-color: navy;  color:white;">
                                                    <td><strong>TOTAL LABA KOTOR + Pajak 11%</strong></td>
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
                                                    <td>5-512</td>
                                                    <td class="text-left">Gaji Driver</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_gaji + $total_gaji_sl); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRGaji?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-513</td>
                                                    <td class="text-left">Uang Jalan</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_uj + $total_uj_sl); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRUJ?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-595</td>
                                                    <td class="text-left">Perbaikan Kendaraan</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($biaya_perbaikan_1 + $biaya_perbaikan_2); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRPerbaikan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                 <tr>
                                                    <td>4-103</td>
                                                    <td class="text-left">OM BMU Bapak Rama</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_khusus_rama_bmu + $total_om_khusus_rama_bmu_kb + $total_om_khusus_rama_bmu_lamteng); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMRamaBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-104</td>
                                                    <td class="text-left">OM BMU Eki Bangunan</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_eki_bangunan_bmu + $total_om_eki_bangunan_bmu_kb + $total_om_eki_bangunan_bmu_lamteng); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMEkiBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-105</td>
                                                    <td class="text-left">OM BMU Soma</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_soma_bmu + $total_om_soma_bmu_kb + $total_om_soma_bmu_lamteng); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMSomaBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-106</td>
                                                    <td class="text-left">OM BMU Berkah</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_berkah_bmu + $total_om_berkah_bmu_kb + $total_om_berkah_bmu_lamteng); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMBerkahBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-107</td>
                                                    <td class="text-left">OM BMU Syafuan</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_syafuan_bmu + $total_om_syafuan_bmu_kb + $total_om_syafuan_bmu_lamteng); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMSyafuanBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-108</td>
                                                    <td class="text-left">OM BMU Yanti</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_yanti_bmu + $total_om_yanti_bmu_kb + $total_om_yanti_bmu_lamteng); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMYantiBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-109</td>
                                                    <td class="text-left">OM BMU Nengah</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_nengah_bmu + $total_om_nengah_bmu_kb + $total_om_nengah_bmu_lamteng); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMNengahBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-110</td>
                                                    <td class="text-left">OM BMU Joko</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_joko_bmu + $total_om_joko_bmu_kb + $total_om_joko_bmu_lamteng); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMJokoBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-111</td>
                                                    <td class="text-left">OM BMU Samsul</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_samsul_bmu + $total_om_samsul_bmu_kb + $total_om_samsul_bmu_lamteng); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMSamsulBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-112</td>
                                                    <td class="text-left">OM BMU Pak Wayan</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_wayan_bmu + $total_om_wayan_bmu_kb + $total_om_wayan_bmu_lamteng); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMWayanBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-113</td>
                                                    <td class="text-left">OM BMU Pak Dedi</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_dedi_bmu + $total_om_dedi_bmu_kb + $total_om_dedi_bmu_lamteng); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMDediBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-114</td>
                                                    <td class="text-left">OM BMU Pak Rony</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_rony_bmu + $total_om_rony_bmu_kb + $total_om_rony_bmu_lamteng); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMRonyBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-115</td>
                                                    <td class="text-left">OM BMU Az zahra</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_azzahra_bmu + $total_om_azzahra_bmu_kb + $total_om_azzahra_bmu_lamteng); ?></td>                                                
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMAzzahraBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-116</td>
                                                    <td class="text-left">OM BMU Pak Ahmad</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_ahmad_bmu + $total_om_ahmad_bmu_kb + $total_om_ahmad_bmu_lamteng); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMAhmadBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-117</td>
                                                    <td class="text-left">OM BMU GM Balkom</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_khusus_gm_bmu + $total_om_khusus_gm_bmu_kb + $total_om_khusus_gm_bmu_lamteng); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMGMBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-118</td>
                                                    <td class="text-left">OM BMU Samsun Taman</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_samsun_bmu + $total_om_samsun_bmu_kb + $total_om_samsun_bmu_lamteng); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMSamsunBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-119</td>
                                                    <td class="text-left">Total OM BMU Global</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_seluruh_om_bmu + $total_seluruh_om_khusus_bmu); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMGlobal?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-120</td>
                                                    <td class="text-left">Total OM BMU Kota Bumi</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_kotabumi + $total_om_khusus_kotabumi); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMKBBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-121</td>
                                                    <td class="text-left">Total OM BMU Lamteng</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om_lamteng + $total_om_khusus_lamteng); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROMLamteng?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-597</td>
                                                    <td class="text-left">Kredit Kendaraan</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_kredit_kendaraan); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRKredit?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
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

                                                    <?php } else if ($laba_bersih_sebelum_pajak == 0) { ?>

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
                    <h3 class="text-center">Laba Rugi Kendaraan Pak Nyoman Edi</h3>
                    <table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">No Polisi</th>
                                <th class="text-center">Rincian</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no_urut = 0;
                            ?>
                            <?php while ($data = mysqli_fetch_array($table1001)) {
                                $no_polisi = $data['no_polisi'];
                                $no_urut = $no_urut + 1;

                                echo "<tr>
                                    <td style='font-size: 14px' align = 'center'>$no_urut</td>
                                    <td style='font-size: 14px' align = 'center'>$no_polisi</td>" ?>
                                <?php echo "<td class='text-center'><a href='VLRPerKendaraan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&no_polisi=$no_polisi'>LR Kendaraan</a></td>"; ?>



                            <?php echo  " </tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                    <br>
                    <br>

                    <br>
                    <br>



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