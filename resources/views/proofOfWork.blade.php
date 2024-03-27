@extends('layout.admin')

@section('title', 'Bukti Fisik')
@section('title_page', 'Bukti Fisik')
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
        @include('components.table-pagenation', ['table' => 'bukti_fisik' , 'url' => '/api/v1/operator/getListBuktiFisik' , 'headers' => [
            "Pic Name",
            "Pic email",
            "Action"
        ] , 'pagination' => true])
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
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


</script>
@endsection