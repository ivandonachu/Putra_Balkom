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


if (isset($_GET['tanggal1'])) {
    $tanggal_awal = $_GET['tanggal1'];
    $tanggal_akhir = $_GET['tanggal2'];
   } 
   
   elseif (isset($_POST['tanggal1'])) {
    $tanggal_awal = $_POST['tanggal1'];
    $tanggal_akhir = $_POST['tanggal2'];
   }  else{
       $tanggal_awal = date('Y-m-1');
     $tanggal_akhir = date('Y-m-31');
     }

function formatuang($angka){
  $uang = "Rp " . number_format($angka,2,',','.');
  return $uang;
}

if ($tanggal_awal == $tanggal_akhir) {
  // Tagihan
  $table = mysqli_query($koneksibalsri_jbb, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_pl a INNER JOIN master_tarif_pl b ON a.delivery_point=b.delivery_point  WHERE tanggal = '$tanggal_awal'");
  $data = mysqli_fetch_array($table);
  $total_tagihan= $data['total_tagihan'];
  //pengiriman_pl
  $table2 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(dexlite) AS total_dex, SUM(um) AS uang_makan, SUM(ug) AS uang_gaji FROM pengiriman_pl WHERE tanggal = '$tanggal_awal'");
  $data2 = mysqli_fetch_array($table2);
  $jml_dex= $data2['total_dex'];
  $total_um= $data2['uang_makan'];
  $total_ug= $data2['uang_gaji'];
  $total_dexlite = $jml_dex * 9700;

  //pengeluran Pul Biaya Kantor
   $table3 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_pl WHERE tanggal = '$tanggal_awal' AND nama_akun = 'Biaya Kantor' ");
   $data3 = mysqli_fetch_array($table3);
   $jml_biaya_kantor = $data3['jumlah_biaya_kantor'];
    if (!isset($data3['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor = 0;
    }

   //pengeluran Pul Listrik & Telepon
   $table4 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_pl WHERE tanggal = '$tanggal_awal' AND nama_akun = 'Listrik & Telepon' ");
   $data4 = mysqli_fetch_array($table4);
   $jml_listrik = $data4['jumlah_listrik'];
    if (!isset($data4['jumlah_listrikr'])) {
    $jml_listrik = 0;
    }

   //pengeluran Biaya Sewa
   $table5 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_pl WHERE tanggal = '$tanggal_awal' AND nama_akun = 'Biaya Sewa' ");
   $data5 = mysqli_fetch_array($table5);
   $jml_sewa = $data5['jumlah_sewa'];
    if (!isset($data5['jumlah_sewa'])) {
    $jml_sewa = 0;
    }

   //pengeluran Alat Tulis Kantor
   $table6 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_pl WHERE tanggal = '$tanggal_awal' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6 = mysqli_fetch_array($table6);
   $jml_atk = $data6['jumlah_atk'];
    if (!isset($data6['jumlah_atk'])) {
    $jml_atk = 0;
    }

    //pengeluran perbaikan
   $table7 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_pl WHERE tanggal = '$tanggal_awal'");
   $data7 = mysqli_fetch_array($table7);
   $jml_perbaikan = $data7['jumlah_perbaikan'];
    if (!isset($data7['jumlah_perbaikan'])) {
    $jml_perbaikan = 0;
    }


}
else{
    // Tagihan
  $table = mysqli_query($koneksibalsri_jbb, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_pl a INNER JOIN master_tarif_pl b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data = mysqli_fetch_array($table);
  $total_tagihan= $data['total_tagihan'];
  
  // Potongan 10%
  $jumlah_potongan = (($total_tagihan * 10) / 100);

  //pengiriman_pl
  $table2 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(dexlite) AS total_dex, SUM(um) AS uang_makan FROM pengiriman_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data2 = mysqli_fetch_array($table2);

  $total_um= $data2['uang_makan'];
 
  $total_dexlite = 0;
  $total_bbm = 0;
  $table222 = mysqli_query($koneksibalsri_jbb, "SELECT jt_gps, uj , dexlite FROM pengiriman_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  while($data = mysqli_fetch_array($table222)){
    $uang_jalan = $data['uj'];
    $jt_gps = $data['jt_gps'];
    $dexlite = $data['dexlite'];
    $total_dexlite = $total_dexlite + ($uang_jalan - ($jt_gps*625));
    $total_bbm = $total_bbm + $dexlite;
    
}
    $uang_bbm = $total_bbm * 0;
  
    $selisih_bbm =  $total_dexlite - $uang_bbm;

    
  //pengeluran Pul Biaya Kantor
   $table3 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
   $data3 = mysqli_fetch_array($table3);
   $jml_biaya_kantor = $data3['jumlah_biaya_kantor'];
    if (!isset($data3['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor = 0;
    }

   //pengeluran Pul Listrik & Telepon
   $table4 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
   $data4 = mysqli_fetch_array($table4);
   $jml_listrik = $data4['jumlah_listrik'];
    if (!isset($data4['jumlah_listrik'])) {
    $jml_listrik = 0;
    }

   //pengeluran Biaya Sewa
   $table5 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
   $data5 = mysqli_fetch_array($table5);
   $jml_sewa = $data5['jumlah_sewa'];
    if (!isset($data5['jumlah_sewa'])) {
    $jml_sewa = 0;
    }

   //pengeluran Alat Tulis Kantor
   $table6 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6 = mysqli_fetch_array($table6);
   $jml_atk = $data6['jumlah_atk'];
    if (!isset($data6['jumlah_atk'])) {
    $jml_atk = 0;
    }

    //pengeluran Transnport / Perjalanan Dinas
   $table61 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61 = mysqli_fetch_array($table61);
   $jml_transport = $data61['jumlah_transport'];
    if (!isset($data61['jumlah_transport'])) {
    $jml_transport = 0;
    }
    //pengeluran Biaya Konsumsi
   $table62 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62 = mysqli_fetch_array($table62);
   $jml_konsumsi = $data62['jumlah_konsumsi'];
    if (!isset($data62['jumlah_konsumsi'])) {
    $jml_konsumsi = 0;
    }

    //pengeluran perbaikan
   $table7 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7 = mysqli_fetch_array($table7);
   $jml_perbaikan = $data7['jumlah_perbaikan'];
    if (!isset($data7['jumlah_perbaikan'])) {
    $jml_perbaikan = 0;
    }
    
    
     //Gaji karyawan
   $table8 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI PL' ");
   $data8 = mysqli_fetch_array($table8);
   $gaji_karyawan = $data8['jumlah_gaji'];
    if (!isset($data8['jumlah_gaji'])) {
    $gaji_karyawan = 0;
    }
    //Gaji dRIVER
   $table9 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Driver PL' ");
   $data9 = mysqli_fetch_array($table9);
   $gaji_driver = $data9['jumlah_gaji'];
    if (!isset($data9['jumlah_gaji'])) {
    $gaji_driver = 0;
    }
    
    $total_gaji_karaywan = $gaji_karyawan + $gaji_driver;

    //list supir
    $table10 =  mysqli_query($koneksibalsri_jbb, "SELECT mt FROM tagihan_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");

    //akses kredit
    $table101 =  mysqli_query($koneksibalsri_jbb, "SELECT mt FROM tagihan_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
    //totalkredit
    $total_kredit = 0;
    while($data = mysqli_fetch_array($table101)){
        $mt = $data['mt'];

        $tablee = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataa = mysqli_fetch_array($tablee);
        $jml_kredit= $dataa['total_kredit'];

        $tableex= mysqli_query($koneksistre, "SELECT SUM(jumlah) AS total_kreditx FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataax = mysqli_fetch_array($tableex);
        $jml_kreditx= $dataax['total_kreditx'];

        if(isset($jml_kredit)){
            $total_kredit += $jml_kredit;
        }
        else if(isset($jml_kreditx)){
            $total_kredit += $jml_kreditx;
        }
        
    }



}

    $total_laba_kotor = $total_tagihan ;
    $sisa_oprasional = $jumlah_potongan - ($jml_atk + $gaji_karyawan + $jml_sewa + $jml_transport );
    $total_biaya_usaha_final = $total_dexlite + $jml_biaya_kantor + $jml_listrik  +  $jml_perbaikan + $total_um + $gaji_driver  +  $jml_konsumsi+ $total_kredit + $jml_atk + $gaji_karyawan + $jml_sewa + $jml_transport;
    $laba_bersih_sebelum_pajak = $total_laba_kotor  - $total_biaya_usaha_final;

    $total_biaya_usaha_final_bbm = $uang_bbm + $jml_biaya_kantor + $jml_listrik  +  $jml_perbaikan + $total_um + $gaji_driver  +  $jml_konsumsi+ $total_kredit + $jml_atk + $gaji_karyawan + $jml_sewa + $jml_transport ;
$laba_bersih_bbm = $total_laba_kotor  - $total_biaya_usaha_final_bbm;
?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan LR Plumpang</title>

    <!-- Custom fonts for this template-->
    <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsPTBALSRI">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">


  <!-- Nav Item - Dashboard -->
<li class="nav-item active" >
    <a class="nav-link" href="DsBALSRIJBB">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

<!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu PT BALSRI JBB
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fa fa-building" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >List Company</span>
    </a>
    <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Company</h6>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.CBM/view/DsPTCBM">PT.CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/CV.PBJ/view/DsCVPBJ">CV.PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BatuBara/view/DsCVPBJ">Transport BL</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.BALSRI/view/DsPTBALSRI">PT.BALSRI</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.MESPBR/view/DsPTPBRMES">PT. MES & PBR</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/Kebun/view/DsKebun">Kebun</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PERTASHOP/view/DsPertashop">Pertashop</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.STRE/view/DsPTSTRE">PT.Sri Trans Energi</a>
            <a class="collapse-item" style="font-size: 15px;" href="DsBALSRIJBB">BALSRI JBB</a>
        </div>
    </div>
</li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
      15  aria-expanded="true" aria-controls="collapseThree">
        <i class="fas fa-chart-line" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Laba Rugi</span>
    </a>
    <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Laba Rugi</h6>
            
            <?php if($nama == 'Nyoman Edy Susanto'){
              echo"<a class='collapse-item' style='font-size: 15px;' href='VLuangOP'>Lap uang Oprasional</a>";
            } ?>
            <?php if($nama == 'Nyoman Edy Susanto'){
              echo" <a class='collapse-item' style='font-size: 15px;' href='VLrGlobalJBB'>LR Global JBB</a>
              <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiTG'>LR Tj Gerem</a>
              <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiPA'>LR Padalarang</a>
              <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiPL'>LR Plumpang</a>
              <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiUB'>LR Ujung Berung</a>
              <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiBA'>LR Balongan</a>";
            } ?>
        </div>
    </div>
</li>

 <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
      15  aria-expanded="true" aria-controls="collapseOne">
        <i class="fas fa-file-invoice-dollar" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Tagihan</span>
    </a>
    <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Tagihan</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanTG">Tagihan Tj Gerem</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanPA">Tagihan Padalarang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanPL">Tagihan Plumpang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanUB">Tagihan Ujung Berung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanBA">Tagihan Balongan</a>
        </div>
    </div>
</li>


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwox"
      15  aria-expanded="true" aria-controls="collapseTwox">
        <i class="fas fa-truck-loading" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Pengiriman</span>
    </a>
    <div id="collapseTwox" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Pengiriman</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanTG">Pengiriman TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanPA">Pengiriman PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanPL">Pengiriman PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanUB">Pengiriman UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanBA">Pengiriman BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseTG">Ritase TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitasePA">Ritase PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitasePL">Ritase PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseUB">Ritase UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseBA">Ritase BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhTG">Jarak Tempuh TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhPA">Jarak Tempuh PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhPL">Jarak Tempuh PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhUB">Jarak Tempuh UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBA">Jarak Tempuh BA</a>

            
        </div>
    </div>
</li>
 <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo22"
      15  aria-expanded="true" aria-controls="collapseTwo22">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Pengeluaran</span>
    </a>
    <div id="collapseTwo22" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Pengeluaran</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanTG">Perbaikan TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanPA">Perbaikan PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanPL">Perbaikan PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanUB">Perbaikan UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanBA">Perbaikan BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulTG">Pengeluaran Pul TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulPA">Pengeluaran Pul PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulPL">Pengeluaran Pul PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulUB">Pengeluaran Pul UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBA">Pengeluaran Pul BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiTG">Gaji TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiPA">Gaji PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiPL">Gaji PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiUB">Gaji UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiBA">Gaji BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Gaji Karyawan</a>
        </div>
    </div>
</li>
 <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo13"
      15  aria-expanded="true" aria-controls="collapseTwo1">
        <i class="fa fa-id-card" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >SDM</span>
    </a>
    <div id="collapseTwo13" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VAMT">AMT</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMT">MT</a>
            <a class="collapse-item" style="font-size: 15px;" href="VBayarKredit">Kredit Kendaraan</a>
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
    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php $foto_profile = $data1['foto_profile']; ?>
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
<div class="container" style="color : black;">
   <?php  echo "<form  method='POST' action='VLabaRugiPL' style='margin-bottom: 15px;'>" ?>
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
<br>
<?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
<br>
<hr>
<br>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laba Rugi Plumpang</strong></h3>
        </div>

        <div>

        </div>



        <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-condensed"  style="color : black;">
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
                 <td class="text-left">Tagihan Patra</td>
                 <td class="text-left"><?= formatuang($total_tagihan); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
                 <?php echo "<td class='text-right'><a href='VRincianLRPL/VRTagihan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
             </tr>
           
             <tr style="background-color: navy;  color:white;">
                <td><strong>LABA KOTOR</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($total_laba_kotor); ?> </td>
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
                <td><strong>4-101</strong></td>
                <td class="text-left"><strong>PEMOTONGAN BIAYA OPRASIONAL</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
                <?php echo "<td class='text-right'></td>"; ?>
            </tr>
            
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Karyawan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_karyawan); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRPL/VRGaji?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-520</td>
                <td class="text-left">Alat Tulis Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_atk); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRPL/VRATK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-570</td>
                <td class="text-left">Biaya Sewa</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_sewa); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRPL/VRSewa?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-530</td>
                <td class="text-left">Transport & Perjalanan Dinas</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_transport); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRPL/VRPerjalanan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                 <td>4-101</td>
                 <td class="text-left">Biaya Oprasional 10%</td>
                 <td class="text-left"><?= formatuang($jumlah_potongan); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
                 <td class="text-left"></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>Sisa Biaya Oprasional</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($sisa_oprasional); ?> </td>
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
                <td>5-510</td>
                <td class="text-left">Gaji Driver</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_driver); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRPL/VRGaji?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-540</td>
                <td class="text-left">Biaya Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_biaya_kantor); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRPL/VRBiayaKantor?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-550</td>
                <td class="text-left">Listrik & Telepon</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_listrik); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRPL/VRListrik?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-560</td>
                <td class="text-left">Biaya Konsumsi</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_konsumsi); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRPL/VRKonsumsi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            
            
            <tr>
                <td>5-595</td>
                <td class="text-left">Biaya Perbaikan Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_perbaikan); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRPL/VRPerbaikan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-596</td>
                <td class="text-left">Uang Makan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_um); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRPL/VRMakan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-597</td>
                <td class="text-left">Uang Dexlite</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_dexlite); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRPL/VRDexlite?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-5971</td>
                <td class="text-left">Uang BBM</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <?php echo "<td class='text-right'><a href=''></a></td>"; ?>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Selisih BBM</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="thick-line"></td>
            </tr>
            <tr>
                <td>5-598</td>
                <td class="text-left">Bayar Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_kredit); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRPL/VRKredit?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
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
                <?php }
                else if ($laba_bersih_sebelum_pajak < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak); ?></td>

                <?php }
                else if ($total_tagihan == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
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
                <td><strong>LABA BERSIH BBM</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_bbm > 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_bbm < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>

                <?php }
                else if ($laba_bersih_bbm == 0) { ?>

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
<h3 class="text-center" >Laba Rugi Berdasarkan Kendaraan Plumpang</h3>
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
<thead>
    <tr>
      <th class="text-center" >No Polisi</th>
      <th class="text-center" >Jenis Kendaraan</th>
      <th></th>
    </tr>
  </thead>
  <tbody>

    <?php while($data = mysqli_fetch_array($table10)){
     $mt = $data['mt'];
     
     $result = mysqli_query($koneksibalsri_jbb, "SELECT * FROM kendaraan WHERE no_polisi = '$mt' ");
    $data_ken = mysqli_fetch_array($result);
    $jenis_ken = $data_ken['jenis_kendaraan']; 

     echo "<tr>
     <td style='font-size: 14px' align = 'center'>$mt</td>
     <td style='font-size: 14px' align = 'center'>$jenis_ken</td>"?>
     <?php echo "<td class='text-center'><a href='VLRKendaraanPL?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&no_polisi=$mt'>LR Kendaraan</a></td>"; ?>
     
    
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