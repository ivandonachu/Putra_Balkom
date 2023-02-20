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
if ($jabatan_valid == 'Administrasi') {

}

else{  header("Location: logout.php");
exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];




$table = mysqli_query($koneksi, "SELECT * FROM master_tarif_pl ");


?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Master Tarif</title>

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
        <span style="font-size: 15px; color:white;" >Tagihan</span>
    </a>
    <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Tagihan</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanTG">Tagihan Tanjung Gerem</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanTG8KL">Tagihan Tanjung Gerem 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanPA">Tagihan Padalarang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanPL">Tagihan Plumpang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanUB">Tagihan Ujung Berung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanUB">Tagihan Balongan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifTG">Master Tarif TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifTG8KL">Master Tarif TG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifPA">Master Tarif PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifPL">Master Tarif PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifUB">Master Tarif UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBA">Master Tarif BA</a>
        </div>
    </div>
</li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Pengiriman</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Pengiriman</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanTG">Pengiriman TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanTG8KL">Pengiriman TG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanPA">Pengiriman PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanPL">Pengiriman PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanUB">Pengiriman UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanBA">Pengiriman BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseTG">Ritase TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseTG8KL">Ritase TG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitasePA">Ritase PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitasePL">Ritase PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseUB">Ritase UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseBA">Ritase BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhTG">Jarak Tempuh TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhTG8KL">Jarak Tempuh TG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhPA">Jarak Tempuh PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhPL">Jarak Tempuh PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhUB">Jarak Tempuh UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBA">Jarak Tempuh BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiTG">Gaji TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiTG8KL">Gaji TG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiPA">Gaji PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiPL">Gaji PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiUB">Gaji UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiBA">Gaji BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Gaji Karyawan</a>
        </div>
    </div>
</li>
 <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo22"
      15  aria-expanded="true" aria-controls="collapseTwo22">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Pengeluaran</span>
    </a>
    <div id="collapseTwo22" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Pengeluaran</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanTG">Catat Perbaikan TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanTG8KL">Catat Perbaikan TG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanPA">Catat Perbaikan PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanPL">Catat Perbaikan PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanUB">Catat Perbaikan UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanUB">Catat Perbaikan BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulTG">Pengeluaran Pul TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulTG8KL">Pengeluaran Pul TG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulPA">Pengeluaran Pul PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulPL">Pengeluaran Pul PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulUB">Pengeluaran Pul UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBA">Pengeluaran Pul BA</a>
        </div>
    </div>
</li>
 <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
      15  aria-expanded="true" aria-controls="collapseTwo1">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >SDM</span>
    </a>
    <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VAMT">AMT</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMT">MT</a>
            <a class="collapse-item" style="font-size: 15px;" href="VBayarKredit">Kredit Kendaraan</a>
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
      <?php echo "<a href='VMasterTarifPL'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Master Tarif PL</h5></a>"; ?>
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



  <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">


   <div class="row">
    <div class="col-md-10">

    </div>
    <div class="col-md-2">
      <!-- Button Input Data Bayar -->
      <div align="right">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i>Tambah Master Tarif</button> <br> <br>
      </div>
      <!-- Form Modal  -->
      <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h5 class="modal-title"> Form Pencatatan Master Tarif</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div> 

          <!-- Form Input Data -->
          <div class="modal-body" align="left">
            <?php  echo "<form action='../proses/proses_master_tarif_PL' enctype='multipart/form-data' method='POST'>";  ?>

            <br>
            <div class="row">
              <div class="col-md-4">
               <label>Supply Point</label>
               <input class="form-control form-control-sm" type="text" id="supply_point" name="supply_point" required="">
             </div>
             <div class="col-md-4">
               <label>Alamat</label>
               <input class="form-control form-control-sm" type="text" id="alamat" name="alamat" required="">
             </div>
             <div class="col-md-4">
               <label>Delivey Point</label>
               <input class="form-control form-control-sm" type="text" id="delivery_point" name="delivery_point" required="">
             </div>
           </div>

         <br>

         <div class="row">
          <div class="col-md-4">
            <label>Jarak Tempuh</label>
            <input class="form-control form-control-sm" type="number" id="jt" name="jt" required="">
          </div>    
          <div class="col-md-4">
            <label>Harga BBM</label>
            <input class="form-control form-control-sm" type="number" id="hrg_bbm" name="hrg_bbm" required="">
          </div>
          <div class="col-md-4">
            <label>KL 1</label>
            <input class="form-control form-control-sm" type="float" id="kl1" name="kl1" required="">
          </div>                

        </div>

        <br>

        <div class="row">
         <div class="col-md-6">
             <label>KL 2</label>
            <input class="form-control form-control-sm" type="float" id="kl2" name="kl2" required="">
           </div>

           <div class="col-md-6">
             <label>KL 3</label>
            <input class="form-control form-control-sm" type="float" id="kl3" name="kl3" required="">
           </div>                 
        </div>
        
        <br>

        <div class="row">
         <div class="col-md-6">
             <label>KL 4</label>
            <input class="form-control form-control-sm" type="float" id="kl4" name="kl4" required="">
           </div>

           <div class="col-md-6">
             <label>KL 5</label>
            <input class="form-control form-control-sm" type="float" id="kl5" name="kl5" required="">
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
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
   
      <th>Supply Point</th>
      <th>Alamat</th>
      <th>Delivery Point</th>   
      <th>JT</th>
      <th>Harga BBM</th>
      <th>KL 1</th>
      <th>KL 2</th>
      <th>KL 3</th>
      <th>KL 4</th>
      <th>KL 5</th>
      <th></th>
    </tr>
  </thead>
  <tbody>

    <?php while($data = mysqli_fetch_array($table)){

      $supply_point =$data['supply_point'];
      $alamat =$data['alamat'];
      $delivery_point =$data['delivery_point'];
      $jt = $data['jt'];
      $hrg_bbm = $data['hrg_bbm'];
      $kl1 = $data['kl1'];
      $kl2 = $data['kl2'];
      $kl3 = $data['kl3'];
      $kl4 = $data['kl4'];
      $kl5 = $data['kl5'];

      echo "<tr>
  
      <td style='font-size: 14px' align = 'center'>$supply_point</td>
      <td style='font-size: 14px' align = 'center'>$alamat</td>
      <td style='font-size: 14px' align = 'center'>$delivery_point</td>
      <td style='font-size: 14px' align = 'center'>$jt/KM</td>
      <td style='font-size: 14px' align = 'center'>$hrg_bbm</td>
      <td style='font-size: 14px' align = 'center'>$kl1/L</td>
      <td style='font-size: 14px' align = 'center'>$kl2/L</td>
      <td style='font-size: 14px' align = 'center'>$kl3/L</td>
      <td style='font-size: 14px' align = 'center'>$kl4/L</td>
      <td style='font-size: 14px' align = 'center'>$kl5/L</td>

      "; ?>
      <?php echo "<td style='font-size: 12px'>"; ?>
      <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['delivery_point']; ?>">Edit</button>

      <!-- Form EDIT DATA -->

      <div class="modal fade" id="formedit<?php echo $data['delivery_point']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role ="document">
          <div class="modal-content"> 
            <div class="modal-header">
              <h5 class="modal-title"> Form Edit Master Tarif </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true"> &times; </span>
              </button>
            </div>

            <!-- Form Edit Data -->
            <div class="modal-body">
              <form action="../proses/edit_master_tarif_PL" enctype="multipart/form-data" method="POST">

                <input type="hidden" name="delivery_point" value="<?php echo $delivery_point;?>"> 
                

                <div class="row">
              <div class="col-md-4">
               <label>Supply Point</label>
               <input class="form-control form-control-sm" type="text" id="supply_point" name="supply_point" required=""  value="<?php echo $supply_point;?>" >
             </div>
             <div class="col-md-4">
               <label>alamat</label>
               <input class="form-control form-control-sm" type="text" id="alamat" name="alamat" required=""  value="<?php echo $alamat;?>" >
             </div>
             <div class="col-md-4">
               <label>Delivey Point</label>
               <input class="form-control form-control-sm" type="text" id="delivery_point" name="delivery_point" required="" disabled value="<?php echo $delivery_point;?>" >
             </div>
           </div>

         <br>

         <div class="row">
          <div class="col-md-4">
            <label>Jarak Tempuh</label>
            <input class="form-control form-control-sm" type="number" id="jt" name="jt" required=""  value="<?php echo $jt;?>">
          </div>    
          <div class="col-md-4">
            <label>Harga BBM</label>
            <input class="form-control form-control-sm" type="number" id="hrg_bbm" name="hrg_bbm" required=""  value="<?php echo $hrg_bbm;?>">
          </div>
          <div class="col-md-4">
            <label>KL 1</label>
            <input class="form-control form-control-sm" type="float" id="kl1" name="kl1" required=""  value="<?php echo $kl1;?>">
          </div>                

        </div>

        <br>

        <div class="row">
         <div class="col-md-6">
             <label>KL 2</label>
            <input class="form-control form-control-sm" type="float" id="kl2" name="kl2" required=""  value="<?php echo $kl2;?>">
           </div>

           <div class="col-md-6">
             <label>KL 3</label>
            <input class="form-control form-control-sm" type="float" id="kl3" name="kl3" required=""  value="<?php echo $kl3;?>">
           </div>                 
        </div>

        <br>

        <div class="row">
         <div class="col-md-6">
             <label>KL 4</label>
            <input class="form-control form-control-sm" type="float" id="kl4" name="kl4" required=""  value="<?php echo $kl4;?>">
           </div>

           <div class="col-md-6">
             <label>KL 5</label>
            <input class="form-control form-control-sm" type="float" id="kl5" name="kl5" required=""  value="<?php echo $kl5;?>">
           </div>                 
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

<!-- Button Hapus -->
<button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['delivery_point']; ?>" data-toggle='tooltip' title='Hapus Data Dokumen'>Hapus</button>
<div class="modal fade" id="PopUpHapus<?php echo $data['delivery_point']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
 <div class="modal-dialog" role ="document">
   <div class="modal-content"> 
    <div class="modal-header">
      <h4 class="modal-title"> <b> Hapus Data Sparepart </b> </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="close">
        <span aria-hidden="true"> &times; </span>
      </button>
    </div>

    <div class="modal-body">
      <form action="../proses/hapus_master_tarif_PL" method="POST">
        <input type="hidden" name="delivery_point" value="<?php echo $delivery_point;?>">
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