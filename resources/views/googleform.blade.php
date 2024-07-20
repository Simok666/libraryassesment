@extends('layout.admin')
@section('title', 'Google Form')
@section('title_page', 'Google Form')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title"></h4>
    </div>
    <div class="card-body">
        <form id="form-google">
            <input type="hidden">
            <table class="table table-striped table-komponent after-loading">
                <tbody>
                    <tr>
                        <th>Link</th>
                        <td>
                            <input type="text" name="link" class="form-control">
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        const getData = ajaxData(`${baseUrl}/api/v1/operator/getLinkGoogleForm`, 'GET', [], function(resp) {
            if (!empty(resp.data)) {
                $("#form-google input[name='link']").val(resp.data.link);
            }
        });
    });

    $("#form-google").on('submit', function(e) {
        e.preventDefault();
        let url = `${baseUrl}/api/v1/operator/storeLinkGoogleForm/`;
        const data = $(this).serialize();
        loadingButton($(this))
        ajaxData(url, 'POST', data, function(resp) {
            toast("Data has been saved");
            loadingButton($("#form-google"), false)
        }, function(data) {
            loadingButton($("#form-google"), false)
        });
    });

</script>
@endsection
