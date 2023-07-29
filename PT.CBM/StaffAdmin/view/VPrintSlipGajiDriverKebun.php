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
    'margin-top' => 5,
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
    $table = mysqli_query($koneksi, "SELECT * FROM rekap_gaji_driver_kebun WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    
    while($data = mysqli_fetch_array($table)){

        $tanggal = $data['tanggal'];
        $nama_driver =$data['nama_driver'];
        $jabatan = $data['jabatan'];
        $rit_muat_sawit_dabuk = $data['rit_muat_sawit_dabuk'];
        $upah_muat_sawit_dabuk = $data['upah_muat_sawit_dabuk'];
        $rit_muat_getah_palembang = $data['rit_muat_getah_palembang'];
        $upah_muat_getah_palembang = $data['upah_muat_getah_palembang'];
        $rit_muat_pupuk_ke_gudang = $data['rit_muat_pupuk_ke_gudang'];
        $upah_muat_pupuk_ke_gudang = $data['upah_muat_pupuk_ke_gudang'];
        $rit_muat_nipah = $data['rit_muat_nipah'];
        $upah_muat_nipah = $data['upah_muat_nipah'];
        $rit_kampas_pupuk_kebun_lengkiti = $data['rit_kampas_pupuk_kebun_lengkiti'];
        $upah_kampas_pupuk_kebun_lengkiti = $data['upah_kampas_pupuk_kebun_lengkiti'];
        $rit_muat_batu = $data['rit_muat_batu'];
        $upah_muat_batu = $data['upah_muat_batu'];
        $total_gaji = $data['total_gaji'];
        $total_gaji_diterima = $data['total_gaji_diterima'];
        $keterangan = $data['keterangan'];

        $html .= '
        
        <h3 class="panel-title" align="Center" style = "margin-bottom: 1px; margin-top: 1px;"><img style=" max-height: 50px; width: 100%; text-align:center; " src="../gambar/Logo CBM.jpeg"> </h3>
        <hr style = "margin-bottom: 1px; margin-top: 1px;">
        <pre class="panel-title" align="center"  style="font-size: 8px; margin-bottom: 1px; margin-top: 1px;">Desa Sukamaju Kecamatan Buay Madang Timur Kabupaten OKU Timur - Sum-Sel</pre>
        <pre class="panel-title" align="center"  style="font-size: 8px; margin-bottom: 1px; margin-top: 1px;">email : ptcahayabumimusi@gmail.com | Telp. 0811-712-856</pre>
        <hr style = "margin-bottom: 1px; margin-top: 1px;">
        <h5 class="panel-title" align="Center" style = "margin-bottom: 1px; margin-top: 1px;"><u><strong>Slip Gaji Driver</strong></u></h5>
        <pre class="panel-title" align="center"  style="font-size: 10px; margin-bottom: 10px; margin-top: 1px;">'. $bulan .' '. $tahun .'</pre>

        <table  align="center" style="width:100%">
        <tr>
            <td align="left" style="font-size: 10px; width:20%; ">Nama Karyawan</td>
            <td align="center" style="font-size: 10px; width:1%;"> : </td>
            <td align="left" style="font-size: 10px; width:79%;">'. $nama_driver .'</td>
        </tr>
        <tr>
            <td align="left" style="font-size: 10px; width:20%; ">Jabatan</td>
            <td align="center" style="font-size: 10px; width:1%;"> : </td>
            <td align="left" style="font-size: 10px; width:79%;">'. $jabatan .'</td>
        </tr>
        </table>
        <br>
        <table align="center" style="width:100%" border="1" cellspacing="0">

        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Rit Muat Sawit Dabuk</td>
        <td align="right" style="font-size: 10px; width:79%;">'. $rit_muat_sawit_dabuk .' Rit</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Upah Muat Sawit Dabuk</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($upah_muat_sawit_dabuk) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Rit Muat Getah Palembang</td>
        <td align="right" style="font-size: 10px; width:79%;">'. $rit_muat_getah_palembang .' Rit</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Upah Muat Getah Palembang</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($upah_muat_getah_palembang) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Rit Muat Pupuk ke Gudang</td>
        <td align="right" style="font-size: 10px; width:79%;">'. $rit_muat_pupuk_ke_gudang .' Rit</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Upah Muat Pupuk ke Gudang</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($upah_muat_pupuk_ke_gudang) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Rit Muat Nipah</td>
        <td align="right" style="font-size: 10px; width:79%;">'. $rit_muat_nipah .' Rit</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Upah Muat Nipah</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($upah_muat_nipah) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Rit Kampas Pupuk Kebun Lenkiti</td>
        <td align="right" style="font-size: 10px; width:79%;">'. $rit_kampas_pupuk_kebun_lengkiti .' Rit</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Upah Kampas Pupuk Kebun Lenkiti</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($upah_kampas_pupuk_kebun_lengkiti) .'</td>
        </tr>
      
    
        </table>


        <br>

        <table align="center" style="width:100%" border="1" cellspacing="0">

        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Total Gaji</td>
        <td align="right" style="font-size: 10px; width:79%; "><strong>'. formatuangx($total_gaji) .'</strong></td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Total Gaji di Terima</td>
        <td align="right" style="font-size: 10px; width:79%; "><strong>'. formatuangx($total_gaji_diterima) .'</strong></td>
        </tr>

        </table>


        <pre class="panel-title" align="left"  style="font-size: 10px; margin-bottom: 5px; margin-top: 5px;"><u>Gaji '. $keterangan .' </u></pre>


        <table align="center" style="width:100%">

        <tr>
        <td align="center" style="font-size: 10px; width:50%; ">Driver</td>
        <td align="center" style="font-size: 10px; width:50%; ">Direktur</td>
        </tr>
    
        </table>
        <br>
        <br>
        <table align="center" style="width:100%">

        <tr>
        <td align="center" style="font-size: 10px; width:50%; ">'.$nama_driver.'</td>
        <td align="center" style="font-size: 10px; width:50%;">Nyoman Edy Susanto</td>
        </tr>
    
        </table>


        <hr style = "margin-bottom: 5px; margin-top: 1px;">
        <br>
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