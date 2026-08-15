@extends('layout.app')
@section('title', 'RS8 Dashboard')

@section('content')
<div class="main-panel">
    @include('layout.header')
    <div class="container">
        <div class="page-inner csr-dashboard-page">
            <section class="csr-command csr-command--rs8" aria-labelledby="csr-rs8-title">
                <div class="csr-command__copy">
                    <div class="csr-command__kicker">
                        <span class="csr-command__signal"></span>
                        RS8 Customer Service
                    </div>

                    <h1 id="csr-rs8-title">Warranty Support<br><span>Command</span></h1>
                    <p>One focused workspace for RS8 warranty monitoring, customer support, and fast record review.</p>

                    <div class="csr-command__actions">
                        <a href="{{ route('csr_rs8.rs8.index') }}" class="csr-command__primary">
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
                        <span>RS8 Channel</span>
                        <small>Operational</small>
                    </div>

                    <div class="csr-command__brand-lockup">
                        <img src="{{ asset('assets/img/rs8-brand.png') }}" alt="RS8">
                    </div>

                    <div class="csr-command__metric">
                        <div>
                            <span class="csr-command__metric-label">Warranty Records</span>
                            <strong id="rs8-count">{{ $rs8Count ?? '—' }}</strong>
                        </div>
                        <div class="csr-command__metric-icon"><i class="fas fa-bolt"></i></div>
                    </div>

                    <div class="csr-command__panel-foot">
                        <span>Current customer registrations</span>
                        <i class="fas fa-circle"></i>
                    </div>
                </div>
            </section>

            <section class="csr-workspace-strip" aria-label="RS8 workspace quick access">
                <div class="csr-workspace-strip__intro">
                    <div class="rs-eyebrow">Quick Access</div>
                    <h2>Stay on the record.</h2>
                    <p>Move directly to the RS8 warranty channel to review customer registrations and support requests.</p>
                </div>
                <a href="{{ route('csr_rs8.rs8.index') }}" class="csr-workspace-card csr-workspace-card--rs8">
                    <span class="csr-workspace-card__icon"><i class="fas fa-bolt"></i></span>
                    <span class="csr-workspace-card__body">
                        <small>RS8 Warranty Channel</small>
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
            url: '{{ route("csr_rs8.index") }}',
            type: 'GET',
            success: function(data) {
                if (typeof data.rs8Count !== 'undefined') {
                    $('#rs8-count').text(data.rs8Count);
                }
            }
        });
    });
</script>
@endpush
@endsection
