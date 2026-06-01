{{--
  resources/views/survey/admin/index.blade.php
  Admin CSAT Dashboard — extends layouts.app
--}}
@extends('layouts.app')

@section('title', 'CSAT Dashboard')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --navy:       #1565c0;
        --navy-mid:   #1565c0;
        --gold:       #C9A84C;
        --gold-light: #E8D49E;
        --gold-pale:  #FBF6E9;
        --slate:      #64748B;
        --success:    #059669;
        --danger:     #DC2626;
        --warn:       #D97706;
    }

    body { font-family: 'DM Sans', sans-serif; }

    /* ── Page header ── */
    .csat-page-header {
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
        border-bottom: 3px solid var(--gold);
        padding: 2rem 2.5rem 1.6rem;
        position: relative;
        overflow: hidden;
    }
    .csat-page-header::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 280px; height: 280px;
        background: rgba(201,168,76,0.08);
        border-radius: 50%;
        pointer-events: none;
    }
    .csat-page-header::after {
        content: '';
        position: absolute;
        bottom: -80px; left: 30%;
        width: 200px; height: 200px;
        background: rgba(201,168,76,0.05);
        border-radius: 50%;
        pointer-events: none;
    }
    .page-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(201,168,76,0.15);
        border: 1px solid rgba(201,168,76,0.4);
        color: var(--gold-light);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        padding: 4px 14px;
        border-radius: 30px;
        margin-bottom: 10px;
    }
    .page-title {
        font-family: 'DM Serif Display', serif;
        font-size: 2rem;
        color: white;
        line-height: 1.2;
        margin: 0;
    }
    .page-subtitle {
        color: rgba(255,255,255,0.6);
        font-size: 0.875rem;
        margin-top: 6px;
    }

    /* ── Stat cards ── */
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 1.4rem 1.6rem;
        border: 1px solid #EEF0F4;
        box-shadow: 0 2px 12px rgba(11,31,58,0.06);
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(11,31,58,0.12);
    }
    .stat-card::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 0 0 20px 20px;
    }
    .stat-card.gold::after  { background: var(--gold); }
    .stat-card.green::after { background: var(--success); }
    .stat-card.red::after   { background: var(--danger); }
    .stat-card.navy::after  { background: var(--navy); }

    .stat-icon {
        width: 48px; height: 48px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }
    .stat-icon.gold  { background: var(--gold-pale);       color: var(--gold); }
    .stat-icon.green { background: #ECFDF5;                color: var(--success); }
    .stat-icon.red   { background: #FEF2F2;                color: var(--danger); }
    .stat-icon.navy  { background: #EEF2FF;                color: var(--navy); }

    .stat-value {
        font-family: 'DM Serif Display', serif;
        font-size: 2rem;
        color: var(--navy);
        line-height: 1;
    }
    .stat-label {
        font-size: 0.78rem;
        color: var(--slate);
        font-weight: 500;
        margin-top: 4px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .stat-sub {
        font-size: 0.7rem;
        color: #94A3B8;
        margin-top: 2px;
    }

    /* ── Section headers ── */
    .section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1rem;
    }
    .section-header span {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.16em;
        color: var(--gold);
        text-transform: uppercase;
    }
    .section-header hr {
        flex: 1;
        border: none;
        height: 1px;
        background: linear-gradient(90deg, rgba(201,168,76,0.4), transparent);
    }

    /* ── Filter bar ── */
    .filter-card {
        background: white;
        border-radius: 18px;
        border: 1px solid #EEF0F4;
        padding: 1.3rem 1.6rem;
        box-shadow: 0 2px 8px rgba(11,31,58,0.05);
    }
    .filter-input {
        border: 1.5px solid #E2E8F0;
        border-radius: 10px;
        padding: 0.5rem 0.85rem;
        font-size: 0.85rem;
        color: var(--navy);
        background: #FAFBFC;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        width: 100%;
        font-family: 'DM Sans', sans-serif;
    }
    .filter-input:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(201,168,76,0.12);
        background: white;
    }
    .filter-label {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.1em;
        color: #64748B;
        text-transform: uppercase;
        margin-bottom: 5px;
        display: block;
    }
    .btn-filter {
        background: linear-gradient(135deg, var(--navy), var(--navy-mid));
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.55rem 1.4rem;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        letter-spacing: 0.05em;
        transition: all 0.2s;
        font-family: 'DM Sans', sans-serif;
    }
    .btn-filter:hover { opacity: 0.88; transform: translateY(-1px); }
    .btn-reset {
        background: #F1F5F9;
        color: #475569;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 0.55rem 1.2rem;
        font-size: 0.82rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none;
        display: inline-block;
    }
    .btn-reset:hover { background: #E2E8F0; }

    /* ── Tables ── */
    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .data-table thead th {
        background: var(--navy);
        color: rgba(255,255,255,0.75);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        padding: 0.85rem 1.1rem;
        white-space: nowrap;
    }
    .data-table thead th:first-child { border-radius: 12px 0 0 0; }
    .data-table thead th:last-child  { border-radius: 0 12px 0 0; }
    .data-table tbody tr {
        transition: background 0.15s;
    }
    .data-table tbody tr:hover td { background: #FAFBFF; }
    .data-table tbody td {
        padding: 0.85rem 1.1rem;
        font-size: 0.855rem;
        color: #2D3A4A;
        border-bottom: 1px solid #F0F2F6;
        background: white;
        vertical-align: middle;
    }
    .data-table tbody tr:last-child td:first-child { border-radius: 0 0 0 12px; }
    .data-table tbody tr:last-child td:last-child  { border-radius: 0 0 12px 0; }

    /* ── Score badge ── */
    .score-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 700;
    }
    .score-excellent { background: #ECFDF5; color: #065F46; }
    .score-good      { background: #FEF9C3; color: #854D0E; }
    .score-neutral   { background: #FFF7ED; color: #9A3412; }
    .score-poor      { background: #FEF2F2; color: #991B1B; }

    /* ── Star display ── */
    .star-display {
        display: inline-flex;
        gap: 1px;
        font-size: 13px;
        line-height: 1;
    }
    .star-filled  { color: var(--gold); }
    .star-empty   { color: #DDE1EA; }

    /* ── Engineer stat card ── */
    .eng-card {
        background: white;
        border: 1px solid #EEF0F4;
        border-radius: 16px;
        padding: 1rem 1.3rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 1px 6px rgba(11,31,58,0.04);
        transition: all 0.2s;
    }
    .eng-card:hover {
        border-color: var(--gold);
        box-shadow: 0 4px 16px rgba(201,168,76,0.15);
    }
    .eng-avatar {
        width: 42px; height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--navy), var(--navy-mid));
        color: var(--gold);
        display: flex; align-items: center; justify-content: center;
        font-family: 'DM Serif Display', serif;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .eng-name {
        font-weight: 600;
        color: var(--navy);
        font-size: 0.88rem;
    }
    .eng-meta {
        font-size: 0.72rem;
        color: var(--slate);
        margin-top: 2px;
    }
    .eng-score {
        margin-left: auto;
        text-align: right;
        flex-shrink: 0;
    }
    .eng-score-val {
        font-family: 'DM Serif Display', serif;
        font-size: 1.4rem;
        color: var(--navy);
        line-height: 1;
    }
    .eng-score-label {
        font-size: 10px;
        color: var(--slate);
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    /* Score bar */
    .score-bar-wrap {
        height: 5px;
        background: #EEF0F4;
        border-radius: 10px;
        margin-top: 6px;
        overflow: hidden;
    }
    .score-bar-fill {
        height: 100%;
        border-radius: 10px;
        background: linear-gradient(90deg, var(--gold), #E8A838);
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ── Pagination ── */
    .pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 1.2rem;
    }
    .pagination-wrap .pagination {
        display: flex;
        gap: 4px;
        list-style: none;
        padding: 0; margin: 0;
    }
    .pagination-wrap .pagination li a,
    .pagination-wrap .pagination li span {
        display: flex; align-items: center; justify-content: center;
        width: 34px; height: 34px;
        border-radius: 9px;
        font-size: 0.82rem;
        font-weight: 500;
        text-decoration: none;
        color: var(--navy);
        background: white;
        border: 1px solid #E2E8F0;
        transition: all 0.15s;
    }
    .pagination-wrap .pagination li.active span,
    .pagination-wrap .pagination li a:hover {
        background: var(--navy);
        color: white;
        border-color: var(--navy);
    }
    .pagination-info {
        font-size: 0.8rem;
        color: var(--slate);
    }

    /* ── View detail button ── */
    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--navy);
        background: #F0F4FF;
        border: 1px solid #DDE4F0;
        text-decoration: none;
        transition: all 0.15s;
    }
    .btn-detail:hover {
        background: var(--navy);
        color: white;
        border-color: var(--navy);
    }

    /* ── Empty state ── */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }
    .empty-state-icon {
        width: 64px; height: 64px;
        background: var(--gold-pale);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.8rem;
    }

    /* ── Animate in ── */
    .fade-up {
        opacity: 0;
        transform: translateY(16px);
        animation: fadeUp 0.5s ease forwards;
    }
    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }
    .delay-1 { animation-delay: 0.05s; }
    .delay-2 { animation-delay: 0.10s; }
    .delay-3 { animation-delay: 0.15s; }
    .delay-4 { animation-delay: 0.20s; }
    .delay-5 { animation-delay: 0.25s; }
    .searchable-select {
    position: relative;
    cursor: pointer;
}
.dropdown-arrow {
    position: absolute;
    right: 0.6rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    pointer-events: none;
    transition: transform 0.2s;
}
.dropdown-arrow.open {
    transform: translateY(-50%) rotate(180deg);
}
.dropdown-list {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    background: white;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    box-shadow: 0 8px 24px -4px rgba(15,23,42,0.12), 0 2px 8px -2px rgba(15,23,42,0.08);
    z-index: 100;
    max-height: 220px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: #C9A84C #f8fafc;
}
.dropdown-list::-webkit-scrollbar       { width: 4px; }
.dropdown-list::-webkit-scrollbar-track { background: #f8fafc; border-radius: 4px; }
.dropdown-list::-webkit-scrollbar-thumb { background: #C9A84C; border-radius: 4px; }
.dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.8rem;
    color: #334155;
    cursor: pointer;
    transition: background 0.12s;
    border-radius: 6px;
    margin: 2px 4px;
}
.dropdown-item:hover  { background: #f0f7ff; color: #1565c0; }
.dropdown-item.selected { background: #eff6ff; color: #1565c0; font-weight: 600; }
.clear-item { color: #94a3b8; }
.clear-item:hover { background: #fef2f2; color: #ef4444; }
</style>

@endpush

@section('content')

{{-- ── PAGE HEADER ── --}}
<div class="text-blue-500 rounded-xl shadow-lg p-8 fade-up">

    <div class="flex items-center justify-between mb-6">
        <!-- Badge -->
        <div class="flex items-center gap-2 bg-blue-300 text-[#1565c0] text-xs font-semibold px-3 py-1 rounded-full">
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            Management Dashboard
        </div>

    </div>

    <!-- Title -->
    <h1 class="text-4xl font-bold leading-tight">
        Customer Satisfaction <br>
        <span class="italic text-yellow-300">Analytics</span>
    </h1>

    <!-- Subtitle -->
    <p class="mt-3 text-blue-300 text-sm">
        All submitted CSAT responses — filtered, ranked, and ready for action.
    </p>

</div>

<div class="p-6 space-y-6">

    {{-- ── STAT CARDS ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card navy fade-up delay-1">
            <div class="stat-icon navy">
                <i class="fa-solid fa-clipboard-list"></i>
            </div>
            <div>
                <div class="stat-value">{{ number_format($totalCount) }}</div>
                <div class="stat-label">Total Responses</div>
                <div class="stat-sub">All time</div>
            </div>
        </div>

        <div class="stat-card gold fade-up delay-2">
            <div class="stat-icon gold">
                <i class="fa-solid fa-star"></i>
            </div>
            <div>
                <div class="stat-value">{{ number_format($avgScore, 2) }}</div>
                <div class="stat-label">Overall CSAT</div>
                <div class="stat-sub">Out of 5.00</div>
            </div>
        </div>

        <div class="stat-card green fade-up delay-3">
            <div class="stat-icon green">
                <i class="fa-solid fa-face-smile"></i>
            </div>
            <div>
                <div class="stat-value">{{ number_format($highRated) }}</div>
                <div class="stat-label">High Rated</div>
                <div class="stat-sub">Score ≥ 4.0</div>
            </div>
        </div>

        <div class="stat-card red fade-up delay-4">
            <div class="stat-icon red">
                <i class="fa-solid fa-face-frown"></i>
            </div>
            <div>
                <div class="stat-value">{{ number_format($lowRated) }}</div>
                <div class="stat-label">Needs Attention</div>
                <div class="stat-sub">Score &lt; 3.0</div>
            </div>
        </div>
    </div>

    {{-- ── FILTERS ── --}}
   <div class="filter-card fade-up delay-2">
    <div class="section-header mb-3">
        <span>Filter Responses</span><hr>
    </div>
    <form method="GET" action="{{ route('admin.csat.index') }}" id="csatFilterForm">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 items-end">

            {{-- Hospital searchable dropdown --}}
            <div class="relative" id="hospitalDropdown">
                <label class="filter-label">Hospital / Client</label>
                <div class="searchable-select" onclick="toggleDropdown('hospital')">
                    <input
                        type="text"
                        id="hospitalSearch"
                        class="filter-input pr-8"
                        placeholder="Search hospital…"
                        value="{{ request('hospital') }}"
                        oninput="filterOptions('hospital')"
                        autocomplete="off"
                    >
                    <input type="hidden" name="hospital" id="hospitalValue" value="{{ request('hospital') }}">
                    <span class="dropdown-arrow" id="hospitalArrow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </div>
                <div class="dropdown-list hidden" id="hospitalList">
                    <div class="dropdown-item clear-item" onclick="clearSelect('hospital')">
                        <span class="text-gray-400 italic text-xs">— Any hospital —</span>
                    </div>
                    @foreach($hospitals as $h)
                    <div class="dropdown-item {{ request('hospital') === $h ? 'selected' : '' }}"
                         onclick="selectOption('hospital', '{{ addslashes($h) }}')">
                        <svg class="w-3.5 h-3.5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                        </svg>
                        <span>{{ $h }}</span>
                        @if(request('hospital') === $h)
                        <svg class="w-3.5 h-3.5 text-blue-500 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        @endif
                    </div>
                    @endforeach
                    <div class="dropdown-empty hidden px-3 py-2 text-xs text-gray-400 italic">No results found</div>
                </div>
            </div>

            {{-- Engineer searchable dropdown --}}
            <div class="relative" id="engineerDropdown">
                <label class="filter-label">Engineer</label>
                <div class="searchable-select" onclick="toggleDropdown('engineer')">
                    <input
                        type="text"
                        id="engineerSearch"
                        class="filter-input pr-8"
                        placeholder="Search engineer…"
                        value="{{ request('engineer') }}"
                        oninput="filterOptions('engineer')"
                        autocomplete="off"
                    >
                    <input type="hidden" name="engineer" id="engineerValue" value="{{ request('engineer') }}">
                    <span class="dropdown-arrow" id="engineerArrow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </div>
                <div class="dropdown-list hidden" id="engineerList">
                    <div class="dropdown-item clear-item" onclick="clearSelect('engineer')">
                        <span class="text-gray-400 italic text-xs">— Any engineer —</span>
                    </div>
                    @foreach($engineers as $e)
                    <div class="dropdown-item {{ request('engineer') === $e ? 'selected' : '' }}"
                         onclick="selectOption('engineer', '{{ addslashes($e) }}')">
                        <svg class="w-3.5 h-3.5 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>{{ $e }}</span>
                        @if(request('engineer') === $e)
                        <svg class="w-3.5 h-3.5 text-blue-500 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        @endif
                    </div>
                    @endforeach
                    <div class="dropdown-empty hidden px-3 py-2 text-xs text-gray-400 italic">No results found</div>
                </div>
            </div>

            {{-- Min Score --}}
            <div>
                <label class="filter-label">Min Score</label>
                <input type="number" name="min_score" class="filter-input"
                       placeholder="1" min="1" max="5" step="0.1"
                       value="{{ request('min_score') }}">
            </div>

            {{-- Max Score --}}
            <div>
                <label class="filter-label">Max Score</label>
                <input type="number" name="max_score" class="filter-input"
                       placeholder="5" min="1" max="5" step="0.1"
                       value="{{ request('max_score') }}">
            </div>

            {{-- Date From --}}
            <div>
                <label class="filter-label">Date From</label>
                <input type="date" name="date_from" class="filter-input"
                       value="{{ request('date_from') }}">
            </div>

            {{-- Date To --}}
            <div>
                <label class="filter-label">Date To</label>
                <input type="date" name="date_to" class="filter-input"
                       value="{{ request('date_to') }}">
            </div>
        </div>

        <div class="flex items-center gap-2 mt-3">
            <button type="submit" class="btn-filter">
                <i class="fa-solid fa-magnifying-glass mr-1.5"></i> Apply Filters
            </button>
            <a href="{{ route('admin.csat.index') }}" class="btn-reset">
                <i class="fa-solid fa-rotate-left mr-1"></i> Reset
            </a>
            @if(request()->hasAny(['hospital','engineer','min_score','max_score','date_from','date_to']))
            <span class="text-xs text-amber-600 font-medium bg-amber-50 border border-amber-200 px-3 py-1.5 rounded-lg">
                <i class="fa-solid fa-filter mr-1"></i> Filters active
            </span>
            @endif
        </div>
    </form>
</div>

    {{-- ── MAIN GRID: Table + Engineer Stats ── --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Responses Table (2/3 width) --}}
        <div class="xl:col-span-2 fade-up delay-3">
            <div class="section-header">
                <span>Submitted Responses</span><hr>
                <span class="text-xs text-slate-400 font-normal ml-2">
                    {{ $responses->total() }} total
                </span>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                @if($responses->count())
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Hospital</th>
                                <th>Engineer</th>
                                <th>Service Date</th>
                                <th>Avg Score</th>
                                <th>Overall</th>
                                <th>Submitted</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($responses as $r)
                            @php
                                $score = $r->average_score;
                                $scoreClass = match(true) {
                                    $score >= 4.5 => 'score-excellent',
                                    $score >= 3.5 => 'score-good',
                                    $score >= 2.5 => 'score-neutral',
                                    default       => 'score-poor',
                                };
                                $scoreLabel = match(true) {
                                    $score >= 4.5 => 'Excellent',
                                    $score >= 3.5 => 'Satisfied',
                                    $score >= 2.5 => 'Neutral',
                                    default       => 'Poor',
                                };
                                $filled = round($r->overall_satisfaction);
                            @endphp
                            <tr>
                                <td>
                                    <div class="font-semibold text-[#1565c0] text-sm leading-tight">
                                        {{ $r->hospital_name ?? '—' }}
                                    </div>
                                    @if($r->serviceRecord?->machine?->name)
                                    <div class="text-xs text-slate-400 mt-0.5">
                                        {{ $r->serviceRecord->machine->name }}
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="inline-flex items-center gap-1.5">
                                        <span class="w-6 h-6 rounded-full bg-[#EEF2FF] text-[#0B1F3A] flex items-center justify-center text-[10px] font-bold flex-shrink-0">
                                            {{ strtoupper(substr($r->service_engineer ?? 'N', 0, 1)) }}
                                        </span>
                                        <span class="text-sm">{{ $r->service_engineer ?? '—' }}</span>
                                    </span>
                                </td>
                                <td class="text-slate-500 text-xs whitespace-nowrap">
                                    {{ $r->serviceRecord?->formatted_service_date ?? '—' }}
                                </td>
                                <td>
                                    <span class="score-badge {{ $scoreClass }}">
                                        <i class="fa-solid fa-star text-[10px]"></i>
                                        {{ number_format($score, 2) }}
                                    </span>
                                    <div class="text-[10px] text-slate-400 mt-1">{{ $scoreLabel }}</div>
                                </td>
                                <td>
                                    <div class="star-display">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= $filled ? 'star-filled' : 'star-empty' }}">★</span>
                                        @endfor
                                    </div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">
                                        {{ $r->overall_satisfaction }}/5
                                    </div>
                                </td>
                                <td class="text-slate-500 text-xs whitespace-nowrap">
                                    {{ $r->submitted_at?->format('M d, Y') }}<br>
                                    <span class="text-slate-400">{{ $r->submitted_at?->format('g:i A') }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.csat.show', $r->id) }}" class="btn-detail">
                                        View <i class="fa-solid fa-arrow-right text-[9px]"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-4 py-3 border-t border-gray-100">
                    <div class="pagination-wrap">
                        <span class="pagination-info">
                            Showing {{ $responses->firstItem() }}–{{ $responses->lastItem() }}
                            of {{ $responses->total() }} results
                        </span>
                        {{ $responses->links() }}
                    </div>
                </div>

                @else
                <div class="empty-state">
                    <div class="empty-state-icon">⭐</div>
                    <p class="font-semibold text-[#0B1F3A] text-base">No responses found</p>
                    <p class="text-slate-400 text-sm mt-1">
                        {{ request()->hasAny(['hospital','engineer','min_score','max_score','date_from','date_to'])
                            ? 'Try adjusting your filters.' : 'No CSAT surveys have been submitted yet.' }}
                    </p>
                </div>
                @endif
            </div>
        </div>

        {{-- Engineer Stats (1/3 width) --}}
        <div class="fade-up delay-4">
            <div class="section-header">
                <span>Engineer Rankings</span><hr>
            </div>

            <div class="space-y-3">
                @forelse($engineerStats as $idx => $eng)
                @php
                    $pct = ($eng->avg_score / 5) * 100;
                    $medal = match($idx) { 0 => '🥇', 1 => '🥈', 2 => '🥉', default => '' };
                @endphp
                <div class="eng-card">
                    <div class="eng-avatar">
                        {{ strtoupper(substr($eng->service_engineer ?? 'N', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="eng-name truncate">
                            {{ $medal }} {{ $eng->service_engineer ?? 'Unknown' }}
                        </div>
                        <div class="eng-meta">
                            {{ $eng->total_responses }} {{ Str::plural('response', $eng->total_responses) }}
                            &nbsp;·&nbsp;
                            Recommend: {{ number_format($eng->avg_recommend, 1) }}/5
                        </div>
                        <div class="score-bar-wrap">
                            <div class="score-bar-fill" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                    <div class="eng-score">
                        <div class="eng-score-val">{{ number_format($eng->avg_score, 1) }}</div>
                        <div class="eng-score-label">Avg</div>
                    </div>
                </div>
                @empty
                <div class="text-center py-10 text-slate-400 text-sm">
                    No engineer data yet.
                </div>
                @endforelse
            </div>

            {{-- Overall satisfaction breakdown mini-card --}}
            @if($totalCount > 0)
            <div class="mt-4 bg-white rounded-2xl border border-[#EEF0F4] p-4 shadow-sm">
                <div class="section-header mb-3">
                    <span>Score Distribution</span><hr>
                </div>
                @php
                    $bands = [
                        ['label' => 'Excellent (4.5–5)', 'count' => \App\Models\CsatResponse::where('average_score','>=',4.5)->count(), 'color' => '#059669'],
                        ['label' => 'Good (3.5–4.4)',    'count' => \App\Models\CsatResponse::whereBetween('average_score',[3.5,4.49])->count(), 'color' => '#C9A84C'],
                        ['label' => 'Neutral (2.5–3.4)', 'count' => \App\Models\CsatResponse::whereBetween('average_score',[2.5,3.49])->count(), 'color' => '#D97706'],
                        ['label' => 'Poor (< 2.5)',      'count' => \App\Models\CsatResponse::where('average_score','<',2.5)->count(), 'color' => '#DC2626'],
                    ];
                @endphp
                @foreach($bands as $band)
                @php $pct = $totalCount > 0 ? round(($band['count'] / $totalCount) * 100) : 0; @endphp
                <div class="mb-2.5">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-slate-600">{{ $band['label'] }}</span>
                        <span class="font-semibold text-[#0B1F3A]">{{ $band['count'] }} ({{ $pct }}%)</span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-700"
                             style="width: {{ $pct }}%; background: {{ $band['color'] }};"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

    </div>{{-- end main grid --}}

</div>{{-- end p-6 --}}
<script>
(function () {
    // Close all dropdowns when clicking outside
    document.addEventListener('click', function (e) {
        ['hospital', 'engineer'].forEach(function (key) {
            const wrapper = document.getElementById(key + 'Dropdown');
            if (wrapper && !wrapper.contains(e.target)) {
                closeDropdown(key);
            }
        });
    });

    window.toggleDropdown = function (key) {
        const list  = document.getElementById(key + 'List');
        const arrow = document.getElementById(key + 'Arrow');
        const isOpen = !list.classList.contains('hidden');

        // Close the other one first
        ['hospital', 'engineer'].forEach(function (k) {
            if (k !== key) closeDropdown(k);
        });

        if (isOpen) {
            closeDropdown(key);
        } else {
            list.classList.remove('hidden');
            arrow.classList.add('open');
            document.getElementById(key + 'Search').focus();
        }
    };

    window.closeDropdown = function (key) {
        document.getElementById(key + 'List').classList.add('hidden');
        document.getElementById(key + 'Arrow').classList.remove('open');
    };

    window.selectOption = function (key, value) {
        document.getElementById(key + 'Search').value = value;
        document.getElementById(key + 'Value').value  = value;
        closeDropdown(key);
        // Remove selected highlight from all, add to clicked
        document.querySelectorAll('#' + key + 'List .dropdown-item').forEach(function (el) {
            el.classList.remove('selected');
        });
    };

    window.clearSelect = function (key) {
        document.getElementById(key + 'Search').value = '';
        document.getElementById(key + 'Value').value  = '';
        closeDropdown(key);
    };

    window.filterOptions = function (key) {
        const search  = document.getElementById(key + 'Search').value.toLowerCase();
        const items   = document.querySelectorAll('#' + key + 'List .dropdown-item:not(.clear-item)');
        const empty   = document.querySelector('#' + key + 'List .dropdown-empty');
        let   visible = 0;

        items.forEach(function (item) {
            const text = item.querySelector('span')?.textContent.toLowerCase() ?? '';
            if (text.includes(search)) {
                item.style.display = '';
                visible++;
            } else {
                item.style.display = 'none';
            }
        });

        // Also update hidden value as user types freely
        document.getElementById(key + 'Value').value = document.getElementById(key + 'Search').value;

        if (empty) {
            empty.classList.toggle('hidden', visible > 0);
        }

        // Open dropdown if not already open
        const list = document.getElementById(key + 'List');
        if (list.classList.contains('hidden')) {
            list.classList.remove('hidden');
            document.getElementById(key + 'Arrow').classList.add('open');
        }
    };
})();
</script>
@endsection