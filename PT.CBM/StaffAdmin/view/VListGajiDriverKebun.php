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
if ($jabatan_valid == 'Staff Admin') {

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
   $table = mysqli_query($koneksikebun,"SELECT * FROM laporan_rit  WHERE tanggal ='$tanggal_awal' ");
   $table2 = mysqli_query($koneksikebun,"SELECT * FROM laporan_rit  WHERE tanggal ='$tanggal_awal' GROUP BY nama_driver ");
 
 }
 
 else{
   $table = mysqli_query($koneksikebun,"SELECT * FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $table2 = mysqli_query($koneksikebun,"SELECT * FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY nama_driver");
 
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

  <title>List Gaji Driver Kebun</title>

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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsStaffAdmin">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active" >
    <a class="nav-link" href="DsStaffAdmin">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu Staff Admin
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Admin Karyawaan</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Gaji & Kas</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Penggajian dan Rekap</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKasKecil">Pencatatan Kas Kecil</a>
            <a class="collapse-item" style="font-size: 15px;" href="VBonKaryawan">Bon Bulanan Karyawan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VBonPribadi">Bon Pribadi Karyawan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKaryawan">List Karyawan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKredit">Kredit</a>
            <a class="collapse-item" style="font-size: 15px;" href="VBungaBank">Bunga Bank</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTransportFee">Transport Fee</a>
        </div>
    </div>
</li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwox"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-dollar-sign" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Rekap Gaji CBM</span>
    </a>
    <div id="collapseTwox" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Rekap Gaji CBM</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiCBM">List Gaji CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiCBM">Rekap Gaji CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiDriverCBM">List Gaji Driver CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiDriverCBM">Rekap Gaji Driver CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiDriverKebun">List Gaji Driver Kebun</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiDriverKebun">Rekap Gaji Driver Kebun</a>
        </div>
    </div>
</li>
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwox1"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-dollar-sign" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Rekap Gaji MES</span>
    </a>
    <div id="collapseTwox1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Rekap Gaji MES</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiMES">List Gaji MES</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiMES">Rekap Gaji MES</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiDriverMES">List Gaji Driver MES</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiDriverMES">Rekap Gaji Driver MES</a>
        </div>
    </div>
</li>
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-dollar-sign" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Rekap Gaji PBR</span>
    </a>
    <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Rekap Gaji PBR</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiPBR">List Gaji PBR</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiPBR">Rekap Gaji PBR</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiDriverPBR">List Gaji Driver PBR</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiDriverPBR">Rekap Gaji Driver PBR</a>
        </div>
    </div>
</li>
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-dollar-sign" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Rekap Gaji PBJ</span>
    </a>
    <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Rekap Gaji PBJ</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiPBJ">List Gaji PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiPBJ">Rekap Gaji PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiDriverPBJ">List Gaji Driver PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiDriverPBJ">Rekap Gaji Driver PBJ</a>
        </div>
    </div>
</li>
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo4"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-dollar-sign" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Rekap Gaji Balsri</span>
    </a>
    <div id="collapseTwo4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Rekap Gaji Balsri</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiBalsri">List Gaji Balsri</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiBalsri">Rekap Gaji Balsri</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiDriverBalsri">List Gaji Driver Balsri</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiDriverBalsri">Rekap Gaji Driver Balsri</a>
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
      <?php echo "<a href='VListGajiDriverKebun'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>List Gaji Driver Kebun</h5></a>"; ?>
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

  <?php echo "<form  method='POST' action='VListGajiDriverCBM' style='margin-bottom: 15px;'>" ?>
            <div>
              <div align="left" style="margin-left: 20px;">
                <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1">
                <span>-</span>
                <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
                <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm">Lihat</button>
              </div>
            </div>
            </form>
  <div class="row">
    <div class="col-md-10">
    <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
    </div>
    <div class="col-md-2">
      <!-- Button Input Data Bayar -->
      <div align="right">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inputx"> <i class="fas fa-plus-square mr-2"></i>REKAP GAJI</button> <br> <br>
      </div>
      <!-- Form Modal  -->
      <div class="modal fade bd-example-modal-lg" id="inputx" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h5 class="modal-title">Persetujuan Rekap Gaji</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div> 

          <!-- Form Input Data -->
          <div class="modal-body" align="left">
            <?php  echo "<form action='../proses/proses_rekap_gaji_driver_kebun?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

            <br>

            <div class="row">
              <div class="col-md-6">
                 <label>Tanggal</label>
                 <input class="form-control form-control-sm" type="date" id="tanggal" name="tanggal" required="">
              </div>
              <div class="col-md-6">
             
              </div>
           </div>

           <br>
           
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">REKAP</button>

      </div>
    </form>
  </div>
</div>
</div>
</div>
</div>
</div>


<h5 align="center" >Rincian Gaji Driver Kebun</h5>
<!-- Tabel -->    
<div style="overflow-x: auto" align = 'center' >
  <table id="example2" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>Nama Driver</th>
      <th>Jabatan</th>
      <th>Rit Muat Sawit Dabuk</th>
      <th>Upah Muat Sawit Dabuk</th>
      <th>Rit Muat Getah Palembang</th>
      <th>Upah Muat Getah Palembang</th>
      <th>Rit Muat Pupuk ke Gudang</th>
      <th>Upah Muat Pupuk ke Gudang</th>
      <th>Rit Muat Nipah</th>
      <th>Upah Muat Nipah</th>
      <th>Rit Kampas Pupuk Kebun Lenkiti</th>
      <th>Upah Kampas Pupuk Kebun Lenkiti</th>
      <th>Rit Muat Batu</th>
      <th>Upah Muat Batu</th>
      <th>Upah Total</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    $total_gaji_sawit_dabuk = 0;
    $total_gaji_pupuk_kegudang = 0;
    $total_gaji_getah_palembang = 0;
    $total_gaji_muat_nipah = 0;
    $total_gaji_kebun_lengkiti = 0;
    $total_gaji_batu =0;

    $total_rit_sawit_dabuk = 0;
    $total_rit_pupuk_kegudang = 0;
    $total_rit_getah_palembang = 0;
    $total_rit_muat_nipah = 0;
    $total_rit_kebun_lengkiti = 0;
    $total_rit_batu = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

  ?>
    <?php while($data = mysqli_fetch_array($table2)){
      $nama_driver = $data['nama_driver'];
      $nama_rute =$data['nama_rute'];
      //sawit dabuk
      $table3 = mysqli_query($koneksikebun,"SELECT SUM(uang_gaji) AS uang_gaji_sawit_dabuk, SUM(rit) AS rit_sawit_dabuk FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver' AND nama_rute = 'Muat Sawit Dabuk'");
      $data3 = mysqli_fetch_array($table3);
      $total_gaji_sawit_dabuk = $data3['uang_gaji_sawit_dabuk'];
      if (  $total_gaji_sawit_dabuk == ""  ) {
        $total_gaji_sawit_dabuk = 0;
      }
      $total_rit_sawit_dabuk = $data3['rit_sawit_dabuk'];
      if (  $total_rit_sawit_dabuk == ""  ) {
        $total_rit_sawit_dabuk = 0;
      }
      
      //pupuk_kepalembang

      $table4 = mysqli_query($koneksikebun,"SELECT SUM(uang_gaji) AS uang_gaji_pupuk_gudang , SUM(rit) AS rit_pupuk_gudang FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Muat Pupuk Ke Gudang'");
      $data4 = mysqli_fetch_array($table4);

      $total_gaji_pupuk_kegudang = $data4['uang_gaji_pupuk_gudang'];
      if (  $total_gaji_pupuk_kegudang == ""  ) {
        $total_gaji_pupuk_kegudang = 0;
      }

      $total_rit_pupuk_kegudang = $data4['rit_pupuk_gudang'];
      if (  $total_rit_pupuk_kegudang == ""  ) {
        $total_rit_pupuk_kegudang = 0;
      }


      //getah palembang
      $table5 = mysqli_query($koneksikebun,"SELECT SUM(uang_gaji) AS uang_gaji_getah_palembang , SUM(rit) AS rit_getah_palembang FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Muat Getah Palembang'");
      $data5 = mysqli_fetch_array($table5);

      $total_gaji_getah_palembang = $data5['uang_gaji_getah_palembang'];
      if (  $total_gaji_getah_palembang == ""  ) {
        $total_gaji_getah_palembang = 0;
      }

      $total_rit_getah_palembang = $data5['rit_getah_palembang'];
      if (  $total_rit_getah_palembang == ""  ) {
        $total_rit_getah_palembang = 0;
      }

      //muat nipah
      $table6 = mysqli_query($koneksikebun,"SELECT SUM(uang_gaji) AS uang_gaji_muat_nipah , SUM(rit) AS rit_muat_nipah FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Muat Nipah'");
      $data6 = mysqli_fetch_array($table6);

      $total_gaji_muat_nipah = $data6['uang_gaji_muat_nipah'];
      if (  $total_gaji_muat_nipah == ""  ) {
        $total_gaji_muat_nipah = 0;
      }

      $total_rit_muat_nipah = $data6['rit_muat_nipah'];
      if (  $total_rit_muat_nipah == ""  ) {
        $total_rit_muat_nipah = 0;
      }

      // kebun lengkiti
      $table7 = mysqli_query($koneksikebun,"SELECT SUM(uang_gaji) AS uang_gaji_kebun_lengkiti , SUM(rit) AS rit_kebun_lengkiti FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Muat Pupuk Kebun Lengkiti'");
      $data7 = mysqli_fetch_array($table7);

      $total_gaji_kebun_lengkiti = $data7['uang_gaji_kebun_lengkiti'];
      if (  $total_gaji_kebun_lengkiti == ""  ) {
        $total_gaji_kebun_lengkiti = 0;
      }

      $total_rit_kebun_lengkiti = $data7['rit_kebun_lengkiti'];
      if (  $total_rit_kebun_lengkiti == ""  ) {
        $total_rit_kebun_lengkiti = 0;
      }

      // muat batu
      $table8 = mysqli_query($koneksi,"SELECT SUM(uang_gaji) AS uang_gaji_batu , SUM(rit) AS rit_batu FROM laporan_rit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND  nama_driver = '$nama_driver'AND nama_rute = 'Muat Batu'");
      $data8 = mysqli_fetch_array($table8);

      $total_gaji_batu = $data8['uang_gaji_batu'];
      if (  $total_gaji_batu == ""  ) {
        $total_gaji_batu = 0;
      }

      $total_rit_batu = $data8['rit_batu'];
      if (  $total_rit_batu == ""  ) {
        $total_rit_batu = 0;
      }
      

      echo "<tr>
    <td style='font-size: 14px' >$nama_driver</td>
    <td style='font-size: 14px' >Driver</td>
    <td style='font-size: 14px' >$total_rit_sawit_dabuk</td>
    <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($total_gaji_sawit_dabuk); ?> <?php echo "</td>
    <td style='font-size: 14px' >$total_rit_getah_palembang</td>
    <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($total_gaji_getah_palembang); ?> <?php echo "</td>
    <td style='font-size: 14px' >$total_rit_pupuk_kegudang</td>
    <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($total_gaji_pupuk_kegudang); ?> <?php echo "</td>

    <td style='font-size: 14px' >$total_rit_muat_nipah</td>
    <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($total_gaji_muat_nipah); ?> <?php echo "</td>
    <td style='font-size: 14px' >$total_rit_kebun_lengkiti</td>
    <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($total_gaji_kebun_lengkiti); ?> <?php echo "</td>
    <td style='font-size: 14px' >$total_rit_batu</td>
    <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($total_gaji_batu); ?> <?php echo "</td>
    <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($total_gaji_sawit_dabuk + $total_gaji_pupuk_kegudang + $total_gaji_getah_palembang + $total_gaji_muat_nipah + $total_gaji_kebun_lengkiti+ $total_gaji_batu); ?> <?php echo "</td>


 </tr>";
}

?>
</tbody>
</table>
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
    var table = $('#example2').DataTable( {
      lengthChange: true,
      buttons: [ 'copy', 'excel', 'csv', 'pdf', 'colvis' ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

</body>

</html>