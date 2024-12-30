<?php
require_once 'vendor/autoload.php';
include 'koneksi.php';


    $tanggal_awal = $_GET['tanggal1'];
    $tanggal_akhir = $_GET['tanggal2'];
    $tahun = date('Y', strtotime($tanggal_awal));
    $bulan = date('M', strtotime($tanggal_awal)); 


?>
  <style>
   tr{
    border-bottom: 2pt solid;
   }
  </style>

<?php

function formatuang($angka)
{
    $uang = number_format($angka, 0, ',', '.');
    return $uang;
}
function formatuangx($angka)
{
    $uang = "Rp " . number_format($angka, 0, ',', '.');
    return $uang;
}

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [210, 297]  ]);
$mpdf->AddPageByArray([
    'margin-left' => 20,
    'margin-right' => 20,
    'margin-top' => 3,
    'margin-bottom' => 5,
]);
$html = '
<html>

<head>


</head>

<body>
<br>
<br>

          
       


';
    $table = mysqli_query($koneksi, "SELECT * FROM rekap_gaji_pbj WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    
    while($data = mysqli_fetch_array($table)){

        $nama_karyawan =$data['nama_karyawan'];
        $jabatan = $data['jabatan'];
        $gaji_pokok = $data['gaji_pokok'];
        $tunjangan_jabatan = $data['tunjangan_jabatan'];
        $tunjangan_akomodasi = $data['tunjangan_akomodasi'];
        $uang_makan = $data['uang_makan'];
        $bpjs_ketenagakerjaan = $data['bpjs_ketenagakerjaan'];
        $bpjs_kesehatan = $data['bpjs_kesehatan'];
        $lembur = $data['lembur'];
        $premi_kehadiran = $data['premi_kehadiran'];
        $bonus_1 = $data['bonus_1'];
        $bonus_2 = $data['bonus_2'];
        $bonus_3 = $data['bonus_3'];
        $insentif = $data['insentif'];
        $absen_terlambat = $data['absen_terlambat'];
        $potongan_absen = $data['potongan_absen'];
        $angsuran_pinjaman = $data['angsuran_pinjaman'];
        $potongan_bon = $data['potongan_bon'];
        $hutang_pribadi = $data['hutang_pribadi'];
        $total_gaji_diterima = $data['total_gaji_diterima'];
        $total_gaji = $data['total_gaji'];
           
        
        $keterangan = $data['keterangan'];

        $html .= '
        
        <h3 class="panel-title" align="Center" style = "margin-bottom: 1px; margin-top: 1px;"><img style=" max-height: 70px; width: 100%; text-align:center; " src="../gambar/Kop PBJ.jpg"> </h3>
        <hr style = "margin-bottom: 1px; margin-top: 1px;">
        <h5 class="panel-title" align="Center" style = "margin-bottom: 1px; margin-top: 1px;"><u><strong>Slip Gaji Karyawan</strong></u></h5>
        <pre class="panel-title" align="center"  style="font-size: 10px; margin-bottom: 10px; margin-top: 1px;">'. $bulan .' '. $tahun .'</pre>

        <table  align="center" style="width:100%">
        <tr>
            <td align="left" style="font-size: 10px; width:20%; ">Nama Karyawan</td>
            <td align="center" style="font-size: 10px; width:1%;"> : </td>
            <td align="left" style="font-size: 10px; width:79%;">'. $nama_karyawan .'</td>
        </tr>
        <tr>
            <td align="left" style="font-size: 10px; width:20%; ">Jabatan</td>
            <td align="center" style="font-size: 10px; width:1%;"> : </td>
            <td align="left" style="font-size: 10px; width:79%;">'. $jabatan .'</td>
        </tr>
        </table>
  
        <table align="center" style="width:100%" border="1" cellspacing="0">

        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Gaji Pokok</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($gaji_pokok) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Tunjangan Jabatan</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($tunjangan_jabatan) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Tunjangan Akomodasi</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($tunjangan_akomodasi) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Uang Makan per Bulan</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($uang_makan) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">BPJS Ketenagakerjaan</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($bpjs_ketenagakerjaan) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">BPJS Kesehatan</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($bpjs_kesehatan) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Lembur</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($lembur) .'</td>
        </tr>
    
        </table>


        <table align="center" style="width:100%" border="1" cellspacing="0">

        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Premi Kehadiran Absen</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($premi_kehadiran) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Bonus 1</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($bonus_1) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Bonus 2</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($bonus_2) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Bonus 3</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($bonus_3) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Insentif</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($insentif) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Absen Terlambat</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($absen_terlambat) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Potongan Bon</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($potongan_bon) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Potongan Absen</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($potongan_absen) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Hutang Pribadi</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($hutang_pribadi) .'</td>
        </tr>
    
        </table>

        <table align="center" style="width:100%" border="1" cellspacing="0">

        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Total Gaji di Terima</td>
        <td align="right" style="font-size: 10px; width:79%; "><strong>'. formatuangx($total_gaji_diterima) .'</strong></td>
        </tr>

        </table>


        <pre class="panel-title" align="left"  style="font-size: 9px; margin-bottom: 2px; margin-top: 2px;"><u>Gaji '. $keterangan .' </u></pre>


        <table align="center" style="width:100%">

        <tr>
        <td align="center" style="font-size: 10px; width:50%; ">Karyawan</td>
        <td align="center" style="font-size: 10px; width:50%;">Direktur</td>
        </tr>
    
        </table>
        <br>
        <br>
        <table align="center" style="width:100%">

        <tr>
        <td align="center" style="font-size: 10px; width:50%; ">'.$nama_karyawan.'</td>
        <td align="center" style="font-size: 10px; width:50%;">Nyoman Edy Susanto</td>
        </tr>
    
        </table>


        <hr style = "margin-bottom: 5px; margin-top: 1px;">
        <br>
        <br>
        <br>

     



        
        ';

        

    } 



    $html .= '';

    





 $html .= '</body>

</html>';

$mpdf->setAutoTopMargin = 'stretch';
$mpdf->setAutoBottomMargin = 'stretch';
$mpdf->WriteHTML($html);
$mpdf->Output();
?>