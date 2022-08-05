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
  $table = mysqli_query($koneksipbr, "SELECT * FROM riwayat_penjualan a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun INNER JOIN baja c ON a.kode_baja=c.kode_baja
 WHERE tanggal = '$tanggal_awal' AND pembayaran = 'Cash' AND referensi = 'PBR' OR tanggal = '$tanggal_awal' AND pembayaran ='Deposit' AND referensi = 'PBR' ORDER BY no_transaksi DESC");
}
else{
  $table = mysqli_query($koneksipbr, "SELECT * FROM riwayat_penjualan a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun INNER JOIN baja c ON a.kode_baja=c.kode_baja
 WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran = 'Cash' AND referensi = 'PBR' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran ='Deposit' AND referensi = 'PBR' ORDER BY no_transaksi DESC");
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

  <title>Rincian Pendapatan PBR</title>

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
           <a class="collapse-item" style="font-size: 15px;" href="VLabaRugi">Laba Rugi PBR</a>
           <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiMes">Laba Rugi MES</a>
           <a class="collapse-item" style="font-size: 15px;" href="VPenggunaanSaldo">Laporan Saldo</a>
           <a class="collapse-item" style="font-size: 15px;" href="VBonKaryawan">Laporan BON</a>
           <a class="collapse-item" style="font-size: 15px;" href="VRincianSAMES">Rincian SA MES</a>
           <a class="collapse-item" style="font-size: 15px;" href="VRincianSAPBR">Rincian SA PBR</a>
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
  <?php echo "<a href=''><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Rincian Pendapatan PBR</h5></a>"; ?>

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
      <?php echo "<a href='VLKeuangan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><button type='button' class='btn btn-primary'>Kembali</button></a>"; ?>
    </div>
    <br>
    <br>
 

<!-- Tabel -->    
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>REF</th>
      <th>Akun</th>
      <th>Barang</th>
      <th>Penyaluran</th>
      <th>Nama</th>
      <th>Pembayaran</th>
      <th>QTY</th>
      <th>Harga</th>
      <th>Jumlah</th>    
      <th>Keterangan</th>
      <th>File</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total_mes = 0;
    $total_briva_mes = 0;
    $total_transfer_mes = 0;
    $total_cash_mes = 0;
    $L03_mes = 0;
    $B05_mes = 0;
    $B12_mes = 0;
    $L12_mes = 0;
    $L03_cash_mes = 0;
    $B05_cash_mes = 0;
    $B12_cash_mes = 0;
    $L12_cash_mes = 0;

    $total_pbr = 0;
    $total_briva_pbr = 0;
    $total_transfer_pbr = 0;
    $total_cash_pbr = 0;
    $L03_pbr = 0;
    $B05_pbr = 0;
    $B12_pbr = 0;
    $L12_pbr = 0;
    $L03_cash_pbr = 0;
    $B05_cash_pbr = 0;
    $B12_cash_pbr = 0;
    $L12_cash_pbr = 0;
    $urut = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>

    <?php while($data = mysqli_fetch_array($table)){
      $no_transaksi = $data['no_transaksi'];
      $tanggal =$data['tanggal'];
      $referensi = $data['referensi'];
      $nama_akun = $data['nama_akun'];
      $nama_baja = $data['nama_baja'];
      $penyaluran = $data['penyaluran'];
      $nama = $data['nama'];
      $pembayaran = $data['pembayaran'];
      $qty = $data['qty'];
      $harga = $data['harga'];
      $jumlah = $data['jumlah'];
      $keterangan = $data['keterangan'];
      $file_bukti = $data['file_bukti'];
    $urut = $urut + 1;
    if($referensi == 'MES' ){
      $total_mes = $total_mes + $jumlah;

  if($pembayaran == 'Cash' OR $pembayaran =='Deposit' ){
      $total_cash_mes = $total_cash_mes + $jumlah;
    }
    else if($pembayaran == 'Briva' ){
      $total_briva_mes = $total_briva_mes + $jumlah;
    }
    else if($pembayaran == 'Transfer' ){
      $total_transfer_mes = $total_transfer_mes + $jumlah;
    }

  if ($pembayaran == 'Cash' OR $pembayaran =='Deposit') {
      if ($nama_baja == 'Elpiji 3 Kg Isi' || $nama_baja == 'Elpiji 3 Kg Baja + Isi' || $nama_baja == 'Elpiji 3 Kg Baja Kosong') {
      $L03_cash_mes = $L03_cash_mes + $jumlah;
  }
  elseif ($nama_baja == 'Elpiji 12 Kg Isi' || $nama_baja == 'Elpiji 12 Kg Baja + Isi' || $nama_baja == 'Elpiji 12 Kg Baja Kosong') {
      $L12_cash_mes = $L12_cash_mes + $jumlah;
  }
  elseif ($nama_baja == 'Bright Gas 5,5 Kg Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja + Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja Kosong') {
      $B05_cash_mes = $B05_cash_mes + $jumlah;
  }
  elseif ($nama_baja == 'Bright Gas 12 Kg Isi' || $nama_baja == 'Bright Gas 12 Kg Baja + Isi' || $nama_baja == 'Bright Gas 12 Kg Baja Kosong') {
      $B12_cash_mes = $B12_cash_mes + $jumlah;
  }
      }
  else if ($pembayaran == 'Bon') {
      $sql_bon = mysqli_query($koneksipbr, "SELECT * FROM piutang_dagang WHERE no_transaksi = '$no_transaksi' ");
      $data_bon = mysqli_fetch_array($sql_bon);
      $jumlah_bon = $data_bon['jumlah_bayar'];
      if ($nama_baja == 'Elpiji 3 Kg Isi' || $nama_baja == 'Elpiji 3 Kg Baja + Isi' || $nama_baja == 'Elpiji 3 Kg Baja Kosong') {
      $L03_cash_mes = $L03_cash_mes + $jumlah_bon;
  }
  elseif ($nama_baja == 'Elpiji 12 Kg Isi' || $nama_baja == 'Elpiji 12 Kg Baja + Isi' || $nama_baja == 'Elpiji 12 Kg Baja Kosong') {
      $L12_cash_mes = $L12_cash_mes + $jumlah_bon;
  }
  elseif ($nama_baja == 'Bright Gas 5,5 Kg Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja + Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja Kosong') {
      $B05_cash_mes = $B05_cash_mes + $jumlah_bon;
  }
  elseif ($nama_baja == 'Bright Gas 12 Kg Isi' || $nama_baja == 'Bright Gas 12 Kg Baja + Isi' || $nama_baja == 'Bright Gas 12 Kg Baja Kosong') {
      $B12_cash_mes = $B12_cash_mes + $jumlah_bon;
  }
  }
  else{
      if ($nama_baja == 'Elpiji 3 Kg Isi' || $nama_baja == 'Elpiji 3 Kg Baja + Isi' || $nama_baja == 'Elpiji 3 Kg Baja Kosong') {
      $L03_mes = $L03_mes + $jumlah;
  }
  elseif ($nama_baja == 'Elpiji 12 Kg Isi' || $nama_baja == 'Elpiji 12 Kg Baja + Isi' || $nama_baja == 'Elpiji 12 Kg Baja Kosong') {
      $L12_mes = $L12_mes + $jumlah;
  }
  elseif ($nama_baja == 'Bright Gas 5,5 Kg Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja + Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja Kosong') {
      $B05_mes = $B05_mes + $jumlah;
  }
  elseif ($nama_baja == 'Bright Gas 12 Kg Isi' || $nama_baja == 'Bright Gas 12 Kg Baja + Isi' || $nama_baja == 'Bright Gas 12 Kg Baja Kosong') {
      $B12_mes = $B12_mes + $jumlah;
  }
  }
}
else{
  $total_pbr = $total_pbr + $jumlah;

  if($pembayaran == 'Cash' OR $pembayaran =='Deposit' ){
      $total_cash_pbr = $total_cash_pbr + $jumlah;
    }
    else if($pembayaran == 'Briva' ){
      $total_briva_pbr = $total_briva_pbr + $jumlah;
    }
    else if($pembayaran == 'Transfer' ){
      $total_transfer_pbr = $total_transfer_pbr + $jumlah;
    }

  if ($pembayaran == 'Cash' OR $pembayaran =='Deposit') {
      if ($nama_baja == 'Elpiji 3 Kg Isi' || $nama_baja == 'Elpiji 3 Kg Baja + Isi' || $nama_baja == 'Elpiji 3 Kg Baja Kosong') {
      $L03_cash_pbr = $L03_cash_pbr + $jumlah;
  }
  elseif ($nama_baja == 'Elpiji 12 Kg Isi' || $nama_baja == 'Elpiji 12 Kg Baja + Isi' || $nama_baja == 'Elpiji 12 Kg Baja Kosong') {
      $L12_cash_pbr = $L12_cash_pbr + $jumlah;
  }
  elseif ($nama_baja == 'Bright Gas 5,5 Kg Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja + Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja Kosong') {
      $B05_cash_pbr = $B05_cash_pbr + $jumlah;
  }
  elseif ($nama_baja == 'Bright Gas 12 Kg Isi' || $nama_baja == 'Bright Gas 12 Kg Baja + Isi' || $nama_baja == 'Bright Gas 12 Kg Baja Kosong') {
      $B12_cash_pbr = $B12_cash_pbr + $jumlah;
  }
      }
  else if ($pembayaran == 'Bon') {
      $sql_bon = mysqli_query($koneksipbr, "SELECT * FROM piutang_dagang WHERE no_transaksi = '$no_transaksi' ");
      $data_bon = mysqli_fetch_array($sql_bon);
      $jumlah_bon = $data_bon['jumlah_bayar'];
      if ($nama_baja == 'Elpiji 3 Kg Isi' || $nama_baja == 'Elpiji 3 Kg Baja + Isi' || $nama_baja == 'Elpiji 3 Kg Baja Kosong') {
      $L03_cash_pbr = $L03_cash_pbr + $jumlah_bon;
  }
  elseif ($nama_baja == 'Elpiji 12 Kg Isi' || $nama_baja == 'Elpiji 12 Kg Baja + Isi' || $nama_baja == 'Elpiji 12 Kg Baja Kosong') {
      $L12_cash_pbr = $L12_cash_pbr + $jumlah_bon;
  }
  elseif ($nama_baja == 'Bright Gas 5,5 Kg Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja + Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja Kosong') {
      $B05_cash_pbr = $B05_cash_pbr + $jumlah_bon;
  }
  elseif ($nama_baja == 'Bright Gas 12 Kg Isi' || $nama_baja == 'Bright Gas 12 Kg Baja + Isi' || $nama_baja == 'Bright Gas 12 Kg Baja Kosong') {
      $B12_cash_pbr = $B12_cash_pbr + $jumlah_bon;
  }
  }
  else{
      if ($nama_baja == 'Elpiji 3 Kg Isi' || $nama_baja == 'Elpiji 3 Kg Baja + Isi' || $nama_baja == 'Elpiji 3 Kg Baja Kosong') {
      $L03_pbr = $L03_pbr + $jumlah;
  }
  elseif ($nama_baja == 'Elpiji 12 Kg Isi' || $nama_baja == 'Elpiji 12 Kg Baja + Isi' || $nama_baja == 'Elpiji 12 Kg Baja Kosong') {
      $L12_pbr = $L12_pbr + $jumlah;
  }
  elseif ($nama_baja == 'Bright Gas 5,5 Kg Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja + Isi' || $nama_baja == 'Bright Gas 5,5 Kg Baja Kosong') {
      $B05_pbr = $B05_pbr + $jumlah;
  }
  elseif ($nama_baja == 'Bright Gas 12 Kg Isi' || $nama_baja == 'Bright Gas 12 Kg Baja + Isi' || $nama_baja == 'Bright Gas 12 Kg Baja Kosong') {
      $B12_pbr = $B12_pbr + $jumlah;
  }
  }
}



      echo "<tr>
      <td style='font-size: 14px'>$urut</td>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$referensi</td>
      <td style='font-size: 14px'>$nama_akun</td>
      <td style='font-size: 14px'>$nama_baja</td>
      <td style='font-size: 14px'>$penyaluran</td>
      <td style='font-size: 14px'>$nama</td>
      <td style='font-size: 14px'>$pembayaran</td>
      <td style='font-size: 14px'>$qty</td>
      <td style='font-size: 14px'>";?> <?= formatuang($harga); ?> <?php echo "</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
      <td style='font-size: 14px'>$keterangan</td>
      <td style='font-size: 14px'>"; ?> <a download="/PT.CBM/KasirToko/file_toko/<?= $file_bukti ?>" href="/PT.CBM/KasirToko/file_toko/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      </tr>";
  }
  ?>

</tbody>
</table>
</div>
<br>
<br>
<br><div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h3 align = 'center'>Pendapatan PBR</h3>
  <!-- Tabel -->    
  <table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
    <thead>
      <tr>
        <th>Total Cash</th>
      </tr>
    </thead>
    <tbody>

      <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($total_cash_pbr); ?> <?php echo "</td>

      </tr>";

      ?>

    </tbody>
  </table>
</div>
<br>
<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">

  <!-- Tabel -->    
  <table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
    <thead>
      <tr>
        <th>Cash Elpiji 3 KG</th>
        <th>Cash Bright Gas 5,5 KG</th>
        <th>Cash Bright Gas 12 KG</th>
        <th>Cash Elpiji 12 KG</th>
      </tr>
    </thead>
    <tbody>

      <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($L03_cash_pbr); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($B05_cash_pbr); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($B12_cash_pbr); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($L12_cash_pbr); ?> <?php echo "</td>

      </tr>";

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