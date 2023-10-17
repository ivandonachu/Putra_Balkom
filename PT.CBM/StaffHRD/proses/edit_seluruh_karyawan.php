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
if ($jabatan_valid == 'Staff HRD') {

}

else{  header("Location: logout.php");
exit;
}


          $nik_pk =$_POST['nik_pk'];
          $nama_karyawan =$_POST['nama_karyawan'];
          $perusahaan =$_POST['perusahaan'];
          $jabatan = $_POST['jabatan'];
          $tempat_lahir =$_POST['tempat_lahir'];
          $tanggal_lahir =$_POST['tanggal_lahir'];
          $nik =$_POST['nik'];
          $bpjs =$_POST['bpjs'];
          $alamat =$_POST['alamat'];
          $no_hp =$_POST['no_hp'];          
          $status_karyawan =$_POST['status_karyawan'];



          $nama_file = $_FILES['file']['name'];
          if ($nama_file == "") {
            $file = "";
          }
          
          else if ( $nama_file != "" ) {
          
            function upload(){
              $nama_file = $_FILES['file']['name'];
              $ukuran_file = $_FILES['file']['size'];
              $error = $_FILES['file']['error'];
              $tmp_name = $_FILES['file']['tmp_name'];
          
              $ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
              $ekstensi_file = explode(".", $nama_file);
              $ekstensi_file = strtolower(end($ekstensi_file));
          
          
              $nama_file_baru = uniqid();
              $nama_file_baru .= ".";
              $nama_file_baru .= $ekstensi_file;
          
              move_uploaded_file($tmp_name, '../../StaffAdmin/file_staff_admin/' . $nama_file_baru   );
          
              return $nama_file_baru; 
          
            }
          
            $file = upload();
            if (!$file) {
              return false;
            }
          
          }


	

if ($file == '') {
  $query3 = mysqli_query($koneksi,"UPDATE seluruh_karyawan SET nama_karyawan = '$nama_karyawan' ,perusahaan = '$perusahaan', jabatan = '$jabatan', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', 
                                                                 nik = '$nik', alamat = '$alamat',bpjs='$bpjs', no_hp = '$no_hp', status_karyawan = '$status_karyawan' WHERE nik = '$nik_pk'");
}
else{
  $query3 = mysqli_query($koneksi,"UPDATE seluruh_karyawan SET nama_karyawan = '$nama_karyawan' ,perusahaan = '$perusahaan', jabatan = '$jabatan', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', 
                                                                 nik = '$nik', alamat = '$alamat',bpjs='$bpjs', no_hp = '$no_hp', status_karyawan = '$status_karyawan' , file_bukti = '$file'WHERE nik = '$nik_pk'");
}

		if ($query3!= "") {
			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VSeluruhKaryawan.php';</script>";exit;
}

  ?>