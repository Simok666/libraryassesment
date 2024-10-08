@extends('layout.admin')

@section('title', 'Users')
@section('title_page', 'Users')
@section('desc_page', 'List of all users')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title"></h4>
    </div>
    <div class="card-body">
        @include('components.table-pagenation', ['table' => 'users' , 'url' => '/api/v1/operator/getUser' , 'headers' => [
            "Name",
            "Email",
            "Library",
            "Address",
            "Status",
            "Action"
        ] , 'pagination' => true])
    </div>
</div>

<!-- modal -->
<div class="modal fade text-left" id="warning" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel140" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title white" id="myModalLabel140">
                    Verifikasi User
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                Apakah anda yakin ingin mengaktifkan user ini? <br>
                <span class="">Name: <strong id="name"></strong></span><br>
                <span class="">Email: <strong id="email"></strong></span>
                <form action="index.html" id="user-verify">
                    <input type="hidden" name="id" id="user_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>

                <button type="submit" form="user-verify" class="btn btn-warning ml-1">
                    <span class="d-none d-sm-block label-submit">Accept</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="detailUser" tabindex="-1" role="dialog"
    aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title white" id="">
                    Detail User
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

                <table class="table table-striped after-loading">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td data-bind-name></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td data-bind-email></td>
                        </tr>
                        <tr>
                            <th>Pic</th>
                            <td data-bind-pic_name></td>
                        </tr>
                        <tr>
                            <th>Leader Name</th>
                            <td data-bind-leader_instance_name></td>
                        </tr>
                        <tr>
                            <th>Library Name</th>
                            <td data-bind-library_name></td>
                        </tr>
                        <tr>
                            <th>Head Library Name</th>
                            <td data-bind-head_library_name></td>
                        </tr>
                        <tr>
                            <th>NPP</th>
                            <td data-bind-npp></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td data-bind-address></td>
                        </tr>
                        <tr>
                            <th>Map Coordinates</th>
                            <td data-bind-map_coordinates></td>
                        </tr>
                        <tr>
                            <th>Village</th>
                            <td data-bind-village></td>
                        </tr>
                        <tr>
                            <th>Subdistrict</th>
                            <td data-bind-subdistrict></td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td data-bind-city></td>
                        </tr>
                        <tr>
                            <th>Province</th>
                            <td data-bind-province></td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td data-bind-number_telephone></td>
                        </tr>
                        <tr>
                            <th>Website</th>
                            <td data-bind-website></td>
                        </tr>
                        <tr>
                            <th>Library Email</th>
                            <td data-bind-library_email></td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <td data-bind-image></td>
                        </tr>
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
        GetData(req,"users", formatusers);
    });

    function formatusers(data) {
        var result = "";
        $.each(data, function(index, data) {
            result += `
                <tr>
                    <td>${data.name}</td>
                    <td>${data.email}</td>
                    <td>${empty(data.library_name) ? "-" : data.library_name}</td>
                    <td>${data.address}</td>
                    <td>
                        ${data.is_verified == '1' ? `<span class="badge bg-success">Verified</span>` : ``}
                        ${data.is_verified == '0' ? `<span class="badge bg-danger">Not Verified</span>` : ``}
                    </td>
                    <td>
                        <a href="#" class="btn btn-info btn-icon btn-sm btn-detail" title="Detail" data-name="${data.name}" data-email="${data.email}" data-id="${data.id}"><span class="bi bi-info-circle"> </span></a>
                        ${data.is_verified == '0' ? `<a  href="#" data-bs-toggle="modal" data-bs-target="#warning" class="btn btn-warning btn-icon btn-sm btn-verify" title="Verify" data-name="${data.name}" data-email="${data.email}" data-id="${data.id}"><span class="bi bi-check2"> </span></a>` : ``}
                </tr>
            `
        });
        return result;
    }

    $(document).on('click', '.btn-verify', function() {
        $('#name').html($(this).data('name'));
        $('#email').html($(this).data('email'));
        $('#user_id').val($(this).data('id'));
    });

    $("#user-verify").on('submit', function(e) {
        e.preventDefault();
        let id = $(this).find("#user_id").val();
        let url = `${baseUrl}/api/v1/operator/verified/${id}`;
        let data = {
            "is_verified" : 1
        };
        loadingButton($(this))
        ajaxData(url, 'PUT', data, function(resp) {
            toast(resp.message);
            $('#warning').modal('hide');
            $('#user-verify').trigger('reset');
            loadingButton($("#user-verify"), false)
            GetData(req,"users", formatusers);
        }, function(data) {
            loadingButton($("#user-verify"), false)
        });
    });
    
    $(document).on('click', '.btn-detail', function() {
        $('#detailUser').modal('show');
        loading($("#detailUser") , true);
        ajaxData(`${baseUrl}/api/v1/operator/getUser`, 'GET', {
            "id" : $(this).data('id')
        }, function(resp) {
            loading($("#detailUser") , false);
            if (empty(resp.data)) {
                toast("Data not found", 'warning');
                $('#detailUser').modal('hide');
            }

            let result = resp.data[0];
            $.each(result, function(index, data) {
                if (index == "image") return;
                $('#detailUser').find(`[data-bind-${index}]`).html(data);
            });
            {{-- $('#detailUser').find('[data-bind-id]').html(result.id);
            $('#detailUser').find('[data-bind-name]').html(result.name);
            $('#detailUser').find('[data-bind-email]').html(result.email);
            $('#detailUser').find('[data-bind-instance-name]').html(result.instance_name);
            $('#detailUser').find('[data-bind-pic-name]').html(result.pic_name);
            $('#detailUser').find('[data-bind-address]').html(result.address);
            $('#detailUser').find('[data-bind-village]').html(result.village);
            $('#detailUser').find('[data-bind-subdistrict]').html(result.subdistrict);
            $('#detailUser').find('[data-bind-city]').html(result.city);
            $('#detailUser').find('[data-bind-province]').html(result.province);
            $('#detailUser').find('[data-bind-number-telephone]').html(result.number_telephone);
            $('#detailUser').find('[data-bind-map-coordinates]').html(result.map_coordinates);
            $('#detailUser').find('[data-bind-library-email]').html(result.library_email);
            $('#detailUser').find('[data-bind-is-verified]').html(result.is_verified); --}}
            if (!empty(result.image)) {
                result.image.forEach(function(image) {
                    $('#detailUser').find('[data-bind-image]').html(`<a href="${image.url}" target="_blank">View Image</a>`);
                });
            } else {
                $('#detailUser').find('[data-bind-image]').html(`-`);
            }
        },
        function() {
            loading($("#detailUser"));
            setTimeout(function() {
                $('#detailUser').modal('hide');
            }, 1000);
        });
    });
</script>
@endsection