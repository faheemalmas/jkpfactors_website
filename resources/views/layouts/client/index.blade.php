<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@1&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('client/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('client/css/tiny-slider.css" rel="stylesheet') }}">
    <link href="{{ asset('client/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .header-title {
            font-family: 'DM Serif Display';
            color: #000;
            white-space: normal;
            padding-top: 10px;
            width: 100%;
            text-transform: uppercase;
        }

        .select2-container .select2-selection--single {
            height: 50px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 45px !important;
        }

        .select2-container--default .select2-results__option--disabled {
            font-size: 13px !important;
            color: black !important;
            font-weight: 300 !important;
            border-bottom: 1px solid black !important;
        }

        .bg-purple {
            background: black !important;
        }

        a {
            word-wrap: break-word;
        }

        .newcol.active {
            color: #238822 !important;
        }

        .newcol:hover {
            color: blue !important;
        }

        .nav-link {
            opacity: 1 !important;
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: black !important;
            color: white !important;
        }

        @media all and (min-width: 992px) {
            .dropdown-menu li {
                position: relative;
            }

            .nav-item .submenu {
                display: none;
                position: absolute;
                left: 100%;
                top: -7px;
            }

            .nav-item .submenu-left {
                right: 100%;
                left: auto;
            }

            .dropdown-menu>li:hover {
                background-color: #f1f1f1
            }

            .dropdown-menu>li:hover>.submenu {
                display: block;
            }
        }

        /* ============ desktop view .end// ============ */

        /* ============ small devices ============ */
        @media (max-width: 991px) {
            .dropdown-menu .dropdown-menu {
                margin-left: 0.7rem;
                margin-right: 0.7rem;
                margin-bottom: .5rem;
            }
        }

        .code-blue {
            color: #4759AB;
        }

        .code-dark {
            color: #003C4F;
        }

        .code-green {
            color: #657422;
        }

        .code-p-green {
            color: #21794D;
        }

        .code-red {
            color: #AD0000;
        }

        .blue-box {
            background-color: #fcfcfc;
            color: white;
            padding: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
            border-radius: 4px;
            position: relative;
            width: 100%;

            box-shadow: -2px 2px 11px -4px rgba(0, 0, 0, 0.64);
            -webkit-box-shadow: -2px 2px 11px -4px rgba(0, 0, 0, 0.64);
            -moz-box-shadow: -2px 2px 11px -4px rgba(0, 0, 0, 0.64);
        }

        body {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif !important;
            color: black !important;
        }

        .comment-text {
            color: #5E5E5E;
        }

        .navbar-expand-md .navbar-nav .dropdown-menu {
            top: 51px;
        }

        .mylist:hover {
            background: transparent !important;
            color: #6A6A6A !important;
            cursor: pointer;
        }

        .text-blue {
            color: #000000 !important;
            text-decoration: none;
            font-size: 15px !important;
        }

        p {
            font-family: Raleway;
            font-size: 18px;
            line-height: 160%;
            text-align: justify;
        }

        .hide-show {
            cursor: pointer;

            text-decoration: underline;
        }

        .dm-serif-regular {
            font-family: "DM Serif Display";
        }

        .raleway-font {
            font-family: Raleway !important;
        }

        .dropdown-item.active,
        .dropdown-item:active {
            color: #fff;
            text-decoration: none;
            background-color: transparent;
        }

        .author {
            text-decoration: none;
            font-size: 20px !important;
            color: #042D53;
        }

        .author-dec {
            font-family: "Raleway", sans-serif;
            font-size: 12px;
            color: #999;
            text-align: center;
        }

        .newcol {
            font-size: 12px;
            display: inline-block;
            margin: 5px 8px;
            color: #333;
            padding-bottom: 0px;
            width: 100%;
            padding-right: .5rem;
            padding-left: .5rem;

            text-wrap: nowrap;
        }

        .newcol-aft {
            position: relative;
        }

        .newcol-aft::after {
            display: inline-block;
            margin-left: .255em;
            vertical-align: .255em;
            content: "";
            border-top: .3em solid;
            border-right: .3em solid transparent;
            border-bottom: 0;
            border-left: .3em solid transparent;
        }

        @media screen and (max-width: 700px) {
            .newbar {
                flex-direction: column !important;
                line-height: 15px !important;
                margin-top: 20px;
            }

        }

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
        }

        .btn-default.active,
        .btn-default:active,
        .open>.dropdown-toggle.btn-default {
            color: #042D53 !important;
            background: transparent !important;
            background-image: none !important;
            border: none !important;
        }

        .btn-default {
            color: #042D53 !important;
            background: transparent !important;
            border: none !important;
        }

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            bottom: 0;
            left: 0;
            position: relative;
            border: 0
        }

        :root {
            --primary-color: #D5E2FD;
            --icon-size: 3rem;
        }

        input[type="radio"] {
            display: inline-block;
            position: absolute;
            overflow: hidden;
            clip: rect(0 0 0 0);
            height: 1;
            width: 1;
            margin: -1;
            padding: 0;
            border: 0;
        }

        .icon {
            display: flex;
            justify-content: center;
            align-items: center;
            color: black;
            border-radius: 0.5rem;
            overflow: hidden;
            padding: 0px 7.5px;
        }

        .icon:hover {
            cursor: pointer;
            background-color: var(--primary-color);
        }

        .peer:checked~.icon {
            background-color: var(--primary-color);
        }


        .wrapper {
            display: flex;
            flex-shrink: 0;
            gap: 0.5rem;
        }

        .main-container-text {
            font-size: 18px !important;
            line-height: 160% !important;
            text-align: justify;
        }

        /* .container {
            max-width: 1140px !important;
        } */

        .form-check-input:checked {
            background-color: transparent !important;
            border-color: transparent !important;
        }

        .form-switch .form-check-input:checked {
            background-position: right center;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%280, 0, 0, 0.25%29'/%3e%3c/svg%3e") !important;
        }

        .form-switch .form-check-input:focus {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%280, 0, 0, 0.25%29'/%3e%3c/svg%3e") !important;
        }

        .form-check-input {
            width: 1em;
            height: 1em;
            margin-top: .25em;
            vertical-align: top;
            background-color: #fff;
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            border: 1px solid rgba(0, 0, 0, .25);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        .form-check-input[type=checkbox] {
            border-radius: 2rem !important;
            border: 1px solid rgba(0, 0, 0, .25) !important;
        }

        .form-check-input:focus {
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25)
        }
    </style>
    @yield('page-css')
    <title>Global Factor Data</title>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>



</head>

<body>

    @include('layouts.client.common.header')

    @yield('content')


    {{-- @include('layouts.client.common.footer') --}}


    <!-- Other JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.5.0/dist/echarts.min.js"></script>
    <script src="{{ asset('client/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('client/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('client/js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            function initializeSelect2() {
                $('.js-example-basic-single').select2({
                    width: '100%'
                });
            }

            initializeSelect2();

            $(window).resize(function() {
                initializeSelect2();
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (window.innerWidth < 992) {

                document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown) {
                    everydropdown.addEventListener('hidden.bs.dropdown', function() {
                        this.querySelectorAll('.submenu').forEach(function(everysubmenu) {
                            everysubmenu.style.display = 'none';
                        });
                    })
                });

                document.querySelectorAll('.dropdown-menu a').forEach(function(element) {
                    element.addEventListener('click', function(e) {
                        let nextEl = this.nextElementSibling;
                        if (nextEl && nextEl.classList.contains('submenu')) {
                            e.preventDefault();
                            if (nextEl.style.display == 'block') {
                                nextEl.style.display = 'none';
                            } else {
                                nextEl.style.display = 'block';
                            }

                        }
                    });
                })
            }
            // end if innerWidth
        });
        document.querySelectorAll('.dropdown-submenu').forEach(function(elem) {
            elem.addEventListener('mouseover', function() {
                var dropdown = this.querySelector('.dropdown-menu');
                if (dropdown) {
                    dropdown.classList.add('show');
                }
            });

            elem.addEventListener('mouseout', function() {
                var dropdown = this.querySelector('.dropdown-menu');
                if (dropdown) {
                    dropdown.classList.remove('show');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.dropdown-submenu a.test').on("click", function(e) {
                $(this).next('ul').toggle();
                e.stopPropagation();
                e.preventDefault();
            });
        });
    </script>
    @yield('page-js')

</body>

</html>
