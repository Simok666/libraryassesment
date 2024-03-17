var laravelCsrf = $('meta[name="csrf-token"]').attr('content');
console.log(laravelCsrf)
// jquery set default header
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': laravelCsrf
    }
})

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
