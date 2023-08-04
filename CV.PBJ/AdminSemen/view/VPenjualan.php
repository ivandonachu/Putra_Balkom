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
if ($jabatan_valid == 'Admin Semen') {

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
  $table = mysqli_query($koneksi,"SELECT * FROM penjualan_sl WHERE tanggal_kirim = '$tanggal_akhir' ");
  //Curah OPC Type 1 bayar
  $table2 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_copct1 ,  SUM(jumlah) AS uang_copct1  FROM penjualan_sl WHERE  tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Transfer' AND satuan = 'Curah OPC Type 1' OR  tanggal_kirim =  
  '$tanggal_awal' AND status_bayar = 'Lunas Cash' AND satuan = 'Curah OPC Type 1'  ");
  $data2 = mysqli_fetch_array($table2);
  $penjualan_copct1 = $data2['penjualan_copct1'];
  $uang_copct1 = $data2['uang_copct1'];

  //Curah OPC Type 1 Bon
  $table22 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_copct1_bon ,  SUM(jumlah) AS uang_copct1_bon  FROM penjualan_sl WHERE   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Bon' AND satuan = 'Curah OPC Type 1' 
                                                                                                                                  OR tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Nyicil' AND satuan = 'Curah OPC Type 1'");
  $data22 = mysqli_fetch_array($table22);
  $penjualan_copct1_bon = $data22['penjualan_copct1_bon'];
  $uang_copct1_bon= $data22['uang_copct1_bon'];

  //Curah PCC bayar
  $table3 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_cpcc ,  SUM(jumlah) AS uang_cpcc  FROM penjualan_sl WHERE   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Transfer' AND satuan = 'Curah PCC' OR   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Cash' AND satuan = 'Curah PCC'  ");
  $data3 = mysqli_fetch_array($table3);
  $penjualan_cpcc = $data3['penjualan_cpcc'];
  $uang_cpcc = $data3['uang_cpcc'];

  //Curah PCC Bon
  $table32 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_cpcc_bon ,  SUM(jumlah) AS uang_cpcc_bon  FROM penjualan_sl WHERE   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Bon' AND satuan = 'Curah PCC' 
                                                                                                                              OR tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Nyicil' AND satuan = 'Curah PCC'");
  $data32 = mysqli_fetch_array($table32);
  $penjualan_cpcc_bon = $data32['penjualan_cpcc_bon'];
  $uang_cpcc_bon= $data32['uang_cpcc_bon'];

  //Big Bag OPC Type 1 bayar
  $table4 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_bopct1 ,  SUM(jumlah) AS uang_bopct1  FROM penjualan_sl WHERE   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Transfer' AND satuan = 'Big Bag OPC Type 1' OR   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Cash' AND satuan = 'Big Bag OPC Type 1'  ");
  $data4 = mysqli_fetch_array($table4);
  $penjualan_bopct1 = $data4['penjualan_bopct1'];
  $uang_bopct1 = $data4['uang_bopct1'];

  //Big Bag OPC Type 1 Bon
  $table42 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_bopct1_bon ,  SUM(jumlah) AS uang_bopct1_bon  FROM penjualan_sl WHERE   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Bon' AND satuan = 'Big Bag OPC Type 1'
                                                                                                                                  OR tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Nyicil' AND satuan = 'Big Bag OPC Type 1'");
  $data42 = mysqli_fetch_array($table42);
  $penjualan_bopct1_bon = $data42['penjualan_bopct1_bon'];
  $uang_bopct1_bon= $data42['uang_bopct1_bon'];

  //Big Bag PCC bayar
  $table5 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_bpcc ,  SUM(jumlah) AS uang_bpcc  FROM penjualan_sl WHERE   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Transfer' AND satuan = 'Big Bag PCC' OR   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Cash' AND satuan = 'Big Bag PCC'  ");
  $data5 = mysqli_fetch_array($table5);
  $penjualan_bpcc = $data5['penjualan_bpcc'];
  $uang_bpcc = $data5['uang_bpcc'];

  //Big Bag PCC Bon
  $table52 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_bpcc_bon ,  SUM(jumlah) AS uang_bpcc_bon  FROM penjualan_sl WHERE  tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Bon' AND satuan = 'Big Bag PCC'
                                                                                                                              OR tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Nyicil' AND satuan = 'Big Bag PCC'");
  $data52 = mysqli_fetch_array($table52);
  $penjualan_bpcc_bon = $data52['penjualan_bpcc_bon'];
  $uang_bpcc_bon= $data52['uang_bpcc_bon'];

  $data42['uang_bopct1_bon'];

  //Sak PCC 50 Kg bayar
  $table6 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_sakpcc ,  SUM(jumlah) AS uang_sakpcc  FROM penjualan_sl WHERE   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Transfer' AND satuan = 'Sak PCC 50 Kg' OR   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Cash' AND satuan = 'Sak PCC 50 Kg'  ");
  $data6 = mysqli_fetch_array($table6);
  $penjualan_sakpcc = $data6['penjualan_sakpcc'];
  $uang_sakpcc = $data6['uang_sakpcc'];

  //Sak PCC 50 Kg Bon
  $table62 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_sakpcc_bon ,  SUM(jumlah) AS uang_sakpcc_bon  FROM penjualan_sl WHERE   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Bon' AND satuan = 'Sak PCC 50 Kg'
                                                                                                                                  OR tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Nyicil' AND satuan = 'Sak PCC 50 Kg'");
  $data62 = mysqli_fetch_array($table62);
  $penjualan_sakpcc_bon = $data62['penjualan_sakpcc_bon'];
  $uang_sakpcc_bon= $data62['uang_sakpcc_bon'];

}

else{
  $table = mysqli_query($koneksi,"SELECT * FROM penjualan_sl WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ORDER BY tanggal_kirim ASC");

  //Curah OPC Type 1 bayar
  $table2 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_copct1 ,  SUM(jumlah) AS uang_copct1  FROM penjualan_sl WHERE  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Transfer' AND satuan = 'Curah OPC Type 1' OR  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Cash' AND satuan = 'Curah OPC Type 1'  ");
  $data2 = mysqli_fetch_array($table2);
  $penjualan_copct1 = $data2['penjualan_copct1'];
  $uang_copct1 = $data2['uang_copct1'];

  //Curah OPC Type 1 Bon
  $table22 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_copct1_bon ,  SUM(jumlah) AS uang_copct1_bon  FROM penjualan_sl WHERE  
                                      tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Bon' AND satuan = 'Curah OPC Type 1' OR
                                      tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Nyicil' AND satuan = 'Curah OPC Type 1'");
  $data22 = mysqli_fetch_array($table22);
  $penjualan_copct1_bon = $data22['penjualan_copct1_bon'];
  $uang_copct1_bon= $data22['uang_copct1_bon'];

  //Curah PCC bayar
  $table3 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_cpcc ,  SUM(jumlah) AS uang_cpcc  FROM penjualan_sl WHERE  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Transfer' AND satuan = 'Curah PCC' OR  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Cash' AND satuan = 'Curah PCC'  ");
  $data3 = mysqli_fetch_array($table3);
  $penjualan_cpcc = $data3['penjualan_cpcc'];
  $uang_cpcc = $data3['uang_cpcc'];

  //Curah PCC Bon
  $table32 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_cpcc_bon ,  SUM(jumlah) AS uang_cpcc_bon  FROM penjualan_sl WHERE  
  tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Bon' AND satuan = 'Curah PCC' OR
  tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Nyicil' AND satuan = 'Curah PCC'");
  $data32 = mysqli_fetch_array($table32);
  $penjualan_cpcc_bon = $data32['penjualan_cpcc_bon'];
  $uang_cpcc_bon= $data32['uang_cpcc_bon'];

  //Big Bag OPC Type 1 bayar
  $table4 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_bopct1 ,  SUM(jumlah) AS uang_bopct1  FROM penjualan_sl WHERE  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Transfer' AND satuan = 'Big Bag OPC Type 1' OR  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Cash' AND satuan = 'Big Bag OPC Type 1'  ");
  $data4 = mysqli_fetch_array($table4);
  $penjualan_bopct1 = $data4['penjualan_bopct1'];
  $uang_bopct1 = $data4['uang_bopct1'];

  //Big Bag OPC Type 1 Bon
  $table42 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_bopct1_bon ,  SUM(jumlah) AS uang_bopct1_bon  FROM penjualan_sl WHERE  
  tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Bon' AND satuan = 'Big Bag OPC Type 1' OR
  tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Nyicil' AND satuan = 'Big Bag OPC Type 1'");
  $data42 = mysqli_fetch_array($table42);
  $penjualan_bopct1_bon = $data42['penjualan_bopct1_bon'];
  $uang_bopct1_bon= $data42['uang_bopct1_bon'];

  //Big Bag PCC bayar
  $table5 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_bpcc ,  SUM(jumlah) AS uang_bpcc  FROM penjualan_sl WHERE  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Transfer' AND satuan = 'Big Bag PCC' OR  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Cash' AND satuan = 'Big Bag PCC'  ");
  $data5 = mysqli_fetch_array($table5);
  $penjualan_bpcc = $data5['penjualan_bpcc'];
  $uang_bpcc = $data5['uang_bpcc'];

  //Big Bag PCC Bon
  $table52 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_bpcc_bon ,  SUM(jumlah) AS uang_bpcc_bon  FROM penjualan_sl WHERE 
   tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Bon' AND satuan = 'Big Bag PCC' OR
   tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Nyicil' AND satuan = 'Big Bag PCC'");
  $data52 = mysqli_fetch_array($table52);
  $penjualan_bpcc_bon = $data52['penjualan_bpcc_bon'];
  $uang_bpcc_bon= $data52['uang_bpcc_bon'];

  $data42['uang_bopct1_bon'];

  //Sak PCC 50 Kg bayar
  $table6 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_sakpcc ,  SUM(jumlah) AS uang_sakpcc  FROM penjualan_sl WHERE  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Transfer' AND satuan = 'Sak PCC 50 Kg' OR  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Cash' AND satuan = 'Sak PCC 50 Kg'  ");
  $data6 = mysqli_fetch_array($table6);
  $penjualan_sakpcc = $data6['penjualan_sakpcc'];
  $uang_sakpcc = $data6['uang_sakpcc'];

  //Sak PCC 50 Kg Bon
  $table62 = mysqli_query($koneksi, "SELECT SUM(qty) AS penjualan_sakpcc_bon ,  SUM(jumlah) AS uang_sakpcc_bon  FROM penjualan_sl WHERE  
  tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Bon' AND satuan = 'Sak PCC 50 Kg' OR
  tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Nyicil' AND satuan = 'Sak PCC 50 Kg'");
  $data62 = mysqli_fetch_array($table62);
  $penjualan_sakpcc_bon = $data62['penjualan_sakpcc_bon'];
  $uang_sakpcc_bon= $data62['uang_sakpcc_bon'];

 

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

  <title>Penjualan Semen</title>

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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKasir">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="margin-top: 50px; height: 100px; width: 110px; " src="../gambar/Logo PBJ.PNG" ></div>
</a>
<br>

<br>
<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active" >
    <a class="nav-link" href="DsAdminSemen">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         ADMIN SEMEN
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;">Kasir</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Kasir</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Penjualan Semen</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Pengiriman</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPenebusan">Penebusan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaran">Pengeluaran</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan">Laporan Keuangan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapDoPenjualanL">Rekap DO Penjualan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapDoPembelian">Rekap DO Pembelian</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPotonganHarga">Potongan Harga</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitDriver">Laporan Rit</a> 
            <a class="collapse-item" style="font-size: 15px;" href="VSewaHiBlow">Uang Sewa Hi Blow</a> 
        </div>
    </div>
</li>
<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
      15  aria-expanded="true" aria-controls="collapseTwo1">
        <i class="fas fa-truck-moving" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >SDM</span>
    </a>
    <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VKendaraan">Kendaraan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VDriverSemen">List Driver</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTokoDO">List Toko DO</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListKota">List Kota</a>
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
      <?php echo "<a href='VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Penjualan Semen</h5></a>"; ?>

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


    <?php  echo "<form  method='POST' action='VPenjualan' style='margin-bottom: 15px;'>" ?>
    <div>
      <div align="left" style="margin-left: 20px;"> 
        <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1"> 
        <span>-</span>
        <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
        <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm" >Lihat</button>
      </div>
    </div>
  </form>

  <br>
  <br>
  <div class="row">
    <div class="col-md-6">
     <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
   </div>
   <div class="col-md-6">
    <!-- Button Input Data Bayar -->
    <div align="right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Catat Pembayaran </button> <br> <br>
    </div>

    <!-- Form Modal  -->
    <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role ="document">
       <div class="modal-content"> 
        <div class="modal-header">
          <h5 class="modal-title"> Form Pembayaran </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> 

        <!-- Form Input Data -->
        <div class="modal-body" align="left">
          <?php  echo "<form action='../proses/proses_penjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

          <div class="row">
            <div class="col-md-6">
              <label>Tanggal DO</label>
              <div class="col-sm-10">
               <input type="date"  name="tanggal_do">
             </div>
           </div>
           <div class="col-md-6">
            <label>Tanggal Kirim</label>
            <div class="col-sm-10">
             <input type="date"  name="tanggal_kirim" required >
           </div>
         </div>
       </div>

       <br>

       <div class="row">
        <div class="col-md-6">
          <label>NO Do</label>
          <div class="col-sm-10">
            <input class="form-control form-control-sm" type="text" id="no_do" name="no_do"  >
          </div>
        </div>

    <div class="col-md-6">
      <label>No Polisi</label>
      <div class="col-sm-10">
            <input class="form-control form-control-sm" type="text" id="no_polisi" name="no_polisi"  required="">
          </div>
    </div>
        
      </div>

      <br>

      <div class="row">
        <div class="col-md-6">
          <label>Tujuan Pengiriman</label>
          <div class="col-sm-12">
            <input class="form-control form-control-sm" type="text" id="tujuan_pengiriman" name="tujuan_pengiriman"  required="">
          </div>
        </div>

        <div class="col-md-6">
      <label>Driver</label>
      <div class="col-sm-12">
        <input class="form-control form-control-sm" type="text" id="driver" name="driver"  required="">
      </div>
    </div>
      </div>

      <br>

      <div class="row">
        <div class="col-md-6">
          <label>QTY</label>
          <input class="form-control form-control-sm" type="float" id="qty" name="qty" onkeyup="sum();" required="">
        </div>    
        <div class="col-md-6">
          <label>Satuan</label>
          <select id="satuan" name="satuan" class="form-control">
            <option>Big Bag OPC Type 1</option>
            <option>Big Bag PCC</option>
            <option>Curah OPC Type 1</option>
            <option>Curah PCC </option>
            <option>Sak PCC 50 Kg </option>
          </select>
        </div>                
      </div>

     

     <br>

     <div class="row">
     <div class="col-md-4">
        <label>Harga Beli</label>
        <input class="form-control form-control-sm" type="number" id="harga_beli" name="harga_beli" required="">
      </div>   
      <div class="col-md-4">
        <label>Harga Jual</label>
        <input class="form-control form-control-sm" type="float" id="harga" name="harga" onkeyup="sum();" required="">
      </div>    
      <div class="col-md-4">
       <label>Jumlah</label>
       <input class="form-control form-control-sm" type="float" id="jumlah" name="jumlah" required=""> 
     </div>                
   </div>

   <br>

   <div class="row">
    <div class="col-md-6">
      <label>Nama Toko di DO</label>
      <select id="tokens" class="selectpicker form-control" name="toko_do" multiple data-live-search="true">
        <option></option>
        <?php
        include 'koneksi.php';
        $result = mysqli_query($koneksi, "SELECT * FROM toko_do_l");   

        while ($data2 = mysqli_fetch_array($result)){
          $data_pangakalan = $data2['nm_lokasi'];

            echo "<option> $data_pangakalan </option> ";
          
        }
        ?>
      </select>
    </div>
    <div class="col-md-6">
      <label>Tempo</label>
      <input class="form-control form-control-sm" type="text" id="tempo" name="tempo"  >
    </div>
  </div>

  <br>


  <div class="row">
    <div class="col-md-6">
      <label>Tanggal Bayar</label>
      <div class="col-sm-10">
       <input type="date"  name="tanggal_bayar" >
     </div>
   </div>
   <div class="col-md-6">
    <label>Status Bayar</label>
    <select id="status_bayar" name="status_bayar" class="form-control">
      <option>Lunas Transfer</option>
      <option>Lunas Cash</option>
      <option>Nyicil</option>
      <option>Bon</option>
    </select>
  </div>
</div>

<br>

<div>
 <label>Keterangan</label>
 <div class="form-group">
   <textarea id = "keterangan" name="keterangan" style="width: 300px;"></textarea>
 </div>

 <br>
 <label>Catatan</label>
 <div class="form-group">
   <textarea id = "catatan" name="catatan" style="width: 300px;"></textarea>
 </div>

 <br>
 <div class="col-md-6">
   <label>Bulan</label>
   <input class="form-control form-control-sm" type="text" id="bulan" name="bulan" > 
 </div>   

 <br>
 <div>
  <label>Upload File</label> 
  <input type="file" name="file"> 
</div> 


<div class="modal-footer">
  <button type="submit" class="btn btn-primary"> OKE </button>
  <button type="reset" class="btn btn-danger"> BATAL </button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>




<!-- Tabel -->    
<div style="overflow-x: auto">
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>Edit</th>
      <th>Pengiriman</th>
      <th>Delete</th>
      <th>TGL DO</th>
      <th>TGL Kirim</th>
      <th>NO DO</th>
      <th>Driver</th>
      <th>NO Polisi</th>
      <th>Tujuan Pengiriman</th>
      <th>Material</th>
      <th>QTY</th>
      <th>Harga Beli</th>
      <th>Harga Jual</th>
      <th>Jumlah</th>    
      <th>Nama Toko di DO</th>
      <th>TGL Bayar</th>
      <th>Status Bayar</th>
      <th>Ket</th>
      <th>Catatan</th>
      <th>File</th>
      
    </tr>
  </thead>
  <tbody>
    <?php
    $no_urut = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>

    <?php while($data = mysqli_fetch_array($table)){
      $no_penjualan = $data['no_penjualan'];
      $tanggal_do =$data['tanggal_do'];
      $tanggal_kirim = $data['tanggal_kirim'];
      $no_do = $data['no_do'];
      $driver = $data['driver'];
      $no_polisi = $data['no_polisi'];
      $tujuan_pengiriman = $data['tujuan_pengiriman'];
      $qty = $data['qty'];
      $satuan = $data['satuan'];
      $harga_beli = $data['harga_beli'];
      $harga = $data['harga'];
      $jumlah = $data['jumlah'];
      $toko_do = $data['toko_do'];
      $tempo = $data['tempo'];
      $tanggal_bayar = $data['tanggal_bayar'];
      $status_bayar = $data['status_bayar'];
      $keterangan = $data['keterangan'];
      $catatan = $data['catatan'];
      $bulan = $data['bulan'];
      $file_bukti = $data['file_bukti'];
      $no_urut = $no_urut + 1;


      echo "<tr>
      <td style='font-size: 14px'>$no_urut</td> "; ?>
         <?php echo "<td style='font-size: 12px'>"; ?>
      <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_penjualan']; ?>">Edit</button>

      <!-- Form EDIT DATA -->

      <div class="modal fade bd-example-modal-lg" id="formedit<?php echo $data['no_penjualan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role ="document">
          <div class="modal-content"> 
            <div class="modal-header">
              <h5 class="modal-title"> Form Edit Penjualan </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true"> &times; </span>
              </button>
            </div>

            <!-- Form Edit Data -->
            <div class="modal-body" align="left">
             <form action="../proses/edit_penjualan" enctype="multipart/form-data" method="POST">

              <input type="hidden" name="no_penjualan" value="<?php echo $no_penjualan;?>"> 
              <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
              <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir;?>">
              <input type="hidden" name="tanggal" value="<?php echo $tanggal;?>">


              <div class="row">
                <div class="col-md-6">
                  <label>Tanggal DO</label>
                  <div class="col-sm-10">
                   <input type="date"  name="tanggal_do" value="<?php echo $tanggal_do;?>">
                 </div>
               </div>
               <div class="col-md-6">
                <label>Tanggal Kirim</label>
                <div class="col-sm-10">
                 <input type="date"  name="tanggal_kirim" value="<?php echo $tanggal_kirim;?>">
               </div>
             </div>
           </div>

           <br>

           <div class="row">
            <div class="col-md-6">
              <label>NO Do</label>
              <div class="col-sm-10">
                <input class="form-control form-control-sm" type="text" id="no_do" name="no_do"  value="<?php echo $no_do;?>">
              </div>
            </div>
             <div class="col-md-6">
          <label>No Polisi</label>
          <input class="form-control form-control-sm" type="text" id="no_polisi" name="no_polisi" required="" value="<?php echo $no_polisi;?>">
        </div>
          </div>

          <br>

          <div class="row">
            <div class="col-md-6">
              <label>Tujuan Pengiriman</label>
              <div class="col-sm-12">
                <input class="form-control form-control-sm" type="text" id="tujuan_pengiriman" name="tujuan_pengiriman"  required="" value="<?php echo $tujuan_pengiriman;?>">
              </div>
            </div>
             <div class="col-md-6">
          <label>Driver</label>
          <input class="form-control form-control-sm" type="text" id="driver" name="driver" required="" value="<?php echo $driver;?>">
        </div>
          </div>

          <br>

          <div class="row">
            <div class="col-md-6">
              <label>QTY</label>
              <input class="form-control form-control-sm" type="float" id="qty" name="qty" onkeyup="sum();" required="" value="<?php echo $qty;?>">
            </div>    
            <div class="col-md-6">
              <label>Satuan</label>
              <select id="satuan" name="satuan" class="form-control">
              <?php $dataSelect = $data['satuan']; ?>  
                 <option <?php echo ($dataSelect == 'Big Bag OPC Type 1') ? "selected": "" ?> >Big Bag OPC Type 1</option>
                 <option <?php echo ($dataSelect == 'Big Bag PCC') ? "selected": "" ?> >Big Bag PCC</option>
                 <option <?php echo ($dataSelect == 'Curah OPC Type 1') ? "selected": "" ?> >Curah OPC Type 1</option>
                 <option <?php echo ($dataSelect == 'Curah PCC') ? "selected": "" ?> >Curah PCC</option>
                 <option <?php echo ($dataSelect == 'Sak PCC 50 Kg') ? "selected": "" ?> >Sak PCC 50 Kg </option>
              </select>
            </div>                
          </div>

         

         <br>

         <div class="row">
         <div class="col-md-6">
            <label>Harga Beli</label>
            <input class="form-control form-control-sm" type="number" name="harga_beli" required=""value="<?php echo $harga_beli;?>" >
          </div> 
          <div class="col-md-6">
            <label>Harga Jual</label>
            <input class="form-control form-control-sm" type="float" id="harga" name="harga" onkeyup="sum();" required="" value="<?php echo $harga;?>">
          </div>               
       </div>

       <br>

       <div class="row">  
        <div class="col-md-6">
          <label>Nama Toko di DO</label>
          <div>
          <select id="tokens" class="selectpicker form-control" name="toko_do" multiple data-live-search="true">
            <option></option>
            <?php
            include 'koneksi.php';
            $result = mysqli_query($koneksi, "SELECT * FROM toko_do_l");   
            $dataSelect = $data['toko_do'];
            while ($data2 = mysqli_fetch_array($result)){
              $data_pangakalan = $data2['nm_lokasi'];

           
                echo "<option" ?> <?php echo ($dataSelect == $data_pangakalan) ? "selected" : "" ?>> <?php echo $data_pangakalan; ?> <?php echo "</option>" ;
              
            }
            ?>
          </select>
          </div>
        </div>

        <div class="col-md-6">
          <label>Tempo</label>
          <input class="form-control form-control-sm" type="text" id="tempo" name="tempo" value="<?php echo $tempo;?>">
        </div>
      </div>

      <br>


      <div class="row">
        <div class="col-md-6">
          <label>Tanggal Bayar</label>
          <div class="col-sm-10">
           <input type="date"  name="tanggal_bayar"  value="<?php echo $tanggal_bayar;?>">
         </div>
       </div>
       <div class="col-md-6">
        <label>Status Bayar</label>
        <select id="status_bayar" name="status_bayar" class="form-control">
         <?php
         $dataSelect = $data['status_bayar']; ?>  
         <option <?php echo ($dataSelect == 'Lunas Transfer') ? "selected": "" ?> >Lunas Transfer</option>
         <option <?php echo ($dataSelect == 'Lunas Cash') ? "selected": "" ?> >Lunas Cash</option>
         <option <?php echo ($dataSelect == 'Nyicil') ? "selected": "" ?> >Nyicil</option>
         <option <?php echo ($dataSelect == 'Bon') ? "selected": "" ?> >Bon</option>
       </select>

     </div>
   </div>

   <br>

   <div>
     <label>Keterangan</label>
     <div class="form-group">
       <textarea id = "keterangan" name="keterangan" style="width: 300px;"><?php echo $keterangan;?></textarea>
     </div>
   </div>
   <br>
     <label>Catatan</label>
     <div class="form-group">
       <textarea id = "catatan" name="catatan" style="width: 300px;"><?php echo $catatan;?></textarea>
     </div>
     <br>
     <div>
     <div class="form-group">
       <label>Bulan</label>
       <input class="form-control form-control-sm" type="text" id="bulan" name="bulan"  value="<?php echo $bulan;?>"> 
     </div>   
     </div>
     <br>
     <div>
      <label>Upload File</label> 
      <input type="file" name="file"> 
    </div> 


<div class="modal-footer">
  <button type="submit" class="btn btn-primary"> UBAH </button>
  <button type="reset" class="btn btn-danger"> BATAL </button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>

<?php echo "</td>"; ?>
<?php echo "<td style='font-size: 12px'>"; ?>
    
      <button type="button" class="fas fa-shipping-fast bg-info mr-2 rounded" data-toggle="modal" data-target="#inputpengiriman<?php echo $data['no_penjualan']; ?>"></i>Pengiriman</button>

    <!-- Form Modal  -->
    <div class="modal fade bd-example-modal-lg" id="inputpengiriman<?php echo $data['no_penjualan']; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
          <?php  echo "<form action='../proses/proses_pengiriman?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

          <br>
          <div class="row">
            <div class="col-md-6">
                
              <label>Tanggal Kirim</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal_antar" name="tanggal_antar" disabled="" value="<?php echo $tanggal_kirim;?>" >
                <input type="hidden" name="tanggal_antar" value="<?php echo $tanggal_kirim;?>"> 
                <input type="hidden" name="no_penjualan" value="<?php  echo $data['no_penjualan'];?>"> 
             </div>      

           </div>
           <div class="col-md-6">


           </div>
         </div>
         <br>

         <div class="row">

          <div class="col-md-6">
           <label>Driver</label>
          <input class="form-control form-control-sm" type="text" id="driver" name="driver" disabled="" value="<?php echo $driver;?>" >
          <input type="hidden" name="driver" value="<?php echo $driver;?>"> 
        </div>

        <div class="col-md-6">
          <label>Kendaraan</label>
          <input class="form-control form-control-sm" type="text" id="no_polisi" name="no_polisi" disabled="" value="<?php echo $no_polisi;?>" >
          <input type="hidden" name="no_polisi" value="<?php echo $no_polisi;?>"> 
        </div>            

      </div>

      <br>

      <div class="row">

        <div class="col-md-6">
          <label>NO DO</label>
          <input class="form-control form-control-sm" type="text" id="no_do" name="no_do" disabled="" value="<?php echo $no_do;?>" >
          <input type="hidden" name="no_do" value="<?php echo $no_do;?>"> 
        </div>    


        <div class="col-md-6">
          <label>Nama Toko di DO</label>
          <input class="form-control form-control-sm" type="text" id="toko_do" name="toko_do" disabled="" value="<?php echo $toko_do;?>" >
          <input type="hidden" name="toko_do" value="<?php echo $toko_do;?>"> 
        </div>          

      </div>

      <br>

      <div class="row">
        
        <div class="col-md-6">
          <label>Uang Jalan</label>
          <input class="form-control form-control-sm" type="number" id="uj" name="uj">
        </div>  

      
        <div class="col-md-6">
          <label>Uang Gaji</label>
          <input class="form-control form-control-sm" type="number" id="ug" name="ug" >
        </div>  

        <div class="col-md-6">
          <label>Ongkos Mobil</label>
          <input class="form-control form-control-sm" type="number" id="om" name="om">
        </div>   
               
     </div>
  <br>
<div class="row">
            <div class="col-md-6">

              <label>Tanggal Ambil Gaji</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal_gaji" name="tanggal_gaji" >
             </div>      

           </div>
            <div class="col-md-6">

              <label>Tanggal Nota Tarikan</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal_nota" name="tanggal_nota" >
             </div>      

           </div>
         </div>
    <br>

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
      <button type="submit" class="btn btn-primary"> OKE </button>
      <button type="reset" class="btn btn-danger"> BATAL </button>
    </div>
  </form>
</div>

</div>
</div>
</div>
</div>
</div>

<?php echo "</td>"; ?>
<?php echo "<td style='font-size: 12px'>"; ?>
<button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_penjualan']; ?>" data-toggle='tooltip' title='Hapus Transaksi'>Hapus</button>

<div class="modal fade" id="PopUpHapus<?php echo $data['no_penjualan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
 <div class="modal-dialog" role ="document">
   <div class="modal-content"> 
    <div class="modal-header">
      <h4 class="modal-title"> <b> Hapus </b> </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="close">
        <span aria-hidden="true"> &times; </span>
      </button>
    </div>

    <div class="modal-body">
      <form action="../proses/hapus_penjualan" method="POST">
        <input type="hidden" name="no_penjualan" value="<?php echo $data['no_penjualan'];?>">
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
<?php echo " </td>
      <td style='font-size: 14px'>$tanggal_do</td>
      <td style='font-size: 14px'>$tanggal_kirim</td>
      <td style='font-size: 14px'>$no_do</td>
      <td style='font-size: 14px'>$driver</td>
      <td style='font-size: 14px'>$no_polisi</td>
      <td style='font-size: 14px'>$tujuan_pengiriman</td>
      <td style='font-size: 14px'>$satuan</td>
      <td style='font-size: 14px'>$qty</td>
      <td style='font-size: 14px'>";?> <?= formatuang($harga_beli); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($harga); ?> <?php echo "</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
      <td style='font-size: 14px'>$toko_do</td>
      <td style='font-size: 14px'>$tanggal_bayar</td>
      <td style='font-size: 14px'>$status_bayar</td>
      <td style='font-size: 14px'>$keterangan</td>
      <td style='font-size: 14px'>$catatan</td>
      <td style='font-size: 14px'>"; ?> <a download="../file_admin_semen/<?= $file_bukti ?>" href="../file_admin_semen/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>
   



<?php echo  " </tr>";
}
?>

</tbody>
</table>
</div>
<br>
<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Penjualan Big Bag OPC Type 1</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  $penjualan_bopct1 ?></div>
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
            Total Uang Big Bag OPC Type 1</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  formatuang($uang_bopct1) ?></div>
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
            Total Big Bag OPC Type 1 BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_bopct1_bon  ?></div>
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
            Total Uang Big Bag OPC Type 1 BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=formatuang($uang_bopct1_bon)?></div>
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
<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Penjualan Big Bag PCC</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=    $penjualan_bpcc   ?></div>
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
            Total Uang Big Bag PCC</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_bpcc) ?></div>
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
            Total Big Bag PCC BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_bpcc_bon ?></div>
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
            Total Uang Big Bag PCC BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_bpcc_bon)?></div>
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

<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Penjualan Curah OPC Type 1</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=    round($penjualan_copct1,3)   ?></div>
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
            Total Uang Curah OPC Type 1</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_copct1) ?></div>
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
            Total Curah OPC Type 1 BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_copct1_bon  ?></div>
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
            Total Uang Curah OPC Type 1 BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_copct1_bon)?></div>
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


<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Penjualan Curah PCC</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=    $penjualan_cpcc  ?></div>
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
            Total Uang Curah PCC</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_cpcc) ?></div>
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
            Total Curah PCC BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_cpcc_bon  ?></div>
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
            Total Uang Curah PCC BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_cpcc_bon)?></div>
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


<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Penjualan Sak PCC 50 Kg</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=    $penjualan_sakpcc   ?></div>
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
            Total Uang Sak PCC 50 Kg</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_sakpcc) ?></div>
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
            Total Sak PCC 50 Kg BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_sakpcc_bon  ?></div>
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
            Total Uang Sak PCC 50 Kg BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_sakpcc_bon)?></div>
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
<script>

function sum() {
  var banyak_barang = document.getElementById('qty').value;
  var harga = document.getElementById('harga').value;
  var result = parseFloat(banyak_barang) * parseFloat(harga);
  if (!isNaN(result)) {
   document.getElementById('jumlah').value = result;
 }
}
</script>
</body>

</html>