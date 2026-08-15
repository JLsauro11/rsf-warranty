@php
    $brand = strtolower($brand ?? 'rs8');
    $accentLabel = strtoupper($brand);
@endphp

<div id="warrantyDateFilter" class="warranty-date-filter warranty-date-filter--{{ $brand }}" data-warranty-date-filter>
    <div class="warranty-date-filter__identity">
        <span class="warranty-date-filter__eyebrow">Purchase Date Filter</span>
        <strong>{{ $accentLabel }} Date Range</strong>
        <span class="warranty-date-filter__hint">Filter records by the customer's actual purchase date.</span>
    </div>

    <div class="warranty-date-filter__dates">
        <label class="warranty-date-filter__field" for="fromDate">
            <span>From</span>
            <input type="date" class="form-control" id="fromDate" autocomplete="off">
        </label>

        <span class="warranty-date-filter__arrow" aria-hidden="true">
            <i class="fas fa-arrow-right"></i>
        </span>

        <label class="warranty-date-filter__field" for="toDate">
            <span>To</span>
            <input type="date" class="form-control" id="toDate" autocomplete="off">
        </label>
    </div>

    <div class="warranty-date-filter__actions">
        <div class="warranty-date-filter__quick" aria-label="Quick purchase date ranges">
            <button type="button" class="warranty-date-filter__preset" data-range="today">Today</button>
            <button type="button" class="warranty-date-filter__preset" data-range="7">7 Days</button>
            <button type="button" class="warranty-date-filter__preset" data-range="30">30 Days</button>
            <button type="button" class="warranty-date-filter__preset" data-range="month">This Month</button>
        </div>

        <div class="warranty-date-filter__buttons">
            <button type="button" class="btn warranty-date-filter__clear" id="clearFilterBtn">
                <i class="fas fa-rotate-left"></i>
                <span>Clear</span>
            </button>
            <button type="button" class="btn warranty-date-filter__apply" id="filterBtn">
                <i class="fas fa-filter"></i>
                <span>Apply Filter</span>
            </button>
        </div>
    </div>

    <div class="warranty-date-filter__status" id="dateFilterStatus" aria-live="polite">
        <i class="fas fa-calendar-check"></i>
        <span>Showing all purchase dates</span>
    </div>
</div>
