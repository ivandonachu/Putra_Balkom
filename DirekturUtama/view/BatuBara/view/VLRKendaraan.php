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
   $no_polisi = $_GET['no_polisi'];
} 

elseif (isset($_POST['tanggal1'])) {
   $tanggal_awal = $_POST['tanggal1'];
   $tanggal_akhir = $_POST['tanggal2'];
   $no_polisi = $_GET['no_polisi'];
}  


function formatuang($angka){
  $uang = "Rp " . number_format($angka,2,',','.');
  return $uang;
}

if ($tanggal_awal == $tanggal_akhir) {
  // tabel lr kendaraan
  $tablex = mysqli_query($koneksipbj, "SELECT * FROM kendaraan WHERE status_kendaraan = 'Angkutan' ");

  // Tagihan
  $table = mysqli_query($koneksipbj, "SELECT muatan , harga_tagihan FROM riwayat_pengiriman a INNER JOIN kendaraan b on b.no_kendaraan=a.no_kendaraan  WHERE tanggal = '$tanggal_awal' AND b.no_polisi = '$no_polisi' ");
  
  $total_tagihan=0;
  while($data = mysqli_fetch_array($table)){
    $muatan = $data['muatan'];
    $harga_tagihan = $data['harga_tagihan'];

    $total_tagihan = $total_tagihan + ($muatan * $harga_tagihan);

  }
  //pengiriman
  $table2 = mysqli_query($koneksipbj, "SELECT SUM(uj_tagihan) AS total_uj, SUM(gaji_tagihan) AS total_gaji FROM riwayat_pengiriman a INNER JOIN kendaraan b on b.no_kendaraan=a.no_kendaraan WHERE tanggal_masuk = '$tanggal_awal' AND b.no_polisi = '$no_polisi'");
  $data2 = mysqli_fetch_array($table2);
  $total_uj= $data2['total_uj'];
  $total_gaji= $data2['total_gaji'];

    //pengeluran perbaikan
   $table7 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS total_pembelian_sparepart FROM riwayat_oprasional a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal = '$tanggal_awal' AND a.kode_akun = '5-595' ");
   $data7 = mysqli_fetch_array($table7);
   $jml_pembelian = $data7['total_pembelian_sparepart'];    
    if (!isset($data7['total_pembelian_sparepart'])) {
    $jml_pembelian = 0;
    }

    $table8 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_perbaikan FROM riwayat_oprasional a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun WHERE tanggal = '$tanggal_awal' AND a.kode_akun = '5-596' ");
   $data8 = mysqli_fetch_array($table8);
   $jml_perbaikan = $data8['jumlah_perbaikan'];
    if (!isset($data8['jumlah_perbaikan'])) {
    $jml_perbaikan = 0;
    }
$laba_bersih_sebelum_pajak = $total_tagihan - ($total_uj + $total_gaji + $jml_listrik + $jml_sewa + $jml_atk + $jml_perbaikan + $jml_pembelian + $jml_biaya_kantor);
    $total_biaya_usaha_final =  $jml_biaya_kantor + $jml_listrik + $jml_sewa + $jml_atk + $jml_perbaikan + $jml_pembelian + $total_uj + $total_gaji ;

}
else{
     // tabel lr kendaraan
  $tablex = mysqli_query($koneksipbj, "SELECT * FROM kendaraan WHERE status_kendaraan = 'Angkutan'");
    // Tagihan
  $table = mysqli_query($koneksipbj, "SELECT muatan , harga_tagihan FROM riwayat_pengiriman a INNER JOIN kendaraan b on b.no_kendaraan=a.no_kendaraan 
                                      WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND b.no_polisi = '$no_polisi'");
  $total_tagihan=0;
  while($data = mysqli_fetch_array($table)){
    $muatan = $data['muatan'];
    $harga_tagihan = $data['harga_tagihan'];

    $total_tagihan = $total_tagihan + ($muatan * $harga_tagihan);

  }
  //pengiriman
  $table2 = mysqli_query($koneksipbj, "SELECT SUM(uj_tagihan) AS total_uj, SUM(gaji_tagihan) AS total_gaji FROM riwayat_pengiriman a 
                                       INNER JOIN kendaraan b on b.no_kendaraan=a.no_kendaraan  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' 
                                       AND b.no_polisi = '$no_polisi'");
  $data2 = mysqli_fetch_array($table2);
  $total_uj= $data2['total_uj'];
  $total_gaji= $data2['total_gaji'];


    //pengeluran perbaikan
   $table7 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS total_pembelian_sparepart FROM riwayat_perbaikan a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun INNER JOIN kendaraan c on c.no_kendaraan=a.no_kendaraan WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.kode_akun = '5-596' AND c.no_polisi = '$no_polisi' ");
   $data7 = mysqli_fetch_array($table7);
   $jml_pembelian = $data7['total_pembelian_sparepart'];
    if (!isset($data7['total_pembelian_sparepart'])) {
    $jml_pembelian = 0;
    }

    $table8 = mysqli_query($koneksipbj, "SELECT SUM(jumlah) AS jumlah_perbaikan FROM riwayat_perbaikan a INNER JOIN kode_akun b ON a.kode_akun=b.kode_akun INNER JOIN kendaraan c on c.no_kendaraan=a.no_kendaraan WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.kode_akun = '5-595' AND c.no_polisi = '$no_polisi'");
   $data8 = mysqli_fetch_array($table8);
   $jml_perbaikan = $data8['jumlah_perbaikan'];
    if (!isset($data8['jumlah_perbaikan'])) {
    $jml_perbaikan = 0;
    }
    

    
    

}
    $total_biaya_usaha_final =  $jml_perbaikan + $jml_pembelian ;
    $laba_bersih_sebelum_pajak = $total_tagihan - $total_biaya_usaha_final ;
    
?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laba Rugi Angkutan Batu Bara</title>

    <!-- Custom fonts for this template-->
    <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Custom styles for this template-->
    <link href="/sbadmin/css/sb-admin-2.min.css" rel="stylesheet">


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
                        <a class="collapse-item" style="font-size: 15px;" href="DsCVPBJ">Transport BB</a>
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
                    <span style="font-size: 15px; color:white;" >Laporan</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Laporan</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VLR">Laba Rugi</a>
                        
                        <a class="collapse-item" style="font-size: 15px;" href="VLSaldo">Laporan Saldo</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VCatatPengiriman">Riwayat Pengiriman</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPerbaikan">Beban Kendaraan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VOperasional">Beban Operasional</a>
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
<div class="container" style="color : black;">
<div align="left">
      <?php echo "<a href='VLR2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><button type='button' class='btn btn-primary'>Kembali</button></a>"; ?>
    </div>


<br>
<br>
<?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
<br>
<br>
<br>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laba Rugi  <?= $no_polisi; ?> Batu Bara</strong></h3>
        </div>

        <div>

        </div>



        <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-condensed"  style="color : black;">
                  <thead>
                    <tr>
                     <td><strong>Akun</strong></td>
                     <td class="text-left"><strong>Nama Akun</strong></td>
                     <td class="text-left"><strong>Debit</strong></td>
                     <td class="text-left"><strong>Kredit</strong></td>
                     <td class="text-right"><strong>Aksi</strong></td>
                 </tr>
             </thead>
             <tbody>
                 <!-- foreach ($order->lineItems as $line) or some such thing here -->
                 <tr>
                    <td><strong>4-000</strong></td>
                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                    <?php echo "<td class='text-right'></td>"; ?>
                </tr>
                <tr>
                 <td>4-100</td>
                 <td class="text-left">Tagihan</td>
                 <td class="text-left"><?= formatuang($total_tagihan); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
                 <?php echo "<td class='text-right'><a href='VRincianLRKen/VRTagihan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&no_polisi=$no_polisi'></a></td>"; ?>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>LABA KOTOR</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($total_tagihan); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <td class="thick-line"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
                <td class="thick-line"></td>
            </tr>
            <tr>
                <td><strong>5-500</strong></td>
                <td class="text-left"><strong>BIAYA USAHA</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
                <?php echo "<td class='text-right'></td>"; ?>
            </tr>
            <tr>
                <td>5-594</td>
                <td class="text-left">Uang Gaji</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_gaji); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRKen/VRincianUJ?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&no_polisi=$no_polisi'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-595</td>
                <td class="text-left">Biaya Perbaikan Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_perbaikan); ?></td>
               <?php echo "<td class='text-right'><a href='VRincianLRKen/VRPerbaikan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&no_polisi=$no_polisi'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-596</td>
                <td class="text-left">Pemeblian Sparepart</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_pembelian); ?></td>
               <?php echo "<td class='text-right'><a href='VRincianLRKen/VRPembelian?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&no_polisi=$no_polisi'>Rincian</a></td>"; ?>
            </tr>
            <tr>
                <td>5-597</td>
                <td class="text-left">Uang Jalan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_uj); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRKen/VRincianUJ?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&no_polisi=$no_polisi'>Rincian</a></td>"; ?>
            </tr>

            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Total Biaya Usaha</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_biaya_usaha_final); ?></td>
                <td class="thick-line"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
                <td class="thick-line"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
                <td class="thick-line"></td>
            </tr>
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_sebelum_pajak > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_sebelum_pajak < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak); ?></td>

                <?php }
                else if ($total_tagihan == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
                <td class="thick-line"></td>
            </tr>
        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
<hr>
<br>
<br>
<h3 class="panel-title" align="Center"><strong>Laba Rugi Kendaraan</strong></h3>
<!-- Tabel -->    
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No</th>
      <th>No Polisi</th>
      <th>Jenis Kendaraan</th>
      <th></th>
    </tr>
  </thead>
  <tbody>

    <?php while($data = mysqli_fetch_array($tablex)){
      $no = $data['no_kendaraan'];
     $no_polisi = $data['no_polisi'];
     $jenis_kendaraan =$data['status_kendaraan'];

     echo "<tr>
     <td style='font-size: 14px' align = 'center'>$no</td>
     <td style='font-size: 14px' align = 'center'>$no_polisi</td>
     <td style='font-size: 14px' align = 'center'>$jenis_kendaraan</td>
     "; ?>
     <?php echo "<td class='text-center'><a href='VLRKendaraan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&no_polisi=$no_polisi'>LR Kendaraan</a></td>"; ?>

<?php echo  " </td> </tr>";
}
?>

</tbody>
</table>
</div>
<br>
<br>
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

<!-- Core plugin JavaScript-->
<script src="/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="/sbadmin/js/sb-admin-2.min.js"></script>

</body>

</html>