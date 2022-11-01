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
if ($jabatan_valid == 'Admin Semen') {

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

  $table = mysqli_query($koneksi, "SELECT * FROM pengiriman_sl WHERE tanggal_antar = '$tanggal_awal'");

}

else{

  $table = mysqli_query($koneksi, "SELECT * FROM pengiriman_sl WHERE tanggal_antar BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ORDER BY tanggal_antar ASC");

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

  <title>Pengiriman Semen</title>

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
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKasir">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3" > <img style="margin-top: 50px; height: 100px; width: 110px; " src="../gambar/Logo PBJ.PNG" ></div>
            </a>
            <br>
            
            <br>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active" >
                <a class="nav-link" href="DsAdminSemen">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 16px;" >Dashboard</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading" style="font-size: 15px; color:white;">
                ADMIN SEMEN
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
                        <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Penjualan Semen</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Pengiriman</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenebusan">Penebusan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaran">Pengeluaran</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan">Laporan Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapDoPenjualanL">Rekap DO Penjualan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapDoPembelian">Rekap DO Pembelian</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPotonganHarga">Potongan Harga</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
                  15  aria-expanded="true" aria-controls="collapseTwo1">
                    <i class="fas fa-truck-moving" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Menu SDM</span>
                </a>
                <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">SDM</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VKendaraan">Kendaraan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VDriver">Driver</a>  
                        <a class="collapse-item" style="font-size: 15px;" href="VTokoDO">List Toko DO</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VListKota">List Kota</a>
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
      <?php echo "<a href='VPengiriman?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Pengiriman Semen</h5></a>"; ?>
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



  <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">


    <?php  echo "<form  method='POST' action='VPengiriman' style='margin-bottom: 15px;'>" ?>
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
  <div class="col-md-10">

  </div>
  <div class="col-md-2">
    <!-- Button Input Data Bayar -->
    <div align="right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Catat Pengiriman</button> <br> <br>
    </div>
    <!-- Form Modal  -->
    <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role ="document">
       <div class="modal-content"> 
        <div class="modal-header">
          <h5 class="modal-title"> Form Pencatatan Pengiriman</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> 

        <!-- Form Input Data -->
        <div class="modal-body" align="left">
          <?php  echo "<form action='../proses/proses_pengiriman?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

          <br>
          <div class="row">
            <div class="col-md-6">

              <label>Tanggal Antar</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal_antar" name="tanggal_antar" >
             </div>      

           </div>
           <div class="col-md-6">


           </div>
         </div>
         <br>

         <div class="row">

          <div class="col-md-6">
          <label>Driver</label>
      <div class="col-sm-12">
        <input class="form-control form-control-sm" type="text" id="driver" name="driver"  required="">
      </div>
        </div>

        <div class="col-md-6">
            <label>No Polisi</label>
      <div class="col-sm-10">
            <input class="form-control form-control-sm" type="text" id="no_polisi" name="no_polisi"  required="">
          </div>
        </div>            

      </div>

      <br>

      <div class="row">

        <div class="col-md-6">
          <label>NO DO</label>
          <input class="form-control form-control-sm" type="text" id="no_do" name="no_do" >
        </div>    


        <div class="col-md-6">
          <label>Nama Toko di DO</label>
          <select id="tokens" class="selectpicker form-control" name="toko_do" multiple data-live-search="true">
            <option></option>
            <?php
            include 'koneksi.php';
            $result = mysqli_query($koneksi, "SELECT * FROM toko_do_l");   

            while ($data2 = mysqli_fetch_array($result)){
              $data_pangakalan = $data2['nm_lokasi'];

             
                echo "<option> $data_pangakalan </option> ";
              
            }
            ?>
          </select>
        </div>          

      </div>

      <br>

      <div class="row">
        
        <div class="col-md-6">
          <label>Uang Jalan</label>
          <input class="form-control form-control-sm" type="number" id="uj" name="uj">
        </div>  

      
        <div class="col-md-6">
          <label>Uang Gaji</label>
          <input class="form-control form-control-sm" type="number" id="ug" name="ug" >
        </div>  

        <div class="col-md-6">
          <label>Ongkos Mobil</label>
          <input class="form-control form-control-sm" type="number" id="om" name="om">
        </div>   
               
     </div>
  <br>
<div class="row">
            <div class="col-md-6">

              <label>Tanggal Ambil Gaji</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal_gaji" name="tanggal_gaji" >
             </div>      

           </div>
            <div class="col-md-6">

              <label>Tanggal Nota Tarikan</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal_nota" name="tanggal_nota" >
             </div>      

           </div>
         </div>
    <br>

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
<div style="overflow-x: auto">
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>Tgl Antar</th>
      <th>No Do</th>   
      <th>Driver</th>
      <th>No Polisi</th>
      <th>Tujuan Pengiriman</th>
      <th>Nama Toko di DO</th>
      <th>Uang Jalan</th>
      <th>Uang Gaji</th>
      <th>Ongkos Mobil</th>
      <th>Tgl Ambil Gaji</th>
      <th>Tgl Nota Tarikan</th>
      <th>KET</th>
      <th>File</th>
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
      $no_pengiriman = $data['no_pengiriman'];
     $no_penjualan = $data['no_penjualan'];
      $tanggal_antar =$data['tanggal_antar'];
      $driver =$data['driver'];
      $no_polisi = $data['no_polisi'];
      $toko_do = $data['toko_do'];
      $no_do = $data['no_do'];
      $uj = $data['uj'];
      $ug = $data['ug'];
      $om = $data['om'];
      $tanggal_gaji = $data['tanggal_gaji'];
      $tanggal_nota = $data['tanggal_nota'];
      $keterangan = $data['keterangan'];
      $file_bukti = $data['file_bukti'];
        $result2 = mysqli_query($koneksi, "SELECT tujuan_pengiriman FROM penjualan_sl WHERE no_penjualan = '$no_penjualan'");
        $data2 = mysqli_fetch_array($result2);
        $tujuan_pengiriman = $data2['tujuan_pengiriman'];
      $urut = $urut + 1;

      echo "<tr>
      <td style='font-size: 14px' align = 'center'>$urut</td>
      <td style='font-size: 14px' align = 'center'>$tanggal_antar</td>
      <td style='font-size: 14px' align = 'center'>$no_do</td>
      <td style='font-size: 14px' align = 'center'>$driver</td>
      <td style='font-size: 14px' align = 'center'>$no_polisi</td>
      <td style='font-size: 14px' align = 'center'>$tujuan_pengiriman</td>
      <td style='font-size: 14px' align = 'center'>$toko_do</td>
      <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($uj); ?> <?php echo "</td>
      <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($ug); ?> <?php echo "</td>
      <td style='font-size: 14px' align = 'center'>"?>  <?= formatuang($om); ?> <?php echo "</td>
      <td style='font-size: 14px' align = 'center'>$tanggal_gaji</td>
      <td style='font-size: 14px' align = 'center'>$tanggal_nota</td>
      <td style='font-size: 14px' align = 'center'>$keterangan</td>
      "; ?>
      <?php echo "
      <td style='font-size: 14px'>"; ?> <a download="../file_admin_semen/<?= $file_bukti ?>" href="../file_admin_semen/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>
      <?php echo "<td style='font-size: 12px'>"; ?>
      <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_pengiriman']; ?>">Edit</button>

      <!-- Form EDIT DATA -->

      <div class="modal fade" id="formedit<?php echo $data['no_pengiriman']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role ="document">
          <div class="modal-content"> 
            <div class="modal-header">
              <h5 class="modal-title"> Form Edit Pengiriman </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true"> &times; </span>
              </button>
            </div>

            <!-- Form Edit Data -->
            <div class="modal-body">
              
              <?php  echo "<form action='../proses/edit_pengiriman?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>
                <input type="hidden" name="no_pengiriman" value="<?php echo $no_pengiriman;?>"> 
                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir;?>">


                <br>
          <div class="row">
            <div class="col-md-6">

              <label>Tanggal Antar</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal_antar" name="tanggal_antar" value="<?php echo $tanggal_antar;?>">
             </div>      

           </div>
           <div class="col-md-6">


           </div>
         </div>
         <br>

         <div class="row">

          <div class="col-md-6">
          <label>Driver</label>
          <input class="form-control form-control-sm" type="text" id="driver" name="driver" required="" value="<?php echo $driver;?>">
          </div>
       

        <div class="col-md-6">
        <label>No Polisi</label>
          <input class="form-control form-control-sm" type="text" id="no_polisi" name="no_polisi" required="" value="<?php echo $no_polisi;?>">
          </div>
          </div>  

      

      <br>
    <div class="row">

        <div class="col-md-6">
          <label>Tujuan Pengiriman</label>
          <input class="form-control form-control-sm" type="text" id="tujuan_pengiriman" name="tujuan_pengiriman"  value="<?php echo $tujuan_pengiriman;?>">
        </div>    

      </div>
       <br>
      <div class="row">

        <div class="col-md-6">
          <label>NO DO</label>
          <input class="form-control form-control-sm" type="text" id="no_do" name="no_do"  value="<?php echo $no_do;?>">
        </div>    


        <div class="col-md-6">
          <label>Nama Toko di DO</label>
          <div>
          <select id="tokens" class="selectpicker form-control" name="toko_do" multiple data-live-search="true">
            <option></option>
            <?php
            include 'koneksi.php';
            $result = mysqli_query($koneksi, "SELECT * FROM toko_do_l");   
            $dataSelect = $data['toko_do'];
            while ($data2 = mysqli_fetch_array($result)){
              $data_pangakalan = $data2['nm_lokasi'];

           
                echo "<option" ?> <?php echo ($dataSelect == $data_pangakalan) ? "selected" : "" ?>> <?php echo $data_pangakalan; ?> <?php echo "</option>" ;
              
            }
            ?>
          </select>
          </div>
        </div>        

      </div>

      <br>

      <div class="row">
        
        <div class="col-md-6">
          <label>Uang Jalan</label>
          <input class="form-control form-control-sm" type="number" id="uj" name="uj" value="<?php echo $uj;?>">
        </div>  

      
        <div class="col-md-6">
          <label>Uang Gaji</label>
          <input class="form-control form-control-sm" type="number" id="ug" name="ug"  value="<?php echo $ug;?>">
        </div>  

        <div class="col-md-6">
          <label>Ongkos Mobil</label>
          <input class="form-control form-control-sm" type="number" id="om" name="om"  value="<?php echo $om;?>">
        </div>   
               
     </div>
  <br>
<div class="row">
            <div class="col-md-6">

              <label>Tanggal Ambil Gaji</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal_gaji" name="tanggal_gaji"  value="<?php echo $tanggal_gaji;?>">
             </div>      

           </div>
            <div class="col-md-6">

              <label>Tanggal Nota Tarikan</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal_nota" name="tanggal_nota"  value="<?php echo $tanggal_nota;?>">
             </div>      

           </div>
         </div>
    <br>

     <div>
       <label>Keterangan</label>
       <div class="form-group">
         <textarea id = "keterangan" name="keterangan" style="width: 300px;"><?php echo $keterangan;?></textarea>
       </div>
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

<!-- Button Hapus -->
<button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_pengiriman']; ?>" data-toggle='tooltip' title='Hapus Data Dokumen'>Hapus</button>
<div class="modal fade" id="PopUpHapus<?php echo $data['no_pengiriman']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
 <div class="modal-dialog" role ="document">
   <div class="modal-content"> 
    <div class="modal-header">
      <h4 class="modal-title"> <b> Hapus Data Sparepart </b> </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="close">
        <span aria-hidden="true"> &times; </span>
      </button>
    </div>

    <div class="modal-body">
      <form action="../proses/hapus_pengiriman" method="POST">
        <input type="hidden" name="no_pengiriman" value="<?php echo $no_pengiriman;?>">
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
  </div>
<br>
<br>
<!--
<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total JT ODO</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jml_jt_odo  ?></div>
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
            Total JT GPS</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jml_jt_gps  ?></div>
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
            Total LOST</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_lost  ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
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
            Total Surplus</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_surplus  ?></div>
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
<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Uang Jalan</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_uj)  ?></div>
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
            Total Gaji</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_ug)  ?></div>
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
            Total Uang Makan</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_um)  ?></div>
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
            Total DEX</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jml_dex  ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-truck-moving fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<br>
<br>
-->


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