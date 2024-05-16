@extends('layout.admin')

@section('title', 'Dashboard')
@section('title_page', 'Dashboard')
@section('desc_page', '')
@section('content')
<div class="card pleno d-none">
    <div class="card-body">
        
    </div>
</div>
<div class="card pleno">
    <div class="card-header">
        <h4 class="card-title">List Pleno</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="pull-right">Status</label>
                    <select class="form-select form-control dropdown-status" name="status">
                        <option value="" selected>Semua</option>
                        <option value="Baru">Baru</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
            </div>
        </div>
        @include('components.table-pagenation', ['table' => 'pleno2 d-none pleno' , 'url' => '/api/v1/getPlenoFinal' , 'headers' => [
        "No",
        "Pic Name",
        "Pic email",
        "Grade",
        "Bukti Evaluasi",
        "Action"
        ] , 'pagination' => true])
    </div>
</div>


<div class="modal fade text-left" id="pleno-detail" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel4" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">Detail Pleno</h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-komponent after-loading detail-pleno">
                    <thead>
                        <tr>
                            <td class="text-center">Nama File</td>
                            <td class="text-center">File</td>
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
    // jquery document ready
    const dashboardWithTable = [
        "admin", "operator", "user", "verifikatordesk", "verifikatorfield"
    ]

    $(document).ready(function() {
        let role = session("role");
        if (dashboardWithTable.includes(role)) {
            $(".pleno").removeClass("d-none");
            $(".pleno").removeClass("d-none");
            req.status = $(".dropdown-status").val();
            GetData(req, "pleno2", formatlibraries2);

            $(".dropdown-status").change(function() {
                req.status = $(this).val();
                req.page = 1;
                GetData(req, "pleno2", formatlibraries2);
            });
        }
    });


    function formatlibraries2(data) {
        var result = "";
        $.each(data, function(index, data) {
            result += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${data.pic_name}</td>
                    <td>${data.pic_email}</td>
                    <td>
                        ${!empty(data.grade) ? data.grade : "-"}
                    </td>
                    <td class="text-center">
                        ${!empty(data.bukti_evaluasi) ? `<a href="#" class="openPopup" link="${data.bukti_evaluasi[0].url}">View File</a> `: "-"}
                    </td>
                    <td class="text-center">
                        <a href="#" class="btn btn-warning btn-sm btn-detail-pleno mb-1" title="Detail" data-id="${data.id}">Detail</a>
                    </td>
                </tr>
            `
        });
        return result;
    }


    function formatlibraries(data) {
        var result = "";
        $.each(data, function(index, data) {
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
                        <a href="#" class="btn btn-warning btn-sm btn-detail-pleno mb-1" title="Detail" data-id="${data.id}">Detail</a>
                    </td>
                </tr>
            `
        });
        return result;
    }

    $(document).on('click', '.openPopup', function() {
        window.open($(this).attr('link'), 'popup', 'width=800,height=600');
    })


    $(document).on('click', '.btn-detail-pleno', function() {
        let modal = $("#pleno-detail"); 
        modal.modal('show');
        loading(modal , true);
        ajaxData(`${baseUrl}/api/v1/getPlenoFinal`, 'GET', {
            "id" : $(this).data('id'),
            "status" : $(".dropdown-status").val()
        }, function(resp) {
            const result = resp.data;
            if (!result) {
                setTimeout(() => {
                    modal.modal('hide')
                    toast("Data not found", 'warning');
                }, 1000);
                return;
            }
            loading(modal , false);
            
            let dataDetail = "";
            data = result[0];
            dataDetail += `
                <tr>
                    <td>Draft Sk</td>
                    <td class="text-center">                        
                        ${!empty(data.draft_sk_upload) ? `<a href="#" class="openPopup" link="${data.draft_sk_upload[0].url}">View File</a> `: "-"}
                    </td>
                </tr>
                <tr>
                    <td>Pleno</td>
                    <td class="text-center">                        
                        ${!empty(data.pleno_upload) ? `<a href="#" class="openPopup" link="${data.pleno_upload[0].url}">View File</a> `: "-"}
                    </td>
                </tr>
                <tr>
                    <td>SK Pimpinan Sesban</td>
                    <td class="text-center">                        
                        ${!empty(data.sk_upload_pimpinan) ? `<a href="#" class="openPopup" link="${data.sk_upload_pimpinan[0].url}">View File</a> `: "-"}
                    </td>
                </tr>
                <tr>
                    <td>SK Pimpinan Kaban</td>
                    <td class="text-center">                        
                        ${!empty(data.sk_upload_pimpinan_kaban) ? `<a href="#" class="openPopup" link="${data.sk_upload_pimpinan_kaban[0].url}">View File</a> `: "-"}
                    </td>
                </tr>
            `
            modal.find('tbody').html(dataDetail);
        },
        function() {
            loading(modal);
            setTimeout(function() {
                modal.modal('hide');
            }, 1000);
        });
    });

</script>
@endsection
