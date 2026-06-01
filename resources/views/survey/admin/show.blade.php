{{--
  resources/views/survey/admin/show.blade.php
  Admin — single CSAT response detail
--}}
@extends('layouts.app')

@section('title', 'CSAT Response Detail')

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

    .detail-header {
        background: linear-gradient(135deg, var(--navy), var(--navy-mid));
        border-bottom: 3px solid var(--gold);
        padding: 1.8rem 2.5rem;
        position: relative;
        overflow: hidden;
    }
    .detail-header::before {
        content: '';
        position: absolute;
        top: -50px; right: -50px;
        width: 220px; height: 220px;
        background: rgba(201,168,76,0.08);
        border-radius: 50%;
        pointer-events: none;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: rgba(255,255,255,0.6);
        font-size: 0.82rem;
        text-decoration: none;
        margin-bottom: 1rem;
        transition: color 0.15s;
    }
    .back-btn:hover { color: var(--gold-light); }

    .detail-title {
        font-family: 'DM Serif Display', serif;
        font-size: 1.8rem;
        color: white;
        line-height: 1.2;
    }

    .info-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.18);
        color: rgba(255,255,255,0.8);
        font-size: 0.78rem;
        padding: 4px 12px;
        border-radius: 20px;
    }
    .info-chip i { color: var(--gold); }

    /* Cards */
    .detail-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #EEF0F4;
        box-shadow: 0 2px 12px rgba(11,31,58,0.06);
        overflow: hidden;
    }
    .detail-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #F0F2F6;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .detail-card-header i { color: var(--gold); }
    .detail-card-header span {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--navy);
    }
    .detail-card-body { padding: 1.3rem 1.5rem; }

    /* Score row */
    .score-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.65rem 0;
        border-bottom: 1px solid #F4F6FA;
    }
    .score-row:last-child { border-bottom: none; }
    .score-row-label {
        font-size: 0.855rem;
        color: #2D3A4A;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .score-row-num {
        width: 24px; height: 24px;
        background: var(--navy);
        color: white;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 700;
        flex-shrink: 0;
    }
    .score-row-stars {
        display: flex;
        gap: 2px;
        font-size: 14px;
    }
    .star-on  { color: var(--gold); }
    .star-off { color: #DDE1EA; }

    /* Big score */
    .big-score {
        text-align: center;
        padding: 1.5rem;
    }
    .big-score-value {
        font-family: 'DM Serif Display', serif;
        font-size: 3.5rem;
        color: var(--navy);
        line-height: 1;
    }
    .big-score-label {
        font-size: 0.8rem;
        color: var(--slate);
        margin-top: 4px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }
    .score-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 700;
        margin-top: 8px;
    }
    .score-excellent { background: #ECFDF5; color: #065F46; }
    .score-good      { background: #FEF9C3; color: #854D0E; }
    .score-neutral   { background: #FFF7ED; color: #9A3412; }
    .score-poor      { background: #FEF2F2; color: #991B1B; }

    /* Score gauge */
    .gauge-wrap {
        width: 120px; height: 60px;
        margin: 0.5rem auto 0;
        position: relative;
    }
    .gauge-svg { width: 100%; height: 100%; overflow: visible; }

    /* Feedback card */
    .feedback-box {
        background: #F9FAFB;
        border-radius: 12px;
        border: 1px solid #EEF0F4;
        padding: 1rem 1.2rem;
        font-size: 0.875rem;
        color: #374151;
        line-height: 1.6;
        font-style: italic;
        position: relative;
    }
    .feedback-box::before {
        content: '"';
        font-family: 'DM Serif Display', serif;
        font-size: 3rem;
        color: var(--gold);
        opacity: 0.4;
        position: absolute;
        top: -8px; left: 10px;
        line-height: 1;
    }
    .feedback-box p { padding-left: 12px; }

    /* Contact card */
    .contact-row {
        display: flex; align-items: center; gap: 10px;
        padding: 0.6rem 0;
        font-size: 0.855rem;
        color: #2D3A4A;
        border-bottom: 1px solid #F4F6FA;
    }
    .contact-row:last-child { border-bottom: none; }
    .contact-row i { color: var(--gold); width: 16px; text-align: center; }

    /* Animate */
    .fade-up { opacity: 0; transform: translateY(14px); animation: fadeUp 0.45s ease forwards; }
    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    .d1 { animation-delay: 0.05s; } .d2 { animation-delay: 0.10s; }
    .d3 { animation-delay: 0.15s; } .d4 { animation-delay: 0.20s; }
    .d5 { animation-delay: 0.25s; } .d6 { animation-delay: 0.30s; }
</style>
@endpush

@section('content')

@php
    $r = $csatResponse;
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
    $perfItems = [
        ['key' => 'perf_sla',            'label' => 'Response within SLA'],
        ['key' => 'perf_first_visit',    'label' => 'First‑visit resolution'],
        ['key' => 'perf_professionalism','label' => 'Professionalism & courtesy'],
        ['key' => 'perf_technical',      'label' => 'Technical knowledge'],
        ['key' => 'perf_pm',             'label' => 'PM thoroughness'],
        ['key' => 'perf_explanation',    'label' => 'Clear explanation of findings'],
        ['key' => 'perf_report',         'label' => 'Report accuracy & completeness'],
    ];
@endphp

{{-- ── HEADER ── --}}
<div class="detail-header fade-up">
    <a href="{{ route('admin.csat.index') }}" class="back-btn">
        <i class="fa-solid fa-arrow-left text-xs"></i> Back to Dashboard
    </a>
    <h1 class="detail-title">CSAT Response<br><em style="color:var(--gold);">Detail View</em></h1>
    <div class="flex flex-wrap gap-2 mt-3">
        <span class="info-chip"><i class="fa-solid fa-hospital text-xs"></i> {{ $r->hospital_name ?? '—' }}</span>
        <span class="info-chip"><i class="fa-solid fa-user-gear text-xs"></i> {{ $r->service_engineer ?? '—' }}</span>
        <span class="info-chip"><i class="fa-solid fa-calendar text-xs"></i> {{ $r->submitted_at?->format('M d, Y g:i A') }}</span>
        @if($r->serviceRecord?->machine)
        <span class="info-chip"><i class="fa-solid fa-microchip text-xs"></i> {{ $r->serviceRecord->machine->name ?? '' }}</span>
        @endif
    </div>
</div>

<div class="p-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT COLUMN: Score summary + engineer contact --}}
        <div class="space-y-5">

            {{-- Overall score card --}}
            <div class="detail-card fade-up d1">
                <div class="detail-card-header">
                    <i class="fa-solid fa-star"></i>
                    <span>Overall Score</span>
                </div>
                <div class="big-score">
                    <div class="big-score-value">{{ number_format($score, 2) }}</div>
                    <div class="big-score-label">Average out of 5.00</div>
                    <div>
                        <span class="score-pill {{ $scoreClass }}">
                            <i class="fa-solid fa-circle-check text-xs"></i> {{ $scoreLabel }}
                        </span>
                    </div>

                    {{-- Mini gauge --}}
                    @php $deg = ($score / 5) * 180; @endphp
                    <div class="gauge-wrap">
                        <svg class="gauge-svg" viewBox="0 0 120 60">
                            <path d="M10,60 A50,50 0 0,1 110,60" fill="none" stroke="#EEF0F4" stroke-width="10" stroke-linecap="round"/>
                            <path d="M10,60 A50,50 0 0,1 110,60" fill="none" stroke="#C9A84C"
                                  stroke-width="10" stroke-linecap="round"
                                  stroke-dasharray="{{ ($deg / 180) * 157 }}, 157"/>
                        </svg>
                    </div>

                    {{-- Overall + Recommend --}}
                    <div class="flex justify-center gap-6 mt-2">
                        <div class="text-center">
                            <div class="text-xs text-slate-400 uppercase tracking-wide">Overall</div>
                            <div class="font-semibold text-[#0B1F3A]">{{ $r->overall_satisfaction }}/5</div>
                        </div>
                        <div class="w-px bg-gray-200"></div>
                        <div class="text-center">
                            <div class="text-xs text-slate-400 uppercase tracking-wide">Recommend</div>
                            <div class="font-semibold text-[#0B1F3A]">{{ $r->overall_recommend }}/5</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Service details --}}
            <div class="detail-card fade-up d2">
                <div class="detail-card-header">
                    <i class="fa-solid fa-file-medical"></i>
                    <span>Service Details</span>
                </div>
                <div class="detail-card-body">
                    <div class="contact-row">
                        <i class="fa-solid fa-hospital"></i>
                        <div>
                            <div class="text-xs text-slate-400">Hospital / Client</div>
                            <div class="font-medium">{{ $r->hospital_name ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="contact-row">
                        <i class="fa-solid fa-user-gear"></i>
                        <div>
                            <div class="text-xs text-slate-400">Service Engineer</div>
                            <div class="font-medium">{{ $r->service_engineer ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="contact-row">
                        <i class="fa-solid fa-calendar"></i>
                        <div>
                            <div class="text-xs text-slate-400">Service Date</div>
                            <div class="font-medium">{{ $r->serviceRecord?->formatted_service_date ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="contact-row">
                        <i class="fa-solid fa-microchip"></i>
                        <div>
                            <div class="text-xs text-slate-400">Machine</div>
                            <div class="font-medium">{{ $r->serviceRecord?->machine?->name ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="contact-row">
                        <i class="fa-solid fa-wrench"></i>
                        <div>
                            <div class="text-xs text-slate-400">Service Type</div>
                            <div class="font-medium">{{ $r->serviceRecord?->service_type_display ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="contact-row">
                        <i class="fa-solid fa-clock"></i>
                        <div>
                            <div class="text-xs text-slate-400">Survey Submitted</div>
                            <div class="font-medium">{{ $r->submitted_at?->format('M d, Y g:i A') ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Follow-up contact --}}
            @if($r->contact_consent)
            <div class="detail-card fade-up d3 border-l-4 border-[#C9A84C]">
                <div class="detail-card-header">
                    <i class="fa-solid fa-phone"></i>
                    <span>Follow-up Contact</span>
                    <span class="ml-auto text-[10px] bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-semibold">Requested</span>
                </div>
                <div class="detail-card-body">
                    <div class="contact-row">
                        <i class="fa-solid fa-user"></i>
                        <div>
                            <div class="text-xs text-slate-400">Name</div>
                            <div class="font-medium">{{ $r->contact_name ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="contact-row">
                        <i class="fa-solid fa-envelope"></i>
                        <div>
                            <div class="text-xs text-slate-400">Contact / Email</div>
                            <div class="font-medium">{{ $r->contact_info ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="detail-card fade-up d3">
                <div class="detail-card-header">
                    <i class="fa-solid fa-phone-slash" style="color:#94A3B8;"></i>
                    <span>Follow-up Contact</span>
                    <span class="ml-auto text-[10px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full font-semibold">Declined</span>
                </div>
                <div class="detail-card-body text-sm text-slate-400 italic">
                    Client did not request a follow-up.
                </div>
            </div>
            @endif

        </div>

        {{-- RIGHT COLUMN: Performance ratings + feedback --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Performance breakdown --}}
            <div class="detail-card fade-up d2">
                <div class="detail-card-header">
                    <i class="fa-solid fa-chart-bar"></i>
                    <span>Performance Breakdown</span>
                </div>
                <div class="detail-card-body">
                    @foreach($perfItems as $i => $item)
                    @php $val = $r->{$item['key']}; @endphp
                    @if($val !== null)
                    <div class="score-row">
                        <div class="score-row-label">
                            <span class="score-row-num">{{ $i + 1 }}</span>
                            {{ $item['label'] }}
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="score-row-stars">
                                @for($s = 1; $s <= 5; $s++)
                                    <span class="{{ $s <= $val ? 'star-on' : 'star-off' }}">★</span>
                                @endfor
                            </div>
                            <span class="text-sm font-semibold text-[#0B1F3A] w-8 text-right">{{ $val }}/5</span>
                        </div>
                    </div>
                    @else
                    <div class="score-row opacity-40">
                        <div class="score-row-label">
                            <span class="score-row-num">{{ $i + 1 }}</span>
                            {{ $item['label'] }}
                        </div>
                        <span class="text-xs text-slate-400 italic">N/A</span>
                    </div>
                    @endif
                    @endforeach

                    {{-- Divider --}}
                    <div class="mt-3 pt-3 border-t border-dashed border-[#C9A84C]/30">
                        <div class="score-row">
                            <div class="score-row-label font-semibold">
                                <span class="score-row-num" style="background:var(--gold);">★</span>
                                Overall Satisfaction
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="score-row-stars">
                                    @for($s = 1; $s <= 5; $s++)
                                        <span class="{{ $s <= $r->overall_satisfaction ? 'star-on' : 'star-off' }}">★</span>
                                    @endfor
                                </div>
                                <span class="text-sm font-semibold text-[#0B1F3A] w-8 text-right">{{ $r->overall_satisfaction }}/5</span>
                            </div>
                        </div>
                        <div class="score-row">
                            <div class="score-row-label font-semibold">
                                <span class="score-row-num" style="background:var(--gold);">↗</span>
                                Likelihood to Recommend
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="score-row-stars">
                                    @for($s = 1; $s <= 5; $s++)
                                        <span class="{{ $s <= $r->overall_recommend ? 'star-on' : 'star-off' }}">★</span>
                                    @endfor
                                </div>
                                <span class="text-sm font-semibold text-[#0B1F3A] w-8 text-right">{{ $r->overall_recommend }}/5</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Feedback --}}
            @if($r->feedback_positive || $r->feedback_improve)
            <div class="detail-card fade-up d3">
                <div class="detail-card-header">
                    <i class="fa-solid fa-comments"></i>
                    <span>Client Feedback</span>
                </div>
                <div class="detail-card-body space-y-4">

                    @if($r->feedback_positive)
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fa-solid fa-thumbs-up text-green-600 text-[9px]"></i>
                            </span>
                            <span class="text-xs font-semibold text-green-700 uppercase tracking-wide">What we did well</span>
                        </div>
                        <div class="feedback-box">
                            <p>{{ $r->feedback_positive }}</p>
                        </div>
                    </div>
                    @endif

                    @if($r->feedback_improve)
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-5 h-5 rounded-full bg-amber-100 flex items-center justify-center">
                                <i class="fa-solid fa-lightbulb text-amber-600 text-[9px]"></i>
                            </span>
                            <span class="text-xs font-semibold text-amber-700 uppercase tracking-wide">Areas to improve</span>
                        </div>
                        <div class="feedback-box">
                            <p>{{ $r->feedback_improve }}</p>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
            @else
            <div class="detail-card fade-up d3">
                <div class="detail-card-header">
                    <i class="fa-solid fa-comments" style="color:#94A3B8;"></i>
                    <span>Client Feedback</span>
                </div>
                <div class="detail-card-body text-sm text-slate-400 italic text-center py-4">
                    No written feedback was provided.
                </div>
            </div>
            @endif

            {{-- Action buttons --}}
            <div class="fade-up d4 flex gap-3 flex-wrap">
                <a href="{{ route('admin.csat.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl
                          bg-white border border-gray-200 text-[#0B1F3A] text-sm font-semibold
                          hover:bg-gray-50 transition-all shadow-sm">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Back to Dashboard
                </a>

                @if($r->serviceRecord)
                <a href="{{ route('client.service.details', $r->service_record_id) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl
                          bg-gradient-to-br from-[#0B1F3A] to-[#1D3A5A]
                          text-white text-sm font-semibold border border-[#C9A84C]/25
                          hover:opacity-90 transition-all shadow-sm" target="_blank">
                    <i class="fa-solid fa-file-medical text-xs"></i> View Service Report
                </a>
                @endif
            </div>

        </div>
    </div>
</div>

@endsection