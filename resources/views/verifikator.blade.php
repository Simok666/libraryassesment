@extends('layout.admin')

@section('title', 'Verifikators')
@section('title_page', 'Verifikators')
@section('desc_page', '')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Verifikator Desk</h4>
    </div>
    <div class="card-body" data-type="desk">
        @include('components.table-pagenation', ['table' => 'desk' , 'url' => '/api/v1/operator/getListVerifikatorDesk' , 'headers' => [
        "Name",
        "email",
        "Action"
        ] , 'pagination' => true])
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Verifikator Field</h4>
    </div>
    <div class="card-body" data-type="field">
        @include('components.table-pagenation', ['table' => 'field' , 'url' => '/api/v1/operator/getListVerifikatorField' , 'headers' => [
        "Name",
        "email",
        "Action"
        ] , 'pagination' => true])
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        GetData(req, "desk", formatTable);
        GetData(req, "field", formatTable);

        $(".datatable-desk, .datatable-field").on('click', '.btn-notif', function() {
            let buttonNotif = $(this);
            let idVefikator = $(this).data('id');
            let type = $(this).parent().parent().parent().parent().parent().parent().data("type");
            CustomloadingButton(buttonNotif);
            ajaxData(`${baseUrl}/api/v1/operator/notifyEmailVerifikator/${idVefikator}?type=${type}`, 'POST', {}
                , function(resp) {
                    CustomloadingButton(buttonNotif, false);
                }
                , function() {
                    CustomloadingButton(buttonNotif, false);
                }
            );
        });
    });

    function formatdesk(data) {
        var result = "";
        $.each(data, function(index, data) {
            result += `
                <tr>
                    <td>${data.name}</td>
                    <td>${data.email}</td>
                    <td>                        
                        <a href="#" class="btn btn-info btn-icon btn-sm btn-notif" title="Notifikasi" data-id="${data.id}"><span class="bi bi-bell"> </span></a>
                    </td>                
                </tr>
            `
        });
        return result;
    }

    function formatfield(data) {
        var result = "";
        $.each(data, function(index, data) {
            result += `
                <tr>
                    <td>${data.name}</td>
                    <td>${data.email}</td>
                    <td>                        
                        <a href="#" class="btn btn-info btn-icon btn-sm btn-notif" title="Notifikasi" data-id="${data.id}"><span class="bi bi-bell"> </span></a>
                    </td>                
                </tr>
            `
        });
        return result;
    }


    

</script>
@endsection
