
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
if ($jabatan_valid == 'Admin Seberuk Utama') {

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
} elseif (isset($_POST['tanggal1'])) {
  $tanggal_awal = $_POST['tanggal1'];
  $tanggal_akhir = $_POST['tanggal2'];
}
else{
    $tanggal_awal = date('Y-m-1');
  $tanggal_akhir = date('Y-m-31');
  }

if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksi, "SELECT * FROM rekap_gaji_penyadap_seberuk WHERE tanggal = '$tanggal_awal'");

} else {
  $table = mysqli_query($koneksi, "SELECT * FROM rekap_gaji_penyadap_seberuk WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");

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

  <title>Rekap Gaji Penyadap Kebun Seberuk</title>

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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsAdminSeberukUtama">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active" >
    <a class="nav-link" href="DsAdminSeberukUtama">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu Administrasi
    </div>
     <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
      15  aria-expanded="true" aria-controls="collapseOne">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Pendapatan</span>
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
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-file-invoice-dollar" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Pengeluaran</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Pengiriman</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VKasBesar">Kas Besar</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKasKecil">Kas Kecil</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListGaji">List Gaji Karyawam</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGaji">Rekap Gaji Karyawan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiPenyadap">List Gaji Penyadap</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiPenyadap">Rekap Gaji Penyadap</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiBuhar">List Gaji Buruh Harian</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiBuhar">Rekap Gaji Buruh Harian</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranBuahSeberuk">Pengeluaran Buah</a>
        </div>
    </div>
</li>
 <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo22"
      15  aria-expanded="true" aria-controls="collapseTwo22">
        <i class="fas fa-users" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Absensi</span>
    </a>
    <div id="collapseTwo22" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Absensi</h6>
            
            <a class="collapse-item" style="font-size: 15px;" href="VKegiatanHarian">Kegiatan Harian</a>
            <a class="collapse-item" style="font-size: 15px;" href="VAbsensiBuruh">Absensi Buruh</a>
            <a class="collapse-item" style="font-size: 15px;" href="VAbsenFoto">Absensi Foto</a>
        </div>
    </div>
</li>
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
      15  aria-expanded="true" aria-controls="collapseTwo1">
        <i class="fas fa-car" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >SDM</span>
    </a>
    <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VListBuruh">List Buruh</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListBuruhHarian">List Buruh Harian</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListKendaraan">List Kendaraan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListAsetSeberuk">List Aset Seberuk</a>
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
      <?php echo "<a href='VRekapGaji'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Rekap Gaji Penyadap Kebun Seberuk</h5></a>"; ?>
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

  <?php echo "<form  method='POST' action='VRekapGajiPenyadap' style='margin-bottom: 15px;'>" ?>
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
    <div class="col-md-2">
      <!-- Button Input Data Bayar -->
      <div align="right">
      <?php echo "<a href='VPrintSlipGajiPenyadap?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' target='_blank'><button style='color:black;
                                             '  type='submit' class=' btn btn-secondary' >  <i class='fa-solid fa-print'></i> Print Slip Gaji</button></a>";
                                                
                                             ?>
      </div>
</div>
    <div class="col-md-2">
      <!-- Button Input Data Bayar -->
      <div align="right">
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#inputx"> <i class="fas fa-trash-alt mr-2"></i>HAPUS REKAP GAJI</button>
      </div>
      <!-- Form Modal  -->
      <div class="modal fade bd-example-modal-lg" id="inputx" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h5 class="modal-title">Persetujuan Hapus Rekap Gaji</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div> 

          <!-- Form Input Data -->
          <div class="modal-body" align="left">
            <?php  echo "<form action='../proses/hapus_seluruh_rekap_gaji_penyadap_seberuk?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

            <br>

            <div class="row">
              <div class="col-md-6">
                 <label>Tanggal</label>
                 <input class="form-control form-control-sm" type="date" id="tanggal" name="tanggal" required="">
              </div>
              <div class="col-md-6">
             
              </div>
           </div>

           <br>
           
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger">Hapus</button>

      </div>
    </form>
  </div>
</div>
</div>
</div>
</div>


    <div class="col-md-2">
      <!-- Button Input Data Bayar -->
      <div align="right">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i>Tambah Rekap Gaji</button> <br> <br>
      </div>
      <!-- Form Modal  -->
      <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h5 class="modal-title"> Form Gaji Penyadap</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div> 

          <!-- Form Input Data -->
          <div class="modal-body" align="left">
            <?php  echo "<form action='../proses/proses_tambah_rekap_gaji_penyadap_seberuk?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

            <br>

            <div class="row">
              <div class="col-md-3">
                 <label>Tanggal</label>
                 <input class="form-control form-control-sm" type="date" id="tanggal" name="tanggal" required="">
              </div>
              <div class="col-md-3">
               <label>Nama Penyadap</label>
               <input class="form-control form-control-sm" type="text" name="nama_penyadap" required="">
             </div>
             <div class="col-md-4">
               <label>Hasil Kotor</label>
               <input class="form-control form-control-sm" type="text" name="hasil_kotor" required="" >
             </div>
             <div class="col-md-4">
               <label>Pembagi</label>
               <input class="form-control form-control-sm" type="text" name="pembagi" required="" >
             </div>
             <div class="col-md-4">
               <label>Harga Gaji</label>
               <input class="form-control form-control-sm" type="number" name="harga_gaji" required="">
             </div>
           </div>



           <br>

           
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary"> CATAT</button>
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
<div style="overflow-x: auto" align = 'center';>
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>  
          <th style="font-size: 14px" scope="col">No</th>
          <th style="font-size: 14px" scope="col">Tanggal</th>
          <th style="font-size: 14px" scope="col">Nama Penyadap</th>
          <th style="font-size: 14px" scope="col">Hasil Kotor</th>
          <th style="font-size: 14px" scope="col">Pembagi</th>
          <th style="font-size: 14px" scope="col">Hasil Bersih</th>
          <th style="font-size: 14px" scope="col">Harga Gaji / Kg </th>
          <th style="font-size: 14px" scope="col">Total Gaji</th>
          <th style="font-size: 14px" scope="col"></th>
        </tr>
      </thead>
      <tbody>
      <?php
      $no_urut = 0;
      $total_gaji_seluruh =0;
      $total_kg_kotor =0;
      $total_kg_bersih =0;
          function formatuang($angka)
          {
            $uang = "Rp " . number_format($angka, 0, ',', '.');
            return $uang;
          }
      ?>

        <?php while($data2 = mysqli_fetch_array($table)){
          $no_riwayat = $data2['no_riwayat'];
          $tanggal = $data2['tanggal'];
          $nama_penyadap =$data2['nama_penyadap'];
          $hasil_kotor = $data2['hasil_kotor'];
          $pembagi = $data2['pembagi'];
          $hasil_bersih = $data2['hasil_bersih'];
          $harga_gaji = $data2['harga_gaji'];
          $total_gaji = $data2['total_gaji'];
          $total_gaji_seluruh = $total_gaji_seluruh + $total_gaji;
          $total_kg_kotor = $total_kg_kotor + $hasil_kotor;
          $total_kg_bersih = $total_kg_bersih + $hasil_bersih;
          $no_urut = $no_urut + 1 ;

          echo "<tr>
          <td style='font-size: 14px'>$no_urut</td>
          <td style='font-size: 14px'>$tanggal</td>
          <td style='font-size: 14px'>$nama_penyadap</td>
          <td style='font-size: 14px'>$hasil_kotor Kg</td>
          <td style='font-size: 14px'>$pembagi</td>
          <td style='font-size: 14px'>$hasil_bersih Kg</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($harga_gaji); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?> <?= formatuang($total_gaji); ?> <?php echo "</td>
          <td style='font-size: 14px'>"; ?>

          <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data2['no_riwayat']; ?>">Edit</button>

          <!-- Form EDIT DATA -->

          <div class="modal fade bd-example-modal-lg" id="formedit<?php echo $data2['no_riwayat']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg" role ="document">
             <div class="modal-content"> 
              <div class="modal-header">
                <h5 class="modal-title"> Form Edit Gaji Penyadap </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                  <span aria-hidden="true"> &times; </span>
                </button>
              </div>

          <!-- Form Edit Data -->
          <div class="modal-body">
              <?php  echo "<form action='../proses/edit_rekap_gaji_penyadap_seberuk?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>
                
            <input type="hidden" name="no_riwayat" value="<?php echo $no_riwayat;?>"> 

            <div class="row">
              <div class="col-md-6">
                 <label>Tanggal</label>
                 <input class="form-control form-control-sm" type="date" name="tanggal" required="" value="<?php echo $tanggal;?>">
              </div>
              <div class="col-md-6">
               <label>Nama Penyadap</label>
               <input class="form-control form-control-sm" type="text" name="nama_penyadap" required="" value="<?php echo $nama_penyadap;?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-4">
               <label>Hasil Kotor</label>
               <input class="form-control form-control-sm" type="text" name="hasil_kotor" required="" value="<?php echo $hasil_kotor;?>">
             </div>
             <div class="col-md-4">
               <label>Pembagi</label>
               <input class="form-control form-control-sm" type="number" name="pembagi" required="" value="<?php echo $pembagi;?>">
             </div>
             <div class="col-md-4">
               <label>Hasil Bersih</label>
               <input class="form-control form-control-sm" type="number" name="hasil_bersih" required="" value="<?php echo $hasil_bersih;?>">
             </div>
             <div class="col-md-4">
               <label>Harga Gaji</label>
               <input class="form-control form-control-sm" type="number" name="harga_gaji" required="" value="<?php echo $harga_gaji;?>">
             </div>
             <div class="col-md-4">
               <label>Total Gaji</label>
               <input class="form-control form-control-sm" type="number" name="total_gaji" required="" value="<?php echo $total_gaji;?>">
             </div>
           </div>

           <br>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"> Ubah </button>
          <button type="reset" class="btn btn-danger"> RESET</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>

<!-- Button Hapus -->
<button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $no_riwayat;?>" data-toggle='tooltip' title='Hapus Data Dokumen'>Hapus</button>
<div class="modal fade" id="PopUpHapus<?php echo $no_riwayat; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
 <div class="modal-dialog" role ="document">
   <div class="modal-content"> 
    <div class="modal-header">
      <h4 class="modal-title"> <b> Hapus Rekap Gaji Penyadap </b> </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="close">
        <span aria-hidden="true"> &times; </span>
      </button>
    </div>

    <div class="modal-body">
  
      <?php  echo "<form action='../proses/hapus_rekap_gaji_penyadap_seberuk?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' method='POST'>";  ?>
        <input type="hidden" name="no_riwayat" value="<?php echo $no_riwayat;?>">
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
     


      <?php echo "</td> 
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
                      Total Gaji Seluruh</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_gaji_seluruh)  ?></div>
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
                      Total Kg Kotor</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_kg_kotor  ?> Kg</div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-scale-balanced fa-2x text-gray-300"></i>
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
                      Total Kg Bersih</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_kg_bersih ?> Kg</div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-scale-balanced fa-2x text-gray-300"></i>
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
      buttons: [  'excel' ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

</body>

</html>