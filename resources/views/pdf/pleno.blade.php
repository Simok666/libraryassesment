<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Akreditasi Perpustakaan Khusus Lembaga Pemerintah</title>
  <link rel="stylesheet" href="style.css">
</head>
<style>
    table, td, th {  
      border: 1px solid #ddd;
      text-align: left;
    }
    
    table {
      border-collapse: collapse;
      width: 100%;
    }
    
    th, td {
      padding: 15px;
    }
    </style>
    </head>
<body>
    
    <h2>Komponen, Indikator Kunci, Skor, dan Bobot Penilaian<</h2>
    
    <p>Akreditasi Perpustakaan Khusus Lembaga Pemerintah</p>
    
    <table class="scrolltable" style="overflow: auto;
    white-space: nowrap;" >
      <tr>
        <th>NO.</th>
        <th>KOMPONEN</th>
        <th>JUMLAH</th>
        <th>SKOR</th>
        <th>BOBOT</th>
        <th>NILAI</th>
        <th>VERIFIKASI</th>
        <th>BUKTI DUKUNG</th>
        <th>CATATAN</th>
        <th>KOMENTAR</th>
      </tr>
      {{$no = 1}}
      @foreach ($subKomponen->komponen as $key => $sk) 
        <tr>
            <td>{{$no++}}</td>
            <td>{{$sk['komponen']->title_komponens}}</td>
            <td>{{$sk['komponen']->jumlah_indikator_kunci}}</td>
            <td>{{$sk->skor_subkomponen}}</td>
            <td>{{$sk['komponen']->bobot}}</td>
            <td>{{$sk->nilai}}</td>
            <td>{{($sk->is_verified) ? 'Lolos Verifikasi' : 'Tidak Lolos Verifikasi' }}</td>
            <td class="text-center"><a href="#" class="openPopup" link="">View File</a></td>
            <td>{{$sk->notes}}</td>
            <td>{{$sk->komentar_pleno}}</td>
        </tr>
      @endforeach
      
    </table>
    <p style="margin-top: 20px; text-align:right">
        Menyetujui<br>
        Kepala Bagian Hukum, Kerjasama, dan Humas, Sekretariat Badan Kebijakan Transportasi sebagai Ketua Tim Pleno
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        Israfulhayat
    </p>
</body>
