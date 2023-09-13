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

else{  header("Location: logout.php");
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
  $table = mysqli_query($koneksipbr, "SELECT * FROM riwayat_keberangkatan a INNER JOIN driver b ON  a.id_driver = b.id_driver WHERE tanggal = '$tanggal_awal' AND referensi = 'MES'");
  $table2 = mysqli_query($koneksipbr, "SELECT * FROM riwayat_pengeluaran a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal = '$tanggal_awal' AND b.kode_akun = '5-580' AND referensi = 'MES' OR tanggal = '$tanggal_awal' AND b.kode_akun = '5-580' AND referensi = 'ME' ");
  $table3 = mysqli_query($koneksipbr, "SELECT * FROM pengeluaran_mes a  WHERE tanggal = '$tanggal_awal'  AND nama_akun = 'Biaya Penjualan & Pemasaran' ");
}
else{
  $table = mysqli_query($koneksipbr, "SELECT * FROM riwayat_keberangkatan a INNER JOIN driver b ON  a.id_driver = b.id_driver WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'MES'");
  $table2 = mysqli_query($koneksipbr, "SELECT * FROM riwayat_pengeluaran a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND b.kode_akun = '5-580' AND referensi = 'MES' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND b.kode_akun = '5-580' AND referensi = 'ME' ");
  $table3 = mysqli_query($koneksipbr, "SELECT * FROM pengeluaran_mes a  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Penjualan & Pemasaran' ");
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

  <title>Rincian Penjualan & Pemasaran MES</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../DsPTPBRMES">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="gambar/Logo CBM.png" ></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            
              <!-- Nav Item - Dashboard -->
            <li class="nav-item active" >
                <a class="nav-link" href="../DsPTPBRMES">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 16px;" >Dashboard</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">
                <!-- Heading -->
                <div class="sidebar-heading" style="font-size: 15px; color:white;">
                     Menu PTPBRMES
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
                        <a class="collapse-item" style="font-size: 15px;" href="../VLKeuangan1">Laporan Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="../VLPenjualan1">Laporan Penjualan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugi">Laba Rugi PBR</a>
                        <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugiMes">Laba Rugi MES</a>
                        <a class="collapse-item" style="font-size: 15px;" href="../VPenggunaanSaldo">Laporan Saldo</a>
                        <a class="collapse-item" style="font-size: 15px;" href="../VBonKaryawan">Laporan BON</a>
                        <a class="collapse-item" style="font-size: 15px;" href="../VRincianSA">Rincian SA</a>
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
  <?php echo "<a href='VRPemasaranTF?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Rincian Penjualan & Pemasaran Transfer MES</h5></a>"; ?>

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

    <div align="left">
      <?php echo "<a href='../VLabaRugiMes2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><button type='button' class='btn btn-primary'>Kembali</button></a>"; ?>
    </div>
    
<br>
<br>
   
<!-- Tabel -->    
<h4 align = 'center'>Pengeluaran Pengiriman ke Pangkalan</h4>
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Nama Driver</th>
      <th>No Polisi</th>
      <th>Posisi Bongkar</th>
      <th>Tujuan Berangkat</th>
      <th>Uang Jalan</th>
      <th>Keterangan</th>
      <th>File LO</th>
    
  </thead>
  <tbody>
    <?php
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }
    
    $urut = 0;
    $total = 0;
    
    ?>

    <?php while($data = mysqli_fetch_array($table)){
      $no_keberangkatan = $data['no_keberangkatan'];
      $tanggal =$data['tanggal'];
      $nama_driver = $data['nama_driver'];
      $no_polisi = $data['no_polisi'];
      $posisi_bongkar = $data['posisi_bongkar'];
      $tujuan_keberangkatan = $data['tujuan_berangkat'];
      $uang_jalan = $data['uang_jalan'];
      $keterangan = $data['keterangan'];
      $file_bukti = $data['file_bukti'];
      $urut  = $urut + 1;

      echo "<tr>
      <td style='font-size: 14px'>$urut</td>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$nama_driver</td>
      <td style='font-size: 14px'>$no_polisi</td>
      <td style='font-size: 14px'>$posisi_bongkar</td>
      <td style='font-size: 14px'>$tujuan_keberangkatan</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($uang_jalan); ?> <?php echo "</td>
      <td style='font-size: 14px'>$keterangan</td>
      <td style='font-size: 14px'>"; ?> <a download="/PT.CBM/KepalaGudang/file_gudang/<?= $file_bukti ?>" href="/PT.CBM/KepalaGudang/file_gudang/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>

    <?php echo  " </td>  </tr>";
  }
  ?>

</tbody>
</table>
<br>
<br>
<hr>
<br>
<br>
<!-- Tabel -->    
<h4 align = 'center'>Pengeluaran Penunjang Pemasaran ke Pangkalan</h4>
<table id="example2" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>REF</th>
      <th>Akun</th>
      <th>Keterangan</th>
      <th>Jumlah Pengeluaran</th>
      <th>File</th>

    </tr>
  </thead>
  <tbody>
  <?php

$urut = 0;
$total = 0;
?>
    <?php while($data = mysqli_fetch_array($table2)){
      $no_transaksi = $data['no_pengeluaran'];
      $tanggal =$data['tanggal'];
      $referensi = $data['referensi'];
      $nama_akun = $data['nama_akun'];
      $keterangan = $data['keterangan'];
      $jumlah_pengeluaran = $data['jumlah_pengeluaran'];
      $file_bukti = $data['file_bukti'];
      $urut  = $urut + 1;

      echo "<tr>
      <td style='font-size: 14px'>$urut</td>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$referensi</td>
      <td style='font-size: 14px'>$nama_akun</td>
      <td style='font-size: 14px'>$keterangan</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($jumlah_pengeluaran); ?> <?php echo "</td>
      <td style='font-size: 14px'>"; ?> <a download="/PT.CBM/KasirToko/file_toko/<?= $file_bukti ?>" href="/PT.CBM/KasirToko/file_toko/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>
      

    <?php echo  " </td> </tr>";
  }
  ?>

</tbody>
</table>

<br>
<br>
<hr>
<br>
<br>

<h3 align = 'center'>Rincian Biaya Pemasaran</h3>

<!-- Tabel -->    
<div style="overflow-x: auto" align = 'center' >
  <table id="example3" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>REF</th>
      <th>Akun</th>
      <th>Keterangan</th>
      <th>Debit</th>
      <th>Kredit</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php

    $urut = 0;
    $total = 0;
    ?>

    <?php while($data = mysqli_fetch_array($table3)){
      $no_pengeluaran = $data['no_pengeluaran'];
      $tanggal =$data['tanggal'];
      $referensi = $data['referensi'];
      $nama_akun = $data['nama_akun'];
      $keterangan = $data['keterangan'];
      $jumlah = $data['jumlah'];
      $file_bukti = $data['file_bukti'];
      $urut  = $urut + 1;


        $total = $total + $jumlah;




      echo "<tr>
      <td style='font-size: 14px'>$urut</td>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$referensi</td>
      <td style='font-size: 14px'>$nama_akun</td>
      <td style='font-size: 14px'>$keterangan</td>";
      if ($nama_akun == 'Saldo Cek Masuk' || $nama_akun == 'Saldo Brimo Masuk' || $nama_akun == 'Saldo Sebelumnya') {
       echo" <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>";
       echo" <td style='font-size: 14px'>"?>  <?= formatuang(0); ?> <?php echo "</td>";
      }
      else{
        echo" <td style='font-size: 14px'>"?>  <?= formatuang(0); ?> <?php echo "</td>";
        echo" <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>";
      }
      echo" <td style='font-size: 14px'>"?>  <?= formatuang($total); ?> <?php echo "</td>
    </td> </tr>";
  }
  ?>

</tbody>
</table>
</div>
<br>
<br>
<hr>
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
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>
<script>
  $(document).ready(function() {
    var table = $('#example2').DataTable( {
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