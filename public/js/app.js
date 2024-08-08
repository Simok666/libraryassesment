var laravelCsrf = $('meta[name="csrf-token"]').attr('content');
var baseUrl = window.location.origin + "/limes/public";
var req = {
    page:1
};

const menuByRole = {
    "admin" : ["*"],
    "user" : ["dashboard","profile-perpustakaan", "profile-komponent" , "profile-buktifisik"],
    "operator" : ["dashboard", "users", "libraries", "proofOfWork", "komponent", "verifikator", "pleno", "googleform", "settingComponent"],
    "verifikator_desk" : ["dashboard", "libraries", "proofOfWork", "komponent", "verifikator-desk"],
    "verifikator_field" : ["dashboard", "libraries", "proofOfWork", "komponent", "verifikator-field"],
    "pimpinan" : ["dashboard", "pleno-sesban"],
    "pimpinankaban" : ["dashboard", "pleno-kaban"]
}

const sidebarItems = [
    {
      url: "dashboard",
      icon: "bi bi-grid-fill",
      label: "Dashboard"
    },
    {
      url: "users",
      icon: "bi bi-person",
      label: "User"
    },
    {
      url: "libraries",
      icon: "bi bi-book",
      label: "Libraries"
    },
    {
      url: "proofOfWork",
      icon: "bi bi-lock",
      label: "Bukti Fisik"
    },
    {
      url: "komponent",
      icon: "bi bi-collection",
      label: "Komponen"
    },
    {
      url: "verifikator",
      icon: "bi bi-person-check",
      label: "Verifikator"
    },
    {
      url: "verifikator-desk",
      icon: "bi bi-book",
      label: "Verifikator Desk"
    },
    {
      url: "verifikator-field",
      icon: "bi bi-book",
      label: "Verifikator Field"
    },
    {
      url: "pleno",
      icon: "bi bi-people-fill",
      label: "Pleno"
    },
    {
      url: "pleno-sesban",
      icon: "bi bi-person-lines-fill",
      label: "Pleno Sesban"
    },
    {
      url: "pleno-kaban",
      icon: "bi bi-person-lines-fill",
      label: "Pleno Kaban"
    },
    {
        url: "googleform",
        icon: "bi bi-google",
        label: "Google Form"
    },
    {
        url: "settingComponent",
        icon: "bi bi-gear",
        label: "Contoh Komponen"
    },

///// PIC Menu
    {
        url: "profile-perpustakaan",
        icon: "bi bi-person",
        label: "Profile Perpustakaan"
    },
    {
        url: "profile-komponent",
        icon: "bi bi-collection",
        label: "Komponen Utama"
    },
    {
        url: "profile-buktifisik",
        icon: "bi bi-collection",
        label: "Bukti Fisik"
    },
];
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
            let code = data.responseJSON?.code;
            if (code >= 500) toast("Something went wrong, please try again", 'danger');
            else toast(data.responseJSON?.message ?? data.responseJSON?.error, 'warning')
            if(typeof errorFunc === "function") {
                errorFunc(data);
            }
        }
    });
}

function ajaxDataFile(url, type, data , successFunc = "", errorFunc = "") {
    return $.ajax({
        url: url,
        type: type,
        dataType:"JSON",
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        success: function (resp) {
            if(!empty(successFunc)) {
                successFunc(resp);
            }
        },
        error: function (data) {
            let code = data.responseJSON.code;
            if (code >= 500) toast("Something went wrong, please try again", 'danger');
            else toast(data.responseJSON.message ?? data.responseJSON.error, 'warning')
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

    if (empty(message)) {
        return;
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
        }, 300);
    } else {
        ajaxData(baseUrl + '/api/v1/user', 'POST', {}, function (resp) {
            $(".display-user-name").html(resp.data.name);
            let role = (resp.data.role == "user" ? "PIC" : resp.data.role); ;
            $(".display-user-role").html(role);
            setSession("role", resp.data.role);
            setSession("is_upload_google_form", resp.data.is_upload_google_form);
            checkUserAccess()
            setMenuByRole();
            checkSpecialAction(resp.data)
        }, function(data) {
            toast(data.responseJSON.message ?? data.responseJSON.error, 'warning');
            setTimeout(deleteSession, 300);
        });
    }
}

function checkUserAccess(){
    const role = session("role");
    // let pathname = window.location.pathname.replace(/\.html$/, '').replace(/[/]/g, '');
    // const accessMenu = menuByRole[`${role}`].filter(item => {
    //     let menuUrl = item.replace(/_/g, '-');
    //     if (item == "*") return true;
    //     return pathname == menuUrl
    // });
    let pathname = window.location.pathname;
    let pathSegments = pathname.split('/');
    let dashboard = pathSegments.pop().replace('.html', '');

    const accessMenu = menuByRole[`${role}`].filter(item => {
        let menuUrl = item.replace(/_/g, '-');
        if (item == "*") return true;
        return dashboard == menuUrl;
    });
    
    console.log(accessMenu, dashboard);

    if (empty(accessMenu)) {
        toast("Access Denied", 'danger');
        setTimeout(function(){
            // redirect to login
            window.location = baseUrl + '/auth-login.html';
        }, 300);
    }
}

function setMenuByRole(){
    const role = session("role");
    const menu = menuByRole[role];
    const sidebarMenu = sidebarItems.filter(item => {
        let menuUrl = item.url.replace(/_/g, '-');
        return menu.includes(menuUrl)
    });

    // add list menu
    sidebarMenu.forEach(function(item){
        let menuItem = `
        <li class="sidebar-item  ">
            <a href="${item.url}.html" class='sidebar-link'>
                <i class="bi ${item.icon}"></i>
                <span>${item.label}</span>
            </a>
        </li>
        `
        $(".sidebar-menu .menu").append(menuItem);
    });

    // active menu
    $(".sidebar-menu .menu .sidebar-item").each(function(index, menu){
        let pathname = window.location.pathname.replace(/[/-]/g, '');
        let urlSidebar = $(this).find("a").attr("href").replace(/[/-]/g, '');
        const hrefRegex = new RegExp(`^${urlSidebar.replace(/\//g, '')}$`);
        if(hrefRegex.test(pathname)){
            $(this).addClass("active");
        }
    });
}

function checkSpecialAction(resp) {
    const { host, hostname, href, origin, pathname, port, protocol, search } = window.location
    if (resp.role == "user") {        
        const pageMapping = {
            0: 'profile-perpustakaan',
            1: 'profile-komponent',
            2: 'profile-buktifisik'
        };
          
        const pattern = new RegExp('\\b(' + Object.values(pageMapping).join('|') + ')\\b', 'i');
        const isWordIncluded = pattern.test(pathname);
        const filename = pathname.split('/').pop();
        // if ((isWordIncluded && parseInt(resp.type_insert) in pageMapping) || parseInt(resp.type_insert) < 3) {
        //     const patternSamePage = new RegExp('\\b(' + pageMapping[resp.type_insert] + ')\\b', 'i');
        //     console.log(patternSamePage.test(filename))
        //     if (patternSamePage.test(filename)) {
        //         return;
        //     }
        //     window.location = `${baseUrl}/${pageMapping[parseInt(resp.type_insert)]}.html`;
        // } else if (isWordIncluded && parseInt(resp.type_insert) >= 3) {
        //     window.location = `${baseUrl}/dashboard.html`;
        // } else {
        //     let a = $(".sidebar-menu .menu").find("a[href='profile-perpustakaan.html']").parent().remove();
        //     console.log(a);
        // };         
    } else if (resp.role == "admin") {
        
    } else if (resp.role == "superadmin") {

    } // etc

    // const { pathname } = window.location;
    // const roleMapping = {
    //     "user": {
    //         0: 'profile-perpustakaan',
    //         1: 'profile-komponent',
    //         2: 'profile-buktifisik'
    //     },
    //     "admin": {},
    //     "superadmin": {}
    // };
    // const pageMapping = roleMapping[resp.role] || {};
    // const filename = pathname.split('/').pop();
    // const redirectPage = pageMapping[resp.type_insert] || (resp.type_insert >= 3 ? 'dashboard.html' : null);
    // if(redirectPage && pathname.indexOf(pageMapping[resp.type_insert]) === -1){
    //     window.location = `${baseUrl}/${redirectPage}`;
    // }
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
            if(!empty(resp.meta)) {
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
                if(typeof formatFunc !== "function") {
                    return;
                }
                resp.lsdt = formatFunc(resp.data);
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
    btnSubmit = $(`form[id=${formSubmit.attr("id")}] [type='submit'],button[form=${formSubmit.attr("id")}]`);
    let spiner = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    if(isLoading === true) {
        let title = btnSubmit.html();
        btnSubmit.attr("title", title);
        btnSubmit.prop("disabled", true);
        btnSubmit.html(spiner);
    } else {
        btnSubmit.prop("disabled", false)
        btnSubmit.html(btnSubmit.attr("title"));
    }
}

function  CustomloadingButton (selector, isLoading = true) {
    let btnSubmit = selector;
    let spiner = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    if(isLoading === true) {
        let title = btnSubmit.html();
        btnSubmit.attr("title", title);
        btnSubmit.prop("disabled", true);
        btnSubmit.html(spiner);
    } else {
        btnSubmit.prop("disabled", false)
        btnSubmit.html(btnSubmit.attr("title"));
        btnSubmit.removeAttr("title")
    }
}