<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
  header("Location: logout.php");
  exit;
}
$id = $_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account WHERE id_karyawan = '$id'");
$data1 = mysqli_fetch_array($result1);
$id1 = $data1['id_karyawan'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Keuangan') {
} else {
  header("Location: logout.php");
  exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];




if (isset($_GET['tanggal1'])) {
  $tanggal_awal = $_GET['tanggal1'];
  $tanggal_akhir = $_GET['tanggal2'];
  $no_polisilr = $_GET['no_polisi'];
} elseif (isset($_POST['tanggal1'])) {
  $tanggal_awal = $_POST['tanggal1'];
  $tanggal_akhir = $_POST['tanggal2'];
}

if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksi, "SELECT  SUM(um) AS uang_makan FROM pengiriman_bk a  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
} else {
  $table = mysqli_query($koneksi, "SELECT SUM(a.ug) AS uang_gaji , b.nama_driver FROM pengiriman_bk a INNER JOIN driver b ON a.no_driver=b.no_driver INNER JOIN kendaraan c ON c.no=a.no 
                            WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND c.no_polisi = '$no_polisilr' GROUP BY b.nama_driver ");
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

  <title>Rincian Gaji Driver <?= $no_polisilr; ?> (Belitung)</title>

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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="/bootstrap-select/dist/css/bootstrap-select.css">

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
        <div class="sidebar-brand-text mx-3"> <img style="height: 65px; width: 220px;" src="../gambar/Logo CBM.jpg"></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="DsAdministrasi">
          <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
          <span style="font-size: 16px;">Dashboard</span></a>
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
          15 aria-expanded="true" aria-controls="collapseOne">
          <i class="fas fa-cash-register" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">LR Kendaraan</span>
        </a>
        <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">LR Kendaraan</h6>
            <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugi2">LR Kendaraan Lampung</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugiP2">LR Kendaraan Sumsel</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugiBr">LR Kendaraan Baturaja</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugiBl">LR Kendaraan Belitung</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugiBk">LR Kendaraan Bangka</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugi">LR Kendaraan Bengkulu</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugiPA">LR Kendaraan Padlarang</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugiPL">LR Kendaraan Plumpang</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugiTG">LR Kendaraan Tj Gerem</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VLabaRugiUB">LR Kendaraan Uj Berung</a>
          </div>
        </div>
      </li>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse2"
          15 aria-expanded="true" aria-controls="collapse2">
          <i class="fas fa-cash-register" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">Data PBJ</span>
        </a>
        <div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Data PBJ</h6>
            <a class="collapse-item" style="font-size: 15px;" href="../VPenebusan">Penebusan PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VPenjualan">Penjualan Ety</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VPenjualanL">Penjualan Agus</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VKeuangan">Keuangan Ety</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VKeuanganL">Keuangan Agus</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VPengiriman">Pengiriman Ety</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VPengirimanL">Pengiriman Agus</a>
            <a class="collapse-item" style="font-size: 15px;" href="../VLStokGudang">Laporan Stok Gudang</a>
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
          <?php echo "<a href='VRMakantanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Rincian Gaji Driver $no_polisilr (Bangka)</h5></a>"; ?>

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
                <span class="mr-2 d-none d-lg-inline  small" style="color:white;"><?php echo "$nama"; ?></span>
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



            <div>
              <div align="left">
                <?php echo "<a href='../VLRKendaraanBk?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&no_polisi=$no_polisilr'><button type='button' class='btn btn-primary'>Kembali</button></a>"; ?>
              </div>
            </div>


            <div class="row">
              <div class="col-md-6">
                <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
              </div>

            </div>





            <!-- Tabel -->
            <h5 class="text-center">Uang Gaji Berdasarkan Driver</h5>
            <table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
              <thead>
                <tr>
                  <th>Nama Driver</th>
                  <th>Jumlah Gaji</th>
                  <th>Total Gaji</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $total = 0;
                function formatuang($angka)
                {
                  $uang = "Rp " . number_format($angka, 2, ',', '.');
                  return $uang;
                }

                ?>

                <?php while ($data = mysqli_fetch_array($table)) {
                  $uang_gaji = $data['uang_gaji'];
                  $nama_driver = $data['nama_driver'];
                  $total = $total + $uang_gaji;

                  echo "<tr>
     
      <td style='font-size: 14px'>$nama_driver</td>
      <td style='font-size: 14px'>" ?> <?= formatuang($uang_gaji); ?> <?php echo "</td>
      <td style='font-size: 14px'>" ?> <?= formatuang($total); ?> <?php echo "</td>
      
 </tr>";
                                                                }
                                                                  ?>

              </tbody>
            </table>
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
  <script src="/sbadmin/vendor/bootstrap/js/bootstrap.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="/sbadmin/js/sb-admin-2.min.js"></script>
  <script src="/bootstrap-select/dist/js/bootstrap-select.js"></script>
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
      var table = $('#example').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'csv', 'pdf', 'colvis']
      });

      table.buttons().container()
        .appendTo('#example_wrapper .col-md-6:eq(0)');
    });
  </script>
  <script>
    function createOptions(number) {
      var options = [],
        _options;

      for (var i = 0; i < number; i++) {
        var option = '<option value="' + i + '">Option ' + i + '</option>';
        options.push(option);
      }

      _options = options.join('');

      $('#number')[0].innerHTML = _options;
      $('#number-multiple')[0].innerHTML = _options;

      $('#number2')[0].innerHTML = _options;
      $('#number2-multiple')[0].innerHTML = _options;
    }

    var mySelect = $('#first-disabled2');

    createOptions(4000);

    $('#special').on('click', function() {
      mySelect.find('option:selected').prop('disabled', true);
      mySelect.selectpicker('refresh');
    });

    $('#special2').on('click', function() {
      mySelect.find('option:disabled').prop('disabled', false);
      mySelect.selectpicker('refresh');
    });

    $('#basic2').selectpicker({
      liveSearch: true,
      maxOptions: 1
    });
  </script>
</body>

</html>