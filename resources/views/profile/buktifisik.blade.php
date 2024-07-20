@extends('layout.admin')

@section('title', 'Bukti Fisik')
@section('title_page', 'Bukti Fisik')
@section('desc_page', '')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title"></h4>
    </div>
    <div class="card-body">
        <form id="form-buktifisik">
            @include('components.table-pagenation', ['table' => 'buktifisik' , 'url' => '/api/v1/user/getBuktiFisikData' , 'headers' => [
            "NO.",
            "TITLE" ,
            "BUKTI FISIK"
            ] , 'pagination' => false])
            <div class="row d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        GetData(req, "buktifisik", formatTable, function(resp) {
            ajaxData( `${baseUrl}/api/v1/user/getDetailBuktiFisik`, "GET", [] , function(resp) {
                if (!empty(resp.data)) {
                    $.each(resp.data, function(index, item) {
                        if (!empty(item.bukti_fisik_upload)) {
                            $(`.bukti-${item.bukti_fisik_data_id} .bukti-dukung`).append(`<a href="${item.bukti_fisik_upload.pop().url}" target="_blank">Download File Sebelumnya</a>`);
                            $(`.bukti-${item.bukti_fisik_data_id} .bukti-dukung input`).removeAttr("required");
                        }
                    })  
                }
            });
        });
        // submit form 
        $("#form-buktifisik").submit(function(e) {
            e.preventDefault();
            loadingButton($("form"))
            ajaxDataFile(`{{ url('/api/v1/user/storeBuktiFisik') }}`, 'POST', new FormData(this),
                function(resp) {
                    toast("Save data success", 'success');
                    loadingButton($("form"), false);
                    setTimeout(function() {
                        // window.location = "{{ url('Dashboard.html') }}";
                    }, 3000);
                },
                function (data) {
                    loadingButton($("form"), false)
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
                        <input type="hidden" name="${index}[bukti_fisik_data_id]" value="${data.id}">
                    </td>
                    <td>${data.title_bukti_fisik}</td>
                    <td class="bukti-dukung"><input required class="form-control" name="${index}[bukti_fisik_upload]" type="file"></td>
                </tr>
            `
        });
        return result;
    }

</script>
@endsection
