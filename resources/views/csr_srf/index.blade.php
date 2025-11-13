@extends('layout.app')
@section('title', 'Home')

@section('content')
    <div class="main-panel">
        @include('layout.header')

        <div class="container">
            <div class="page-inner">
                <div
                        class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
                >
                    <div>
                        <h3 class="fw-bold mb-3">Dashboard</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div
                                                class="icon-big text-center icon-success bubble-shadow-small"
                                        >
                                            <i class="fas fa-chess-board"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">SRF</p>
                                            <h4 class="card-title" id="srf-count"></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--<footer class="footer">--}}
        {{--<div class="container-fluid d-flex justify-content-between">--}}
        {{--<nav class="pull-left">--}}
        {{--<ul class="nav">--}}
        {{--<li class="nav-item">--}}
        {{--<a class="nav-link" href="http://www.themekita.com">--}}
        {{--ThemeKita--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--<li class="nav-item">--}}
        {{--<a class="nav-link" href="#"> Help </a>--}}
        {{--</li>--}}
        {{--<li class="nav-item">--}}
        {{--<a class="nav-link" href="#"> Licenses </a>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</nav>--}}
        {{--<div class="copyright">--}}
        {{--2024, made with <i class="fa fa-heart heart text-danger"></i> by--}}
        {{--<a href="http://www.themekita.com">ThemeKita</a>--}}
        {{--</div>--}}
        {{--<div>--}}
        {{--Distributed by--}}
        {{--<a target="_blank" href="https://themewagon.com/">ThemeWagon</a>.--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</footer>--}}
    </div>

    @push('js')

    <script>
        $(function () {
            $.ajax({
                url: '{{ route("csr_srf.index") }}',
                type: 'GET',
                success: function(data) {
                    $('#srf-count').text(data.srfCount);
                }
            });
        });
    </script>

    @endpush

@endsection