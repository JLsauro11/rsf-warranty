@extends('layout.app')
@section('title', 'SRF Dashboard')

@section('content')
<div class="main-panel">
    @include('layout.header')
    <div class="container">
        <div class="page-inner csr-dashboard-page">
            <section class="csr-command csr-command--srf" aria-labelledby="csr-srf-title">
                <div class="csr-command__copy">
                    <div class="csr-command__kicker">
                        <span class="csr-command__signal"></span>
                        SRF Customer Service
                    </div>

                    <h1 id="csr-srf-title">Warranty Support<br><span>Command</span></h1>
                    <p>One focused workspace for SRF warranty monitoring, customer support, and fast record review.</p>

                    <div class="csr-command__actions">
                        <a href="{{ route('csr_srf.srf.index') }}" class="csr-command__primary">
                            <span>Open Warranty Records</span>
                            <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                        <span class="csr-command__live"><i></i> Live workspace</span>
                    </div>

                    <div class="csr-command__tags" aria-label="Workspace capabilities">
                        <span><i class="fas fa-headset"></i> Customer Support</span>
                        <span><i class="fas fa-shield-alt"></i> Warranty Review</span>
                        <span><i class="fas fa-bolt"></i> Fast Monitoring</span>
                    </div>
                </div>

                <div class="csr-command__brand-panel">
                    <div class="csr-command__panel-head">
                        <span>SRF Channel</span>
                        <small>Operational</small>
                    </div>

                    <div class="csr-command__brand-lockup">
                        <img src="{{ asset('assets/img/srf-brand.png') }}" alt="SRF">
                    </div>

                    <div class="csr-command__metric">
                        <div>
                            <span class="csr-command__metric-label">Warranty Records</span>
                            <strong id="srf-count">{{ $srfCount ?? '—' }}</strong>
                        </div>
                        <div class="csr-command__metric-icon"><i class="fas fa-flag-checkered"></i></div>
                    </div>

                    <div class="csr-command__panel-foot">
                        <span>Current customer registrations</span>
                        <i class="fas fa-circle"></i>
                    </div>
                </div>
            </section>

            <section class="csr-workspace-strip" aria-label="SRF workspace quick access">
                <div class="csr-workspace-strip__intro">
                    <div class="rs-eyebrow">Quick Access</div>
                    <h2>Keep support moving.</h2>
                    <p>Move directly to the SRF warranty channel to review customer registrations and support requests.</p>
                </div>
                <a href="{{ route('csr_srf.srf.index') }}" class="csr-workspace-card csr-workspace-card--srf">
                    <span class="csr-workspace-card__icon"><i class="fas fa-flag-checkered"></i></span>
                    <span class="csr-workspace-card__body">
                        <small>SRF Warranty Channel</small>
                        <strong>Review Records</strong>
                        <em>Open the full warranty table</em>
                    </span>
                    <span class="csr-workspace-card__arrow"><i class="fas fa-external-link-alt"></i></span>
                </a>
            </section>
        </div>
    </div>
</div>

@push('js')
<script>
    $(function () {
        $.ajax({
            url: '{{ route("csr_srf.index") }}',
            type: 'GET',
            success: function(data) {
                if (typeof data.srfCount !== 'undefined') {
                    $('#srf-count').text(data.srfCount);
                }
            }
        });
    });
</script>
@endpush
@endsection
