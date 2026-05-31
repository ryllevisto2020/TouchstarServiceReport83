@extends('layouts.client')

@section('title', 'Touchstar Medical Enterprises Inc. Client Management')

@section('content')
<div class="w-full p-6 bg-slate-50 min-h-screen">

    {{-- Header --}}
    <div class="mb-8">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-3xl p-8 border border-blue-100 shadow-sm">
            <h1 class="text-xl sm:text-2xl font-semibold text-slate-800">
                Touchstar Medical Enterprises Inc. Client Dashboard
            </h1>

            <p class="text-3xl sm:text-4xl font-bold text-slate-900 mt-2">
                Welcome, {{ $client_detail->client_name ?? 'Client' }} 👋
            </p>

            <p class="text-sm text-slate-500 mt-2">
                {{ $currentDate ?? now()->format('l, F d, Y') }} · Here’s what’s happening today
            </p>
        </div>
    </div>

    {{-- Quick Summary --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        {{-- Machines --}}
        <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-6 hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mb-4">
                <span class="text-blue-600 text-xl">🖥️</span>
            </div>
            <h3 class="text-sm font-medium text-slate-500">Installed Machines</h3>
            <p class="text-3xl font-bold text-slate-900 mt-2">
                {{ $machineCount ?? 0 }}
            </p>
            <p class="text-sm text-slate-400 mt-1">Registered equipment</p>
        </div>

        {{-- Services --}}
        <div class="bg-white rounded-2xl shadow-sm border border-indigo-100 p-6 hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center mb-4">
                <span class="text-indigo-600 text-xl">🛠️</span>
            </div>
            <h3 class="text-sm font-medium text-slate-500">Pending Services</h3>
            <p class="text-3xl font-bold text-slate-900 mt-2">
                {{ $pendingService ?? 0 }}
            </p>
            <p class="text-sm text-slate-400 mt-1">Awaiting maintenance</p>
        </div>

        {{-- Completed --}}
        <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 p-6 hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center mb-4">
                <span class="text-emerald-600 text-xl">✅</span>
            </div>
            <h3 class="text-sm font-medium text-slate-500">Completed Requests</h3>
            <p class="text-3xl font-bold text-slate-900 mt-2">
                {{ $completedRequests ?? 0 }}
            </p>
            <p class="text-sm text-slate-400 mt-1">Finished service records</p>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Welcome / Info --}}
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
            <h2 class="text-xl font-semibold text-slate-800 mb-4">
                Welcome to Your Portal
            </h2>

            <p class="text-slate-600 leading-relaxed">
                Manage your machine service requests, monitor maintenance records,
                and stay updated with your account activities. This dashboard is
                designed to provide quick access to important information and
                improve your service experience with Touchstar Medical Enterprises Inc.
            </p>

            {{-- Highlight Box --}}
            <div class="mt-6 bg-blue-50 border border-blue-100 rounded-2xl p-5">
                <h3 class="font-medium text-blue-700 mb-2">
                    Quick Reminder
                </h3>
                <p class="text-sm text-slate-600">
                    If your equipment needs preventive maintenance or repair,
                    submit a request to our technical team for immediate support.
                </p>
            </div>            
        </div>

        {{-- Quick Links --}}
       
    </div>

    {{-- Bottom Section --}}
    <div class="mt-8">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-500 rounded-3xl p-8 text-white shadow-md">
            <h3 class="text-2xl font-semibold mb-3">
                Thank You for Trusting Touchstar Medical
            </h3>
            <p class="text-blue-100 max-w-3xl">
                We are committed to providing dependable medical equipment support,
                preventive maintenance, and quality service to help your facility
                operate efficiently and without interruption.
            </p>
        </div>
    </div>

</div>
@endsection