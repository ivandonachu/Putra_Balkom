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
   // $status_kendaraan = $_GET['status_kendaraan'];
    $tahun1 = date('Y', strtotime($tanggal_awal));
    $tahun2 = date('Y', strtotime($tanggal_akhir));
    $bulanx1 = date('m', strtotime($tanggal_awal));
    $bulan1 = ltrim($bulanx1, '0');
    $bulanx2 = date('m', strtotime($tanggal_akhir));
    $bulan2 = ltrim($bulanx2, '0');
} elseif (isset($_POST['tanggal1'])) {
    $tanggal_awal = $_POST['tanggal1'];
    $tanggal_akhir = $_POST['tanggal2'];
   // $status_kendaraan = $_POST['status_kendaraan'];
    $tahun1 = date('Y', strtotime($tanggal_awal));
    $tahun2 = date('Y', strtotime($tanggal_akhir));
    $bulanx1 = date('m', strtotime($tanggal_awal));
    $bulan1 = ltrim($bulanx1, '0');
    $bulanx2 = date('m', strtotime($tanggal_akhir));
    $bulan2 = ltrim($bulanx2, '0');
} else {
    $tanggal_awal = date('Y-m-1');
    $tanggal_akhir = date('Y-m-31');
  //  $status_kendaraan = "Bapak Nyoman Edi";
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
 //Untung angkutan / pranko
 $table1 = mysqli_query($koneksipbj, "SELECT no_polisi, kota, qty FROM pembelian_sl WHERE tanggal  = '$tanggal_awal' AND tipe_semen = 'Pranko'  ");
 $total_angkutan_edy = 0;
 $total_angkutan_rama = 0;
 $total_map = 0;
 $total_eki_bangunan = 0;
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
         } else if ($pemilik == 'MAP') {
             $total_map = $total_map + $total_angkut;
         } else if ($pemilik == 'Eki Bangunan') {
             $total_eki_bangunan = $total_eki_bangunan + $total_angkut;
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

         /*if($status_kendaraan == 'Bapak Nyoman Edi' ){

             if ($pemilik == 'Bapak Nyoman Edi') {
                 $total_angkutan_edy = $total_angkutan_edy + $total_angkut;
             } else if ($pemilik == 'Bapak Rama') {
                 
             } else if ($pemilik == 'MAP') {
                
             } else if ($pemilik == 'Eki Bangunan') {
                 
             }

         }

         else if($status_kendaraan == 'Bapak Rama' ){

             if ($pemilik == 'Bapak Nyoman Edi') {
             
             } else if ($pemilik == 'Bapak Rama') {
                 $total_angkutan_rama = $total_angkutan_rama + $total_angkut;
             } else if ($pemilik == 'MAP') {
                
             } else if ($pemilik == 'Eki Bangunan') {
                 
             }

         }

         else if($status_kendaraan == 'MAP' ){

             if ($pemilik == 'Bapak Nyoman Edi') {
             
             } else if ($pemilik == 'Bapak Rama') {
                 
             } else if ($pemilik == 'MAP') {
                 $total_map = $total_map + $total_angkut;
             } else if ($pemilik == 'Eki Bangunan') {
                 
             }

         }

         else if($status_kendaraan == 'Eki Bangunan' ){

             if ($pemilik == 'Bapak Nyoman Edi') {
             
             } else if ($pemilik == 'Bapak Rama') {
                 
             } else if ($pemilik == 'MAP') {
                 
             } else if ($pemilik == 'Eki Bangunan') {
                 $total_eki_bangunan = $total_eki_bangunan + $total_angkut;
             }

         }*/

         if ($pemilik == 'Bapak Nyoman Edi') {
             $total_angkutan_edy = $total_angkutan_edy + $total_angkut;
         } else if ($pemilik == 'Bapak Rama') {
             $total_angkutan_rama = $total_angkutan_rama + $total_angkut;
         } else if ($pemilik == 'MAP') {
             $total_map = $total_map + $total_angkut;
         } else if ($pemilik == 'Eki Bangunan') {
             $total_eki_bangunan = $total_eki_bangunan + $total_angkut;
         }

     }
     
   

     else if ($kota == 'Kab Tlg Bwg' || $kota == 'KAB. TULANG BAWANG') {
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
         } else if ($pemilik == 'MAP') {
             $total_map = $total_map + $total_angkut;
         } else if ($pemilik == 'Eki Bangunan') {
             $total_eki_bangunan = $total_eki_bangunan + $total_angkut;
         }

     } else if ($kota == 'KAB WAY KANAN') {
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
         } else if ($pemilik == 'MAP') {
             $total_map = $total_map + $total_angkut;
         } else if ($pemilik == 'Eki Bangunan') {
             $total_eki_bangunan = $total_eki_bangunan + $total_angkut;
         }

     } else if ($kota == 'Kab OKU Selatan' || $kota == 'KAB OKU SELATAN' || $kota == 'Kab Ogn Kmrg Ulu Sel') {
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
         } else if ($pemilik == 'MAP') {
             $total_map = $total_map + $total_angkut;
         } else if ($pemilik == 'Eki Bangunan') {
             $total_eki_bangunan = $total_eki_bangunan + $total_angkut;
         }
     }
 }


 //pengiriman ety
 $table2 = mysqli_query($koneksipbj, "SELECT SUM(uj) AS total_uj, SUM(ug) AS total_gaji, SUM(om) AS total_om, SUM(bs) AS total_bs FROM pengiriman_s WHERE 
                                     tanggal_antar  = '$tanggal_awal'");
 $data2 = mysqli_fetch_array($table2);
 $total_uj = $data2['total_uj'];
 $total_gaji = $data2['total_gaji'];
 $total_om = $data2['total_om'];
 $total_bs = $data2['total_bs'];

 //pengiriman kadek
 $table2sl = mysqli_query($koneksipbj, "SELECT SUM(uj) AS total_uj, SUM(ug) AS total_gaji, SUM(om) AS total_om, SUM(bs) AS total_bs FROM pengiriman_sl WHERE 
  tanggal_antar  = '$tanggal_awal'");
 $data2sl = mysqli_fetch_array($table2sl);
 $total_uj_sl = $data2sl['total_uj'];
 $total_gaji_sl = $data2sl['total_gaji'];
 $total_om_sl = $data2sl['total_om'];
 $total_bs_sl = $data2sl['total_bs'];



 //pengeluran perbaikan yani
 $table7 = mysqli_query($koneksipbj, "SELECT SUM(jumlah_sparepart) AS total_pembelian_sparepart FROM riwayat_pengeluaran_workshop_s
                                      WHERE tanggal  = '$tanggal_awal'");
 $data7 = mysqli_fetch_array($table7);
 $jml_pembelian_sparepart = $data7['total_pembelian_sparepart'];
 if (!isset($data7['total_pembelian_sparepart'])) {
     $jml_pembelian_sparepart = 0;
 }

 //pengeluran perbaikan etty
 $table7s = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_perbaikan FROM keuangan_s  WHERE tanggal  = '$tanggal_awal' AND nama_akun = 'Perbaikan Kendaraan' ");
 $data7s = mysqli_fetch_array($table7s);
 $jml_perbaikan_etty = $data7s['jumlah_perbaikan'];
 if (!isset($data7s['jumlah_perbaikan'])) {
     $jml_perbaikan_etty = 0;
 }

 //pengeluran perbaikan 2
 $table7sl = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_perbaikan_2 FROM keuangan_sl  WHERE tanggal  = '$tanggal_awal' AND nama_akun = 'Perbaikan Kendaraan' ");
 $data7sl = mysqli_fetch_array($table7sl);
 $jml_perbaikan_2 = $data7sl['jumlah_perbaikan_2'];
 if (!isset($data7sl['jumlah_perbaikan_2'])) {
     $jml_perbaikan_2 = 0;
 }


 $table8 = mysqli_query($koneksipbj, "SELECT SUM(jumlah_bengkel) AS jumlah_perbaikan FROM riwayat_pengeluaran_workshop_s
                                      WHERE tanggal  = '$tanggal_awal'");
 $data8 = mysqli_fetch_array($table8);
 $jml_perbaikan = $data8['jumlah_perbaikan'];
 if (!isset($data8['jumlah_perbaikan'])) {
     $jml_perbaikan = 0;
 }



 $total_pendapatan = $total_angkutan_edy + $total_angkutan_rama + $total_map + $total_eki_bangunan;
 $pembelian_total = 0;


 $laba_kotor = $total_pendapatan - $pembelian_total;
 $total_biaya_usaha_final =  $jml_pembelian_sparepart + $jml_perbaikan_etty + $jml_perbaikan_2 + $jml_perbaikan;
 $laba_bersih_sebelum_pajak =  $laba_kotor;

   
} else {


  
    //Untung angkutan / pranko
    $table1 = mysqli_query($koneksipbj, "SELECT no_polisi, kota, qty FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_semen = 'Pranko'  ");
    $total_angkutan_edy = 0;
    $total_angkutan_rama = 0;
    $total_map = 0;
    $total_eki_bangunan = 0;
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
            } else if ($pemilik == 'MAP') {
                $total_map = $total_map + $total_angkut;
            } else if ($pemilik == 'Eki Bangunan') {
                $total_eki_bangunan = $total_eki_bangunan + $total_angkut;
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

            /*if($status_kendaraan == 'Bapak Nyoman Edi' ){

                if ($pemilik == 'Bapak Nyoman Edi') {
                    $total_angkutan_edy = $total_angkutan_edy + $total_angkut;
                } else if ($pemilik == 'Bapak Rama') {
                    
                } else if ($pemilik == 'MAP') {
                   
                } else if ($pemilik == 'Eki Bangunan') {
                    
                }

            }

            else if($status_kendaraan == 'Bapak Rama' ){

                if ($pemilik == 'Bapak Nyoman Edi') {
                
                } else if ($pemilik == 'Bapak Rama') {
                    $total_angkutan_rama = $total_angkutan_rama + $total_angkut;
                } else if ($pemilik == 'MAP') {
                   
                } else if ($pemilik == 'Eki Bangunan') {
                    
                }

            }

            else if($status_kendaraan == 'MAP' ){

                if ($pemilik == 'Bapak Nyoman Edi') {
                
                } else if ($pemilik == 'Bapak Rama') {
                    
                } else if ($pemilik == 'MAP') {
                    $total_map = $total_map + $total_angkut;
                } else if ($pemilik == 'Eki Bangunan') {
                    
                }

            }

            else if($status_kendaraan == 'Eki Bangunan' ){

                if ($pemilik == 'Bapak Nyoman Edi') {
                
                } else if ($pemilik == 'Bapak Rama') {
                    
                } else if ($pemilik == 'MAP') {
                    
                } else if ($pemilik == 'Eki Bangunan') {
                    $total_eki_bangunan = $total_eki_bangunan + $total_angkut;
                }

            }*/

            if ($pemilik == 'Bapak Nyoman Edi') {
                $total_angkutan_edy = $total_angkutan_edy + $total_angkut;
            } else if ($pemilik == 'Bapak Rama') {
                $total_angkutan_rama = $total_angkutan_rama + $total_angkut;
            } else if ($pemilik == 'MAP') {
                $total_map = $total_map + $total_angkut;
            } else if ($pemilik == 'Eki Bangunan') {
                $total_eki_bangunan = $total_eki_bangunan + $total_angkut;
            }

        }
        
      

        else if ($kota == 'Kab Tlg Bwg' || $kota == 'KAB. TULANG BAWANG') {
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
            } else if ($pemilik == 'MAP') {
                $total_map = $total_map + $total_angkut;
            } else if ($pemilik == 'Eki Bangunan') {
                $total_eki_bangunan = $total_eki_bangunan + $total_angkut;
            }

        } else if ($kota == 'KAB WAY KANAN') {
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
            } else if ($pemilik == 'MAP') {
                $total_map = $total_map + $total_angkut;
            } else if ($pemilik == 'Eki Bangunan') {
                $total_eki_bangunan = $total_eki_bangunan + $total_angkut;
            }

        } else if ($kota == 'Kab OKU Selatan' || $kota == 'KAB OKU SELATAN' || $kota == 'Kab Ogn Kmrg Ulu Sel') {
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
            } else if ($pemilik == 'MAP') {
                $total_map = $total_map + $total_angkut;
            } else if ($pemilik == 'Eki Bangunan') {
                $total_eki_bangunan = $total_eki_bangunan + $total_angkut;
            }
        }
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


    $table8 = mysqli_query($koneksipbj, "SELECT SUM(jumlah_bengkel) AS jumlah_perbaikan FROM riwayat_pengeluaran_workshop_s
                                         WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data8 = mysqli_fetch_array($table8);
    $jml_perbaikan = $data8['jumlah_perbaikan'];
    if (!isset($data8['jumlah_perbaikan'])) {
        $jml_perbaikan = 0;
    }



    $total_pendapatan = $total_angkutan_edy + $total_angkutan_rama + $total_map + $total_eki_bangunan;
    $pembelian_total = 0;


    $laba_kotor = $total_pendapatan - $pembelian_total;
    $total_biaya_usaha_final =  $jml_pembelian_sparepart + $jml_perbaikan_etty + $jml_perbaikan_2 + $jml_perbaikan;
    $laba_bersih_sebelum_pajak =  $laba_kotor;


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
                        <a class='collapse-item' style='font-size: 15px;' href='VLR2L'>Laba Rugi</a>
                        <a class='collapse-item' style='font-size: 15px;' href='VLR2LBaru'>Laba Rugi Baru</a>
                        <a class='collapse-item' style='font-size: 15px;' href='VLRKendaraan'>Laba Rugi Kendaraan</a>
                        <a class='collapse-item' style='font-size: 15px;' href='VRekapanHarga'>Rekapan Harga</a>
                        <a class='collapse-item' style='font-size: 15px;' href='VRekapSparepart'>Rekap Sparepart</a>
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
                            <?php /*
                            <select id="status_kendaraan" name="status_kendaraan" style="font-size: 14px">
                                <option>Bapak Nyoman Edi</option>
                                <option>MAP</option>
                                <option>Eki Bangunan</option>
                                <option>Bapak Rama</option>
                            </select>
                            */ ?>
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
                                    <h3 class="panel-title" align="Center"><strong>LR Tagihan RLI PT PBJ</strong></h3>
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
                                                    <td class="text-left">Pendapatan RLI Bapak Edy</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_edy); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianRLI/VRTagihanEdy?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-101</td>
                                                    <td class="text-left">Pendapatan RLI Bapak Rama</td>
                                                    <td class="text-left"><?= formatuang($total_angkutan_rama); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianRLI/VRTagihanRama?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-102</td>
                                                    <td class="text-left">Pendapatan RLI MAP</td>
                                                    <td class="text-left"><?= formatuang($total_map); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianRLI/VRTagihanMap?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>4-103</td>
                                                    <td class="text-left">Pendapatan RLI Eki Bangunan</td>
                                                    <td class="text-left"><?= formatuang($total_eki_bangunan); ?></td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianRLI/VRTagihanEki?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
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
                                               <?php /* <tr>
                                                    <td><strong>5-500</strong></td>
                                                    <td class="text-left"><strong>BIAYA USAHA</strong></td>
                                                    <td class="text-left"></td>
                                                    <td class="text-left"></td>
                                                    <?php echo "<td class='text-right'></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-596</td>
                                                    <td class="text-left">Pembelian Sparepart</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($jml_pembelian_sparepart); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLRBaru/VRPembelian?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
                                                </tr>
                                                <tr>
                                                    <td>5-597</td>
                                                    <td class="text-left">Pengeluaran Perbaikan</td>
                                                    <td class="text-left"><?= formatuang(0); ?></td>
                                                    <td class="text-left"><?= formatuang($jml_perbaikan + $jml_perbaikan_2 + $jml_perbaikan_etty); ?></td>
                                                    <?php echo "<td class='text-right'><a href='VRincianLRBaru/VPengeluaranLainnya?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
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
                                                </tr> */ ?>
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