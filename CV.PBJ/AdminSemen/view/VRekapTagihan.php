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
if ($jabatan_valid == 'Admin Semen') {
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

    //Untung angkutan / pranko
    $table1 = mysqli_query($koneksi, "SELECT no_polisi, kota, qty, tujuan FROM pembelian_sl WHERE tanggal = '$tanggal_awal' AND tipe_semen = 'Pranko'  ");
    $total_angkutan_edy_rli = 0;
    $total_angkutan_edy_bmu = 0;
    $total_angkutan_rama_bmu = 0;
    $total_angkutan_map_bmu = 0;
    $total_angkutan_eki_bangunan_bmu = 0;
    $total_angkutan_soma_bmu = 0;
    $total_angkutan_berkah_bmu = 0;
    $total_angkutan_syafuan_bmu = 0;
    while ($data1 = mysqli_fetch_array($table1)) {


        $kota = $data1['kota'];
        $qty = $data1['qty'];
        $tujuan = $data1['tujuan'];

        //kak nyoman
        if ($kota == 'KAB OKU TIMUR') {

            //RLI
            $table1p = mysqli_query($koneksi, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 200 && $qty <= 300) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_angkut_bmu = $qty * $tarif_600;
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
            }
        } else if ($kota == 'KAB MESUJI') {
            //RLI
            $table1p = mysqli_query($koneksi, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 200 && $qty <= 300) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_angkut_bmu = $qty * $tarif_600;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
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
            }
        } else if ($kota == 'KAB. TULANG BAWANG') {
            //RLI
            $table1p = mysqli_query($koneksi, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 200 && $qty <= 300) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_angkut_bmu = $qty * $tarif_600;
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
            }
        } else if ($kota == 'KAB WAY KANAN') {
            //RLI
            $table1p = mysqli_query($koneksi, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 200 && $qty <= 300) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_angkut_bmu = $qty * $tarif_600;
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
            }
        } else if ($kota == 'KAB OKU SELATAN') {
            //RLI
            $table1p = mysqli_query($koneksi, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            if (
                $tujuan == 'TK BESI 88' || $tujuan == 'TB BERKAH' || $tujuan == 'EKA JAYA' || $tujuan == 'ANUGRAH' ||
                $tujuan == 'TB MANDIRI JAYA' || $tujuan == 'ANEKA JAYA' || $tujuan == 'ANEKA BAUT' || $tujuan == 'SUMBER ANUGRAH' || $tujuan == 'RIZKY' || $tujuan == 'PUTRA LIWA'
            ) {

                //BMU 10ton
                if ($qty >= 200 && $qty <= 300) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_angkut_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_400 = $data3p['tarif_400'];
                    $total_angkut_bmu = $qty * $tarif_400;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_600 = $data3p['tarif_600'];
                    $total_angkut_bmu = $qty * $tarif_600;
                }
            } else {

                //BMU 10ton
                if ($qty >= 200 && $qty <= 300) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_angkut_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_400 = $data3p['tarif_400'];
                    $total_angkut_bmu = $qty * $tarif_400;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_600 = $data3p['tarif_600'];
                    $total_angkut_bmu = $qty * $tarif_600;
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
            }
        }
    }



    $total_pendapatan_rli = $total_angkutan_edy_rli;
    $total_pendapatan_bmu = $total_angkutan_edy_bmu + $total_angkutan_rama_bmu + $total_angkutan_map_bmu + $total_angkutan_eki_bangunan_bmu + $total_angkutan_soma_bmu + $total_angkutan_berkah_bmu + $total_angkutan_syafuan_bmu;
} else {



    //Untung angkutan / pranko
    $table1 = mysqli_query($koneksi, "SELECT no_polisi, kota, qty, tujuan FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'Pranko'  ");
    $total_angkutan_edy_rli = 0;
    $total_angkutan_edy_bmu = 0;
    $total_angkutan_rama_bmu = 0;
    $total_angkutan_map_bmu = 0;
    $total_angkutan_eki_bangunan_bmu = 0;
    $total_angkutan_soma_bmu = 0;
    $total_angkutan_berkah_bmu = 0;
    $total_angkutan_syafuan_bmu = 0;
    while ($data1 = mysqli_fetch_array($table1)) {


        $kota = $data1['kota'];
        $qty = $data1['qty'];
        $tujuan = $data1['tujuan'];

        //kak nyoman
        if ($kota == 'KAB OKU TIMUR') {

            //RLI
            $table1p = mysqli_query($koneksi, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 200 && $qty <= 300) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_angkut_bmu = $qty * $tarif_600;
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

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI' || $pemilik == 'Bapak Nyoman Edi' && $kontrak == '') {
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
            }
        } else if ($kota == 'KAB MESUJI') {
            //RLI
            $table1p = mysqli_query($koneksi, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;


            //BMU 20ton
            if ($qty >= 200 && $qty <= 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_angkut_bmu = $qty * $tarif_600;
            }

            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            $pemilik = 0;
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
                $kontrak = $data2p['kontrak'];
            } else {
                $pemilik = '';
                $kontrak = '';
            }

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI' || $pemilik == 'Bapak Nyoman Edi' && $kontrak == '') {
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
            }
        } else if ($kota == 'KAB. TULANG BAWANG') {
            //RLI
            $table1p = mysqli_query($koneksi, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 200 && $qty <= 300) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_angkut_bmu = $qty * $tarif_600;
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

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI' || $pemilik == 'Bapak Nyoman Edi' && $kontrak == '') {
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
            }
        } else if ($kota == 'KAB WAY KANAN') {
            //RLI
            $table1p = mysqli_query($koneksi, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            //BMU 10ton
            if ($qty >= 200 && $qty <= 300) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_200 = $data3p['tarif_200'];
                $total_angkut_bmu = $qty * $tarif_200;
            }
            //BMU 20ton
            else if ($qty > 300 && $qty <= 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_400 = $data3p['tarif_400'];
                $total_angkut_bmu = $qty * $tarif_400;
            }
            //BMU 30ton
            else if ($qty > 500) {

                $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                $data3p = mysqli_fetch_array($table3p);
                $tarif_600 = $data3p['tarif_600'];
                $total_angkut_bmu = $qty * $tarif_600;
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

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI' || $pemilik == 'Bapak Nyoman Edi' && $kontrak == '') {
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
            }
        } else if ($kota == 'KAB OKU SELATAN') {
            //RLI
            $table1p = mysqli_query($koneksi, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut_rli = $qty * $tarif;

            if (
                $tujuan == 'TK BESI 88' || $tujuan == 'TB BERKAH' || $tujuan == 'EKA JAYA' || $tujuan == 'ANUGRAH' ||
                $tujuan == 'TB MANDIRI JAYA' || $tujuan == 'ANEKA JAYA' || $tujuan == 'ANEKA BAUT' || $tujuan == 'SUMBER ANUGRAH' || $tujuan == 'RIZKY' || $tujuan == 'PUTRA LIWA'
            ) {

                //BMU 10ton
                if ($qty >= 200 && $qty <= 300) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_angkut_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_400 = $data3p['tarif_400'];
                    $total_angkut_bmu = $qty * $tarif_400;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = 'MUARA DUA KOTA' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_600 = $data3p['tarif_600'];
                    $total_angkut_bmu = $qty * $tarif_600;
                }
            } else {

                //BMU 10ton
                if ($qty >= 200 && $qty <= 300) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_200 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_200 = $data3p['tarif_200'];
                    $total_angkut_bmu = $qty * $tarif_200;
                }
                //BMU 20ton
                else if ($qty > 300 && $qty <= 500) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_400 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_400 = $data3p['tarif_400'];
                    $total_angkut_bmu = $qty * $tarif_400;
                }
                //BMU 30ton
                else if ($qty > 500) {

                    $table3p = mysqli_query($koneksi, "SELECT tarif_600 FROM tarif_bmu WHERE nama_wilayah  = '$kota' ");
                    $data3p = mysqli_fetch_array($table3p);
                    $tarif_600 = $data3p['tarif_600'];
                    $total_angkut_bmu = $qty * $tarif_600;
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

            if ($pemilik == 'Bapak Nyoman Edi' && $kontrak == 'RLI' || $pemilik == 'Bapak Nyoman Edi' && $kontrak == '') {
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
            }
        }
    }



    $total_pendapatan_rli = $total_angkutan_edy_rli;
    $total_pendapatan_bmu = $total_angkutan_edy_bmu + $total_angkutan_rama_bmu + $total_angkutan_map_bmu + $total_angkutan_eki_bangunan_bmu + $total_angkutan_soma_bmu + $total_angkutan_berkah_bmu + $total_angkutan_syafuan_bmu;
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKasir">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3"> <img style="margin-top: 50px; height: 100px; width: 110px; " src="../gambar/Logo PBJ.PNG"></div>
            </a>
            <br>

            <br>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="DsAdminSemen">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 16px;">Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading" style="font-size: 15px; color:white;">
                ADMIN SEMEN
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" 15 aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">Kasir</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Kasir</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Penjualan Semen</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPiutang">Piutang Semen</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Pengiriman</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenebusan">Penebusan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaran">Pengeluaran</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan">Laporan Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapDoPenjualanL">Rekap DO Penjualan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapDoPembelian">Rekap DO Pembelian</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPotonganHarga">Potongan Harga</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitDriver">Laporan Rit</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VSewaHiBlow">Uang Sewa Hi Blow</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VFilePBJ">File PBJ</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VStokGudang">Stok Gudang</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapTagihan">Rekap Tagihan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapPiutang">Rekap Piutang</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1" 15 aria-expanded="true" aria-controls="collapseTwo1">
                    <i class="fas fa-truck-moving" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">SDM</span>
                </a>
                <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VKendaraan">Kendaraan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VDriverSemen">List Driver</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VTokoDO">List Toko DO</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VListKota">List Kota</a>
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
                <div class="container" style="color : black;">
                    <?php echo "<form  method='POST' action='VRekapTagihan' style='margin-bottom: 15px;'>" ?>
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
                                    <h3 class="panel-title" align="Center"><strong>Tagihan BMU PT PBJ</strong></h3>
                                </div>

                                <div>

                                </div>



                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed" style="color : black;">
                                            <thead>
                                                <tr>
                                                    <td><strong>No</strong></td>
                                                    <td class="text-left"><strong>Nama Pemilik</strong></td>
                                                    <td class="text-left"><strong>Total Tagihan</strong></td>
                                                    <td class="text-right"><strong>Aksi</strong></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td class="text-left">Tagihan BMU Bapak Edy</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_edy_bmu); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianRLI/VRTagihanEdyBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td class="text-left">Tagihan BMU Bapak Rama</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_rama_bmu); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianRLI/VRTagihanRamaBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td class="text-left">Tagihan BMU MAP</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_map_bmu); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianRLI/VRTagihanMapBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td class="text-left">Tagihan BMU Eki Bangunan</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_eki_bangunan_bmu); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianRLI/VRTagihanEkiBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td class="text-left">Tagihan BMU Soma</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_soma_bmu); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianRLI/VRTagihanSomaBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td class="text-left">Tagihan BMU Berkah</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_berkah_bmu); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianRLI/VRTagihanBerkahBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td class="text-left">Tagihan BMU Syafuan</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_syafuan_bmu); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianRLI/VRTagihanSyafuanBMU?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td class="thick-line"></td>
                                                    <td class="no-line text-left"></td>
                                                    <td class="no-line text-left"></td>
                                                    <td class="thick-line"></td>
                                                </tr>
                                                <tr style="background-color: navy;  color:white;">
                                                    <td><strong>TOTAL TAGIHAN RLI</strong></td>
                                                    <td class="thick-line"></td>
                                                    <td class="no-line text-left"><?= formatuang($total_pendapatan_bmu); ?> </td>
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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title" align="Center"><strong>Tagihan RLI PT PBJ</strong></h3>
                                </div>

                                <div>

                                </div>



                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed" style="color : black;">
                                            <thead>
                                                <tr>
                                                    <td><strong>No</strong></td>
                                                    <td class="text-left"><strong>Nama Pemilik</strong></td>
                                                    <td class="text-left"><strong>Total Tagihan</strong></td>
                                                    <td class="text-right"><strong>Aksi</strong></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td class="text-left">Tagihan RLI Bapak Edy</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_edy_rli); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianRLI/VRTagihanEdy?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td class="thick-line"></td>
                                                    <td class="no-line text-left"></td>
                                                    <td class="no-line text-left"></td>
                                                    <td class="thick-line"></td>
                                                </tr>
                                                <tr style="background-color: navy;  color:white;">
                                                    <td><strong>TOTAL TAGIHAN RLI</strong></td>
                                                    <td class="thick-line"></td>
                                                    <td class="no-line text-left"><?= formatuang($total_pendapatan_rli); ?> </td>
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