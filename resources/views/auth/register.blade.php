<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Pendaftaran - Penilaian Perpustakaan</title>
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
                        <img src="{{ asset('icon/icon-4.jpg') }}" style="height: 100px" alt="">
                        {{-- <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo"></a> --}}
                        {{-- <h3>Penilaian Perpustakaan</h3> --}}
                    </div>
                    <h1 class="auth-title">Pendaftaran</h1>
                    <form action="index.html">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="name" minlength="3" class="form-control form-control-xl" placeholder="Nama" required>
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
                            <input type="password" min="8" name="password" class="form-control form-control-xl" placeholder="Kata Sandi" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="instance_name" minlength="3" class="form-control form-control-xl" placeholder="Nama Instansi" required>
                            <div class="form-control-icon">
                                <i class="bi bi-building"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="pic_name" minlength="3" class="form-control form-control-xl" placeholder="Nama PIC" required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="mb-4 position-relative has-icon-left">
                            <label for="sk_image">Gambar Sk</label>
                            <input type="file" name="sk_image[]" id="sk_image" class="form-control form-control-xl" placeholder="Choose Image" required>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4" id="select-kepala-eslon">
                            <span class="input-group-text mb-4" id="basic-addon1" >Pilih Jabatan</span>
                            <ul class="list-unstyled mb-0">
                                <li class="d-inline-block me-2 mb-1">
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox">
                                            <input type="radio" name="nama_jabatan" class="form-check-input form-check-primary" 
                                                name="customCheck" id="customColorCheck1" onclick="showSelectOptions(1)" required>
                                            <label class="form-check-label" for="customColorCheck1">Kepala Eselon 1</label>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-inline-block me-2 mb-1">
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox">
                                            <input type="radio" name="nama_jabatan" class="form-check-input form-check-secondary" 
                                                name="customCheck" id="customColorCheck2" onclick="showSelectOptions(2)">
                                            <label class="form-check-label" for="customColorCheck2">Kepala Eselon 2</label>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-inline-block me-2 mb-1">
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox">
                                            <input type="radio" name="nama_jabatan" class="form-check-input form-check-success" 
                                                name="customCheck" id="customColorCheck3" onclick="showSelectOptions(3)">
                                            <label class="form-check-label" for="customColorCheck3">Kepala Eselon 3</label>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-inline-block me-2 mb-1">
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox">
                                            <input type="radio" name="nama_jabatan" class="form-check-input form-check-danger" 
                                                name="customCheck" id="customColorCheck4" onclick="showSelectOptions(4)">
                                            <label class="form-check-label" for="customColorCheck4">Staf pelaksana/ jabatan fungsional</label>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4" id="eselon-satu-container" style="display:none;">
                            <select name="id_satuan_kerja_eselon_1" id="eselon-satu" class="form-control form-control-xl list-eselon-satu"  >
                                <option value="null"selected>Pilih Eselon 1</option>
                            </select>
                            <div class="form-control-icon">
                                <i class="bi bi-archive"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4" id="eselon-dua-container" style="display:none;">
                            <select name="id_satuan_kerja_eselon_2" id="eselon-dua" class="form-control form-control-xl list-eselon-dua" >
                                <option value="null"selected>Pilih Eselon 2</option>
                            </select>
                            <div class="form-control-icon">
                                <i class="bi bi-archive"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4" id="eselon-tiga-container" style="display:none;">
                            <select name="id_satuan_kerja_eselon_3"  id="eselon-tiga" class="form-control  form-control-xl list-eselon-tiga" >
                                <option value="null"selected>Pilih Eselon 3</option>
                            </select>
                            <div class="form-control-icon">
                                <i class="bi bi-archive"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4" id="eselon-fungsi-container" style="display:none;">
                            <select name="id_fungsi" id="eselon-fungsi" class="form-control form-control-xl list-fungsi" >
                                <option value="null"selected>Pilih Fungsi</option>
                            </select>
                            <div class="form-control-icon">
                                <i class="bi bi-archive"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="leader_instance_name" class="form-control form-control-xl" placeholder="Nama Instansi Pemimpin">
                            <div class="form-control-icon">
                                <i class="bi bi-building"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="library_name" class="form-control form-control-xl" placeholder="Nama Perpustakaan">
                            <div class="form-control-icon">
                                <i class="bi bi-building"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="head_library_name" class="form-control form-control-xl" placeholder="Nama Kepala Perpustakaan">
                            <div class="form-control-icon">
                                <i class="bi bi-building"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="npp" class="form-control form-control-xl" placeholder="NPP">
                            <div class="form-control-icon">
                                <i class="bi bi-hash"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="address" class="form-control form-control-xl" placeholder="Alamat" required>
                            <div class="form-control-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <div id="map" style="height: 300px;"></div>
                            <input type="hidden" name="map_coordinates" id="map_coordinates" value="" required>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" min="5" name="village" id="village" class="form-control form-control-xl" placeholder="Kelurahan" required>
                            <div class="form-control-icon">
                                <i class="bi bi-building"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" min="5" name="subdistrict" id="subdistrict" class="form-control form-control-xl" placeholder="Kecamatan" required>
                            <div class="form-control-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" min="5" name="city" id="city" class="form-control form-control-xl" placeholder="Kota/Kabupaten" required>
                            <div class="form-control-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" min="5" name="province" id="province" class="form-control form-control-xl" placeholder="Provinsi" required>
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
                            <input type="email" name="library_email" id="library_email" class="form-control form-control-xl" placeholder="Email perpustakaan example@gmail.com" value="">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="website" id="website" class="form-control form-control-xl" placeholder="website https://example.com" value="">
                            <div class="form-control-icon">
                                <i class="bi bi-globe"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="submit">Simpan</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Sudah punya akun? <a href="{{ url('auth-login.html') }}" class="font-bold">Masuk</a>.</p>
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
            getListEselon();

            $('form').submit(function(e) {
                e.preventDefault();
                var form = this;
                var formData = new FormData(form);
                loadingButton($(this))
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
                        loadingButton($("form"), false)
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
                        loadingButton($("form"), false)
                    }
                });
            });
        })

        $('#eselon-satu').on('change', function() { 
                let eselon_satu_id = $(this).val();

                $('#eselon-dua').empty();
                $('#eselon-dua').append('<option value="null">Pilih Eselon 2</option>');

                const urlEselonDua = `${baseUrl}/api/v1/eselonDua/?id_eselon_satu=${eselon_satu_id}`;
                ajaxData(urlEselonDua, 'GET', [], function(resp) { 
                    let data = resp.data;
                    let option2 = ``;

                    data.forEach(element => {
                        option2 += `<option value="${element.id}">${element.nama_satuan_kerja_eselon_2}</option>`;
                    });
                    $(".list-eselon-dua").append(option2);
                });

            });

            $('#eselon-dua').on('change', function() {
                let eselon_dua_id = $(this).val();

                $('#eselon-tiga').empty();
                $('#eselon-tiga').append('<option value="null">Pilih Eselon 3</option>');

                const urlEselonTiga = `${baseUrl}/api/v1/eselonTiga/?id_eselon_dua=${eselon_dua_id}`;
                ajaxData(urlEselonTiga, 'GET', [], function(resp) { 
                    let data2 = resp.data;
                    let option3 = ``;

                    data2.forEach(element => {
                        option3 += `<option value="${element.id}">${element.nama_satuan_kerja_eselon_3}</option>`;
                    });
                    $(".list-eselon-tiga").append(option3);
                });
            });

            $('#eselon-tiga').on('change', function() {
                let eselon_tiga_id = $(this).val();

                $('#eselon-fungsi').empty();
                $('#eselon-fungsi').append('<option value="null">Pilih Fungsi</option>');

                const urlFungsi = `${baseUrl}/api/v1/fungsi/?id_eselon_tiga=${eselon_tiga_id}`;
                ajaxData(urlFungsi, 'GET', [], function(resp) { 
                    let data3 = resp.data;
                    let option4 = ``;

                    data3.forEach(element => {
                        option4 += `<option value="${element.id}">${element.nama_fungsi}</option>`;
                    });
                    $(".list-fungsi").append(option4);
                });
            });

        let getListEselon = () => {
            const url = `${baseUrl}/api/v1/eselon/`;
            ajaxData(url, 'GET', [], function(resp) {
                let data = resp.data;
                let option = ``;

                data.forEach(element => {
                    option += `<option value="${element.id}">${element.nama_satuan_kerja_eselon_1}</option>`;
                });
                $(".list-eselon-satu").append(option);
            }, function(data) {
                
            });
        }

        function showSelectOptions(level) {
            document.getElementById('eselon-satu-container').style.display = 'none';
            document.getElementById('eselon-dua-container').style.display = 'none';
            document.getElementById('eselon-tiga-container').style.display = 'none';
            document.getElementById('eselon-fungsi-container').style.display = 'none';
            // document.getElementById('container-jabatan-fungsional').style.display = 'none';

            if (level === 1) {
                document.getElementById('eselon-satu-container').style.display = 'block';
            } else if (level === 2) {
                document.getElementById('eselon-satu-container').style.display = 'block';
                document.getElementById('eselon-dua-container').style.display = 'block';
            } else if (level === 3) {
                document.getElementById('eselon-satu-container').style.display = 'block';
                document.getElementById('eselon-dua-container').style.display = 'block';
                document.getElementById('eselon-tiga-container').style.display = 'block';
            } else if (level === 4) {
                document.getElementById('eselon-satu-container').style.display = 'block';
                document.getElementById('eselon-dua-container').style.display = 'block';
                document.getElementById('eselon-tiga-container').style.display = 'block';
                document.getElementById('eselon-fungsi-container').style.display = 'block';
                // document.getElementById('container-jabatan-fungsional').style.display = 'block';
            }
        }

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
