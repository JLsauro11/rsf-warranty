<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta
            content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
            name="viewport"
    />
    <link
            rel="icon"
            href="{{ asset('assets/img/favicon.png') }}"
            type="image/x-icon"
    />
    <!-- Sweet Alert -->
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('assets/css/fonts.min.css') }}"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />

    <!-- DataTables Buttons CSS for export buttons -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" />
    @stack('css')
    <link rel="stylesheet" href="{{ asset('assets/css/rs8-srf-theme.css') }}" />

</head>
@php
    $uiBrand = match (true) {
        request()->routeIs('admin.rs8.*', 'csr_rs8.*') => 'rs8',
        request()->routeIs('admin.srf.*', 'csr_srf.*') => 'srf',
        default => 'fusion',
    };
@endphp
<body data-brand="{{ $uiBrand }}">
<div class="wrapper">
    <!-- Sidebar -->
    @include('layout.sidebar')
    <!-- End Sidebar -->

    @yield('content')

</div>
<!--   Core JS Files   -->
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

<!-- jQuery Scrollbar -->
<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

<!-- Chart JS -->
<script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>

<!-- jQuery Sparkline -->
<script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Chart Circle -->
<script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>

<!-- DataTables Buttons scripts and dependencies -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>


<!-- Bootstrap Notify -->
<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

<!-- jQuery Vector Maps -->
<script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>



<!-- Kaiadmin JS -->
<script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>

<!-- Unified sidebar toggle: desktop collapse + mobile off-canvas -->
<script>
    (function () {
        const desktopQuery = window.matchMedia('(min-width: 992px)');
        const $html = $('html');
        const $wrapper = $('.wrapper');
        const $toggles = $('.universal-sidebar-toggler');

        function syncSidebarToggle() {
            const isDesktop = desktopQuery.matches;
            const isOpen = isDesktop
                ? !$wrapper.hasClass('sidebar_minimize')
                : $html.hasClass('nav_open');

            $toggles.attr('aria-expanded', isOpen ? 'true' : 'false');
            $toggles.each(function () {
                const $icon = $(this).find('i');
                $icon.removeClass('gg-menu-left gg-menu-right');
                $icon.addClass(isOpen ? 'gg-menu-left' : 'gg-menu-right');
            });
        }

        function refreshResponsiveTables() {
            // DataTables measures column widths when it is initialized.
            // Recalculate after the sidebar width transition has finished.
            if ($.fn.dataTable) {
                $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust().draw(false);
            }

            $('.table-responsive, .dataTables_wrapper, table.dataTable').css('width', '100%');
            $(window).triggerHandler('resize.rsResponsiveTables');
        }

        function scheduleTableRefresh() {
            window.requestAnimationFrame(refreshResponsiveTables);
            window.setTimeout(refreshResponsiveTables, 120);
            window.setTimeout(refreshResponsiveTables, 280);
        }

        $toggles.on('click.rsUnifiedSidebar', function (event) {
            event.preventDefault();
            event.stopPropagation();

            if (desktopQuery.matches) {
                $wrapper.toggleClass('sidebar_minimize');
                $wrapper.removeClass('sidebar_minimize_hover');
            } else {
                $html.toggleClass('nav_open');
            }

            syncSidebarToggle();
            scheduleTableRefresh();
        });

        $('.sidebar .nav-item > a').on('click.rsUnifiedSidebar', function () {
            if (!desktopQuery.matches) {
                $html.removeClass('nav_open');
                syncSidebarToggle();
            }
        });

        function handleBreakpointChange() {
            if (desktopQuery.matches) {
                $html.removeClass('nav_open');
            } else {
                $wrapper.removeClass('sidebar_minimize sidebar_minimize_hover');
            }
            syncSidebarToggle();
            scheduleTableRefresh();
        }

        $('.main-panel, .sidebar').on('transitionend.rsResponsiveTables', function (event) {
            if (event.originalEvent && event.originalEvent.propertyName === 'width') {
                refreshResponsiveTables();
            }
        });

        if (desktopQuery.addEventListener) {
            desktopQuery.addEventListener('change', handleBreakpointChange);
        } else {
            desktopQuery.addListener(handleBreakpointChange);
        }

        handleBreakpointChange();
    })();
</script>

<script>
    $(document).ready(function () {
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
            pageLength: 5,
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        var column = this;
                        var select = $(
                            '<select class="form-select"><option value=""></option></select>'
                        )
                            .appendTo($(column.footer()).empty())
                            .on("change", function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                column
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append(
                                    '<option value="' + d + '">' + d + "</option>"
                                );
                            });
                    });
            },
        });

        // Add Row
        $("#add-row").DataTable({
            pageLength: 5,
        });

        var action =
            '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $("#addRowButton").click(function () {
            $("#add-row")
                .dataTable()
                .fnAddData([
                    $("#addName").val(),
                    $("#addPosition").val(),
                    $("#addOffice").val(),
                    action,
                ]);
            $("#addRowModal").modal("hide");
        });
    });
</script>
<script>
    $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
    });

    $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
    });

    $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
    });
</script>
<script src="{{ asset('assets/js/password-toggle.js') }}"></script>
@stack('js')
    <script src="{{ asset('assets/js/bulk-table-delete.js') }}"></script>
</body>
</html>
