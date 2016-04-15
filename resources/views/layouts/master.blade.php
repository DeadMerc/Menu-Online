<!DOCTYPE html>
<html>
    <head >
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Lumino - Dashboard</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/dt/jq-2.2.0,dt-1.10.11/datatables.min.css"/>

        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/datepicker3.css" rel="stylesheet">
        <link href="/css/styles.css" rel="stylesheet">

        <!--Icons-->
        <script src="/js/lumino.glyphs.js"></script>

        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->

    </head>
    <body >
        <div class="loader">
            <div class='uil-ripple-css' style='transform:scale(0.64);'><div></div><div></div></div>
        </div>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><span>Lumino</span>Admin</a>
                    <ul class="user-menu">
                        <li class="dropdown pull-right">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Admin <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
                                <li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li>
                                <li><a href="#"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </div><!-- /.container-fluid -->
        </nav>
        <div class="alert bg-danger fly" role="alert">
            <div class="dangerText"></div><br>
            <i>Fade out in 3 seconds.</i>
        </div>
        <div class="alert bg-success fly" role="alert">
            <svg class="glyph stroked checkmark"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-checkmark"></use></svg> <a class="doneText"></a> 
        </div>
        <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
            <form role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
            </form>
            <ul class="nav menu">
                <li >
                    <a class="admin" href="/admin">
                        <svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg>Главная
                    </a>
                </li>
                <li class="parent ">
                    <a    data-toggle="collapse"  href="#sub-item-2">
                        <span  class=""><svg class="glyph stroked chevron-down"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-chevron-down"></use></svg></span> Категории
                    </a>
                    <ul class="children collapse" id="sub-item-2">
                        <li>
                            <a   href="/admin/categories">
                                <svg class="glyph stroked app window with content"><use xlink:href="#stroked-app-window-with-content"/></svg>Все
                            </a>
                        </li>
                        <li >
                            <a  href="/admin/category">
                                <svg class="glyph stroked plus sign"><use xlink:href="#stroked-plus-sign"/></svg>Добавить
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="parent ">
                    <a  data-toggle="collapse"  href="#sub-item-1">
                        <span  class=""><svg class="glyph stroked chevron-down"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-chevron-down"></use></svg></span> Заведения
                    </a>
                    <ul class="children collapse " id="sub-item-1">
                        <li>
                            <a  href="/admin/shops">
                                <svg class="glyph stroked app window with content"><use xlink:href="#stroked-app-window-with-content"/></svg>Все
                            </a>
                        </li>
                        <li>
                            <a class="" href="/admin/shop">
                                <svg class="glyph stroked plus sign"><use xlink:href="#stroked-plus-sign"/></svg>Добавить
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="parent ">
                    <a  data-toggle="collapse"  href="#events">
                        <span  class=""><svg class="glyph stroked chevron-down"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-chevron-down"></use></svg></span> Акции
                    </a>
                    <ul class="children collapse" id="events">
                        <li>
                            <a class="" href="/admin/events">
                                <svg class="glyph stroked app window with content"><use xlink:href="#stroked-app-window-with-content"/></svg>Все
                            </a>
                        </li>
                        <li>
                            <a class="" href="/admin/event">
                                <svg class="glyph stroked plus sign"><use xlink:href="#stroked-plus-sign"/></svg>Добавить
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="parent ">
                    <a   data-toggle="collapse"  href="#sub-item-3">
                        <span  ><svg class="glyph stroked chevron-down"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-chevron-down"></use></svg></span> Отзывы
                    </a>
                    <ul class="children collapse" id="sub-item-3">
                        <li>
                            <a class="" href="/admin/reviews">
                                <svg class="glyph stroked app window with content"><use xlink:href="#stroked-app-window-with-content"/></svg>Все
                            </a>
                        </li>
                        <li>
                            <a class="" href="/admin/review">
                                <svg class="glyph stroked plus sign"><use xlink:href="#stroked-plus-sign"/></svg>Добавить
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="parent ">
                    <a  data-toggle="collapse"  href="#sub-item-4">
                        <span  class=""><svg class="glyph stroked chevron-down"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-chevron-down"></use></svg></span> Промо ( на главной )
                    </a>
                    <ul class="children collapse" id="sub-item-4">
                        <li>
                            <a class="" href="/admin/promos">
                                <svg class="glyph stroked app window with content"><use xlink:href="#stroked-app-window-with-content"/></svg>Все
                            </a>
                        </li>
                        <li>
                            <a class="" href="/admin/promo">
                                <svg class="glyph stroked plus sign"><use xlink:href="#stroked-plus-sign"/></svg>Добавить
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="parent ">
                    <a  data-toggle="collapse"  href="#sub-item-5">
                        <span  class=""><svg class="glyph stroked chevron-down"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-chevron-down"></use></svg></span> События города
                    </a>
                    <ul class="children collapse" id="sub-item-5">
                        <li>
                            <a class="" href="/admin/news">
                                <svg class="glyph stroked app window with content"><use xlink:href="#stroked-app-window-with-content"/></svg>Все
                            </a>
                        </li>
                        <li>
                            <a class="" href="/admin/new">
                                <svg class="glyph stroked plus sign"><use xlink:href="#stroked-plus-sign"/></svg>Добавить
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

        </div><!--/.sidebar-->
        @section('mainRows')
        MainRows
        @show


        <script src="/js/jquery-1.11.1.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/chart.min.js"></script>
        <script src="/js/easypiechart.js"></script>
        <!--<script src="/js/chart-data.js"></script>
        <script src="/js/easypiechart-data.js"></script>
        <script src="/js/bootstrap-datepicker.js"></script>-->
        <script src="/js/dataTables.bootstrap.min.js"></script>
        <script src="/js/dataTables.min.js"></script>

        <script src="/js/app.js"></script>
        <script>
            $('#calendar').datepicker({
            });

            !function ($) {
                $(document).on("click", "ul.nav li.parent > a > span.icon", function () {
                    $(this).find('em:first').toggleClass("glyphicon-minus");
                });
                $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
            }(window.jQuery);

            $(window).on('resize', function () {
                if ($(window).width() > 768)
                    $('#sidebar-collapse').collapse('show')
            })
            $(window).on('resize', function () {
                if ($(window).width() <= 767)
                    $('#sidebar-collapse').collapse('hide')
            })
        </script>	
        <script>
            function Table() {
                //$("#example1").DataTable();
                hideLoader();
                $('#example').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "retrieve": true,
                    "autoWidth": false
                });
            }
            ;
            function hideLoader() {
                setTimeout(function () {
                    $(".loader").fadeOut("slow");
                }, 500);
            }
            $(window).load(Table);


        </script>

    </body>

</html>
