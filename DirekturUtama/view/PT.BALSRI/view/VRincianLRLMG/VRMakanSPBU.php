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

if ($tanggal_awal == $tanggal_akhir) {
    $table = mysqli_query($koneksibalsri, "SELECT  SUM(um) AS uang_makan FROM pengiriman_spbu a  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");

}

else{
    $table = mysqli_query($koneksibalsri, "SELECT SUM(a.um) AS uang_makan , b.no_polisi FROM pengiriman_spbu a INNER JOIN kendaraan b ON a.no=b.no WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY b.no_polisi ");
    $table2 = mysqli_query($koneksibalsri, "SELECT SUM(a.um) AS uang_makan , b.nama_driver FROM pengiriman_spbu a INNER JOIN driver b ON a.no_driver=b.no_driver WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY b.nama_driver ");

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

  <title>Rincian Uang Makan Driver Lampung 8KL</title>

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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="/bootstrap-select/dist/css/bootstrap-select.css">

  <!-- Link datepicker -->

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
     <hr class="sidebar-divider">
     <!-- Heading -->
     <div class="sidebar-heading" style="font-size: 15px; color:white;">
          Menu PT BALSRI
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
             <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BatuBara/view/DsCVPBJ">Transport BB</a>
             <a class="collapse-item" style="font-size: 15px;" href="../DsPTBALSRI">PT.BALSRI</a>
             <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.MESPBR/view/DsPTPBRMES">PT. MES & PBR</a>
             <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/Kebun/view/DsKebun">Kebun</a>
             <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PERTASHOP/view/DsPertashop">Pertashop</a>
             <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.STRE/view/DsPTSTRE">PT.Sri Trans Energi</a>
         </div>
     </div>
 </li>
 <!-- Nav Item - Pages Collapse Menu -->
 <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
       15  aria-expanded="true" aria-controls="collapseOne">
         <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
         <span style="font-size: 15px; color:white;" >Tagihan</span>
     </a>
     <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
         <div class="bg-white py-2 collapse-inner rounded">
             <h6 class="collapse-header" style="font-size: 15px;">Menu Tagihan</h6>
             <a class="collapse-item" style="font-size: 15px;" href="../VTagihan">Tagihan Lampung</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VTagihanL8">Tagihan Lampung 8KL</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VTagihanP">Tagihan Pelmbang</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VTagihanBr">Tagihan Baturaja</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VTagihanBl">Tagihan Babel</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VLrGlobal">Laba Rugi Global</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugi">Laba Rugi Lampung</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugiP">Laba Rugi Palembang</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugiBr">Laba Rugi Baturaja</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugiBl">Laba Rugi Babel</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VMasterTarif">Master Tarif LMG</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VMasterTarifL8">Master Tarif LMG 8KL</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VMasterTarifP">Master Tarif PLG</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VMasterTarifBr">Master Tarif BTA</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VMasterTarifBl">Master Tarif BB</a>
         </div>
     </div>
 </li>
 
     <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
       15  aria-expanded="true" aria-controls="collapseTwo">
         <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
         <span style="font-size: 15px; color:white;" >Pengiriman</span>
     </a>
     <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
         <div class="bg-white py-2 collapse-inner rounded">
             <h6 class="collapse-header" style="font-size: 15px;">Menu Pengiriman</h6>
             <a class="collapse-item" style="font-size: 15px;" href="../VPengiriman">Pengiriman LMG</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VPengirimanL8">Pengiriman LMG 8KL</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VPengirimanaP">Pengiriman PLG</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VPengirimanaBr">Pengiriman BTA</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VPengirimanaBl">Pengiriman BB</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VRitase">Ritase LMG</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VRitaseL8">Ritase LMG 8KL</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VRitaseP">Ritase PLG</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VRitaseBr">Ritase BTA</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VRitaseBl">Ritase BB</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VJarakTempuh">Jarak Tempuh LMG</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VJarakTempuhL8">Jarak Tempuh LMG 8KL</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VJarakTempuhP">Jarak Tempuh PLG</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VJarakTempuhBr">Jarak Tempuh BTA</a> 
             <a class="collapse-item" style="font-size: 15px;" href="../VJarakTempuhBl">Jarak Tempuh BB</a> 
             
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
             <a class="collapse-item" style="font-size: 15px;" href="../VCatatPerbaikan">Catat Perbaikan LMG</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VCatatPerbaikanP">Catat Perbaikan PLG</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VCatatPerbaikanBr">Catat Perbaikan BTA</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VCatatPerbaikanBl">Catat Perbaikan BB</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VPengeluaranPul">Pengeluaran Pul LMG</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VPengeluaranPulP">Pengeluaran Pul PLG</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VPengeluaranPulBr">Pengeluaran Pul BTA</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VPengeluaranPulBl">Pengeluaran Pul BB</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VGaji">Gaji LMG</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VGajiL8">Gaji LMG 8KL</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VGajiP">Gaji PLG</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VGajiBr">Gaji BTA</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VGajiBl">Gaji BB</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VGajiKaryawan">Gaji Karyawan</a>
         </div>
     </div>
 </li>
  <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo13"
       15  aria-expanded="true" aria-controls="collapseTwo1">
         <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
         <span style="font-size: 15px; color:white;" >SDM</span>
     </a>
     <div id="collapseTwo13" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
         <div class="bg-white py-2 collapse-inner rounded">
             <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
             <a class="collapse-item" style="font-size: 15px;" href="../VAMT">AMT</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VMT">MT</a>
         </div>
     </div>
 </li>
   <!-- Nav Item - Pages Collapse Menu -->
   <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOnex"
       15  aria-expanded="true" aria-controls="collapseOne">
         <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
         <span style="font-size: 15px; color:white;" >Data Backup</span>
     </a>
     <div id="collapseOnex" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
         <div class="bg-white py-2 collapse-inner rounded">
             <h6 class="collapse-header" style="font-size: 15px;">Menu Tagihan</h6>
             <a class="collapse-item" style="font-size: 15px;" href="../VLuangOPx">Lap uang Oprasional</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VTagihanx">Tagihan Lampung</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VTagihanPx">Tagihan Pelmbang</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VTagihanBrx">Tagihan Baturaja</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VLrGlobalx">Laba Rugi Global</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugix">Laba Rugi Lampung</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugiPx">Laba Rugi Palembang</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugiBrx">Laba Rugi Baturaja</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VMasterTarifx">Master Tarif LMG</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VMasterTarifPx">Master Tarif PLG</a>
             <a class="collapse-item" style="font-size: 15px;" href="../VMasterTarifBrx">Master Tarif BTA</a>
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
      <?php echo "<a href='VRMakantanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Rincian Uang Makan Driver Lampung 8KL</h5></a>"; ?>

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

<!-- Top content -->
<div>   


  <!-- Name Page -->
  <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">


    
    <div>
    <div align="left">
      <?php echo "<a href='../VLabaRugi2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><button type='button' class='btn btn-primary'>Kembali</button></a>"; ?>
    </div>
    </div>
  
  
  <div class="row">
    <div class="col-md-6">
     <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
   </div>
   
</div>





<!-- Tabel -->    
<h5 class="text-center" >Uang Makan Berdasarkan Kendaraan</h5>
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No Polisi</th>
      <th>Jumlah Uang Makan</th>
      <th>Total Uang Makan</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total=0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>

    <?php while($data = mysqli_fetch_array($table)){
      $uang_makan = $data['uang_makan'];
      $no_polisi =$data['no_polisi'];
    $total = $total + $uang_makan;

      echo "<tr>
     
      <td style='font-size: 14px'>$no_polisi</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($uang_makan); ?> <?php echo "</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($total); ?> <?php echo "</td>
      
 </tr>";
}
?>

</tbody>
</table>
<br>
<br>
<h5 class="text-center" >Uang Makan Berdasarkan Driver</h5>
<table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Nama Driver</th>
      <th>Jumlah Uang Makan</th>
      <th>Total Uang Makan</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total=0;

    ?>

    <?php while($data = mysqli_fetch_array($table2)){
      $nama_driver = $data['nama_driver'];
      $uang_makan = $data['uang_makan'];
    $total = $total + $uang_makan;

      echo "<tr>
     
      <td style='font-size: 14px'>$nama_driver</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($uang_makan); ?> <?php echo "</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($total); ?> <?php echo "</td>
      
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<script src="/sbadmin/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="/sbadmin/js/sb-admin-2.min.js"></script>
<script src="/bootstrap-select/dist/js/bootstrap-select.js"></script>
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
<script>
  function createOptions(number) {
    var options = [], _options;

    for (var i = 0; i < number; i++) {
      var option = '<option value="' + i + '">Option ' + i + '</option>';
      options.push(option);
    }

    _options = options.join('');

    $('#number')[0].innerHTML = _options;
    $('#number-multiple')[0].innerHTML = _options;

    $('#number2')[0].innerHTML = _options;
    $('#number2-multiple')[0].innerHTML = _options;
  }

  var mySelect = $('#first-disabled2');

  createOptions(4000);

  $('#special').on('click', function () {
    mySelect.find('option:selected').prop('disabled', true);
    mySelect.selectpicker('refresh');
  });

  $('#special2').on('click', function () {
    mySelect.find('option:disabled').prop('disabled', false);
    mySelect.selectpicker('refresh');
  });

  $('#basic2').selectpicker({
    liveSearch: true,
    maxOptions: 1
  });
</script>
</body>

</html>