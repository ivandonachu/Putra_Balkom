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
if ($jabatan_valid == 'Kepala Gudang') {

}

else{  header("Location: logout.php");
exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];



$table = mysqli_query($koneksi, "SELECT * FROM laporan_inventory ORDER BY no_laporan");
$table2 = mysqli_query($koneksi, "SELECT * FROM inventory a INNER JOIN baja b ON a.kode_baja=b.kode_baja");
 ?>
 <!DOCTYPE html>
 <html lang="en">

 <head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Laporan Inventory</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKepalaGudang.php">
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
                  <i class="fas fa-warehouse" style="font-size: 18px; color:white;" ></i>
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
       <?php echo "<a href='VPepindahanBaja1'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Konfirmasi Baja Retur Toko</h5></a>"; ?>
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

  <div class="row">
    <div class="col-md-10">
     
   </div>
   <div class="col-md-2">
    <!-- Button Pindah Baja -->
    <div align="right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Laporan Inventory </button> <br> <br>
    </div>
    <!-- Form Modal  -->
    <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role ="document">
       <div class="modal-content"> 
        <div class="modal-header">
          <h5 class="modal-title"> Form Laporan Inventory </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> 

        <!-- Form Input Data -->
        <div class="modal-body" align="left">
          <?php  echo "<form action='../proses/proses_laporan_inventory' enctype='multipart/form-data' method='POST'>";  ?>

          <div class="row">
            <div class="col-md-6">

              <label>Tanggal</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal" name="tanggal" required="">
             </div>
    

          </div>
          <div class="col-md-6">
          <label>REF</label>
            <select id="referensi" name="referensi"  enctype="multipart/form-data" class="form-control">
              <option>TK</option>
              <option>GD</option>
       
            </select>
          </div>
        </div>

      <br>

     

      <div class="row">

        <div class="col-md-4">
          <label>Elpiji 3 Kg Baja + Isi</label>
          <input class="form-control form-control-sm" type="number" id="L03K11" name="L03K11"  required="">
        </div>   
        <div class="col-md-4">
          <label>Elpiji 3 Kg Kosong</label>
          <input class="form-control form-control-sm" type="number" id="L03K10" name="L03K10"  required="">
        </div>    
        <div class="col-md-4">
          <label>Elpiji 3 Kg Retur</label>
          <input class="form-control form-control-sm" type="number" id="L03K00" name="L03K00"  required="">
        </div>              
      </div>

      <br>

      <div class="row">
        <div class="col-md-4">
          <label>Elpiji 12 Kg Baja + Isi</label>
          <input class="form-control form-control-sm" type="number" id="L12K11" name="L12K11"  required="">
        </div>   
        <div class="col-md-4">
          <label>Elpiji 12 Kg Kosong</label>
          <input class="form-control form-control-sm" type="number" id="L12K10" name="L12K10"  required="">
        </div>    
        <div class="col-md-4">
          <label>Elpiji 12 Kg Retur</label>
          <input class="form-control form-control-sm" type="number" id="L12K00" name="L12K00"  required="">
        </div>              
      </div>

      <br>

       <div class="row">
        <div class="col-md-4">
          <label>Bright Gas 5,5 Kg Baja + Isi</label>
          <input class="form-control form-control-sm" type="number" id="B05K11" name="B05K11"  required="">
        </div>   
        <div class="col-md-4">
          <label>Bright Gas 5,5 Kg Kosong</label>
          <input class="form-control form-control-sm" type="number" id="B05K10" name="B05K10"  required="">
        </div>    
        <div class="col-md-4">
          <label>Bright Gas 5,5 Kg Retur</label>
          <input class="form-control form-control-sm" type="number" id="B05K00" name="B05K00"  required="">
        </div>              
      </div>

      <br>

      <div class="row">
        <div class="col-md-4">
          <label>Bright Gas 12 Kg Baja + Isi</label>
          <input class="form-control form-control-sm" type="number" id="B12K11" name="B12K11"  required="">
        </div>   
        <div class="col-md-4">
          <label>Bright Gas 12 Kg Kosong</label>
          <input class="form-control form-control-sm" type="number" id="B12K10" name="B12K10"  required="">
        </div>    
        <div class="col-md-4">
          <label>Bright Gas 12 Kg Retur</label>
          <input class="form-control form-control-sm" type="number" id="B12K00" name="B12K00"  required="">
        </div>              
      </div>

      <br>
    
    <div>
     <label>Upload File</label> 
    <input type="file" name="file"> 
   </div>

  <div class="modal-footer">
    <button type="submit" class="btn btn-primary"> Laporkan</button>
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
      <th>REF</th>
      <th>L03K11</th>
      <th>L03K10</th>
      <th>L03K00</th>
      <th>L12K11</th>
      <th>L12K10</th>
      <th>L12K00</th>
      <th>B05K11</th>
      <th>B05K10</th>
      <th>B05K00</th>
      <th>B12K11</th>
      <th>B12K10</th>
      <th>B12K00</th>
      <th>FILE</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>

    <?php while($data = mysqli_fetch_array($table)){
      $no_laporan = $data['no_laporan'];
      $tanggal =$data['tanggal'];
      $referensi = $data['referensi'];
      $L03K11 = $data['L03K11'];
      $L03K10 = $data['L03K10'];
      $L03K00 = $data['L03K00'];
      $L12K11 = $data['L12K11'];
      $L12K10 = $data['L12K10'];
      $L12K00 = $data['L12K00'];
      $B05K11 = $data['B05K11'];
      $B05K10 = $data['B05K10'];
      $B05K00 = $data['B05K00'];
      $B12K11 = $data['B12K11'];
      $B12K10 = $data['B12K10'];
      $B12K00 = $data['B12K00'];
      $file_bukti = $data['file_bukti'];


      echo "<tr>
      <td style='font-size: 14px'>$no_laporan</td>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$referensi</td>
      <td style='font-size: 14px'>$L03K11</td>
      <td style='font-size: 14px'>$L03K10</td>
      <td style='font-size: 14px'>$L03K00</td>
      <td style='font-size: 14px'>$L12K11</td>
      <td style='font-size: 14px'>$L12K10</td>
      <td style='font-size: 14px'>$L12K00</td>
      <td style='font-size: 14px'>$B05K11</td>
      <td style='font-size: 14px'>$B05K10</td>
      <td style='font-size: 14px'>$B05K00</td>
      <td style='font-size: 14px'>$B12K11</td>
      <td style='font-size: 14px'>$B12K10</td>
      <td style='font-size: 14px'>$B12K00</td>
     <td style='font-size: 14px'>"; ?> <a download="../file_gudang/<?= $file_bukti ?>" href="../file_gudang/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?> 
      <?php echo "<td style='font-size: 12px'>"; ?>

      <button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_laporan']; ?>" data-toggle='tooltip' title='Hapus Laporan'></button>

      <div class="modal fade" id="PopUpHapus<?php echo $data['no_laporan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
       <div class="modal-dialog" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h4 class="modal-title"> <b> Hapus Laporan </b> </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>

          <div class="modal-body">
            <form action="../proses/hapus_laporan_inventory" method="POST">
              <input type="hidden" name="no_laporan" value="<?php echo $no_laporan;?>">
              <input type="hidden" name="referensi" value="<?php echo $referensie; ?>">

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