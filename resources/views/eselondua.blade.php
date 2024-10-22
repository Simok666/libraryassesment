@extends('layout.admin')
@section('title', 'Eselon Dua')
@section('title_page', 'Eselon Dua')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title"></h4>
        <button type="submit" style="float: right" class="btn btn-primary btn-add-eselon">Tambah Eselon Dua</button>
    </div>
    <div class="card-body">
        <form id="form-eselon-dua">
            <input type="hidden">
            <table class="table table-striped table-komponent after-loading" id="data-eselon">
                <tbody>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<div class="modal fade text-left" id="modal-add-eselon-dua" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel4" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">Add Data Eselon Dua</h4>
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
                                <th>Eselon Dua</th>
                                <td>
                                    <input type="text" name="repeater[0][nama_satuan_kerja_eselon_2]" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <th>Pilih Eselon Satu</th>
                                <td>
                                    <select name="repeater[0][id_eselon_satu]" class="form-control list-eselon-satu" required>
                                        <option value="" disabled sekected>Pilih Eselon</option>
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
        getListGrade();
        let dataEselon = $("#data-eselon");
        const getData = ajaxData(`${baseUrl}/api/v1/admin/getEselonFungsi?filter=eselonDua`, 'GET', [], function(resp) {
            if (!empty(resp.data)) {
                let dataDetail = "";
                resp.data.eselonDua.forEach(function(data, index) {
                    let options = '';
                    resp.data.eselonSatu.forEach(function(eselonSatu) {
                        options += `<option value="${eselonSatu.id}">${eselonSatu.nama_satuan_kerja_eselon_1}</option>`;
                    });
                    
                    dataDetail += `
                        <tr>
                            <th> Eselon Dua </th>
                            <td>
                                <input type="hidden" name="repeater[${index}][id]" value="${data.id ?? ''}" class="form-control">
                                <div class="form-group">
                                    <label class="pull-right">Eselon 1</label>
                                    <select class="form-select form-control dropdown-status" name="repeater[${index}][id_eselon_satu]" >
                                        <option value="${data.eselon.id}" selected>${data.eselon?.nama_satuan_kerja_eselon_1 ?? 'Pilih Eselon 1'}</option>
                                        ${options} <!-- Masukkan opsi yang telah dibangun di sini -->
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="pull-right">Eselon 2</label>
                                    <input type="text" name="repeater[${index}][nama_satuan_kerja_eselon_2]" class="form-control" value="${data.nama_satuan_kerja_eselon_2 ?? ''}">
                                </div>
                           </td>
                        </tr>
                    `;
                });
                dataEselon.find('tbody').html(dataDetail);
            }
        });
    });
    

    $(document).on('click', '.btn-add-eselon', function() {
        $('#modal-add-eselon-dua').modal('show');
        $('#modal-add-eselon-dua').find('form')[0].reset();
    });
    

    $("#form-add-eselon").on('submit', function(e) {
        e.preventDefault();
        const url = `${baseUrl}/api/v1/admin/eselonDua`;
        const data = new FormData(this);
        loadingButton($(this))
        ajaxDataFile(url, 'POST', data, function(resp) {
            toast("Data has been saved");
            $('#modal-add-eselon-dua').modal('hide');
            window.location.reload();
            loadingButton($("#add-eselon"), false)
        }, function(data) {
            loadingButton($("#add-eselon"), false)
        });
    });

    let getListGrade = () => {
        const url = `${baseUrl}/api/v1/admin/getEselonFungsi/?filter=eselonSatu`;
        ajaxData(url, 'GET', [], function(resp) {
            let data = resp.data;
            let option = ``;

            data.forEach(element => {
                console.log(element)
                option += `<option value="${element.id}">${element.nama_satuan_kerja_eselon_1}</option>`;
            });
            $(".list-eselon-satu").append(option);
        }, function(data) {
            
        });
    }

    $("#form-eselon-dua").on('submit', function(e) {
        e.preventDefault();
        let url = `${baseUrl}/api/v1/admin/eselonDua`;
        const data = $(this).serialize();
    
        loadingButton($(this))
        ajaxData(url, 'POST', data, function(resp) {
            toast("Data has been saved");
            loadingButton($("#form-eselon-dua"), false)
        }, function(data) {
            loadingButton($("#form-eselon-dua"), false)
        });
    });

</script>
@endsection
