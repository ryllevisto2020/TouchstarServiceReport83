

@extends('layouts.client')  

@section('title', 'Service Satisfaction Survey')

@section('content')

{{-- Trigger: auto-opens the modal on page load --}}
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="text-center">
        <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-[#0B1F3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                         M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2
                         m-6 9l2 2 4-4"/>
            </svg>
        </div>
        <p class="text-gray-500 text-sm">Loading survey…</p>
    </div>
</div>

{{-- ================================================================
     CSAT MODAL
     ================================================================ --}}
<div
    id="csatModal"
    class="fixed inset-0 z-[999] flex items-center justify-center p-4"
    style="display: none !important;"
>
    {{-- Backdrop --}}
    <div
        id="csatBackdrop"
        class="absolute inset-0 bg-[#0B1F3A]/70 backdrop-blur-sm"
        onclick="closeCsatModal()"
    ></div>

    {{-- Card --}}
    <div
        id="csatCard"
        class="relative w-full max-w-3xl max-h-[92vh] overflow-y-auto rounded-3xl bg-white
               shadow-[0_32px_64px_-12px_rgba(11,31,58,0.45),0_0_0_1px_rgba(201,168,76,0.2)]
               scroll-smooth"
        style="scrollbar-width: thin; scrollbar-color: #C9A84C #F0F4FA;"
    >

        {{-- ── HEADER ── --}}
       <div class="relative overflow-hidden rounded-t-3xl bg-gradient-to-br from-[#1565c0] to-[#0d47a1] px-8 py-7 border-b-[3px] border-[#C9A84C]">

        <!-- decorative circle -->
        <div class="pointer-events-none absolute -top-16 -right-12 w-72 h-72 rounded-full bg-[#C9A84C]/10"></div>

        <!-- top bar -->
        <div class="flex items-start justify-between relative z-10">

            <!-- logo + badge -->
            <div class="flex items-start gap-4">

                <!-- Logo -->
                <img src="{{ asset('images/logo1.png') }}"
                    alt="Touchstar Logo"
                    class="h-20 w-auto object-contain drop-shadow-md">

                <div>
                    <span class="inline-flex items-center gap-1.5 mb-2
                                bg-[#C9A84C]/20 border border-[#C9A84C]/40
                                text-[#F3E6B2] text-[10px] font-semibold
                                tracking-[0.14em] uppercase px-3 py-1 rounded-full">

                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0
                                    1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755
                                    1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197
                                    -1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588
                                    -1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>

                        Technical Services Division
                    </span>

                    <!-- title -->
                    <h2 class="font-serif text-[1.8rem] font-bold text-white leading-tight tracking-tight"
                        style="font-family:'Georgia',serif;">
                        Post-Service Customer<br>Satisfaction Survey
                    </h2>

                    <!-- subtitle -->
                    <p class="text-white/70 text-sm max-w-lg mt-2 leading-relaxed">
                        We appreciate your partnership. Your insight helps us refine our medical service
                        excellence — it takes less than 2 minutes.
                    </p>
                </div>
            </div>

            <!-- close -->
            <button
                onclick="closeCsatModal()"
                class="flex items-center justify-center w-9 h-9 rounded-full
                      bg-white/10 border border-white/20 text-white text-xl
                      hover:bg-[#C9A84C] hover:text-[#0B1F3A] hover:border-[#C9A84C]
                      transition-all duration-200 hover:rotate-90"
                aria-label="Close">
                ✕
            </button>

        </div>

        <!-- service info chips -->
        <div class="flex flex-wrap gap-2 mt-5 relative z-10">

            <span class="inline-flex items-center gap-1.5 bg-white/10 border border-white/20 text-white/80 text-xs px-3 py-1 rounded-full">
                <svg class="w-3 h-3 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                </svg>
                {{ $hospital->client_name }}
            </span>

            <span class="inline-flex items-center gap-1.5 bg-white/10 border border-white/20 text-white/80 text-xs px-3 py-1 rounded-full">
                <svg class="w-3 h-3 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                {{ $serviceRecord->service_engineer ?? 'N/A' }}
            </span>

            <span class="inline-flex items-center gap-1.5 bg-white/10 border border-white/20 text-white/80 text-xs px-3 py-1 rounded-full">
                <svg class="w-3 h-3 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $serviceRecord->formatted_service_date ?? 'N/A' }}
            </span>

        </div>

    </div>

        {{-- ── BODY ── --}}
        <div class="px-8 py-7">

            <form id="csatForm" novalidate>
                @csrf

                {{-- Rating scale legend --}}
                <div class="flex flex-wrap gap-x-4 gap-y-1.5 mb-6 bg-[#F4F6FA] px-5 py-3 rounded-2xl text-[11px] text-[#5E6F88]">
                    @foreach(['★ Very dissatisfied','★★ Dissatisfied','★★★ Neutral','★★★★ Satisfied','★★★★★ Very satisfied'] as $legend)
                    <span class="flex items-center gap-1">
                        <span class="text-[#C9A84C] text-sm">{{ Str::before($legend, ' ') }}</span>
                        {{ Str::after($legend, ' ') }}
                    </span>
                    @endforeach
                </div>

                {{-- ── Performance Ratings ── --}}
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-[10px] font-semibold tracking-[0.16em] text-yellow-500 uppercase">Service Performance Evaluation</span>
                    <div class="flex-1 h-px bg-gradient-to-r from-[#C9A84C]/40 to-transparent"></div>
                </div>

                <div class="rounded-2xl border border-gray-100 overflow-hidden divide-y divide-gray-50 mb-6">
                    @php
                    $perfItems = [
                        ['name' => 'perf1', 'label' => 'Service team responded promptly Response within SLA', 'sub' => 'promptness', 'required' => true],
                        ['name' => 'perf2', 'label' => 'Issue was resolved correctly during first visit', 'required' => true],
                        ['name' => 'perf3', 'label' => 'Service engineer/IT Staff was professional and courteous', 'required' => true],
                        ['name' => 'perf4', 'label' => 'Service engineer/IT Staff demonstrated strong technical knowledge', 'required' => true],
                        ['name' => 'perf5', 'label' => 'Preventive maintenance was performed thoroughly', 'sub' => 'if applicable', 'required' => false],
                        ['name' => 'perf6', 'label' => 'Findings and recommendations were clearly explained', 'required' => true],
                        ['name' => 'perf7', 'label' => 'Service report/documentation was accurate and complete', 'required' => true],
                    ];
                    @endphp

                    @foreach($perfItems as $i => $item)
                    <div class="flex items-center justify-between flex-wrap gap-3 px-5 py-4 hover:bg-amber-50/40 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="flex-shrink-0 w-7 h-7 rounded-full bg-[#1565c0] text-white text-[11px] font-bold flex items-center justify-center">
                                {{ $i + 1 }}
                            </span>
                            <span class="text-sm font-medium text-[#1F2A3F]">
                                {{ $item['label'] }}
                                @isset($item['sub'])
                                <em class="text-[#8A9BB0] font-normal text-xs ml-1 not-italic">({{ $item['sub'] }})</em>
                                @endisset
                            </span>
                        </div>
                        <div class="star-rating" data-name="{{ $item['name'] }}" data-required="{{ $item['required'] ? 'true' : 'false' }}">
                            @for($s = 5; $s >= 1; $s--)
                            <input type="radio" name="{{ $item['name'] }}" id="{{ $item['name'] }}-{{ $s }}" value="{{ $s }}"
                                   {{ $item['required'] && $s === 5 ? '' : '' }}>
                            <label for="{{ $item['name'] }}-{{ $s }}" title="{{ $s }} star">
                                <svg viewBox="0 0 24 24" class="star-svg">
                                    <path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"/>
                                </svg>
                            </label>
                            @endfor
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- ── Overall Scores ── --}}
                <div class="rounded-2xl bg-[#F9F9FC] border border-[#C9A84C]/25 px-6 py-4 mb-6 divide-y divide-[#C9A84C]/15 space-y-0">
                    @php
                    $overallItems = [
                        ['name' => 'overall1', 'label' => 'Overall satisfaction with the service'],
                        ['name' => 'overall2', 'label' => 'Likelihood to recommend our service'],
                    ];
                    @endphp
                    @foreach($overallItems as $item)
                    <div class="flex items-center justify-between flex-wrap gap-3 py-3">
                        <span class="text-sm font-semibold text-[#1F2A3F]">{{ $item['label'] }}</span>
                        <div class="star-rating" data-name="{{ $item['name'] }}" data-required="true">
                            @for($s = 5; $s >= 1; $s--)
                            <input type="radio" name="{{ $item['name'] }}" id="{{ $item['name'] }}-{{ $s }}" value="{{ $s }}">
                            <label for="{{ $item['name'] }}-{{ $s }}" title="{{ $s }} star">
                                <svg viewBox="0 0 24 24" class="star-svg">
                                    <path pathLength="360" d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"/>
                                </svg>
                            </label>
                            @endfor
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- ── Open feedback ── --}}
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-[10px] font-semibold tracking-[0.16em] text-[#C9A84C] uppercase">Your Voice</span>
                    <div class="flex-1 h-px bg-gradient-to-r from-[#C9A84C]/40 to-transparent"></div>
                </div>

                <div class="grid gap-4 mb-6">
                    <div>
                        <label class="block text-[11px] font-semibold text-[#2D3A4A] uppercase tracking-wide mb-1.5">
                            What did we do well?
                            <span class="ml-2 text-[10px] bg-[#C9A84C]/10 border border-[#C9A84C]/30 text-[#9A7D34] px-2 py-0.5 rounded-full normal-case tracking-normal font-medium">Optional</span>
                        </label>
                        <textarea name="did_well" rows="3" placeholder="Share a highlight…"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-[#0B1F3A]
                                   placeholder:text-gray-400 focus:outline-none focus:border-[#C9A84C] focus:bg-white
                                   transition-colors resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#2D3A4A] uppercase tracking-wide mb-1.5">
                            What can we improve?
                            <span class="ml-2 text-[10px] bg-[#C9A84C]/10 border border-[#C9A84C]/30 text-[#9A7D34] px-2 py-0.5 rounded-full normal-case tracking-normal font-medium">Optional</span>
                        </label>
                        <textarea name="improve" rows="3" placeholder="Constructive feedback…"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-[#0B1F3A]
                                   placeholder:text-gray-400 focus:outline-none focus:border-[#C9A84C] focus:bg-white
                                   transition-colors resize-none"></textarea>
                    </div>
                </div>

                {{-- ── Follow-up contact ── --}}
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-[11px] font-semibold text-[#2D3A4A] uppercase tracking-wide">May we contact you regarding your feedback?</span>
                    </div>
                    <div class="flex gap-3 flex-wrap">
                        <label class="contact-pill">
                            <input type="radio" name="contact" value="yes" id="contactYes"> Yes
                        </label>
                        <label class="contact-pill contact-pill-active">
                            <input type="radio" name="contact" value="no" id="contactNo" checked> No
                        </label>
                    </div>
                    <div id="contactFields" class="hidden grid-cols-2 gap-3 mt-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-[#2D3A4A] uppercase tracking-wide mb-1">Name</label>
                            <input type="text" name="contact_name" placeholder="Your name"
                                   class="w-full border-b border-[#1565c0] bg-transparent pb-1.5 text-sm text-[#0B1F3A]
                                          focus:outline-none focus:border-[#1565c0] transition-colors placeholder:text-gray-400">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-[#2D3A4A] uppercase tracking-wide mb-1">Contact / email</label>
                            <input type="text" name="contact_info" placeholder="Phone or email"
                                   class="w-full border-b border-[#1565c0] bg-transparent pb-1.5 text-sm text-[#0B1F3A]
                                          focus:outline-none focus:border-[#1565c0] transition-colors placeholder:text-gray-400">
                        </div>
                    </div>
                </div>

               {{-- Validation error message --}}
                <div id="csatError"
                     class="hidden flex items-center gap-2 text-sm text-red-700 bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-4">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span id="csatErrorMsg">Please rate all required fields before submitting.</span>
                </div>

                {{-- ── Submit bar ── --}}
                <div class="flex items-center justify-between gap-4 pt-5 border-t border-[#1565c0] flex-wrap">
                    <p class="text-xs text-[#7A8A9F] flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Confidential — used only for quality improvement
                    </p>
                    <button
                        type="submit"
                        id="csatSubmitBtn"
                        class="inline-flex items-center gap-2 px-7 py-2.5 rounded-full
                               bg-gradient-to-br from-[#1565c0] to-[#1565c0] text-white
                               text-sm font-bold tracking-widest uppercase
                               border border-[#1565c0]/25 shadow-lg shadow-[#1565c0]/30
                               hover:translate-y-[-2px] hover:shadow-xl hover:shadow-[#1565c0]/40
                               active:translate-y-0 transition-all duration-200 focus:outline-none"
                    >
                        Submit Survey
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </button>
                </div>

                {{-- Success message --}}
                <div id="csatSuccess"
                     class="hidden items-center gap-3 mt-4 bg-green-50 border border-green-200 text-green-800
                            px-5 py-3.5 rounded-2xl text-sm font-medium">
                    <span class="flex-shrink-0 w-7 h-7 rounded-full bg-[#0B1F3A] text-[#C9A84C] flex items-center justify-center font-bold text-base">✓</span>
                    Thank you! Your feedback has been recorded successfully.
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* ── Star Rating Component ── */
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    gap: 0.2rem;
    --clr-stroke: #8A9BB0;
    --clr-gold: #C9A84C;
}

.star-rating input { display: none; }

.star-rating label { cursor: pointer; line-height: 1; display: inline-flex; }

.star-svg {
    width: 1.75rem;
    height: 1.75rem;
    overflow: visible;
    fill: transparent;
    stroke: var(--clr-stroke);
    stroke-linejoin: bevel;
    stroke-dasharray: 12;
    animation: starIdle 4s linear infinite;
    transition: stroke 0.2s, fill 0.4s cubic-bezier(0.2, 0.9, 0.3, 1.2);
}

@keyframes starIdle { from { stroke-dashoffset: 24; } }

.star-rating label:hover .star-svg {
    stroke: var(--clr-gold);
}

.star-rating input:checked ~ label .star-svg {
    transition: none;
    animation: starIdle 4s linear infinite, starPop 0.55s cubic-bezier(0.2, 0.8, 0.4, 1.2) forwards;
    fill: var(--clr-gold);
    stroke: var(--clr-gold);
    stroke-opacity: 0;
    stroke-dasharray: 0;
    stroke-linejoin: miter;
    stroke-width: 8px;
}

@keyframes starPop {
    0%    { transform: scale(1);   fill: var(--clr-gold); fill-opacity: 0;   stroke-opacity: 1; stroke: var(--clr-stroke); stroke-dasharray: 10; stroke-width: 1px; stroke-linejoin: bevel; }
    30%   { transform: scale(0.7); fill: var(--clr-gold); fill-opacity: 0.2; stroke-opacity: 1; stroke: var(--clr-stroke); stroke-dasharray: 8;  stroke-width: 1.2px; stroke-linejoin: bevel; }
    30.1% { stroke: var(--clr-gold); stroke-dasharray: 0; stroke-linejoin: miter; stroke-width: 8px; fill-opacity: 0.2; }
    60%   { transform: scale(1.2); fill: var(--clr-gold); fill-opacity: 1; stroke-opacity: 0; }
    100%  { transform: scale(1);   fill: var(--clr-gold); stroke-opacity: 0; }
}

/* Contact pills */
.contact-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.45rem 1.6rem;
    border-radius: 999px;
    border: 1.5px solid #CBD5E0;
    font-size: 0.85rem;
    font-weight: 600;
    color: #2D4059;
    background: white;
    cursor: pointer;
    transition: all 0.15s;
}
.contact-pill:has(input:checked) {
    background: #0B1F3A;
    border-color: #0B1F3A;
    color: white;
}

/* Modal entrance */
#csatCard {
    animation: csatEnter 0.38s cubic-bezier(0.15, 0.85, 0.3, 1) both;
}
@keyframes csatEnter {
    from { opacity: 0; transform: scale(0.96) translateY(18px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}

/* Custom scrollbar inside card */
#csatCard::-webkit-scrollbar       { width: 5px; }
#csatCard::-webkit-scrollbar-track { background: #F0F4FA; border-radius: 8px; }
#csatCard::-webkit-scrollbar-thumb { background: #C9A84C; border-radius: 8px; }
</style>
@endpush

@push('scripts')
<script>
(function () {
    const SUBMIT_URL = "{{ route('client.csat.store', $serviceRecord) }}";
    const CSRF       = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    // ── Open / close modal ──────────────────────────────────────────────
    function openCsatModal() {
        const modal = document.getElementById('csatModal');
        modal.style.removeProperty('display');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeCsatModal() {
        const modal = document.getElementById('csatModal');
        modal.style.display = 'none';
        document.body.style.overflow = '';
        // redirect back to pending list
        window.location.href = "{{ route('client.landing') }}";
    }

    window.closeCsatModal = closeCsatModal;

    // Auto-open on page load
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(openCsatModal, 150);

        // Contact toggle
        document.querySelectorAll('input[name="contact"]').forEach(r => {
            r.addEventListener('change', e => {
                const fields = document.getElementById('contactFields');
                if (e.target.value === 'yes') {
                    fields.classList.remove('hidden');
                    fields.classList.add('grid');
                } else {
                    fields.classList.add('hidden');
                    fields.classList.remove('grid');
                }
            });
        });
    });

    // ── Form submission ─────────────────────────────────────────────────
    document.getElementById('csatForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        // Validate required star ratings
        const required = ['perf1','perf2','perf3','perf4','perf6','perf7','overall1','overall2'];
        const missing  = required.filter(name => !document.querySelector(`input[name="${name}"]:checked`));

        if (missing.length) {
            showError('Please complete all required star ratings before submitting.');
            return;
        }

        hideError();

        const btn = document.getElementById('csatSubmitBtn');
        btn.disabled = true;
        btn.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            Submitting…
        `;

        const payload = new FormData(this);

        try {
            const res = await fetch(SUBMIT_URL, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                body: payload,
            });

            const data = await res.json();

            if (res.ok) {
                showSuccess();
                btn.style.display = 'none';
                // Close & redirect after 2.5s
                setTimeout(() => {
                    closeCsatModal();
                }, 2500);
            } else {
                showError(data.message ?? 'Something went wrong. Please try again.');
                resetBtn(btn);
            }
        } catch (err) {
            showError('Network error. Please check your connection and try again.');
            resetBtn(btn);
        }
    });

    function resetBtn(btn) {
        btn.disabled = false;
        btn.innerHTML = `Submit Survey <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>`;
    }

    function showError(msg) {
        const el = document.getElementById('csatError');
        document.getElementById('csatErrorMsg').textContent = msg;
        el.classList.remove('hidden');
        el.classList.add('flex');
        el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function hideError() {
        const el = document.getElementById('csatError');
        el.classList.add('hidden');
        el.classList.remove('flex');
    }

    function showSuccess() {
        const el = document.getElementById('csatSuccess');
        el.classList.remove('hidden');
        el.classList.add('flex');
    }
})();
</script>
@endpush