@extends('layout.admin')

@section('title', 'Komponen')
@section('title_page', 'Komponen')
@section('desc_page', '')
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
        @include('components.table-pagenation', ['table' => 'bukti_fisik' , 'url' => '/api/v1/getListKomponen' , 'headers' => [
            "Pic Name",
            "Pic email",
            "Action"
        ] , 'pagination' => true])
    </div>
</div>


<div class="modal fade text-left" id="detailKomponen" tabindex="-1" role="dialog"
    aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title white" id="">
                    Detail Komponen
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
                        </tr>
                    </thead>
                    <tbody>
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
        req.status = 'Baru';
        GetData(req,"bukti_fisik", formatTable);

        $(".dropdown-status").change(function() {
            req.status = $(this).val();
            req.page = 1;
            GetData(req,"bukti_fisik", formatTable);
        });
    });

    function formatTable(data) {
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
        $('#detailKomponen').modal('show');
        loading($("#detailKomponen") , true);
        ajaxData(`${baseUrl}/api/v1/getListKomponen`, 'GET', {
            "id" : $(this).data('id'),
            "status" : $(".dropdown-status").val()
        }, function(resp) {
            const result = resp.data[0]?.subkomponen;
            if (!result) {
                setTimeout(() => {
                    $('#detailKomponen').modal('hide')
                    toast("Data not found", 'warning');
                }, 1000);
                return;
            }
            loading($("#detailKomponen") , false);
            
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
                    </tr>
                `
            });
            $('#detailKomponen').find('.table-komponent tbody').html(dataDetail);
        },
        function() {
            loading($("#detailKomponen"));
            setTimeout(function() {
                $('#detailKomponen').modal('hide');
            }, 1000);
        });
    });

    $(document).on('click', '.openPopup', function() {
        window.open($(this).attr('link'), 'popup', 'width=800,height=600');
    })

</script>
@endsection