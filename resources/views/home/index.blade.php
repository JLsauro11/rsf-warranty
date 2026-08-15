@extends('layout.app')
@section('title', 'RS8 x SRF Dashboard')

@section('content')
<div class="main-panel">
    @include('layout.header')
    <div class="container">
        <div class="page-inner">
            <section class="dashboard-hero dashboard-hero-v2">
                <div class="hero-v2-main">
                    <div class="hero-v2-copy">
                        <div class="hero-v2-kicker"><span></span> Internal Warranty System</div>
                        <h1>Warranty<br><em>Operations</em></h1>
                        <p>One command workspace for RS8 and SRF warranty monitoring, product administration, and customer support.</p>
                        <div class="hero-v2-tags">
                            <span>ADMIN CONTROL</span>
                            <span>LIVE RECORDS</span>
                            <span>RS8 × SRF</span>
                        </div>
                    </div>

                </div>
            </section>

            <div class="rs-page-heading">
                <div class="rs-eyebrow">Live Overview</div>
                <h2>Warranty Records</h2>
                <p>Current registration totals across the supported warranty channels.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-xl-4">
                    <div class="brand-stat-card rs8-card">
                        <div class="brand-lockup">
                            <img src="{{ asset('assets/img/rs8-brand.png') }}" alt="RS8">
                        </div>
                        <div class="stat-label">Warranty Records</div>
                        <div class="stat-value" id="rs8-count-card">—</div>
                        <div class="stat-foot">Registered RS8 customer warranty records.</div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="brand-stat-card srf-card">
                        <div class="brand-lockup">
                            <img src="{{ asset('assets/img/srf-brand.png') }}" alt="SRF">
                        </div>
                        <div class="stat-label">Warranty Records</div>
                        <div class="stat-value" id="srf-count-card">—</div>
                        <div class="stat-foot">Registered SRF customer warranty records.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $(function () {
        $.ajax({
            url: '{{ route("admin.index") }}',
            type: 'GET',
            success: function(data) {
                $('#rs8-count-card').text(data.rs8Count);
                $('#srf-count-card').text(data.srfCount);
            }
        });
    });
</script>
@endpush
@endsection
