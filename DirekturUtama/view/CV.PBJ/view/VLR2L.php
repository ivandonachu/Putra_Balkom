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
    $tahun1 = date('Y', strtotime($tanggal_awal));
    $tahun2 = date('Y', strtotime($tanggal_akhir));
    $bulanx1 = date('m', strtotime($tanggal_awal));
    $bulan1 = ltrim($bulanx1, '0');
    $bulanx2 = date('m', strtotime($tanggal_akhir));
    $bulan2 = ltrim($bulanx2, '0');
} elseif (isset($_POST['tanggal1'])) {
    $tanggal_awal = $_POST['tanggal1'];
    $tanggal_akhir = $_POST['tanggal2'];
    $tahun1 = date('Y', strtotime($tanggal_awal));
    $tahun2 = date('Y', strtotime($tanggal_akhir));
    $bulanx1 = date('m', strtotime($tanggal_awal));
    $bulan1 = ltrim($bulanx1, '0');
    $bulanx2 = date('m', strtotime($tanggal_akhir));
    $bulan2 = ltrim($bulanx2, '0');
} else {
    $tanggal_awal = date('Y-m-1');
    $tanggal_akhir = date('Y-m-31');
    $tahun1 = date('Y', strtotime($tanggal_awal));
    $tahun2 = date('Y', strtotime($tanggal_akhir));
    $bulanx1 = date('m', strtotime($tanggal_awal));
    $bulan1 = ltrim($bulanx1, '0');
    $bulanx2 = date('m', strtotime($tanggal_akhir));
    $bulan2 = ltrim($bulanx2, '0');
}


if ($tahun1 == $tahun2) {

    if ($bulan1 == 1) {
        $bulan_bunga = $bulan2;
    } else {
        $bulan_bunga = 0;
        for ($x = $bulan1; $x <= $bulan2; $x++) {
            $bulan_bunga = $bulan_bunga + 1;
        }
    }
} else if ($tahun1 < $tahun2) {

    if ($bulan1 == 1) {
        $bulan_bunga = $bulan2 + 12;
    } else {
        $bulan_bunga = 0;
        $bulan2 = $bulan2 + 12;
        for ($x = $bulan1; $x <= $bulan2; $x++) {
            $bulan_bunga = $bulan_bunga + 1;
        }
    }
}

function formatuang($angka)
{
    $uang = "Rp " . number_format($angka, 2, ',', '.');
    return $uang;
}

if ($tanggal_awal == $tanggal_akhir) {
} else {

    // Penjualan kadek dan etty
    $tablex = mysqli_query($koneksipbj, "SELECT jumlah FROM penjualan_sl WHERE tanggal_do BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Transfer' AND tujuan_pengiriman != 'Gudang Mesuji' OR tanggal_do BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Cash' AND tujuan_pengiriman != 'Gudang Mesuji' ");
    $pendapatan_penjualan_kadek = 0;
    //kadek
    while ($data = mysqli_fetch_array($tablex)) {



        $jumlah = $data['jumlah'];
        $pendapatan_penjualan_kadek = $pendapatan_penjualan_kadek + $jumlah;
    }

    //ety
    $tablex2 = mysqli_query($koneksipbj, "SELECT jumlah FROM penjualan_s WHERE tanggal_do BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND status_bayar  = 'Lunas Transfer' OR tanggal_do BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND status_bayar = 'Lunas Cash'  ");
    $pendapatan_penjualan_ety = 0;

    while ($datae = mysqli_fetch_array($tablex2)) {

        $jumlahx = $datae['jumlah'];
        $pendapatan_penjualan_ety = $pendapatan_penjualan_ety + $jumlahx;
    }


    //sewa hiblow

    $sql_sewa_hiblow = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS total_sewa_hiblow FROM sewa_hiblow WHERE tanggal_do BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

    $data_sewa_hiblow = mysqli_fetch_array($sql_sewa_hiblow);
    $total_sewa_hiblow = $data_sewa_hiblow['total_sewa_hiblow'];


    //Untung angkutan / pranko
    $table1 = mysqli_query($koneksipbj, "SELECT no_polisi, kota, qty FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'Pranko'  ");
    $total_angkutan_edy = 0;
    $total_angkutan_rama = 0;
    $total_angkutan_aril = 0;
    $total_angkutan_reni = 0;
    while ($data1 = mysqli_fetch_array($table1)) {


        $kota = $data1['kota'];
        $qty = $data1['qty'];

        //kak nyoman
        if ($kota == 'Kab Ogn Kmrg Ulu Tim' || $kota == 'KAB OKU TIMUR') {
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut = $qty * $tarif;
            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);
            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
            }


            if ($pemilik == 'Bapak Nyoman Edi') {
                $total_angkutan_edy = $total_angkutan_edy + $total_angkut;
            } else if ($pemilik == 'Bapak Rama') {
                $total_angkutan_rama = $total_angkutan_rama + $total_angkut;
            } else if ($pemilik == 'Bapak Aril') {
                $total_angkutan_aril = $total_angkutan_aril + $total_angkut;
            } else if ($pemilik == 'Mbak Reni') {
                $total_angkutan_reni = $total_angkutan_reni + $total_angkut;
            }
        } else if ($kota == 'Kab Mesuji' || $kota == 'KAB MESUJI') {
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut = $qty * $tarif;
            $no_polisi = trim($data1["no_polisi"]);
            $no_polisi_ts = str_replace(" ", "", $no_polisi);

            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            $pemilik = 0;
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
            }

            if ($pemilik == 'Bapak Nyoman Edi') {
                $total_angkutan_edy = $total_angkutan_edy + $total_angkut;
            } else if ($pemilik == 'Bapak Rama') {
                $total_angkutan_rama = $total_angkutan_rama + $total_angkut;
            } else if ($pemilik == 'Bapak Aril') {
                $total_angkutan_aril = $total_angkutan_aril + $total_angkut;
            } else if ($pemilik == 'Mbak Reni') {
                $total_angkutan_reni = $total_angkutan_reni + $total_angkut;
            }
        } else if ($kota == 'Kab Tlg Bwg' || $kota == 'KAB. TULANG BAWANG') {
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut = $qty * $tarif;
            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
            }

            if ($pemilik == 'Bapak Nyoman Edi') {
                $total_angkutan_edy = $total_angkutan_edy + $total_angkut;
            } else if ($pemilik == 'Bapak Rama') {
                $total_angkutan_rama = $total_angkutan_rama + $total_angkut;
            } else if ($pemilik == 'Bapak Aril') {
                $total_angkutan_aril = $total_angkutan_aril + $total_angkut;
            } else if ($pemilik == 'Mbak Reni') {
                $total_angkutan_reni = $total_angkutan_reni + $total_angkut;
            }
        } else if ($kota == 'KAB WAY KANAN') {
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut = $qty * $tarif;
            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
            }

            if ($pemilik == 'Bapak Nyoman Edi') {
                $total_angkutan_edy = $total_angkutan_edy + $total_angkut;
            } else if ($pemilik == 'Bapak Rama') {
                $total_angkutan_rama = $total_angkutan_rama + $total_angkut;
            } else if ($pemilik == 'Bapak Aril') {
                $total_angkutan_aril = $total_angkutan_aril + $total_angkut;
            } else if ($pemilik == 'Mbak Reni') {
                $total_angkutan_reni = $total_angkutan_reni + $total_angkut;
            }
        } else if ($kota == 'Kab OKU Selatan' || $kota == 'KAB OKU SELATAN' || $kota == 'Kab Ogn Kmrg Ulu Sel') {
            $table1p = mysqli_query($koneksipbj, "SELECT tarif_pranko FROM list_kota_l WHERE nama_kota  = '$kota' ");
            $data1p = mysqli_fetch_array($table1p);
            $tarif = $data1p['tarif_pranko'];
            $total_angkut = $qty * $tarif;
            $table2p = mysqli_query($koneksipbj, "SELECT status_kendaraan FROM kendaraan_sl WHERE no_polisi  = '$no_polisi_ts' ");
            $data2p = mysqli_fetch_array($table2p);
            if (isset($data2p['status_kendaraan'])) {
                $pemilik = $data2p['status_kendaraan'];
            }

            if ($pemilik == 'Bapak Nyoman Edi') {
                $total_angkutan_edy = $total_angkutan_edy + $total_angkut;
            } else if ($pemilik == 'Bapak Rama') {
                $total_angkutan_rama = $total_angkutan_rama + $total_angkut;
            } else if ($pemilik == 'Bapak Aril') {
                $total_angkutan_aril = $total_angkutan_aril + $total_angkut;
            } else if ($pemilik == 'Mbak Reni') {
                $total_angkutan_reni = $total_angkutan_reni + $total_angkut;
            }
        }
    }
 
    $total_angkutan_global = $total_angkutan_aril + $total_angkutan_aril + $total_angkutan_rama + $total_angkutan_reni;



    /* pembelian kadek dan etty
    $total_penebusan_dani = 0;
    $total_penebusan_ety = 0;
    $tabel = mysqli_query($koneksipbj, "SELECT no_do FROM penjualan_sl WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

    while ($datal = mysqli_fetch_array($tabel)) {
        $no_do_penjualan = $datal['no_do'];
        $tablexj = mysqli_query($koneksipbj, "SELECT jumlah FROM pembelian_sl WHERE no_do = '$no_do_penjualan'");

        $data1x = mysqli_fetch_array($tablexj);
        $jumlah_dani = $data1x['jumlah'];

        $total_penebusan_dani = $total_penebusan_dani + $jumlah_dani;
    }F

    $tabel2 = mysqli_query($koneksipbj, "SELECT no_do FROM penjualan_s WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

    while ($data2 = mysqli_fetch_array($tabel2)) {
        $no_do_penjualanx = $data2['no_do'];
        $tablexjx = mysqli_query($koneksipbj, "SELECT jumlah FROM pembelian_sl WHERE no_do = '$no_do_penjualanx'");

        $data2x = mysqli_fetch_array($tablexjx);
        $jumlah_ety = $data2x['jumlah'];

        $total_penebusan_ety = $total_penebusan_ety + $jumlah_ety;
    }

    $pembelian_total = $total_penebusan_dani + $total_penebusan_ety;

    // pembelian kadek dan etty



 
    */


    $tablexj = mysqli_query($koneksipbj, "SELECT sum(jumlah) AS total_pembelian FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

    $data1x = mysqli_fetch_array($tablexj);
    $pembelian_total = $data1x['total_pembelian'];






    // piutang kadek dan etty
    $tablexr = mysqli_query($koneksipbj, "SELECT jumlah FROM penjualan_sl WHERE tanggal_do BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Bon' AND tujuan_pengiriman != 'Gudang Mesuji' OR tanggal_do BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Nyicil'  AND tujuan_pengiriman != 'Gudang Mesuji'");
    $piutang_penjualan_kadek = 0;
    //kadek
    while ($data = mysqli_fetch_array($tablexr)) {

        $jumlah = $data['jumlah'];
        $piutang_penjualan_kadek = $piutang_penjualan_kadek + $jumlah;
    }

    //ety
    $tablex2r = mysqli_query($koneksipbj, "SELECT jumlah FROM penjualan_s WHERE tanggal_do BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar  = 'Bon' OR tanggal_do BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND  status_bayar = 'Nyicil' ");
    $piutang_penjualan_ety = 0;
    while ($datae = mysqli_fetch_array($tablex2r)) {



        $jumlahx = $datae['jumlah'];
        $piutang_penjualan_ety = $piutang_penjualan_ety + $jumlahx;
    }

    //pengiriman ety
    $table2 = mysqli_query($koneksipbj, "SELECT SUM(uj) AS total_uj, SUM(ug) AS total_gaji, SUM(om) AS total_om, SUM(bs) AS total_bs FROM pengiriman_s WHERE 
                                        tanggal_antar  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data2 = mysqli_fetch_array($table2);
    $total_uj = $data2['total_uj'];
    $total_gaji = $data2['total_gaji'];
    $total_om = $data2['total_om'];
    $total_bs = $data2['total_bs'];

    //pengiriman kadek
    $table2sl = mysqli_query($koneksipbj, "SELECT SUM(uj) AS total_uj, SUM(ug) AS total_gaji, SUM(om) AS total_om, SUM(bs) AS total_bs FROM pengiriman_sl WHERE 
     tanggal_antar  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data2sl = mysqli_fetch_array($table2sl);
    $total_uj_sl = $data2sl['total_uj'];
    $total_gaji_sl = $data2sl['total_gaji'];
    $total_om_sl = $data2sl['total_om'];
    $total_bs_sl = $data2sl['total_bs'];

    //SQL UJ Hiblow
    $sql_uj_sewa_hiblow = mysqli_query($koneksipbj, "SELECT SUM(uang_jalan) AS total_uj_sewa_hiblow FROM sewa_hiblow WHERE tanggal_do BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

    $data_uj_sewa_hiblow = mysqli_fetch_array($sql_uj_sewa_hiblow);
    $total_uj_sewa_hiblow = $data_uj_sewa_hiblow['total_uj_sewa_hiblow'];


    //Cashback
    $table_cashback = mysqli_query($koneksipbj, "SELECT SUM(potongan_harga) AS jumlah_potongan_harga FROM potongan_harga WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    $data_cashback = mysqli_fetch_array($table_cashback);
    $jml_cashback = $data_cashback['jumlah_potongan_harga'];
    if (!isset($data_cashback['jumlah_potongan_harga'])) {
        $jml_cashback = 0;
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
    if (!isset($data4s['jumlah_listrik'])) {
        $jml_listrik_s = 0;
    }

    //Listrik & Telepon kadek
    $table4sl = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_listrik FROM keuangan_sl  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon'");
    $data4sl = mysqli_fetch_array($table4sl);
    $jml_listrik_sl = $data4sl['jumlah_listrik'];
    if (!isset($data4sl['jumlah_listrik'])) {
        $jml_listrik_sl = 0;
    }

    //Trasnport/Perjalan Dinas etty
    $table5s = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_transport FROM keuangan_s  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
    $data5s = mysqli_fetch_array($table5s);
    $jml_transport_s = $data5s['jumlah_transport'];
    if (!isset($data5s['jumlah_transport'])) {
        $jml_transport_s = 0;
    }

    //Trasnport/Perjalan Dinas kadek
    $table5sl = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_transport FROM keuangan_sl  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
    $data5sl = mysqli_fetch_array($table5sl);
    $jml_transport_sl = $data5sl['jumlah_transport'];
    if (!isset($data5sl['jumlah_transport'])) {
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

    //Biaya Konsumsi
    $table_biaya_konsumsi_s = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_biaya_konsumsi_s FROM keuangan_s  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
    $data_biaya_konsumsi_s = mysqli_fetch_array($table_biaya_konsumsi_s);
    $jumlah_biaya_konsumsi_s = $data_biaya_konsumsi_s['jumlah_biaya_konsumsi_s'];
    if (!isset($data_biaya_konsumsi_s['jumlah_biaya_konsumsi_s'])) {
        $jumlah_biaya_konsumsi_s = 0;
    }

    //Biaya Konsumsi
    $table_biaya_konsumsi = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_biaya_konsumsi_sl FROM keuangan_sl  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
    $data_biaya_konsumsi = mysqli_fetch_array($table_biaya_konsumsi);
    $jumlah_biaya_konsumsi_sl = $data_biaya_konsumsi['jumlah_biaya_konsumsi_sl'];
    if (!isset($data_biaya_konsumsi['jumlah_biaya_konsumsi_sl'])) {
        $jumlah_biaya_konsumsi_sl = 0;
    }

    //Biaya administrasi
    $table_admin_s = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_admin_s FROM keuangan_s  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Administrasi' ");
    $data_admin_s = mysqli_fetch_array($table_admin_s);
    $jumlah_admin_s = $data_admin_s['jumlah_admin_s'];
    if (!isset($data_admin_s['jumlah_admin_s'])) {
        $jumlah_admin_s = 0;
    }

    //Biaya administrasi
    $table_admin_sl = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_admin_sl FROM keuangan_sl  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Administrasi' ");
    $data_admin_sl = mysqli_fetch_array($table_admin_sl);
    $jumlah_admin_sl = $data_admin_sl['jumlah_admin_sl'];
    if (!isset($data_admin_sl['jumlah_admin_sl'])) {
        $jumlah_admin_sl = 0;
    }

    //Pemasukan Lainnya
    $table_pemasukan_lainnya_s = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_pemasukan_lainnya_s FROM keuangan_s  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Pemasukan Lainnya' ");
    $data_pemasukan_lainnya_s = mysqli_fetch_array($table_pemasukan_lainnya_s);
    $jumlah_pemasukan_lainnya_s = $data_pemasukan_lainnya_s['jumlah_pemasukan_lainnya_s'];
    if (!isset($data_pemasukan_lainnya_s['jumlah_pemasukan_lainnya_s'])) {
        $jumlah_pemasukan_lainnya_s = 0;
    }

    //Pemasukan Lainnya
    $table_pemasukan_lainnya_sl = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_pemasukan_lainnya_sl FROM keuangan_sl  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Pemasukan Lainnya' ");
    $data_pemasukan_lainnya_sl = mysqli_fetch_array($table_pemasukan_lainnya_sl);
    $jumlah_pemasukan_lainnya_sl = $data_pemasukan_lainnya_sl['jumlah_pemasukan_lainnya_sl'];
    if (!isset($data_pemasukan_lainnya_sl['jumlah_pemasukan_lainnya_sl'])) {
        $jumlah_pemasukan_lainnya_sl = 0;
    }

    //Ongkos Kuli s
    $table_ongkos_kuli_s = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_ongkos_kuli_s FROM keuangan_s  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Ongkos Kuli' ");
    $data_ongkos_kuli_s = mysqli_fetch_array($table_ongkos_kuli_s);
    $total_ongkos_kuli_s = $data_ongkos_kuli_s['jumlah_ongkos_kuli_s'];
    if (!isset($data_ongkos_kuli_s['jumlah_ongkos_kuli_s'])) {
        $total_ongkos_kuli_s = 0;
    }

    //Ongkos Kuli sl
    $table_ongkos_kuli_sl = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_ongkos_kuli_sl FROM keuangan_sl  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Ongkos Kuli' ");
    $data_ongkos_kuli_sl = mysqli_fetch_array($table_ongkos_kuli_sl);
    $total_ongkos_kuli_sl = $data_ongkos_kuli_sl['jumlah_ongkos_kuli_sl'];
    if (!isset($data_ongkos_kuli_sl['jumlah_ongkos_kuli_sl'])) {
        $total_ongkos_kuli_sl = 0;
    }

    //Pengeluaran Laiinya s
    $table_pengeluaran_lainnya_s = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_pengeluaran_lainnya_s FROM keuangan_s  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Pengeluaran Lainnya' ");
    $data_pengeluaran_lainnya_s = mysqli_fetch_array($table_pengeluaran_lainnya_s);
    $jumlah_pengeluaran_lainnya_s = $data_pengeluaran_lainnya_s['jumlah_pengeluaran_lainnya_s'];
    if (!isset($data_pengeluaran_lainnya_s['jumlah_pengeluaran_lainnya_s'])) {
        $jumlah_pengeluaran_lainnya_s = 0;
    }

    //Pengeluaran Laiinya sl
    $table_pengeluaran_lainnya_sl = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_pengeluaran_lainnya_sl FROM keuangan_sl  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Pengeluaran Lainnya' ");
    $data_pengeluaran_lainnya_sl = mysqli_fetch_array($table_pengeluaran_lainnya_sl);
    $jumlah_pengeluaran_lainnya_sl = $data_pengeluaran_lainnya_sl['jumlah_pengeluaran_lainnya_sl'];
    if (!isset($data_pengeluaran_lainnya_sl['jumlah_pengeluaran_lainnya_sl'])) {
        $jumlah_pengeluaran_lainnya_sl = 0;
    }


    //pengeluran perbaikan yani
    $table7 = mysqli_query($koneksipbj, "SELECT SUM(jumlah_sparepart) AS total_pembelian_sparepart FROM riwayat_pengeluaran_workshop_s
                                         WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data7 = mysqli_fetch_array($table7);
    $jml_pembelian_sparepart = $data7['total_pembelian_sparepart'];
    if (!isset($data7['total_pembelian_sparepart'])) {
        $jml_pembelian_sparepart = 0;
    }

    //pengeluran perbaikan etty
    $table7s = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_perbaikan FROM keuangan_s  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Perbaikan Kendaraan' ");
    $data7s = mysqli_fetch_array($table7s);
    $jml_perbaikan_etty = $data7s['jumlah_perbaikan'];
    if (!isset($data7s['jumlah_perbaikan'])) {
        $jml_perbaikan_etty = 0;
    }

    //pengeluran perbaikan 2
    $table7sl = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_perbaikan_2 FROM keuangan_sl  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Perbaikan Kendaraan' ");
    $data7sl = mysqli_fetch_array($table7sl);
    $jml_perbaikan_2 = $data7sl['jumlah_perbaikan_2'];
    if (!isset($data7sl['jumlah_perbaikan_2'])) {
        $jml_perbaikan_2 = 0;
    }

    //biaya pajak
    $table_pajak = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_pajak FROM keuangan_sl  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Pajak' ");
    $data_pajak = mysqli_fetch_array($table_pajak);
    $biaya_pajak = $data_pajak['jumlah_pajak'];
    if (!isset($data_pajak['jumlah_pajak'])) {
        $biaya_pajak = 0;
    }

    //biaya oprasional pabrik 1
    $table_op_pabrik_1 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS oprasional_pabrik_1 FROM keuangan_sl WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Oprasional Pabrik' ");
    $data_op_pabrik_1 = mysqli_fetch_array($table_op_pabrik_1);
    $biaya_op_pabrik_1 = $data_op_pabrik_1['oprasional_pabrik_1'];
    if (!isset($data_op_pabrik_1['oprasional_pabrik_1'])) {
        $biaya_op_pabrik_1 = 0;
    }

    //biaya oprasional pabrik 2
    $table_op_pabrik_2 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS oprasional_pabrik_2 FROM keuangan_s WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Oprasional Pabrik' ");
    $data_op_pabrik_2 = mysqli_fetch_array($table_op_pabrik_2);
    $biaya_op_pabrik_2 = $data_op_pabrik_2['oprasional_pabrik_2'];
    if (!isset($data_op_pabrik_2['oprasional_pabrik_2'])) {
        $biaya_op_pabrik_2 = 0;
    }


    $table8 = mysqli_query($koneksipbj, "SELECT SUM(jumlah_bengkel) AS jumlah_perbaikan FROM riwayat_pengeluaran_workshop_s
                                         WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data8 = mysqli_fetch_array($table8);
    $jml_perbaikan = $data8['jumlah_perbaikan'];
    if (!isset($data8['jumlah_perbaikan'])) {
        $jml_perbaikan = 0;
    }

    //gaji karaywan
    $table8 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS total_pengeluaran  FROM keuangan_s WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Gaji Karyawan' ");
    $data8 = mysqli_fetch_array($table8);
    $gaji_karyawan = $data8['total_pengeluaran'];
    if ($gaji_karyawan > 0) {

        $gaji_karyawan = $data8['total_pengeluaran'];
        $total_gaji_karyawan_new = 0;
    } else {
        $gaji_karyawan = 0;
        //GAJI karyawan new
        $table10x = mysqli_query($koneksicbm, "SELECT SUM(total_gaji_diterima) AS total_gaji_new FROM rekap_gaji_pbj WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
        $data_gaji_x = mysqli_fetch_array($table10x);
        $total_gaji_karyawan_new = $data_gaji_x['total_gaji_new'];
        if (!isset($data_gaji_x['total_gaji_new'])) {
            $total_gaji_karyawan_new = 0;
        }
    }
}

//GAJI Drivver new
$table101x = mysqli_query($koneksicbm, "SELECT SUM(total_gaji_diterima) AS total_gaji_driverx FROM rekap_gaji_driver_pbj WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
$data_gaji_driver = mysqli_fetch_array($table101x);
$total_gaji_driver = $data_gaji_driver['total_gaji_driverx'];
if (!isset($data_gaji_driver['total_gaji_driverx'])) {
    $total_gaji_driver = 0;
}

if ($total_gaji_driver > 0) {
    $total_bunga_bank = 50000000 * $bulan_bunga;

    $total_pendapatan =  $total_angkutan_global + $pendapatan_penjualan_ety + $pendapatan_penjualan_kadek + $piutang_penjualan_ety + $piutang_penjualan_kadek + $jml_cashback + $total_sewa_hiblow + $jumlah_pemasukan_lainnya_s + $jumlah_biaya_konsumsi_sl;
    $laba_kotor = $total_pendapatan - $pembelian_total;

    $total_biaya_usaha_final =  $total_uj + $total_gaji_driver + $total_om + $jml_listrik_s + $jml_transport_s + $jml_atk_s + $jml_biaya_kantor_s + $jml_biaya_kantor_sl + $biaya_op_pabrik_1 + $biaya_op_pabrik_2 +
        $total_uj_sl + $total_om_sl + $jml_listrik_sl + $jml_transport_sl + $jml_atk_sl + $gaji_karyawan + $total_gaji_karyawan_new + $total_bunga_bank + $jumlah_biaya_konsumsi_s + $jumlah_biaya_konsumsi_sl + $jumlah_admin_s + $jumlah_admin_sl + $total_bs + $total_bs_sl +
        $jumlah_pengeluaran_lainnya_s + $jumlah_pengeluaran_lainnya_sl + $total_ongkos_kuli_s + $total_ongkos_kuli_sl + $jml_biaya_tarikan_sl + $jml_biaya_tarikan_s + $biaya_pajak +  $total_uj_sewa_hiblow;

    $laba_bersih_sebelum_pajak =  $laba_kotor - $total_biaya_usaha_final;
} else {

    $total_bunga_bank = 50000000 * $bulan_bunga;

    $total_pendapatan = $total_angkutan_global +  $pendapatan_penjualan_ety + $pendapatan_penjualan_kadek + $piutang_penjualan_ety + $piutang_penjualan_kadek + $jml_cashback + $total_sewa_hiblow + $jumlah_pemasukan_lainnya_s + $jumlah_biaya_konsumsi_sl;
    $laba_kotor = $total_pendapatan - $pembelian_total;
    $total_biaya_usaha_final =  $total_uj + $total_gaji + $total_om + $jml_listrik_s + $jml_transport_s + $jml_atk_s + $jml_biaya_kantor_s + $jml_biaya_kantor_sl + $biaya_op_pabrik_1 + $biaya_op_pabrik_2 +
        $total_uj_sl + $total_gaji_sl + $total_om_sl + $jml_listrik_sl + $jml_transport_sl + $jml_atk_sl + $gaji_karyawan + $total_gaji_karyawan_new + $total_bunga_bank + $jumlah_biaya_konsumsi_s + $jumlah_biaya_konsumsi_sl + $jumlah_admin_s + $jumlah_admin_sl + $total_bs + $total_bs_sl +
        $jumlah_pengeluaran_lainnya_s + $jumlah_pengeluaran_lainnya_sl + $total_ongkos_kuli_s + $total_ongkos_kuli_sl + $jml_biaya_tarikan_sl + $jml_biaya_tarikan_s + $biaya_pajak +  $total_uj_sewa_hiblow;
    $laba_bersih_sebelum_pajak =  $laba_kotor - $total_biaya_usaha_final;
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
                        <a class='collapse-item' style='font-size: 15px;' href='VRekapanHarga'>Rekapan Harga</a>
                        <a class='collapse-item' style='font-size: 15px;' href='VRekapSparepart'>Rekap Sparepart</a>
                        <a class='collapse-item' style='font-size: 15px;' href='VRekapPiutang'>Rekap Piutang</a>
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
                                    <h3 class="panel-title" align="Center"><strong>Laba Rugi PT PBJ</strong></h3>
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
                                                    <td class="text-left">Penjualan Dani</td>
                                                    <td class="text-left"><?= formatuang($pendapatan_penjualan_kadek); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPenjualanKDK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-101</td>
                                                    <td class="text-left">Penjualan Ety</td>
                                                    <td class="text-left"><?= formatuang($pendapatan_penjualan_ety); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPenjualanETY?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-102</td>
                                                    <td class="text-left">Piutang Penjualan Dani</td>
                                                    <td class="text-left"><?= formatuang($piutang_penjualan_kadek); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPiutangKDK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-103</td>
                                                    <td class="text-left">Piutang Penjualan Ety</td>
                                                    <td class="text-left"><?= formatuang($piutang_penjualan_ety); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPiutangETY?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr><tr>
                                                    <td>4-104</td>
                                                    <td class="text-left">Pendapatan Angkutan Pranko</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_global); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRCashback?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-108</td>
                                                    <td class="text-left">Cashback</td>
                                                    <td class="text-left"><?= formatuang($jml_cashback); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRCashback?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-109</td>
                                                    <td class="text-left">Sewa Hiblow</td>
                                                    <td class="text-left"><?= formatuang($total_sewa_hiblow); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRSewaHiblow?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-110</td>
                                                    <td class="text-left">Pemasukan Lainnya</td>
                                                    <td class="text-left"><?= formatuang($jumlah_pemasukan_lainnya_s + $jumlah_pemasukan_lainnya_sl); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VPemasukanLainnya?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
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
                                                    <td class="text-left"><?= formatuang($pembelian_total); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRPembelianKDK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr style="background-color:    #F0F8FF;  ">
                                                    <td><strong>Total Harga Pokok Penjualan</strong></td>
                                                    <td class="thick-line"></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($pembelian_total); ?></td>
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


                                                    <?php

                                                    if ($total_gaji_driver > 0) { ?>
                                                        <td class="text-left"><?= formatuang($total_gaji_driver); ?></td>


                                                    <?php } else { ?>

                                                        <td class="text-left"><?= formatuang($total_gaji + $total_gaji_sl); ?></td>

                                                    <?php } ?>


                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRGaji?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-512</td>
                                                    <td class="text-left">Gaji Karyawan</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($gaji_karyawan + $total_gaji_karyawan_new); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRGajiKaryawan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-513</td>
                                                    <td class="text-left">Uang Jalan</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_uj + $total_uj_sl + $total_uj_sewa_hiblow); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRUJ?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-514</td>
                                                    <td class="text-left">Ongkos Mobil</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_om + $total_om_sl); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VROM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-515</td>
                                                    <td class="text-left">Ongkos Kuli</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_ongkos_kuli_s + $total_ongkos_kuli_sl); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VROngkosKuli?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-516</td>
                                                    <td class="text-left">Biaya Sewa Mobil Luar</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_bs + $total_bs_sl + $jml_biaya_tarikan_sl + $jml_biaya_tarikan_s); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRBS?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-520</td>
                                                    <td class="text-left">Biaya Administrasi</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($jumlah_admin_s + $jumlah_admin_sl); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRBiayaAdministasi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-530</td>
                                                    <td class="text-left">Biaya Konsumsi</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($jumlah_biaya_konsumsi_s + $jumlah_biaya_konsumsi_sl); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VRBiayaKonsumsi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
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
                                                    <td>5-560</td>
                                                    <td class="text-left">Oprasional Pabrik</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($biaya_op_pabrik_1 + $biaya_op_pabrik_2); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VROPPabrik?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
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
                                                    <td>5-597</td>
                                                    <td class="text-left">Pengeluaran Lainnya</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($jumlah_pengeluaran_lainnya_s + $jumlah_pengeluaran_lainnya_sl); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VPengeluaranLainnya?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-598</td>
                                                    <td class="text-left">Biaya Pajak</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($biaya_pajak); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLR/VBiayaPajak?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-599</td>
                                                    <td class="text-left">Bunga Bank</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($total_bunga_bank); ?></td>
                                                    <?php echo "<td class='text-right'><a href=''></a></td>"; ?>
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