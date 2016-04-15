
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
