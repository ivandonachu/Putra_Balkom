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
if ($jabatan_valid == 'Administrasi') {

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

  $table = mysqli_query($koneksi, "SELECT * FROM pengiriman_br a INNER JOIN driver b ON a.no_driver=b.no_driver INNER JOIN kendaraan c ON c.no=a.no WHERE tanggal = '$tanggal_awal' ORDER BY a.tanggal");

  $table2 = mysqli_query($koneksi, "SELECT SUM(jt_gps) AS total_jt_gps, SUM(jt_odo) AS total_jt_odo , SUM(dexlite) AS total_dex, SUM(um) AS uang_makan, SUM(ug) AS uang_gaji, SUM(uj) AS uang_jalan FROM pengiriman_br WHERE tanggal = '$tanggal_awal'");
  $data2 = mysqli_fetch_array($table2);
  $jml_jt_gps= $data2['total_jt_gps'];
  $jml_jt_odo= $data2['total_jt_odo'];
  $jml_dex= $data2['total_dex'];
  $total_um= $data2['uang_makan'];
  $total_ug= $data2['uang_gaji'];
  $total_uj= $data2['uang_jalan'];

  $table3 = mysqli_query($koneksi,"SELECT * FROM pengiriman_br WHERE tanggal = '$tanggal_awal' AND jns_trans = 'Lost' ");
  $data3 = mysqli_fetch_array($table3);
  $total_lost = $data3['jml_trans'];
  if (!isset($data3['jml_trans'])) {
    $total_lost = 0;
}

  $table4 = mysqli_query($koneksi,"SELECT * FROM pengiriman_br WHERE tanggal = '$tanggal_awal' AND jns_trans = 'Surplus' ");
  $data4 = mysqli_fetch_array($table4);
  $total_surplus = $data4['jml_trans'];
  if (!isset($data4['jml_trans'])) {
    $total_surplus = 0;
}

}
else{

  $table = mysqli_query($koneksi, "SELECT * FROM pengiriman_br a INNER JOIN driver b ON a.no_driver=b.no_driver INNER JOIN kendaraan c ON c.no=a.no WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY a.tanggal");

  $table2 = mysqli_query($koneksi, "SELECT SUM(jt_gps) AS total_jt_gps, SUM(jt_odo) AS total_jt_odo , SUM(dexlite) AS total_dex, SUM(um) AS uang_makan, SUM(ug) AS uang_gaji, SUM(uj) AS uang_jalan FROM pengiriman_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data2 = mysqli_fetch_array($table2);
  $jml_jt_gps= $data2['total_jt_gps'];
  $jml_jt_odo= $data2['total_jt_odo'];
  $jml_dex= $data2['total_dex'];
  $total_um= $data2['uang_makan'];
  $total_ug= $data2['uang_gaji'];
  $total_uj= $data2['uang_jalan'];

  $table3 = mysqli_query($koneksi,"SELECT SUM(jml_trans) AS lost FROM pengiriman_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND jns_trans = 'Lost' ");
  $data3 = mysqli_fetch_array($table3);
  $total_lost = $data3['lost'];
  if (!isset($data3['lost'])) {
    $total_lost = 0;
}
  $table4 = mysqli_query($koneksi,"SELECT SUM(jml_trans) AS surplus FROM pengiriman_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND jns_trans = 'Surplus' ");
  $data4 = mysqli_fetch_array($table4);
  $total_surplus = $data4['surplus'];
  if (!isset($data4['surplus'])) {
    $total_surplus = 0;
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

  <title>Pencatatan Pengiriman</title>

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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsAdministrasi">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active" >
    <a class="nav-link" href="DsAdministrasi">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu Administrasi
    </div>
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
            <a class="collapse-item" style="font-size: 15px;" href="VTagihan">Tagihan Lampung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanL8">Tagihan Lampung SPBU</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanP">Tagihan Pelembang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanBr">Tagihan Baturaja</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanBl">Tagihan Belitung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanBk">Tagihan Bangka</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarif">Master Tarif LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifL8">Master Tarif LMG SPBU</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifP">Master Tarif PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBr">Master Tarif BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBl">Master Tarif BL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBk">Master Tarif BK</a>
        </div>
    </div>
</li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-truck" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Pengiriman</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Pengiriman</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Pengiriman LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanL8">Pengiriman LMG SPBU</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaP">Pengiriman PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaBr">Pengiriman BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaBl">Pengiriman BL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaBk">Pengiriman BK</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitase">Ritase LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseL8">Ritase LMG SPBU</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseP">Ritase PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseBr">Ritase BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseBl">Ritase BL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseBk">Ritase BK</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuh">Jarak Tempuh LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhL8">Jarak Tempuh LMG SPBU</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhP">Jarak Tempuh PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBr">Jarak Tempuh BTA</a> 
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBl">Jarak Tempuh BL</a> 
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBk">Jarak Tempuh BK</a> 
            <a class="collapse-item" style="font-size: 15px;" href="VGaji">Gaji LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiL8">Gaji LMG SPBU</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiP">Gaji PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiBr">Gaji BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiBl">Gaji BL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiBk">Gaji BK</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Gaji Karyawan</a>
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
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikan">Catat Perbaikan LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanP">Catat Perbaikan PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanBr">Catat Perbaikan BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanBl">Catat Perbaikan BL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanBk">Catat Perbaikan BK</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPul">Pengeluaran Pul LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulP">Pengeluaran Pul PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBr">Pengeluaran Pul BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBl">Pengeluaran Pul BL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBk">Pengeluaran Pul BK</a>
        </div>
    </div>
</li>
 <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
      15  aria-expanded="true" aria-controls="collapseTwo1">
        <i class="fas fa-car" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >SDM</span>
    </a>
    <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VAMT">AMT</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMT">MT</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMT">MT</a>
            <a class="collapse-item" style="font-size: 15px;" href="VBayarKredit">Kredit Kendaraan</a>
        </div>
    </div>
</li>
 <!-- Nav Item - Pages Collapse Menu -->
 <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1z"
                  15  aria-expanded="true" aria-controls="collapseTwo1z">
                    <i class="fas fa-car" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >BBM</span>
                </a>
                <div id="collapseTwo1z" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu BBM</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VStokBBM">Lap Stok BBM</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VBBMMasuk">Lap BBM Masuk</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VBBMKeluar">Lap BBM Keluar</a>
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
      <?php echo "<a href='VPengirimanaBr?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Pencatatan Pengiriman BTA</h5></a>"; ?>
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



  <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">


    <?php  echo "<form  method='POST' action='VPengirimanaBr' style='margin-bottom: 15px;'>" ?>
    <div>
      <div align="left" style="margin-left: 20px;"> 
        <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1"> 
        <span>-</span>
        <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
        <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm" >Lihat</button>
      </div>
    </div>
  </form>


  <div class="col-md-8">
   <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
 </div>
 <br>

 <div class="row">
  <div class="col-md-10">

  </div>
  <div class="col-md-2">
    <!-- Button Input Data Bayar -->
    <div align="right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Catat Pengiriman</button> <br> <br>
    </div>
    <!-- Form Modal  -->
    <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role ="document">
       <div class="modal-content"> 
        <div class="modal-header">
          <h5 class="modal-title"> Form Pencatatan Pengiriman</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> 

        <!-- Form Input Data -->
        <div class="modal-body" align="left">
          <?php  echo "<form action='../proses/proses_pengiriman_br?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

          <br>
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
           <label>AMT</label>
           <select id="amt" name="amt" class="form-control ">
            <?php
            include 'koneksi.php';
            $result = mysqli_query($koneksi, "SELECT * FROM driver WHERE alamat = 'Baturaja'");   

            while ($data2 = mysqli_fetch_array($result)){
              $nama_driver = $data2['nama_driver'];


              echo "<option> $nama_driver </option> ";
              
            }
            ?>
          </select>
        </div>

        <div class="col-md-6">
          <label>MT</label>
          <select id="mt" name="mt" class="form-control">
            <?php
            include 'koneksi.php';
            $result = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE wilayah_operasi = 'Baturaja'");   

            while ($data2 = mysqli_fetch_array($result)){
              $no_polisi = $data2['no_polisi'];


              echo "<option> $no_polisi </option> ";
              
            }
            ?>
          </select>
        </div>            

      </div>

      <br>

      <div class="row">

        <div class="col-md-4">
          <label>JT GPS</label>
          <input class="form-control form-control-sm" type="number" id="jt_gps" name="jt_gps" required="">
        </div>    


        <div class="col-md-4">
          <label>JT ODO</label>
          <input class="form-control form-control-sm" type="number" id="jt_odo" name="jt_odo" required="">
        </div>

        <div class="col-md-4">
          <label>Muatan</label>
          <select id="muatan" name="muatan" class="form-control">
            <option>1000 L</option>
            <option>2000 L</option>
            <option>3000 L</option>
            <option>4000 L</option>
            <option>5000 L</option>
            <option>6000 L</option>
            <option>7000 L</option>
            <option>8000 L</option>
          </select>
        </div>                

      </div>

      <br>

      <div class="row">
        <div class="col-md-6">
          <label>Jenis Transprt</label>
          <select id="jns_trans" name="jns_trans" class="form-control">
            <option>Normal</option>
            <option>Lost</option>
            <option>Surplus</option>
          </select>

        </div>  

        <div class="col-md-6">
          <label>Jumlah Trasport</label>
          <input class="form-control form-control-sm" type="float" id="jml_trans" name="jml_trans" required="">

        </div>  
        <small>
          <ul>
             <li>Disi nol jika Normal</li>
             <li style="color: red;" >MASUKAN JUMLAH TOTAL LOST / SURPLUS (JIKA TIDAK NORMAL)</li>
          </ul>
        </small>            
      </div>

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
      <button type="submit" class="btn btn-primary"> CATAT</button>
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
<div style="overflow-x: auto" align = 'center';>
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>AMT</th>   
      <th>MT</th>
      <th>Jen Ken</th>
      <th>Muat</th>
      <th>JT GPS</th>
      <th>JT ODO</th>
      <th>DEX</th>
      <th>Uang DEX</th>
      <th>Uang Makan</th>
      <th>Gaji</th>
      <th>Uang Jalan</th>
      <th>Jns Trans</th>
      <th>Jml Trans</th>
      <th>KET</th>
      <th>File</th>
      <th></th>
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
      $amt =$data['nama_driver'];
      $mt = $data['no_polisi'];
      $jen_ken = $data['jenis_kendaraan'];
      $muatan = $data['muatan'];
      $jt_gps = $data['jt_gps'];
      $jt_odo = $data['jt_odo'];
      $dexlite = $data['dexlite'];
      $u_dex = $data['u_dex'];
      $um = $data['um'];
      $ug = $data['ug'];
      $uj = $data['uj'];
      $jns_trans = $data['jns_trans'];
      $jml_trans = $data['jml_trans'];
      $keterangan = $data['keterangan'];
      $file_bukti = $data['file_bukti'];

      $urut = $urut + 1;

      echo "<tr>
      <td style='font-size: 14px' align = 'center'>$urut</td>
      <td style='font-size: 14px' align = 'center'>$tanggal</td>
      <td style='font-size: 14px' align = 'center'>$amt</td>
      <td style='font-size: 14px' align = 'center'>$mt</td>
      <td style='font-size: 14px' align = 'center'>$jen_ken</td>
      <td style='font-size: 14px' align = 'center'>$muatan/L</td>
      <td style='font-size: 14px' align = 'center'>$jt_gps/Km</td>
      <td style='font-size: 14px' align = 'center'>$jt_odo/km</td>
      <td style='font-size: 14px' align = 'center'>$dexlite/L</td>
      <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($u_dex); ?> <?php echo "</td>
      <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($um); ?> <?php echo "</td>
      <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($ug); ?> <?php echo "</td>
      <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($uj); ?> <?php echo "</td>
      <td style='font-size: 14px' align = 'center'>$jns_trans</td>
      <td style='font-size: 14px' align = 'center'>$jml_trans</td>
      <td style='font-size: 14px' align = 'center'>$keterangan</td>
      "; ?>
      <?php echo "
      <td style='font-size: 14px'>"; ?> <a download="../file_administrasi/<?= $file_bukti ?>" href="../file_administrasi/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>
      <?php echo "<td style='font-size: 12px'>"; ?>
      <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_laporan']; ?>">Edit</button>

      <!-- Form EDIT DATA -->

      <div class="modal fade" id="formedit<?php echo $data['no_laporan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role ="document">
          <div class="modal-content"> 
            <div class="modal-header">
              <h5 class="modal-title"> Form Edit Dokumen </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true"> &times; </span>
              </button>
            </div>

            <!-- Form Edit Data -->
            <div class="modal-body">
              <form action="../proses/edit_pengiriman_br" enctype="multipart/form-data" method="POST">

                <input type="hidden" name="no_laporan" value="<?php echo $no_laporan;?>"> 
                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir;?>">

                <label>Tanggal</label>
                <div class="col-sm-10">
                 <input type="date" id="tanggal" name="tanggal" disabled="" value="<?php echo $tanggal;?>">
               </div>
              <br>

              <div class="row">

                <div class="col-md-6">
                 <label>AMT</label>

                 <select id="amt" name="amt" class="form-control ">
                   <?php
                   $dataSelect = $data['amt']; 
                   include 'koneksi.php';
                   $result = mysqli_query($koneksi, "SELECT * FROM driver WHERE alamat = 'Baturaja'");   

                   while ($data2 = mysqli_fetch_array($result)){
                    $nama_driver = $data2['nama_driver'];

                    echo "<option" ?> <?php echo ($dataSelect == $nama_driver) ? "selected" : "" ?>> <?php echo $nama_driver; ?> <?php echo "</option>" ;

                  }
                  ?>
                </select>


              </div>

              <div class="col-md-6">
                <label>MT</label>
                <select id="mt" name="mt" class="form-control">
                  <?php
                  $dataSelect = $data['mt']; 
                  include 'koneksi.php';
                  $result = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE wilayah_operasi = 'Baturaja'");   

                  while ($data2 = mysqli_fetch_array($result)){
                    $no_polisi = $data2['no_polisi'];

                    echo "<option" ?> <?php echo ($dataSelect == $no_polisi) ? "selected" : "" ?>> <?php echo $no_polisi; ?> <?php echo "</option>" ;

                  }
                  ?>
                </select>
              </div>            

            </div>

            <br>

            <div class="row">

              <div class="col-md-4">
                <label>JT GPS</label>
                <input class="form-control form-control-sm" type="number" id="jt_gps" name="jt_gps" required="" value="<?php echo $jt_gps;?>">
              </div>    


              <div class="col-md-4">
                <label>JT ODO</label>
                <input class="form-control form-control-sm" type="number" id="jt_odo" name="jt_odo" required="" value="<?php echo $jt_odo;?>">
              </div>

              <div class="col-md-4">
                <label>Muatan</label>
                <select id="muatan" name="muatan" class="form-control">
                  <?php $dataSelect = $data['muatan']; ?>
                  <option <?php echo ($dataSelect == '1000 L') ? "selected": "" ?> >1000 L</option>
                  <option <?php echo ($dataSelect == '2000 L') ? "selected": "" ?> >2000 L</option>
                  <option <?php echo ($dataSelect == '3000 L') ? "selected": "" ?> >3000 L</option>
                  <option <?php echo ($dataSelect == '4000 L') ? "selected": "" ?> >4000 L</option>
                  <option <?php echo ($dataSelect == '5000 L') ? "selected": "" ?> >5000 L</option>
                  <option <?php echo ($dataSelect == '6000 L') ? "selected": "" ?> >6000 L</option>
                  <option <?php echo ($dataSelect == '7000 L') ? "selected": "" ?> >7000 L</option>
                  <option <?php echo ($dataSelect == '8000 L') ? "selected": "" ?> >8000 L</option>
                </select>

              </div>                

            </div>

            <br>

            <div class="row">
              <div class="col-md-6">
                <label>Jenis Transprt</label>
                <select id="jns_trans" name="jns_trans" class="form-control">
                 <?php $dataSelect = $data['jns_trans']; ?>
                 <option <?php echo ($dataSelect == 'Normal') ? "selected": "" ?> >Normal</option>
                 <option <?php echo ($dataSelect == 'Lost') ? "selected": "" ?> >Lost</option>
                 <option <?php echo ($dataSelect == 'Surplus') ? "selected": "" ?> >Surplus</option>
               </select>

             </div>  

             <div class="col-md-6">
              <label>Jumlah Trasport</label>
              <input class="form-control form-control-sm" type="float" id="jml_trans" name="jml_trans" required="" value="<?php echo $jml_trans;?>" >

            </div>  
            <small>
              <ul>
                <li>Disi nol jika Normal</li>
                <li style="color: red;" >MASUKAN ULANG TOTAL JUMLAH LOST / SURPLUS (JIKA TIDAK NORMAL)</li>
              </ul>
            </small>            
          </div>

          <div>
           <label>Keterangan</label>
           <div class="form-group">
             <textarea id = "keterangan" name="keterangan"  style="width: 300px;" ><?php echo $keterangan;?></textarea>
           </div>
         </div>

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

<!-- Button Hapus -->
<button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_laporan']; ?>" data-toggle='tooltip' title='Hapus Data Dokumen'>Hapus</button>
<div class="modal fade" id="PopUpHapus<?php echo $data['no_laporan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
 <div class="modal-dialog" role ="document">
   <div class="modal-content"> 
    <div class="modal-header">
      <h4 class="modal-title"> <b> Hapus Data Sparepart </b> </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="close">
        <span aria-hidden="true"> &times; </span>
      </button>
    </div>

    <div class="modal-body">
      <form action="../proses/hapus_pengiriman_br" method="POST">
        <input type="hidden" name="no_laporan" value="<?php echo $no_laporan;?>">
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

<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total JT ODO</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jml_jt_odo  ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-road fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total JT GPS</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jml_jt_gps  ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-road fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total LOST</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_lost  ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Surplus</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_surplus  ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<br>
<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Uang Jalan</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_uj)  ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Gaji</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_ug)  ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Uang Makan</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_um)  ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total DEX</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jml_dex  ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-truck-moving fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
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