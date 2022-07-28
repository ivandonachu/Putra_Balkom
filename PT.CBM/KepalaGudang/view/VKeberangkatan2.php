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
if ($jabatan_valid == 'Kepala Gudang') {

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

if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksi, "SELECT * FROM riwayat_keberangkatan a INNER JOIN driver b ON  a.id_driver = b.id_driver WHERE tanggal = '$tanggal_awal'");
}
else{
  $table = mysqli_query($koneksi, "SELECT * FROM riwayat_keberangkatan a INNER JOIN driver b ON  a.id_driver = b.id_driver WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
}

$table2 = mysqli_query($koneksi, "SELECT * FROM driver ");
$table3 = mysqli_query($koneksi, "SELECT * FROM rute_driver");

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Keberangkatan</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKepalaGudang">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active" >
                <a class="nav-link" href="DsKepalaGudang.php">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 16px;" >Dashboard</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading" style="font-size: 15px; color:white;">
                     Menu Kepala Gudang
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                  15  aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Inventory</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Inventory</h6>
                        <a class="collapse-item" href="VLaporanInventory" style="font-size: 15px;">Laporan Inventory</a>
                        <a class="collapse-item" href="VKeberangkatan" style="font-size: 15px;">Keberangkatan</a>
                        <a class="collapse-item" href="VKonfirmasiRetur" style="font-size: 15px;">Konfirmasi Retur</a>
                        <a class="collapse-item" href="VPindahBajaMD" style="font-size: 15px;">Pidah Baja MES/PBR</a>
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
        <?php echo "<a href='VKeberangkatan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Keberangkatan Gudang</h5></a>"; ?>
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


    <?php  echo "<form  method='POST' action='VKeberangkatan2' style='margin-bottom: 15px;'>" ?>
    <div>
      <div align="left" style="margin-left: 20px;"> 
        <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1"> 
        <span>-</span>
        <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
        <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm" >Lihat</button>
      </div>
    </div>
  </form>


    <div class="col-md-8">
     <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
   </div>
   <br>

<!-- Tabel -->    
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Nama Driver</th>
      <th>No Polisi</th>
      <th>Posisi Bongkar</th>
      <th>Tujuan Berangkat</th>
      <th>Uang Jalan</th>
      <th>LPG 3kg</th>
      <th>LPG 3kg Rt</th>
      <th>LPG 12kg</th>
      <th>LPG 12kg Rt</th>
      <th>BG 5,5kg</th>
      <th>BG 5,5kg Rt</th>
      <th>BG 12kg</th>
      <th>BG 12kg Rt</th>
      <th>Status</th>
      <th>Keterangan</th>
      <th>File LO</th>
      <th>Hapus</th>
      <th>Input File LO</th>
    </tr>
  </thead>
  <tbody>
    <?php
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>

    <?php while($data = mysqli_fetch_array($table)){
      $no_keberangkatan = $data['no_keberangkatan'];
      $tanggal =$data['tanggal'];
      $nama_driver = $data['nama_driver'];
      $no_polisi = $data['no_polisi'];
      $posisi_bongkar = $data['posisi_bongkar'];
      $tujuan_keberangkatan = $data['tujuan_berangkat'];
      $L03K11 = $data['L03K11'];
      $L03K00 = $data['L03K00'];
      $L12K11 = $data['L12K11'];
      $L12K00 = $data['L12K00'];
      $B05K11 = $data['B05K11'];
      $B05K00 = $data['B05K00'];
      $B12K11 = $data['B12K11'];
      $B12K00 = $data['B12K00'];
      $uang_jalan = $data['uang_jalan'];
      $keterangan = $data['keterangan'];
      $file_bukti = $data['file_bukti'];
      $status = $data['jenis_keberangkatan'];

      echo "<tr>
      <td style='font-size: 14px'>$no_keberangkatan</td>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$nama_driver</td>
      <td style='font-size: 14px'>$no_polisi</td>
      <td style='font-size: 14px'>$posisi_bongkar</td>
      <td style='font-size: 14px'>$tujuan_keberangkatan</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($uang_jalan); ?> <?php echo "</td>
      <td style='font-size: 14px'>$L03K11</td>
      <td style='font-size: 14px'>$L03K00</td>
      <td style='font-size: 14px'>$L12K11</td>
      <td style='font-size: 14px'>$L12K00</td>
      <td style='font-size: 14px'>$B05K11</td>
      <td style='font-size: 14px'>$B05K00</td>
      <td style='font-size: 14px'>$B12K11</td>
      <td style='font-size: 14px'>$B12K00</td>
      <td style='font-size: 14px'>$status</td>
      <td style='font-size: 14px'>$keterangan</td>
      <td style='font-size: 14px'>"; ?> <a download="../file_toko/<?= $file_bukti ?>" href="../file_toko/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>
      <?php echo "<td style='font-size: 12px' align = 'center'>"; ?>

      <button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_keberangkatan']; ?>" data-toggle='tooltip' title='Hapus Keberangkatan'></button>

      <div class="modal fade" id="PopUpHapus<?php echo $data['no_keberangkatan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
       <div class="modal-dialog" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h4 class="modal-title"> <b> Hapus Keberangkatan</b> </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>

          <div class="modal-body">
            <form action="../proses/hapus_keberangkatan" method="POST">
              <input type="hidden" name="no_keberangkatan" value="<?php echo $no_keberangkatan;?>">
              <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
              <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir;?>">
              <input type="hidden" name="uang_jalan" value="<?php echo $uang_jalan;?>">
              <input type="hidden" name="status" value="<?php echo $status;?>">
              <input type="hidden" name="L03K11" value="<?php echo $L03K11;?>">
              <input type="hidden" name="L12K11" value="<?php echo $L12K11;?>">
              <input type="hidden" name="B05K11" value="<?php echo $B05K11;?>">
              <input type="hidden" name="B12K11" value="<?php echo $B12K11;?>">
              <input type="hidden" name="L03K00" value="<?php echo $L03K00;?>">
              <input type="hidden" name="L12K00" value="<?php echo $L12K00;?>">
              <input type="hidden" name="B05K00" value="<?php echo $B05K00;?>">
              <input type="hidden" name="B12K00" value="<?php echo $B12K00;?>">
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

    <?php echo  " </td> " ?> 
    <?php echo "<td style='font-size: 12px' align = 'center'>"; ?>

      <button href="#" type="submit" class="fas fa-plus-square mr-2 bg-primary mr-2 rounded" data-toggle="modal" data-target="#inputfile<?php echo $data['no_keberangkatan']; ?>" data-toggle='tooltip' title='Input file LO'></button>

      <div class="modal fade" id="inputfile<?php echo $data['no_keberangkatan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
       <div class="modal-dialog" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h4 class="modal-title"> <b> Input File LO </b> </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>

          <div class="modal-body">
            <form action="../proses/input_file_lo" enctype="multipart/form-data" method="POST">
              <input type="hidden" name="no_keberangkatan" value="<?php echo $no_keberangkatan ;?>">
              <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
              <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir;?>">
             <div>
              <label>Upload File</label> 
              <input type="file" name="file"> 
             </div> 


              <div class="modal-footer">
                <button type="submit" class="btn btn-primary"> Inputkan</button>
                <button type="reset" class="btn btn-danger"> RESET</button>
              </div>

              
            </form>
          </div>
        </div>
      </div>
    </div>

      <button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#hapusfile<?php echo $data['no_keberangkatan']; ?>" data-toggle='tooltip' title='Hapus File LO'></button>

      <div class="modal fade" id="hapusfile<?php echo $data['no_keberangkatan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
       <div class="modal-dialog" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h4 class="modal-title"> <b> Hapus File LO </b> </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>

          <div class="modal-body">
            <form action="../proses/hapus_file_lo" method="POST">

              <input type="hidden" name="no_keberangkatan" value="<?php echo $no_keberangkatan;?>">
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

    <?php echo  " </td>  </tr>";
  }
  ?>

</tbody>
</table>
<br>
<br>
<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">

<div class="row">
  <div class="col-md-6">
    <!-- Tabel -->    
  <table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Kode Rute</th>
      <th>Posisi Bongkar</th>
      <th>Tujuan Keberangkatan</th>
      <th>Tambahan</th>
      <th>Jumlah</th>
    </tr>
  </thead>
  <tbody>

    <?php while($data3 = mysqli_fetch_array($table3)){
      $no_rute = $data3['no_rute'];
      $posisi_bongkar =$data3['posisi_bongkar'];
      $tujuan_berangkat = $data3['tujuan_berangkat'];
      $tambahan = $data3['tambahan'];
      $jumlah = $data3['jumlah'];


      echo "<tr>
      <td style='font-size: 14px'>$no_rute</td>
      <td style='font-size: 14px'>$posisi_bongkar</td>
      <td style='font-size: 14px'>$tujuan_berangkat</td>
      <td style='font-size: 14px'>$tambahan</td>
      <td style='font-size: 14px'>$jumlah</td> 
        </tr>";
  }
  ?>

</tbody>
</table>
  </div>
  <div class="col-md-6">
    

<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Nama Driver</th>
      <th>No Polisi</th>
      <th>Status</th>
      <th>Berangkat 3kg</th>
      <th>Berangkat 12kg + 5,5kg</th>
    </tr>
  </thead>
  <tbody>

    <?php while($data2 = mysqli_fetch_array($table2)){
      $nama_driver = $data2['nama_driver'];
      $no_polisi =$data2['no_polisi'];
      $status = $data2['status'];
      $id_driver = $data2['id_driver'];
      echo "<tr>
      <td style='font-size: 14px'>$nama_driver</td>
      <td style='font-size: 14px'>$no_polisi</td>
      <td style='font-size: 14px'>$status</td>"; ?>
      <?php echo "<td style='font-size: 12px'>"; ?>
      <div align="center">
      <button href="#" type="submit" class="btn btn-primary" data-toggle="modal" data-target="#PopUpHapus<?php echo $data2['id_driver']; ?>" data-toggle='tooltip' > <i class="fas fa-plus-square mr-2"></i> Catat Keberangkatan</button>
      </div>
      <div class="modal fade bd-example-modal-lg" id="PopUpHapus<?php echo $data2['id_driver']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h4 class="modal-title"> <b> Form Input Keberangkatan 3KG </b> </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>

          <div class="modal-body" align="left">
          <?php  echo "<form action='../proses/proses_keberangkatan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

          <div class="row">
            <div class="col-md-12">

              <label>Tanggal</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal" name="tanggal" required="">
             </div>
  

          </div>
        </div>

        <br>

        <div class="row">
          <div class="col-md-6">
            <input type="hidden" name="nama_driver" id="nama_driver" value="<?php echo $nama_driver; ?>">
            <label>Nama Driver</label>
            <input class="form-control form-control-sm" disabled="" type="text" id="nama_driver" name="nama_driver" value="<?php echo $nama_driver ?>" required>
          </div>
  
          <div class="col-md-6">
           <label>No Polisi</label>
           <input class="form-control form-control-sm" type="text" id="no_polisi" name="no_polisi" value="<?php echo $no_polisi ?>">
        </div>
      </div>

      <br>
      <div class="row">
        <div class="col-md-6">
          <label>Posisi Bongkar</label>
          <select id="posisi_bongkar" name="posisi_bongkar" class="form-control">
            <?php
            include 'koneksi.php';
            $result4 = mysqli_query($koneksi, "SELECT * FROM rute_driver");   

            while ($data4 = mysqli_fetch_array($result4)){
              $posisi_bongkar = $data4['posisi_bongkar'];

             
                echo "<option> $posisi_bongkar </option> ";
              
            }
            ?>
          </select>
        </div>
        <div class="col-md-6">
             <label>Uang Tambahan</label>
             <input class="form-control form-control-sm" type="number" id="uang_tambahan" name="uang_tambahan" value="0">     
        </div>
      </div>


    <script>

      function sum() {
        var banyak_barang = document.getElementById('qty').value;
        var harga = document.getElementById('harga').value;
        var result = parseInt(banyak_barang) * parseInt(harga);
        if (!isNaN(result)) {
         document.getElementById('jumlah').value = result;
       }
     }
   </script>

   <div class="row">
        <div class="col-md-6">
             <label>Jumlah Baja 3kg</label>
             <input class="form-control form-control-sm" type="number" id="L03K11" name="L03K11" value="0" required>     
        </div>
        <div class="col-md-6">
             <label>Jumlah Baja 3kg RETUR</label>
             <input class="form-control form-control-sm" type="number" id="L03K00" name="L03K00" value="0" required>     
        </div>
      </div>
<br>
   <div class="row">
     <div class="col-md-6">
           <label>Status</label>
           <select id="status" name="status" class="form-control ">
            <option>Kamvas + Pengisian</option>
            <option>Hanya Kamvas</option>
            
          </select>
        </div>
      </div>
   <div>

<br>
     <label>Keterangan</label>
         <div class="form-group">
           <textarea id = "keterangan" name="keterangan" style="width: 300px;"></textarea>
         </div>
  </div>

<br>

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

    <?php echo  " </td> ";

    //12 + 55 kg berangkat
 echo "<td style='font-size: 12px'>"; ?>
      <div align="center">
      <button href="#" type="submit" class="btn btn-primary" data-toggle="modal" data-target="#berangkat12<?php echo $data2['id_driver']; ?>" data-toggle='tooltip' > <i class="fas fa-plus-square mr-2"></i> Catat Keberangkatan</button>
      </div>
      <div class="modal fade bd-example-modal-lg" id="berangkat12<?php echo $data2['id_driver']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h4 class="modal-title"> <b> Form Input Keberangkatan 12 KG + 5,5KG </b> </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>

          <div class="modal-body" align="left">
          <?php  echo "<form action='../proses/proses_keberangkatan12?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

          <div class="row">
            <div class="col-md-12">

              <label>Tanggal</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal" name="tanggal" required="">
             </div>
  

          </div>
        </div>

        <br>

        <div class="row">
          <div class="col-md-6">
            <input type="hidden" name="nama_driver" id="nama_driver" value="<?php echo $nama_driver; ?>">
            <label>Nama Driver</label>
            <input class="form-control form-control-sm" disabled="" type="text" id="nama_driver" name="nama_driver" value="<?php echo $nama_driver ?>" required>
          </div>
  
          <div class="col-md-6">
           <label>No Polisi</label>
           <input class="form-control form-control-sm" type="text" id="no_polisi" name="no_polisi" value="<?php echo $no_polisi ?>">
        </div>
      </div>

      <br>
      <div class="row">
        <div class="col-md-6">
          <label>Posisi Bongkar</label>
          <select id="posisi_bongkar" name="posisi_bongkar" class="form-control">
            <?php
            include 'koneksi.php';
            $result4 = mysqli_query($koneksi, "SELECT * FROM rute_driver");   

            while ($data4 = mysqli_fetch_array($result4)){
              $posisi_bongkar = $data4['posisi_bongkar'];

           
                echo "<option> $posisi_bongkar </option> ";
              
            }
            ?>
          </select>
        </div>
        <div class="col-md-6">
             <label>Uang Tambahan</label>
             <input class="form-control form-control-sm" type="number" id="uang_tambahan" name="uang_tambahan" value="0">     
        </div>
      </div>


    <script>

      function sum() {
        var banyak_barang = document.getElementById('qty').value;
        var harga = document.getElementById('harga').value;
        var result = parseInt(banyak_barang) * parseInt(harga);
        if (!isNaN(result)) {
         document.getElementById('jumlah').value = result;
       }
     }
   </script>

   <div class="row">
       <div class="col-md-4">
             <label>Jumlah Baja BG 5,5 Kg</label>
             <input class="form-control form-control-sm" type="number" id="bg5" name="bg5" value="0" required>     
        </div>
        <div class="col-md-4">
             <label>Jumlah Baja BG 12 Kg</label>
             <input class="form-control form-control-sm" type="number" id="bg12" name="bg12" value="0" required>     
        </div>
        <div class="col-md-4">
             <label>Jumlah Baja LPG 12 Kg</label>
             <input class="form-control form-control-sm" type="number" id="lpg12" name="lpg12" value="0" required>     
        </div>
      </div>
<br>
<div class="row">
       <div class="col-md-4">
             <label>Jumlah Baja BG 5,5 Kg RETUR</label>
             <input class="form-control form-control-sm" type="number" id="bg5rt" name="bg5rt" value="0" required>     
        </div>
        <div class="col-md-4">
             <label>Jumlah Baja BG 12 Kg RETUR</label>
             <input class="form-control form-control-sm" type="number" id="bg12rt" name="bg12rt" value="0" required>     
        </div>
        <div class="col-md-4">
             <label>Jumlah Baja LPG 12 Kg RETURS</label>
             <input class="form-control form-control-sm" type="number" id="lpg12rt" name="lpg12rt" value="0" required>     
        </div>
      </div>
      <br>
   <div class="row">
     <div class="col-md-6">
           <label>Status</label>
           <select id="status" name="status" class="form-control ">
            <option>Kamvas + Pengisian</option>
            <option>Hanya Kamvas</option>
            
          </select>
        </div>
      </div>
   <div>

<br>
     <label>Keterangan</label>
         <div class="form-group">
           <textarea id = "keterangan" name="keterangan" style="width: 300px;"></textarea>
         </div>
  </div>

<br>

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

    <?php echo  " </td> </tr>";





  }
  ?>

</tbody>
</table>
  </div>
</div>

</div>
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