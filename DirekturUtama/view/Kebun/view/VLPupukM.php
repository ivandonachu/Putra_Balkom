<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
  header("Location: logout.php");
  exit;
}
$id = $_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksicbm, "SELECT * FROM super_account WHERE username = '$id'");
$data1 = mysqli_fetch_array($result1);
$nama = $data1['nama_pemilik'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Direktur Utama') {
} else {
  header("Location: logout.php");
  exit;
}


if (isset($_GET['tanggal1'])) {
  $tanggal_awal = $_GET['tanggal1'];
  $tanggal_akhir = $_GET['tanggal2'];
} elseif (isset($_POST['tanggal1'])) {
  $tanggal_awal = $_POST['tanggal1'];
  $tanggal_akhir = $_POST['tanggal2'];
} else {
  $tanggal_awal = date('Y-m-1');
  $tanggal_akhir = date('Y-m-31');
}

if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksikebun, "SELECT * FROM stok_pupuk_msj WHERE tanggal = '$tanggal_awal'");
} else {
  $table = mysqli_query($koneksikebun, "SELECT * FROM stok_pupuk_msj WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  
  $table2 = mysqli_query($koneksikebun, "SELECT nama_pupuk, SUM(jumlah_masuk) AS total_masuk, SUM(jumlah_keluar) AS total_keluar  FROM stok_pupuk 
                                    WHERE  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  GROUP BY nama_pupuk  ");


 
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

  <title>Stok Pupuk</title>
  <!-- Custom fonts for this template-->
  <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKebun">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo Melodi.png" ></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active" >
    <a class="nav-link" href="DsKebun">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

     <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu Kebun
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
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/CV.PBJ/view/DsCVPBJ">CV.PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BatuBara/view/DsCVPBJ">Transport BB</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.BALSRI/view/DsPTBALSRI">PT.BALSRI</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.MESPBR/view/DsPTPBRMES">PT. MES & PBR</a>
            <a class="collapse-item" style="font-size: 15px;" href="DsKebun">Kebun</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PERTASHOP/view/DsPertashop">Pertashop</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.STRE/view/DsPTSTRE">PT.Sri Trans Energi</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BALSRI_JBB/view/DsBALSRIJBB">BALSRI JBB</a>
        </div>
    </div>
</li>
    <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoZZZ"
        15  aria-expanded="true" aria-controls="collapseTwoZZZ">
        <i class="fa fa-clipboard-list" style="font-size: 15px; color:white;" ></i>
            <span style="font-size: 15px; color:white;" >Report Laba Rugi</span>
        </a>
        <div id="collapseTwoZZZ" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header" style="font-size: 15px;">Report Laba Rugi</h6>
                <a class="collapse-item" style="font-size: 15px;" href="VLRSeberuk">Laba Rugi Seberuk</a>
                <a class="collapse-item" style="font-size: 15px;" href="VLRLengkiti">Laba Rugi Lengkiti</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
      15  aria-expanded="true" aria-controls="collapseTwo">
      <i class="fa fa-clipboard-list" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Report Lengkiti</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Report Lengkiti</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VLAbsensiL">Absensi Lengkiti</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLKegiatan">Laporan Kegiatan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLKaret">Laporan Karet</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLSawit">Laporan Sawit</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLPengeluaran">Pengeluaran Kebun</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLMinyak">Stok Minyak</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLPupuk">Stok Pupuk</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLBatang">Laporan Batang</a>
        </div>
    </div>
</li>

<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1x"
    15  aria-expanded="true" aria-controls="collapseTwo1x">
    <i class="fa fa-address-card" aria-hidden="true"></i>
        <span style="font-size: 15px; color:white;" >SDM Lengkiti</span>
    </a>
    <div id="collapseTwo1x" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VDriverS">Driver Sawit</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMobilS">Mobil Sawit</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKaryawanK">Karyawan Karet</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKaryawanL">Karyawan Lengkiti</a>
        </div>
    </div>
</li>
 <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
      15  aria-expanded="true" aria-controls="collapseOne">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Pendapatan Seberuk</span>
    </a>
    <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Pendapatan</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VPendapatanKaret">Pendapatan Karet</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTimbanganBTA">Timbangan Baturaja</a>
            <a class="collapse-item" style="font-size: 15px;" href="VDataProduksi">Data Produksi</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTimbanganGetah">Timbangan Getah</a>
        </div>
    </div>
</li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo22"
      15  aria-expanded="true" aria-controls="collapseTwo22">
        <i class="fas fa-file-invoice-dollar" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Pengeluaran Seberuk</span>
    </a>
    <div id="collapseTwo22" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Pengiriman</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VKasBesar">Kas Besar</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKasKecil">Kas Kecil</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGaji">Rekap Gaji</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiPenyadap">Rekap Gaji Penyadap</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiBuhar">Rekap Gaji Buruh Harian</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranBuahSeberuk">Pengeluaran Buah</a>
        </div>
    </div>
</li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo22z"
      15  aria-expanded="true" aria-controls="collapseTwo22z">
        <i class="fas fa-users" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Absensi Seberuk</span>
    </a>
    <div id="collapseTwo22z" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Absensi</h6>
            
            <a class="collapse-item" style="font-size: 15px;" href="VKegiatanHarian">Kegiatan Harian</a>
            <a class="collapse-item" style="font-size: 15px;" href="VAbsensiBuruh">Absensi Buruh</a>
            <a class="collapse-item" style="font-size: 15px;" href="VAbsenFoto">Absensi Foto</a>
        </div>
    </div>
</li>
<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1xz"
      15  aria-expanded="true" aria-controls="collapseTwo1xz">
        <i class="fas fa-car" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >SDM Seberuk</span>
    </a>
    <div id="collapseTwo1xz" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VListBuruh">List Buruh</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListBuruhHarian">List Buruh Harian</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListKendaraan">List Kendaraan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListAsetSeberuk">List Aset Seberuk</a>

        </div>
    </div>
</li>
<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menumesuji1"
      15  aria-expanded="true" aria-controls="menumesuji1">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Laporan Mesuji</span>
    </a>
    <div id="menumesuji1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Laporan</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VLAbsensiM">Absensi Mesuji</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLKegiatanM">Laporan Kegiatan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLSawitM">Laporan Sawit</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLPengeluaranM">Pengeluaran Mesuji</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLMinyakM">Stok Minyak</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLPupukM">Stok Pupuk</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitDriverM">Laporan Rit</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLBatangM">Laporan Batang</a>
        </div>
    </div>
</li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menumesuji2"
      15  aria-expanded="true" aria-controls="menumesuji2">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >SDM Mesuji</span>
    </a>
    <div id="menumesuji2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VDriverM">Driver Sawit</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMobilM">Mobil Sawit</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKaryawanM">Karyawan Karet</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKaryawanM">Karyawan Mesuji</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListAsetMesujiM">List Aset Mesuji</a>
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
          <?php echo "<a href='VLPupuk?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Stok Pupuk</h5></a>"; ?>

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>



          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">





            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline  small" style="color:white;"><?php echo "$nama"; ?></span>
                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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
            <?php echo "<form  method='POST' action='VLPupukM' style='margin-bottom: 15px;'>" ?>
            <div>
              <div align="left" style="margin-left: 20px;">
                <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1">
                <span>-</span>
                <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
                <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm">Lihat</button>
              </div>
            </div>
            </form>
            <div class="row">
              <div class="col-md-6">
                <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
              </div>
             
            </div>






            <!-- Tabel -->
            <table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Akun</th>
                  <th>Nama Pupuk</th>
                  <th>Keterangan</th>
                  <th>Jumlah</th>

                </tr>
              </thead>
              <tbody>
                <?php

                $urut = 0;


                ?>

                <?php while ($data = mysqli_fetch_array($table)) {
                  $no_laporan = $data['no_laporan'];
                  $tanggal = $data['tanggal'];
                  $nama_akun = $data['nama_akun'];
                  $nama_pupuk = $data['nama_pupuk'];
                  $jumlah_masuk = $data['jumlah_masuk'];
                  $jumlah_keluar = $data['jumlah_keluar'];
                  $keterangan = $data['keterangan'];
                  $urut = $urut + 1;


                  echo "<tr>
                <td style='font-size: 14px'>$urut</td>
                <td style='font-size: 14px'>$tanggal</td>
                <td style='font-size: 14px'>$nama_akun</td>
                <td style='font-size: 14px'>$nama_pupuk</td>
                <td style='font-size: 14px'>$keterangan</td>"; ?>
                <?php if($nama_akun == "Stok Masuk"){
                    echo "<td style='font-size: 14px'>$jumlah_masuk</td>";
                }   
                else{
                    echo "<td style='font-size: 14px'>$jumlah_keluar</td>";
                }?>
              
                   

                  <?php echo  " </tr>";
                }

                  ?>

              </tbody>
            </table>
          </div>
          <br>
          <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
          <table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
        <thead>
            <tr>
            <th>Nama Pupuk</th>   
            <th>Total Masuk</th>
            <th>Total Keluar</th>
            <th>Sisa Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php

            function formatuang($angka){
            $uang = "Rp " . number_format($angka,2,',','.');
            return $uang;
            }

            ?>
            <?php while($data = mysqli_fetch_array($table2)){
            $nama_pupuk =$data['nama_pupuk'];
            $total_masuk = $data['total_masuk'];
            $total_keluar = $data['total_keluar'];
            $sisa_stok = $total_masuk - $total_keluar;
            echo "<tr>
            <td style='font-size: 14px' align = 'center'>$nama_pupuk</td>
            <td style='font-size: 14px' align = 'center'>$total_masuk</td>
            <td style='font-size: 14px' align = 'center'>$total_keluar</td>
            <td style='font-size: 14px' align = 'center'>$sisa_stok</td>
            </tr>";
        }
        ?>

        </tbody>
        </table>
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
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
      var table = $('#example').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'csv', 'pdf', 'colvis']
      });

      table.buttons().container()
        .appendTo('#example_wrapper .col-md-6:eq(0)');
    });
  </script>

</body>

</html>