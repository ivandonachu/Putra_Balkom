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

  $table = mysqli_query($koneksipbj, "SELECT * FROM riwayat_pengiriman a INNER JOIN driver b ON a.no_driver=b.no_driver INNER JOIN kendaraan c ON c.no_kendaraan=a.no_kendaraan INNER JOIN lokasi_kirim d ON d.no_lokasi=a.no_lokasi WHERE a.tanggal = '$tanggal_awal' ");
  
  $table2 = mysqli_query($koneksipbj, "SELECT b.nama_driver, SUM(rit) AS total_rit  FROM riwayat_pengiriman a INNER JOIN driver b ON a.no_driver=b.no_driver WHERE a.tanggal = '$tanggal_awal' GROUP BY b.nama_driver ");

  $table3 = mysqli_query($koneksipbj, "SELECT b.no_polisi, SUM(rit) AS total_rit  FROM riwayat_pengiriman a INNER JOIN kendaraan b ON a.no_kendaraan=b.no_kendaraan WHERE a.tanggal = '$tanggal_awal' GROUP BY b.no_polisi ");

  $table4 = mysqli_query($koneksipbj, "SELECT b.nama_driver, SUM(gaji_tagihan) AS total_gaji FROM riwayat_pengiriman a INNER JOIN driver b ON a.no_driver=b.no_driver WHERE a.tanggal = '$tanggal_awal' GROUP BY b.nama_driver "); 

  $table5 = mysqli_query($koneksipbj, "SELECT tanggal, SUM(rit) AS total_rit FROM riwayat_pengiriman WHERE tanggal = '$tanggal_awal' AND no_lokasi ='2'  GROUP BY tanggal ");

  $table6 = mysqli_query($koneksipbj, "SELECT tanggal, SUM(rit) AS total_rit FROM riwayat_pengiriman WHERE tanggal = '$tanggal_awal' AND no_lokasi ='3'  GROUP BY tanggal ");
}
else{

  $table = mysqli_query($koneksipbj, "SELECT * FROM riwayat_pengiriman a INNER JOIN driver b ON a.no_driver=b.no_driver INNER JOIN kendaraan c ON c.no_kendaraan=a.no_kendaraan INNER JOIN lokasi_kirim d ON d.no_lokasi=a.no_lokasi WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ORDER BY a.tanggal ");

  $table2 = mysqli_query($koneksipbj, "SELECT b.nama_driver, SUM(rit) AS total_rit  FROM riwayat_pengiriman a INNER JOIN driver b ON a.no_driver=b.no_driver WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY b.nama_driver ");

  $table3 = mysqli_query($koneksipbj, "SELECT b.no_polisi, SUM(rit) AS total_rit  FROM riwayat_pengiriman a INNER JOIN kendaraan b ON a.no_kendaraan=b.no_kendaraan WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY b.no_polisi ");

   $table4 = mysqli_query($koneksipbj, "SELECT b.nama_driver, SUM(gaji_tagihan) AS total_gaji FROM riwayat_pengiriman a INNER JOIN driver b ON a.no_driver=b.no_driver WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY b.nama_driver "); 

   $table5 = mysqli_query($koneksipbj, "SELECT tanggal, SUM(rit) AS total_rit FROM riwayat_pengiriman WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_lokasi ='2'  GROUP BY tanggal ");

  $table6 =  mysqli_query($koneksipbj, "SELECT tanggal, SUM(rit) AS total_rit FROM riwayat_pengiriman WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_lokasi ='3'  GROUP BY tanggal ");
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
                        <a class="collapse-item" style="font-size: 15px;" href="../DsPBJ">Transport BB</a>
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
                        <a class="collapse-item" style="font-size: 15px;" href="../VLR">Laba Rugi</a>
                        <a class="collapse-item" style="font-size: 15px;" href="../VLSaldo">Laporan Saldo</a>
                        <a class="collapse-item" style="font-size: 15px;" href="../VCatatPengiriman">Riwayat Pengiriman</a>
                        <a class="collapse-item" style="font-size: 15px;" href="../VPerbaikan">Beban Kendaraan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="../VOperasional">Beban Operasional</a>

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
      <?php echo "<a href='VRTagihan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Rincian Tagihan</h5></a>"; ?>
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



  <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<div align="left">
      <?php echo "<a href='../VLR2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><button type='button' class='btn btn-primary'>Kembali</button></a>"; ?>
    </div>


  <div class="col-md-8">
   <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
 </div>
 <br>

<!-- Tabel -->    
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%;  ">
  <thead>
    <tr>
      <th>No</th>
      <th>No SJB</th>
      <th>Date In</th>
      <th>Date Out</th>   
      <th>Barang</th>
      <th>Rute</th>
      <th>Muatan</th>
      <th>Harga</th>
      <th>Jasa Transport</th>
      <th>No Polisi</th>
      <th>Driver</th>
      <th>Uang Jalan</th>
      <th>Gaji</th>
      <th>KET</th>
      <th>File</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $urut = 0;
    $total_muatan = 0;
    $total_tagihan =  0;
    $total_uj = 0;
    $total_gaji = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>
    <?php while($data = mysqli_fetch_array($table)){
      $no_pengiriman = $data['no_pengiriman'];
      $no_sjb = $data['no_sjb'];
      $tanggal =$data['tanggal'];
      $tanggal_keluar =$data['tanggal_keluar'];
      $nm_perusahaan = $data['nm_perusahaan'];
      $nm_lokasi = $data['nm_lokasi'];
      $muatan = $data['muatan'];
      $harga = $data['harga_tagihan'];
      $no_polisi = $data['no_polisi'];
      $nama_driver = $data['nama_driver'];
      $uj = $data['uj_tagihan'];
      $gaji = $data['gaji_tagihan'];
      $keterangan = $data['keterangan'];
      $file_bukti = $data['file_bukti'];
      $jasa_transport = $muatan * $harga;

      $total_tagihan = $total_tagihan + $jasa_transport;
      $total_muatan = $total_muatan + $muatan;
      $total_uj = $total_uj + $uj;
      $total_gaji = $total_gaji + $gaji;

      $urut = $urut + 1;

      echo "<tr>
      <td style='font-size: 14px' align = 'center'>$urut</td>
       <td style='font-size: 14px' align = 'center'>$no_sjb</td>
      <td style='font-size: 14px' align = 'center'>$tanggal</td>
      <td style='font-size: 14px' align = 'center'>$tanggal_keluar</td>
      <td style='font-size: 14px' align = 'center'>$nm_perusahaan</td>
      <td style='font-size: 14px' align = 'center'>$nm_lokasi</td>
      <td style='font-size: 14px' align = 'center'>$muatan</td>
      <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($harga); ?> <?php echo "</td>
      <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($jasa_transport); ?> <?php echo "</td>
      <td style='font-size: 14px' align = 'center'>$no_polisi</td>
      <td style='font-size: 14px' align = 'center'>$nama_driver</td>
      <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($uj); ?> <?php echo "</td>
      <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($gaji); ?> <?php echo "</td>
      <td style='font-size: 14px' align = 'center'>$keterangan</td>
      "; ?>
      <?php echo "
      <td style='font-size: 14px'>"; ?> <a download="/CV.PBJ/Kasir/file_kasir_pbj/<?= $file_bukti ?>" href="/CV.PBJ/Kasir/file_kasir_pbj/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>
   
<?php echo  " </tr>";
}
?>

</tbody>
</table>

<br>
<br>

<br>
<br>
<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Tagihan</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_tagihan)  ?></div>
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
            Total Muatan</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  $total_muatan;echo " Ton"; ?></div>
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
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_gaji)  ?></div>
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

<h5 align="center" >Ritease Driver</h5>
<!-- Tabel -->    
<table id="example1" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Nama Driver</th>
      <th>Total Rit</th>
      <th></th>

    </tr>
  </thead>
  <tbody>

    <?php while($data = mysqli_fetch_array($table2)){
      $nama_driver = $data['nama_driver'];
      $total_rit =$data['total_rit'];

      echo "<tr>
      <td style='font-size: 14px' align = 'center'>$nama_driver</td>
      <td style='font-size: 14px' align = 'center'>$total_rit</td>
      <td  align = 'center'><a href='VRincianRitDriver?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&nama_driver=$nama_driver'>Rincian</a></td>
      </tr>";
}
?>

</tbody>
</table>


<br>
<br>

<h5 align="center" >Ritease Kendaraan</h5>
<!-- Tabel -->    
<table id="example1" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No Polisi</th>
      <th>Total Rit</th>
      <th></th>

    </tr>
  </thead>
  <tbody>

    <?php while($data = mysqli_fetch_array($table3)){
      $no_polisi = $data['no_polisi'];
      $total_rit =$data['total_rit'];

      echo "<tr>
      <td style='font-size: 14px' align = 'center'>$no_polisi</td>
      <td style='font-size: 14px' align = 'center'>$total_rit</td>
      <td  align = 'center'><a href='VRincianRitKen?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&no_polisi=$no_polisi'>Rincian</a></td>
      </tr>";
}
?>

</tbody>
</table>

<br>
<br>

<h5 align="center" >Gaji Driver</h5>
<!-- Tabel -->    
<table id="example1" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Nama Driver</th>
      <th>Total Rit</th>
      <th></th>

    </tr>
  </thead>
  <tbody>

    <?php while($data = mysqli_fetch_array($table4)){
      $no_polisi = $data['no_polisi'];
      $total_gaji =$data['total_gaji'];

      echo "<tr>
      <td style='font-size: 14px' align = 'center'>$no_polisi</td>
      <td style='font-size: 14px' align = 'center'>$total_gaji</td>
      <td  align = 'center'><a href='VRincianRitKen?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&no_polisi=$no_polisi'>Rincian</a></td>
      </tr>";
}
?>

</tbody>
</table>

<br>
<br>

<h5 align="center" >Rit Rute PT. SLR Service 40-KM</h5>
<!-- Tabel -->    
<table id="example1" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Nama Driver</th>
      <th>Total Rit</th>


    </tr>
  </thead>
  <tbody>

    <?php while($data = mysqli_fetch_array($table5)){
      $tanggal = $data['tanggal_keluar'];
      $total_rit =$data['total_rit'];

      echo "<tr>
      <td style='font-size: 14px' align = 'center'>$tanggal</td>
      <td style='font-size: 14px' align = 'center'>$total_rit</td>
      <td  align = 'center'><a href='VRincianRitTanggal?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&tanggal=$tanggal&no_lokasi=3'>Rincian</a></td>
      </tr>";
}
?>

</tbody>
</table>

<br>
<br>

<h5 align="center" >Rit Rute PT. SLR Service 107-KM</h5>
<!-- Tabel -->    
<table id="example1" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Nama Driver</th>
      <th>Total Rit</th>


    </tr>
  </thead>
  <tbody>

    <?php while($data = mysqli_fetch_array($table6)){
      $tanggal = $data['tanggal_keluar'];
      $total_rit =$data['total_rit'];

      echo "<tr>
      <td style='font-size: 14px' align = 'center'>$tanggal</td>
      <td style='font-size: 14px' align = 'center'>$total_rit</td>
      <td  align = 'center'><a href='VRincianRitTanggal?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&tanggal=$tanggal&no_lokasi=3'>Rincian</a></td>
      </tr>";
}
?>

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