<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Login - Mazer Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/toastify/toastify.css') }}">
<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        {{-- <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo"></a> --}}
                        <h3>Library Assesment</h3>
                    </div>
                    <h1 class="auth-title">Log in.</h1>
                    <form action="index.html">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" name="email" class="form-control form-control-xl" placeholder="Email" required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl" placeholder="Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <select class="form-select" name="role" required>
                                <option value="" disabled readonly selected>--- Select Role ---</option>
                                <option value="admin">Admin</option>
                                <option value="pimpinan">Pimpinan</option>
                                <option value="operator">Operator</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="submit">Log in</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Don't have an account? <a href="auth-register.html" class="font-bold">Sign
                                up As User</a>.</p>
                        {{-- <p><a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>.</p> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendors/toastify/toastify.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // if not empty token redirect
        if (!empty(session('token'))) {
            window.location.href = "{{ url('dashboard') }}";
        }
        // jquery on submit
        $(document).ready(function() {
            $('form').submit(function(e) {
                e.preventDefault();
                role = $('select[name=role]').val();
                ajaxData(`{{ url('api/v1/') }}/${role}/login`, 'POST', $(this).serialize(),
                    function(resp) {
                        setSession('token',resp.data.token)
                        setSession('isLogin',true)
                        window.location = "{{ url('dashboard') }}";
                    },
                    function(data) {
                        let code = data.responseJSON.code;
                        if (code >= 500) toast("Something went wrong, please try again", 'danger');
                        else toast("Email or password is incorrect", 'warning');
                    }
                );
            });
        })
    </script>
</body>

</html>
