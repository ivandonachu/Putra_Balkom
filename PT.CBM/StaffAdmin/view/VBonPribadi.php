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
  $table = mysqli_query($koneksi, "SELECT * FROM bon_pribadi a INNER JOIN karyawan b ON a.id_karyawan = b.id_karyawan INNER JOIN kode_akun c ON c.kode_akun = a.kode_akun WHERE tanggal_bon = '$tanggal_awal'");
  $table2 = mysqli_query($koneksi, "SELECT * FROM riwayat_bon_pribadi a INNER JOIN bon_pribadi b ON b.no_bon=a.no_bon INNER JOIN karyawan c ON c.id_karyawan=b.id_karyawan WHERE tanggal_bon = '$tanggal_awal' ");
}
else{
  $table = mysqli_query($koneksi, "SELECT * FROM bon_pribadi a INNER JOIN karyawan b ON a.id_karyawan = b.id_karyawan INNER JOIN kode_akun c ON c.kode_akun = a.kode_akun WHERE tanggal_bon BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
  $table2 = mysqli_query($koneksi, "SELECT * FROM riwayat_bon_pribadi a INNER JOIN bon_pribadi b ON b.no_bon=a.no_bon INNER JOIN karyawan c ON c.id_karyawan=b.id_karyawan WHERE tanggal_bon BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
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

  <title>Bon Pribadi Karyawan</title>

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
                        <a class="collapse-item" style="font-size: 15px;" href="VBonKaryawan">Bon Bulanan Karyawan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VBonPribadi">Bon Pribadi Karyawan</a>
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
        <?php echo "<a href='VBonKaryawan'><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Bon Pribadi Karyawan</h5></a>"; ?>
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
   
   <div class="col-md-12">

    <!-- Button Input Data Bayar -->
    <div align="right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Catat Bon </button> <br> <br>
    </div>
    <!-- Form Modal  -->
    <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role ="document">
       <div class="modal-content"> 
        <div class="modal-header">
          <h5 class="modal-title"> Form Pengeluaran </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> 

        <!-- Form Input Data -->
        <div class="modal-body" align="left">
          <?php  echo "<form action='../proses/proses_bon_pribadi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

         <div class="row">
            <div class="col-md-6">

              <label>Tanggal Menghutang</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal_bon" name="tanggal_bon" required="">
             </div>
                 

          </div>
          <div class="col-md-6">

          <label>Tanggal Angsuran</label>
          <div class="col-sm-10">
          <input type="date" id="tanggal_angsuran" name="tanggal_angsuran" required="">
          </div>
            

          </div>
         
        </div>


      <br>

      <div class="row">

        <div class="col-md-6">
          <label>Nama</label>
          <select id="nama" name="nama" class="form-control">
            <?php
            include 'koneksi.php';
            $result = mysqli_query($koneksi, "SELECT * FROM karyawan");   

            while ($data2 = mysqli_fetch_array($result)){
              $data_pangakalan = $data2['nama_karyawan'];

           
                echo "<option> $data_pangakalan </option> ";
        
            }
            ?>
             <?php
            include 'koneksi.php';
            $result = mysqli_query($koneksi, "SELECT * FROM driver");   

            while ($data2 = mysqli_fetch_array($result)){
              $data_pangakalan = $data2['nama_driver'];

          
                echo "<option> $data_pangakalan </option> ";
           
            }
            ?>
          </select>
        </div>    

        <div class="col-md-6">
          <label>Pembayaran</label>
          <select id="pembayaran" name="pembayaran" class="form-control">
            <option>Cash</option>
            <option>Transfer</option>
          </select>
        </div>                

      </div>

      <br>

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

     <div class="form-group">
      <label>Jumlah BON</label>
      <input class="form-control form-control-sm" type="number" id="jumlah" name="jumlah" required="">          
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

      
     <?php  echo "<form  method='POST' action='VBonPribadi' style='margin-bottom: 15px;'>" ?>
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
    <div class="col-md-8">
     <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
   </div>
 </div>


 <!-- Tabel -->    
 <div style="overflow-x: auto" align = 'center'>
  <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal Bon</th>
      <th>Tanggal Angsuran</th>
      <th>Tanggal Terakhir Mengangsur</th>
      <th>Nama Karyawan</th>
      <th>Total Bon</th>
      <th>Total Bayar</th>
      <th>Jumlah Angsuran</th>
      <th>Status Hutang</th>
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
      $no_bon = $data['no_bon'];
      $tanggal_bon =$data['tanggal_bon'];
      $tanggal_angsur =$data['tanggal_angsuran'];
      $total_bayar = $data['total_bayar'];
      $nama_akun = $data['nama_akun'];
      $nama_karyawan = $data['nama_karyawan'];
      $keterangan = $data['keterangan'];
      $jumlah_bon = $data['jumlah_bon'];
      $jumlah_angsuran = $data['jumlah_angsuran'];
      $file_bukti = $data['file_bukti'];
      $status_hutang = $data['status_bayar'];

      $sql_riw_bon = mysqli_query($koneksi, "SELECT tanggal_bayar FROM riwayat_bon_pribadi WHERE no_bon = '$no_bon' ORDER BY no_riwayat DESC LIMIT 1");
      $data_riw_bon = mysqli_fetch_assoc($sql_riw_bon);
      if( !isset($data_riw_bon['tanggal_bayar'])){
        $tanggal_bayar = '-';
      }
      else{
        $tanggal_bayar = $data_riw_bon['tanggal_bayar'];
      }
     
      


      echo "<tr>
      <td style='font-size: 14px'>$no_bon </td>
      <td style='font-size: 14px'>$tanggal_bon</td>
      <td style='font-size: 14px'>$tanggal_angsur</td>
      <td style='font-size: 14px'>$tanggal_bayar</td>
      <td style='font-size: 14px'>$nama_karyawan</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($jumlah_bon); ?> <?php echo "</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($total_bayar); ?> <?php echo "</td>
      <td style='font-size: 14px'>$jumlah_angsuran</td>
      <td style='font-size: 14px'>$status_hutang</td>
      <td style='font-size: 14px'>$keterangan</td>
      <td style='font-size: 14px'>"; ?> <a download="../file_staf_admin/<?= $file_bukti ?>" href="../file_staf_admin/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>
      <?php echo "<td style='font-size: 12px'>"; ?>

      <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_bon']; ?>">Bayar</button>

      <!-- Form EDIT DATA -->

      <div class="modal fade" id="formedit<?php echo $data['no_bon']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role ="document">
          <div class="modal-content"> 
            <div class="modal-header">Form Bayar BON </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true"> &times; </span>
              </button>
            </div>


            <!-- Form Edit Data -->
            <div class="modal-body">
              <form action="../proses/end_bon_pribadi" enctype="multipart/form-data" method="POST">


               <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
               <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir;?>">
               <input type="hidden" name="no_bon" value="<?php echo $no_bon;?>">
               <input type="hidden" name="jumlah_bon" value="<?php echo $jumlah_bon;?>">
               <input type="hidden" name="total_bayar" value="<?php echo $total_bayar;?>">
               <input type="hidden" name="jumlah_angsuran" value="<?php echo $jumlah_angsuran;?>">

               <div class="row">
                <div class="col-md-6">
                  <label>Tanggal</label>
                  <div class="col-sm-10">
                   <input type="date" id="tanggal" name="tanggal"  value="<?php echo $tanggal;?>" required="">
                 </div>
               </div>
               <div class="col-md-6">
                <label>Jumlah</label>
                <input class="form-control form-control-sm" type="number" id="jumlah_bayar" name="jumlah_bayar"  value="0"  required="">
               </div>
             </div>


            <div>
              <label>Upload File</label> 
              <input type="file" name="file"> 
            </div> 


            <div class="modal-footer">
              <button type="submit" class="btn btn-primary"> Bayar </button>
              <button type="reset" class="btn btn-danger"> RESET</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_bon']; ?>" data-toggle='tooltip' title='Hapus Pengeluaran'></button>

      <div class="modal fade" id="PopUpHapus<?php echo $data['no_bon']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
       <div class="modal-dialog" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h4 class="modal-title"> <b> Hapus Bon</b> </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>


          <div class="modal-body">
            <form action="../proses/hapus_bon_pribadi" method="POST">
              <input type="hidden" name="no_laporan" value="<?php echo $no_bon ?>">
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


<br><br><br>

<div style="overflow-x: auto" align = 'center' >
<h3>Riwayat Penycilan Bon Pribadi</h3>
  <table id="example3" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal Ngansur</th>
      <th>Nama</th>
      <th>Jumlah Bayar</th>
      <th>agsuran ke</th>
      <th></th>
     
    </tr>
  </thead>
  <tbody>
  <?php

    $no_urut = 0;
         
  ?>

    <?php while($data = mysqli_fetch_array($table2)){
      $no_riwayat = $data['no_riwayat'];
      $tanggal_bayar =$data['tanggal_bayar'];
      $nama_karyawan = $data['nama_karyawan'];
      $angsuran_ke = $data['angsuran_ke'];
      $jumlah_bon = $data['jumlah_bon'];
      $jumlah_bayar = $data['jumlah_bayar'];
      $total_bayar = $data['total_bayar'];
      $no_bon = $data['no_bon'];
      $jumlah_angsuran = $data['jumlah_angsuran'];
      $no_urut = $no_urut + 1;

      echo "<tr>
      <td style='font-size: 14px'>$no_urut</td>
      <td style='font-size: 14px'>$tanggal_bayar</td>
      <td style='font-size: 14px'>$nama_karyawan</td>
      <td style='font-size: 14px'>";?> <?= formatuang($jumlah_bayar); ?> <?php echo "</td>
      <td style='font-size: 14px'>$angsuran_ke</td>
      "; ?>
      <?php echo "<td style='font-size: 12px'>"; ?>
      <button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_riwayat']; ?>" data-toggle='tooltip' title='Hapus Transaksi'></button>
     

      <div class="modal fade" id="PopUpHapus<?php echo $data['no_riwayat']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
       <div class="modal-dialog" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h4 class="modal-title"> <b> Hapus </b> </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>
          <div class="modal-body">
            <form action="../proses/hapus_riwayat_bon_pribadi" method="POST">
              <input type="hidden" name="no_riwayat" value="<?php echo $no_riwayat; ?>">
              <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
              <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir;?>">
              <input type="hidden" name="no_bon" value="<?php echo $no_bon;?>">
               <input type="hidden" name="jumlah_bon" value="<?php echo $jumlah_bon;?>">
               <input type="hidden" name="jumlah_bayar" value="<?php echo $jumlah_bayar;?>">
               <input type="hidden" name="total_bayar" value="<?php echo $total_bayar;?>">
               <input type="hidden" name="jumlah_angsuran" value="<?php echo $jumlah_angsuran;?>">

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