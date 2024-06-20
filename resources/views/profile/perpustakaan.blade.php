@extends('layout.admin')
@section('title', 'Perpustakaan')
@section('title_page', 'Perpustakaan')
@section('desc_page', 'Daftar semua Perpustakaan')
@section('styles')
<style>
    .form-control {
        border-color: black;
    }

</style>
@endsection
@section('content')

<div class="card">
    <div class="card-header">
        <h4 class="card-title"></h4>
    </div>
    <div class="card-body">
        <legend class="text-center">DATA PROFIL PERPUSTAKAAN</legend>
        <div class="row">
            <div class="col-12">
                <form class="form form-horizontal" id="form-perpustakaan">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label>Nomor NPP</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="nomor_npp" placeholder="Nomor NPP">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Hasil Akreditasi</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="hasil_akreditasi" placeholder="Hasil Akreditasi">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Nama Perpustakaan</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="nama_perpustakaan" placeholder="Nama Perpustakaan">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Alamat</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="alamat" placeholder="Alamat">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Desa</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="desa" placeholder="Desa">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Kabupaten/Kota</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="kabupaten_kota" placeholder="Kabupaten/Kota">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Provinsi</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="provinsi" placeholder="Provinsi">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>No. Telp</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="no_telp" placeholder="No. Telp">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Situs Web</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="situs_web" placeholder="Situs Web">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Email</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="email" placeholder="Email">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Status Kelembagaan</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <select class="form-select" name="status_kelembagaan" id="status_kelembagaan">
                                    <option value="" disabled selected>Status Kelembagaan</option>
                                    <option value="Negeri">Negeri</option>
                                    <option value="Swasta">Swasta</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Tahun Berdiri</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="tahun_berdiri_perpustakaan" placeholder="Tahun Berdiri">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>No. SK Pendirian</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="sk_pendirian_perpustakaan" placeholder="No. SK Pendirian">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Nama Kepala Perpustakaan</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="nama_kepala_perpustakaan" placeholder="Nama Kepala Perpustakaan">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Nama Kepala Instansi</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="nama_kepala_instansi" placeholder="Nama Kepala Instansi">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Induk</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="induk" placeholder="Induk">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Jenis Perpustakaan</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <select class="form-control" name="jenis_perpustakaan" required>
                                    <option disabled selected value="">-- Pilih Jenis Perpustakaan --</option>
                                    <option value="Perpustakaan Khusus">Perpustakaan Khusus</option>
                                    <option value="Perpustakaan Perguruan Tinggi">Perpustakaan Perguruan Tinggi</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Visi</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="visi" placeholder="Visi">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>Misi</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="text" class="form-control" name="misi" placeholder="Misi">
                            </div>
                            <div class="col-md-3 col-12">
                                <label>DATA PERPUSTAKAAN File</label>
                            </div>
                            <div class="col-md-9 col-12 form-group">
                                <input required type="file" class="form-control" name="data_perpustakaan_image[]" placeholder="File">
                            </div>
                            <div class="col-md-12">
                                Download Template : <a download href="{{ asset('file/template/perpustakaan.xlsx') }}">Download</a>
                            </div>
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {

        $("#form-perpustakaan").on('submit', function(e) {
            e.preventDefault();
            let url = `${baseUrl}/api/v1/user/store`;
            let data = new FormData(this);
            loadingButton($(this))
            ajaxDataFile(url, 'POST', data, function(resp) {
                toast(resp.message);
                loadingButton($("#form-perpustakaan"), false)
                // delay redirect subkomponent
                setTimeout(function() {
                    window.location = "{{ url('dashboard.html') }}";
                })
            }, function(data) {
                loadingButton($("#form-perpustakaan"), false)
            });
        });
    });

</script>
@endsection
