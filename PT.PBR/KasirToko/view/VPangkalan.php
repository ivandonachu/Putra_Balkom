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


$table = mysqli_query($koneksi, "SELECT * FROM pangkalan");
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>List Pangkalan</title>

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
            <a class="collapse-item" style="font-size: 15px;" href="VPenggunaanSaldo">Laporan Saldo</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRiwayatDeposit1">Riwayat Deposit</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRiwayatBonPembelian1">Riwayat Bon </a>
            <a class="collapse-item" style="font-size: 15px;" href="VBonKaryawan">Bon Karyawan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Gaji Karyawan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitDriverMES">Laporan Rit MES</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitDriverPBR">Laporan Rit PBR</a>
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
      <?php echo "<a href='VListPangkalan'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>List Pangkalan</h5></a>"; ?>
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
        <!-- Button Input Data -->
        <div align="right">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Input Pangkalan </button> <br> <br>
        </div>
        <div class="modal fade" id="input" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
         <div class="modal-dialog" role ="document">
           <div class="modal-content"> 
            <div class="modal-header">
              <h5 class="modal-title"> Form Input Pangkalan </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div> 

            <!-- Form Input Data -->
            <div class="modal-body" align="left">
              <form action="../proses/proses_pangkalan" method="POST">
                <div class="row">
                  <div class="col-md-6">
                    <label>No Registrasi</label>
                    <input type="text" name="no_reg" class="form-control" placeholder="Masukkan No Registrasi..." required="" >       
                  </div>
                  <div class="col-md-6">
                    <label>Sub Penyalur</label>
                    <input type="text" name="sub_penyalur" class="form-control" placeholder="Masukkan Nama..." required="">      
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-6">
                    <label>Type</label>
                    <input type="text" name="type" class="form-control" placeholder="Masukkan Jabatan..." required=""> 
                  </div>
                  <div class="col-md-6">
                   <label>Pemilik</label>
                   <input type="text" name="pemilik" class="form-control" placeholder="Masukkan Nama..." required="">
                 </div>
               </div>
               <br>
               <div class="row">
                <div class="col-md-6">
                 <label>No HP Pemilik</label>
                 <input type="text" name="no_hp_pemilik" class="form-control" placeholder="Masukkan Jabatan..." required=""> 
               </div>
               <div class="col-md-6">
                 <label>No KTP</label>
                 <input type="text" name="no_ktp" class="form-control" placeholder="Masukkan Nama..." required="">        
               </div>
             </div>
             <br>
             <div class="row">
              <div class="col-md-6">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" placeholder="Masukkan Jabatan..." required=""> 
              </div>
              <div class="col-md-6">
               <label>No Kantor</label>
               <input type="text" name="no_kantor" class="form-control" placeholder="Masukkan Nama..." required=""> 
             </div>
           </div>
           <br>
           <div class="row">
            <div class="col-md-6">
              <label>SP Agen</label>
              <input type="text" name="sp_agen" class="form-control" placeholder="Masukkan Jabatan..." required=""> 
            </div>
            <div class="col-md-6">
              <label>Se LPG</label>
              <input type="text" name="se_lpg" class="form-control" placeholder="Masukkan Nama..." required="">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-6">
              <label>QTY Kontrak</label>
              <input type="text" name="qty_kontrak" class="form-control" placeholder="Masukkan Jabatan..." required=""> 
            </div>
            <div class="col-md-6">
             <label>Kode Pos</label>
             <input type="text" name="kode_pos" class="form-control" placeholder="Masukkan Nama..." required="">    
           </div>
         </div>
         <br>
         <div class="row">
          <div class="col-md-6">
            <label>Latitude</label>
            <input type="text" name="latitude" class="form-control" placeholder="Masukkan Jabatan..." required=""> 
          </div>
          <div class="col-md-6">
            <label>Longtitude</label>
            <input type="text" name="longtitude" class="form-control" placeholder="Masukkan Nama..." required="">    
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-6">
           <label>Status</label>
           <input type="text" name="status" class="form-control" placeholder="Masukkan Jabatan..." required=""> 
         </div>
         <div class="col-md-6">
           <label>Tipe Pembayaran</label>
           <input type="text" name="tipe_pembayaran" class="form-control" placeholder="Masukkan Nama..." required="">
         </div>
       </div>
       <br>
       
       

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
</div>


<!-- Tabel -->    
<div style="overflow-x: auto">
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th style="font-size: 11px" scope="col">No Registrasi Agen</th>
      <th style="font-size: 11px" scope="col">Sub Penyalur</th>
      <th style="font-size: 11px" scope="col">Type</th>
      <th style="font-size: 11px" scope="col">Nama Pemilik</th>
      <th style="font-size: 11px" scope="col">No Hp</th>
      <th style="font-size: 11px" scope="col">No KTP</th>
      <th style="font-size: 11px" scope="col">alamat</th>     
      <th style="font-size: 11px" scope="col">No Kantor</th>
      <th style="font-size: 11px" scope="col">SP Agen</th>
      <th style="font-size: 11px" scope="col">SE LPG</th>
      <th style="font-size: 11px" scope="col">QTY Kontrak</th>
      <th style="font-size: 11px" scope="col">Kode Pos</th>
      <th style="font-size: 11px" scope="col">Latitude</th>
      <th style="font-size: 11px" scope="col">Longtitude</th>
      <th style="font-size: 11px" scope="col">Status</th>
      <th style="font-size: 11px" scope="col">Tipe Pembayaran</th>
      <th style="font-size: 11px" scope="col"></th>


    </tr>
  </thead>
  <tbody>

    <?php while($data = mysqli_fetch_array($table)){
      $no_reg = $data['no_registrasi'];
      $sub_penyalur = $data['sub_penyalur'];
      $type = $data['type'];
      $pemilik = $data['pemilik'];
      $no_hp_pemilik = $data['no_hp_pemilik'];
      $no_ktp = $data['no_ktp'];
      $alamat = $data['alamat'];
      $no_kantor = $data['no_kantor'];
      $sp_agen = $data['sp_agen'];
      $se_lpg = $data['se_lpg'];
      $qty_kontrak = $data['qty_kontrak'];
      $kode_pos = $data['kode_pos'];
      $latitude = $data['latitude'];
      $longtitude = $data['longtitude'];
      $status = $data['status'];
      $tipe_pembayaran = $data['tipe_pembayaran'];


      echo "<tr>
      <td style='font-size: 12px'>$no_reg</td>
      <td style='font-size: 12px'>$sub_penyalur</td>
      <td style='font-size: 12px'>$type</td>
      <td style='font-size: 12px'>$pemilik</td>
      <td style='font-size: 12px'>$no_hp_pemilik</td>
      <td style='font-size: 12px'>$no_ktp</td>
      <td style='font-size: 12px'>$alamat</td>
      <td style='font-size: 12px'>$no_kantor</td>
      <td style='font-size: 12px'>$sp_agen</td>
      <td style='font-size: 12px'>$se_lpg</td>
      <td style='font-size: 12px'>$qty_kontrak</td>
      <td style='font-size: 12px'>$kode_pos</td>
      <td style='font-size: 12px'>$latitude</td>
      <td style='font-size: 12px'>$longtitude</td>
      <td style='font-size: 12px'>$status</td>
      <td style='font-size: 12px'>$tipe_pembayaran</td>
      <td style='font-size: 12px'>"; ?>

      <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_registrasi']; ?>">Edit</button>

      <!-- Form EDIT DATA -->

      <div class="modal fade" id="formedit<?php echo $data['no_registrasi']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
       <div class="modal-dialog" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h5 class="modal-title"> Form Edit Pangkalan </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>

          <?php
          include 'koneksi.php';
          $id_edit = $data['no_registrasi'];
          $queryE = mysqli_query($koneksi, "SELECT * FROM pangkalan where no_registrasi = '$id_edit'");
          $dataE = mysqli_fetch_array($queryE);
          ?> 

          <!-- Form Edit Data -->
          <div class="modal-body">
            <form action="../proses/edit_pangkalan" method="POST">
              
              <div class="row">
                <div class="col-md-6">
                  <label> ID Karyawan </label>
                  <input type="text" name="no_reg" class="form-control" value="<?php echo $dataE['no_registrasi'] ?>" disabled=""> 
                  <input type="hidden" name="no_reg" value="<?php echo $dataE['no_registrasi'];?>">
                </div>
                <div class="col-md-6">
                  <label>Sub Penyalur</label>
                  <input type="text" name="sub_penyalur" class="form-control" value="<?php echo $dataE['sub_penyalur'] ?>" required="" > 
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6">
                  <label>Type</label>
                  <input type="text" name="type" class="form-control" value="<?php echo $dataE['type'] ?>" disabled=""> 
                  <input type="hidden" name="type" value="<?php echo $dataE['type'];?>">         
                </div>
                <div class="col-md-6">
                 <label>Nama Pemilik</label>
                 <input type="text" name="pemilik" class="form-control" value="<?php echo $dataE['pemilik'] ?>" required=""> 
               </div>
             </div>
             <br>
             <div class="row">
              <div class="col-md-6">
               <label>No HP Pemilik</label>
               <input type="text" name="no_hp_pemilik" class="form-control" value="<?php echo $dataE['no_hp_pemilik'] ?>" required=""> 
             </div>
             <div class="col-md-6">
               <label>No KTP</label>
               <input type="text" name="no_ktp" class="form-control" value="<?php echo $dataE['no_ktp'] ?>" required=""> 
             </div>
           </div>
           <br>
           <div class="row">
            <div class="col-md-6">
              <label>Alamat</label>
              <input type="text" name="alamat" class="form-control" value="<?php echo $dataE['alamat'] ?>" required=""> 
            </div>
            <div class="col-md-6">
             <label>No Kantor</label>
             <input type="text" name="no_kantor" class="form-control" value="<?php echo $dataE['no_kantor'] ?>" required=""> 
           </div>
         </div>
         <br>
         <div class="row">
          <div class="col-md-6">
           <label>SP Agen</label>
           <input type="text" name="sp_agen" class="form-control" value="<?php echo $dataE['sp_agen'] ?>" disabled=""> 
           <input type="hidden" name="sp_agen" value="<?php echo $dataE['sp_agen'];?>">    
         </div>
         <div class="col-md-6">
           <label>Se LPG</label>
           <input type="text" name="se_lpg" class="form-control" value="<?php echo $dataE['se_lpg'] ?>" disabled=""> 
           <input type="hidden" name="se_lpg" value="<?php echo $dataE['se_lpg'];?>">  
         </div>
       </div>
       <br>
       <div class="row">
        <div class="col-md-6">
         <label>QTY Kontrak</label>
         <input type="text" name="qty_kontrak" class="form-control" value="<?php echo $dataE['qty_kontrak'] ?>" required=""> 
       </div>
       <div class="col-md-6">
         <label>Kode Pos</label>
         <input type="text" name="kode_pos" class="form-control" value="<?php echo $dataE['kode_pos'] ?>" required=""> 
       </div>
     </div>
     <br>
     <div class="row">
      <div class="col-md-6">
       <label>Latitude</label>
       <input type="text" name="latitude" class="form-control" value="<?php echo $dataE['latitude'] ?>" required=""> 
     </div>
     <div class="col-md-6">
      <label>Longtitude</label>
      <input type="text" name="longtitude" class="form-control" value="<?php echo $dataE['longtitude'] ?>" required=""> 
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-6">
     <label>Status</label>
     <input type="text" name="status" class="form-control" value="<?php echo $dataE['status'] ?>" required=""> 
   </div>
   <div class="col-md-6">
     <label>Tipe Pembayaran</label>
     <input type="text" name="tipe_pembayaran" class="form-control" value="<?php echo $dataE['tipe_pembayaran'] ?>" required=""> 
   </div>
 </div>
 <br>
 

 <div class="modal-footer">
  <button type="submit" class="btn btn-primary"> Ubah </button>
  <button type="reset" class="btn btn-danger"> RESET</button>
</div>
</form>
</div>
</div>
</div>
</div>


<?php echo "
</td>
</tr>";
}
?>

</tbody>
</table>
</div>
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