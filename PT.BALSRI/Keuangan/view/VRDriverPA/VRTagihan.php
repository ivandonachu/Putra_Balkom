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
if ($jabatan_valid == 'Keuangan') {

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
 $no_polisilr = $_GET['no_polisi'];
} 

elseif (isset($_POST['tanggal1'])) {
 $tanggal_awal = $_POST['tanggal1'];
 $tanggal_akhir = $_POST['tanggal2'];
}  

if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksibalsri_jbb, "SELECT * FROM tagihan_pa a INNER JOIN master_tarif_pa b ON a.delivery_point=b.delivery_point WHERE tanggal = '$tanggal_awal' AND mt = '$no_polisilr'" );

  $table2 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_pa a INNER JOIN master_tarif_pa b ON a.delivery_point=b.delivery_point  WHERE tanggal = '$tanggal_awal' AND mt = '$no_polisilr'");
  $data2 = mysqli_fetch_array($table2);
  $total_tagihan= $data2['total_tagihan'];
  $total_jt= $data2['total_jt'];
  $total_rit= $data2['total_rit'];

}

else{
  $table = mysqli_query($koneksibalsri_jbb, "SELECT * FROM tagihan_pa a INNER JOIN master_tarif_pa b ON a.delivery_point=b.delivery_point WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND mt = '$no_polisilr' ORDER BY a.tanggal");
  $table2 = mysqli_query($koneksibalsri_jbb, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_pa a INNER JOIN master_tarif_pa b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND mt = '$no_polisilr'");
  $data2 = mysqli_fetch_array($table2);
  $total_tagihan= $data2['total_tagihan'];
  $total_jt= $data2['total_jt'];
  $total_rit= $data2['total_rit'];

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

  <title>Tagihan Angkutan <?= $no_polisilr; ?> (Padalarang)</title>

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
    <div class="sidebar-brand-text mx-3" > <img style="height: 65px; width: 220px;" src="../gambar/Logo CBM.jpg" ></div>
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
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
      15  aria-expanded="true" aria-controls="collapseOne">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >LR Kendaraan</span>
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

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>


        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
            aria-labelledby="searchDropdown">
            <form class="form-inline mr-auto w-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small"
                    placeholder="Search for..." aria-label="Search"
                    aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </li>




    <div class="topbar-divider d-none d-sm-block"></div>

   <!-- Nav Item - User Information -->
    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php $foto_profile = $data1['foto_profile']; ?>
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


    
    <div>
    <div align="left">
      <?php echo "<a href='../VLRKendaraanPA?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&no_polisi=$no_polisilr'><button type='button' class='btn btn-primary'>Kembali</button></a>"; ?>
    </div>
    </div>
  
  
  <div class="row">
    <div class="col-md-6">
     <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
   </div>
   
</div>





<!-- Tabel -->    
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>SO</th>
      <th>LO</th>
      <th>Delivery Point</th>
      <th>Alamat</th>
      <th>Jumlah Pemesanan</th>
      <th>Jarak Tempuh</th>
      <th>AMT</th>
      <th>MT</th>
      <th>Harga</th>
      <th>Total</th>    
      <th>File</th>
 
    </tr>
  </thead>
  <tbody>
    <?php
    $total_max_pesanan = 0;
    $urut = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>

    <?php while($data = mysqli_fetch_array($table)){
      $no_tagihan = $data['no_tagihan'];
      $tanggal =$data['tanggal'];
      $so = $data['so'];
      $lo = $data['lo'];
      $delivery_point = $data['delivery_point'];
      $alamat = $data['alamat'];
      $jumlah_pesanan = $data['jumlah_pesanan'];
      $jt = $data['jt'];
      $amt = $data['amt'];
      $mt = $data['mt'];
      $total = $data['total'];
      $file_bukti = $data['file_bukti'];
      if ($jumlah_pesanan == 'kl1') {
        $total_pesanan = 1000;
        $total_max_pesanan = $total_max_pesanan + $total_pesanan;
      }
      else if ($jumlah_pesanan == 'kl2') {
        $total_pesanan = 2000;
        $total_max_pesanan = $total_max_pesanan + $total_pesanan;
      }
      else if ($jumlah_pesanan == 'kl3') {
        $total_pesanan = 3000;
        $total_max_pesanan = $total_max_pesanan + $total_pesanan;
      }
      else if ($jumlah_pesanan == 'kl4') {
        $total_pesanan = 4000;
        $total_max_pesanan = $total_max_pesanan + $total_pesanan;
      }
      else if ($jumlah_pesanan == 'kl5') {
        $total_pesanan = 5000;
        $total_max_pesanan = $total_max_pesanan + $total_pesanan;
      }
      $harga = $data[$jumlah_pesanan];
      

 $urut = $urut + 1;

      echo "<tr>
      <td style='font-size: 14px'>$urut</td>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$so</td>
      <td style='font-size: 14px'>$lo</td>
      <td style='font-size: 14px'>$delivery_point</td>
      <td style='font-size: 14px'>$alamat</td>
      <td style='font-size: 14px'>$total_pesanan/L</td>
      <td style='font-size: 14px'>$jt</td>
      <td style='font-size: 14px'>$amt</td>
      <td style='font-size: 14px'>$mt</td>
      <td style='font-size: 14px'>";?> <?= formatuang($harga); ?> <?php echo "</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($total); ?> <?php echo "</td>
      <td style='font-size: 14px'>"; ?> <a download="/BALSRI_JBB/Administrasi/file_administrasi/<?= $file_bukti ?>" href="/BALSRI_JBB/Administrasi//file_administrasi/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>
    

<?php echo  "</tr>";
}
?>

</tbody>
</table>
</div>
<br>
<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Tagihan</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_tagihan)  ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Ritase</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_rit  ?></div>
          </div>
          <div class="col-auto">
            <i class=" fas fa-truck-moving fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total KM</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_jt  ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-road fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Pesanan</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$total_max_pesanan?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
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
    var table = $('#example').DataTable( {
      lengthChange: false,
      buttons: [ 'copy', 'excel', 'csv', 'pdf', 'colvis' ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>
<script>
  function createOptions(number) {
    var options = [], _options;

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

  $('#special').on('click', function () {
    mySelect.find('option:selected').prop('disabled', true);
    mySelect.selectpicker('refresh');
  });

  $('#special2').on('click', function () {
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