$(".btn-danger").click(function (event) {
    var realy = confirm("Вы действительно хотите удалить?");
    if (realy == false) {
        event.preventDefault();
    }
});

function getChildCategory(category) {
    //console.log(category.val());
    $.get('/api/categories/' + category.val() + '/childrens', function (res) {
        //console.log(res);
        $(".childCategories").html('<option selected disabled>Ожидайте ответа сервера</option>');
        if (res.response.length === 0) {
            showSuccess('Данные по запросу не найдены');
        } else if (res.error !== false) {
            showDanger('Непредвиденная ошибка');
        } else {
            var options = '<option selected disabled>Выберите подкатегорию</option>';
            $.each(res.response, function (i, v) {
                options += '<option value="' + v.id + '">' + v.name + '</option> ';
            });
            $(".childCategories").html(options);
        }
    });
}


//to select
function getShopsByCategoryToSelect(category) {
    //console.log(category.val());
    $.get('/api/categories/' + category.val() + '/shops_global', function (res) {
        //console.log(res);
        $(".shops").html('<option selected disabled>Ожидайте ответа сервера</option>');
        if (res.response.length === 0) {
            showSuccess('Данные по запросу не найдены');
        } else if (res.error !== false) {
            showDanger('Непредвиденная ошибка');
        } else {
            var options = '<option selected disabled>Выберите подкатегорию</option>';
            $.each(res.response, function (i, v) {
                options += '<option value="' + v.id + '">' + v.title + '</option> ';
            });
            $(".shops").html(options);
        }

    });
}
//to table list
function getShopsByCategory(category) {
    //console.log(category.val());
    $.get('/api/categories/' + category.val() + '/shops', function (res) {
        console.log(res);
        //$(".childCategories").html('<option selected disabled>Ожидайте ответа сервера</option>');
        if (res.response.length === 0) {
            showSuccess('Данные по запросу не найдены');
        } else if (res.error !== false) {
            showDanger('Непредвиденная ошибка');
        } else {
            var shops = '';
            $.each(res.response, function (i, v) {
                shops += '<tr role="row" class="odd">\n\
                    <td class="sorting_1">' + v.id + '</td>\n\
                    <td>' + v.category.name + '</td>\n\
                    <td>Временно недоступно</td>\n\
                    <td>' + v.city.name + '</td>\n\
                    <td>' + v.title + '</td>\n\
                    <td>\n\
                        <a style="float: left" href="/admin/shop/' + v.id + '" class="btn btn-info">Редактировать</a>\n\
                        <form method="POST" action="/api/shops/' + v.id + '" accept-charset="UTF-8" style="float:left;"><input name="_method" type="hidden" value="DELETE">\n\
                        <input name="id" type="hidden" value="' + v.id + '">\n\
                        <input class="btn btn-danger" =""="" type="submit" value="Удалить">\n\
                        </form>\n\
                    </td>\n\
                </tr>';
            });
            $(".shops").html(shops);
        }
        Table();
    });
}

function getCategoriesByCategory(category) {
    //console.log(category.val());
    $.get('/api/categories/' + category.val() + '/childrens', function (res) {
        console.log(res);
        //$(".childCategories").html('<option selected disabled>Ожидайте ответа сервера</option>');
        if (res.response.length === 0) {
            showSuccess('Данные по запросу не найдены');
        } else if (res.error !== false) {
            showDanger('Непредвиденная ошибка');
        } else {
            var shops = '';
            $.each(res.response, function (i, v) {
                shops += '<tr>\n\
                    <td>' + v.id + '</td>\n\
                    <td><img height="100px" width="300px" src="/images/' + v.image + '"></td>\n\
                    <td>' + v.name + '</td>\n\
                    <td>\n\
                        <a style="float: left" href="/admin/category/' + v.id + '" class="btn btn-info">Редактировать</a>\n\
                        <form method="POST" action="/api/categories/' + v.id + '" accept-charset="UTF-8" style="float:left;"><input name="_method" type="hidden" value="DELETE">\n\
                        <input name="id" type="hidden" value="' + v.id + '">\n\
                        <input class="btn btn-danger" =""="" type="submit" value="Удалить">\n\
                        </form>\n\
                    </td>\n\
                </tr>';
            });
            $(".categories").html(shops);
        }
        Table();
    });
}


$("#shopTableAdd").submit(function (event) {
    event.preventDefault();
    var data = new FormData(document.forms.shopTableAdd);
    var url = $("#shopTableAdd").attr("action");
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        processData: false, // tell jQuery not to process the data
        contentType: false   // tell jQuery not to set contentType
    }).done(function (response) {
        console.log(response);
        if (response.error === false) {
            showSuccess("Успешно", '/admin/shops');
        } else {
            var errors = '';
            $.each(response.validator, function (i, v) {
                errors += i + ') ' + v + '<br>';
            });
            //console.log(errors);
            showDanger(errors);
        }
    }).fail(function (response) {
        showDanger('возможно картинка очень большая');
    });

});
$("#promoTableAdd").submit(function (event) {
    event.preventDefault();
    var data = new FormData(document.forms.promoTableAdd);
    var url = $("#promoTableAdd").attr("action");
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        processData: false, // tell jQuery not to process the data
        contentType: false   // tell jQuery not to set contentType
    }).done(function (response) {
        console.log(response);
        if (response.error === false) {
            showSuccess("Успешно", '/admin/promos');
        } else {
            var errors = '';
            errors += '' + response.message + '<br>';
            if (typeof response.validator !== 'undefined') {
                $.each(response.validator, function (i, v) {
                    errors += i + ') ' + v + '<br>';
                });
            }

            //console.log(errors);
            showDanger(errors);
        }
    }).fail(function (response) {
        showDanger('возможно картинка очень большая');
    });

});

$("#newsTableAdd").submit(function (event) {
    event.preventDefault();
    var data = new FormData(document.forms.newsTableAdd);
    var url = $("#newsTableAdd").attr("action");
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        processData: false, // tell jQuery not to process the data
        contentType: false   // tell jQuery not to set contentType
    }).done(function (response) {
        console.log(response);
        if (response.error === false) {
            showSuccess("Успешно", '/admin/news');
        } else {
            var errors = '';
            $.each(response.validator, function (i, v) {
                errors += i + ') ' + v + '<br>';
            });
            //console.log(errors);
            showDanger(errors);
        }
    }).fail(function (response) {
        showDanger('возможно картинка очень большая');
    });

});

$("#eventTableAdd").submit(function (event) {
    event.preventDefault();
    var data = new FormData(document.forms.eventTableAdd);
    var url = $("#eventTableAdd").attr("action");
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        processData: false, // tell jQuery not to process the data
        contentType: false   // tell jQuery not to set contentType
    }).done(function (response) {
        //console.log(response);
        if (response.error === false) {
            showSuccess("Успешно", '/admin/events');

        } else {
            showDanger("Заполните все поля");
        }
    }).fail(function (response) {
        showDanger('возможно картинка очень большая');
    });

});
//#categoryTableAdd
$("#categoryTableAdd").submit(function (event) {
    event.preventDefault();
    var data = new FormData(document.forms.categoryTableAdd);
    var url = $("#categoryTableAdd").attr("action");
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        processData: false, // tell jQuery not to process the data
        contentType: false   // tell jQuery not to set contentType
    }).done(function (response) {
        //console.log(response);
        if (response.error === false) {
            showSuccess("Успешно", '/admin/categories');

        } else {
            showDanger("Заполните все поля");
        }
    }).fail(function (response) {
        showDanger('возможно картинка очень большая');
    });

});

$("#reviewTableAdd").submit(function (event) {
    event.preventDefault();
    var data = new FormData(document.forms.reviewTableAdd);
    var url = $("#reviewTableAdd").attr("action");
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        processData: false, // tell jQuery not to process the data
        contentType: false   // tell jQuery not to set contentType
    }).done(function (response) {
        //console.log(response);
        if (response.error === false) {
            showSuccess("Успешно", '/admin/reviews');

        } else {
            showDanger("Заполните все поля");
        }
    }).fail(function (response) {
        showDanger('возможно картинка очень большая');
    });

});
$(".stroked").on("click", function () {

});

function reviewPublish(id) {

    $.get('/admin/publish/' + id + '').done(function (response) {
        if (response.error === false) {
            $(".publish" + id + "").fadeOut("slow");
            showSuccess('Успех');
        } else {
            showDanger('Ошибка');
        }
    });
}
function reviewUnPublish(id) {
    $.get('/admin/unpublish/' + id + '').done(function (response) {
        if (response.error === false) {
            $(".unpublish" + id + "").fadeOut("slow");
            showSuccess('Успех');
        } else {
            showDanger('Ошибка');
        }
    });
}

function showDanger(text) {
    $(".dangerText").html(text);
    $(".bg-danger").show("slow", function () {
        setTimeout(function () {
            $(".bg-danger").hide("slow");
        }, 3000);
    });
}
function showSuccess(text, redirect) {
    $(".doneText").html(text);
    $(".bg-success").show("slow", function () {
        setTimeout(function () {
            $(".bg-success").hide("slow");
            if (redirect) {
                window.location.replace(redirect);
            }
        }, 2000);
    });
}

function addFile() {
    $('.files').append('<div class="form-group"><input name="images[]" type="file"></div>');
}

function removeActive() {
    $.each($(".menu").find("li"), function (i, v) {
        $(this).removeClass('active');
    });
}

$(function () {
    var url = window.location.pathname;
    if (url == '/admin') {
        $(".admin").parent().addClass('active');
    } else {
        $("#sidebar-collapse a").each(function () {

            if ($(this).attr('href') == url) {
                $(this).addClass('active');
                $(this).parent().parent().addClass("in");
            }
        });
    }


});
