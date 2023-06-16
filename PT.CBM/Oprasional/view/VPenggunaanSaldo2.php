
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
if ($jabatan_valid == 'Kepala Oprasional') {

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
if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksi, "SELECT * FROM riwayat_saldo_armada WHERE tanggal = '$tanggal_awal' ");
$table2 = mysqli_query($koneksi, "SELECT * FROM rekening ");
}
else{
$table = mysqli_query($koneksi, "SELECT * FROM riwayat_saldo_armada  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ");
$table2 = mysqli_query($koneksi, "SELECT * FROM rekening ");

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

  <title>Penggunaan Uang</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKepalaOprasional">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active" >
                <a class="nav-link" href="DsKepalaOprasional">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 16px;" >Dashboard</span></a>
                </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu Kepala Oprasional
       </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                  15  aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Oprasional</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Oprasional</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VSaldoBaru">Penggunaan Saldo</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VUangPBJ">Uang PBJ</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPBRKasir">Pengeluaran PBR/MES </a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapUang">Rekap Uang Masuk</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapTF">Rekap TF ke Bank</a>
                        
                    </div>
                </div>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwox"
                  15  aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Penageluaran</span>
                </a>
                <div id="collapseTwox" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Pengeluaran</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranCBM">Pengeluaran CBM</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranMES">Pengeluaran MES</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPBR">Pengeluaran PBR</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranKebun">Pengeluaran Kebun</a>
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
      <?php echo "<a href='VPenggunaanSaldo'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Penggunaan Saldo Perusahaan</h5></a>"; ?>
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
 <?php  echo "<form  method='POST' action='VPenggunaanSaldo2' style='margin-bottom: 15px;'>" ?>
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
  <div class="row">
    <div class="col-md-10">
     
   </div>
   <div class="col-md-2">
    <!-- Button Pindah Baja -->
    <div align="right">
 
    </div>
    <!-- Form Modal  -->
    <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role ="document">
       <div class="modal-content"> 
        <div class="modal-header">
          <h5 class="modal-title"> Form Penggunaan Saldo </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> 

        <!-- Form Input Data -->
        <div class="modal-body" align="left">
          <?php  echo "<form action='../proses/proses_penggunaan_saldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

          <div class="row">
            <div class="col-md-6">

              <label>Tanggal</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal" name="tanggal" required="">
             </div>
    
          </div>
          <div class="col-md-6">
          </div>
        </div>


        <div class="row">
           
          <div class="col-md-6">
           <label>REF Pengeluaran/Pemasukan</label>
          <select id="referensi" name="referensi" class="form-control">
            <option>CBM</option>
            <option>Melodi Tani</option>
            <option>PBJ</option>
            <option>BALSRI</option>
            <option>Kebun Lengkiti</option>
            <option>MES/PBR</option>
            <option>STE</option>
          </select>
          <small></small>
        </div>

        <div class="col-md-6">
          <label>Akun</label>
          <select id="akun" name="akun" class="form-control">
            <option>Setor ke Bank</option>
            <option>Dana Masuk</option>
            <option>Biaya Usaha Lainnya</option>
            <option>Biaya Perbaikan Kendaraan</option>
            <option>Biaya Penjualan & Pemasaran</option>
            <option>Bon Karyawan</option>
            <option>Transfer Ke Bos</option>
            <option>Pemakaian Pribadi</option>
            <option>Bayar Pajak</option>
            <option>Bayar Kir</option>
            <option>Mocash</option>
            <option>Pengeluaran Pak Nyoman</option>
            <option>Pengeluaran Buk Mery</option>
          </select>
        </div>            

      </div>

      <br>

     

      <div class="row">
        <div class="col-md-6">
          <label>Jumlah</label>
          <input class="form-control form-control-sm" type="number" id="jumlah" name="jumlah"  required="">
        </div>    
        <div class="col-md-6">
        </div>         
      </div>

      <br>

    <div>
       <label>Saldo</label>
          <select id="rekening" name="rekening" class="form-control">
            <option>CBM</option>
            <option>Melodi Tani</option>
            <option>PBJ</option>
          </select>
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
    <button type="submit" class="btn btn-primary">Pindahkan</button>
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
      <th>Akun</th>
      <th>REF</th>
      <th>Rekening</th>
      <th>Debit</th>
      <th>Kredit</th>
      <th>Keterangan</th>
      <th>File</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    //Masuk CBM Keluar CBM
    $masuk_cbm_cbm = 0;
    //Masuk CBM Keluar PBJ
    $masuk_cbm_pbj = 0;
    //mASUK cbm kELUAR MT
    $masuk_cbm_mt = 0;
    //masuk mt keluar cbm
    $masuk_mt_cbm = 0;
    //masuk mt keluar pbj
    $masuk_mt_pbj = 0;
    //masuk mt keluar mt
    $masuk_mt_mt = 0;
    //masuk pbj keluar cbm
    $masuk_pbj_cbm = 0;
    //masuk pbj keluar pbj
    $masuk_pbj_pbj = 0;
    //masuk pbj keluar mt
    $masuk_pbj_mt = 0;
    
    
    //keluar cbm masuk cbm
    $keluar_cbm_cbm = 0;
    //keluar cbm masuk pbj
    $keluar_cbm_pbj = 0;
    //keluar cbm masuk mt
    $keluar_cbm_mt = 0;
    //keluar mt masuk cbm
    $keluar_mt_cbm = 0;
    //keluar mt masuk pbj
    $keluar_mt_pbj = 0;
    //keluar mt masuk mt
    $keluar_mt_mt = 0;
    //keluar pbj masuk cbm
    $keluar_pbj_cbm = 0;
    //keluar pbj masuk pbj
    $keluar_pbj_pbj = 0;
    //keluar pbj masuk mt
    $keluar_pbj_mt = 0;

    //setor dana cbm ke cbm
    $setor_cbm_cbm = 0;
    //setor dana cbm ke pbj
    $setor_cbm_pbj = 0;
    //setor dana cbm ke mt
    $setor_cbm_mt = 0;
    //setor dana mt ke cbm
    $setor_mt_cbm = 0;
    //setor dana mt ke pbj
    $setor_mt_pbj = 0;
    //setor dana mt ke mt
    $setor_mt_mt = 0;
    //setor dana pbj ke cbm
    $setor_pbj_cbm = 0;
    //setor dana pbj ke pbj
    $setor_pbj_pbj = 0;
    //setor dana pbj ke mt
    $setor_pbj_mt = 0;

    //khusus
    //keluar cbm ke balsri
    $keluar_cbm_balsri = 0 ;
    //keluar pbj ke balsri
    $keluar_pbj_balsri = 0 ;
    //keluar mt ke balsri
    $keluar_mt_balsri = 0 ;
    //keluar cbm ke kebun lengkiti
    $keluar_cbm_keling = 0 ;
    //keluar pbj ke kebun lengkiti
    $keluar_pbj_keling = 0 ;
    //keluar mt ke kebun lengkiti
    $keluar_mt_keling = 0 ;
    //keluar cbm ke pbr
    $keluar_cbm_pbr = 0 ;
    //keluar pbj ke pbr
    $keluar_pbj_pbr = 0 ;
    //keluar mt ke pbr
    $keluar_mt_pbr = 0 ;
    //keluar cbm ke ste
    $keluar_cbm_ste = 0 ;
    //keluar pbj ke ste
    $keluar_pbj_ste = 0 ;
    //keluar mt ke ste
    $keluar_mt_ste = 0 ;
    
    $urut = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>
    <?php while($data = mysqli_fetch_array($table)){
      $no_laporan = $data['no_laporan'];
      $tanggal =$data['tanggal'];
      $referensi = $data['referensi'];
      $nama_akun = $data['nama_akun'];
      $nama_rekening = $data['nama_rekening'];
      $jumlah = $data['jumlah'];
      $file_bukti = $data['file_bukti'];
      $keterangan = $data['keterangan'];
      $status_saldo = $data['status_saldo'];
    if($nama_akun == 'Transfer Ke Bos'){
        
    }
    //Masuk CBM Keluar CBM
    if ($status_saldo == 'Masuk' && $nama_rekening == 'CBM' && $referensi == 'CBM') {
        $masuk_cbm_cbm = $masuk_cbm_cbm + $jumlah;
      }
    //Masuk CBM Keluar PBJ
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'CBM' && $referensi == 'PBJ') {
        $masuk_cbm_pbj = $masuk_cbm_pbj + $jumlah;
      }
    //mASUK cbm kELUAR MT
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'CBM' && $referensi == 'Melodi Tani') {
        $masuk_cbm_mt = $masuk_cbm_mt + $jumlah;
      }
    //masuk mt keluar cbm
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'Melodi Tani' && $referensi == 'CBM') {
        $masuk_mt_cbm = $masuk_mt_cbm + $jumlah;
      }
    //masuk mt keluar pbj
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'Melodi Tani' && $referensi == 'PBJ') {
        $masuk_mt_pbj = $masuk_mt_pbj + $jumlah;
      }
    //masuk mt keluar mt
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'Melodi Tani' && $referensi == 'Melodi Tani') {
        $masuk_mt_mt = $masuk_mt_mt + $jumlah;
      }
    //masuk pbj keluar cbm
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'PBJ' && $referensi == 'CBM') {
        $masuk_pbj_cbm = $masuk_pbj_cbm + $jumlah;
      }
    //masuk pbj keluar pbj
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'PBJ' && $referensi == 'PBJ') {
        $masuk_pbj_pbj = $masuk_pbj_pbj + $jumlah;
      }
    //masuk pbj keluar mt
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'PBJ' && $referensi == 'Melodi Tani') {
        $masuk_pbj_mt = $masuk_pbj_mt + $jumlah;
      }
    
    
    //keluar cbm masuk cbm
    if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'CBM' && $nama_akun != 'Setor ke Bank' ) {
        $keluar_cbm_cbm = $keluar_cbm_cbm + $jumlah;
      }
    //keluar cbm masuk pbj
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'PBJ' && $nama_akun != 'Setor ke Bank'  ) {
        $keluar_cbm_pbj = $keluar_cbm_pbj + $jumlah;
      }
    //keluar cbm masuk mt
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'Melodi Tani' && $nama_akun != 'Setor ke Bank' ) {
        $keluar_cbm_mt = $keluar_cbm_mt + $jumlah;
      }
    //keluar mt masuk cbm
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'CBM' && $nama_akun != 'Setor ke Bank' ) {
        $keluar_mt_cbm = $keluar_mt_cbm + $jumlah;
      }
    //keluar mt masuk pbj
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'PBJ' && $nama_akun != 'Setor ke Bank' ) {
        $keluar_mt_pbj = $keluar_mt_pbj + $jumlah;
      }
    //keluar mt masuk mt
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'Melodi Tani' && $nama_akun != 'Setor ke Bank' ) {
        $keluar_mt_mt = $keluar_mt_mt + $jumlah;
      }
    //keluar pbj masuk cbm
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'CBM' && $nama_akun != 'Setor ke Bank' ) {
        $keluar_pbj_cbm = $keluar_pbj_cbm + $jumlah;
      }
    //keluar pbj masuk pbj
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'PBJ' && $nama_akun != 'Setor ke Bank' ) {
        $keluar_pbj_pbj = $keluar_pbj_pbj + $jumlah;
      }
    //keluar pbj masuk mt
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'Melodi Tani' && $nama_akun != 'Setor ke Bank' ) {
        $keluar_pbj_mt = $keluar_pbj_mt + $jumlah;
      }
    //keluar cbm masuk balsri
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'BALSRI') {
        $keluar_cbm_balsri = $keluar_cbm_balsri + $jumlah;
      }
    //keluar pbj masuk balsri
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'BALSRI') {
        $keluar_pbj_balsri = $keluar_pbj_balsri + $jumlah;
      }
    //keluar mt masuk balsri
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'BALSRI') {
        $keluar_mt_balsri = $keluar_mt_balsri + $jumlah;
      }
    //keluar cbm masuk kebun lengkiti
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'Kebun Lengkiti') {
        $keluar_cbm_keling = $keluar_cbm_keling + $jumlah;
      }
    //keluar pbj masuk  kebun lengkiti
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'Kebun Lengkiti') {
        $keluar_pbj_keling = $keluar_pbj_keling + $jumlah;
      }
    //keluar mt masuk  kebun lengkiti
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'Kebun Lengkiti') {
        $keluar_mt_keling = $keluar_mt_keling + $jumlah;
      }
    //keluar cbm masuk balsri
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'MES/PBR') {
        $keluar_cbm_pbr = $keluar_cbm_pbr + $jumlah;
      }
    //keluar pbj masuk balsri
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'MES/PBR') {
        $keluar_pbj_pbr = $keluar_pbj_pbr + $jumlah;
      }
    //keluar mt masuk balsri
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'MES/PBR') {
        $keluar_mt_pbr = $keluar_mt_pbr + $jumlah;
      }
    
      //keluar cbm masuk balsri
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'STE') {
      $keluar_cbm_ste = $keluar_cbm_ste + $jumlah;
    }
  //keluar pbj masuk balsri
  else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'STE') {
      $keluar_pbj_ste = $keluar_pbj_ste + $jumlah;
    }
  //keluar mt masuk balsri
  else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'STE') {
      $keluar_mt_ste = $keluar_mt_ste + $jumlah;
    }
  


    //setor dana cbm ke cbm
    if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'CBM' && $nama_akun == 'Setor ke Bank' ) {
        $setor_cbm_cbm = $setor_cbm_cbm + $jumlah;
      }
    //setor dana cbm ke pbj
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'PBJ' && $nama_akun == 'Setor ke Bank' ) {
        $setor_cbm_pbj = $setor_cbm_pbj + $jumlah;
      }
    //setor dana cbm ke mt
   else if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'Melodi Tani' && $nama_akun == 'Setor ke Bank' ) {
        $setor_cbm_mt = $setor_cbm_mt + $jumlah;
      }
    //setor dana mt ke cbm
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'CBM' && $nama_akun == 'Setor ke Bank' ) {
        $setor_mt_cbm = $setor_mt_cbm + $jumlah;
      }
    //setor dana mt ke pbj
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'PBJ' && $nama_akun == 'Setor ke Bank' ) {
        $setor_mt_pbj = $setor_mt_pbj + $jumlah;
      }
    //setor dana mt ke mt
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'Melodi Tani' && $nama_akun == 'Setor ke Bank' ) {
        $setor_mt_mt = $setor_mt_mt + $jumlah;
      }
    //setor dana pbj ke cbm
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'CBM' && $nama_akun == 'Setor ke Bank' ) {
        $setor_pbj_cbm = $setor_pbj_cbm + $jumlah;
      }
    //setor dana pbj ke pbj
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'PBJ' && $nama_akun == 'Setor ke Bank' ) {
        $setor_pbj_pbj = $setor_pbj_pbj + $jumlah;
      }
    //setor dana pbj ke mt
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'Melodi Tani' && $nama_akun == 'Setor ke Bank' ) {
        $setor_pbj_mt = $setor_pbj_mt + $jumlah;
      }

        $urut = $urut + 1;
      echo "<tr>
      <td style='font-size: 14px'>$urut</td>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$nama_akun</td>
      <td style='font-size: 14px'>$referensi</td>
      <td style='font-size: 14px'>$nama_rekening</td>";


      if ($status_saldo == 'Masuk') {
        echo "
        <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>";
      }
      else{
        echo "
        <td style='font-size: 14px'>"?>  <?php echo "</td>";
      }

      if ($status_saldo == 'Keluar') {
        echo "
        <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>";
      }
      else{
        echo "
        <td style='font-size: 14px'>"?>  <?php echo "</td>";
      }
        
      echo "
      <td style='font-size: 14px'>$keterangan</td>
      <td style='font-size: 14px'>"; ?> <a download="../file_oprasional/<?= $file_bukti ?>" href="../file_oprasional/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>
      <?php echo "<td style='font-size: 12px'>"; ?>
      

        <!-- Form EDIT DATA -->

        <div class="modal fade" id="formedit<?php echo $data['no_laporan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
          <div class="modal-dialog" role ="document">
            <div class="modal-content"> 
              <div class="modal-header">Form Edit Kas Kecil </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                  <span aria-hidden="true"> &times; </span>
                </button>
              </div>


              <!-- Form Edit Data -->
              <div class="modal-body">
                <form action="../proses/edit_penggunaan_saldo.php" enctype="multipart/form-data" method="POST">

                  <div class="row">
            <div class="col-md-6">

              <label>Tanggal</label>
              <div class="col-sm-10">
               <input type="date" id="tanggal" name="tanggal"  value="<?php echo $tanggal;?>" required="">
             </div>
   

          </div>
          <div class="col-md-6">
          </div>
        </div>


        <div class="row">
          

        <div class="col-md-6">

          <label><label>REF Pengeluaran/Pemasukan</label></label>
          <select id="referensi" name="referensi" class="form-control">
            <?php $dataSelect = $data['referensi']; ?>
            <option <?php echo ($dataSelect == 'CBM') ? "selected": "" ?> >CBM</option>
            <option <?php echo ($dataSelect == 'Melodi Tani') ? "selected": "" ?> >Melodi Tani</option>
            <option <?php echo ($dataSelect == 'PBJ') ? "selected": "" ?> >PBJ</option>
            <option <?php echo ($dataSelect == 'BALSRI') ? "selected": "" ?> >BALSRI</option>
            <option <?php echo ($dataSelect == 'Kebun Lengkiti') ? "selected": "" ?> >Kebun Lengkiti</option>
            <option <?php echo ($dataSelect == 'MES/PBR') ? "selected": "" ?> >MES/PBR</option>
            <option <?php echo ($dataSelect == 'STE') ? "selected": "" ?> >STE</option>
          </select>

        </div>            
         <div class="col-md-6">

          <label><label>Akun</label></label>
          <select id="akun" name="akun" class="form-control">
            <?php $dataSelect = $data['nama_akun']; ?>
            <option <?php echo ($dataSelect == 'Setor ke Bank') ? "selected": "" ?> >Setor ke Bank</option>
            <option <?php echo ($dataSelect == 'Dana Masuk') ? "selected": "" ?> >Dana Masuk</option>
            <option <?php echo ($dataSelect == 'Biaya Usaha Lainnya') ? "selected": "" ?> >Biaya Usaha Lainnya</option>
            <option <?php echo ($dataSelect == 'Biaya Perbaikan Kendaraan') ? "selected": "" ?> >Biaya Perbaikan Kendaraan</option>
            <option <?php echo ($dataSelect == 'Biaya Penjualan & Pemasaran') ? "selected": "" ?> >Biaya Penjualan & Pemasaran</option>
            <option <?php echo ($dataSelect == 'Bon Karyawan') ? "selected": "" ?> >Bon Karyawan</option>
            <option <?php echo ($dataSelect == 'Transfer Ke Bos') ? "selected": "" ?> >Transfer Ke Bos</option>
            <option <?php echo($dataSelect == 'Bayar Pajak')?"selected": ""?>>Bayar Pajak</option>
            <option <?php echo($dataSelect == 'Bayar Kir')?"selected": ""?>>Bayar Kir</option>
            <option <?php echo($dataSelect == 'Mocash')?"selected": ""?>>Mocash</option>
            <option <?php echo($dataSelect == 'Pengeluaran Pak Nyoman')?"selected": ""?>>Pengeluaran Pak Nyoman</option>
            <option <?php echo($dataSelect == 'Pengeluaran Buk Mery')?"selected": ""?>>Pengeluaran Buk Mery</option>

          </select>

        </div>
      </div>

      <br>

     

      <div class="row">
        <div class="col-md-6">
          <label>Jumlah</label>
          <input class="form-control form-control-sm" type="number" id="jumlah" name="jumlah"  value="<?php echo $jumlah;?>"  required="">
        </div>    
        <div class="col-md-6">
       

          <label><label>Saldo</label></label>
          <select id="rekening" name="rekening" class="form-control">
            <?php $dataSelect = $data['nama_rekening']; ?>
            <option <?php echo ($dataSelect == 'CBM') ? "selected": "" ?> >CBM</option>
            <option <?php echo ($dataSelect == 'Melodi Tani') ? "selected": "" ?> >Melodi Tani</option>
            <option <?php echo ($dataSelect == 'PBJ') ? "selected": "" ?> >PBJ</option>
          </select>

  
        </div>         
      </div>

      <div>
     <label>Keterangan</label>
     <div class="form-group">
       <textarea id = "keterangan" name="keterangan" style="width: 300px;"><?php echo $keterangan;?></textarea>
     </div>
   </div>

              <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
              <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir;?>">
               <input type="hidden" name="no_laporan" value="<?php echo $no_laporan;?>">
  
    <br>



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
 
      <div class="modal fade" id="PopUpHapus<?php echo $data['no_laporan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
       <div class="modal-dialog" role ="document">
         <div class="modal-content"> 
          <div class="modal-header">
            <h4 class="modal-title"> <b> Hapus </b> </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>



          <div class="modal-body">
            <form action="../proses/hapus_penggunaan_saldo" method="POST">
              <input type="hidden" name="no_laporan" value="<?php echo $no_laporan; ?>">
              <input type="hidden" name="status_saldo" value="<?php echo $status_saldo; ?>">
              <input type="hidden" name="nama_rekening" value="<?php echo $nama_rekening;?>">
              <input type="hidden" name="jumlah" value="<?php echo $jumlah;?>">
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
<br>
<br>
<br>

<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h6 align="center">UANG CBM</h6>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Total Uang Masuk ke CBM</th>
      <th>Total Uang Keluar dari CBM</th>
      <th>Total Uang Disetor ke CBM</th>
      <th>Total Uang CBM di Tangan</th>
      <th>Rincian</th>
    </tr>
  </thead>
  <tbody>

    <?php
      echo "<tr>

      <td style='font-size: 14px'>";?> <?= formatuang($masuk_cbm_cbm + $masuk_cbm_mt + $masuk_cbm_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($masuk_pbj_cbm + $masuk_mt_cbm + $keluar_cbm_balsri + $keluar_cbm_keling + $keluar_cbm_cbm + $keluar_cbm_pbr + $keluar_cbm_mt + $keluar_cbm_pbj + $keluar_cbm_ste); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($setor_cbm_cbm + $setor_cbm_mt + $setor_cbm_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang(($masuk_cbm_cbm + $masuk_cbm_mt + $masuk_cbm_pbj + 15000000) - ($masuk_pbj_cbm + $masuk_mt_cbm + $keluar_cbm_balsri + $keluar_cbm_ste  + $setor_cbm_cbm + $setor_cbm_mt + $setor_cbm_pbj + $keluar_cbm_keling + $keluar_cbm_cbm + $keluar_cbm_pbr + $keluar_cbm_mt + $keluar_cbm_pbj)); ?> <?php echo "</td>
      <td class='text-center'><a href='VRincianCBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>
        </tr>";
  
  ?>

</tbody>
</table>
</div>

<br>

<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h6 align="center">UANG MT</h6>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Total Uang Masuk ke MT</th>
      <th>Total Uang Keluar dari MT</th>
      <th>Total Uang Disetor ke MT</th>
      <th>Total Uang MT di Tangan</th>
      <th>Rincian</th>
    </tr>
  </thead>
  <tbody>

    <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($masuk_mt_mt + $masuk_mt_cbm + $masuk_mt_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($masuk_cbm_mt + $masuk_pbj_mt + $keluar_mt_balsri + $keluar_mt_keling + $keluar_mt_mt + $keluar_mt_pbr + $keluar_mt_cbm + $keluar_mt_pbj + $keluar_mt_ste); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($setor_mt_mt + $setor_mt_cbm + $setor_mt_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang(($masuk_mt_mt + $masuk_mt_cbm + $masuk_mt_pbj)-($masuk_cbm_mt + $masuk_pbj_mt + $keluar_mt_balsri + $keluar_mt_ste + $setor_mt_mt + $setor_mt_cbm + $setor_mt_pbj + $keluar_mt_keling + $keluar_mt_mt + $keluar_mt_pbr + $keluar_mt_cbm + $keluar_mt_pbj)); ?> <?php echo "</td>
      <td class='text-center'><a href='VRincianMT?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>
        </tr>";
  
  ?>

</tbody>
</table>
</div>

<br>

<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h6 align="center">UANG PBJ</h6>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Total Uang Masuk ke PBJ</th>
      <th>Total Uang Keluar dari PBJ</th>
      <th>Total Uang Disetor ke PBJ</th>
      <th>Total Uang PBJ di Tangan</th>
      <th>Rincian</th>
    </tr>
  </thead>
  <tbody>

    <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($masuk_pbj_mt + $masuk_pbj_cbm + $masuk_pbj_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($masuk_cbm_pbj + $masuk_mt_pbj + $keluar_pbj_balsri + $keluar_pbj_keling + $keluar_pbj_pbj + $keluar_pbj_pbr + $keluar_pbj_cbm + $keluar_pbj_mt + $keluar_pbj_ste ); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($setor_pbj_mt + $setor_pbj_cbm + $setor_pbj_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang(($masuk_pbj_mt + $masuk_pbj_cbm + $masuk_pbj_pbj)-($setor_pbj_mt + $setor_pbj_cbm + $setor_pbj_pbj + $masuk_cbm_pbj + $masuk_mt_pbj + $keluar_pbj_balsri + $keluar_pbj_ste + $keluar_pbj_keling + $keluar_pbj_pbj + $keluar_pbj_pbr + $keluar_pbj_cbm + $keluar_pbj_mt )); ?> <?php echo "</td>
      <td class='text-center'><a href='VRincianPBJ?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>
        </tr>";
  
  ?>

</tbody>
</table>
</div>
<br>

<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h6 align="center">Pengeluaran Untuk Balsri</h6>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Total Uang CBM dipakai BALSRI</th>
      <th>Total Uang PBJ dipakai BALSRI</th>
      <th>Total Uang MT dipakai BALSRI</th>
    
      <th>Rincian</th>
    </tr>
  </thead>
  <tbody>

    <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_cbm_balsri); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_pbj_balsri); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_mt_balsri); ?> <?php echo "</td>
      <td class='text-center'><a href='VRincianBALSRI?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>
        </tr>";
  
  ?>

</tbody>
</table>
</div>
<br>
<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h6 align="center">Pengeluaran Untuk STE</h6>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Total Uang CBM dipakai STE</th>
      <th>Total Uang PBJ dipakai STE</th>
      <th>Total Uang MT dipakai STE</th>
    
      <th>Rincian</th>
    </tr>
  </thead>
  <tbody>

    <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_cbm_ste); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_pbj_ste); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_mt_ste); ?> <?php echo "</td>
      <td class='text-center'><a href='VRincianSTE?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>
        </tr>";
  
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