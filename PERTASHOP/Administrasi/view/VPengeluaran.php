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
if ($jabatan_valid == 'Administrasi') {

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
  $table = mysqli_query($koneksi, "SELECT * FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal'");
  $table2 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran, lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal' GROUP BY b.lokasi");
  $table3 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal' GROUP BY a.sumber_dana");
  $table4 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana , lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal' AND lokasi = 'Bedilan' GROUP BY a.sumber_dana");
  $table5 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana , lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal' AND lokasi = 'Nusa Bakti' GROUP BY a.sumber_dana");
  $table6 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana , lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal' AND lokasi = 'Sumber Jaya' GROUP BY a.sumber_dana");
  $table6 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana , lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal' AND lokasi = 'Muara Dua' GROUP BY a.sumber_dana");
}
else{
  $table = mysqli_query($koneksi, "SELECT * FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $table2 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran, lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY b.lokasi");
  $table3 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY a.sumber_dana");
  $table4 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana , lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND lokasi = 'Bedilan' GROUP BY a.sumber_dana");
  $table5 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana , lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND lokasi = 'Nusa Bakti' GROUP BY a.sumber_dana");
  $table6 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana , lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND lokasi = 'Sumber Jaya' GROUP BY a.sumber_dana");
  $table7 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran, sumber_dana , lokasi FROM pengeluaran  a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND lokasi = 'Muara Dua' GROUP BY a.sumber_dana");
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

  <title>Pengeluaran</title>
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
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsAdministrasi">
            <div class="sidebar-brand-icon rotate-n-15">

          </div>
          <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/logo balsri.png" ></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active" >
          <a class="nav-link" href="DsAdministrasi">
              <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
              <span style="font-size: 16px;" >Dashboard</span></a>
          </li>

          <!-- Divider -->
          <hr class="sidebar-divider">

          <!-- Heading -->
          <div class="sidebar-heading" style="font-size: 15px; color:white;">
              ADMIN PERTASHOP
          </div>

          <!-- Nav Item - Pages Collapse Menu -->
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            15  aria-expanded="true" aria-controls="collapseTwo">
              <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
              <span style="font-size: 16px; color:white;" >Transaksi</span>
          </a>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header" style="font-size: 15px;">Menu Transaksi</h6>
                  <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Penjualan Pertamax</a>
                  <a class="collapse-item" style="font-size: 15px;" href="VPenjualanDex">Penjualan Dexlite</a>
                  <a class="collapse-item" style="font-size: 15px;" href="VPembelian">Pembelian</a>
                  <a class="collapse-item" style="font-size: 15px;" href="VPengeluaran">Pengeluaran</a>
                  <a class="collapse-item" style="font-size: 15px;" href="VSetoran">Setoran</a>
                  <a class="collapse-item" style="font-size: 15px;" href="VCorPertamax">Cor Pertamax</a>
                  <a class="collapse-item" style="font-size: 15px;" href="VCorDexlite">Cor Dexlite</a>                   
              </div>
          </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
          aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-gas-pump" style="font-size: 17px; color:white;"></i>
          <span style="font-size: 15px; color:white;">SDM</span>
      </a>
      <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
      data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
              <a class="collapse-item" style="font-size: 15px;" href="VAkunKaryawan">Akun Karyawan</a>
              <a class="collapse-item" style="font-size: 15px;" href="VPertashop">Lokasi Pertashop</a>                  
              <a class="collapse-item" style="font-size: 15px;" href="VAbsensi">Absensi</a>                   
              <a class="collapse-item" style="font-size: 15px;" href="VDriver">Driver</a>
              <a class="collapse-item" style="font-size: 15px;" href="VKendaraan">Kendaraan</a>
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
      <?php echo "<a href='VPengeluaranPul2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Pengeluaran</h5></a>"; ?>

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
    <?php  echo "<form  method='POST' action='VPengeluaran' style='margin-bottom: 15px;'>" ?>
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
    <div align="right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Catat Pengeluaran </button> <br> <br>
    </div>
    
     <!-- Form Modal  -->
    <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role ="document">
       <div class="modal-content"> 
        <div class="modal-header">
          <h5 class="modal-title"> Form Pengeluaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> 

        <!-- Form Input Data -->
        <div class="modal-body" align="left">
          <?php  echo "<form action='../proses/proses_pengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

          <div class="row">
            <div class="col-md-6">

              <label>Tanggal</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal" name="tanggal" required="">
             </div>
   

          </div>


          <div class="col-md-6">
           <label>Lokasi</label>
           <select id="lokasi" name="lokasi" class="form-control ">
            <?php
            include 'koneksi.php';
            $result = mysqli_query($koneksi, "SELECT * FROM pertashop");   

            while ($data2 = mysqli_fetch_array($result)){
              $nama_driver = $data2['lokasi'];


              echo "<option> $nama_driver </option> ";
              
            }
            ?>
          </select>
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
             <option>Gaji Karyawan</option>
             <option>Transport & Perjalanan Dinas</option>
             <option>Biaya Konsumsi</option>
          </select>
        </div>          
        <div class="col-md-6">
          <label>Sumber Dana</label>
          <select id="sumber_dana" name="sumber_dana" class="form-control">
            <option>Uang Penjualan</option>
            <option>Uang Jalan Balsri</option>
            <option>Uang Pertashop</option>
            <option>Uang Serli</option>
            <option>Uang Risa</option>
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
<div style="overflow-x: auto" align = 'center'>
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Kode Perta</th>
      <th>Lokasi</th>
      <th>Akun</th>
      <th>Sumber Dana</th>
      <th>Keterangan</th>
      <th>Pengeluaran</th>
      <th>Total</th>
      <th>file</th>
      <th>Aksi</th>
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
     $kode_perta =$data['kode_perta'];
     $lokasi =$data['lokasi'];
     $nama_akun = $data['nama_akun'];
     $sumber_dana = $data['sumber_dana'];
     $jumlah = $data['jumlah'];
     $keterangan = $data['keterangan'];
     $file_bukti = $data['file_bukti'];

     $total = $total + $jumlah;
     $urut = $urut + 1;


     echo "<tr>
     <td style='font-size: 14px'>$urut</td>
     <td style='font-size: 14px'>$tanggal</td>
     <td style='font-size: 14px'>$kode_perta</td>
     <td style='font-size: 14px'>$lokasi</td>
     <td style='font-size: 14px'>$nama_akun</td>
     <td style='font-size: 14px'>$sumber_dana</td>
     <td style='font-size: 14px'>$keterangan</td>
     <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
     <td style='font-size: 14px'>"?>  <?= formatuang($total); ?> <?php echo "</td>
     <td style='font-size: 14px'>"; ?> <a download="/PERTASHOP/Administrasi/file_administrasi/<?= $file_bukti ?>" href="/PERTASHOP/Administrasi/file_administrasi/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
     "; ?>
     <?php echo "<td style='font-size: 12px'>"; ?>

       <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_transaksi']; ?>">Edit</button>

        <!-- Form EDIT DATA -->

        <div class="modal fade" id="formedit<?php echo $data['no_transaksi']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
          <div class="modal-dialog" role ="document">
            <div class="modal-content"> 
              <div class="modal-header">Form Edit Pengeluaran </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                  <span aria-hidden="true"> &times; </span>
                </button>
              </div>


              <!-- Form Edit Data -->
              <div class="modal-body">
                <form action="../proses/edit_pengeluaran.php" enctype="multipart/form-data" method="POST">

                  <div class="row">
            <div class="col-md-6">

              <label>Tanggal</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal" name="tanggal"  value="<?php echo $tanggal;?>" required="">
             </div>
   

          </div>
          <div class="col-md-6">
          <label>Akun</label>
           <label>Lokasi</label>

                 <select id="lokasi" name="lokasi" class="form-control ">
                   <?php
                   $dataSelect = $data['lokasi']; 
                   include 'koneksi.php';
                   $result = mysqli_query($koneksi, "SELECT * FROM pertashop");   

                   while ($data2 = mysqli_fetch_array($result)){
                    $nama_driver = $data2['lokasi'];

                    echo "<option" ?> <?php echo ($dataSelect == $nama_driver) ? "selected" : "" ?>> <?php echo $nama_driver; ?> <?php echo "</option>" ;

                  }
                  ?>
                </select>   
          </div>
        </div>


        <div class="row">
          

        <div class="col-md-6">

          <label>Akun</label>
          <select id="akun" name="akun" class="form-control">
            <?php $dataSelect = $data['nama_akun']; ?>
            <option <?php echo ($dataSelect == 'Biaya Kantor') ? "selected": "" ?> >Biaya Kantor</option>
            <option <?php echo ($dataSelect == 'Listrik & Telepon') ? "selected": "" ?> >Listrik & Telepon</option>
            <option <?php echo ($dataSelect == 'Alat Tulis Kantor') ? "selected": "" ?> >Alat Tulis Kantor</option>
             <option <?php echo ($dataSelect == 'Biaya Sewa') ? "selected": "" ?> >Biaya Sewa</option>
             <option <?php echo ($dataSelect == 'Gaji Karyawan') ? "selected": "" ?> >Gaji Karyawan</option>
             <option <?php echo ($dataSelect == 'Transport & Perjalanan Dinas') ? "selected": "" ?> >Transport & Perjalanan Dinas</option>
             <option <?php echo ($dataSelect == 'Biaya Konsumsi') ? "selected": "" ?> >Biaya Konsumsi</option>

          </select>

        </div>       
        <div class="col-md-6">

          <label>Sumber Dana</label>
          <select id="sumber_dana" name="sumber_dana" class="form-control">
            <?php $dataSelect = $data['sumber_dana']; ?>
            <option <?php echo ($dataSelect == 'Uang Penjualan') ? "selected": "" ?> >Uang Penjualan</option>
            <option <?php echo ($dataSelect == 'Uang Jalan Balsri') ? "selected": "" ?> >Uang Jalan Balsri</option>
            <option <?php echo ($dataSelect == 'Uang Pertashop') ? "selected": "" ?> >Uang Pertashop</option>
            <option <?php echo ($dataSelect == 'Uang Serli') ? "selected": "" ?> >Uang Serli</option>

          </select>

        </div>         

      </div>

      <br>

     

      <div class="row">
        <div class="col-md-6">
          <label>Jumlah</label>
          <input class="form-control form-control-sm" type="number" id="jumlah" name="jumlah"  value="<?php echo $jumlah;?>"  required="">
        </div>    
        <div class="col-md-6">
        </div>         
      </div>

      <div>
     <label>Keterangan</label>
     <div class="form-group">
       <textarea id = "keterangan" name="keterangan" style="width: 300px;"><?php echo $keterangan;?></textarea>
     </div>
   </div>

              <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
              <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir;?>">
               <input type="hidden" name="no_transaksi" value="<?php echo $no_laporan;?>">
  
    <br>



  <div>
    <label>Upload File</label> 
    <input type="file" name="file"> 
  </div> 
                 

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"> Ubah </button>
                    <button type="reset" class="btn btn-danger"> RESET</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>




      <button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_transaksi']; ?>" data-toggle='tooltip' title='Hapus Transaksi'>Hapus</button>

      <div class="modal fade" id="PopUpHapus<?php echo $data['no_transaksi']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
       <div class="modal-dialog" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h4 class="modal-title"> <b> Hapus </b> </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>


          <div class="modal-body">
            <form action="../proses/hapus_pengeluaran" method="POST">
              <input type="hidden" name="no_transaksi" value="<?php echo $no_laporan; ?>">
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

    <?php echo  " </td> </tr>";
  }

?>

</tbody>
</table>
</div>


<br>
<br>
<h5 align="center" >Total Pengeluaran</h5>
<!-- Tabel -->    
<table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Lokasi</th>
      <th>Total Pengeluaran</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    $total_seluruh = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table2)){
      $lokasi = $data['lokasi'];
      $total_pengeluaran =$data['total_pengeluaran'];
      $total_seluruh = $total_seluruh + $total_pengeluaran;

      echo "<tr>
      <td style='font-size: 14px' >$lokasi</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($total_pengeluaran); ?> <?php echo "</td>

      </tr>";
}
?>
      <td style='font-size: 14px; ' ><strong>TOTAL</strong></td>  
      <td style='font-size: 14px'> <strong> <?= formatuang($total_seluruh); ?></strong> </td>

      </tr>
</tbody>
</table>


<br>
<br>
<h5 align="center" >Total Pengeluaran Berdasarkan Sumber</h5>
<!-- Tabel -->    
<table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Sumber Dana</th>
      <th>Total Pengeluaran</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    $total_seluruh = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table3)){
      $sumber_dana = $data['sumber_dana'];
      $total_pengeluaran =$data['total_pengeluaran'];
      $total_seluruh = $total_seluruh + $total_pengeluaran;

      echo "<tr>
      <td style='font-size: 14px' >$sumber_dana</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($total_pengeluaran); ?> <?php echo "</td>

      </tr>";
}
?>
<td style='font-size: 14px; ' ><strong>TOTAL</strong></td>  
      <td style='font-size: 14px'> <strong> <?= formatuang($total_seluruh); ?></strong> </td>

      </tr>
</tbody>
</table>

<br>
<br>
<h5 align="center" >Total Pengeluaran Berdasarkan Sumber (Bedilan)</h5>
<!-- Tabel -->    
<table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Sumber Dana</th>
      <th>Total Pengeluaran</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    $total_seluruh = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table4)){
      $sumber_dana = $data['sumber_dana'];
      $total_pengeluaran =$data['total_pengeluaran'];
      $total_seluruh = $total_seluruh + $total_pengeluaran;

      echo "<tr>
      <td style='font-size: 14px' >$sumber_dana</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($total_pengeluaran); ?> <?php echo "</td>

      </tr>";
}
?>
<td style='font-size: 14px; ' ><strong>TOTAL</strong></td>  
      <td style='font-size: 14px'> <strong> <?= formatuang($total_seluruh); ?></strong> </td>

      </tr>
</tbody>
</table>

<br>
<br>
<h5 align="center" >Total Pengeluaran Berdasarkan Sumber (Nusa Bakti)</h5>
<!-- Tabel -->    
<table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Sumber Dana</th>
      <th>Total Pengeluaran</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    $total_seluruh = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table5)){
      $sumber_dana = $data['sumber_dana'];
      $total_pengeluaran =$data['total_pengeluaran'];
      $total_seluruh = $total_seluruh + $total_pengeluaran;

      echo "<tr>
      <td style='font-size: 14px' >$sumber_dana</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($total_pengeluaran); ?> <?php echo "</td>

      </tr>";
}
?>
<td style='font-size: 14px; ' ><strong>TOTAL</strong></td>  
      <td style='font-size: 14px'> <strong> <?= formatuang($total_seluruh); ?></strong> </td>

      </tr>
</tbody>
</table>


<br>
<br>
<h5 align="center" >Total Pengeluaran Berdasarkan Sumber (Sumber Jaya)</h5>
<!-- Tabel -->    
<table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Sumber Dana</th>
      <th>Total Pengeluaran</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    $total_seluruh = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table6)){
      $sumber_dana = $data['sumber_dana'];
      $total_pengeluaran =$data['total_pengeluaran'];
      $total_seluruh = $total_seluruh + $total_pengeluaran;

      echo "<tr>
      <td style='font-size: 14px' >$sumber_dana</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($total_pengeluaran); ?> <?php echo "</td>

      </tr>";
}
?>
<td style='font-size: 14px; ' ><strong>TOTAL</strong></td>  
      <td style='font-size: 14px'> <strong> <?= formatuang($total_seluruh); ?></strong> </td>

      </tr>
</tbody>
</table>

<br>
<br>
<h5 align="center" >Total Pengeluaran Berdasarkan Sumber (Muara Dua)</h5>
<!-- Tabel -->    
<table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Sumber Dana</th>
      <th>Total Pengeluaran</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    $total_seluruh = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table7)){
      $sumber_dana = $data['sumber_dana'];
      $total_pengeluaran =$data['total_pengeluaran'];
      $total_seluruh = $total_seluruh + $total_pengeluaran;

      echo "<tr>
      <td style='font-size: 14px' >$sumber_dana</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($total_pengeluaran); ?> <?php echo "</td>

      </tr>";
}
?>
<td style='font-size: 14px; ' ><strong>TOTAL</strong></td>  
      <td style='font-size: 14px'> <strong> <?= formatuang($total_seluruh); ?></strong> </td>

      </tr>
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