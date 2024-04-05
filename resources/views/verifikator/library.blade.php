@extends('layout.admin')

@section('title', 'Libraries')
@section('title_page', 'Libraries')
@section('desc_page', 'List of all Libraries')
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.css') }}">

    <link rel="stylesheet" href="{{ asset("vendors/summernote/summernote-lite.min.css") }}">
@endsection
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
            "No",
            "Pic Name",
            "Pic email",
            "Status Profile Perpustakaan",
            "Status Subkomponent",
            "Status Bukti Fisik",
            "Action"
        ] , 'pagination' => true])
    </div>
</div>

<div class="modal fade text-left" id="modal-subkomponent" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel4" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">Verify Komponen</h4>
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
                <form id="form-subkomponent">
                    <input type="hidden" name="user_id">
                    <table class="table table-striped table-komponent after-loading">
                        <thead>
                            <tr>
                                <th>NO.</th>
                                <th>KOMPONEN</th>
                                <th>JUMLAH INDIKATOR KUNCI (IK)</th>
                                <th>SKOR SUBKOMPONEN</th>
                                <th>BOBOT</th>
                                <th>NILAI</th>
                                <th>VERIFIKASI</th>
                                <th>BUKTI DUKUNG</th>
                                <th width="15%">Status</th>
                                <th width="30%">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="submit" form="form-subkomponent" class="btn btn-primary ml-1">
                    <span class="d-none d-sm-block">Accept</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="modal-buktifisik" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel4" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">Verify Bukti Fisik</h4>
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
                <form id="form-buktifisik">
                    <input type="hidden" name="user_id">
                    <table class="table table-striped table-bukti after-loading">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">File</th>
                                <th scope="col">Status</th>
                                <th scope="col">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="submit" form="form-buktifisik" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Accept</span>
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade text-left" id="modal-perpustakaan" tabindex="-1" role="dialog"
    aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title white" id="">
                    Detail Perpustakaan
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
                <form class="after-loading" id="form-perpustakaan">
                    <table class="table table-striped ">
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
                    <input type="hidden" name="user_id">
                    <input type="hidden" name="library_id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Status Perpustakaan</label>
                                <select class="form-select" name="repeater[0][status]" required>
                                    <option value="" selected disabled> -- Status ---</option>
                                    <option value="1"> Lolos Verifikasi </option>
                                    <option value="0"> Tidak Lolos Verifikasi </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="summer-note">Catatan</label>
                                <textarea class="form-control sumernote-perpustakaan" id="summer-note" name="repeater[0][notes]" placeholder="notes"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="submit" form="form-perpustakaan" class="btn btn-primary ml-1">
                    <span class="d-none d-sm-block">Accept</span>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ asset('vendors/summernote/summernote-lite.min.js') }}"></script>
<script>
    $(document).ready(function() {
        req.status = "Baru";
        GetData(req,"libraries", formatTable);

        $(".dropdown-status").change(function() {
            req.status = $(this).val();
            req.page = 1;
            GetData(req,"libraries", formatTable);
        });
    });

    function formatTable(data) {
        var result = "";
        $.each(data, function(index, data) {
            result += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${data.pic_name}</td>
                    <td>${data.pic_email}</td>
                    <td class="text-center">
                        ${!empty(data.status_perpustakaan) ? `<span class="bi bi-check-circle-fill text-success"></span>` : `<span class="bi bi-x-circle-fill text-danger"></span>`}
                    </td>
                    <td class="text-center">
                        ${!empty(data.status_subkomponent) ? `<span class="bi bi-check-circle-fill text-success"></span>` : `<span class="bi bi-x-circle-fill text-danger"></span>`}
                    </td>
                    <td class="text-center">
                        ${!empty(data.status_buktifisik) ? `<span class="bi bi-check-circle-fill text-success"></span>` : `<span class="bi bi-x-circle-fill text-danger"></span>`}
                    </td>
                    <td class="text-center btn-group-vertical" width="100%">                        
                        ${empty(data.status_perpustakaan)? `<a href="#" class="btn btn-warning btn-sm btn-verify-perpustakaan mb-1" title="Verify Perpustakaan" data-id="${data.id}">Verify Perpustakaan</a>` : ''}
                        ${empty(data.status_subkomponent)? `<a href="#" class="btn btn-warning btn-sm btn-verify-subkomponen mb-1" title="Verify Subkomponen" data-id="${data.id}">Verify Subkomponen</a>` : ''}
                        ${empty(data.status_buktifisik)? `<a href="#" class="btn btn-warning btn-sm btn-verify-bukti-fisik" title="Verify Bukti Fisik" data-id="${data.id}">Verifi Bukti Fisik</a>` : ''}
                    </td>
                </tr>
            `
        });
        return result;
    }
    
    $(document).on('click', '.btn-verify-perpustakaan', function() {
        $('#modal-perpustakaan').modal('show');
        loading($("#modal-perpustakaan") , true);
        ajaxData(`${baseUrl}/api/v1/getListLibrary`, 'GET', {
            "id" : $(this).data('id'),
            "status" : $(".dropdown-status").val()
        }, function(resp) {
            const result = resp.data[0]?.profil_perpustakaan;
            if (!result) {
                setTimeout(() => {
                    $('#modal-perpustakaan').modal('hide')
                    toast("Data not found", 'warning');
                }, 1000);
                return;
            }
            loading($("#modal-perpustakaan") , false);
        
            $.each(result, function(index, data) {
                if (index == "data_perpustakaan_image") return;
                $('#modal-perpustakaan').find(`[data-bind-${index}]`).html(data);
            });
                
            if (!empty(result.data_perpustakaan_image)) {
                result.data_perpustakaan_image.forEach(function(image) {
                    $('#modal-perpustakaan').find('[data-bind-data_perpustakaan_image]').html(`<a href="${image.url}" target="_blank">View Image</a>`);
                });
            } else {
                $('#modal-perpustakaan').find('[data-bind-image]').html(`-`);
            }

            $("#modal-perpustakaan").find('[name=user_id]').val(result.user_id);
            $("#modal-perpustakaan").find('[name=library_id]').val(result.library_id);
            settingSummerNote($(".sumernote-perpustakaan"))
        },
        function() {
            loading($("#modal-perpustakaan"));
            setTimeout(function() {
                $('#detailLibrary').modal('hide');
            }, 1000);
        });
    });

    $(document).on('click', '.btn-verify-subkomponen', function() {
        $('#modal-subkomponent').modal('show');
        loading($("#modal-subkomponent") , true);
        ajaxData(`${baseUrl}/api/v1/getListKomponen`, 'GET', {
            "id" : $(this).data('id'),
            "status" : $(".dropdown-status").val()
        }, function(resp) {
            const result = resp.data[0]?.subkomponen;
            if (!result) {
                setTimeout(() => {
                    $('#modal-subkomponent').modal('hide')
                    toast("Data not found", 'warning');
                }, 1000);
                return;
            }
            loading($("#modal-subkomponent") , false);
            
            let dataDetail = "";

            $.each(result, function(index, data) {
                dataDetail += `
                    <tr>
                        <td>${index+1}</td>
                        <td>${data.komponen.title_komponens}</td>
                        <td class="jml-ik text-center">${data.komponen.jumlah_indikator_kunci}</td>
                        <td class="text-center">${data.skor_subkomponen}</td>
                        <td class="text-center">${data.komponen.bobot}</td>
                        <td class="text-center">${data.nilai}</td>
                        <td class="text-center">
                            <i class="${data.is_verified ? 'bi bi-check-circle-fill text-success' : 'bi bi-x-circle-fill text-danger'}"></i>
                        <td class="text-center"><a href="#" class="openPopup" link="${data.bukti_dukung[0].url}">View File</a></td>
                        <td class="form-group">
                            <select class="form-select" name="repeater[${index}][status]" required>
                                <option value="" selected disabled> -- Status ---</option>
                                <option value="1"> Lolos Verifikasi </option>
                                <option value="0"> Tidak Lolos Verifikasi </option>
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="repeater[${index}][id]" value="${data.id}">
                            <textarea class="form-control sumernote-komponent" id="sumkomp${index}" name="repeater[${index}][catatan]" placeholder="notes">
                            </textarea>
                        </td>
                    </tr>
                `
            });
            $('#modal-subkomponent').find('.table-komponent tbody').html(dataDetail);
            $('#modal-subkomponent').find('[name=user_id]').val(result[0]?.user_id);
            settingSummerNote($("#modal-subkomponent .sumernote-komponent"));
        },
        function() {
            loading($("#modal-subkomponent"));
            setTimeout(function() {
                $('#modal-subkomponent').modal('hide');
            }, 1000);
        });
    });

    $(document).on('click', '.btn-verify-bukti-fisik', function() {
        $('#modal-buktifisik').modal('show');
        loading($("#modal-buktifisik") , true);
        ajaxData(`${baseUrl}/api/v1/getListBuktiFisik`, 'GET', {
            "id" : $(this).data('id'),
            "status" : $(".dropdown-status").val()
        }, function(resp) {
            const result = resp.data[0]?.BuktiFisik;
            if (!result) {
                setTimeout(() => {
                    $('#modal-buktifisik').modal('hide')
                    toast("Data not found", 'warning');
                }, 1000);
                return;
            }
            loading($("#modal-buktifisik") , false);

            let dataDetail = "";

            $.each(result, function(index, data) {
                dataDetail += `
                    <tr>
                        <td>${index+1}</td>
                        <td>${data.bukti_fisik_data.title_bukti_fisik}</td>
                        <td><a href="#" class="openPopup" link="${data.bukti_fisik_upload[0].url}">View File</a></td>
                        <td class="form-group">
                            <select class="form-select" name="repeater[${index}][status]" required>
                                <option value="" selected disabled> -- Status ---</option>
                                <option value="1"> Lolos Verifikasi </option>
                                <option value="0"> Tidak Lolos Verifikasi </option>
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="repeater[${index}][id]" value="${data.bukti_fisik_data_id}">
                            <textarea class="form-control sumernote-buktifisik" id="sumkomp${index}" name="repeater[${index}][catatan]" placeholder="notes">
                            </textarea>
                        </td>
                    </tr>
                `
            });
            $('#modal-buktifisik').find('.table-bukti tbody').html(dataDetail);
            $('#modal-buktifisik').find('[name=user_id]').val(result[0]?.user_id);
            settingSummerNote($("#modal-buktifisik .sumernote-buktifisik"));
           
        },
        function() {
            loading($("#modal-buktifisik"));
            setTimeout(function() {
                $('#modal-buktifisik').modal('hide');
            }, 1000);
        });
    });

    function settingSummerNote(selector) {
        $(selector).summernote({
            height: 100,
            disableDragAndDrop: true,
            paste: {
                forcePlainText: true,
                text: function() {},
                onBeforePaste: function(evt) {
                    evt.preventDefault();
                },
            },
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', []],
                ['misc', ['codeview']],
            ],
            callbacks: {
                onImageUpload: function() {
                    return false;
                },
            },
        });
    }


    $("#form-subkomponent").on('submit', function(e) {
        e.preventDefault();
        let url = `${baseUrl}/api/v1/storeTextEditor/`;
        const data = $(this).serialize() + `&type=subkomponen`;
        loadingButton($(this))
        ajaxData(url, 'POST', data, function(resp) {
            toast("Data has been saved");
            $('#modal-komponent').modal('hide');
            loadingButton($("#form-komponent"), false)
            GetData(req,"libraries", formatTable);
        }, function(data) {
            loadingButton($("#form-komponent"), false)
        });
    });

    $("#form-buktifisik").on('submit', function(e) {
        e.preventDefault();
        let url = `${baseUrl}/api/v1/storeTextEditor/`;
        const data = $(this).serialize() + `&type=bukti_fisik`;
        loadingButton($(this))
        ajaxData(url, 'POST', data, function(resp) {
            toast("Data has been saved");
            $('#modal-buktifisik').modal('hide');
            loadingButton($("#form-buktifisik"), false)
            GetData(req,"libraries", formatTable);
        }, function(data) {
            loadingButton($("#form-buktifisik"), false)
        });
    });


    $("#form-perpustakaan").on('submit', function(e) {
        e.preventDefault();
        let url = `${baseUrl}/api/v1/storeTextEditor/`;
        const data = $(this).serialize() + `&type=perpustakaan`;
        loadingButton($(this))
        ajaxData(url, 'POST', data, function(resp) {
            toast("Data has been saved");
            $('#modal-perpustakaan').modal('hide');
            loadingButton($("#form-perpustakaan"), false)
            GetData(req,"libraries", formatTable);
        }, function(data) {
            loadingButton($("#form-perpustakaan"), false)
        });
    });

    $(document).on('click', '.openPopup', function() {
        window.open($(this).attr('link'), 'popup', 'width=800,height=600');
    })
</script>
@endsection