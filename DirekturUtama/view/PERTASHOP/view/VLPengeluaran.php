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
else{
  $tanggal_awal = date('Y-m-1');
$tanggal_akhir = date('Y-m-31');
}

if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksiperta, "SELECT * FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal'");
  $table2 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS total_pengeluaran, lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal' GROUP BY b.lokasi");
  $table3 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal' GROUP BY a.sumber_dana");
  $table4 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana , lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal' AND lokasi = 'Bedilan' GROUP BY a.sumber_dana");
  $table5 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana , lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal' AND lokasi = 'Nusa Bakti' GROUP BY a.sumber_dana");
  $table6 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana , lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal' AND lokasi = 'Sumber Jaya' GROUP BY a.sumber_dana");
}
else{
  $table = mysqli_query($koneksiperta, "SELECT * FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $table2 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS total_pengeluaran, lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY b.lokasi");
  $table3 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY a.sumber_dana");
  $table4 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana , lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND lokasi = 'Bedilan' GROUP BY a.sumber_dana");
  $table5 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana , lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND lokasi = 'Nusa Bakti' GROUP BY a.sumber_dana");
  $table6 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana , lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND lokasi = 'Sumber Jaya' GROUP BY a.sumber_dana");
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

  <title>Pengeluaran</title>
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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsPertashop">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
</a>

<!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu Pertashop
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
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.BALSRI/view/DsPTBALSRI">PT.BALSRI</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.MESPBR/view/DsPTPBRMES">PT. MES & PBR</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/Kebun/view/DsKebun">Kebun</a>
            <a class="collapse-item" style="font-size: 15px;" href="DsPertashop">Pertashop</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.STRE/view/DsPTSTRE">PT.Sri Trans Energi</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BALSRI_JBB/view/DsBALSRIJBB">BALSRI JBB</a>
        </div>
    </div>
</li>
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
      15  aria-expanded="true" aria-controls="collapseOne">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Laporan</span>
    </a>
    <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Laporan</h6>
            
            <?php if($nama == 'Nyoman Edy Susanto'){
              echo"<a class='collapse-item' style='font-size: 15px;' href='VLabaRugiPs'>Laba Rugi</a>";
            } ?>
            <a class="collapse-item" style="font-size: 15px;" href="Setoran">Setoran</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLPenjualan">Lap Penjualan Pertamax</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLPenjualanDex">Lap Penjualan Dexlite</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCorPertamax">Lap Ngecor Pertamax</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCorDexlite">Lap Ngecor Dexlite</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLPengeluaran">Laporan Pengeluran</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan">Laporan Keuangan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPembelian">Laporan Pembelian</a>
            <a class="collapse-item" style="font-size: 15px;" href="VAbsensi">Absensi</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGrafikPenjualan">Grafik Penjualan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGrafikPenjualanPagi">Grafik Jual Pagi</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPenjualanPagi">Penjualan Pagi</a>
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
      <?php echo "<a href='VLPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Pengeluaran</h5></a>"; ?>

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
    <?php  echo "<form  method='POST' action='VLPengeluaran' style='margin-bottom: 15px;'>" ?>
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
    <div class="col-md-6">
     <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
   </div>
</div>


<!-- Tabel -->    
<div style="overflow-x: auto" align = 'center'>
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Kode Perta</th>
      <th>Lokasi</th>
      <th>Akun</th>
      <th>Keterangan</th>
      <th>Pengeluaran</th>
      <th>Total</th>
      <th>file</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total = 0;
    $urut = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>

    <?php while($data = mysqli_fetch_array($table)){
     $no_laporan = $data['no_transaksi'];
     $tanggal =$data['tanggal'];
     $kode_perta =$data['kode_perta'];
     $lokasi =$data['lokasi'];
     $nama_akun = $data['nama_akun'];
     $jumlah = $data['jumlah'];
     $keterangan = $data['keterangan'];
     $file_bukti = $data['file_bukti'];

     $total = $total + $jumlah;
     $urut = $urut + 1;


     echo "<tr>
     <td style='font-size: 14px'>$urut</td>
     <td style='font-size: 14px'>$tanggal</td>
     <td style='font-size: 14px'>$kode_perta</td>
     <td style='font-size: 14px'>$lokasi</td>
     <td style='font-size: 14px'>$nama_akun</td>
     <td style='font-size: 14px'>$keterangan</td>
     <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
     <td style='font-size: 14px'>"?>  <?= formatuang($total); ?> <?php echo "</td>
     <td style='font-size: 14px'>"; ?> <a download="/PERTASHOP/Administrasi/file_administrasi/<?= $file_bukti ?>" href="/PERTASHOP/Administrasi/file_administrasi/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
    </tr>";
  }

?>

</tbody>
</table>
</div>


<br>
<br>
<h5 align="center" >Total Pengeluaran</h5>
<!-- Tabel -->    
<table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Lokasi</th>
      <th>Total Pengeluaran</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    $total_seluruh = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table2)){
      $lokasi = $data['lokasi'];
      $total_pengeluaran =$data['total_pengeluaran'];
      $total_seluruh = $total_seluruh + $total_pengeluaran;

      echo "<tr>
      <td style='font-size: 14px' >$lokasi</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($total_pengeluaran); ?> <?php echo "</td>

      </tr>";
}
?>
      <td style='font-size: 14px; ' ><strong>TOTAL</strong></td>  
      <td style='font-size: 14px'> <strong> <?= formatuang($total_seluruh); ?></strong> </td>

      </tr>
</tbody>
</table>


<br>
<br>
<h5 align="center" >Total Pengeluaran Berdasarkan Sumber</h5>
<!-- Tabel -->    
<table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Sumber Dana</th>
      <th>Total Pengeluaran</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    $total_seluruh = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table3)){
      $sumber_dana = $data['sumber_dana'];
      $total_pengeluaran =$data['total_pengeluaran'];
      $total_seluruh = $total_seluruh + $total_pengeluaran;

      echo "<tr>
      <td style='font-size: 14px' >$sumber_dana</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($total_pengeluaran); ?> <?php echo "</td>

      </tr>";
}
?>
<td style='font-size: 14px; ' ><strong>TOTAL</strong></td>  
      <td style='font-size: 14px'> <strong> <?= formatuang($total_seluruh); ?></strong> </td>

      </tr>
</tbody>
</table>

<br>
<br>
<h5 align="center" >Total Pengeluaran Berdasarkan Sumber (Bedilan)</h5>
<!-- Tabel -->    
<table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Sumber Dana</th>
      <th>Total Pengeluaran</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    $total_seluruh = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table4)){
      $sumber_dana = $data['sumber_dana'];
      $total_pengeluaran =$data['total_pengeluaran'];
      $total_seluruh = $total_seluruh + $total_pengeluaran;

      echo "<tr>
      <td style='font-size: 14px' >$sumber_dana</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($total_pengeluaran); ?> <?php echo "</td>

      </tr>";
}
?>
<td style='font-size: 14px; ' ><strong>TOTAL</strong></td>  
      <td style='font-size: 14px'> <strong> <?= formatuang($total_seluruh); ?></strong> </td>

      </tr>
</tbody>
</table>

<br>
<br>
<h5 align="center" >Total Pengeluaran Berdasarkan Sumber (Nusa Bakti)</h5>
<!-- Tabel -->    
<table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Sumber Dana</th>
      <th>Total Pengeluaran</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    $total_seluruh = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table5)){
      $sumber_dana = $data['sumber_dana'];
      $total_pengeluaran =$data['total_pengeluaran'];
      $total_seluruh = $total_seluruh + $total_pengeluaran;

      echo "<tr>
      <td style='font-size: 14px' >$sumber_dana</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($total_pengeluaran); ?> <?php echo "</td>

      </tr>";
}
?>
<td style='font-size: 14px; ' ><strong>TOTAL</strong></td>  
      <td style='font-size: 14px'> <strong> <?= formatuang($total_seluruh); ?></strong> </td>

      </tr>
</tbody>
</table>


<br>
<br>
<h5 align="center" >Total Pengeluaran Berdasarkan Sumber (Sumber Jaya)</h5>
<!-- Tabel -->    
<table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Sumber Dana</th>
      <th>Total Pengeluaran</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    $total_seluruh = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table6)){
      $sumber_dana = $data['sumber_dana'];
      $total_pengeluaran =$data['total_pengeluaran'];
      $total_seluruh = $total_seluruh + $total_pengeluaran;

      echo "<tr>
      <td style='font-size: 14px' >$sumber_dana</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($total_pengeluaran); ?> <?php echo "</td>

      </tr>";
}
?>
<td style='font-size: 14px; ' ><strong>TOTAL</strong></td>  
      <td style='font-size: 14px'> <strong> <?= formatuang($total_seluruh); ?></strong> </td>

      </tr>
</tbody>
</table>



<br>
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