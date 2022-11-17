
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
if ($jabatan_valid == 'Kasir') {

}

else{  header("Location: logout.php");
exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];



$table = mysqli_query($koneksi, "SELECT * FROM riwayat_peminjaman a INNER JOIN riwayat_penjualan b ON a.no_transaksi=b.no_transaksi INNER JOIN baja c ON c.kode_baja=b.kode_baja");

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Riwayat Peminjaman Toko</title>

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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKasirToko.php">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="margin-top: 50px; height: 110px; width: 120px; " src="../gambar/Logo CBM.PNG" ></div>
</a>
<br> <br>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active" >
    <a class="nav-link" href="DsKasirToko.php">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu Kasir Toko
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Transaksi</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Transaksi</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VPenjualan1">Penjualan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaran1">Pengeluaran</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPembelian1">Pembelian</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan1">Laporan Keuangan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRiwayatDeposit1">Riwayat Deposit</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRiwayatBonPembelian1">Riwayat Bon </a>
            <a class="collapse-item" style="font-size: 15px;" href="VBonKaryawan">Bon Karyawan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Gaji Karyawan</a>
        </div>
    </div>
</li>

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
    aria-expanded="true" aria-controls="collapseUtilities">
    <i class="fas fa-dolly-flatbed" style="font-size: 15px; color:white;"></i>
    <span style="font-size: 15px; color:white;">Pencatatan Inventory</span>
</a>
<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
data-parent="#accordionSidebar">
<div class="bg-white py-2 collapse-inner rounded">
    <h6 class="collapse-header" style="font-size: 15px;">Menu Inventory</h6>
    <a class="collapse-item" href="VInventoryPerusahaan" style="font-size: 15px;">Inventory Perusahaan</a>
    <a class="collapse-item" style="font-size: 15px;" href="VRiwayatPeminjaman1">Riwayat Peminjaman</a>
    <a class="collapse-item" href="VKonfirmasiRetur" style="font-size: 15px;">Konfirmasi Retur</a>
    <a class="collapse-item" href="VKeberangkatan" style="font-size: 15px;">Keberangkatan</a>
    <a class="collapse-item" href="VReturPangkalan" style="font-size: 15px;">Retur Pangkalan</a>
</div>
</div>
</li>
<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilitiesx"
    aria-expanded="true" aria-controls="collapseUtilitiesx">
    <i class="fas fa-clipboard-list" style="font-size: 15px; color:white;"></i>
    <span style="font-size: 15px; color:white;">Administrasi</span>
</a>
<div id="collapseUtilitiesx" class="collapse" aria-labelledby="headingUtilities"
data-parent="#accordionSidebar">
<div class="bg-white py-2 collapse-inner rounded">
    <h6 class="collapse-header" style="font-size: 15px;">Menu Administrasi</h6>
    <a class="collapse-item" style="font-size: 15px;" href="VPangkalan">Pangkalan</a>
    <a class="collapse-item" style="font-size: 15px;" href="VKaryawan">Karyawan</a>
    <a class="collapse-item" style="font-size: 15px;" href="VDriver">Driver</a>
    <a class="collapse-item" href="VRute" style="font-size: 15px;">Rute</a>
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
      <a href="VRiwayatPeminjaman1"><h5 class="text-center sm" style="color:white; margin-top: 8px; ">Riwayat Peminjaman Toko</h5></a>
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

    <!-- Tabel -->    
    <table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
      <thead>
        <tr>
          <th>No</th>
          <th>Tanggal Pinjam</th>
          <th>Tanggal Kembali</th>
          <th>REF</th>
          <th>Nama</th>
          <th>Barang</th>
          <th>QTY Dipinjam</th>
          <th>QTY Kembali</th>
          <th>Status Pinjam</th>
          <th>Keterangan</th>
          <th>File</th>
          <th>Aksi</th>
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
          $no_transaksi = $data['no_transaksi'];
          $tanggal =$data['tanggal'];
          $tanggal_bayar =$data['tanggal_bayar'];
          $referensi = $data['referensi'];
          $nama= $data['nama'];
          $nama_baja = $data['nama_baja'];
          $qty = $data['qty'];
          $qty_kembali = $data['qty_kembali'];
          $status_pinjam = $data['status_pinjam'];
          $keterangan = $data['keterangan'];
          $file_bukti = $data['file_bukti'];



          echo "<tr>
          <td style='font-size: 14px'>$no_transaksi</td>
          <td style='font-size: 14px'>$tanggal</td>
          <td style='font-size: 14px'>$tanggal_bayar</td>
          <td style='font-size: 14px'>$referensi</td>
          <td style='font-size: 14px'>$nama</td>  
          <td style='font-size: 14px'>$nama_baja</td>
          <td style='font-size: 14px'>$qty</td>
          <td style='font-size: 14px'>$qty_kembali</td>
          <td style='font-size: 14px'>$status_pinjam</td>
          <td style='font-size: 14px'>$keterangan</td>
          <td style='font-size: 14px'>"; ?> <a download="../file_toko/<?= $file_bukti ?>" href="../file_toko/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
          "; ?>
          <?php echo "<td style='font-size: 12px'>"; ?>

          <button href="#" type="submit" class="fas fa-clipboard-check  bg-info mr-2 rounded" data-toggle="modal" data-target="#PopUpBalik<?php echo $data['no_transaksi']; ?>" data-toggle='tooltip' title='Balikan Baja'></button>

          <div class="modal fade" id="PopUpBalik<?php echo $data['no_transaksi']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
           <div class="modal-dialog" role ="document">
             <div class="modal-content"> 
              <div class="modal-header">
                <h4 class="modal-title"> <b> Pengembalian Baja </b> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> 
              <?php
              include 'koneksi.php';
          //penjulan
              $no_laporan = $data['no_transaksi'];
              $queryE = mysqli_query($koneksi, "SELECT * FROM riwayat_penjualan where no_transaksi = '$no_laporan'");
              $dataE = mysqli_fetch_array($queryE);
          //pinjam
              $no_laporan2 = $data['no_pinjam'];
              $queryP = mysqli_query($koneksi, "SELECT * FROM riwayat_peminjaman where no_pinjam = '$no_laporan2'");
              $dataP = mysqli_fetch_array($queryP);
              ?>
              <!-- Form Input Data -->
              <div class="modal-body" align="left">
                <?php  echo "<form action='../proses/end_pinjam' enctype='multipart/form-data' method='POST'>";  ?>

                <div class="row">
                  <div class="col-md-6">

                    <input type="hidden" name="no_laporan" value="<?php echo $dataE['no_transaksi'];?>">
                    <input type="hidden" name="no_pinjam" value="<?php echo $dataP['no_pinjam'];?>">
                    <div>
                      <label>Tanggal</label>
                      <input type="date" id="tanggal1" name="tanggal_kembali" required="">
                    </div>
                  </div>
                  <script>
                   $(document) .ready(function(){

                    var dtToday = new Date();

                    var month = dtToday.getMonth() +1;
                    var day = dtToday.getDate();
                    var year = dtToday.getFullYear();
                    if (month < 10)
                      month = '0' + month.toString();
                    if (day < 10)
                      day = '0' + day.toString();

                    var maxDate = year + '-' + month + '-' +day;

                    $('#tanggal1').attr('min',maxDate);

                  })
                </script>       
                <div class="col-md-6">
                  <label>QTY Kembali</label>
                  <input type="number" name="qty_kembali">
                </div>
              </div>
              <div class="row">

                <div class="col-md-6">
                 <label>Barang Kembali</label>
                 <select id="nama_baja_kembali" name="nama_baja_kembali" class="form-control ">
                  <option>Elpiji 3 Kg Baja + Isi</option>
                  <option>Elpiji 3 Kg Baja Kosong </option>
                  <option>Elpiji 12 Kg Baja + Isi</option>
                  <option>Elpiji 12 Kg Baja Kosong </option>
                  <option>Bright Gas 5,5 Kg Baja + Isi</option>
                  <option>Bright Gas 5,5 Kg Baja Kosong</option>
                  <option>Bright Gas 12 Kg Baja + Isi</option>
                  <option>Bright Gas 12 Kg Baja Kosong</option>
                </select>
              </div>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Kembalikan</button>
              <button type="reset" class="btn btn-danger">RESET</button>
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