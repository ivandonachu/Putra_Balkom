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
} elseif (isset($_POST['tanggal1'])) {
  $tanggal_awal = $_POST['tanggal1'];
  $tanggal_akhir = $_POST['tanggal2'];
}
else{
    $tanggal_awal = date('Y-m-1');
  $tanggal_akhir = date('Y-m-31');
  }

if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksicbm, "SELECT * FROM rekap_gaji_balsri WHERE tanggal = '$tanggal_awal'");

} else {
  $table = mysqli_query($koneksicbm, "SELECT * FROM rekap_gaji_balsri WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");

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

  <title>Rekap Gaji Karyawan Balsri</title>

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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsPTCBM.php">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="gambar/Logo CBM.png" ></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">


  <!-- Nav Item - Dashboard -->
<li class="nav-item active" >
    <a class="nav-link" href="DsPTCBM">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

     <!-- Divider -->
     <hr class="sidebar-divider">
                <!-- Heading -->
                <div class="sidebar-heading" style="font-size: 15px; color:white;">
                     Menu PT. CBM
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
                        <a class="collapse-item" style="font-size: 15px;" href="DsPTCBM">PT. CBM</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/CV.PBJ/view/DsCVPBJ">PT.PBJ</a>
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
                    <span style="font-size: 15px; color:white;" >Laporan Perusahan</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Laporan</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan1">Laporan Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLPenjualan1">Laporan Penjualan</a>
                        
                        <?php if($nama == 'Nyoman Edy Susanto'){
                        echo"<a class='collapse-item' style='font-size: 15px;' href='VLabaRugi'>Laba Rugi</a>";
                        } ?>
                        <a class="collapse-item" style="font-size: 15px;" href="VSaldoBaru">Laporan Saldo</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VBonKaryawan">Laporan BON </a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRincianSA">Alokasi SA </a>
                         <a class="collapse-item" style="font-size: 15px;" href="VUangPBJ">Uang PBJ</a>
                         <a class="collapse-item" style="font-size: 15px;" href="VKeberangkatan">Uang Jalan</a>
                         <a class="collapse-item" style="font-size: 15px;" href="VPengeluaran">Pengeluaran Kasir</a>
                         <a class="collapse-item" style="font-size: 15px;" href="VKasKecil">Kas Kecil</a>
                         <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Gaji Karyawan</a>
                         <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranWorkshop">Pengeluaran Workshop</a>
                    </div>
                </div>
            </li>
            
             <!-- Nav Item - Pages Collapse Menu -->
             <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2"
                  15  aria-expanded="true" aria-controls="collapseTwo2">
                    <i class="fas fa-file-alt" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Daftar SDM</span>
                </a>
                <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">SDM</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VAset">Aset</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VDokumen">Dokumen</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VSeluruhKaryawan">List Karyawan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VSuratKeluarMasuk">Surat Keluar Masuk</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VKontrakKerja">Kontrak Kerja</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VSuratIzin">Surat Izin</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo4"
                  15  aria-expanded="true" aria-controls="collapseTwo4">
                    <i class="fas fa-file-alt" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Rekap Gaji</span>
                </a>
                <div id="collapseTwo4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">SDM</h6>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiCBM">Rekap Gaji CBM</a>
                        <a class="collapse-item" style="font-size: 12pxx;" href="VRekapGajiDriverCBM">Rekap Gaji Driver CBM</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiDriverKebun">Rekap Gaji Driver Kebun</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiMES">Rekap Gaji MES</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiDriverMES">Rekap Gaji Driver MES</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiPBR">Rekap Gaji PBR</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiDriverPBR">Rekap Gaji Driver PBR</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiPBJ">Rekap Gaji PBJ</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiDriverPBJ">Rekap Gaji Driver PBJ</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiBalsri">Rekap Gaji Balsri</a>
                        <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiDriverBalsri">Rekap Gaji Driver Balsri</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo5"
                  15  aria-expanded="true" aria-controls="collapseTwo5">
                    <i class="fas fa-file-alt" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Pengeluaran</span>
                </a>
                <div id="collapseTwo5" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">SDM</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranCBM">Pengeluaran CBM</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranMES">Pengeluaran MES</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPBR">Pengeluaran PBR</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranKebun">Pengeluaran Kebun</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMocashCBM">Mocash CBM</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMocashMES">Mocash MES</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMocashPBR">Mocash PBR</a>
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
      <?php echo "<a href='VRekapGajiBalsri'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Rekap Gaji Karyawan Balsri</h5></a>"; ?>
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

  <h1></h1>
  <!-- Name Page -->
  <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">

  <?php echo "<form  method='POST' action='VRekapGajiBalsri' style='margin-bottom: 15px;'>" ?>
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
<div style="overflow-x: auto" align = 'center';>
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>  
          <th style="font-size: 14px" scope="col">No</th>
          <th style="font-size: 14px" scope="col">Tanggal</th>
          <th style="font-size: 14px" scope="col">Nama Karyawan</th>
          <th style="font-size: 14px" scope="col">Jabatan</th>
          <th style="font-size: 14px" scope="col">Gaji Pokok</th>
          <th style="font-size: 14px" scope="col">Tunjangan Jabatan</th>
          <th style="font-size: 14px" scope="col">Tunjangan Akomodasi</th>
          <th style="font-size: 14px" scope="col">Uang Makan / Bulan</th>
          <th style="font-size: 14px" scope="col">BPJS Ketenagakerjaan</th>
          <th style="font-size: 14px" scope="col">BPJS Kesehatan</th>
          <th style="font-size: 14px" scope="col">Lembur</th>
          <th style="font-size: 14px" scope="col">Premi Kehadiran</th>
          <th style="font-size: 14px" scope="col">Bonus 1</th>
          <th style="font-size: 14px" scope="col">Bonus 2</th>
          <th style="font-size: 14px" scope="col">Bonus 3</th>
          <th style="font-size: 14px" scope="col">Potongan Absen</th>
          <th style="font-size: 14px" scope="col">Angsuran Pinjaman</th>
          <th style="font-size: 14px" scope="col">Potongan Bon</th>
          <th style="font-size: 14px" scope="col">Total Gaji</th>
          <th style="font-size: 14px" scope="col">Total Gaji Diterima </th>
          <th style="font-size: 14px" scope="col">Keterangan </th>
        </tr>
      </thead>
      <tbody>
      <?php
      $no_urut = 0;
      $total_tf = 0;
      $total_cash = 0;
      $total_seluruh = 0;
          function formatuang($angka)
          {
            $uang = "Rp " . number_format($angka, 0, ',', '.');
            return $uang;
          }
      ?>

        <?php while($data2 = mysqli_fetch_array($table)){
          $no_riwayat = $data2['no_riwayat'];
          $tanggal = $data2['tanggal'];
          $nama_karyawan =$data2['nama_karyawan'];
          $jabatan = $data2['jabatan'];
          $gaji_pokok = $data2['gaji_pokok'];
          $tunjangan_jabatan = $data2['tunjangan_jabatan'];
          $tunjangan_akomodasi = $data2['tunjangan_akomodasi'];
          $uang_makan = $data2['uang_makan'];
          $bpjs_ketenagakerjaan = $data2['bpjs_ketenagakerjaan'];
          $bpjs_kesehatan = $data2['bpjs_kesehatan'];
          $lembur = $data2['lembur'];
          $premi_kehadiran = $data2['premi_kehadiran'];
          $bonus_1 = $data2['bonus_1'];
          $bonus_2 = $data2['bonus_2'];
          $bonus_3 = $data2['bonus_3'];
          $potongan_absen = $data2['potongan_absen'];
          $angsuran_pinjaman = $data2['angsuran_pinjaman'];
          $potongan_bon = $data2['potongan_bon'];
          $total_gaji = $data2['total_gaji'];
          $total_gaji_diterima = $data2['total_gaji_diterima'];
          $keterangan = $data2['keterangan'];
          $no_urut = $no_urut + 1 ;

          $total_seluruh = $total_seluruh + $total_gaji_diterima;
          if($keterangan == 'Transfer'){
            $total_tf = $total_tf + $total_gaji_diterima;
          }
          else if ($keterangan == 'Cash'){
            $total_cash = $total_cash + $total_gaji_diterima;

          }
          echo "<tr>
          <td style='font-size: 14px'>$no_urut</td>
          <td style='font-size: 14px'>$tanggal</td>
          <td style='font-size: 14px'>$nama_karyawan</td>
          <td style='font-size: 14px'>$jabatan</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($gaji_pokok); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($tunjangan_jabatan); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($tunjangan_akomodasi); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($uang_makan); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($bpjs_ketenagakerjaan); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($bpjs_kesehatan); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($lembur); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($premi_kehadiran); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($bonus_1); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($bonus_2); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($bonus_3); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($potongan_absen); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($angsuran_pinjaman); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($potongan_bon); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($total_gaji); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($total_gaji_diterima); ?> <?php echo "</td>
          <td style='font-size: 14px'>$keterangan</td>
     
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
        <div class="row" style="margin-right: 20px; margin-left: 20px;">
          <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                      Total Gaji Transfer</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_tf)  ?></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                      Total Gaji Cash</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_cash)  ?></div>
                  </div>
                  <div class="col-auto">
                    <i class=" fas fa-dollar-sign fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                      Total Seluruh Gaji</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_seluruh)  ?></div>
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
      lengthChange: true,
      buttons: [ 'copy', 'excel', 'csv', 'pdf', 'colvis' ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

</body>

</html>