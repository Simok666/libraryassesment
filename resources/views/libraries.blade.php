@extends('layout.admin')

@section('title', 'Perpustakaan')
@section('title_page', 'Perpustakaan')
@section('desc_page', 'List of all Perpustakaan')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="pull-right">Status</label>
                    <select class="form-select form-control dropdown-status" name="status">
                        <option value="Baru" selected>Baru</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h4 class="card-title"></h4>
    </div>
    <div class="card-body">
        @include('components.table-pagenation', ['table' => 'libraries' , 'url' => '/api/v1/getListLibrary' , 'headers' => [
            "Pic Name",
            "Pic email",
            "Action"
        ] , 'pagination' => true])
    </div>
</div>


<div class="modal fade text-left" id="detailLibrary" tabindex="-1" role="dialog"
    aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title white" id="">
                    Detail Library
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center loading">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                </div>
                <table class="table table-striped after-loading">
                    <tbody>
                        <tr>
                            <th scope="row">Nomor NPP</th>
                            <td data-bind-nomor_npp></td>
                        </tr>
                        <tr>
                            <th scope="row">Hasil Akreditasi</th>
                            <td data-bind-hasil_akreditasi></td>
                        </tr>
                        <tr>
                            <th scope="row">Nama Perpustakaan</th>
                            <td data-bind-nama_perpustakaan></td>
                        </tr>
                        <tr>
                            <th scope="row">Alamat</th>
                            <td data-bind-alamat></td>
                        </tr>
                        <tr>
                            <th scope="row">Desa</th>
                            <td data-bind-desa></td>
                        </tr>
                        <tr>
                            <th scope="row">Kabupaten/Kota</th>
                            <td data-bind-kabupaten_kota></td>
                        </tr>
                        <tr>
                            <th scope="row">Provinsi</th>
                            <td data-bind-provinsi></td>
                        </tr>
                        <tr>
                            <th scope="row">No Telepon</th>
                            <td data-bind-no_telp></td>
                        </tr>
                        <tr>
                            <th scope="row">Situs Web</th>
                            <td data-bind-situs_web></td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td data-bind-email></td>
                        </tr>
                        <tr>
                            <th scope="row">Status Kelembagaan</th>
                            <td data-bind-status_kelembagaan></td>
                        </tr>
                        <tr>
                            <th scope="row">Tahun Berdiri Perpustakaan</th>
                            <td data-bind-tahun_berdiri_perpustakaan></td>
                        </tr>
                        <tr>
                            <th scope="row">SK Pendirian Perpustakaan</th>
                            <td data-bind-sk_pendirian_perpustakaan></td>
                        </tr>
                        <tr>
                            <th scope="row">Nama Kepala Perpustakaan</th>
                            <td data-bind-nama_kepala_perpustakaan></td>
                        </tr>
                        <tr>
                            <th scope="row">Nama Kepala Instansi</th>
                            <td data-bind-nama_kepala_instansi></td>
                        </tr>
                        <tr>
                            <th scope="row">Induk</th>
                            <td data-bind-induk></td>
                        </tr>
                        <tr>
                            <th scope="row">Jenis Perpustakaan</th>
                            <td data-bind-jenis_perpustakaan></td>
                        </tr>
                        <tr>
                            <th scope="row">Visi</th>
                            <td data-bind-visi></td>
                        </tr>
                        <tr>
                            <th scope="row">Misi</th>
                            <td data-bind-misi></td>
                        </tr>
                        <tr>
                            <th scope="row">Status</th>
                            <td data-bind-status></td>
                        </tr>
                        <tr>
                            <th scope="row">Data Perpustakaan Image </th>
                            <td data-bind-data_perpustakaan_image></td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        req.status = "Baru";
        GetData(req,"libraries", formatlibraries);

        $(".dropdown-status").change(function() {
            req.status = $(this).val();
            req.page = 1;
            GetData(req,"libraries", formatlibraries);
        });
    });

    function formatlibraries(data) {
        var result = "";
        $.each(data, function(index, data) {
            result += `
                <tr>
                    <td>${data.pic_name}</td>
                    <td>${data.pic_email}</td>
                    <td>                        
                        <a href="#" class="btn btn-info btn-icon btn-sm btn-detail" title="Detail" data-name="${data.pic_name}" data-email="${data.pic_email}" data-id="${data.id}"><span class="bi bi-info-circle"> </span></a>
                    </td>
                </tr>
            `
        });
        return result;
    }

    $(document).on('click', '.btn-detail', function() {
        $('#detailLibrary').modal('show');
        loading($("#detailLibrary") , true);
        ajaxData(`${baseUrl}/api/v1/getListLibrary`, 'GET', {
            "id" : $(this).data('id'),
            "status" : $(".dropdown-status").val()
        }, function(resp) {
            const result = resp.data[0]?.profil_perpustakaan;
            if (!result) {
                setTimeout(() => {
                    $('#detailLibrary').modal('hide')
                    toast("Data not found", 'warning');
                }, 1000);
                return;
            }
            loading($("#detailLibrary") , false);
        
            $.each(result, function(index, data) {
                if (index == "data_perpustakaan_image") return;
                $('#detailLibrary').find(`[data-bind-${index}]`).html(data);
            });
                
            if (!empty(result.data_perpustakaan_image)) {
                result.data_perpustakaan_image.forEach(function(image) {
                    $('#detailLibrary').find('[data-bind-data_perpustakaan_image]').html(`<a href="${image.url}" target="_blank">View Image</a>`);
                });
            } else {
                $('#detailLibrary').find('[data-bind-image]').html(`-`);
            }
        },
        function() {
            loading($("#detailLibrary"));
            setTimeout(function() {
                $('#detailLibrary').modal('hide');
            }, 1000);
        });
    });
</script>
@endsection