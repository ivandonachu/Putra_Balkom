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
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Manager') {

}

else{  header("Location: logout.php");
exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1 '");
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
if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksi, "SELECT * FROM pengeluaran_pul_p WHERE tanggal = '$tanggal_awal'");
  $table2 = mysqli_query($koneksi, "SELECT nama_akun , SUM(jumlah) AS pengeluaran_pul_p FROM pengeluaran_pul WHERE tanggal = '$tanggal_awal' GROUP BY nama_akun");
}
else{
  $table = mysqli_query($koneksi, "SELECT * FROM pengeluaran_pul_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $table2 = mysqli_query($koneksi, "SELECT nama_akun , SUM(jumlah) AS pengeluaran_pul_p FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY nama_akun");
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

  <title>Pengeluaran PUL</title>
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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsManager">
     <div class="sidebar-brand-icon rotate-n-15">

     </div>
     <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
 </a>

 <!-- Divider -->
     <hr class="sidebar-divider">
     <!-- Heading -->
     <div class="sidebar-heading" style="font-size: 15px; color:white;">
          Menu PT BALSRI
     </div>
 <!-- Nav Item - Pages Collapse Menu -->
 <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
       15  aria-expanded="true" aria-controls="collapseOne">
         <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
         <span style="font-size: 15px; color:white;" >Tagihan</span>
     </a>
     <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
         <div class="bg-white py-2 collapse-inner rounded">
             <h6 class="collapse-header" style="font-size: 15px;">Menu Tagihan</h6>
             <a class="collapse-item" style="font-size: 15px;" href="VTagihan">Tagihan Lampung</a>
             <a class="collapse-item" style="font-size: 15px;" href="VTagihanL8">Tagihan Lampung 8KL</a>
             <a class="collapse-item" style="font-size: 15px;" href="VTagihanP">Tagihan Pelmbang</a>
             <a class="collapse-item" style="font-size: 15px;" href="VTagihanBr">Tagihan Baturaja</a>
             <a class="collapse-item" style="font-size: 15px;" href="VTagihanBl">Tagihan Belitung</a>
             <a class="collapse-item" style="font-size: 15px;" href="VLrGlobal">Laba Rugi Global</a>
             <a class="collapse-item" style="font-size: 15px;" href="VLabaRugi">Laba Rugi Lampung</a>
             <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiP">Laba Rugi Palembang</a>
             <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBr">Laba Rugi Baturaja</a>
             <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBl">Laba Rugi Belitung</a>
             <a class="collapse-item" style="font-size: 15px;" href="VMasterTarif">Master Tarif LMG</a>
             <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifL8">Master Tarif LMG 8KL</a>
             <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifP">Master Tarif PLG</a>
             <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBr">Master Tarif BTA</a>
             <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBl">Master Tarif BL</a>
         </div>
     </div>
 </li>
 
     <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
       15  aria-expanded="true" aria-controls="collapseTwo">
         <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
         <span style="font-size: 15px; color:white;" >Pengiriman</span>
     </a>
     <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
         <div class="bg-white py-2 collapse-inner rounded">
             <h6 class="collapse-header" style="font-size: 15px;">Menu Pengiriman</h6>
             <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Pengiriman LMG</a>
             <a class="collapse-item" style="font-size: 15px;" href="VPengirimanL8">Pengiriman LMG 8KL</a>
             <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaP">Pengiriman PLG</a>
             <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaBr">Pengiriman BTA</a>
             <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaBl">Pengiriman BL</a>
             <a class="collapse-item" style="font-size: 15px;" href="VRitase">Ritase LMG</a>
             <a class="collapse-item" style="font-size: 15px;" href="VRitaseL8">Ritase LMG 8KL</a>
             <a class="collapse-item" style="font-size: 15px;" href="VRitaseP">Ritase PLG</a>
             <a class="collapse-item" style="font-size: 15px;" href="VRitaseBr">Ritase BTA</a>
             <a class="collapse-item" style="font-size: 15px;" href="VRitaseBl">Ritase BL</a>
             <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuh">Jarak Tempuh LMG</a>
             <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhL8">Jarak Tempuh LMG 8KL</a>
             <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhP">Jarak Tempuh PLG</a>
             <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBr">Jarak Tempuh BTA</a> 
             <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBl">Jarak Tempuh BL</a> 
             
         </div>
     </div>
 </li>
  <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo22"
       15  aria-expanded="true" aria-controls="collapseTwo22">
         <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
         <span style="font-size: 15px; color:white;" >Pengeluaran</span>
     </a>
     <div id="collapseTwo22" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
         <div class="bg-white py-2 collapse-inner rounded">
             <h6 class="collapse-header" style="font-size: 15px;">Menu Pengeluaran</h6>
             <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikan">Catat Perbaikan LMG</a>
             <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanP">Catat Perbaikan PLG</a>
             <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanBr">Catat Perbaikan BTA</a>
             <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanBl">Catat Perbaikan BL</a>
             <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPul">Pengeluaran Pul LMG</a>
             <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulP">Pengeluaran Pul PLG</a>
             <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBr">Pengeluaran Pul BTA</a>
             <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBl">Pengeluaran Pul BL</a>
             <a class="collapse-item" style="font-size: 15px;" href="VGaji">Gaji LMG</a>
             <a class="collapse-item" style="font-size: 15px;" href="VGajiL8">Gaji LMG 8KL</a>
             <a class="collapse-item" style="font-size: 15px;" href="VGajiP">Gaji PLG</a>
             <a class="collapse-item" style="font-size: 15px;" href="VGajiBr">Gaji BTA</a>
             <a class="collapse-item" style="font-size: 15px;" href="VGajiBl">Gaji BL</a>
             <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Gaji Karyawan</a>
         </div>
     </div>
 </li>
  <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo13"
       15  aria-expanded="true" aria-controls="collapseTwo1">
         <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
         <span style="font-size: 15px; color:white;" >SDM</span>
     </a>
     <div id="collapseTwo13" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
         <div class="bg-white py-2 collapse-inner rounded">
             <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
             <a class="collapse-item" style="font-size: 15px;" href="VAMT">AMT</a>
             <a class="collapse-item" style="font-size: 15px;" href="VMT">MT</a>
         </div>
     </div>
 </li>
   <!-- Nav Item - Pages Collapse Menu -->
   <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOnex"
       15  aria-expanded="true" aria-controls="collapseOne">
         <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
         <span style="font-size: 15px; color:white;" >Data Backup</span>
     </a>
     <div id="collapseOnex" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
         <div class="bg-white py-2 collapse-inner rounded">
             <h6 class="collapse-header" style="font-size: 15px;">Menu Tagihan</h6>
             <a class="collapse-item" style="font-size: 15px;" href="VLuangOPx">Lap uang Oprasional</a>
             <a class="collapse-item" style="font-size: 15px;" href="VTagihanx">Tagihan Lampung</a>
             <a class="collapse-item" style="font-size: 15px;" href="VTagihanPx">Tagihan Pelmbang</a>
             <a class="collapse-item" style="font-size: 15px;" href="VTagihanBrx">Tagihan Baturaja</a>
             <a class="collapse-item" style="font-size: 15px;" href="VLrGlobalx">Laba Rugi Global</a>
             <a class="collapse-item" style="font-size: 15px;" href="VLabaRugix">Laba Rugi Lampung</a>
             <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiPx">Laba Rugi Palembang</a>
             <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBrx">Laba Rugi Baturaja</a>
             <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifx">Master Tarif LMG</a>
             <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifPx">Master Tarif PLG</a>
             <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBrx">Master Tarif BTA</a>
         </div>
     </div>
 </li>
 <?php if($nama == "Tanry Yanoda Donachu"){ ?>
   
 <!-- Nav Item - Pages Collapse Menu -->
 <li class="nav-item">
                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse22"
               15  aria-expanded="true" aria-controls="collapse22">
                 <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                 <span style="font-size: 15px; color:white;" >Pertashop</span>
             </a>
             <div id="collapse22" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <h6 class="collapse-header" style="font-size: 15px;">Pertashop</h6>
                     <a class="collapse-item" style="font-size: 15px;" href="VPembelian">Pembelian</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VLPenjualan">Penjualan Pertamax</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VLPenjualanDex">Penjualan Dex</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiPs">Laba Rugi</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VGrafikPenjualan">Grafik Penjualan</a>
                     <a class="collapse-item" style="font-size: 15px;" href="Setoran">Setoran</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VAbsensi">Absensi</a>
                 </div>
             </div>
         </li>
   

 <?php } ?>


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
      <?php echo "<a href='VPengeluaranPul2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Pengeluaran PUL PLG</h5></a>"; ?>

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
    <?php  echo "<form  method='POST' action='VPengeluaranPulP2' style='margin-bottom: 15px;'>" ?>
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
   <div class="col-md-6">
    <!-- Button Input Data Bayar -->

    
     <!-- Form Modal  -->
    <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role ="document">
       <div class="modal-content"> 
        <div class="modal-header">
          <h5 class="modal-title"> Form Penggunaan Kas Kecil </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> 

        <!-- Form Input Data -->
        <div class="modal-body" align="left">
          <?php  echo "<form action='../proses/proses_pengeluaranP?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

          <div class="row">
            <div class="col-md-6">

              <label>Tanggal</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal" name="tanggal" required="">
             </div>
   

          </div>
          <div class="col-md-6">
          </div>
        </div>


        <div class="row">
          

        <div class="col-md-6">
          <label>Akun</label>
          <select id="akun" name="akun" class="form-control">
            <option>Biaya Kantor</option>
            <option>Listrik & Telepon</option>>
            <option>Alat Tulis Kantor</option>
             <option>Biaya Sewa</option>
          </select>
        </div>            

      </div>

      <br>

     

      <div class="row">
        <div class="col-md-6">
          <label>Jumlah</label>
          <input class="form-control form-control-sm" type="number" id="jumlah" name="jumlah"  required="">
        </div>    
        <div class="col-md-6">
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
        <button type="submit" class="btn btn-primary"> BAYAR</button>
        <button type="reset" class="btn btn-danger"> RESET</button>
      </div>
    </form>
  </div>
</div>
</div>
</div>
</div>
</div>






<!-- Tabel -->    
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
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
     $nama_akun = $data['nama_akun'];
     $jumlah = $data['jumlah'];
     $keterangan = $data['keterangan'];
     $file_bukti = $data['file_bukti'];

     $total = $total + $jumlah;
     $urut = $urut + 1;


     echo "<tr>
     <td style='font-size: 14px'>$urut</td>
     <td style='font-size: 14px'>$tanggal</td>
     <td style='font-size: 14px'>$nama_akun</td>
     <td style='font-size: 14px'>$keterangan</td>
     <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
     <td style='font-size: 14px'>"?>  <?= formatuang($total); ?> <?php echo "</td>
     <td style='font-size: 14px'>"; ?> <a download="/PT.BALSRI/Administrasi/file_administrasi/<?= $file_bukti ?>" href="/PT.BALSRI/Administrasi/file_administrasi/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
     "; ?>

    <?php echo  "  </tr>";
  }

?>

</tbody>
</table>
</div>
<br>
<hr>
<br>
<div style="margin-right: 100px; margin-left: 100px;">
<h6 align="Center">Total Per Akun</h6>
<div style="overflow-x: auto" align = 'center'>
<table  class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
      <th>Nama Akun</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php while($data = mysqli_fetch_array($table2)){
      $nama_akun =$data['nama_akun'];
      $total_pengeluaran = $data['total_pengeluaran'];


      echo "<tr>
      <td style='font-size: 14px'>$nama_akun</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($total_pengeluaran); ?> <?php echo "</td>
     
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