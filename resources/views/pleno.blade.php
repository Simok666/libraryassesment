@extends('layout.admin')

@section('title', 'Pleno')
@section('title_page', 'Pleno')
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
        @include('components.table-pagenation', ['table' => 'libraries' , 'url' => '/api/v1/getListPleno' , 'headers' => [
            "No",
            "Pic Name",
            "Pic email",
            "Draft Sk",
            "Pleno",
            "Pleno Pimpinan Sesban",
            "Pleno Pimpinan Kaban",
            "Isi Komentar Pleno",
            "Generate PDF",
            "Action"
        ] , 'pagination' => true])
    </div>
</div>

<div class="modal fade text-left" id="modal-pleno" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel4" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">Isi Komentar Pleno</h4>
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
                <form id="form-pleno">
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
                <button type="submit" form="form-pleno" class="btn btn-primary ml-1">
                    <span class="d-none d-sm-block">Accept</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="modal-upload-pleno" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel4" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">Upload Pleno</h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-upload-pleno">
                    <input type="hidden" name="user_id">
                    <table class="table table-striped table-komponent after-loading">
                        <tbody>
                            <tr>
                                <th>Draft SK</th>
                                <td>
                                    <input type="file" name="draft_sk_upload[]" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <th>Pleno</th>
                                <td>
                                    <input type="file" name="pleno_upload[]" class="form-control">
                                </td>
                            </tr>
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
                <button type="submit" form="form-upload-pleno" class="btn btn-primary ml-1">
                    <span class="d-none d-sm-block">Accept</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="modal-grade-pleno" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel4" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">Grade Pleno</h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-grade-pleno">
                    <input type="hidden" name="id">
                    <table class="table table-striped table-komponent after-loading">
                        <tbody>
                            <tr>
                                <th>Grade</th>
                                <td>
                                    <select name="grade" class="form-control list-grade" required>
                                        <option value="" disabled sekected>Pilih Grade</option>
                                    </select>
                                </td>
                            </tr>
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
                <button type="submit" form="form-grade-pleno" class="btn btn-primary ml-1">
                    <span class="d-none d-sm-block">Accept</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="modal-evaluasi-pleno" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel4" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">Evaluasi Pleno</h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning evaluasi-alert" role="alert" id="alert-evaluasi-pleno">
                </div>
                <form id="form-evaluasi-pleno">
                    <input type="hidden" name="id">
                    <input type="hidden" name="is_evaluasi">
                    <table class="table table-striped table-komponent after-loading">
                        <tbody>
                            <tr>
                                <th>Bukti Evaluasi</th>
                                <td>
                                    <input type="file" name="bukti_evaluasi[]" class="form-control" required>
                                </td>
                            </tr>
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
                <button type="submit" form="form-evaluasi-pleno" class="btn btn-primary ml-1">
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
        GetData(req,"libraries", formatlibraries);
        getListGrade()
        $(".dropdown-status").change(function() {
            req.status = $(this).val();
            req.page = 1;
            GetData(req,"libraries", formatlibraries);
        });
    });

    function formatlibraries(data) {
        var result = "";
        $.each(data, function(index, data) {
            let evaluasiFile = '';
            if(data.bukti_evaluasi !== null) {
                evaluasiFile = (data.bukti_evaluasi[0].url !== undefined) ? data.bukti_evaluasi[0].url: "";
            } 
            result += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${data.pic_name}</td>
                    <td>${data.pic_email}</td>
                    <td class="text-center">                        
                        ${!empty(data.draft_sk_upload) ? `<a href="#" class="openPopup" link="${data.draft_sk_upload[0].url}">View File</a> `: "-"}
                    </td>
                    <td class="text-center">                        
                        ${!empty(data.pleno_upload) ? `<a href="#" class="openPopup" link="${data.pleno_upload[0].url}">View File</a> `: "-"}
                    </td>
                    <td class="text-center">                        
                        ${!empty(data.sk_upload_pimpinan) ? `<a href="#" class="openPopup" link="${data.sk_upload_pimpinan[0].url}">View File</a> `: "-"}
                    </td>
                    <td class="text-center">                        
                        ${!empty(data.sk_upload_pimpinan_kaban) ? `<a href="#" class="openPopup" link="${data.sk_upload_pimpinan_kaban[0].url}">View File</a> `: "-"}
                    </td>
                     <td class="text-center">                        
                        <a href="#" class="btn btn-warning btn-sm btn-isi-pleno mb-1" title="Isi Pleno" data-id="${data.id}">Isi Pleno</a>
                    </td>
                    <td class="text-center">
                        ${(data.is_pleno == 1 ? `<a href="#" class="openPopup" link="${baseUrl + `/generatePdf/${data.id}`}">View File</a>` : "" )}
                    </td>
                    <td class="text-center" role="group">
                        <div class="btn-group-vertical">
                        <a href="#" class="btn btn-warning btn-sm btn-upload-pleno mb-1" title="Upload Pleno" data-id="${data.id}">Upload Pleno</a>
                        <a href="#" class="btn btn-warning btn-sm btn-grade-pleno mb-1" title="Grade Pleno" data-grade="${data.grade}" data-id="${data.id}">Grade Pleno</a>
                        <a href="#" class="btn btn-warning btn-sm btn-evaluasi-pleno mb-1" title="Evaluasi Pleno" data-file="${evaluasiFile}" data-id="${data.id}">Evaluasi Pleno</a>
                        </div>
                    </td>
                </tr>
            `
        });
        return result;
    }

    $(document).on('click', '.btn-isi-pleno', function() {
        $('#modal-pleno').modal('show');
        loading($("#modal-pleno") , true);
        ajaxData(`${baseUrl}/api/v1/getListKomponen`, 'GET', {
            "id" : $(this).data('id'),
            "status" : $(".dropdown-status").val()
        }, function(resp) {
            const result = resp.data[0]?.subkomponen;
            if (!result) {
                setTimeout(() => {
                    $('#modal-pleno').modal('hide')
                    toast("Data not found", 'warning');
                }, 1000);
                return;
            }
            loading($("#modal-pleno") , false);
            
            let dataDetail = "";

            $.each(result, function(index, data) {
                let statusVerif = data.status_verifikasi;
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
                        </td>
                        <td class="text-center"><a href="#" class="openPopup ${data.bukti_dukung[0]?.url ? data.bukti_dukung[0]?.url :"d-none"}" link="${data.bukti_dukung[0]?.url ? data.bukti_dukung[0]?.url :""}">View File</a></td>
                        <td>
                            <input type="hidden" name="repeater[${index}][id]" value="${data.id}">
                            <textarea class="form-control sumernote-komponent" id="sumkomp${index}" name="repeater[${index}][pleno]" placeholder="notes">
                            ${data.komentar_pleno ?? ""}
                            </textarea>
                        </td>
                    </tr>
                `
            });
            $('#modal-pleno').find('.table-komponent tbody').html(dataDetail);
            $('#modal-pleno').find('[name=user_id]').val(result[0]?.user_id);
            settingSummerNote($("#modal-pleno .sumernote-komponent"));
        },
        function() {
            loading($("#modal-pleno"));
            setTimeout(function() {
                $('#modal-pleno').modal('hide');
            }, 1000);
        });
    });

    $(document).on('click', '.btn-upload-pleno', function() {
        $('#modal-upload-pleno').modal('show');
        $('#modal-upload-pleno').find('form')[0].reset();
        $("#modal-upload-pleno [name=user_id]").val($(this).data('id'));
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

    $("#form-pleno").on('submit', function(e) {
        e.preventDefault();
        let url = `${baseUrl}/api/v1/storeTextEditor/`;
        const data = $(this).serialize();
        loadingButton($(this))
        ajaxData(url, 'POST', data, function(resp) {
            toast("Data has been saved");
            $('#modal-pleno').modal('hide');
            loadingButton($("#form-pleno"), false)
            GetData(req,"libraries", formatlibraries);
        }, function(data) {
            loadingButton($("#form-pleno"), false)
        });
    });

    $("#form-upload-pleno").on('submit', function(e) {
        e.preventDefault();
        const url = `${baseUrl}/api/v1/uploadPleno/${$(this).find('[name=user_id]').val()}`;
        const data = new FormData(this);
        loadingButton($(this))
        ajaxDataFile(url, 'POST', data, function(resp) {
            toast("Data has been saved");
            $('#modal-upload-pleno').modal('hide');
            loadingButton($("#upload-pleno"), false)
            GetData(req,"libraries", formatlibraries);
        }, function(data) {
            loadingButton($("#upload-pleno"), false)
        });
    });
    
    $(document).on('click', '.openPopup', function() {
        window.open($(this).attr('link'), 'popup', 'width=800,height=600');
    })

    let getListGrade = () => {
        const url = `${baseUrl}/api/v1/operator/getGrading`;
        ajaxData(url, 'GET', [], function(resp) {
            let data = resp.data;
            let option = ``;
            data.forEach(element => {
                console.log(element)
                option += `<option value="${element.grade}">${element.details}</option>`;
            });
            $(".list-grade").append(option);
        }, function(data) {
            
        });
    }

    $(document).on('click', '.btn-grade-pleno', function() {
        $(".list-grade").val("").trigger("change");
        $('#modal-grade-pleno').modal('show');
        $("#modal-grade-pleno [name=id]").val($(this).data('id'));
        const grade = $(this).data('grade'); 
        if (!empty(grade)) {
            var selectedOption = $(".list-grade option").filter(function() {
                return $(this).text() === grade;
            });
            console.log(selectedOption)
            selectedOption.prop("selected", true);
        } else {
            $(".list-grade").val("").trigger("change");
        }
    });

    $("#form-grade-pleno").on('submit', function(e) {
        e.preventDefault();
        const url = `${baseUrl}/api/v1/operator/storeGradePleno`;
        const data = $(this).serialize();
        loadingButton($(this))
        ajaxData(url, 'POST', data, function(resp) {
            toast("Data has been saved");
            $('#modal-grade-pleno').modal('hide');
            loadingButton($("#form-grade-pleno"), false)
            GetData(req,"libraries", formatlibraries);
        }, function(data) {
            loadingButton($("#form-grade-pleno"), false)
        });
    });

    $(document).on('click', '.btn-evaluasi-pleno', function() {
        $(".evaluasi-alert").hide();
        $("#modal-evaluasi-pleno").modal('show');
        $('#modal-evaluasi-pleno').find('form')[0].reset();
        $("#modal-evaluasi-pleno [name=id]").val($(this).data('id'));
        $("#modal-evaluasi-pleno [name=is_evaluasi]").val(1);
        fileOld = $(this).data('file');
        if (!empty(fileOld)) {
            $(".evaluasi-alert").show();
            $("#modal-evaluasi-pleno .evaluasi-alert").html(`File Sebelumnya : <a href="${baseUrl}/storage/${fileOld}" target="_blank">Download</a>`);
        }
    })

    $("#form-evaluasi-pleno").on('submit', function(e) {
        e.preventDefault();
        const url = `${baseUrl}/api/v1/operator/storeBuktiEvaluasi`;
        const data = new FormData(this);
        loadingButton($(this))
        ajaxDataFile(url, 'POST', data, function(resp) {
            toast("Data has been saved");
            $('#modal-evaluasi-pleno').modal('hide');
            loadingButton($("#form-evaluasi-pleno"), false)
            GetData(req,"libraries", formatlibraries);
        }, function(data) {
            loadingButton($("#form-evaluasi-pleno"), false)
        });
    });

</script>
@endsection