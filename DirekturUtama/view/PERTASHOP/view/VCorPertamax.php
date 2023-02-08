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
 $lokasi = $_GET['lokasi'];
} 

elseif (isset($_POST['tanggal1'])) {
 $tanggal_awal = $_POST['tanggal1'];
 $tanggal_akhir = $_POST['tanggal2'];
 $lokasi = $_POST['lokasi'];
} 


if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksiperta,"SELECT * FROM ngecor WHERE tanggal ='$tanggal_awal' AND nama_barang = 'Pertamax' AND lokasi_cor = '$lokasi'");
  $table2 = mysqli_query($koneksiperta,"SELECT * FROM barang ");
}

else{
  $table = mysqli_query($koneksiperta,"SELECT * FROM ngecor WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_barang = 'Pertamax' AND lokasi_cor = '$lokasi'");
  $table2 = mysqli_query($koneksiperta,"SELECT * FROM barang ");
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

  <title>Pencatatan Cor</title>


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
      <?php echo "<a href='VPembelian'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Ngecor Pertamax Ps $lokasi</h5></a>"; ?>
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


 <div style="margin-right: 20px; margin-left: 20px;">

 <?php  echo "<form  method='POST' action='VCorPertamax'>" ?>
  <div>
      <div align="left" style="margin-left: 20px;"> 
        <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1"> 
        <span>-</span>
        <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
        <select id="lokasi" name="lokasi"s>
            <?php
            include 'koneksi.php';
            $result = mysqli_query($koneksiperta, "SELECT * FROM pertashop");   

            while ($data2 = mysqli_fetch_array($result)){
              $nama_driver = $data2['lokasi'];


              echo "<option> $nama_driver </option> ";
              
            }
            ?>
          </select>
        <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm" >Lihat</button>
      </div>
    </div>
</form>

<div class="col-md-8">
   <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
 </div>
 <br>


<!-- Tabel -->    
<div style="overflow-x: auto" align = 'center'>
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th style="font-size: 11px" >No</th>
      <th style="font-size: 11px" >Tanggal</th>
      <th style="font-size: 11px" >Tanggal Pembayaran</th>
      <th style="font-size: 11px" >Lokasi Cor</th>
      <th style="font-size: 11px" >No Polisi</th>
      <th style="font-size: 11px" >Nama Driver</th>   
      <th style="font-size: 11px" >Perusahaan</th>
      <th style="font-size: 11px" >Nama Barang </th>
      <th style="font-size: 11px" >Jumlah Cor</th>
      <th style="font-size: 11px" >Harga</th>
      <th style="font-size: 11px" >Total</th>
      <th style="font-size: 11px" >Jenis Cor</th>
      <th style="font-size: 11px" >Keterangan</th>
      <th style="font-size: 11px" >File</th>

    </tr>
  </thead>
  <tbody>
    <?php
    $urut = 0;
    $cor_nb_max_sirkulasi = 0;
    $cor_nb_max_penjualan = 0;
    $cor_nb_dex_sirkulasi = 0;
    $cor_nb_dex_penjualan = 0;
    $cor_be_penjualan = 0;
    $cor_be_sirkulasi = 0;
    $cor_md_penjualan = 0;
    $cor_md_sirkulasi = 0;
    $cor_sj_penjualan = 0;
    $cor_sj_sirkulasi = 0;
    $cor_pb_penjualan = 0;
    $cor_pb_sirkulasi = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>
    <?php while($data = mysqli_fetch_array($table)){
      $no_cor = $data['no_cor'];
      $tanggal =$data['tanggal'];
      $tanggal_pembayaran =$data['tanggal_pembayaran'];
      $lokasi_cor =$data['lokasi_cor'];
      $no_polisi =$data['no_polisi'];
      $nama_driver =$data['nama_driver'];
      $nama_perusahaan =$data['nama_perusahaan'];
      $nama_barang = $data['nama_barang'];
      $jumlah = $data['jumlah'];
      $harga = $data['harga'];
      $total = $data['total'];
      $keterangan = $data['keterangan'];
      $file_bukti = $data['file_bukti'];

      
      $urut = $urut + 1;

      if($lokasi_cor == 'Nusa Bakti'){
        if($nama_barang == 'Pertamax'){

          if($jenis_cor == 'Sirkulasi' ){
            $cor_nb_max_sirkulasi = $cor_nb_max_sirkulasi + $jumlah;
          }
          else{
            $cor_nb_max_penjualan = $cor_nb_max_penjualan + $jumlah;
          }
          
        }
        else{

          if($jenis_cor == 'Sirkulasi' ){
            $cor_nb_dex_sirkulasi = $cor_nb_dex_sirkulasi + $jumlah;
          }
          else{
            $cor_nb_dex_penjualan = $cor_nb_dex_penjualan + $jumlah;
          }
          
        }
        
      }
      else if($lokasi_cor == 'Bedilan'){
        
        if($jenis_cor == 'Sirkulasi' ){
          $cor_be_sirkulasi = $cor_be_sirkulasi + $jumlah;
        }
        else{
          $cor_be_penjualan = $cor_be_penjualan + $jumlah;
        }
  
      }
      else if($lokasi_cor == 'Muara Dua'){
        
        if($jenis_cor == 'Sirkulasi' ){
          $cor_md_sirkulasi = $cor_md_sirkulasi + $jumlah;
        }
        else{
          $cor_md_penjualan = $cor_md_penjualan + $jumlah;
        }
        
      }
      else if($lokasi_cor == 'Sumber Jaya'){

        if($jenis_cor == 'Sirkulasi' ){
          $cor_sj_sirkulasi = $cor_sj_sirkulasi + $jumlah;
        }
        else{
          $cor_sj_penjualan = $cor_sj_penjualan + $jumlah;
        }
     
      }
      else if($lokasi_cor == 'Pul Baturaja'){
        
        if($jenis_cor == 'Sirkulasi' ){
          $cor_pb_sirkulasi = $cor_pb_sirkulasi + $jumlah;
        }
        else{
          $cor_pb_penjualan = $cor_pb_penjualan + $jumlah;
        }
        
      }


      echo "<tr>
      <td style='font-size: 11px' align = 'center'>$urut</td>
      <td style='font-size: 11px' align = 'center'>$tanggal</td>
      <td style='font-size: 11px' align = 'center'>$tanggal_pembayaran</td>
      <td style='font-size: 11px' align = 'center'>$lokasi_cor</td>
      <td style='font-size: 11px' align = 'center'>$no_polisi</td>
      <td style='font-size: 11px' align = 'center'>$nama_driver</td>
      <td style='font-size: 11px' align = 'center'>$nama_perusahaan</td>
      <td style='font-size: 11px' align = 'center'>$nama_barang</td>
      <td style='font-size: 11px' align = 'center'>$jumlah/L</td>
      <td style='font-size: 11px' align = 'center'>"?>  <?= formatuang($harga); ?> <?php echo "</td>
      <td style='font-size: 11px' align = 'center'>"?>  <?= formatuang($total); ?> <?php echo "</td>
      <td style='font-size: 11px' align = 'center'>$jenis_cor</td>
      <td style='font-size: 11px' align = 'center'>$keterangan</td>
      "; ?>
      <?php echo "
      <td style='font-size: 11px'>"; ?> <a download="/PERTASHOP/Administrasi/file_administrasi/<?= $file_bukti ?>" href="/PERTASHOP/Administrasi/file_administrasi/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
    </tr>";
}
?>

</tbody>
</table>
</div>

<br>
<br>
<div style="margin-right: 100px; margin-left: 100px;">
<h6 align="Center">Stok</h6>
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th  style='font-size: 12px' >No</th>
      <th  style='font-size: 12px'>Kode Perta</th>
      <th  style='font-size: 12px'>Nama Barang</th>
      <th  style='font-size: 12px'>STOK</th>
    </tr>
  </thead>
  <tbody>
    <?php while($data = mysqli_fetch_array($table2)){
      $kode_barang = $data['kode_barang'];
      $kode_perta =$data['kode_perta'];
      $nama_barang =$data['nama_barang'];
      $stok = $data['stok'];
      $no_urut =+1 ;

      echo "<tr>
      <td style='font-size: 12px' align = 'center'>$no_urut</td>
      <td style='font-size: 12px' align = 'center'>$kode_perta</td>
      <td style='font-size: 12px' align = 'center'>$nama_barang</td>
      <td style='font-size: 12px' align = 'center'>$stok</td>
     
  </tr>";
}
?>

</tbody>
</table>
</div>

<div style="margin-right: 100px; margin-left: 100px;">
<h6 align="Center">Laporan Barang Di Cor</h6>
<div style="overflow-x: auto" align = 'center'>
<table  class="table-sm table-striped table-bordered  nowrap" style="width:auto">
<thead>
      <th style='font-size: 11px'>Pertashop</th>
      <th style='font-size: 11px'>Nama Barang</th>
      <th style='font-size: 11px'>Jenis Cor</th>
      <th style='font-size: 11px'>Total Di Cor</th>
    </tr>
  </thead>
  <tbody>

  
  <tr>
      <td style='font-size: 11px' align = 'center'>Nusa Bakti</td>
      <td style='font-size: 11px' align = 'center'>Dexlite</td>
      <td style='font-size: 11px' align = 'center'>Penjualan</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_nb_dex_penjualan); ?></td>
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Nusa Bakti</td>
      <td style='font-size: 11px' align = 'center'>Dexlite</td>
      <td style='font-size: 11px' align = 'center'>Sirkulasi</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_nb_dex_sirkulasi); ?></td>
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Nusa Bakti</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'>Penjualan</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_nb_max_penjualan); ?></td>
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Nusa Bakti</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'>Sirkulasi</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_nb_max_sirkulasi); ?></td>
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Sumber Jaya</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'>Penjualan</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_sj_penjualan); ?></td>
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Sumber Jaya</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'>Sirkulasi</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_sj_sirkulasi); ?></td>
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Bedilan</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'>Penjualan</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_be_penjualan); ?></td>
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Bedilan</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'>Sirkulasi</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_be_sirkulasi); ?></td>
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Muara Dua</td>
      <td style='font-size: 11px' align = 'center'>Dexlite</td>
      <td style='font-size: 11px' align = 'center'>Penjualan</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_md_penjualan); ?></td>
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Muara Dua</td>
      <td style='font-size: 11px' align = 'center'>Dexlite</td>
      <td style='font-size: 11px' align = 'center'>Sirkulasi</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_md_sirkulasi); ?></td>
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Pul Baturaja</td>
      <td style='font-size: 11px' align = 'center'>Dexlite</td>
      <td style='font-size: 11px' align = 'center'>Penjualan</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_pb_penjualan); ?></td>
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Pul Baturaja</td>
      <td style='font-size: 11px' align = 'center'>Dexlite</td>
      <td style='font-size: 11px' align = 'center'>Sirkulasi</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_pb_sirkulasi); ?></td>
  </tr>



</tbody>
</table>
</div>
</div>
</div>

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