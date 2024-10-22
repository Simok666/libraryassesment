@extends('layout.admin')
@section('title', 'Eselon Tiga')
@section('title_page', 'Eselon Tiga')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title"></h4>
        <button type="submit" style="float: right" class="btn btn-primary btn-add-eselon">Tambah Eselon Tiga</button>
    </div>
    <div class="card-body">
        <form id="form-eselon-tiga">
            <input type="hidden">
            <table class="table table-striped table-komponent after-loading" id="data-eselon">
                <tbody>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<div class="modal fade text-left" id="modal-add-eselon-tiga" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel4" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">Add Data Eselon Tiga</h4>
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
                                <th>Eselon Tiga</th>
                                <td>
                                    <input type="text" name="repeater[0][nama_satuan_kerja_eselon_3]" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <th>Pilih Eselon Dua</th>
                                <td>
                                    <select name="repeater[0][id_eselon_dua]" class="form-control list-eselon-dua" required>
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
        getListEselonDua();
        let dataEselon = $("#data-eselon");
        const getData = ajaxData(`${baseUrl}/api/v1/admin/getEselonFungsi?filter=eselonTiga`, 'GET', [], function(resp) {
            if (!empty(resp.data)) {
                let dataDetail = "";
                resp.data.eselonTiga.forEach(function(data, index) {
                    console.log(data);
                    let options = '';
                    resp.data.eselonDua.forEach(function(eselonDua) {
                        options += `<option value="${eselonDua.id}">${eselonDua.nama_satuan_kerja_eselon_2}</option>`;
                    });
                    
                    dataDetail += `
                        <tr>
                            <th> Eselon Tiga </th>
                            <td>
                                <input type="hidden" name="repeater[${index}][id]" value="${data.id ?? ''}" class="form-control">
                                <div class="form-group">
                                    <label class="pull-right">Eselon Dua</label>
                                    <select class="form-select form-control dropdown-status" name="repeater[${index}][id_eselon_dua]" >
                                        <option value="${data.eselons_dua.id}" selected>${data.eselons_dua?.nama_satuan_kerja_eselon_2 ?? 'Pilih Eselon 2'}</option>
                                        ${options} <!-- Masukkan opsi yang telah dibangun di sini -->
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="pull-right">Eselon 3</label>
                                    <input type="text" name="repeater[${index}][nama_satuan_kerja_eselon_3]" class="form-control" value="${data.nama_satuan_kerja_eselon_3 ?? ''}">
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
        $('#modal-add-eselon-tiga').modal('show');
        $('#modal-add-eselon-tiga').find('form')[0].reset();
    });
    

    $("#form-add-eselon").on('submit', function(e) {
        e.preventDefault();
        const url = `${baseUrl}/api/v1/admin/eselonTiga`;
        const data = new FormData(this);
        loadingButton($(this))
        ajaxDataFile(url, 'POST', data, function(resp) {
            toast("Data has been saved");
            $('#modal-add-eselon-tiga').modal('hide');
            window.location.reload();
            loadingButton($("#add-eselon"), false)
        }, function(data) {
            loadingButton($("#add-eselon"), false)
        });
    });

    let getListEselonDua = () => {
        const url = `${baseUrl}/api/v1/admin/getEselonFungsi/?filter=eselonDua`;
        ajaxData(url, 'GET', [], function(resp) {
            let data = resp.data;
            let option = ``;
    
            data.eselonDua.forEach(element => {
                console.log(element)
                option += `<option value="${element.id}">${element.nama_satuan_kerja_eselon_2}</option>`;
            });
            $(".list-eselon-dua").append(option);
        }, function(data) {
            
        });
    }

    $("#form-eselon-tiga").on('submit', function(e) {
        e.preventDefault();
        let url = `${baseUrl}/api/v1/admin/eselonTiga`;
        const data = $(this).serialize();
        
        loadingButton($(this))
        ajaxData(url, 'POST', data, function(resp) {
            toast("Data has been saved");
            loadingButton($("#form-eselon-tiga"), false)
        }, function(data) {
            loadingButton($("#form-eselon-tiga"), false)
        });
    });

</script>
@endsection
