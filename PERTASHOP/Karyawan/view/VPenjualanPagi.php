<?php
session_start();
include'koneksi.php';
if(!isset($_SESSION["login"])){
  header("Location: logout.php");
  exit;
}
$id=$_COOKIE['id_cookie'];

$result = mysqli_query($koneksi, "SELECT * FROM akun_perta  WHERE id_kar_perta = '$id'");
$data3 = mysqli_fetch_array($result);
$nama = $data3['nama'];
$nama_karyawan = $data3['nama_karyawan'];
$kode_perta = $data3['kode_perta'];


$result2 = mysqli_query($koneksi, "SELECT * FROM pertashop WHERE kode_perta = '$kode_perta'");
$data2 = mysqli_fetch_array($result2);
$lokasi = $data2['lokasi'];

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
  $table = mysqli_query($koneksi,"SELECT * FROM penjualan_pagi a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta  WHERE tanggal ='$tanggal_awal' AND b.lokasi = '$lokasi'");
    $result = mysqli_query($koneksi, "SELECT * FROM pertashop WHERE lokasi = '$lokasi' ");
$data_perta = mysqli_fetch_array($result);
$kode_perta = $data_perta['kode_perta'];

}

else{
  $table = mysqli_query($koneksi,"SELECT * FROM penjualan_pagi a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND b.lokasi = '$lokasi'");
  $result = mysqli_query($koneksi, "SELECT * FROM pertashop WHERE lokasi = '$lokasi' ");
$data_perta = mysqli_fetch_array($result);
$kode_perta = $data_perta['kode_perta'];


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

  <title>Penjualan</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKaryawan">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active" >
                <a class="nav-link" href="DsKaryawan">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 16px;" >Dashboard</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading" style="font-size: 15px; color:white;">
                     Menu Kasir
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                  15  aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Kasir</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Kasir</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Penjualan Pertamax</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenjualanDex">Penjualan Dexlite</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaran">Pengeluaran</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VAbsensi">Absensi</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenjualanPagi">Penjualan Pagi</a>
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
      <?php echo "<a href='VPenjualanPagi'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Penjualan Pagi Pertashop $lokasi</h5></a>"; ?>
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
          <span class="mr-2 d-none d-lg-inline  small"  style="color:white;"><?php echo "$nama_karyawan"; ?></span>
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


 <div style="margin-right: 10px; margin-left: 10px;">

  <?php  echo "<form  method='POST' action='VPenjualanPagi'>" ?>
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

 <div class="row">
  
  <div class="col-md-12">
    <!-- Button Input Data Bayar -->
    <div>
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
          <?php  echo "<form action='../proses/proses_penjualan_pagi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

          <br>
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
         <br>

         <div class="row">

          <div class="col-md-6">
           <label>Lokasi</label>
           <select id="lokasi" name="lokasi" class="form-control ">
            <?php
            include 'koneksi.php';
            $result = mysqli_query($koneksi, "SELECT * FROM pertashop where lokasi = '$lokasi'");   

            while ($data2 = mysqli_fetch_array($result)){
              $nama_driver = $data2['lokasi'];


              echo "<option> $nama_driver </option> ";
              
            }
            ?>
          </select>
        </div>

      </div>

      <br>

      <div class="row">
         <div class="col-md-4">
        <label>Nama Barang</label>
          <select id="nama_barang" name="nama_barang" class="form-control">
            <option>Pertamax</option>
            <option>Dexlite</option>
          </select>
          </div> 
          
        <div class="col-md-4">
          <label>QTY</label>
             <input class="form-control form-control-sm" type="float" id="qty" name="qty" required="">
        </div>                

        <input type="hidden" name="nama_karyawan" value="<?php echo $nama_karyawan;?>">  
        <div class="col-md-4">
          <label>Harga</label>
          <input class="form-control form-control-sm" type="float" id="harga" name="harga" required="">

        </div>         
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
<table id='example' class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%;  ">
  <thead>
    <tr>
      <th  style="font-size: 11px" >No</th>
      <th  style="font-size: 11px">Tanggal</th>
      <th  style="font-size: 11px">Kode Pertashop</th>   
      <th  style="font-size: 11px">Lokasi</th>
      <th  style="font-size: 11px">Penjual</th>
      <th  style="font-size: 11px">Barang</th>
      <th  style="font-size: 11px">QTY</th>
      <th  style="font-size: 11px">Harga</th>
      <th  style="font-size: 11px">Jumlah</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $urut = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>
    <?php while($data = mysqli_fetch_array($table)){
      $no_penjualan = $data['no_penjualan'];
      $tanggal =$data['tanggal'];
      $kode_perta =$data['kode_perta'];
      $lokasi = $data['lokasi'];
      $nama_barang = $data['nama_barang'];
      $nama_karyawan = $data['nama_karyawan'];
      $qty = $data['qty'];
      $harga = $data['harga'];
      $jumlah = $qty * $harga;
      $urut = $urut + 1;

      echo "<tr>
      <td style='font-size: 11px' align = 'center'>$urut</td>
      <td style='font-size: 11px' align = 'center'>$tanggal</td>
      <td style='font-size: 11px' align = 'center'>$kode_perta</td>
      <td style='font-size: 11px' align = 'center'>$lokasi</td>
      <td style='font-size: 11px' align = 'center'>$nama_karyawan</td>
      <td style='font-size: 11px' align = 'center'>$nama_barang</td>
      <td style='font-size: 11px' align = 'center'>$qty/L</td>
      <td style='font-size: 11px' align = 'center'>"?>  <?= formatuang($harga); ?> <?php echo "</td>
      <td style='font-size: 11px' align = 'center'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
      "; ?>
    
      <?php echo "<td style='font-size: 12px'>"; ?>
    
<!-- Button Hapus -->
<button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_penjualan']; ?>" data-toggle='tooltip' title='Hapus Data Dokumen'>Hapus</button>
<div class="modal fade" id="PopUpHapus<?php echo $data['no_penjualan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
 <div class="modal-dialog" role ="document">
   <div class="modal-content"> 
    <div class="modal-header">
      <h4 class="modal-title"> <b> Hapus Data Penjualan </b> </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="close">
        <span aria-hidden="true"> &times; </span>
      </button>
    </div>

    <div class="modal-body">
      <form action="../proses/hapus_penjualan_pagi" method="POST">
        <input type="hidden" name="no_penjualan" value="<?php echo $no_penjualan;?>">
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
<div style="margin-right: 100px; margin-left: 100px;">
Chart
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
      buttons: [ 'colvis' ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>



</body>

</html>