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
$foto_profile = $data1['foto_profile'];
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

  $table4 = mysqli_query($koneksipbj, "SELECT driver, SUM(uj) AS total_gaji FROM pengiriman_s WHERE tanggal_antar = '$tanggal_awal' GROUP BY driver "); 

}
else{

 
   $table4 = mysqli_query($koneksipbj, "SELECT driver, SUM(uj) AS total_gaji FROM pengiriman_s  WHERE tanggal_antar BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY driver "); 
   $table4x = mysqli_query($koneksipbj, "SELECT driver, SUM(uj) AS total_gaji FROM pengiriman_sl  WHERE tanggal_antar BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY driver "); 
   $table = mysqli_query($koneksipbj,"SELECT * FROM sewa_hiblow WHERE tanggal_do BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");


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

  <title>Rincian Gaji</title>

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
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsCVPBJ">
        <div class="sidebar-brand-icon rotate-n-15">

        </div>
        <div class="sidebar-brand-text mx-3" > <img style="margin-top: 50px; height: 100px; width: 110px; " src="../gambar/Logo PBJ.png" ></div>
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
             Menu CV.PBJ (Semen)
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
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
          15  aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-clipboard-list" style="font-size: 15px; color:white;" ></i>
            <span style="font-size: 15px; color:white;" >Report Etty</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header" style="font-size: 15px;">Report</h6>
                <a class="collapse-item" style="font-size: 15px;" href="../VPenjualan">Laporan Penjualan</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VPengiriman">Laporan Pengiriman</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VKeuangan">Laporan Keuangan</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VPengeluran">Laporan Pengeluaran</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VPengeluaranWorkshop">Pengeluaran Workshop</a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3"
          15  aria-expanded="true" aria-controls="collapseTwo3">
            <i class="fa fa-clipboard-list" style="font-size: 15px; color:white;" ></i>
            <span style="font-size: 15px; color:white;" >Report Made Dani</span>
        </a>
        <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header" style="font-size: 15px;">Report</h6>
                
                <a class="collapse-item" style="font-size: 15px;" href="../VPenjualanL">Laporan Penjualan</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VPenebusanL">Laporan Penebusan</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VSewaHiBlow">Sewa Hiblow</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VPengirimanL">Laporan Pengiriman</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VKeuanganL">Laporan Keuangan</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VPengeluaranL">Laporan Pengeluaran</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VRekapDoPenjualanL">Rekap DO Penjualan</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VRekapDoPembelian">Rekap DO Pembelian</a>
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
                        <a class='collapse-item' style='font-size: 15px;' href='../VLR2L'>Laba Rugi</a>
                        <a class='collapse-item' style='font-size: 15px;' href='../VLRKendaraan'>Laba Rugi Kendaraan</a>
                        <a class='collapse-item' style='font-size: 15px;' href='../VRekapanHarga'>Rekapan Harga</a>
                        <a class='collapse-item' style='font-size: 15px;' href='../VRekapSparepart'>Rekap Sparepart</a>
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
 <?php echo "<a href='../VLR2LBaru?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><button type='button' class='btn btn-primary'>Kembali</button></a>"; ?>

  <div class="col-md-8">
   <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
 </div>



<h5 align="center" >Uang Jalan Etty</h5>
<!-- Tabel -->    
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th align="center">Nama Driver</th>
      <th align="center">Uang Jalan</th>
      <th align="center">Total Uang Jalan</th>

    </tr>
  </thead>
  <tbody>
  <?php
    $uj_etty = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>
    <?php while($data = mysqli_fetch_array($table4)){
      $nama_driver = $data['driver'];
      $total_gaji =$data['total_gaji'];
      $uj_etty = $uj_etty + $total_gaji ;
      echo "<tr>
      <td style='font-size: 14px' align = 'center'>$nama_driver</td>
      <td style='font-size: 14px' align = 'center'>"?> <?= formatuang($total_gaji); ?> <?php echo" </td>
      <td style='font-size: 14px' align = 'center'>"?> <?= formatuang($uj_etty); ?> <?php echo" </td>
      </tr>";
}
?>

</tbody>
</table>

<br>
<br>
<br>


<h5 align="center" >Uang Jalan Kadek</h5>
<!-- Tabel -->    
<table id="example1" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th align="center">Nama Driver</th>
      <th align="center">Uang Jalan</th>
      <th align="center">Total Uang Jalan</th>

    </tr>
  </thead>
  <tbody>
  <?php
    $uj_kadek = 0;


    ?>
    <?php while($data = mysqli_fetch_array($table4x)){
      $nama_driver = $data['driver'];
      $total_gaji =$data['total_gaji'];
      $uj_kadek = $uj_kadek + $total_gaji ;
      echo "<tr>
      <td style='font-size: 14px' align = 'center'>$nama_driver</td>
      <td style='font-size: 14px' align = 'center'>"?> <?= formatuang($total_gaji); ?> <?php echo" </td>
      <td style='font-size: 14px' align = 'center'>"?> <?= formatuang($uj_kadek); ?> <?php echo" </td>
      </tr>";
}
?>

</tbody>
</table>

<br>
<br>
<br>
<h5 align="center" >Uang Jalan Menyewakan HiBLow</h5>
<!-- Tabel -->    
<div style="overflow-x: auto">
<table id="example3" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal DO</th>
      <th>No DO</th>
      <th>No Kendaraan</th> 
      <th>Uang Jalan</th> 
      <th>Qty/Tonase</th>
      <th>Harga / Ton</th>
      <th>Jumlah</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $urut = 0;

    $total_sewa = 0;
    ?>
    <?php while($data = mysqli_fetch_array($table)){
      $no_laporan = $data['no_laporan'];
      $tanggal_do =$data['tanggal_do'];
      $no_do =$data['no_do'];
      $no_kendaraan =$data['no_kendaraan'];
      $uang_jalan =$data['uang_jalan'];
      $tonase =$data['tonase'];
      $harga =$data['harga'];
      $jumlah =$data['jumlah'];
      $total_sewa = $total_sewa + $uang_jalan;
      $urut = $urut + 1;

      echo "<tr>
      <td style='font-size: 14px' align = 'center'>$urut</td>
      <td style='font-size: 14px' align = 'center'>$tanggal_do</td>
      <td style='font-size: 14px' align = 'center'>$no_do</td>
      <td style='font-size: 14px' align = 'center'>$no_kendaraan</td>
      <td style='font-size: 14px' align = 'center'>$uang_jalan</td>
      <td style='font-size: 14px' align = 'center'>$tonase</td>
      <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($harga); ?> <?php echo "</td>
      <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
       </tr>";
}
?>

</tbody>
</table>
</div>
<br>
<br>
<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-6 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Uj Hiblow</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=   formatuang($total_sewa) ?></div>
          </div>
          <div class="col-auto">
           <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example1').DataTable( {
      lengthChange: false,
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>
<script>
  $(document).ready(function() {
    var table = $('#example3').DataTable( {
      lengthChange: false,
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>


</body>

</html>