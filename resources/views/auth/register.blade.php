<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Registration - Library Assesment</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/toastify/toastify.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/leaflet/leaflet.css') }}">
</head>
<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-12 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        {{-- <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo"></a> --}}
                        <h3>Library Assesment</h3>
                    </div>
                    <h1 class="auth-title">Registration</h1>
                    <form action="index.html">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="name" minlength="3" class="form-control form-control-xl" placeholder="Name" required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" name="email" class="form-control form-control-xl" placeholder="Email" required>
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" min="8" name="password" class="form-control form-control-xl" placeholder="Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="instance_name" minlength="3" class="form-control form-control-xl" placeholder="Instance Name" required>
                            <div class="form-control-icon">
                                <i class="bi bi-building"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="pic_name" minlength="3" class="form-control form-control-xl" placeholder="PIC Name" required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="mb-4 position-relative has-icon-left">
                            <label for="sk_image">Sk Image</label>
                            <input type="file" name="sk_image[]" id="sk_image" class="form-control form-control-xl" placeholder="Choose Image" required>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="address" class="form-control form-control-xl" placeholder="Address" required>
                            <div class="form-control-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <div id="map" style="height: 300px;"></div>
                            <input type="hidden" name="map_coordinates" id="map_coordinates" value="" required>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" min="5" name="village" id="village" class="form-control form-control-xl" placeholder="Village" required>
                            <div class="form-control-icon">
                                <i class="bi bi-building"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" min="5" name="subdistrict" id="subdistrict" class="form-control form-control-xl" placeholder="Subdistrict" required>
                            <div class="form-control-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" min="5" name="city" id="city" class="form-control form-control-xl" placeholder="City" required>
                            <div class="form-control-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" min="5" name="province" id="province" class="form-control form-control-xl" placeholder="Province" required>
                            <div class="form-control-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" min="10" name="number_telephone" id="number_telephone" class="form-control form-control-xl" placeholder="08123456789" value="" required>
                            <div class="form-control-icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" name="library_email" id="library_email" class="form-control form-control-xl" placeholder="tipsi@gmail.com" value="tipsi@gmail.com">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="submit">Submit</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Already have an account? <a href="{{ url('auth-login.html') }}" class="font-bold">Log
                                in</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendors/toastify/toastify.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('vendors/leaflet/leaflet.js') }}"></script>

    <script>
        // if not empty token redirect
        if (!empty(session('token'))) {
            window.location.href = "{{ url('dashboard') }}";
        }
        // jquery on submit
        $(document).ready(function() {
            $('form').submit(function(e) {
                e.preventDefault();
                var form = this;
                var formData = new FormData(form);
                $.ajax({
                    url: `{{ url('api/v1/user/register') }}`,
                    type: 'POST',
                    dataType: "JSON",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (resp) {
                        toast("Register Success", 'success');
                        setTimeout(function () {
                            window.location = "{{ url('auth-login.html') }}";
                        }, 3000);
                    },
                    error: function (data) {
                        let code = data.responseJSON.code;
                        if (code >= 500) {
                            toast("Something went wrong, please try again", 'danger');
                        } else {
                            toast(data.responseJSON.message, 'warning');
                        }
                    }
                });
            });
        })

    </script>


    <script>
        var map;
        var marker;

        function initMap() {
            map = L.map('map', {
                center: [-6.175392, 106.827153]
                , zoom: 15
                , zoomControl: false
            });

            let defaultMarker = L.marker([-6.175392, 106.827153]).addTo(map)

            L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);

            L.control.zoom({
                position: "topright"
            }).addTo(map);

            navigator.geolocation.getCurrentPosition(function(position) {
                let pos = {
                    lat: position.coords.latitude
                    , lng: position.coords.longitude
                };

                map.removeLayer(defaultMarker);
                map.setView([pos.lat, pos.lng], 15);
                marker = L.marker([pos.lat, pos.lng]).addTo(map);
                document.getElementById('map_coordinates').value = pos.lat + "," + pos.lng;
            });

            map.on('click', function(event) {
                if (marker) {
                    map.removeLayer(marker);
                }
                map.removeLayer(defaultMarker);
                marker = L.marker(event.latlng).addTo(map);
                document.getElementById('map_coordinates').value = event.latlng.lat + "," + event.latlng.lng;
            });
        }


        initMap();

    </script>
</body>

</html>
