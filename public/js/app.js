var laravelCsrf = $('meta[name="csrf-token"]').attr('content');
var baseUrl = window.location.origin;
// jquery set default header
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': laravelCsrf,
        'Authorization': 'Bearer ' + session("token")
    }
})

function ajaxData(url, type, data , successFunc = "", errorFunc = "") {
    return $.ajax({
        url: url,
        type: type,
        dataType:"JSON",
        data: data,
        success: function (resp) {
            if(!empty(successFunc)) {
                successFunc(resp);
            }
        },
        error: function (data) {
            let code = data.responseJSON.code;
            if (code >= 500) toast("Something went wrong, please try again", 'danger');
            else if(!empty(errorFunc)) errorFunc(data);
            else toast(data.responseJSON.message, 'warning');
        }
    });
}

function toast(message, type) {
    switch(type) {
        case 'primary': type = '#435ebe'; break;
        case 'secondary': type = '#6c757d'; break;
        case 'success': type = '#198754'; break;
        case 'danger': type = '#dc3545'; break;
        case 'warning': type = '#ffc107'; break;
        case 'info': type = '#0dcaf0'; break;
        default: type = '#6c757d';
    }
    Toastify({
        text: message,
        duration: 3000,
        close:true,
        backgroundColor: type,
    }).showToast();
}

function empty(value) {
    return (value === undefined || value === null || value.length <= 0) ? true : false;
}

function setSession(name, value) {
    localStorage.setItem(name, JSON.stringify(value));
}
function session(name) {
    return localStorage.getItem(name) ?? "";
}

function checkLogin() {
    if(empty(session("isLogin"))) {
        toast("Session expired, please login again", 'danger');
        setTimeout(deleteSession, 3000);
        window.location = '/';
    } else {
        ajaxData(baseUrl + '/api/v1/user', 'POST', {}, function (resp) {
            console.log(resp);
        }, function(data) {
            toast(data.responseJSON.message, 'warning');
            setTimeout(deleteSession, 3000);
        });
    }
}
function deleteSession() {
    localStorage.removeItem("isLogin");
    localStorage.removeItem("token");
    window.location = '/';
}

// checkLogin();
