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
    
    //kota bumi
    $tabel_kotabumi = mysqli_query($koneksipbj, "SELECT no_polisi, driver, qty FROM pembelian_kota_bumi WHERE tanggal = '$tanggal_awal' ");

    $total_angkutan_edy_bmu_kb = 0;
    $total_angkutan_rama_bmu_kb = 0;
    $total_angkutan_soma_bmu_kb = 0;
    $total_angkutan_berkah_bmu_kb = 0;
    $total_angkutan_map_bmu_kb = 0;
    
    while ($data1 = mysqli_fetch_array($tabel_kotabumi)) {

        $no_polisi_ts = $data1['no_polisi'];
        $qty = $data1['qty'];
        $driver = $data1['driver'];

        if ($qty >= 200 && $qty <= 300) {
    
            $total_angkut_bmu_kotabumi = $qty * 8149;
        }

        else if ($qty > 300 && $qty <= 500) {
               
            $total_angkut_bmu_kotabumi = $qty * 7238;
        }

        else if ($qty > 500) {
               
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
            } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                $total_angkutan_soma_bmu_kb = $total_angkutan_soma_bmu_kb + $total_angkut_bmu_kotabumi;
            } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                $total_angkutan_berkah_bmu_kb = $total_angkutan_berkah_bmu_kb + $total_angkut_bmu_kotabumi;
            } 
            
}

    //Untung angkutan / pranko
    $table1 = mysqli_query($koneksipbj, "SELECT no_polisi, kota, qty, tujuan FROM pembelian_sl WHERE tanggal = '$tanggal_awal' AND tipe_semen = 'Pranko'  OR tanggal = '$tanggal_awal' AND tipe_semen = 'FRC'  ");
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
    $total_angkutan_kustomo_bmu = 0;
    $total_angkutan_kodri_bmu = 0;
    $total_angkutan_samsul_bmu = 0;
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
            if ($qty >= 200 && $qty <= 300) {

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
            } else if ($pemilik == 'Kodri' && $kontrak == 'BMU') {
                $total_angkutan_kodri_bmu = $total_angkutan_kodri_bmu + $total_angkut_bmu;
            }
        } else if ($kota == 'KAB MESUJI') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 200 && $qty <= 300) {

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
            } else if ($pemilik == 'Kustomo' && $kontrak == 'BMU') {
                $total_angkutan_kustomo_bmu = $total_angkutan_kustomo_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Kodri' && $kontrak == 'BMU') {
                $total_angkutan_kodri_bmu = $total_angkutan_kodri_bmu + $total_angkut_bmu;
            }
        } else if ($kota == 'KAB. TULANG BAWANG') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 200 && $qty <= 300) {

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
            } else if ($pemilik == 'Kodri' && $kontrak == 'BMU') {
                $total_angkutan_kodri_bmu = $total_angkutan_kodri_bmu + $total_angkut_bmu;
            }
        } else if ($kota == 'KAB WAY KANAN') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 200 && $qty <= 300) {

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
            } else if ($pemilik == 'Kodri' && $kontrak == 'BMU') {
                $total_angkutan_kodri_bmu = $total_angkutan_kodri_bmu + $total_angkut_bmu;
            }
        } else if ($kota == 'KAB OKU SELATAN') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            if (
                $tujuan == 'TK BESI 88' || $tujuan == 'TB BERKAH' || $tujuan == 'EKA JAYA' || $tujuan == 'ANUGRAH' ||
                $tujuan == 'TB MANDIRI JAYA' || $tujuan == 'ANEKA JAYA' || $tujuan == 'ANEKA BAUT' || $tujuan == 'SUMBER ANUGRAH' || $tujuan == 'RIZKY' || $tujuan == 'PUTRA LIWA'
            ) {

                //BMU 10ton
                if ($qty >= 200 && $qty <= 300) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_angkut_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_400 = $data3p['tarif_400'];
                    $total_angkut_bmu = $qty * $tarif_400;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_600 = $data3p['tarif_600'];
                    $total_angkut_bmu = $qty * $tarif_600;
                }
            } else {

                //BMU 10ton
                if ($qty >= 200 && $qty <= 300) {

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
            } else if ($pemilik == 'Kodri' && $kontrak == 'BMU') {
                $total_angkutan_kodri_bmu = $total_angkutan_kodri_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                $total_angkutan_samsul_bmu = $total_angkutan_samsul_bmu + $total_angkut_bmu;
            }
        }
    }



    $total_pendapatan_rli = $total_angkutan_edy_rli;
    $total_pendapatan_bmu = $total_angkutan_edy_bmu + $total_angkutan_rama_bmu + $total_angkutan_eki_bangunan_bmu + $total_angkutan_soma_bmu + $total_angkutan_berkah_bmu + $total_angkutan_syafuan_bmu;
} else {


    //kota bumi
    $tabel_kotabumi = mysqli_query($koneksipbj, "SELECT no_polisi, driver, qty FROM pembelian_kota_bumi WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

    $total_angkutan_edy_bmu_kb = 0;
    $total_angkutan_rama_bmu_kb = 0;
    $total_angkutan_soma_bmu_kb = 0;
    $total_angkutan_berkah_bmu_kb = 0;
    $total_angkutan_map_bmu_kb = 0;
    
    while ($data1 = mysqli_fetch_array($tabel_kotabumi)) {

        $no_polisi_ts = $data1['no_polisi'];
        $qty = $data1['qty'];
        $driver = $data1['driver'];

        if ($qty >= 200 && $qty <= 300) {
    
            $total_angkut_bmu_kotabumi = $qty * 8149;
        }

        else if ($qty > 300 && $qty <= 500) {
               
            $total_angkut_bmu_kotabumi = $qty * 7238;
        }

        else if ($qty > 500) {
               
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
            } else if ($pemilik == 'Soma' && $kontrak == 'BMU') {
                $total_angkutan_soma_bmu_kb = $total_angkutan_soma_bmu_kb + $total_angkut_bmu_kotabumi;
            } else if ($pemilik == 'Berkah' && $kontrak == 'BMU') {
                $total_angkutan_berkah_bmu_kb = $total_angkutan_berkah_bmu_kb + $total_angkut_bmu_kotabumi;
            } 
            
        }


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
    $total_angkutan_kustomo_bmu = 0;
    $total_angkutan_kodri_bmu = 0;
    $total_angkutan_map_bmu = 0;
    $total_angkutan_samsul_bmu = 0;
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
            if ($qty >= 200 && $qty <= 300) {

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
            } else if ($pemilik == 'Kodri' && $kontrak == 'BMU') {
                $total_angkutan_kodri_bmu = $total_angkutan_kodri_bmu + $total_angkut_bmu;
            }
        } else if ($kota == 'KAB MESUJI') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;


            //BMU 20ton
            if ($qty >= 200 && $qty <= 500) {

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
            } else if ($pemilik == 'Kustomo' && $kontrak == 'BMU') {
                $total_angkutan_kustomo_bmu = $total_angkutan_kustomo_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Kodri' && $kontrak == 'BMU') {
                $total_angkutan_kodri_bmu = $total_angkutan_kodri_bmu + $total_angkut_bmu;
            }
        } else if ($kota == 'KAB. TULANG BAWANG') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 200 && $qty <= 300) {

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
            } else if ($pemilik == 'Kodri' && $kontrak == 'BMU') {
                $total_angkutan_kodri_bmu = $total_angkutan_kodri_bmu + $total_angkut_bmu;
            }
        } else if ($kota == 'KAB WAY KANAN') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 200 && $qty <= 300) {

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
            } else if ($pemilik == 'Kodri' && $kontrak == 'BMU') {
                $total_angkutan_kodri_bmu = $total_angkutan_kodri_bmu + $total_angkut_bmu;
            }
        } else if ($kota == 'KAB OKU SELATAN') {
            //RLI
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            if (
                $tujuan == 'TK BESI 88' || $tujuan == 'TB BERKAH' || $tujuan == 'EKA JAYA' || $tujuan == 'ANUGRAH' ||
                $tujuan == 'TB MANDIRI JAYA' || $tujuan == 'ANEKA JAYA' || $tujuan == 'ANEKA BAUT' || $tujuan == 'SUMBER ANUGRAH' || $tujuan == 'RIZKY' || $tujuan == 'PUTRA LIWA'
            ) {

                //BMU 10ton
                if ($qty >= 200 && $qty <= 300) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_angkut_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_400 = $data3p['tarif_400'];
                    $total_angkut_bmu = $qty * $tarif_400;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksipbj, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_600 = $data3p['tarif_600'];
                    $total_angkut_bmu = $qty * $tarif_600;
                }
            } else {

                //BMU 10ton
                if ($qty >= 200 && $qty <= 300) {

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
            } else if ($pemilik == 'Kodri' && $kontrak == 'BMU') {
                $total_angkutan_kodri_bmu = $total_angkutan_kodri_bmu + $total_angkut_bmu;
            } else if ($pemilik == 'Samsul' && $kontrak == 'BMU') {
                $total_angkutan_samsul_bmu = $total_angkutan_samsul_bmu + $total_angkut_bmu;
            }
            
        }
    }


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
    if($no_polisi == 'BG8344YC' ||$no_polisi == 'BG8370YC' ||$no_polisi == 'BG8971YB' ||$no_polisi == 'BG8521YB' ||$no_polisi == 'BG8251YC' ||$no_polisi == 'BG8101YA' ||$no_polisi == 'BG8694YA' ||$no_polisi == 'BG8930VA' ||$no_polisi == 'BG8221YD' ||
    $no_polisi == 'BG8223YD' ||$no_polisi == 'BG8224YD' ||$no_polisi == 'BG8225YD' ||$no_polisi == 'BG8226YD' ||$no_polisi == 'BG8227YD' ||$no_polisi == 'BG8876UY' ||$no_polisi == 'BG8515YB' ||$no_polisi == 'BG8969YB' ||$no_polisi == 'BG8101YB' ||
    $no_polisi == 'BG8252YC' ||$no_polisi == 'BG8376YB' ||$no_polisi == 'BG8970YB' ||$no_polisi == 'BG8231KN' ||$no_polisi == 'BE9789AV' ||$no_polisi == 'BE9816AV' ||$no_polisi == 'BG8405YB' ||$no_polisi == 'BG8965V' ||$no_polisi == 'BG8966V' ||
    $no_polisi == 'BG8884UY' ||$no_polisi == 'BG1718XL' ||$no_polisi == 'BG1705XL' ||$no_polisi == 'BG1707XL' ||$no_polisi == 'BG1759XL' ||$no_polisi == 'BG1726XL' ||$no_polisi == 'BG1725XL' ||$no_polisi == 'BG1703XL' ||$no_polisi == 'BG1778XL' ||
    $no_polisi == 'BG1678XL' ||$no_polisi == 'BG1765XL'){
        $total_uj = $total_uj + $uj;
        $total_gaji = $total_gaji + $ug;
        $total_om = $total_om + $om;
    }
    else{

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
    if($no_polisi == 'BG8344YC' ||$no_polisi == 'BG8370YC' ||$no_polisi == 'BG8971YB' ||$no_polisi == 'BG8521YB' ||$no_polisi == 'BG8251YC' ||$no_polisi == 'BG8101YA' ||$no_polisi == 'BG8694YA' ||$no_polisi == 'BG8930VA' ||$no_polisi == 'BG8221YD' ||
    $no_polisi == 'BG8223YD' ||$no_polisi == 'BG8224YD' ||$no_polisi == 'BG8225YD' ||$no_polisi == 'BG8226YD' ||$no_polisi == 'BG8227YD' ||$no_polisi == 'BG8876UY' ||$no_polisi == 'BG8515YB' ||$no_polisi == 'BG8969YB' ||$no_polisi == 'BG8101YB' ||
    $no_polisi == 'BG8252YC' ||$no_polisi == 'BG8376YB' ||$no_polisi == 'BG8970YB' ||$no_polisi == 'BG8231KN' ||$no_polisi == 'BE9789AV' ||$no_polisi == 'BE9816AV' ||$no_polisi == 'BG8405YB' ||$no_polisi == 'BG8965V' ||$no_polisi == 'BG8966V' ||
    $no_polisi == 'BG8884UY' ||$no_polisi == 'BG1718XL' ||$no_polisi == 'BG1705XL' ||$no_polisi == 'BG1707XL' ||$no_polisi == 'BG1759XL' ||$no_polisi == 'BG1726XL' ||$no_polisi == 'BG1725XL' ||$no_polisi == 'BG1703XL' ||$no_polisi == 'BG1778XL' ||
    $no_polisi == 'BG1678XL' ||$no_polisi == 'BG1765XL'){
        $total_uj_sl = $total_uj_sl + $uj;
        $total_gaji_sl = $total_gaji_sl + $ug;
        $total_om_sl = $total_om_sl + $om;
    }
    else{
        
    }
    }

        
    //pengiriman 1 bs
    $table2x = mysqli_query($koneksipbj, "SELECT no_polisi, driver, SUM(bs) as total_bs  FROM pengiriman_s WHERE tanggal_antar  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'Pranko' GROUP BY no_polisi ");
    $total_bs = 0;

    while ($data2x = mysqli_fetch_array($table2x)) {
    $no_polisi = $data2x['no_polisi'];
    $bs = $data2x['total_bs'];
    if($no_polisi == 'BG8344YC' ||$no_polisi == 'BG8370YC' ||$no_polisi == 'BE8266WY' ||$no_polisi == 'BE8294WV' ||$no_polisi == 'Z9888DD' ||$no_polisi == 'BG8135FS' ||$no_polisi == 'BG8165FN' ||$no_polisi == 'BE8670HU' ||$no_polisi == 'BG8297CE' ||
    $no_polisi == 'BG8837CE' ||$no_polisi == 'BG8220V' ||$no_polisi == 'BG8290VA' ||$no_polisi == 'B9052VDA' ||$no_polisi == 'BE8770GB' ||$no_polisi == 'BG8454UH' ||$no_polisi == 'BG8970FO' ||$no_polisi == 'BG8805NM' ||$no_polisi == 'BG8045YC' ||
    $no_polisi == 'BG8651FO' ||$no_polisi == 'BG8608YB' ||$no_polisi == 'BG8971YB' ||$no_polisi == 'BG8220V'||$no_polisi == 'BG8290VA'||$no_polisi == 'BG8297CE'||$no_polisi == 'BG8837CE'||$no_polisi == 'BG8251V' ){
        $total_bs = $total_bs + $bs;
    }
    else{
        
    }
    }

    //pengiriman 2 bs
    $table2slx = mysqli_query($koneksipbj, "SELECT no_polisi, driver, SUM(bs) as total_bs_sl FROM pengiriman_sl WHERE tanggal_antar  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'Pranko' GROUP BY no_polisi");
    $total_bs_sl = 0;

    while ($data2slx = mysqli_fetch_array($table2slx)) {
    $no_polisi = $data2slx['no_polisi'];
    $bs = $data2slx['total_bs_sl'];
    if($no_polisi == 'BG8344YC' ||$no_polisi == 'BG8370YC' ||$no_polisi == 'BE8266WY' ||$no_polisi == 'BE8294WV' ||$no_polisi == 'Z9888DD' ||$no_polisi == 'BG8135FS' ||$no_polisi == 'BG8165FN' ||$no_polisi == 'BE8670HU' ||$no_polisi == 'BG8297CE' ||
    $no_polisi == 'BG8837CE' ||$no_polisi == 'BG8220V' ||$no_polisi == 'BG8290VA' ||$no_polisi == 'B9052VDA' ||$no_polisi == 'BE8770GB' ||$no_polisi == 'BG8454UH' ||$no_polisi == 'BG8970FO' ||$no_polisi == 'BG8805NM' ||$no_polisi == 'BG8045YC' ||
    $no_polisi == 'BG8651FO' ||$no_polisi == 'BG8608YB' ||$no_polisi == 'BG8971YB' ||$no_polisi == 'BG8220V'||$no_polisi == 'BG8290VA'||$no_polisi == 'BG8297CE'||$no_polisi == 'BG8837CE'||$no_polisi == 'BG8251V'){
        $total_bs_sl = $total_bs_sl + $bs;

    }
    else{
        
    }
    }


    //Biaya tarikan etty
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




    $laba_kotor = $total_angkutan_edy_bmu + $total_angkutan_rama_bmu + $total_angkutan_eki_bangunan_bmu + $total_angkutan_soma_bmu + $total_angkutan_berkah_bmu + $total_angkutan_syafuan_bmu + $total_angkutan_edy_rli + $total_angkutan_yanti_bmu +
        $total_angkutan_nengah_bmu + $total_angkutan_joko_bmu + $total_angkutan_kustomo_bmu + $total_angkutan_kodri_bmu + $total_angkutan_edy_bmu_kb + $total_angkutan_rama_bmu_kb + $total_angkutan_soma_bmu_kb + $total_angkutan_berkah_bmu_kb;

    $total_biaya_usaha_final = $total_gaji + $total_gaji_sl + $total_uj + $total_uj_sl + $total_om + $total_om_sl + $total_bs + $total_bs_sl + $jml_biaya_tarikan_sl + $jml_biaya_tarikan_s + $biaya_perbaikan_1 + $biaya_perbaikan_2 + $jml_pembelian_sparepart;

    $laba_bersih_sebelum_pajak = $laba_kotor - $total_biaya_usaha_final;

    $table1001 =  mysqli_query($koneksipbj, "SELECT no_polisi FROM kendaraan_sl_sp WHERE status_kendaraan = 'Bapak Nyoman Edi' AND kontrak = 'BMU' ");
    $table1002 =  mysqli_query($koneksipbj, "SELECT no_polisi FROM kendaraan_sl_sp WHERE status_kendaraan = 'Bapak Nyoman Edi' AND kontrak = 'RLI' ");
    
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
                                                    <td>4-100</td>
                                                    <td class="text-left">Tagihan BMU Bapak Edy</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_edy_bmu + $total_angkutan_edy_bmu_kb); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanEdyBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-101</td>
                                                    <td class="text-left">Tagihan RLI Bapak Edy</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_edy_rli); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanEdy?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-102</td>
                                                    <td class="text-left">Tagihan BMU Bapak Rama</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_rama_bmu + $total_angkutan_rama_bmu_kb); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanRamaBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-103</td>
                                                    <td class="text-left">Tagihan BMU Eki Bangunan</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_eki_bangunan_bmu); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanEkiBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-104</td>
                                                    <td class="text-left">Tagihan BMU Soma</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_soma_bmu + $total_angkutan_soma_bmu_kb); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanSomaBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-105</td>
                                                    <td class="text-left">Tagihan BMU Berkah</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_berkah_bmu + $total_angkutan_berkah_bmu_kb); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanBerkahBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-106</td>
                                                    <td class="text-left">Tagihan BMU Syafuan</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_syafuan_bmu); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanSyafuanBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-106</td>
                                                    <td class="text-left">Tagihan BMU Yanti</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_yanti_bmu); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanYantiBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-106</td>
                                                    <td class="text-left">Tagihan BMU Nengah</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_nengah_bmu); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanNengahBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-106</td>
                                                    <td class="text-left">Tagihan BMU Joko</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_joko_bmu); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanJokoBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-106</td>
                                                    <td class="text-left">Tagihan BMU Kustomo</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_kustomo_bmu); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanKustomoBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-106</td>
                                                    <td class="text-left">Tagihan BMU Kodri</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_kodri_bmu); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanKodriBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-106</td>
                                                    <td class="text-left">Tagihan BMU Samsul</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_samsul_bmu); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRTagihanSamsulBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
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
                                                    <td>5-514</td>
                                                    <td class="text-left">Ongkos Mobil</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om + $total_om_sl); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VROM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-516</td>
                                                    <td class="text-left">Biaya Sewa Mobil Luar</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_bs + $total_bs_sl + $jml_biaya_tarikan_sl + $jml_biaya_tarikan_s); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRBS?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-595</td>
                                                    <td class="text-left">Perbaikan Kendaraan</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($biaya_perbaikan_1 + $biaya_perbaikan_2); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRPerbaikan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-595</td>
                                                    <td class="text-left">Pembalian Sparepart</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($jml_pembelian_sparepart); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRLRKendaraan/VRPembelian?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
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
                                <th class="text-center">Jenis Kendaraan</th>
                                <th></th>
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
                    <h3 class="text-center">Laba Rugi Kendaraan Pak Nyoman Edi</h3>
                    <table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">No Polisi</th>
                                <th class="text-center">Jenis Kendaraan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no_urut = 0;
                            ?>
                            <?php while ($data = mysqli_fetch_array($table1002)) {
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