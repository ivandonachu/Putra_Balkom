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
  $table = mysqli_query($koneksipbr, "SELECT * FROM riwayat_saldo_armada WHERE tanggal = '$tanggal_awal' ");
$table2 = mysqli_query($koneksipbr, "SELECT * FROM rekening ");
}
else{
$table = mysqli_query($koneksipbr, "SELECT * FROM riwayat_saldo_armada  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ");
$table2 = mysqli_query($koneksipbr, "SELECT * FROM rekening ");

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
 <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsPTPBRMES">
     <div class="sidebar-brand-icon rotate-n-15">

     </div>
     <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="gambar/Logo CBM.png" ></div>
 </a>

 <!-- Divider -->
 <hr class="sidebar-divider my-0">

 
   <!-- Nav Item - Dashboard -->
 <li class="nav-item active" >
     <a class="nav-link" href="DsPTPBRMES">
         <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
         <span style="font-size: 16px;" >Dashboard</span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">
     <!-- Heading -->
     <div class="sidebar-heading" style="font-size: 15px; color:white;">
          Menu PBRMES
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
             <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.CBM/view/DsPTCBM">PT. CBM</a>
             <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/CV.PBJ/view/DsCVPBJ">CV.PBJ</a>
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
       <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
     15  aria-expanded="true" aria-controls="collapseTwo">
       <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
       <span style="font-size: 15px; color:white;" >Laporan Perusahan</span>
   </a>
   <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
       <div class="bg-white py-2 collapse-inner rounded">
           <h6 class="collapse-header" style="font-size: 15px;">Laporan</h6>
           <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan1">Laporan Keuangan</a>
           <a class="collapse-item" style="font-size: 15px;" href="VLPenjualan1">Laporan Penjualan</a>
           <?php if($nama == 'Nyoman Edy Susanto'){
           echo"<a class='collapse-item' style='font-size: 15px;' href='VLabaRugi'>Laba Rugi PBR</a>
                <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiMes'>Laba Rugi MES</a>";
           } ?>
           <a class="collapse-item" style="font-size: 15px;" href="VPenggunaanSaldo">Laporan Saldo</a>
           <a class="collapse-item" style="font-size: 15px;" href="VBonKaryawan">Laporan BON</a>
           <a class="collapse-item" style="font-size: 15px;" href="VRincianSAMES">Rincian SA MES</a>
           <a class="collapse-item" style="font-size: 15px;" href="VRincianSAPBR">Rincian SA PBR</a>
           <a class="collapse-item" style="font-size: 15px;" href="VKeberangkatan">Uang Jalan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaran">Pengeluaran Kasir</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Gaji Karyawan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranWorkshop">Pengeluaran Workshop</a>
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
 <?php  echo "<form  method='POST' action='VPenggunaanSaldo2' style='margin-bottom: 15px;'>" ?>
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
     <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
   </div>
   </div>
  



<!-- Tabel -->    
<div style="overflow-x: auto" align = 'center' >
  <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Akun</th>
      <th>REF/Tujuan</th>
      <th>Saldo/Asal</th>
      <th>Debit</th>
      <th>Kredit</th>
      <th>Keterangan</th>
      <th>File</th>
    </tr>
  </thead>
  <tbody>
    <?php
    //dana masuk cbm ke mes
    $dana_masuk_cbm_mes = 0;
    //dana masuk cbm ke pbr
    $dana_masuk_cbm_pbr = 0;


  
    //setor mes ke  mes
    $setor_mes_mes = 0;
    //setor pbr ke pbr
    $setor_pbr_pbr = 0;


    
    $urut = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>
    <?php while($data = mysqli_fetch_array($table)){
      $no_laporan = $data['no_laporan'];
      $tanggal =$data['tanggal'];
      $referensi = $data['referensi'];
      $nama_akun = $data['nama_akun'];
      $nama_rekening = $data['nama_rekening'];
      $jumlah = $data['jumlah'];
      $file_bukti = $data['file_bukti'];
      $keterangan = $data['keterangan'];
      $status_saldo = $data['status_saldo'];
    
    //Dana Masuk cbm ke pbr
    if ($status_saldo == 'Masuk' && $nama_rekening == 'CBM' && $referensi == 'PBR') {
        $dana_masuk_cbm_mes = $dana_masuk_cbm_mes + $jumlah;
      }
    //Dana Masuk CBM Keluar mes
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'CBM' && $referensi == 'MES') {
        $dana_masuk_cbm_pbr = $dana_masuk_cbm_pbr + $jumlah;
      }
    //Setor pbr kELUAR pbr
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBR' && $referensi == 'PBR') {
        $setor_mes_mes = $setor_mes_mes + $jumlah;
      }
    //Setor mes keluar mes
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'MES' && $referensi == 'MES') {
        $setor_pbr_pbr = $setor_pbr_pbr + $jumlah;
      }
   
   

        $urut = $urut + 1;

      echo "<tr>
      <td style='font-size: 14px'>$urut</td>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$nama_akun</td>
      <td style='font-size: 14px'>$referensi</td>
      <td style='font-size: 14px'>$nama_rekening</td>";


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
      <td style='font-size: 14px'>"; ?> <a download="/PT.PBR/KasirToko/file_toko/<?= $file_bukti ?>" href="/PT.PBR/KasirToko/file_toko/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
    </tr>";
  }
  ?>

</tbody>
</table>
</div>
  </div>
<br>
<br>
<br>

<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h6 align="center">Rekap Saldo MES & PBR</h6>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Total Setor PBR ke PBR</th>
      <th>Total Setor MES ke MES</th>
      <th>Total Dana Masuk CBM ke PBR</th>
      <th>Total Dana Masuk CBM ke MES</th>

    </tr>
  </thead>
  <tbody>

    <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($setor_pbr_pbr); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($setor_mes_mes); ?> <?php echo "</td>
      
      <td style='font-size: 14px'>";?> <?= formatuang($dana_masuk_cbm_pbr); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($dana_masuk_cbm_mes); ?> <?php echo "</td>
      

        </tr>";
  
  ?>

</tbody>
</table>
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