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
}  


function formatuang($angka){
  $uang = "Rp " . number_format($angka,2,',','.');
  return $uang;
}

if ($tanggal_awal == $tanggal_akhir) {
  // Tagihan
  $table = mysqli_query($koneksipbj, "SELECT muatan , harga_tagihan FROM riwayat_pengiriman WHERE tanggal = '$tanggal_awal'");
  
  $total_tagihan=0;
  while($data = mysqli_fetch_array($table)){
    $muatan = $data['muatan'];
    $harga_tagihan = $data['harga_tagihan'];

    $total_tagihan = $total_tagihan + ($muatan * $harga_tagihan);

  }
  //pengiriman
  $table2 = mysqli_query($koneksipbj, "SELECT SUM(uj_tagihan) AS total_uj, SUM(gaji_tagihan) AS total_gaji FROM riwayat_pengiriman WHERE tanggal_masuk = '$tanggal_awal'");
  $data2 = mysqli_fetch_array($table2);
  $total_uj= $data2['total_uj'];
  $total_gaji= $data2['total_gaji'];


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
$laba_bersih_sebelum_pajak = $total_tagihan - ($total_uj + $total_gaji + $jml_listrik + $jml_sewa + $jml_atk + $jml_perbaikan + $jml_pembelian + $jml_biaya_kantor);
    $total_biaya_usaha_final =  $jml_biaya_kantor + $jml_listrik + $jml_sewa + $jml_atk + $jml_perbaikan + $jml_pembelian + $total_uj + $total_gaji ;

}
else{
    // Tagihan
  $table = mysqli_query($koneksipbj, "SELECT muatan , harga_tagihan FROM riwayat_pengiriman WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $total_tagihan=0;
  while($data = mysqli_fetch_array($table)){
    $muatan = $data['muatan'];
    $harga_tagihan = $data['harga_tagihan'];

    $total_tagihan = $total_tagihan + ($muatan * $harga_tagihan);

  }
  //pengiriman
  $table2 = mysqli_query($koneksipbj, "SELECT SUM(uj_tagihan) AS total_uj, SUM(gaji_tagihan) AS total_gaji FROM riwayat_pengiriman WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data2 = mysqli_fetch_array($table2);
  $total_uj= $data2['total_uj'];
  $total_gaji= $data2['total_gaji'];
  
  //Gaji karyawan
   $table9 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Batu Bara' ");
   $data9 = mysqli_fetch_array($table9);
   $gaji_karyawan = $data9['jumlah_gaji'];
    if (!isset($data9['jumlah_gaji'])) {
    $gaji_karyawan = 0;
    }

  //pengeluran Pul Biaya Kantor
   $table3 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM riwayat_oprasional a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.kode_akun = '5-540' ");
   $data3 = mysqli_fetch_array($table3);
   $jml_biaya_kantor = $data3['jumlah_biaya_kantor'];
    if (!isset($data3['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor = 0;
    }

   //pengeluran Pul Listrik & Telepon
   $table4 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_listrik FROM riwayat_oprasional a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.kode_akun = '5-550' ");
   $data4 = mysqli_fetch_array($table4);
   $jml_listrik = $data4['jumlah_listrik'];
    if (!isset($data4['jumlah_listrikr'])) {
    $jml_listrik = 0;
    }

   //pengeluran Biaya Sewa
   $table5 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_sewa FROM riwayat_oprasional a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.kode_akun = '5-570' ");
   $data5 = mysqli_fetch_array($table5);
   $jml_sewa = $data5['jumlah_sewa'];
    if (!isset($data5['jumlah_sewa'])) {
    $jml_sewa = 0;
    }

   //pengeluran Alat Tulis Kantor
   $table6 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_atk FROM riwayat_oprasional a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.kode_akun = '5-520' ");
   $data6 = mysqli_fetch_array($table6);
   $jml_atk = $data6['jumlah_atk'];
    if (!isset($data6['jumlah_atk'])) {
    $jml_atk = 0;
    }
    
    //pengeluran akomodasi
   $table61 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS akomodasi FROM riwayat_oprasional a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.kode_akun = '5-530' ");
   $data61 = mysqli_fetch_array($table61);
   $jml_akomodasi = $data61['akomodasi'];
    if (!isset($data61['akomodasi'])) {
    $jml_akomodasi = 0;
    }
    
    //pengeluran Alat Tulis Kantor
   $table62 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS pemasaran FROM riwayat_oprasional a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.kode_akun = '5-580' ");
   $data62 = mysqli_fetch_array($table62);
   $jml_pemasaran = $data62['pemasaran'];
    if (!isset($data62['pemasaran'])) {
    $jml_pemasaran = 0;
    }
    
    //pengeluran Alat Tulis Kantor
   $table63 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS lain FROM riwayat_oprasional a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.kode_akun = '5-590' ");
   $data63 = mysqli_fetch_array($table63);
   $jml_lain = $data63['lain'];
    if (!isset($data63['lain'])) {
    $jml_lain = 0;
    }

    //pengeluran perbaikan
   $table7 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS total_pembelian_sparepart FROM riwayat_perbaikan a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.kode_akun = '5-595' ");
   $data7 = mysqli_fetch_array($table7);
   $jml_pembelian = $data7['total_pembelian_sparepart'];
    if (!isset($data7['total_pembelian_sparepart'])) {
    $jml_pembelian = 0;
    }

    $table8 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_perbaikan FROM riwayat_perbaikan a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.kode_akun = '5-596' ");
   $data8 = mysqli_fetch_array($table8);
   $jml_perbaikan = $data8['jumlah_perbaikan'];
    if (!isset($data8['jumlah_perbaikan'])) {
    $jml_perbaikan = 0;
    }
    

    
    

}

    $laba_bersih_sebelum_pajak = $total_tagihan - ($total_uj + $total_gaji + $gaji_karyawan + $jml_akomodasi + $jml_listrik + $jml_sewa + $jml_atk + $jml_perbaikan + $jml_pembelian + $jml_biaya_kantor + $jml_pemasaran + $jml_lain);
    $total_biaya_usaha_final =  $jml_biaya_kantor + $jml_listrik + $jml_sewa + $jml_akomodasi + $jml_atk + $jml_perbaikan + $jml_pembelian + $total_uj + $total_gaji + $gaji_karyawan + $jml_pemasaran + $jml_lain;
?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laba Rugi Angkutan Batu Bara</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsCVPBJ">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3" > <img style="margin-top: 50px;" src="../gambar/Logo PBJ.PNG" ></div>
            </a>
            <br>
            
            <br>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active" >
                <a class="nav-link" href="DsCVPBJ">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 16px;" >Dashboard</span></a>
                </li>

                 <!-- Divider -->
                <hr class="sidebar-divider">
                <!-- Heading -->
                <div class="sidebar-heading" style="font-size: 15px; color:white;">
                     Menu CV.PBJ
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
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.CBM/view/DsPTCBM">PT.CBM</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/CV.PBJ/view/DsCVPBJ">CV.PBJ</a>
                        <a class="collapse-item" style="font-size: 15px;" href="DsCVPBJ">Transport BB</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.BALSRI/view/DsPTBALSRI">PT.BALSRI</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.MESPBR/view/DsPTPBRMES">PT. MES & PBR</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/Kebun/view/DsKebun">Kebun</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PERTASHOP/view/DsPertashop">Pertashop</a>
                    </div>
                </div>
            </li>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                  15  aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Laporan</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Laporan</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VLR">Laba Rugi</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLSaldo">Laporan Saldo</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VCatatPengiriman">Riwayat Pengiriman</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPerbaikan">Beban Kendaraan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VOperasional">Beban Operasional</a>
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
<div class="container" style="color : black;">
   <?php  echo "<form  method='POST' action='VLR2' style='margin-bottom: 15px;'>" ?>
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
                 <td class="text-left">Tagihan</td>
                 <td class="text-left"><?= formatuang($total_tagihan); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
                 <?php echo "<td class='text-right'><a href='VRincianLR/VRTagihan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>LABA KOTOR</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($total_tagihan); ?> </td>
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
                <td class="text-left">GAJI</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_gaji+$gaji_karyawan); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLR/VRGaji?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-520</td>
                <td class="text-left">Alat Tulis Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_atk); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLR/VRATK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-530</td>
                <td class="text-left">Transport & Akomodasi</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_akomodasi); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLR/VRTransport?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-540</td>
                <td class="text-left">Biaya Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_biaya_kantor); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLR/VRBiayaKantor?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-550</td>
                <td class="text-left">Listrik & Telepon</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_listrik); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLR/VRListrik?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-570</td>
                <td class="text-left">Biaya Sewa</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_sewa); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLR/VRBiayaSewa?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-580</td>
                <td class="text-left">Biaya Penjualan & Pemasaran</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_pemasaran); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLR/VRBiayaPen?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-590</td>
                <td class="text-left">Biaya Lain - Lain</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_lain); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLR/VRBiayaLain?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
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
                <td class="text-left">Pemeblian Sparepart</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_pembelian); ?></td>
               <?php echo "<td class='text-right'><a href='VRincianLR/VRPembelian?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-597</td>
                <td class="text-left">Uang Jalan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_uj); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLR/VRUangJalan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>"; ?>
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