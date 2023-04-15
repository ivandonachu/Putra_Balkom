
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
if ($jabatan_valid == 'Kepala Oprasional') {

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

else{
    $tanggal_awal = date('Y-m-1');
  $tanggal_akhir = date('Y-m-31');
  }

if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksi, "SELECT * FROM riwayat_saldo_armada WHERE tanggal = '$tanggal_awal' ");
$table2 = mysqli_query($koneksi, "SELECT * FROM rekening ");
}
else{
$table = mysqli_query($koneksi, "SELECT * FROM riwayat_saldo_armada  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
$table2 = mysqli_query($koneksi, "SELECT * FROM rekening ");

// KELUARRRRRR
//keluar cbm untuk cbm
$table3 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_cbm FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'CBM' AND referensi = 'CBM' AND status_saldo = 'Keluar' ");
   $data3 = mysqli_fetch_array($table3);
   $jumlah_kel_cbm = $data3['jumlah_kel_cbm'];
    if (!isset($data3['jumlah_kel_cbm'])) {
    $jumlah_kel_cbm = 0;
    }

//keluar mes untuk mes
$table4 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_mes FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'MES' AND referensi = 'MES' AND status_saldo = 'Keluar' ");
   $data4 = mysqli_fetch_array($table4);
   $jumlah_kel_mes = $data4['jumlah_kel_mes'];
    if (!isset($data4['jumlah_kel_mes'])) {
    $jumlah_kel_mes = 0;
    }

//keluar pbr untuk pbr
$table5 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_pbr FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PBR' AND referensi = 'PBR' AND status_saldo = 'Keluar' ");
   $data5 = mysqli_fetch_array($table5);
   $jumlah_kel_pbr = $data5['jumlah_kel_pbr'];
    if (!isset($data5['jumlah_kel_pbr'])) {
    $jumlah_kel_pbr = 0;
    }

//keluar pbj untuk pbj
$table6 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_pbj FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PBJ' AND referensi = 'PBJ' AND status_saldo = 'Keluar' ");
   $data6 = mysqli_fetch_array($table6);
   $jumlah_kel_pbj = $data6['jumlah_kel_pbj'];
    if (!isset($data6['jumlah_kel_pbj'])) {
    $jumlah_kel_pbj = 0;
    }

  //keluar mt untuk mt
$table7 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_mt FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'CBM' AND referensi = 'Melodi Tani' AND status_saldo = 'Keluar' ");
$data7 = mysqli_fetch_array($table7);
$jumlah_kel_mt = $data7['jumlah_kel_mt'];
 if (!isset($data7['jumlah_kel_mt'])) {
 $jumlah_kel_mt = 0;

 }//keluar balsri untuk balsri
$table8 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_balsri_balsri FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'BALSRI' AND referensi = 'BALSRI' AND status_saldo = 'Keluar' ");
$data8 = mysqli_fetch_array($table8);
$jumlah_kel_balsri_balsri = $data8['jumlah_kel_balsri_balsri'];
 if (!isset($data8['jumlah_kel_balsri_balsri'])) {
 $jumlah_kel_balsri_balsri = 0;

 }//keluar balsri untuk ste
$table9 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_balsri_ste FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'BALSRI' AND referensi = 'STE' AND status_saldo = 'Keluar' ");
$data9 = mysqli_fetch_array($table9);
$jumlah_kel_balsri_ste = $data9['jumlah_kel_balsri_ste'];
 if (!isset($data9['jumlah_kel_balsri_ste'])) {
 $jumlah_kel_balsri_ste = 0;

 }//keluar pribadi untuk kebun 
$table10 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_pri FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'Kebun Lenkiti' AND status_saldo = 'Keluar' ");
$data10 = mysqli_fetch_array($table10);
$jumlah_kel_pri = $data10['jumlah_kel_pri'];
 if (!isset($data10['jumlah_kel_pri'])) {
 $jumlah_kel_pri = 0;
 }

  //keluar pribadi untuk kebun 
$table101 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_pri_pri FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'PRIBADI' AND status_saldo = 'Keluar' ");
$data101 = mysqli_fetch_array($table101);
$jumlah_kel_pri = $data101['jumlah_kel_pri_pri'];
 if (!isset($data101['jumlah_kel_pri_pri'])) {
 $jumlah_kel_pri_pri = 0;
 }
//keluar PBJ untuk kebun MBAH
$table1011 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_pbj_kebunmbah FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PBJ' AND referensi = 'Kebun Mbah' AND status_saldo = 'Keluar' ");
$data1011 = mysqli_fetch_array($table1011);
$jumlah_kel_pbj_kebunmbah = $data1011['jumlah_kel_pbj_kebunmbah'];
 if (!isset($data1011['jumlah_kel_pbj_kebunmbah'])) {
 $jumlah_kel_pbj_kebunmbah = 0;
 }

 //keluar CBM untuk kebun MBAH
$table1011y = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_cbm_kebunmbah FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'CBM' AND referensi = 'Kebun Mbah' AND status_saldo = 'Keluar' ");
$data1011y = mysqli_fetch_array($table1011y);
$jumlah_kel_cbm_kebunmbah = $data1011y['jumlah_kel_cbm_kebunmbah'];
 if (!isset($data1011y['jumlah_kel_cbm_kebunmbah'])) {
 $jumlah_kel_cbm_kebunmbah = 0;
 }

 //keluar CBM untuk kebun KELING
$table1011x = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_cbm_keling FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'CBM' AND referensi = 'Kebun Lengkiti' AND status_saldo = 'Keluar' ");
$data1011x = mysqli_fetch_array($table1011x);
$jumlah_kel_cbm_keling = $data1011x['jumlah_kel_cbm_keling'];
 if (!isset($data1011x['jumlah_kel_cbm_keling'])) {
 $jumlah_kel_cbm_keling = 0;
 }

// MASUKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK

 //MASUK cbm untuk cbm
$table11 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_mas_cbm FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'CBM' AND referensi = 'CBM' AND status_saldo = 'Masuk' ");
$data11 = mysqli_fetch_array($table11);
$jumlah_mas_cbm = $data11['jumlah_mas_cbm'];
 if (!isset($data11['jumlah_mas_cbm'])) {
 $jumlah_mas_cbm = 0;
 }

//MASUK mes untuk mes
$table12 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_mas_mes FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'MES' AND referensi = 'MES' AND status_saldo = 'Masuk' ");
$data12 = mysqli_fetch_array($table12);
$jumlah_mas_mes = $data12['jumlah_mas_mes'];
 if (!isset($data12['jumlah_mas_mes'])) {
 $jumlah_mas_mes = 0;
 }

//MASUK pbr untuk pbr
$table13 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_mas_pbr FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PBR' AND referensi = 'PBR' AND status_saldo = 'Masuk' ");
$data13 = mysqli_fetch_array($table13);
$jumlah_mas_pbr = $data13['jumlah_mas_pbr'];
 if (!isset($data13['jumlah_mas_pbr'])) {
 $jumlah_mas_pbr = 0;
 }

//MASUK pbj untuk pbj
$table14 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_mas_pbj FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PBJ' AND referensi = 'PBJ' AND status_saldo = 'Masuk' ");
$data14 = mysqli_fetch_array($table14);
$jumlah_mas_pbj = $data14['jumlah_mas_pbj'];
 if (!isset($data14['jumlah_mas_pbj'])) {
 $jumlah_mas_pbj = 0;
 }

//MASUK mt untuk mt
$table15 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_mas_mt FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'CBM' AND referensi = 'Melodi Tani' AND status_saldo = 'Masuk' ");
$data15 = mysqli_fetch_array($table15);
$jumlah_mas_mt = $data15['jumlah_mas_mt'];
if (!isset($data15['jumlah_mas_mt'])) {
$jumlah_mas_mt = 0;

}//MASUK balsri untuk balsri
$table16 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_mas_balsri_balsri FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'BALSRI' AND referensi = 'BALSRI' AND status_saldo = 'Masuk' ");
$data16 = mysqli_fetch_array($table16);
$jumlah_mas_balsri_balsri = $data16['jumlah_mas_balsri_balsri'];
if (!isset($data16['jumlah_mas_balsri_balsri'])) {
$jumlah_mas_balsri_balsri = 0;

}//MASUK balsri untuk ste
$table17 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_mas_balsri_ste FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'BALSRI' AND referensi = 'STE' AND status_saldo = 'Masuk' ");
$data17 = mysqli_fetch_array($table17);
$jumlah_mas_balsri_ste = $data17['jumlah_mas_balsri_ste'];
if (!isset($data17['jumlah_mas_balsri_ste'])) {
$jumlah_mas_balsri_ste = 0;

}//MASUK pribadi untuk kebun 
$table18 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_mas_pri FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'Kebun Lenkiti' AND status_saldo = 'Masuk' ");
$data18 = mysqli_fetch_array($table18);
$jumlah_mas_pri = $data18['jumlah_mas_pri'];
if (!isset($data18['jumlah_mas_pri'])) {
$jumlah_mas_pri = 0;
}

//MASUK pribadi untuk kebun 
$table19 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_mas_pri_pri FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'PRIBADI' AND status_saldo = 'Masuk' ");
$data19 = mysqli_fetch_array($table19);
$jumlah_mas_pri_pri = $data19['jumlah_mas_pri_pri'];
if (!isset($data19['jumlah_mas_pri_pri'])) {
$jumlah_mas_pri_pri = 0;
}

//MASUK pribadi untuk kebun 
$table20 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_mas_pri_mbah FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'Kebun Mbah' AND status_saldo = 'Masuk' ");
$data20 = mysqli_fetch_array($table20);
$jumlah_mas_pri_mbah = $data20['jumlah_mas_pri_mbah'];
if (!isset($data20['jumlah_mas_pri_mbah'])) {
$jumlah_mas_pri_mbah = 0;
}

//Keluar pribadi untuk kebun 
$table21 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_pri_mbah FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'Kebun Mbah' AND status_saldo = 'Keluar' ");
$data21 = mysqli_fetch_array($table21);
$jumlah_kel_pri_mbah = $data21['jumlah_kel_pri_mbah'];
if (!isset($data21['jumlah_kel_pri_mbah'])) {
$jumlah_kel_pri_mbah = 0;
}
//Keluar pribadi untuk CBM 
$table22 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_pri_cbm FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'CBM' AND status_saldo = 'Keluar' ");
$data22 = mysqli_fetch_array($table22);
$jumlah_kel_pri_cbm = $data22['jumlah_kel_pri_cbm'];
if (!isset($data22['jumlah_kel_pri_cbm'])) {
$jumlah_kel_pri_cbm = 0;
}
//Keluar pribadi untuk MES 
$table23 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_pri_mes FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'MES' AND status_saldo = 'Keluar' ");
$data23 = mysqli_fetch_array($table23);
$jumlah_kel_pri_mes = $data23['jumlah_kel_pri_mes'];
if (!isset($data23['jumlah_kel_pri_mes'])) {
$jumlah_kel_pri_mes = 0;
}
//Keluar pribadi untuk PBR 
$table24 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_pri_pbr FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'PBR' AND status_saldo = 'Keluar' ");
$data24 = mysqli_fetch_array($table24);
$jumlah_kel_pri_pbr = $data24['jumlah_kel_pri_pbr'];
if (!isset($data24['jumlah_kel_pri_pbr'])) {
$jumlah_kel_pri_pbr = 0;
}

//Keluar pribadi untuk PBR 
$table25 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_pbr_ranau FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PBR' AND referensi = 'Kebun Ranau' AND status_saldo = 'Keluar' ");
$data25 = mysqli_fetch_array($table25);
$jumlah_kel_pbr_ranau = $data25['jumlah_kel_pbr_ranau'];
if (!isset($data25['jumlah_kel_pbr_ranau'])) {
$jumlah_kel_pbr_ranau = 0;
}

//Keluar CBM untuk Exxa 
$table26 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_cbm_exxa_da FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'CBM' AND referensi = 'Exxa' AND status_saldo = 'Keluar' ");
$data26 = mysqli_fetch_array($table26);
$jumlah_kel_cbm_exxa = $data26['jumlah_kel_cbm_exxa_da'];
if (!isset($data26['jumlah_kel_cbm_exxa_da'])) {
$jumlah_kel_cbm_exxa = 0;
}

//Keluar CBM untuk Kebun Seberuk 
$table27 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_cbm_beruk FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'CBM' AND referensi = 'Kebun Seberuk' AND status_saldo = 'Keluar' ");
$data27 = mysqli_fetch_array($table27);
$jumlah_kel_cbm_beruk = $data27['jumlah_kel_cbm_beruk'];
if (!isset($data27['jumlah_kel_cbm_beruk'])) {
$jumlah_kel_cbm_beruk = 0;
}

//Keluar Kebun Seberuk untuk Kebun Seberuk 
$table28 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_beruk_beruk FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'Kebun Seberuk' AND referensi = 'Kebun Seberuk' AND status_saldo = 'Keluar' ");
$data28 = mysqli_fetch_array($table28);
$jumlah_kel_beruk_beruk = $data28['jumlah_kel_beruk_beruk'];
if (!isset($data28['jumlah_kel_beruk_beruk'])) {
$jumlah_kel_beruk_beruk = 0;
}

//Keluar pribadi untuk kebun 
$table29 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_kel_lengkiti_lengkiti FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'Kebun Lenkiti' AND referensi = 'Kebun Lenkiti' AND status_saldo = 'Keluar' ");
$data29 = mysqli_fetch_array($table29);
$jumlah_kel_lengkiti_lengkiti = $data29['jumlah_kel_lengkiti_lengkiti'];
if (!isset($data29['jumlah_kel_lengkiti_lengkiti'])) {
$jumlah_kel_lengkiti_lengkiti = 0;
}

// kode salado

$CBM = 'CBM';
$MES = 'MES';
$PBR = 'PBR';
$PBJ = 'PBJ';
$MT = 'Melodi Tani';
$BALSRI = 'BALSRI';
$STE = 'STE';
$PRIBADI = 'PRIBADI';
$Kebun = 'Kebun Lengkiti';
$Keluar = 'Keluar';
$Masuk = 'Masuk';
$mbah = 'Kebun Mbah';
$ranau = 'Kebun Ranau';
$exxa = 'Exxa';
$beruk = 'Kebun Seberuk';


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

  <title>Penggunaan Uang</title>

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

  <!-- Link datepicker -->

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav  sidebar sidebar-dark accordion" style=" background-color: #004445" id="accordionSidebar">

       <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKepalaOprasional">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active" >
                <a class="nav-link" href="DsKepalaOprasional">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 16px;" >Dashboard</span></a>
                </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu Kepala Oprasional
       </div>

      <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                  15  aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Oprasional</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Oprasional</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VSaldoBaru">Penggunaan Saldo</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VUangPBJ">Uang PBJ</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPBR">Pengeluaran PBR/MES</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapUang">Rekap Uang Masuk</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapTF">Rekap TF ke Bank</a>
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
      <?php echo "<a href='VPenggunaanSaldo'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Penggunaan Saldo Perusahaan</h5></a>"; ?>
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
 <?php  echo "<form  method='POST' action='VSaldoBaru' style='margin-bottom: 15px;'>" ?>
    <div>
      <div align="left" style="margin-left: 20px;"> 
        <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1"> 
        <span>-</span>
        <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
        <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm" >Lihat</button>
      </div>
    </div>
  </form>

  <div class="row">
    <div class="col-md-8">
     <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir </a>" ?>
   </div>
   </div>
  <div class="row">
    <div class="col-md-10">
     
   </div>
   <div class="col-md-2">
    <!-- Button Pindah Baja -->
    <div align="right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Penggunaan Saldo </button> <br> <br>
    </div>
    <!-- Form Modal  -->
    <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role ="document">
       <div class="modal-content"> 
        <div class="modal-header">
          <h5 class="modal-title"> Form Penggunaan Saldo </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> 

        <!-- Form Input Data -->
        <div class="modal-body" align="left">
          <?php  echo "<form action='../proses/proses_penggunaan_saldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

          <div class="row">
            <div class="col-md-6">

              <label>Tanggal</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal" name="tanggal" required="">
             </div>
    
          </div>
          <div class="col-md-6">
          </div>
        </div>
  <br>

        <div class="row">
        <div class="col-md-6">
       <label>Saldo</label>
          <select id="rekening" name="rekening" class="form-control">
            <option>CBM</option>
            <option>PBJ</option>
            <option>MES</option>
            <option>PBR</option>
            <option>PRIBADI</option>
            <option>BALSRI</option>
            <option>STE</option>
            <option>Kebun Lengkiti</option>
            <option>Kebun Seberuk</option>
            
          </select>
    </div>
          <div class="col-md-6">
           <label>REF Pengeluaran/Pemasukan</label>
          <select id="referensi" name="referensi" class="form-control">
            <option>CBM</option>
            <option>Melodi Tani</option>
            <option>PBJ</option>
            <option>BALSRI</option>
            <option>Kebun Lengkiti</option>
            <option>Kebun Mbah</option>
            <option>PRIBADI</option>
            <option>MES</option>
            <option>PBR</option>
            <option>STE</option>
            <option>Kebun Ranau</option>
            <option>Exxa</option>
            <option>Kebun Seberuk</option>
          </select>
          <small></small>
        </div>
        
   

      </div>

      <br>

     

      <div class="row">
      <div class="col-md-6">
          <label>Akun</label>
          <select id="akun" name="akun" class="form-control">
            <option>Setor ke Bank</option>
            <option>Dana Masuk</option>
            <option>Biaya Usaha Lainnya</option>
            <option>Biaya Perbaikan Kendaraan</option>
            <option>Biaya Perbaikan Kendaraan Pribadi</option>
            <option>Biaya Penjualan & Pemasaran</option>
            <option>Alat Tulis Kantor</option>
            <option>Biaya Kantor</option>
            <option>Biaya Konsumsi</option>
            <option>Transport / Perjalanan Dinas</option>
            <option>Listrik & Telepon</option>
            <option>Bon Karyawan</option>
            <option>Mocash</option>
            <option>Pengeluaran Lainnya</option>
            <option>Uang Jalan</option>
          </select>
        </div>            
        <div class="col-md-6">
          <label>Jumlah</label>
          <input class="form-control form-control-sm" type="number" id="jumlah" name="jumlah"  required="">
        </div>    
      </div>
      <br>


    <div>
     <label>Keterangan</label>
     <div class="form-group">
       <textarea id = "keterangan" name="keterangan" style="width: 300px;"></textarea>
     </div>
   </div>

   <div>
    <label>Upload File</label> 
    <input type="file" name="file"> 
  </div> 


  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">CATAT</button>
    <button type="reset" class="btn btn-danger"> RESET</button>
  </div>
</form>
</div>

</div>
</div>
</div>

</div>
</div>



<!-- Tabel -->    
<div style="overflow-x: auto" align = 'center'>
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Rekening</th>
      <th>REF/Digunakan</th>
      <th>Akun</th>
      <th>Debit</th>
      <th>Kredit</th>
      <th>Keterangan</th>
      <th>File</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    
    $urut = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>
    <?php while($data = mysqli_fetch_array($table)){
      $no_laporan = $data['no_laporan'];
      $tanggal =$data['tanggal'];
      $nama_rekening = $data['nama_rekening'];
      $referensi = $data['referensi'];
      $nama_akun = $data['nama_akun'];
      $jumlah = $data['jumlah'];
      $file_bukti = $data['file_bukti'];
      $keterangan = $data['keterangan'];
      $status_saldo = $data['status_saldo'];
        $urut = $urut + 1;
      echo "<tr>
      <td style='font-size: 14px'>$urut</td>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$nama_rekening</td>
      <td style='font-size: 14px'>$referensi</td>
      <td style='font-size: 14px'>$nama_akun</td>
      
     ";


      if ($status_saldo == 'Masuk') {
        echo "
        <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>";
      }
      else{
        echo "
        <td style='font-size: 14px'>"?>  <?php echo "</td>";
      }

      if ($status_saldo == 'Keluar') {
        echo "
        <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>";
      }
      else{
        echo "
        <td style='font-size: 14px'>"?>  <?php echo "</td>";
      }
        
      echo "
      <td style='font-size: 14px'>$keterangan</td>
      <td style='font-size: 14px'>"; ?> <a download="../file_oprasional/<?= $file_bukti ?>" href="../file_oprasional/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>
      <?php echo "<td style='font-size: 12px'>"; ?>
       <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_laporan']; ?>">Edit</button>

        <!-- Form EDIT DATA -->

        <div class="modal fade" id="formedit<?php echo $data['no_laporan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
          <div class="modal-dialog" role ="document">
            <div class="modal-content"> 
              <div class="modal-header">Form Edit Kas Kecil </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                  <span aria-hidden="true"> &times; </span>
                </button>
              </div>


              <!-- Form Edit Data -->
              <div class="modal-body">
                <form action="../proses/edit_penggunaan_saldo.php" enctype="multipart/form-data" method="POST">

                  <div class="row">
            <div class="col-md-6">

              <label>Tanggal</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal" name="tanggal"  value="<?php echo $tanggal;?>" required="">
             </div>
   

          </div>
          <div class="col-md-6">
          </div>
        </div>

<br>
        <div class="row">
        <div class="col-md-6">
       

       <label><label>Saldo</label></label>
       <select id="rekening" name="rekening" class="form-control">
         <?php $dataSelect1 = $data['nama_rekening']; ?>
         <option <?php echo ($dataSelect1 == 'CBM') ? "selected": "" ?> >CBM</option>
         <option <?php echo ($dataSelect1 == 'PBJ') ? "selected": "" ?> >PBJ</option>
         <option <?php echo ($dataSelect1 == 'MES') ? "selected": "" ?> >MES</option>
         <option <?php echo ($dataSelect1 == 'PBR') ? "selected": "" ?> >PBR</option>
         <option <?php echo ($dataSelect1 == 'BALSRI') ? "selected": "" ?> >BALSRI</option>
         <option <?php echo ($dataSelect1 == 'STE') ? "selected": "" ?> >STE</option>
         <option <?php echo ($dataSelect1 == 'PRIBADI') ? "selected": "" ?> >PRIBADI</option>
         <option <?php echo ($dataSelect == 'Kebun Lengkiti') ? "selected": "" ?> >Kebun Lengkiti</option>
         <option <?php echo ($dataSelect == 'Kebun Seberuk') ? "selected": "" ?> >Kebun Seberuk</option>
       </select>


     </div>    

        <div class="col-md-6">

          <label><label>REF Pengeluaran/Pemasukan</label></label>
          <select id="referensi" name="referensi" class="form-control">
            <?php $dataSelect = $data['referensi']; ?>
            <option <?php echo ($dataSelect == 'CBM') ? "selected": "" ?> >CBM</option>
            <option <?php echo ($dataSelect == 'Melodi Tani') ? "selected": "" ?> >Melodi Tani</option>
            <option <?php echo ($dataSelect == 'PBJ') ? "selected": "" ?> >PBJ</option>
            <option <?php echo ($dataSelect == 'BALSRI') ? "selected": "" ?> >BALSRI</option>
            <option <?php echo ($dataSelect == 'Kebun Lengkiti') ? "selected": "" ?> >Kebun Lengkiti</option>
            <option <?php echo ($dataSelect == 'Kebun Mbah') ? "selected": "" ?> >Kebun Mbah</option>
            <option <?php echo ($dataSelect == 'PRIBADI') ? "selected": "" ?> >PRIBADI</option>
            <option <?php echo ($dataSelect == 'MES') ? "selected": "" ?> >MES</option>
            <option <?php echo ($dataSelect == 'PBR') ? "selected": "" ?> >PBR</option>
            <option <?php echo ($dataSelect == 'STE') ? "selected": "" ?> >STE</option>
            <option <?php echo ($dataSelect == 'Kebun Ranau') ? "selected": "" ?> >Kebun Ranau</option>
            <option <?php echo ($dataSelect == 'Exxa') ? "selected": "" ?> >Exxa</option>
            <option <?php echo ($dataSelect == 'Kebun Seberuk') ? "selected": "" ?> >Kebun Seberuk</option>
          </select>

        </div>            
         
      </div>

      <br>

     

      <div class="row">

      <div class="col-md-6">

          <label><label>Akun</label></label>
          <select id="akun" name="akun" class="form-control">
            <?php $dataSelect = $data['nama_akun']; ?>
            <option <?php echo ($dataSelect == 'Setor ke Bank') ? "selected": "" ?> >Setor ke Bank</option>
            <option <?php echo ($dataSelect == 'Dana Masuk') ? "selected": "" ?> >Dana Masuk</option>
            <option <?php echo ($dataSelect == 'Biaya Usaha Lainnya') ? "selected": "" ?> >Biaya Usaha Lainnya</option>
            <option <?php echo ($dataSelect == 'Biaya Perbaikan Kendaraan') ? "selected": "" ?> >Biaya Perbaikan Kendaraan</option>
            <option <?php echo ($dataSelect == 'Biaya Perbaikan Kendaraan Pribadi') ? "selected": "" ?> >Biaya Perbaikan Kendaraan Pribadi</option>
            <option <?php echo ($dataSelect == 'Biaya Penjualan & Pemasaran') ? "selected": "" ?> >Biaya Penjualan & Pemasaran</option>
            <option <?php echo ($dataSelect == 'Bon Karyawan') ? "selected": "" ?> >Bon Karyawan</option>
            <option <?php echo ($dataSelect == 'Alat Tulis Kantor') ? "selected": "" ?> >Alat Tulis Kantor</option>
            <option <?php echo ($dataSelect == 'Biaya Kantor') ? "selected": "" ?> >Biaya Kantor</option>
            <option <?php echo ($dataSelect == 'Biaya Konsumsi') ? "selected": "" ?> >Biaya Konsumsi</option>
            <option <?php echo($dataSelect == 'Transport / Perjalanan Dinas')?"selected": ""?>>Transport / Perjalanan Dinas</option>
            <option <?php echo($dataSelect == 'Listrik & Telepon')?"selected": ""?>>Listrik & Telepon</option>
            <option <?php echo($dataSelect == 'Mocash')?"selected": ""?>>Mocash</option>
            <option <?php echo($dataSelect == 'Prive')?"selected": ""?>>Prive</option>
            <option <?php echo($dataSelect == 'Pengeluaran Lainnya')?"selected": ""?>>Pengeluaran Lainnya</option>
            <option <?php echo($dataSelect == 'Uang Jalan')?"selected": ""?>>Uang Jalan</option>
          </select>

        </div>
        <div class="col-md-6">
          <label>Jumlah</label>
          <input class="form-control form-control-sm" type="number" id="jumlah" name="jumlah"  value="<?php echo $jumlah;?>"  required="">
        </div>    
             
      </div>
      <br>
      <div>
     <label>Keterangan</label>
     <div class="form-group">
       <textarea id = "keterangan" name="keterangan" style="width: 300px;"><?php echo $keterangan;?></textarea>
     </div>
   </div>

              <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
              <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir;?>">
               <input type="hidden" name="no_laporan" value="<?php echo $no_laporan;?>">
  
    <br>



  <div>
    <label>Upload File</label> 
    <input type="file" name="file"> 
  </div> 
                 

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"> Ubah </button>
                    <button type="reset" class="btn btn-danger"> RESET</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      <button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_laporan']; ?>" data-toggle='tooltip' title='Hapus Transaksi'></button>

      <div class="modal fade" id="PopUpHapus<?php echo $data['no_laporan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
       <div class="modal-dialog" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h4 class="modal-title"> <b> Hapus </b> </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>



          <div class="modal-body">
            <form action="../proses/hapus_penggunaan_saldo" method="POST">
              <input type="hidden" name="no_laporan" value="<?php echo $no_laporan; ?>">
              <input type="hidden" name="status_saldo" value="<?php echo $status_saldo; ?>">
              <input type="hidden" name="nama_rekening" value="<?php echo $nama_rekening;?>">
              <input type="hidden" name="jumlah" value="<?php echo $jumlah;?>">
              <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
              <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir;?>">



              <div class="form-group">
                <h6> Yakin Ingin Hapus Data? </h6>             
              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-primary"> Hapus </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php echo  " </td> </tr>";
  }
  ?>

</tbody>
</table>
</div>
  </div>
<br>
<br>
<div style="margin-right: 100px; margin-left: 100px;">
<h6 align="Center">Laporan Pengeluaran</h6>
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
      <th style='font-size: 11px'align = 'center'>Rekening</th>
      <th style='font-size: 11px'align = 'center'>Referensi</th>
      <th style='font-size: 11px'align = 'center'>Total Keluar</th>
      <th style='font-size: 11px'align = 'center'></th>
    </tr>
  </thead>
  <tbody>

  
  <tr>
      <td style='font-size: 11px' align = 'center'>CBM</td>
      <td style='font-size: 11px' align = 'center'>CBM</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_cbm); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$CBM&rekening=$CBM&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>MES</td>
      <td style='font-size: 11px' align = 'center'>MES</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_mes); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$MES&rekening=$MES&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>PBR</td>
      <td style='font-size: 11px' align = 'center'>PBR</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_pbr); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$PBR&rekening=$PBR&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>PBJ</td>
      <td style='font-size: 11px' align = 'center'>PBJ</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_pbj); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$PBJ&rekening=$PBJ&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>PBJ</td>
      <td style='font-size: 11px' align = 'center'>Kebun Mbah</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_pbj_kebunmbah); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$mbah&rekening=$PBJ&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>CBM</td>
      <td style='font-size: 11px' align = 'center'>Kebun Mbah</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_cbm_kebunmbah); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$mbah&rekening=$CBM&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>CBM</td>
      <td style='font-size: 11px' align = 'center'>Melodi Tani</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_mt); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$MT&rekening=$CBM&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>BALSRI</td>
      <td style='font-size: 11px' align = 'center'>BALSRI</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_balsri_balsri); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$BALSRI&rekening=$BALSRI&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>BALSRI</td>
      <td style='font-size: 11px' align = 'center'>STE</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_balsri_ste); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$STE&rekening=$BALSRI&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>CBM</td>
      <td style='font-size: 11px' align = 'center'>Kebun Lengkiti</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_cbm_keling); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$Kebun&rekening=$CBM&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>PRIBADI</td>
      <td style='font-size: 11px' align = 'center'>PRIBADI</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_pri_pri); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$PRIBADI&rekening=$PRIBADI&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>PRIBADI</td>
      <td style='font-size: 11px' align = 'center'>Kebun Mbah</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_pri_mbah); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$mbah&rekening=$PRIBADI&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>PRIBADI</td>
      <td style='font-size: 11px' align = 'center'>CBM</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_pri_cbm); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$CBM&rekening=$PRIBADI&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>PRIBADI</td>
      <td style='font-size: 11px' align = 'center'>MES</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_pri_mes); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$MES&rekening=$PRIBADI&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>PRIBADI</td>
      <td style='font-size: 11px' align = 'center'>PBR</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_pri_pbr); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$PBR&rekening=$PRIBADI&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>PBR</td>
      <td style='font-size: 11px' align = 'center'>Kebun Ranau</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_pbr_ranau); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$ranau&rekening=$PBR&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>CBM</td>
      <td style='font-size: 11px' align = 'center'>Exxa</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_cbm_exxa); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$exxa&rekening=$CBM&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>CBM</td>
      <td style='font-size: 11px' align = 'center'>Kebun Seberuk</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_cbm_beruk); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$beruk&rekening=$CBM&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Kebun Seberuk</td>
      <td style='font-size: 11px' align = 'center'>Kebun Seberuk</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_beruk_beruk); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$beruk&rekening=$beruk&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Kebun Lengkiti</td>
      <td style='font-size: 11px' align = 'center'>Kebun Lengkiti</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_kel_lengkiti_lengkiti); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$Kebun&rekening=$Kebun&status_saldo=$Keluar'>Rincian</a></td>"; ?>
     
  </tr>


</tbody>
</table>
</div>
<br>
<br>

<div style="margin-right: 100px; margin-left: 100px;">
<h6 align="Center">Laporan Pemasukan</h6>
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
      <th style='font-size: 11px' align = 'center'>Rekening</th>
      <th style='font-size: 11px' align = 'center'>Referensi</th>
      <th style='font-size: 11px' align = 'center'>Total Masuk</th>
      <th style='font-size: 11px'align = 'center'></th>
    </tr>
  </thead>
  <tbody>

  
  <tr>
      <td style='font-size: 11px' align = 'center'>CBM</td>
      <td style='font-size: 11px' align = 'center'>CBM</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_mas_cbm); ?></td>
     
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$CBM&rekening=$CBM&status_saldo=$Masuk'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>MES</td>
      <td style='font-size: 11px' align = 'center'>MES</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_mas_mes); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$MES&rekening=$MES&status_saldo=$Masuk'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>PBR</td>
      <td style='font-size: 11px' align = 'center'>PBR</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_mas_pbr); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$PBR&rekening=$PBR&status_saldo=$Masuk'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>PBJ</td>
      <td style='font-size: 11px' align = 'center'>PBJ</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_mas_pbj); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$PBJ&rekening=$PBJ&status_saldo=$Masuk'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>CBM</td>
      <td style='font-size: 11px' align = 'center'>Melodi Tani</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_mas_mt); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$MT&rekening=$MT&status_saldo=$Masuk'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>BALSRI</td>
      <td style='font-size: 11px' align = 'center'>BALSRI</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_mas_balsri_balsri); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$BALSRI&rekening=$BALSRI&status_saldo=$Masuk'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>BALSRI</td>
      <td style='font-size: 11px' align = 'center'>STE</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_mas_balsri_ste); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$STE&rekening=$BALSRI&status_saldo=$Masuk'>Rincian</a></td>"; ?>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>CBM</td>
      <td style='font-size: 11px' align = 'center'>Kebun Lengkiti</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_mas_pri); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$Kebun&rekening=$CBM&status_saldo=$Masuk'>Rincian</a></td>"; ?>

     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>PRIBADI</td>
      <td style='font-size: 11px' align = 'center'>PRIBADI</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_mas_pri_pri); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$PRIBADI&rekening=$PRIBADI&status_saldo=$Masuk'>Rincian</a></td>"; ?>
     
  </tr>
  tr>
      <td style='font-size: 11px' align = 'center'>PRIBADI</td>
      <td style='font-size: 11px' align = 'center'>Kebun Mbah</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($jumlah_mas_pri_mbah); ?></td>
      <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$mbah&rekening=$PRIBADI&status_saldo=$Masuk'>Rincian</a></td>"; ?>
     
  </tr>

</tbody>
</table>
</div>
<br>
<br>





<?php /*
<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h6 align="center">UANG CBM</h6>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Total Uang Masuk ke CBM</th>
      <th>Total Uang Keluar dari CBM</th>
      <th>Total Uang Disetor ke CBM</th>
      <th>Total Uang CBM di Tangan</th>
      <th>Rincian</th>
    </tr>
  </thead>
  <tbody>

    <?php
      echo "<tr>

      <td style='font-size: 14px'>";?> <?= formatuang($masuk_cbm_cbm + $masuk_cbm_mt + $masuk_cbm_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($masuk_pbj_cbm + $masuk_mt_cbm + $keluar_cbm_balsri + $keluar_cbm_keling + $keluar_cbm_cbm + $keluar_cbm_pbr + $keluar_cbm_mt + $keluar_cbm_pbj + $keluar_cbm_ste); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($setor_cbm_cbm + $setor_cbm_mt + $setor_cbm_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang(($masuk_cbm_cbm + $masuk_cbm_mt + $masuk_cbm_pbj + 15000000) - ($masuk_pbj_cbm + $masuk_mt_cbm + $keluar_cbm_balsri + $keluar_cbm_ste  + $setor_cbm_cbm + $setor_cbm_mt + $setor_cbm_pbj + $keluar_cbm_keling + $keluar_cbm_cbm + $keluar_cbm_pbr + $keluar_cbm_mt + $keluar_cbm_pbj)); ?> <?php echo "</td>
      <td class='text-center'><a href='VRincianCBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>
        </tr>";
  
  ?>

</tbody>
</table>
</div>

<br>

<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h6 align="center">UANG MT</h6>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Total Uang Masuk ke MT</th>
      <th>Total Uang Keluar dari MT</th>
      <th>Total Uang Disetor ke MT</th>
      <th>Total Uang MT di Tangan</th>
      <th>Rincian</th>
    </tr>
  </thead>
  <tbody>

    <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($masuk_mt_mt + $masuk_mt_cbm + $masuk_mt_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($masuk_cbm_mt + $masuk_pbj_mt + $keluar_mt_balsri + $keluar_mt_keling + $keluar_mt_mt + $keluar_mt_pbr + $keluar_mt_cbm + $keluar_mt_pbj + $keluar_mt_ste); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($setor_mt_mt + $setor_mt_cbm + $setor_mt_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang(($masuk_mt_mt + $masuk_mt_cbm + $masuk_mt_pbj)-($masuk_cbm_mt + $masuk_pbj_mt + $keluar_mt_balsri + $keluar_mt_ste + $setor_mt_mt + $setor_mt_cbm + $setor_mt_pbj + $keluar_mt_keling + $keluar_mt_mt + $keluar_mt_pbr + $keluar_mt_cbm + $keluar_mt_pbj)); ?> <?php echo "</td>
      <td class='text-center'><a href='VRincianMT?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>
        </tr>";
  
  ?>

</tbody>
</table>
</div>

<br>

<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h6 align="center">UANG PBJ</h6>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Total Uang Masuk ke PBJ</th>
      <th>Total Uang Keluar dari PBJ</th>
      <th>Total Uang Disetor ke PBJ</th>
      <th>Total Uang PBJ di Tangan</th>
      <th>Rincian</th>
    </tr>
  </thead>
  <tbody>

    <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($masuk_pbj_mt + $masuk_pbj_cbm + $masuk_pbj_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($masuk_cbm_pbj + $masuk_mt_pbj + $keluar_pbj_balsri + $keluar_pbj_keling + $keluar_pbj_pbj + $keluar_pbj_pbr + $keluar_pbj_cbm + $keluar_pbj_mt + $keluar_pbj_ste ); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($setor_pbj_mt + $setor_pbj_cbm + $setor_pbj_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang(($masuk_pbj_mt + $masuk_pbj_cbm + $masuk_pbj_pbj)-($setor_pbj_mt + $setor_pbj_cbm + $setor_pbj_pbj + $masuk_cbm_pbj + $masuk_mt_pbj + $keluar_pbj_balsri + $keluar_pbj_ste + $keluar_pbj_keling + $keluar_pbj_pbj + $keluar_pbj_pbr + $keluar_pbj_cbm + $keluar_pbj_mt )); ?> <?php echo "</td>
      <td class='text-center'><a href='VRincianPBJ?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>
        </tr>";
  
  ?>

</tbody>
</table>
</div>
<br>

<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h6 align="center">Pengeluaran Untuk Balsri</h6>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Total Uang CBM dipakai BALSRI</th>
      <th>Total Uang PBJ dipakai BALSRI</th>
      <th>Total Uang MT dipakai BALSRI</th>
    
      <th>Rincian</th>
    </tr>
  </thead>
  <tbody>

    <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_cbm_balsri); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_pbj_balsri); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_mt_balsri); ?> <?php echo "</td>
      <td class='text-center'><a href='VRincianBALSRI?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>
        </tr>";
  
  ?>

</tbody>
</table>
</div>
<br>

<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h6 align="center">Pengeluaran Untuk STE</h6>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Total Uang CBM dipakai STE</th>
      <th>Total Uang PBJ dipakai STE</th>
      <th>Total Uang MT dipakai STE</th>
    
      <th>Rincian</th>
    </tr>
  </thead>
  <tbody>

    <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_cbm_ste); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_pbj_ste); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_mt_ste); ?> <?php echo "</td>
      <td class='text-center'><a href='VRincianSTE?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>
        </tr>";
  
  ?>

</tbody>
</table>
</div>
<br>
*/ ?>





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
<script src="/sbadmin/vendor/jquery/jquery.min.js"></script>
<script src="/sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/sbadmin/vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="/sbadmin/js/sb-admin-2.min.js"></script>

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

</body>

</html>