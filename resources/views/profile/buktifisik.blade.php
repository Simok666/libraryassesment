@extends('layout.admin')

@section('title', 'Component Libraries')
@section('title_page', 'Component Libraries')
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
            "BUKTI Fisik"
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
        GetData(req, "buktifisik", formatTable);
        // submit form 
        $("#form-buktifisik").submit(function(e) {
            e.preventDefault();
            loadingButton($("form"))
            ajaxDataFile(`{{ url('/api/v1/user/storeBuktiFisik') }}`, 'POST', new FormData(this),
                function(resp) {
                    toast("Save data success", 'success');
                    loadingButton($("form"), false);
                    setTimeout(function() {
                        window.location = "{{ url('Dashboard.html') }}";
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
                <tr>
                    <td>
                        ${index+1}
                        <input type="hidden" name="${index}[bukti_fisik_data_id]" value="${data.id}">
                    </td>
                    <td>${data.title_bukti_fisik}</td>
                    <td><input required class="form-control" name="${index}[bukti_fisik_upload]" type="file"></td>
                </tr>
            `
        });
        return result;
    }

</script>
@endsection
