var laravelCsrf = $('meta[name="csrf-token"]').attr('content');
var baseUrl = window.location.origin;
var req = {
    page:1
};
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
            toast(data.responseJSON.message ?? data.responseJSON.error, 'warning')
            if(typeof errorFunc === "function") {
                errorFunc(data);
            }
        }
    });
}

function toast(message, type = "success") {
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
    // empty array
    return (value === undefined || value === null || value.length === 0 || value === "") ? true : false;
}

function setSession(name, value) {
    localStorage.setItem(name, value);
}
function session(name) {
    return localStorage.getItem(name) ?? "";
}

function checkLogin() {
    if(empty(session("isLogin"))) {
        toast("Session expired, please login again", 'danger');
        setTimeout(function(){
            deleteSession();
        }, 3000);
    } else {
        ajaxData(baseUrl + '/api/v1/user', 'POST', {}, function (resp) {
            $(".display-user-name").html(resp.data.name);
            $(".display-user-role").html(resp.data.role);
            setSession("role", resp.data.role);
        }, function(data) {
            toast(data.responseJSON.message ?? data.responseJSON.error, 'warning');
            setTimeout(deleteSession, 3000);
        });
    }
}
function deleteSession() {
    localStorage.removeItem("isLogin");
    localStorage.removeItem("token");
    window.location = '/';
}


function GetData(req , table, formatFunc = "" ,successfunc = "") {
    req = (typeof req !== 'undefined') ?  req : "";
    successfunc = (typeof successfunc !== 'undefined') ?  successfunc : "";
    url = $(`.datatable-${table}`).data("action");
    // add loading on table use font awesome reolad 
    $(`.datatable-${table} tbody`).html(`<tr><td colspan='10' class='text-center'><div class="spinner-border text-primary" role="status"></div></td></tr>`);
    $.ajax({
        type: "GET",
        url: baseUrl + url,
        data: req,
        dataType: "JSON",
        tryCount: 0,
        retryLimit: 3,
        success: function(resp){
            resp.lsdt = "";
            if(empty(resp.meta.data)) {
                if(typeof formatFunc !== "function") {
                    return;
                }
                resp.lsdt = formatFunc(resp.data);
                $(".datatable-"+table+" tbody").html(resp.lsdt);
                pagination(resp.meta, table);
                if(successfunc != "") {
                    getfunc = successfunc;
                    successfunc(resp);
                }
            } else {
                $(".datatable-"+table+" tbody").html(resp.lsdt);
                $(".pagination-setting-"+table).addClass("hidden");
                if(successfunc != "") {
                    getfunc = successfunc;
                    successfunc(resp);
                }
            }
        },
        error: function(xhr, textstatus, errorthrown) {
            $(".datatable-"+table+" tbody").html("<tr><td colspan='10' class='text-center'><span class='label label-warning'>Periksa koneksi internet anda kembali</span></td></tr>");
            $(".pagenation-setting-"+table).addClass("hidden");
        }
    });
}
function pagination(page, table) {
    var paginglayout = $(".pagination-setting-"+table);
    let stringInfo = `${page.from} - ${page.to} of ${page.total} Records`;
    if (empty(page.from)) {
        stringInfo = "";
    }
    var infopage = stringInfo + " | total " + page.last_page + " Pages";
    page.IsNext = page.current_page < page.last_page;
    page.IsPrev = page.current_page > 1;

    paginglayout.attr("page", page.current_page);
    paginglayout.attr("lastpage", page.last_page);
    paginglayout.removeClass("hidden");
    paginglayout.find("input[type='text']").val(Number(page.current_page));
    paginglayout.find(".pagination-info").html(infopage);
    if(page.IsNext == true) {
        paginglayout.find(".btn-next, .next-head").removeClass("disabled");
        paginglayout.find(".btn-last").removeClass("disabled");
        paginglayout.find(".btn-last").attr("lastpage", page.JmlHalTotal);
        datanext = (Number(page.current_page) + 1);
    } else {
        paginglayout.find(".btn-next, .next-head").addClass("disabled");
        paginglayout.find(".btn-last").addClass("disabled");
        dataprev = 0;
    }
    if(page.IsPrev == true) {
        paginglayout.find(".btn-prev, .prev-head").removeClass("disabled");
        paginglayout.find(".btn-first").removeClass("disabled");
        dataprev = (Number(page.current_page) - 1);
    } else {
        paginglayout.find(".btn-prev, .prev-head").addClass("disabled");
        paginglayout.find(".btn-first").addClass("disabled");
        dataprev = 0;
    }
}

$(".btn-next").click(function() {
    let page = parseInt($(this).parent().parent().parent().attr("page"));
    let table = $(this).parent().parent().parent().attr("class");
    table = table.replace(/pagination-setting-/g, "", table);
    req.page  =  page + 1;
    GetData(req, table, eval(`format${table}`));
});

$(".btn-prev").click(function() {
    let page = parseInt($(this).parent().parent().parent().attr("page"));
    let table = $(this).parent().parent().parent().attr("class");
    table = table.replace(/pagination-setting-/g, "", table);
    req.page  =  page - 1;
    GetData(req, table, eval(`format${table}`));
});

$(".btn-first").click(function() {
    let table = $(this).parent().parent().parent().attr("class");
    table = table.replace(/pagination-setting-/g, "", table);
    req.page  = 1;
    GetData(req, table, eval(`format${table}`));
});
$(".btn-last").click(function() {
    let table = $(this).parent().parent().parent().attr("class");
    table = table.replace(/pagination-setting-/g, "", table);
    req.page = $(this).parent().parent().parent().attr('lastpage');
    GetData(request, table, eval(`format${table}`));
});

$(".goto").on("submit",function(e) {
    e.preventDefault();
    let table = $(this).parent().parent().parent().attr("class");
    table = table.replace(/pagination-setting-/g, "", table);
    req.page = parseInt($(this).find("input").val()) ? parseInt($(this).find("input").val()) : 1;
    GetData(req, table, eval(`format${table}`));
    return false;
});

function loading(selector, isLoading = true) {
    if(isLoading == true) {
        selector.find(".after-loading").addClass("d-none");
        selector.find(".loading").removeClass("d-none");
    } else {
        selector.find(".after-loading").removeClass("d-none");
        selector.find(".loading").addClass("d-none");
    }
}

function loadingButton (formSubmit, isLoading = true) {
    let btnSubmit = formSubmit.find("button[type='submit']");
    if (empty(btnSubmit)) {
        btnSubmit = $(document).find(`button[form=${formSubmit.attr("id")}]`);
    }
    let spiner = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    if(isLoading === true) {
        let title = btnSubmit.html();
        btnSubmit.attr("title", title);
        btnSubmit.prop("disabled", true);
        btnSubmit.html(spiner);
    } else {
        btnSubmit.removeAttr("disabled")
        btnSubmit.html(btnSubmit.attr("title"));
    }
}