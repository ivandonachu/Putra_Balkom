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
  $lokasi = $_GET['lokasi'];
 } 
 
 else if (isset($_POST['tanggal1'])) {
  $tanggal_awal = $_POST['tanggal1'];
  $tanggal_akhir = $_POST['tanggal2'];
  $lokasi = $_POST['lokasi'];
 } 
else{
  $tanggal_awal = date('Y-m-1');
$tanggal_akhir = date('Y-m-31');
$lokasi = 'Nusa Bakti';
}
if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksi,"SELECT * FROM pembelian a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta  WHERE tanggal ='$tanggal_awal' AND b.lokasi = '$lokasi' ");
   $table2 = mysqli_query($koneksi,"SELECT * FROM barang ");
}

else{
  $table = mysqli_query($koneksi,"SELECT * FROM pembelian a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND b.lokasi = '$lokasi'");
  $table2 = mysqli_query($koneksi,"SELECT * FROM barang ");
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

  <title>Pembelian</title>

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
      <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
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
       Menu Administrasi
     </div>

     <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
      15  aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
      <span style="font-size: 15px; color:white;" >SDM</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
        <a class="collapse-item" style="font-size: 15px;" href="VAkunKaryawan">Akun Karyawan</a>
        <a class="collapse-item" style="font-size: 15px;" href="VPertashop">Pertashop</a>
        <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Penjualan Pertamax</a>
                    <a class="collapse-item" style="font-size: 15px;" href="VPenjualanDex">Penjualan Dexlite</a>
        <a class="collapse-item" style="font-size: 15px;" href="VPembelian">Pembelian</a>
        <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Pengiriman</a>
        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaran">Pengeluaran</a>
        <a class="collapse-item" style="font-size: 15px;" href="VAbsensi">Absensi</a>
        <a class="collapse-item" style="font-size: 15px;" href="VSetoran">Setoran</a>
        <a class="collapse-item" style="font-size: 15px;" href="VCorPertamax">Cor Pertamax</a>
          <a class="collapse-item" style="font-size: 15px;" href="VCorDexlite">Cor Dexlite</a>
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
      <?php echo "<a href='VPembelian'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Pembelian Ps $lokasi</h5></a>"; ?>
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


 <?php  echo "<form  method='POST' action='VPembelian'>" ?>
  <div>
      <div align="left" style="margin-left: 20px;"> 
        <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1"> 
        <span>-</span>
        <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
        <select id="lokasi" name="lokasi"s>
            <?php
            include 'koneksi.php';
            $result = mysqli_query($koneksi, "SELECT * FROM pertashop");   

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

 <div class="row">
  <div class="col-md-10">

  </div>
  <div class="col-md-2">
    <!-- Button Input Data Bayar -->
    <div align="right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Catat Pembelian</button> <br> <br>
    </div>
    <!-- Form Modal  -->
    <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role ="document">
       <div class="modal-content"> 
        <div class="modal-header">
          <h5 class="modal-title"> Form Pencatatan Pembelian</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> 

        <!-- Form Input Data -->
        <div class="modal-body" align="left">
          <?php  echo "<form action='../proses/proses_pembelian?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

          <br>
          <div class="row">
            <div class="col-md-6">

              <label>Tanggal</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal" name="tanggal" required="">
             </div>      

           </div>
           
         </div>
         <br>

         <div class="row">

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
 

        <div class="col-md-6">
          <label>No SO</label>
          <input class="form-control form-control-sm" type="text" id="no_so" name="no_so" required="">
        </div> 
      </div>

      <br>

      <div class="row">

        <div class="col-md-6">
          <label>QTY</label>
          <select id="qty" name="qty" class="form-control">
            <option>1000</option>
            <option>2000</option>
            <option>3000</option>
            <option>4000</option>
            <option>5000</option>
            <option>6000</option>
            <option>7000</option>
            <option>8000</option>
          </select>
        </div>       
        
        <div class="col-md-6">
        <label>Nama Barang</label>
          <select id="nama_barang" name="nama_barang" class="form-control">
            <option>Pertamax</option>
            <option>Dexlite</option>
          </select>
          </div> 
        </div>   


      
      <div class="row">

                
        <div class="col-md-6">
          <label>Harga</label>
          <input class="form-control form-control-sm" type="float" id="harga" name="harga" required="">
        </div>   
        <div class="col-md-6">
          <label>Volume Tangki</label>
          <input class="form-control form-control-sm" type="float" id="volume_tangki" name="volume_tangki" required="">
        </div> 
        
      </div>

      <div class="row">

                
<div class="col-md-6">
  <label>Soding Sebelum Isi</label>
  <input class="form-control form-control-sm" type="float" id="sonding_awal" name="sonding_awal" required="">
</div>   
<div class="col-md-6">
  <label>Soding Setelah Isi</label>
  <input class="form-control form-control-sm" type="float" id="sonding_akhir" name="sonding_akhir" required="">
</div> 
</div>

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
<div style="overflow-x: auto" align = 'center'>
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th style="font-size: 11px" >No</th>
      <th style="font-size: 11px" >No SO</th>
      <th style="font-size: 11px" >Tanggal Pembelian</th>
      <th style="font-size: 11px" >Tanggal Bongkar</th>
      <th style="font-size: 11px" >Kode Pertashop</th>   
      <th style="font-size: 11px" >Lokasi</th>
      <th style="font-size: 11px" >Nama Barang</th>
      <th style="font-size: 11px" >QTY</th>
      <th style="font-size: 11px" >Harga</th>
      <th style="font-size: 11px" >Jumlah</th>
      <th style="font-size: 11px" >Volume Tanki</th>
      <th style="font-size: 11px" >Sonding Sebelum Isi</th>
      <th style="font-size: 11px" >Sonding Setelah Isi</th>
      <th style="font-size: 11px" >Selisih S1 & S2</th>
      <th style="font-size: 11px" >Losis</th>
      <th style="font-size: 11px" >Keterangan</th>
      <th style="font-size: 11px" >File</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $urut = 0;
    $selisih = 0;
    $losis = 0;
 

    $losis_nb_dex = 0;
    $losis_nb_max = 0;
    $losis_sj = 0 ;
    $losis_md =0;
    $losis_be = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>
    <?php while($data = mysqli_fetch_array($table)){
      $no_pembelian = $data['no_pembelian'];
      $no_so =$data['no_so'];
      $tanggal =$data['tanggal'];
      $tanggal_bongkar =$data['tanggal_bongkar'];
      $kode_perta =$data['kode_perta'];
      $nama_barang =$data['nama_barang'];
      $lokasi = $data['lokasi'];
      $volume_tangki = $data['volume_tangki'];
      $sonding_awal = $data['sonding_awal'];
      $sonding_akhir = $data['sonding_akhir'];
      $qty = $data['qty'];
      $harga = $data['harga'];
      $jumlah = $qty * $harga;
      $keterangan = $data['keterangan'];
      $file_bukti = $data['file_bukti'];
      $selisih = $sonding_akhir - $sonding_awal;
      $losis = $selisih - $qty; 
      
      $urut = $urut + 1;


      if($losis < 0){
        if($kode_perta == '2P.323.208'){
          if($nama_barang == 'Pertamax'){
            $losis_nb_dex = $losis_nb_dex + $losis;
          }
          else{
            $losis_nb_max = $losis_nb_max + $losis; 
           
          }
          
        }
        else if($kode_perta == 'bedilan'){
          $losis_be = $losis_be + $losis; 
         
        }
        else if($kode_perta == 'muaradua'){
          $losis_md = $losis_md + $losis; 
         
        }
        else if($kode_perta == 'sumberjaya'){
          $losis_sj = $losis_sj + $losis; 
          
        }
      }

     

      echo "<tr>
      <td style='font-size: 11px' align = 'center'>$urut</td>
      <td style='font-size: 11px' align = 'center'>$no_so</td>
      <td style='font-size: 11px' align = 'center'>$tanggal</td>
      <td style='font-size: 11px' align = 'center'>$tanggal_bongkar</td>
      <td style='font-size: 11px' align = 'center'>$kode_perta</td>
      <td style='font-size: 11px' align = 'center'>$lokasi</td>
      <td style='font-size: 11px' align = 'center'>$nama_barang</td>
      <td style='font-size: 11px' align = 'center'>$qty/L</td>
      <td style='font-size: 11px' align = 'center'>"?>  <?= formatuang($harga); ?> <?php echo "</td>
      <td style='font-size: 11px' align = 'center'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
      <td style='font-size: 11px' align = 'center'>$volume_tangki/L</td>
      <td style='font-size: 11px' align = 'center'>$sonding_awal/L</td>
      <td style='font-size: 11px' align = 'center'>$sonding_akhir/L</td>
      <td style='font-size: 11px' align = 'center'>$selisih/L</td>
      <td style='font-size: 11px' align = 'center'>"?> <?= round($losis,2); ?> <?php echo" /L</td>
      <td style='font-size: 11px' align = 'center'>$keterangan</td>
      "; ?>
      <?php echo "
      <td style='font-size: 11px'>"; ?> <a download="../file_administrasi/<?= $file_bukti ?>" href="../file_administrasi/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>
      <?php echo "<td style='font-size: 11px'>"; ?>
    


      <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_pembelian']; ?>">Edit</button>

<!-- Form EDIT DATA -->

<div class="modal fade bd-example-modal-lg" id="formedit<?php echo $data['no_pembelian']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Form Edit Pembelian </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="close">
          <span aria-hidden="true"> &times; </span>
        </button>
      </div>

      <!-- Form Edit Data -->
      <div class="modal-body" align="left">
        <form action="../proses/edit_pembelian" enctype="multipart/form-data" method="POST">

          <input type="hidden" name="no_pembelian" value="<?php echo $no_pembelian; ?>">
          <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
          <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">

          <div class="row">
            <div class="col-md-6">

              <label>No SO</label>
              <div class="col-sm-10">
                <input  class="form-control form-control-sm" type="text" id="no_so" name="no_so" required="" value="<?php echo $no_so;  ?>">
              </div>

            </div>
            <div class="col-md-6">

            </div>

          </div>

          <br>

          <div class="row">
            <div class="col-md-6">

              <label>Tanggal</label>
              <div class="col-sm-10">
                <input  class="form-control form-control-sm" type="date" id="tanggal" name="tanggal" required="" value="<?php echo $tanggal; ?>">
              </div>

            </div>
            <div class="col-md-6">

              <label>Tanggal Bongkar</label>
              <div class="col-sm-10">
                <input  class="form-control form-control-sm" type="date" id="tanggal_bongkar" name="tanggal_bongkar" value="<?php echo $tanggal_bongkar; ?>">
              </div>

            </div>

          </div>


          <br>

          <div class="row">

          <div class="col-md-6">
          <label>Lokasi</label>
          <select id="lokasi" name="lokasi" class="form-control ">
            <?php
            include 'koneksi.php';
            $dataSelect = $data['lokasi'];
            $result = mysqli_query($koneksi, "SELECT * FROM pertashop");   

            while ($data2 = mysqli_fetch_array($result)){
              $nama_driver = $data2['lokasi'];


              echo "<option" ?> <?php echo ($dataSelect == $nama_driver) ? "selected" : "" ?>> <?php echo $nama_driver; ?> <?php echo "</option>";
              
            }
            ?>
          </select>
          </div>

        

            <div class="col-md-6">
              <label>QTY</label>
              <select id="qty" name="qty" class="form-control">
                <?php
                $dataSelect = $data['qty']; ?>
                <option <?php echo ($dataSelect == '1000') ? "selected" : "" ?>>1000</option>
                <option <?php echo ($dataSelect == '2000') ? "selected" : "" ?>>2000</option>
                <option <?php echo ($dataSelect == '3000') ? "selected" : "" ?>>3000</option>
                <option <?php echo ($dataSelect == '4000') ? "selected" : "" ?>>4000</option>
                <option <?php echo ($dataSelect == '5000') ? "selected" : "" ?>>5000</option>
              </select>
            </div>
            </div>
     

          <br>

          <div class="row">

            <div class="col-md-6">
            <label>Nama Barang</label>
              <select id="nama_barang" name="nama_barang" class="form-control">
                <?php
                $dataSelect = $data['nama_barang']; ?>
                <option <?php echo ($dataSelect == 'Pertamax') ? "selected" : "" ?>>Pertamax</option>
                <option <?php echo ($dataSelect == 'Dexlite') ? "selected" : "" ?>>Dexlite</option>

              </select>
            </div>
          </div>

          <br>
          
          <div class="row">
            <div class="col-md-6">

              <label>Harga</label>
              <div class="col-sm-10">
                <input  class="form-control form-control-sm" type="float" id="harga" name="harga" required="" value="<?php echo $harga; ?>">
              </div>

            </div>
            <div class="col-md-6">

              <label>Volume Tanki</label>
              <div class="col-sm-10">
                <input  class="form-control form-control-sm" type="float" id="volume_tangki" name="volume_tangki" required="" value="<?php echo $volume_tangki; ?>">
              </div>

            </div>

          </div>
          <br>
          
          <div class="row">
            <div class="col-md-6">

              <label>Sonding Sebelum Isi</label>
              <div class="col-sm-10">
                <input  class="form-control form-control-sm" type="float" id="sonding_awal" name="sonding_awal" required="" value="<?php echo $sonding_awal; ?>">
              </div>

            </div>
            <div class="col-md-6">

              <label>Sonding Setelah Isi</label>
              <div class="col-sm-10">
                <input  class="form-control form-control-sm" type="float" id="sonding_akhir" name="sonding_akhir" required="" value="<?php echo $sonding_akhir; ?>">
              </div>

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

          <div>
            <label>Upload File</label>
            <input type="file" name="file">
          </div>
      </div>


      <div class="modal-footer">
        <button type="submit" class="btn btn-primary"> Ubah </button>
        <button type="reset" class="btn btn-danger"> RESET</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Button Hapus -->
<button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_pembelian']; ?>" data-toggle='tooltip' title='Hapus Data Dokumen'>Hapus</button>
<div class="modal fade" id="PopUpHapus<?php echo $data['no_pembelian']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
 <div class="modal-dialog" role ="document">
   <div class="modal-content"> 
    <div class="modal-header">
      <h4 class="modal-title"> <b> Hapus Data Sparepart </b> </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="close">
        <span aria-hidden="true"> &times; </span>
      </button>
    </div>

    <div class="modal-body">
      <form action="../proses/hapus_pembelian" method="POST">
        <input type="hidden" name="no_pembelian" value="<?php echo $no_pembelian;?>">
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
<div style="margin-right: 100px; margin-left: 100px;">
<h6 align="Center">Stok</h6>
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th  style='font-size: 12px' >Kode Barang</th>
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


      echo "<tr>
      <td style='font-size: 12px' align = 'center'>$kode_barang</td>
      <td style='font-size: 12px' align = 'center'>$kode_perta</td>
      <td style='font-size: 12px' align = 'center'>$nama_barang</td>
      <td style='font-size: 12px' align = 'center'>$stok</td>
     
  </tr>";
}
?>

</tbody>
</table>
</div>
</div>

<br>
<hr>
<div style="margin-right: 100px; margin-left: 100px;">
<h6 align="Center">Laporan Losis</h6>
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
      <th style='font-size: 11px'>Pertashop</th>
      <th style='font-size: 11px'>Nama Barang</th>
      <th style='font-size: 11px'>Total Losis</th>
    </tr>
  </thead>
  <tbody>

  
  <tr>
      <td style='font-size: 11px' align = 'center'>Nusa Bakti</td>
      <td style='font-size: 11px' align = 'center'>Dexlite</td>
      <td style='font-size: 11px' align = 'center'><?=  ($losis_nb_dex); ?></td>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Nusa Bakti</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'><?=  ($losis_nb_max); ?></td>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Sumber Jaya</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'><?=  ($losis_sj); ?></td>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Bedilan</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'><?=  ($losis_be); ?></td>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Muara Dua</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'><?=  ($losis_md); ?></td>
     
  </tr>


</tbody>
</table>
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