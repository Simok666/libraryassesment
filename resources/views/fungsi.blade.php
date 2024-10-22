@extends('layout.admin')
@section('title', 'Fungsi')
@section('title_page', 'Fungsi')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title"></h4>
        <button type="submit" style="float: right" class="btn btn-primary btn-add-eselon">Tambah Fungsi</button>
    </div>
    <div class="card-body">
        <form id="form-fungsi">
            <input type="hidden">
            <table class="table table-striped table-komponent after-loading" id="data-eselon">
                <tbody>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<div class="modal fade text-left" id="modal-add-fungsi" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel4" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">Add Data Fungsi</h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-add-fungsi">
                    {{-- <input type="hidden" name="user_id"> --}}
                    <table class="table table-striped table-komponent after-loading">
                        <tbody>
                            <tr>
                                <th>Fungsi</th>
                                <td>
                                    <input type="text" name="repeater[0][nama_fungsi]" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <th>Pilih Eselon Tiga</th>
                                <td>
                                    <select name="repeater[0][id_eselon_tiga]" class="form-control list-eselon-tiga" required>
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
                <button type="submit" form="form-add-fungsi" class="btn btn-primary ml-1">
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
        getListEselonDua()
        let dataEselon = $("#data-eselon");
        const getData = ajaxData(`${baseUrl}/api/v1/admin/getEselonFungsi?filter=fungsi`, 'GET', [], function(resp) {
            if (!empty(resp.data)) {
                let dataDetail = "";
                resp.data.fungsi.forEach(function(data, index) {
                    console.log(data);
                    let options = '';
                    resp.data.eselonTiga.forEach(function(eselonTiga) {
                        options += `<option value="${eselonTiga.id}">${eselonTiga.nama_satuan_kerja_eselon_3}</option>`;
                    });
                    
                    dataDetail += `
                        <tr>
                            <th> Eselon Tiga </th>
                            <td>
                                <input type="hidden" name="repeater[${index}][id]" value="${data.id ?? ''}" class="form-control">
                                <div class="form-group">
                                    <label class="pull-right">Eselon Dua</label>
                                    <select class="form-select form-control dropdown-status" name="repeater[${index}][id_eselon_dua]" >
                                        <option value="${data.eselons_tiga.id}" selected>${data.eselons_tiga?.nama_satuan_kerja_eselon_3 ?? 'Pilih Eselon 3'}</option>
                                        ${options} <!-- Masukkan opsi yang telah dibangun di sini -->
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="pull-right">Fungsi</label>
                                    <input type="text" name="repeater[${index}][nama_fungsi]" class="form-control" value="${data.nama_fungsi ?? ''}">
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
        $('#modal-add-fungsi').modal('show');
        $('#modal-add-fungsi').find('form')[0].reset();
    });
    

    $("#form-add-fungsi").on('submit', function(e) {
        e.preventDefault();
        const url = `${baseUrl}/api/v1/admin/fungsi`;
        const data = new FormData(this);
        loadingButton($(this))
        ajaxDataFile(url, 'POST', data, function(resp) {
            toast("Data has been saved");
            $('#modal-add-fungsi').modal('hide');
            window.location.reload();
            loadingButton($("#add-eselon"), false)
        }, function(data) {
            loadingButton($("#add-eselon"), false)
        });
    });

    let getListEselonDua = () => {
        const url = `${baseUrl}/api/v1/admin/getEselonFungsi/?filter=eselonTiga`;
        ajaxData(url, 'GET', [], function(resp) {
            let data = resp.data;
            let option = ``;
            console.log(data);
            data.eselonTiga.forEach(element => {
                console.log(element)
                option += `<option value="${element.id}">${element.nama_satuan_kerja_eselon_3}</option>`;
            });
            $(".list-eselon-tiga").append(option);
        }, function(data) {
            
        });
    }

    $("#form-fungsi").on('submit', function(e) {
        e.preventDefault();
        let url = `${baseUrl}/api/v1/admin/fungsi`;
        const data = $(this).serialize();
        
        loadingButton($(this))
        ajaxData(url, 'POST', data, function(resp) {
            toast("Data has been saved");
            loadingButton($("#form-fungsi"), false)
        }, function(data) {
            loadingButton($("#form-fungsi"), false)
        });
    });

</script>
@endsection
