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
if ($jabatan_valid == 'Staff Admin') {

}

else{  header("Location: logout.php");
exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];

$table = mysqli_query($koneksi, "SELECT * FROM dokumen");

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Pencatatan Asset</title>

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
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsStaffAdmin">
        <div class="sidebar-brand-icon rotate-n-15">

        </div>
        <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active" >
        <a class="nav-link" href="DsStaffAdmin">
          <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
          <span style="font-size: 16px;" >Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu Staff Admin
       </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                  15  aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Admin Karyawaan</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Gaji & Kas</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Penggajian dan Rekap</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VKasKecil">Pencatatan Kas Kecil</a>
                        <?php if($nama == 'Risa Septiana') { ?> 
                        <a class="collapse-item" style="font-size: 15px;" href="VAset">Aset</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VDokumen">Dokumen</a>
                        <?php } ?>
                        <a class="collapse-item" style="font-size: 15px;" href="VKaryawan">List Karyawan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VBonKaryawan">Bon Karyawan</a>
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
        <?php echo "<a href='VDokumen'><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Pencatatan Dokumen</h5></a>"; ?>

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


      <div class="row">
        <div class="col-md-10">

        </div>
        <div class="col-md-2">
          <!-- Button Input Data Bayar -->
          <div align="right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Catat Dokumen</button> <br> <br>
          </div>
          <!-- Form Modal  -->
          <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg" role ="document">
             <div class="modal-content"> 
              <div class="modal-header">
                <h5 class="modal-title"> Form Pencatatan Dokumen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> 

              <!-- Form Input Data -->
              <div class="modal-body" align="left">
                <?php  echo "<form action='../proses/proses_catat_dok' enctype='multipart/form-data' method='POST'>";  ?>


                <br>

                <div class="form-group">
                  <label>Nomor Rak</label>
                  <input class="form-control form-control-sm" type="text" id="no_rak" name="no_rak" required="">          
                </div>
                <div class="form-group">
                  <label>Nama Dokumen</label>
                  <input class="form-control form-control-sm" type="text" id="nama_dokumen" name="nama_dokumen" required="">          
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label>REF</label>
                    <select id="referensi" name="referensi" class="form-control">
                      <option>CBM</option>
                      <option>MES</option>
                      <option>PBR</option>
                      <option>PBJ</option>
                      <option>BASRI</option>
                      <option>Kebon Lengkiti</option>
                      <option>Kebon Seberuk</option>
                    </select>
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
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Tanggal Input</th>
      <th>REF</th>   
      <th>No Rak</th>
      <th>Nama Dokumen</th>
      <th>File</th>
      <th>Keterangan</th>
      <th>Edit</th>
      <th>Hapus</th>
    </tr>
  </thead>
  <tbody>

    <?php while($data = mysqli_fetch_array($table)){
      $no_dokumen = $data['no_dokumen'];
      $tanggal =$data['tanggal'];
      $referensi =$data['referensi'];
      $no_rak = $data['no_rak'];
      $nama_dokumen = $data['nama_dokumen'];
      $keterangan = $data['keterangan'];
       $file_bukti = $data['file_bukti'];



      echo "<tr>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$referensi</td>
      <td style='font-size: 14px'>$no_rak</td>
      <td style='font-size: 14px'>$nama_dokumen</td>
      <td style='font-size: 14px'>$keterangan</td>
      "; ?>
      

       <?php echo "
         <td style='font-size: 14px'>"; ?> <a download="../file_staff_admin/<?= $file_bukti ?>" href="../file_staff_admin/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>
<?php echo "<td style='font-size: 12px'>"; ?>
      <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_dokumen']; ?>">Edit</button>

      <!-- Form EDIT DATA -->

      <div class="modal fade" id="formedit<?php echo $data['no_dokumen']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role ="document">
          <div class="modal-content"> 
            <div class="modal-header">
              <h5 class="modal-title"> Form Edit Dokumen </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true"> &times; </span>
              </button>
            </div>


            <!-- Form Edit Data -->
            <div class="modal-body">
              <form action="../proses/proses_edit_dok.php" enctype="multipart/form-data" method="POST">


                <div class="form-group">
                  <label> No Rak </label>
                  <input type="text" name="no_rak" class="form-control" value="<?php echo $no_rak; ?>" required=""> 

                </div>
                <input type="hidden" name="no_dokumen" value="<?php echo $no_dokumen;?>"> 
                <div class="form-group">
                  <label>REF</label>
                    <select id="referensi" name="referensi" class="form-control">
                      <?php $dataSelect = $data['referensi']; ?>
                      <option <?php echo ($dataSelect == 'CBM') ? "selected": "" ?> >CBM</option>
                      <option <?php echo ($dataSelect == 'MES') ? "selected": "" ?>  >MES</option>
                      <option <?php echo ($dataSelect == 'PBR') ? "selected": "" ?>  >PBR</option>
                      <option <?php echo ($dataSelect == 'PBJ') ? "selected": "" ?>  >PBJ</option>
                      <option <?php echo ($dataSelect == 'BASRI') ? "selected": "" ?>  >BASRI</option>
                      <option <?php echo ($dataSelect == 'Kebon Lengkiti') ? "selected": "" ?>  >Kebon Lengkiti</option>
                      <option <?php echo ($dataSelect == 'Kebon Seberuk') ? "selected": "" ?>  >Kebon Seberuk</option>
                    </select>            
                </div>
                <div class="form-group">
                  <label>Nama Dokumen</label>
                  <input type="text" name="nama_dokumen" class="form-control"  value="<?php echo $nama_dokumen;?>" required="" >             
                </div>

                <div class="form-group">
                  <label>Keterangan</label>
                  <input type="text" name="keterangan" class="form-control" value="<?php echo $keterangan;?>" required=""> 
                </div>

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




      <?php echo "</td> "; ?>
      <?php echo "<td style='font-size: 12px'>"; ?>

      <button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_dokumen']; ?>" data-toggle='tooltip' title='Hapus Data Dokumen'></button>

      <div class="modal fade" id="PopUpHapus<?php echo $data['no_dokumen']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
       <div class="modal-dialog" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h4 class="modal-title"> <b> Hapus Data Dokumen </b> </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>

          <div class="modal-body">
            <form action="../proses/hapus_dokumen" method="POST">
              <input type="hidden" name="no_dokumen" value="<?php echo $no_dokumen;?>">
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