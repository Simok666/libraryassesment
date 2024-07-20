@extends('layout.admin')

@section('title', 'Contoh Komponen')
@section('title_page', 'Contoh Komponen')
@section('desc_page', '')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title"></h4>
    </div>
    <div class="card-body">
        @include('components.table-pagenation', ['table' => 'example-component' , 'url' => '/api/v1/operator/getKomponen' , 'headers' => [
        "NO.",
        "Title" ,
        "Jenis Perpustakaan" ,
        "File",
        "Action"
        ] , 'pagination' => false])
    </div>
</div>

<div class="modal fade text-left" id="UploadFile" tabindex="-1" role="dialog"
    aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title white" id="">
                    Upload File
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="index.html" id="form-komponen">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="id">
                                <input type="file" class="form-control" name="example[]">
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

                <button type="submit" form="form-komponen" class="btn btn-warning ml-1">
                    <span class="d-none d-sm-block label-submit">Accept</span>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        GetData(req, "example-component", formatTable);
        // submit form 
        $("#form-komponen").submit(function(e) {
            e.preventDefault();
            loadingButton($("form"))
            ajaxDataFile(`{{ url('/api/v1/operator/storeKomponenExample') }}`, 'POST', new FormData(this),
                function(resp) {
                    toast("Save data success", 'success');
                    loadingButton($("#form-komponen"), false);
                    
                    GetData(req, "example-component", formatTable);

                    $("#UploadFile").modal('hide');
                    setTimeout(function() {
                        // window.location = "{{ url('Dashboard.html') }}";
                    }, 3000);
                },
                function (data) {
                    loadingButton($("#form-komponen"), false)
                }
            );
        });
    });

    function formatTable(data) {
        var result = "";
        $.each(data, function(index, data) {
            result += `
                <tr class="bukti-${data.id}">
                    <td>
                        ${index+1}
                        <input type="hidden" name="${index}[id]" value="${data.id}">
                    </td>
                    <td>${data.title_komponens}</td>
                    <td>${data.jenis_perpustakaan}</td>
                    <td>
                        ${empty(data.contoh) ? '-' : `<a href="${data.contoh.pop()?.url}" target="_blank">Download</a>`  }
                    </td>
                    <td>
                        <a href="#" class="btn btn-warning btn-icon btn-sm btn-edit" title="Detail" data-title="${data.title_komponens}" data-id="${data.id}"><span class="bi bi-pencil"> </span></a>
                    </td>
                </tr>
            `
        });
        return result;
    }

    $(document).on('click', '.btn-edit', function() {
        $("#form-komponen").trigger('reset');
        $('#UploadFile').modal('show');
        $('#form-komponen input[name="id"]').val($(this).data('id'));
        $('#UploadFile .modal-title').html('Upload File ' + $(this).data('title'));
    });

</script>
@endsection
