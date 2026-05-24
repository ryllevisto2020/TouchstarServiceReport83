@extends('layouts.client')

@section('title', 'Touchstar Medical Enterprises Inc. Client Management')

@section('content')
<div class="w-full">
  {{-- Top Bar --}}
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6">
    <div class="w-full">
      <h1 class="serif text-xl sm:text-2xl text-gray-900 font-normal">
        Touchstar Medical Enterprises Inc. Client Dashboard
      </h1>
      <p class="text-xs sm:text-sm text-gray-400 mt-0.5">
        {{ $currentDate ?? now()->format('l, F d, Y') }} · Here's what's happening today
      </p>
    </div>
  </div>

  {{-- Stats Grid --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      
      <div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-5">
        <p class="text-[11px] uppercase tracking-wider text-gray-400 mb-2">
          Welcome
        </p>
       <p class="serif text-2xl sm:text-3xl text-gray-900 font-normal leading-none mb-1">
            Hello, {{ $client_detail->client_name ?? 'Client' }} 👋
        </p>
        <p class="text-xs text-gray-500">
          We're glad to have you here today.
        </p>
      </div>

      <div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-5">
        <p class="text-[11px] uppercase tracking-wider text-gray-400 mb-2">
          Appointment
        </p>
        <p class="serif text-2xl sm:text-3xl text-gray-900 font-normal leading-none mb-1">
          Stay Updated
        </p>
        <p class="text-xs text-gray-500">
          Check your latest schedules and visits.
        </p>
      </div>

      <div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-5">
        <p class="text-[11px] uppercase tracking-wider text-gray-400 mb-2">
          Health Reminder
        </p>
        <p class="serif text-2xl sm:text-3xl text-gray-900 font-normal leading-none mb-1">
          Take Care 💙
        </p>
        <p class="text-xs text-gray-500">
          Your wellness always comes first.
        </p>
      </div>

      <div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-5">
        <p class="text-[11px] uppercase tracking-wider text-gray-400 mb-2">
          Support
        </p>
        <p class="serif text-2xl sm:text-3xl text-gray-900 font-normal leading-none mb-1">
          Need Help?
        </p>
        <p class="text-xs text-gray-500">
          Contact us anytime for assistance.
        </p>
      </div>

    </div>
{{-- Bottom Row --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

  {{-- Dashboard Overview --}}
  <div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-5">
    <div class="flex items-center justify-between mb-4">
      <p class="text-sm font-medium text-gray-900">Dashboard overview</p>
      <span class="text-xs text-gray-400">Updated today</span>
    </div>

    {{-- Dummy Graph --}}
    <div class="h-56 flex items-end justify-between gap-2 mb-4">
      <div class="flex flex-col items-center gap-2 w-full">
        <div class="bg-emerald-400 rounded-t-md w-full h-24"></div>
        <span class="text-[11px] text-gray-400">Mon</span>
      </div>

      <div class="flex flex-col items-center gap-2 w-full">
        <div class="bg-blue-400 rounded-t-md w-full h-36"></div>
        <span class="text-[11px] text-gray-400">Tue</span>
      </div>

      <div class="flex flex-col items-center gap-2 w-full">
        <div class="bg-violet-400 rounded-t-md w-full h-20"></div>
        <span class="text-[11px] text-gray-400">Wed</span>
      </div>

      <div class="flex flex-col items-center gap-2 w-full">
        <div class="bg-amber-400 rounded-t-md w-full h-44"></div>
        <span class="text-[11px] text-gray-400">Thu</span>
      </div>

      <div class="flex flex-col items-center gap-2 w-full">
        <div class="bg-rose-400 rounded-t-md w-full h-32"></div>
        <span class="text-[11px] text-gray-400">Fri</span>
      </div>

      <div class="flex flex-col items-center gap-2 w-full">
        <div class="bg-cyan-400 rounded-t-md w-full h-40"></div>
        <span class="text-[11px] text-gray-400">Sat</span>
      </div>

      <div class="flex flex-col items-center gap-2 w-full">
        <div class="bg-gray-400 rounded-t-md w-full h-28"></div>
        <span class="text-[11px] text-gray-400">Sun</span>
      </div>
    </div>

    <div class="grid grid-cols-3 gap-3 pt-2 border-t border-gray-100">
      <div>
        <p class="text-xs text-gray-400">Appointments</p>
        <p class="text-lg font-semibold text-gray-800">24</p>
      </div>

      <div>
        <p class="text-xs text-gray-400">Clients</p>
        <p class="text-lg font-semibold text-gray-800">18</p>
      </div>

      <div>
        <p class="text-xs text-gray-400">Reports</p>
        <p class="text-lg font-semibold text-gray-800">12</p>
      </div>
    </div>
  </div>

  {{-- Quick Actions --}}
  <div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-5">
    <p class="text-sm font-medium text-gray-900 mb-4">Quick actions (This is for Ongoing Development)</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">

      <a href="#" class="flex items-center gap-2.5 border border-gray-200 rounded-lg px-3.5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
        </svg>
        <span class="truncate">Report a Concern</span>
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
@endsection