@extends('layouts.client')

@section('title', 'Touchstar Medical Enterprises Inc. Client Management')

@section('content')
 <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 max-w-full">
  <div class="flex w-full bg-gray-100 max-w-full">
    <div class="ml-0 lg:ml-56 flex-1 p-4 sm:p-6 lg:p-8 w-full max-w-full">
      {{-- Top Bar --}}
      <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6">
        <div class="w-full">
          <h1 class="serif text-xl sm:text-2xl text-gray-900 font-normal">
            Touchstar Medical Enterprises Inc. Good Day! {{ $clientName ?? 'Guest' }} 👋
          </h1>
          <p class="text-xs sm:text-sm text-gray-400 mt-0.5">
            {{ $currentDate ?? now()->format('l, F d, Y') }} · Here's what's happening today
          </p>
        </div>
      </div>

      {{-- Stats Grid --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 max-w-full">
        <div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-5">
          <p class="text-[11px] uppercase tracking-wider text-gray-400 mb-2">Total clients</p>
          <p class="serif text-2xl sm:text-3xl text-gray-900 font-normal leading-none mb-1">1,248</p>
          <p class="text-xs text-emerald-600">↑ 12 new this month</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-5">
          <p class="text-[11px] uppercase tracking-wider text-gray-400 mb-2">Today's appointments</p>
          <p class="serif text-2xl sm:text-3xl text-gray-900 font-normal leading-none mb-1">4</p>
          <p class="text-xs text-gray-400">2 completed · 2 remaining</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-5">
          <p class="text-[11px] uppercase tracking-wider text-gray-400 mb-2">Pending follow-ups</p>
          <p class="serif text-2xl sm:text-3xl text-gray-900 font-normal leading-none mb-1">17</p>
          <p class="text-xs text-orange-500">↑ 3 since last week</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-5">
          <p class="text-[11px] uppercase tracking-wider text-gray-400 mb-2">Unpaid invoices</p>
          <p class="serif text-2xl sm:text-3xl text-gray-900 font-normal leading-none mb-1">₱38k</p>
          <p class="text-xs text-gray-400">6 invoices outstanding</p>
        </div>
      </div>

      {{-- Two Column Row --}}
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        {{-- Today's Appointments --}}
        <div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-5">
          <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-medium text-gray-900">Today's appointments</p>
            <span class="text-xs text-gray-400">May 13</span>
          </div>
          <div class="divide-y divide-gray-50">
            @forelse($appointments ?? [] as $appointment)
              <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 py-3">
                <span class="text-xs font-medium text-gray-400 sm:w-14">{{ $appointment['time'] }}</span>
                <div class="flex-1">
                  <p class="text-sm font-medium text-gray-800">{{ $appointment['name'] }}</p>
                  <p class="text-xs text-gray-400">{{ $appointment['type'] }}</p>
                </div>
                <span class="text-xs font-medium px-2.5 py-0.5 rounded-full inline-block w-fit
                  @if($appointment['status'] === 'Confirmed') bg-emerald-50 text-emerald-700
                  @elseif($appointment['status'] === 'Pending') bg-amber-50 text-amber-700
                  @else bg-blue-50 text-blue-700
                  @endif">
                  {{ $appointment['status'] }}
                </span>
              </div>
            @empty
              <div class="flex items-center gap-3 py-3">
                <span class="text-xs font-medium text-gray-400 w-14">9:00 AM</span>
                <div class="flex-1">
                  <p class="text-sm font-medium text-gray-800">Maria Santos</p>
                  <p class="text-xs text-gray-400">General Check-up</p>
                </div>
                <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-2.5 py-0.5 rounded-full">Confirmed</span>
              </div>
              <div class="flex items-center gap-3 py-3">
                <span class="text-xs font-medium text-gray-400 w-14">10:30 AM</span>
                <div class="flex-1">
                  <p class="text-sm font-medium text-gray-800">Jose dela Cruz</p>
                  <p class="text-xs text-gray-400">Follow-up · Hypertension</p>
                </div>
                <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-2.5 py-0.5 rounded-full">Confirmed</span>
              </div>
              <div class="flex items-center gap-3 py-3">
                <span class="text-xs font-medium text-gray-400 w-14">1:00 PM</span>
                <div class="flex-1">
                  <p class="text-sm font-medium text-gray-800">Ana Reyes</p>
                  <p class="text-xs text-gray-400">Lab Results Review</p>
                </div>
                <span class="text-xs font-medium bg-amber-50 text-amber-700 px-2.5 py-0.5 rounded-full">Pending</span>
              </div>
              <div class="flex items-center gap-3 py-3">
                <span class="text-xs font-medium text-gray-400 w-14">3:30 PM</span>
                <div class="flex-1">
                  <p class="text-sm font-medium text-gray-800">Ramon Bautista</p>
                  <p class="text-xs text-gray-400">New Patient Consult</p>
                </div>
                <span class="text-xs font-medium bg-blue-50 text-blue-700 px-2.5 py-0.5 rounded-full">New client</span>
              </div>
            @endforelse
          </div>
        </div>

        {{-- Recent Clients --}}
        <div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-5">
          <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-medium text-gray-900">Recent clients</p>
            <a href="#" class="text-xs text-emerald-600 hover:underline">View all →</a>
          </div>
          <div class="divide-y divide-gray-50">
            <div class="flex items-center gap-3 py-3">
              <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-xs font-medium text-emerald-700 flex-shrink-0">MS</div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-800 truncate">Maria Santos</p>
                <p class="text-xs text-gray-400">Last visit: May 10, 2026</p>
              </div>
              <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-2.5 py-0.5 rounded-full flex-shrink-0">Active</span>
            </div>
            <div class="flex items-center gap-3 py-3">
              <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-xs font-medium text-blue-700 flex-shrink-0">JD</div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-800 truncate">Jose dela Cruz</p>
                <p class="text-xs text-gray-400">Last visit: May 8, 2026</p>
              </div>
              <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-2.5 py-0.5 rounded-full flex-shrink-0">Active</span>
            </div>
            <div class="flex items-center gap-3 py-3">
              <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center text-xs font-medium text-purple-700 flex-shrink-0">AR</div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-800 truncate">Ana Reyes</p>
                <p class="text-xs text-gray-400">Last visit: Apr 28, 2026</p>
              </div>
              <span class="text-xs font-medium bg-amber-50 text-amber-700 px-2.5 py-0.5 rounded-full flex-shrink-0">Follow-up</span>
            </div>
            <div class="flex items-center gap-3 py-3">
              <div class="w-8 h-8 rounded-full bg-orange-50 flex items-center justify-center text-xs font-medium text-orange-700 flex-shrink-0">RB</div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-800 truncate">Ramon Bautista</p>
                <p class="text-xs text-gray-400">New patient</p>
              </div>
              <span class="text-xs font-medium bg-blue-50 text-blue-700 px-2.5 py-0.5 rounded-full flex-shrink-0">New</span>
            </div>
          </div>
        </div>
      </div>

      {{-- Bottom Row --}}
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Health Overview --}}
        <div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-5">
          <p class="text-sm font-medium text-gray-900 mb-4">Client health overview</p>
          <div class="space-y-3">
            <div class="flex items-center gap-3 text-xs">
              <span class="w-24 text-gray-500 flex-shrink-0">Hypertension</span>
              <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-emerald-500 rounded-full transition-all duration-300" style="width: 62%"></div>
              </div>
              <span class="text-gray-400 w-8 text-right flex-shrink-0">62%</span>
            </div>
            <div class="flex items-center gap-3 text-xs">
              <span class="w-24 text-gray-500 flex-shrink-0">Diabetes</span>
              <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-blue-400 rounded-full transition-all duration-300" style="width: 38%"></div>
              </div>
              <span class="text-gray-400 w-8 text-right flex-shrink-0">38%</span>
            </div>
            <div class="flex items-center gap-3 text-xs">
              <span class="w-24 text-gray-500 flex-shrink-0">Respiratory</span>
              <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-violet-400 rounded-full transition-all duration-300" style="width: 22%"></div>
              </div>
              <span class="text-gray-400 w-8 text-right flex-shrink-0">22%</span>
            </div>
            <div class="flex items-center gap-3 text-xs">
              <span class="w-24 text-gray-500 flex-shrink-0">Cardiac</span>
              <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-red-400 rounded-full transition-all duration-300" style="width: 15%"></div>
              </div>
              <span class="text-gray-400 w-8 text-right flex-shrink-0">15%</span>
            </div>
            <div class="flex items-center gap-3 text-xs">
              <span class="w-24 text-gray-500 flex-shrink-0">Other</span>
              <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-gray-400 rounded-full transition-all duration-300" style="width: 41%"></div>
              </div>
              <span class="text-gray-400 w-8 text-right flex-shrink-0">41%</span>
            </div>
          </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-5">
          <p class="text-sm font-medium text-gray-900 mb-4">Quick actions</p>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
            <a href="#" class="flex items-center gap-2.5 border border-gray-200 rounded-lg px-3.5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
              </svg>
              <span class="truncate">Add client</span>
            </a>
            <a href="#" class="flex items-center gap-2.5 border border-gray-200 rounded-lg px-3.5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              <span class="truncate">New appointment</span>
            </a>
            <a href="#" class="flex items-center gap-2.5 border border-gray-200 rounded-lg px-3.5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
              </svg>
              <span class="truncate">Create invoice</span>
            </a>
            <a href="#" class="flex items-center gap-2.5 border border-gray-200 rounded-lg px-3.5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-violet-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
              </svg>
              <span class="truncate">View reports</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  </main>
@endsection