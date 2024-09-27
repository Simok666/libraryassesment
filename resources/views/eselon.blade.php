@extends('layout.admin')
@section('title', 'Eselon Satu')
@section('title_page', 'Eselon Satu')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title"></h4>
        <button type="submit" style="float: right" class="btn btn-primary btn-add-eselon">Tambah Eselon</button>
    </div>
    <div class="card-body">
        <form id="form-eselon">
            <input type="hidden">
            <table class="table table-striped table-komponent after-loading" id="data-eselon">
                <tbody>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<div class="modal fade text-left" id="modal-add-eselon-satu" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel4" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">Add Data Eselon Satu</h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-add-eselon">
                    {{-- <input type="hidden" name="user_id"> --}}
                    <table class="table table-striped table-komponent after-loading">
                        <tbody>
                            <tr>
                                <th>Eselon Satu</th>
                                <td>
                                    <input type="text" name="repeater[0][nama_satuan_kerja_eselon_1]" class="form-control">
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
                <button type="submit" form="form-add-eselon" class="btn btn-primary ml-1">
                    <span class="d-none d-sm-block">Accept</span>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        let dataEselon = $("#data-eselon");
        const getData = ajaxData(`${baseUrl}/api/v1/admin/getEselonFungsi?filter=eselonSatu`, 'GET', [], function(resp) {
            if (!empty(resp.data)) {
                let dataDetail = "";
                resp.data.forEach(function(data, index) {
                    dataDetail += `
                        <tr>
                            <th> Eselon </td>
                            <td>
                                <input type="hidden" name="repeater[${index}][id]" value="${data.id ?? ''}" class="form-control">
                                <input type="text" name="repeater[${index}][nama_satuan_kerja_eselon_1]" class="form-control" value="${data.nama_satuan_kerja_eselon_1 ?? ''}">
                            </td>
                        </tr>
                    `;
                });
                dataEselon.find('tbody').html(dataDetail);
            }
        });
    });

    $(document).on('click', '.btn-add-eselon', function() {
        $('#modal-add-eselon-satu').modal('show');
        $('#modal-add-eselon-satu').find('form')[0].reset();
    });

    $("#form-add-eselon").on('submit', function(e) {
        e.preventDefault();
        const url = `${baseUrl}/api/v1/admin/eselonSatu/`;
        const data = new FormData(this);
        loadingButton($(this))
        ajaxDataFile(url, 'POST', data, function(resp) {
            toast("Data has been saved");
            $('#modal-add-eselon-satu').modal('hide');
            window.location.reload();
            loadingButton($("#add-eselon"), false)
        }, function(data) {
            loadingButton($("#add-eselon"), false)
        });
    });

    $("#form-eselon").on('submit', function(e) {
        e.preventDefault();
        let url = `${baseUrl}/api/v1/admin/eselonSatu/`;
        const data = $(this).serialize();
        loadingButton($(this))
        ajaxData(url, 'POST', data, function(resp) {
            toast("Data has been saved");
            loadingButton($("#form-eselon"), false)
        }, function(data) {
            loadingButton($("#form-eselon"), false)
        });
    });

</script>
@endsection
