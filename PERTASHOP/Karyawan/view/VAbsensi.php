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
  $table = mysqli_query($koneksi,"SELECT * FROM absensi  WHERE tanggal ='$tanggal_awal' AND nama_karyawan = '$nama_karyawan'");
   
}

else{
  $table = mysqli_query($koneksi,"SELECT * FROM absensi  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_karyawan = '$nama_karyawan'");


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

  <title>Absensi</title>

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
       <?php echo "<a href='VPepindahanBaja1'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Semangat Kerja</h5></a>"; ?>
       <!-- Sidebar Toggle (Topbar) -->
       <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>



      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">






        <div class="topbar-divider d-none d-sm-block"></div>
<div
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


  <!-- Name Page -->
  <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
 <?php  echo "<form  method='POST' action='VAbsensi' style='margin-bottom: 15px;'>" ?>
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
      <div class="col-md-10">
        <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
      </div>
      <div class="col-md-2">
        <!-- Button Pindah Baja -->
        <!-- Button Input Data -->
        <div align="right">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inputkaryawan"> <i class="fas fa-plus-square mr-2"></i> Absensi </button> <br> <br>
        </div>
        <div class="modal fade" id="inputkaryawan" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
         <div class="modal-dialog" role ="document">
           <div class="modal-content"> 
            <div class="modal-header">
              <h5 class="modal-title"> Form Absensi </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div> 

            <!-- Form Input Data -->
            <div class="modal-body" align="left">
              
                 <?php  echo "<form action='../proses/proses_absensi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>
                <input type="hidden" name="nama_karyawan" value="<?php echo $nama_karyawan;?>">  
                <input type="hidden" name="lokasi" value="<?php echo $lokasi;?>">  
        <div>
          <label>Status</label>
          <select id="status" name="status" class="form-control">
            <option>Cek In</option>
            <option>Cek Out</option>
            <option>Izin</option>
            <option>Lainnya</option>
          </select>
        </div>  
        <br>
        <div>
     <label>Keterangan</label>
     <div class="form-group">
       <textarea id = "keterangan" name="keterangan" style="width: 300px;"></textarea>
     </div>
   </div>

        <br>
      <label>Upload File</label> 
      <input type="file" name="file" required> 
    </div> 
                
              


                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"> SUBMIT</button>
                  <button type="reset" class="btn btn-danger"> RESET</button>
                </div>
              </form>
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
        <th>Waktu Absen<a/th>
        <th>Status<a/th>
        <th>Nama Karyawan</th>
        <th>Lokasi</th>
        <th>Keterangan</th>
        <th>Bukti Foto</th>
        <th>Hapus Absen</th>
      </tr>
    </thead>
    <tbody>

      <?php while($data = mysqli_fetch_array($table)){
        $no_absen = $data['no_absen'];
        $tanggal =$data['tanggal'];
        $status =$data['status'];
        $nama_karyawan =$data['nama_karyawan'];
        $lokasi = $data['lokasi'];
        $keterangan = $data['keterangan'];
        $file_bukti = $data['file_bukti'];
       


        echo "<tr>
        <td style='font-size: 14px'>$tanggal</td>
        <td style='font-size: 14px'>$status</td>
        <td style='font-size: 14px'>$nama_karyawan</td>
        <td style='font-size: 14px'>$lokasi</td>
        <td style='font-size: 14px'>$keterangan</td>
        "; ?>
        
        <?php echo "<td style='font-size: 12px'>"; ?>

        <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_absen']; ?>">Lihat</button>

        <!-- Form EDIT DATA -->

        <div class="modal fade" id="formedit<?php echo $data['no_absen']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
          <div class="modal-dialog" role ="document">
            <div class="modal-content"> 
              <div class="modal-header">
                <h5 class="modal-title"> Foto Absen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                  <span aria-hidden="true"> &times; </span>
                </button>
              </div>


              <!-- Form Edit Data -->
              <div class="modal-body">
                       <img  style="height: 100%; width: 100%;" s src="../file_karyawan/<?= $file_bukti ?>" >
                </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><a  style="color: black;" download="../file_karyawan/<?= $file_bukti ?>" href="../file_karyawan/<?= $file_bukti ?>">Download</a>  </button>
              
                  </div>
                </form>
              </div>
            </div>
          </div>
   




        <?php echo "</td> "; ?>
        
        <?php echo "<td style='font-size: 12px'>"; ?>

      <!-- Button Hapus -->
<button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_absen']; ?>" data-toggle='tooltip' title='Hapus Data Dokumen'>Hapus</button>
<div class="modal fade" id="PopUpHapus<?php echo $data['no_absen']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
 <div class="modal-dialog" role ="document">
   <div class="modal-content"> 
    <div class="modal-header">
      <h4 class="modal-title"> <b> Hapus Data Absensi </b> </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="close">
        <span aria-hidden="true"> &times; </span>
      </button>
    </div>

    <div class="modal-body">
      <form action="../proses/hapus_absensi" method="POST">
        <input type="hidden" name="no_absen" value="<?php echo $no_absen;?>">
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




        <?php echo "</td> 
        </tr>";
      }
      ?>

    </tbody>
  </table>
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