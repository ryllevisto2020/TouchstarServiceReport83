@extends('layouts.app')
@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    body { font-family: 'Inter', sans-serif; }
    .animate-fade-in { animation: fadeIn 0.3s ease-out; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .form-step { display: none; }
    .form-step.active { display: block; animation: slideIn 0.3s ease-out; }
    @keyframes slideIn { from { transform: translateX(20px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    .step-indicator {
        width: 32px; height: 32px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 600; font-size: 14px;
        background-color: #e5e7eb; color: #6b7280;
    }
    .step-indicator.active  { background-color: #0ea5e9; color: white; }
    .step-indicator.completed { background-color: #10b981; color: white; }
    .progress-bar  { height: 6px; background-color: #e5e7eb; border-radius: 3px; overflow: hidden; }
    .progress-fill { height: 100%; background-color: #0ea5e9; transition: width 0.3s ease; }
    .input-error   { border-color: #ef4444 !important; }
    .error-message { color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; }

    /* Client dropdown */
    #client-dropdown-list button:hover { background-color: #eff6ff; }
</style>

<main class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Page Title -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">TouchStar Medical Machines</h2>
            <p class="text-gray-600">List of all machines with their Preventive Maintenance Schedules</p>
        </div>
        <div>
            <button type="button" id="open-machine-modal"
                class="bg-blue-600 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700">
                + Add Machine
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filters -->
    <form method="GET" action="{{ route('machines.index') }}" id="filter-form"
          class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 items-end">

            <div class="group">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                <select name="status"
                    class="w-full px-3 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    onchange="filterTable()">
                    <option value="">All Statuses</option>
                    <option value="Operational"     {{ request('status') == 'Operational'     ? 'selected' : '' }}>✓ Operational</option>
                    <option value="Maintenance"     {{ request('status') == 'Maintenance'     ? 'selected' : '' }}>⚙ Maintenance</option>
                    <option value="Standby"         {{ request('status') == 'Standby'         ? 'selected' : '' }}>⏸ Standby</option>
                    <option value="Not Operational" {{ request('status') == 'Not Operational' ? 'selected' : '' }}>✗ Not Operational</option>
                </select>
            </div>

            <div class="group relative">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Location</label>
                <button type="button" id="location-trigger"
                    class="w-full px-3 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-900 text-sm text-left flex items-center justify-between hover:border-slate-400">
                    <span id="location-display">Select Location</span>
                    <span class="text-slate-400">▼</span>
                </button>
                <div id="location-dropdown" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-slate-200 rounded-lg shadow-lg z-50">
                    <div class="p-3 border-b border-slate-200 sticky top-0 bg-white rounded-t-lg">
                        <input type="text" id="location-search-input" placeholder="Search locations..."
                            class="w-full px-3 py-2 rounded border border-slate-300 text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            autocomplete="off">
                    </div>
                    <div id="location-options-container" class="max-h-48 overflow-y-auto">
                        <button type="button" data-value="" class="location-option w-full text-left px-4 py-2.5 hover:bg-blue-50 text-slate-700 text-sm border-b border-slate-100">
                            ✓ All Locations
                        </button>
                        @if(isset($locations))
                            @foreach($locations as $location)
                                <button type="button" data-value="{{ $location }}" class="location-option w-full text-left px-4 py-2.5 hover:bg-blue-50 text-slate-700 text-sm border-b border-slate-100">
                                    📍 {{ $location }}
                                </button>
                            @endforeach
                        @endif
                    </div>
                </div>
                <select name="location" id="location-filter" class="hidden">
                    <option value="">All Locations</option>
                    @if(isset($locations))
                        @foreach($locations as $location)
                            <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>{{ $location }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="group">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Serial Number</label>
                <div class="relative">
                    <input type="text" name="serial_search" id="serial-search"
                        placeholder="Search serial..."
                        value="{{ request('serial_search') }}"
                        class="w-full px-3 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        autocomplete="off" list="serial-list">
                    <datalist id="serial-list">
                        @if(isset($serialNumbers))
                            @foreach($serialNumbers as $serial)
                                <option value="{{ $serial }}">
                            @endforeach
                        @endif
                    </datalist>
                    @if(request('serial_search'))
                        <button type="button"
                            onclick="document.getElementById('serial-search').value=''; filterTable();"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">✕</button>
                    @endif
                </div>
            </div>

            <div class="group">
                <label class="block text-sm font-semibold text-slate-700 mb-2">PMS Due</label>
                <select name="pms_due"
                    class="w-full px-3 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    onchange="filterTable()">
                    <option value="">Any Time</option>
                    <option value="Next 7 Days"  {{ request('pms_due') == 'Next 7 Days'  ? 'selected' : '' }}>📅 Next 7 Days</option>
                    <option value="Next 30 Days" {{ request('pms_due') == 'Next 30 Days' ? 'selected' : '' }}>📅 Next 30 Days</option>
                    <option value="Overdue"      {{ request('pms_due') == 'Overdue'      ? 'selected' : '' }}>⚠ Overdue</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit"
                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium px-4 py-2.5 rounded-lg transition-all shadow-sm hover:shadow-md">
                    Apply Filters
                </button>
                <a href="{{ route('machines.index') }}"
                    class="px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-lg transition-all">
                    Clear
                </a>
            </div>
        </div>

        @if(request('status') || request('location') || request('serial_search') || request('pms_due'))
            <div class="mt-4 pt-4 border-t border-slate-200">
                <p class="text-sm text-slate-600 mb-2">Active Filters:</p>
                <div class="flex flex-wrap gap-2">
                    @if(request('status'))
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                            Status: {{ request('status') }}
                            <a href="{{ route('machines.index', array_merge(request()->query(), ['status' => null])) }}" class="hover:text-blue-900">✕</a>
                        </span>
                    @endif
                    @if(request('location'))
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                            Location: {{ request('location') }}
                            <a href="{{ route('machines.index', array_merge(request()->query(), ['location' => null])) }}" class="hover:text-green-900">✕</a>
                        </span>
                    @endif
                    @if(request('serial_search'))
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-medium">
                            Serial: {{ request('serial_search') }}
                            <a href="{{ route('machines.index', array_merge(request()->query(), ['serial_search' => null])) }}" class="hover:text-purple-900">✕</a>
                        </span>
                    @endif
                    @if(request('pms_due'))
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-medium">
                            PMS: {{ request('pms_due') }}
                            <a href="{{ route('machines.index', array_merge(request()->query(), ['pms_due' => null])) }}" class="hover:text-orange-900">✕</a>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </form>

    <!-- View Toggle -->
    <div class="flex justify-end mb-4">
        <div class="inline-flex rounded-md shadow-sm" role="group">
            <button id="card-view-btn"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-l-md border border-blue-600 hover:bg-blue-700">
                <i class="fas fa-th-large mr-1"></i> Card View
            </button>
            <button id="table-view-btn"
                class="px-4 py-2 text-sm font-medium text-blue-600 bg-white rounded-r-md border border-blue-600 hover:bg-gray-100">
                <i class="fas fa-table mr-1"></i> Table View
            </button>
        </div>
    </div>

    @if($machines->count() > 0)

        <!-- Card View -->
        <div id="card-view" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($machines as $machine)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="relative">
                    <img class="h-48 w-full object-cover"
                        src="{{ $machine->image_path ? Storage::url($machine->image_path) : asset('machines/default-machine.jpg') }}"
                        alt="{{ $machine->name }}">
                    <div class="absolute top-4 right-4 h-16 w-16">
                        <img class="h-16 w-16 rounded-md object-cover border-2 border-white shadow-md"
                            src="{{ $machine->image_path ? Storage::url($machine->image_path) : asset('machines/default-machine.jpg') }}"
                            alt="{{ $machine->name }}">
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $machine->name }}</h3>
                            <p class="text-sm text-gray-500">ID: {{ $machine->serial_number }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($machine->status == 'Operational') bg-green-100 text-green-800
                            @elseif($machine->status == 'Maintenance') bg-yellow-100 text-yellow-800
                            @elseif($machine->status == 'Standby') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $machine->status }}
                        </span>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <div>
                            <p class="text-xs text-gray-500">Location</p>
                            <p class="text-sm font-medium">{{ $machine->client_location }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Last Service</p>
                            <p class="text-sm font-medium">{{ $machine->last_service_date->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Next PMS</p>
                            <p class="text-sm font-medium
                                @if($machine->next_service_date->isPast()) text-red-600
                                @elseif($machine->next_service_date->diffInDays(now()) <= 7) text-yellow-600
                                @else text-green-600 @endif">
                                {{ $machine->next_service_date->format('d M Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Region</p>
                            <p class="text-sm font-medium">{{ $machine->region }}</p>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <button class="text-blue-600 hover:text-blue-900 view-details"
                                data-machine-id="{{ $machine->id }}">
                            <i class="fas fa-eye mr-1"></i> Details
                        </button>
                        <button class="text-gray-600 hover:text-gray-900 edit-machine"
                                data-machine-id="{{ $machine->id }}">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Table View -->
        <div id="table-view" class="bg-white shadow rounded-lg overflow-hidden hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Machine</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Next PMS</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($machines as $machine)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover"
                                            src="{{ $machine->image_path ? Storage::url($machine->image_path) : asset('machines/default-machine.jpg') }}"
                                            alt="{{ $machine->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $machine->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $machine->model }}</div>
                                        <div class="text-xs text-gray-400">{{ $machine->serial_number }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $machine->client_location }}</div>
                                <div class="text-sm text-gray-500">{{ $machine->city }}, {{ $machine->region }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($machine->status == 'Operational') bg-green-100 text-green-800
                                    @elseif($machine->status == 'Maintenance') bg-yellow-100 text-yellow-800
                                    @elseif($machine->status == 'Standby') bg-blue-100 text-blue-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $machine->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $machine->last_service_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm
                                @if($machine->next_service_date->isPast()) text-red-600
                                @elseif($machine->next_service_date->diffInDays(now()) <= 7) text-yellow-600
                                @else text-green-600 @endif">
                                {{ $machine->next_service_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 mr-3 view-details"
                                        data-machine-id="{{ $machine->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-gray-600 hover:text-gray-900 mr-3 edit-machine"
                                        data-machine-id="{{ $machine->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900 delete-machine"
                                        data-machine-id="{{ $machine->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 rounded-b-lg shadow mt-6">
            {{ $machines->appends(request()->query())->links() }}
        </div>

    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <div class="text-gray-400 text-6xl mb-4"><i class="fas fa-tools"></i></div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No machines found</h3>
            <p class="text-gray-500 mb-4">
                @if(request()->hasAny(['status', 'location', 'pms_due']))
                    No machines match your current filter criteria.
                @else
                    Get started by adding your first medical machine.
                @endif
            </p>
            @if(request()->hasAny(['status', 'location', 'pms_due']))
                <a href="{{ route('machines.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-600 bg-blue-100 hover:bg-blue-200">
                    Clear Filters
                </a>
            @else
                <button type="button" id="open-machine-modal"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i> Add Your First Machine
                </button>
            @endif
        </div>
    @endif

</main>

<!-- ═══════════════════════════════════════════════════════════════
     ADD / EDIT MACHINE MODAL
═══════════════════════════════════════════════════════════════ -->
<div id="machine-modal" class="fixed z-10 inset-0 overflow-y-auto hidden animate-fade-in">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-middle bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <form id="machine-form" action="{{ route('machines.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="edit-machine-id" name="machine_id" value="">

                <!-- Header & Progress -->
                <div class="bg-white px-6 pt-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 id="modal-title" class="text-2xl font-bold text-gray-900">Register New Medical Machine</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500 close-modal">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-2">
                                <div class="step-indicator active" data-step="1"><span>1</span><i class="fas fa-check hidden"></i></div>
                                <span class="text-sm font-medium text-blue-600">Basic Info</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="step-indicator" data-step="2"><span>2</span><i class="fas fa-check hidden"></i></div>
                                <span class="text-sm font-medium text-gray-500">Location</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="step-indicator" data-step="3"><span>3</span><i class="fas fa-check hidden"></i></div>
                                <span class="text-sm font-medium text-gray-500">Maintenance</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="step-indicator" data-step="4"><span>4</span><i class="fas fa-check hidden"></i></div>
                                <span class="text-sm font-medium text-gray-500">Review</span>
                            </div>
                        </div>
                        <div class="progress-bar"><div class="progress-fill" style="width: 25%"></div></div>
                    </div>
                </div>

                <div class="bg-white px-6 pb-6">

                    <!-- ── STEP 1: Basic Info ── -->
                    <div class="form-step active" data-step="1">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Machine Name *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-toolbox text-gray-400"></i>
                                    </div>
                                    <input type="text" name="name" id="name" required
                                        class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                                </div>
                                <p class="error-message hidden" id="name-error"></p>
                            </div>

                            <div>
                                <label for="model" class="block text-sm font-medium text-gray-700 mb-2">Model *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-microchip text-gray-400"></i>
                                    </div>
                                    <input type="text" name="model" id="model" required
                                        class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                                </div>
                                <p class="error-message hidden" id="model-error"></p>
                            </div>

                            <div>
                                <label for="serial_number" class="block text-sm font-medium text-gray-700 mb-2">Serial Number *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-barcode text-gray-400"></i>
                                    </div>
                                    <input type="text" name="serial_number" id="serial_number" required
                                        class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                                </div>
                                <p class="error-message hidden" id="serial_number-error"></p>
                            </div>

                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 pt-3 flex items-start pointer-events-none">
                                        <i class="fas fa-align-left text-gray-400"></i>
                                    </div>
                                    <textarea name="description" id="description" rows="3"
                                        class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3"></textarea>
                                </div>
                                <p class="error-message hidden" id="description-error"></p>
                            </div>
                        </div>
                    </div>

                    <!-- ── STEP 2: Location (Client Searchable Dropdown) ── -->
                    <div class="form-step" data-step="2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Client searchable dropdown (full width) -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Hospital / Client Name *</label>

                                {{-- Hidden fields submitted with the form --}}
                                <input type="hidden" name="client_id"       id="client_id">
                                <input type="hidden" name="client_location" id="client_location">

                                <div class="relative" id="client-dropdown-wrapper">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                        <i class="fas fa-hospital text-gray-400"></i>
                                    </div>
                                    {{-- Visible search input --}}
                                    <input type="text" id="client-search-input"
                                        placeholder="Type to search hospital / client..."
                                        autocomplete="off"
                                        class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">

                                    {{-- Dropdown list --}}
                                    <div id="client-dropdown-list"
                                        class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-slate-200 rounded-lg shadow-lg z-50 max-h-56 overflow-y-auto">
                                        {{-- Options injected by JS --}}
                                    </div>
                                </div>
                                <p class="error-message hidden" id="client_location-error"></p>
                            </div>

                            <!-- Region -->
                            <div>
                                <label for="region" class="block text-sm font-medium text-gray-700 mb-2">Region *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </div>
                                    <select name="region" id="region" required
                                        class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 appearance-none">
                                        <option value="">Select Region</option>
                                        <option value="NCR">National Capital Region</option>
                                        <option value="CAR">Cordillera Administrative Region</option>
                                        <option value="ILOCOS">Ilocos Region</option>
                                        <option value="CAGAYAN">Cagayan Valley</option>
                                        <option value="CENTRAL_LUZON">Central Luzon</option>
                                        <option value="CALABARZON">CALABARZON</option>
                                        <option value="MIMAROPA">MIMAROPA</option>
                                        <option value="BICOL">Bicol Region</option>
                                        <option value="WESTERN_VISAYAS">Western Visayas</option>
                                        <option value="CENTRAL_VISAYAS">Central Visayas</option>
                                        <option value="EASTERN_VISAYAS">Eastern Visayas</option>
                                        <option value="ZAMBOANGA">Zamboanga Peninsula</option>
                                        <option value="NORTHERN_MINDANAO">Northern Mindanao</option>
                                        <option value="DAVAO">Davao Region</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                <p class="error-message hidden" id="region-error"></p>
                            </div>

                            <!-- City (auto-filled from client_address) -->
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-city text-gray-400"></i>
                                    </div>
                                    <input type="text" name="city" id="city" required
                                        placeholder="Auto-filled when client is selected"
                                        class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                                </div>
                                <p class="error-message hidden" id="city-error"></p>
                            </div>

                        </div>
                    </div>

                    <!-- ── STEP 3: Maintenance ── -->
                    <div class="form-step" data-step="3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-cog text-gray-400"></i>
                                    </div>
                                    <select name="status" id="status" required
                                        class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 appearance-none">
                                        <option value="Operational">Operational</option>
                                        <option value="Maintenance">Maintenance</option>
                                        <option value="Standby">Standby</option>
                                        <option value="Not Operational">Not Operational</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                <p class="error-message hidden" id="status-error"></p>
                            </div>

                            <div>
                                <label for="installation_date" class="block text-sm font-medium text-gray-700 mb-2">Installation Date *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                    </div>
                                    <input type="date" name="installation_date" id="installation_date" required
                                        class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                                </div>
                                <p class="error-message hidden" id="installation_date-error"></p>
                            </div>

                            <div>
                                <label for="last_service_date" class="block text-sm font-medium text-gray-700 mb-2">Last Service Date *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-wrench text-gray-400"></i>
                                    </div>
                                    <input type="date" name="last_service_date" id="last_service_date" required
                                        class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                                </div>
                                <p class="error-message hidden" id="last_service_date-error"></p>
                            </div>

                            <div>
                                <label for="service_interval_days" class="block text-sm font-medium text-gray-700 mb-2">Service Interval (Days) *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-day text-gray-400"></i>
                                    </div>
                                    <input type="number" name="service_interval_days" id="service_interval_days" value="90" min="1" required
                                        class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                                </div>
                                <p class="error-message hidden" id="service_interval_days-error"></p>
                            </div>

                            <div class="md:col-span-2">
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Machine Image</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                                    <div class="space-y-1 text-center">
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                                <span>Upload an image</span>
                                                <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                        <p id="image-selected-name" class="text-xs text-blue-600 hidden"></p>
                                    </div>
                                </div>
                                <p class="error-message hidden" id="image-error"></p>
                            </div>
                        </div>
                    </div>

                    <!-- ── STEP 4: Review ── -->
                    <div class="form-step" data-step="4">
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Please review the information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="border-l-4 border-blue-500 pl-3 py-1">
                                    <p class="text-sm font-medium text-gray-500">Machine Name</p>
                                    <p id="review-name" class="font-semibold">-</p>
                                </div>
                                <div class="border-l-4 border-blue-500 pl-3 py-1">
                                    <p class="text-sm font-medium text-gray-500">Model</p>
                                    <p id="review-model" class="font-semibold">-</p>
                                </div>
                                <div class="border-l-4 border-blue-500 pl-3 py-1">
                                    <p class="text-sm font-medium text-gray-500">Serial Number</p>
                                    <p id="review-serial" class="font-semibold">-</p>
                                </div>
                                <div class="border-l-4 border-blue-500 pl-3 py-1">
                                    <p class="text-sm font-medium text-gray-500">Client / Hospital</p>
                                    <p id="review-client" class="font-semibold">-</p>
                                </div>
                                <div class="border-l-4 border-blue-500 pl-3 py-1">
                                    <p class="text-sm font-medium text-gray-500">City</p>
                                    <p id="review-location" class="font-semibold">-</p>
                                </div>
                                <div class="border-l-4 border-blue-500 pl-3 py-1">
                                    <p class="text-sm font-medium text-gray-500">Installation Date</p>
                                    <p id="review-installation" class="font-semibold">-</p>
                                </div>
                                <div class="border-l-4 border-blue-500 pl-3 py-1">
                                    <p class="text-sm font-medium text-gray-500">Service Interval</p>
                                    <p id="review-interval" class="font-semibold">- days</p>
                                </div>
                                <div class="border-l-4 border-blue-500 pl-3 py-1">
                                    <p class="text-sm font-medium text-gray-500">Next Service</p>
                                    <p id="review-next-service" class="font-semibold">-</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center mb-4">
                            <input id="terms" name="terms" type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" required>
                            <label for="terms" class="ml-2 block text-sm text-gray-700">
                                I confirm that all information provided is accurate
                            </label>
                        </div>
                        <p class="error-message hidden" id="terms-error"></p>
                    </div>
                </div>

                <!-- Footer Navigation -->
                <div class="bg-gray-50 px-6 py-4 flex justify-between">
                    <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-colors prev-step hidden">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </button>
                    <div class="flex space-x-3 ml-auto">
                        <button type="button" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors close-modal">
                            Cancel
                        </button>
                        <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors next-step">
                            Continue <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors hidden submit-btn">
                            <i class="fas fa-check-circle mr-2"></i> Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════════
     DETAILS MODAL
═══════════════════════════════════════════════════════════════ -->
<div id="details-modal" class="fixed z-10 inset-0 overflow-y-auto hidden animate-fade-in">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-middle bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
            <div class="bg-white px-6 pt-6 pb-4">
                <div class="flex justify-between items-center mb-6">
                    <h3 id="details-modal-title" class="text-2xl font-bold text-gray-900">Machine Details</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500 close-details-modal">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <img id="details-image" class="w-full h-64 object-cover rounded-lg" src="" alt="Machine Image">
                    </div>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900" id="details-name">-</h4>
                            <p class="text-gray-600" id="details-model">-</p>
                            <p class="text-sm text-gray-500">Serial: <span id="details-serial">-</span></p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Status</p>
                                <span id="details-status" class="px-2 py-1 text-xs font-semibold rounded-full">-</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Location</p>
                                <p id="details-location" class="text-sm">-</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Installation Date</p>
                                <p id="details-installation" class="text-sm">-</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Service Interval</p>
                                <p id="details-interval" class="text-sm">- days</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Last Service</p>
                                <p id="details-last-service" class="text-sm">-</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Next Service</p>
                                <p id="details-next-service" class="text-sm">-</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-2">Description</p>
                            <p id="details-description" class="text-sm text-gray-700">-</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <button type="button" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors close-details-modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════════
     MAIN MACHINE MANAGER SCRIPT
═══════════════════════════════════════════════════════════════ -->
<script>
class MachineManager {
    constructor() {
        this.isEditMode    = false;
        this.currentEditId = null;
        this.currentStep   = 1;
        this.totalSteps    = 4;
        this.debounceTimer = null;
        this.baseURL       = window.location.origin;
        this.init();
    }

    init() {
        this.bindEvents();
        this.setupFormValidation();
        this.initializeViewToggle();
        this.handleKeyboardShortcuts();
        this.setupImagePreview();
    }

    bindEvents() {
        document.querySelectorAll('.close-modal').forEach(btn =>
            btn.addEventListener('click', () => this.closeModal()));

        document.querySelectorAll('.close-details-modal').forEach(btn =>
            btn.addEventListener('click', () => this.closeDetailsModal()));

        document.getElementById('open-machine-modal')?.addEventListener('click', () => this.openAddModal());
        document.querySelector('.next-step')?.addEventListener('click', () => this.nextStep());
        document.querySelector('.prev-step')?.addEventListener('click', () => this.prevStep());
        document.getElementById('machine-form')?.addEventListener('submit', e => this.handleFormSubmit(e));
        document.getElementById('card-view-btn')?.addEventListener('click', () => this.toggleView('card'));
        document.getElementById('table-view-btn')?.addEventListener('click', () => this.toggleView('table'));

        this.bindMachineActions();

        document.getElementById('machine-modal')?.addEventListener('click', e => {
            if (e.target.id === 'machine-modal') this.closeModal();
        });
        document.getElementById('details-modal')?.addEventListener('click', e => {
            if (e.target.id === 'details-modal') this.closeDetailsModal();
        });
    }

    setupImagePreview() {
        document.getElementById('image')?.addEventListener('change', function() {
            const nameEl = document.getElementById('image-selected-name');
            if (this.files && this.files[0]) {
                nameEl.textContent = '✓ ' + this.files[0].name;
                nameEl.classList.remove('hidden');
            }
        });
    }

    bindMachineActions() {
        document.querySelectorAll('.view-details').forEach(btn =>
            btn.addEventListener('click', e => {
                e.preventDefault();
                this.fetchMachineDetails(btn.getAttribute('data-machine-id'));
            }));

        document.querySelectorAll('.edit-machine').forEach(btn =>
            btn.addEventListener('click', e => {
                e.preventDefault();
                this.fetchMachineForEdit(btn.getAttribute('data-machine-id'));
            }));

        document.querySelectorAll('.delete-machine').forEach(btn =>
            btn.addEventListener('click', e => {
                e.preventDefault();
                this.deleteMachine(btn.getAttribute('data-machine-id'));
            }));
    }

    async fetchMachineDetails(machineId) {
        try {
            this.showLoading('Loading machine details...');
            const response = await fetch(`${this.baseURL}/machine/${machineId}/details`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': this.getCSRFToken() }
            });
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            const data = await response.json();
            this.populateDetailsModal(data);
            this.openDetailsModal();
        } catch (err) {
            this.showError('Failed to load machine details. Please try again.');
        } finally {
            this.hideLoading();
        }
    }

    async fetchMachineForEdit(machineId) {
        try {
            this.showLoading('Loading machine data...');
            const response = await fetch(`${this.baseURL}/machine/${machineId}/edit`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': this.getCSRFToken() }
            });
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            const data = await response.json();
            this.setupEditMode(machineId, data);
            this.openModal();
        } catch (err) {
            this.showError('Failed to load machine data. Please try again.');
        } finally {
            this.hideLoading();
        }
    }

    async deleteMachine(machineId) {
        if (!confirm('Are you sure you want to delete this machine? This action cannot be undone.')) return;
        try {
            this.showLoading('Deleting machine...');
            const response = await fetch(`${this.baseURL}/machine/${machineId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': this.getCSRFToken(), 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            const result = await response.json();
            if (result.success) {
                this.showSuccess(result.message);
                this.removeMachineFromDOM(machineId);
            } else {
                this.showError(result.message || 'Failed to delete machine');
            }
        } catch (err) {
            this.showError('Network error. Please try again.');
        } finally {
            this.hideLoading();
        }
    }

    async handleFormSubmit(e) {
        e.preventDefault();
        if (!this.validateCurrentStep()) return;

        const form     = e.target;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn?.innerHTML || 'Submit';

        try {
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
                submitBtn.disabled  = true;
            }

            const url = this.isEditMode
                ? `${this.baseURL}/machine/${this.currentEditId}`
                : `${this.baseURL}/machine`;

            if (this.isEditMode) formData.append('_method', 'PUT');

            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': this.getCSRFToken(), 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!response.ok) {
                const errorData = await response.json().catch(() => ({ success: false, message: `Server error: ${response.status}` }));
                if (response.status === 422 && errorData.errors) {
                    this.handleFormErrors(errorData.errors);
                    this.showError(errorData.message || 'Please correct the errors and try again.');
                } else {
                    throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                }
                return;
            }

            const result = await response.json();
            if (result.success) {
                this.showSuccess(result.message);
                this.closeModal();
                setTimeout(() => window.location.reload(), 1500);
            } else {
                if (result.errors) this.handleFormErrors(result.errors);
                this.showError(result.message || 'Please correct the errors and try again.');
            }
        } catch (err) {
            this.showError(err.message || 'Network error. Please try again.');
        } finally {
            if (submitBtn) {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled  = false;
            }
        }
    }

    handleFormErrors(errors) {
        document.querySelectorAll('.error-message').forEach(el => { el.classList.add('hidden'); el.textContent = ''; });
        document.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));

        Object.keys(errors).forEach(field => {
            const input = document.getElementById(field) || document.getElementById(field.replace('_', '-'));
            const errorEl = document.getElementById(`${field}-error`) || document.getElementById(field.replace(/_/g, '-') + '-error');
            if (input)   input.classList.add('input-error');
            if (errorEl) { errorEl.textContent = Array.isArray(errors[field]) ? errors[field][0] : errors[field]; errorEl.classList.remove('hidden'); }
        });
    }

    populateDetailsModal(data) {
        this.updateElementText('details-modal-title', `${data.name} Details`);
        this.updateElementText('details-name',         data.name);
        this.updateElementText('details-model',        data.model);
        this.updateElementText('details-serial',       data.serial_number);
        this.updateElementText('details-location',     `${data.client_location}, ${data.city}, ${data.region}`);
        this.updateElementText('details-installation', this.formatDate(data.installation_date));
        this.updateElementText('details-interval',     `${data.service_interval_days} days`);
        this.updateElementText('details-last-service', data.last_service_date || 'Not available');
        this.updateElementText('details-next-service', data.next_service_date || 'Not calculated');
        this.updateElementText('details-description',  data.description || 'No description available');

        const imageEl = document.getElementById('details-image');
        if (imageEl) {
            imageEl.src     = data.image_path || '/images/default-machine.jpg';
            imageEl.onerror = () => { imageEl.src = '/images/default-machine.jpg'; };
        }

        const statusEl = document.getElementById('details-status');
        if (statusEl) {
            statusEl.textContent = data.status;
            statusEl.className   = 'px-2 py-1 text-xs font-semibold rounded-full';
            const map = {
                'Operational':     ['bg-green-100',  'text-green-800'],
                'Maintenance':     ['bg-yellow-100', 'text-yellow-800'],
                'Standby':         ['bg-blue-100',   'text-blue-800'],
                'Not Operational': ['bg-red-100',    'text-red-800']
            };
            if (map[data.status]) statusEl.classList.add(...map[data.status]);
        }
    }

    setupEditMode(machineId, data) {
        this.isEditMode    = true;
        this.currentEditId = machineId;
        this.updateElementText('modal-title', 'Edit Medical Machine');

        // Standard fields
        ['name','model','serial_number','description','region','city',
         'status','installation_date','last_service_date','service_interval_days'
        ].forEach(field => {
            const el = document.getElementById(field);
            if (el && data[field] !== undefined) el.value = data[field];
        });

        // ── Client dropdown: pre-fill from returned data ──
        const searchInput         = document.getElementById('client-search-input');
        const clientIdInput       = document.getElementById('client_id');
        const clientLocationInput = document.getElementById('client_location');

        if (data.client_name) {
            if (searchInput)         searchInput.value         = data.client_name;
            if (clientLocationInput) clientLocationInput.value = data.client_name;
        } else if (data.client_location) {
            if (searchInput)         searchInput.value         = data.client_location;
            if (clientLocationInput) clientLocationInput.value = data.client_location;
        }
        if (data.client_id && clientIdInput) clientIdInput.value = data.client_id;

        this.goToStep(1);
    }

    openAddModal() {
        this.isEditMode    = false;
        this.currentEditId = null;
        this.updateElementText('modal-title', 'Register New Medical Machine');
        this.resetForm();
        this.openModal();
    }

    openModal()        { document.getElementById('machine-modal')?.classList.remove('hidden'); document.body.classList.add('overflow-hidden'); }
    closeModal()       { document.getElementById('machine-modal')?.classList.add('hidden');    document.body.classList.remove('overflow-hidden'); this.resetForm(); }
    openDetailsModal() { document.getElementById('details-modal')?.classList.remove('hidden'); document.body.classList.add('overflow-hidden'); }
    closeDetailsModal(){ document.getElementById('details-modal')?.classList.add('hidden');    document.body.classList.remove('overflow-hidden'); }

    goToStep(step) {
        document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
        document.querySelector(`.form-step[data-step="${step}"]`)?.classList.add('active');

        document.querySelectorAll('.step-indicator').forEach((ind, idx) => {
            const n = idx + 1;
            ind.classList.remove('active','completed');
            const span = ind.querySelector('span');
            const icon = ind.querySelector('i');
            if (n === step) {
                ind.classList.add('active');
                span?.classList.remove('hidden'); icon?.classList.add('hidden');
            } else if (n < step) {
                ind.classList.add('completed');
                span?.classList.add('hidden'); icon?.classList.remove('hidden');
            } else {
                span?.classList.remove('hidden'); icon?.classList.add('hidden');
            }
        });

        const pct = ((step - 1) / (this.totalSteps - 1)) * 100;
        const bar = document.querySelector('.progress-fill');
        if (bar) bar.style.width = `${pct}%`;

        this.toggleElementVisibility('.prev-step',  step !== 1);
        this.toggleElementVisibility('.next-step',  step !== this.totalSteps);
        this.toggleElementVisibility('.submit-btn', step === this.totalSteps);

        if (step === this.totalSteps) this.updateReviewSection();
        this.currentStep = step;
    }

    nextStep() { if (this.validateCurrentStep() && this.currentStep < this.totalSteps) this.goToStep(this.currentStep + 1); }
    prevStep() { if (this.currentStep > 1) this.goToStep(this.currentStep - 1); }

    validateCurrentStep() {
        this.clearErrors();
        switch (this.currentStep) {
            case 1: return this.validateStep1();
            case 2: return this.validateStep2();
            case 3: return this.validateStep3();
            case 4: return this.validateStep4();
        }
        return true;
    }

    validateStep1() {
        let ok = true;
        ['name','model','serial_number'].forEach(f => {
            const el = document.getElementById(f);
            if (!el || !el.value.trim()) { this.showFieldError(f, `Please enter a ${f.replace(/_/g,' ')}`); ok = false; }
        });
        return ok;
    }

    validateStep2() {
        let ok = true;
        // Validate client selection via hidden fields
        const clientId       = document.getElementById('client_id');
        const clientLocation = document.getElementById('client_location');
        const searchInput    = document.getElementById('client-search-input');

        if (!clientId?.value || !clientLocation?.value) {
            // Show error on the visible search input
            if (searchInput) searchInput.classList.add('input-error');
            const errEl = document.getElementById('client_location-error');
            if (errEl) { errEl.textContent = 'Please select a hospital/client from the list'; errEl.classList.remove('hidden'); }
            ok = false;
        }

        ['region','city'].forEach(f => {
            const el = document.getElementById(f);
            if (!el || !el.value.trim()) {
                this.showFieldError(f, `Please ${f === 'region' ? 'select' : 'enter'} a ${f.replace(/_/g,' ')}`);
                ok = false;
            }
        });
        return ok;
    }

    validateStep3() {
        let ok = true;
        const installEl  = document.getElementById('installation_date');
        const serviceEl  = document.getElementById('last_service_date');
        const intervalEl = document.getElementById('service_interval_days');

        if (!installEl?.value)  { this.showFieldError('installation_date',    'Please select an installation date'); ok = false; }
        if (!serviceEl?.value)  { this.showFieldError('last_service_date',    'Please select a last service date');  ok = false; }
        if (!intervalEl?.value || intervalEl.value < 1) { this.showFieldError('service_interval_days', 'Please enter a valid service interval'); ok = false; }

        if (installEl?.value && serviceEl?.value) {
            if (new Date(serviceEl.value) < new Date(installEl.value)) {
                this.showFieldError('last_service_date', 'Last service date cannot be before installation date');
                ok = false;
            }
        }
        return ok;
    }

    validateStep4() {
        if (!document.getElementById('terms')?.checked) {
            this.showError('Please confirm that all information is accurate');
            return false;
        }
        return true;
    }

    showFieldError(fieldId, message) {
        const field   = document.getElementById(fieldId);
        const errEl   = document.getElementById(`${fieldId}-error`) || document.getElementById(fieldId.replace(/_/g,'-') + '-error');
        if (field)  field.classList.add('input-error');
        if (errEl)  { errEl.textContent = message; errEl.classList.remove('hidden'); }
    }

    updateReviewSection() {
        const map = {
            'review-name':        'name',
            'review-model':       'model',
            'review-serial':      'serial_number',
            'review-client':      'client-search-input', // show the human-readable name
            'review-installation':'installation_date',
            'review-interval':    'service_interval_days'
        };

        Object.keys(map).forEach(rid => {
            const src  = document.getElementById(map[rid]);
            const dest = document.getElementById(rid);
            if (!src || !dest) return;
            let val = src.value;
            if (rid === 'review-installation' && val) val = this.formatDate(val);
            else if (rid === 'review-interval' && val)  val = `${val} days`;
            dest.textContent = val || '-';
        });

        const city   = document.getElementById('city');
        const region = document.getElementById('region');
        const locRev = document.getElementById('review-location');
        if (city && region && locRev) locRev.textContent = [city.value, region.value].filter(Boolean).join(', ') || '-';

        const lastSvc   = document.getElementById('last_service_date');
        const interval  = document.getElementById('service_interval_days');
        const nextRev   = document.getElementById('review-next-service');
        if (lastSvc?.value && interval?.value && nextRev) {
            const d = new Date(lastSvc.value);
            d.setDate(d.getDate() + parseInt(interval.value));
            nextRev.textContent = this.formatDate(d.toISOString().split('T')[0]);
        }
    }

    resetForm() {
        document.getElementById('machine-form')?.reset();
        // Also clear client dropdown UI
        const si = document.getElementById('client-search-input');
        const ci = document.getElementById('client_id');
        const cl = document.getElementById('client_location');
        const dp = document.getElementById('client-dropdown-list');
        if (si) si.value = '';
        if (ci) ci.value = '';
        if (cl) cl.value = '';
        if (dp) dp.classList.add('hidden');
        const nameEl = document.getElementById('image-selected-name');
        if (nameEl) { nameEl.textContent = ''; nameEl.classList.add('hidden'); }
        this.goToStep(1);
        this.clearErrors();
        this.isEditMode    = false;
        this.currentEditId = null;
    }

    clearErrors() {
        document.querySelectorAll('.error-message').forEach(el => { el.classList.add('hidden'); el.textContent = ''; });
        document.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
    }

    setupFormValidation() {
        const form = document.getElementById('machine-form');
        if (!form) return;
        form.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('blur',  () => this.validateField(input));
            input.addEventListener('input', () => { if (input.classList.contains('input-error')) this.validateField(input); });
        });
    }

    validateField(field) {
        field.classList.remove('input-error');
        const errEl = document.getElementById(`${field.id}-error`) || document.getElementById(field.id.replace(/_/g,'-') + '-error');
        if (errEl) { errEl.classList.add('hidden'); errEl.textContent = ''; }
        if (field.required && !field.value.trim()) {
            this.showFieldError(field.id, `${(field.name || field.id).replace(/_/g,' ')} is required`);
            return false;
        }
        return true;
    }

    initializeViewToggle() { this.toggleView('card'); }

    toggleView(viewType) {
        const cardView = document.getElementById('card-view');
        const tableView = document.getElementById('table-view');
        const cardBtn  = document.getElementById('card-view-btn');
        const tableBtn = document.getElementById('table-view-btn');

        if (viewType === 'card') {
            cardView?.classList.remove('hidden');
            tableView?.classList.add('hidden');
            cardBtn?.classList.add('text-white','bg-blue-600');   cardBtn?.classList.remove('text-blue-600','bg-white');
            tableBtn?.classList.add('text-blue-600','bg-white');  tableBtn?.classList.remove('text-white','bg-blue-600');
        } else {
            cardView?.classList.add('hidden');
            tableView?.classList.remove('hidden');
            tableBtn?.classList.add('text-white','bg-blue-600');  tableBtn?.classList.remove('text-blue-600','bg-white');
            cardBtn?.classList.add('text-blue-600','bg-white');   cardBtn?.classList.remove('text-white','bg-blue-600');
        }
    }

    removeMachineFromDOM(machineId) {
        document.querySelectorAll(`[data-machine-id="${machineId}"]`).forEach(el => {
            el.closest('.bg-white.rounded-lg, tr')?.remove();
        });
    }

    updateElementText(id, text) { const el = document.getElementById(id); if (el) el.textContent = text; }
    toggleElementVisibility(sel, show) { document.querySelector(sel)?.classList.toggle('hidden', !show); }

    formatDate(str) {
        if (!str) return '-';
        try { return new Date(str).toLocaleDateString('en-US', { year:'numeric', month:'short', day:'numeric' }); }
        catch { return str; }
    }

    showLoading(msg = 'Loading...') {
        let overlay = document.getElementById('loading-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'loading-overlay';
            overlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            overlay.innerHTML = `<div class="bg-white rounded-lg p-6 flex items-center space-x-3"><div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div><span id="loading-message">${msg}</span></div>`;
            document.body.appendChild(overlay);
        } else {
            const msgEl = document.getElementById('loading-message');
            if (msgEl) msgEl.textContent = msg;
            overlay.classList.remove('hidden');
        }
        document.body.classList.add('overflow-hidden');
    }

    hideLoading() {
        document.getElementById('loading-overlay')?.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    showSuccess(msg) { this.showNotification(msg, 'success'); }
    showError(msg)   { this.showNotification(msg, 'error'); }

    showNotification(msg, type = 'info') {
        const n = document.createElement('div');
        n.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 max-w-md ${
            type === 'success' ? 'bg-green-100 text-green-700 border border-green-200' :
            type === 'error'   ? 'bg-red-100 text-red-700 border border-red-200' :
                                 'bg-blue-100 text-blue-700 border border-blue-200'}`;
        n.innerHTML = `<div class="flex items-start"><div class="flex-shrink-0"><i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} text-lg"></i></div><div class="ml-3"><p class="text-sm font-medium">${msg}</p></div><div class="ml-auto pl-3"><button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button></div></div>`;
        document.body.appendChild(n);
        setTimeout(() => {
            if (n.parentElement) {
                n.style.transition = 'opacity 0.5s, transform 0.5s';
                n.style.opacity = '0'; n.style.transform = 'translateX(100%)';
                setTimeout(() => n.parentElement && n.remove(), 500);
            }
        }, 5000);
    }

    getCSRFToken() { return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''; }

    handleKeyboardShortcuts() {
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                if (!document.getElementById('machine-modal')?.classList.contains('hidden'))  this.closeModal();
                if (!document.getElementById('details-modal')?.classList.contains('hidden')) this.closeDetailsModal();
            }
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                const form = document.getElementById('machine-form');
                if (form && !document.getElementById('machine-modal')?.classList.contains('hidden')) {
                    if (this.currentStep === this.totalSteps) form.dispatchEvent(new Event('submit'));
                    else this.nextStep();
                }
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.machineManager = new MachineManager();
});
</script>

<!-- ═══════════════════════════════════════════════════════════════
     CLIENT SEARCHABLE DROPDOWN SCRIPT
═══════════════════════════════════════════════════════════════ -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    let allClients = [];

    // ── Fetch clients from server ──────────────────────────────────────────────
    fetch(`${window.location.origin}/machine/clients`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
    .then(r => r.json())
    .then(data => { allClients = data; })
    .catch(err => console.error('Failed to load clients:', err));

    const searchInput         = document.getElementById('client-search-input');
    const dropdownList        = document.getElementById('client-dropdown-list');
    const clientIdInput       = document.getElementById('client_id');
    const clientLocationInput = document.getElementById('client_location');
    const cityInput           = document.getElementById('city');

    if (!searchInput || !dropdownList) return;

    // ── Render matching options ────────────────────────────────────────────────
    function renderOptions(filtered) {
        dropdownList.innerHTML = '';
        if (!filtered.length) {
            dropdownList.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500 text-center">No clients found</div>';
        } else {
            filtered.forEach(client => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'w-full text-left px-4 py-2.5 hover:bg-blue-50 text-slate-800 text-sm border-b border-slate-100 flex flex-col transition-colors';
                btn.innerHTML = `
                    <span class="font-medium">🏥 ${client.client_name}</span>
                    <span class="text-xs text-gray-400 mt-0.5">${client.client_address || 'No address on record'}</span>
                `;
                btn.addEventListener('click', () => selectClient(client));
                dropdownList.appendChild(btn);
            });
        }
        dropdownList.classList.remove('hidden');
    }

    // ── Select a client ────────────────────────────────────────────────────────
    function selectClient(client) {
        searchInput.value         = client.client_name;
        clientIdInput.value       = client.client_id;
        clientLocationInput.value = client.client_name;

        // Auto-fill city from client_address
        if (cityInput) cityInput.value = client.client_address || '';

        // Clear validation error if any
        searchInput.classList.remove('input-error');
        const errEl = document.getElementById('client_location-error');
        if (errEl) errEl.classList.add('hidden');

        dropdownList.classList.add('hidden');
    }

    // ── Filter on typing ───────────────────────────────────────────────────────
    searchInput.addEventListener('input', function () {
        const term = this.value.toLowerCase().trim();

        // Clear client_id/location when user types (forces re-selection)
        clientIdInput.value       = '';
        clientLocationInput.value = '';

        if (!term) { dropdownList.classList.add('hidden'); return; }

        const filtered = allClients.filter(c =>
            c.client_name.toLowerCase().includes(term) ||
            (c.client_address || '').toLowerCase().includes(term)
        );
        renderOptions(filtered);
    });

    // ── Show full list on focus if no term ────────────────────────────────────
    searchInput.addEventListener('focus', function () {
        const term = this.value.toLowerCase().trim();
        if (allClients.length) {
            const filtered = term
                ? allClients.filter(c => c.client_name.toLowerCase().includes(term) || (c.client_address || '').toLowerCase().includes(term))
                : allClients;
            renderOptions(filtered);
        }
    });

    // ── Close dropdown on outside click ───────────────────────────────────────
    document.addEventListener('click', function (e) {
        if (!e.target.closest('#client-dropdown-wrapper')) {
            dropdownList.classList.add('hidden');
        }
    });
});
</script>

<!-- ═══════════════════════════════════════════════════════════════
     LOCATION FILTER DROPDOWN (sidebar filter, not form)
═══════════════════════════════════════════════════════════════ -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const locationTrigger   = document.getElementById('location-trigger');
    const locationDropdown  = document.getElementById('location-dropdown');
    const locationSearchInput = document.getElementById('location-search-input');
    const locationFilter    = document.getElementById('location-filter');
    const locationDisplay   = document.getElementById('location-display');
    const locationOptions   = document.querySelectorAll('.location-option');

    locationTrigger?.addEventListener('click', e => {
        e.preventDefault();
        locationDropdown.classList.toggle('hidden');
        if (!locationDropdown.classList.contains('hidden')) locationSearchInput.focus();
    });

    locationSearchInput?.addEventListener('input', e => {
        const term = e.target.value.toLowerCase();
        let visible = 0;
        locationOptions.forEach(opt => {
            const show = opt.textContent.toLowerCase().includes(term);
            opt.classList.toggle('hidden', !show);
            if (show) visible++;
        });
        let noMsg = document.getElementById('location-no-results');
        if (visible === 0) {
            if (!noMsg) {
                noMsg = document.createElement('div');
                noMsg.id = 'location-no-results';
                noMsg.className = 'px-4 py-3 text-center text-gray-500 text-sm';
                document.getElementById('location-options-container').appendChild(noMsg);
            }
            noMsg.textContent = 'No locations found';
        } else {
            noMsg?.remove();
        }
    });

    locationOptions.forEach(opt => {
        opt.addEventListener('click', e => {
            e.preventDefault();
            locationFilter.value    = opt.getAttribute('data-value');
            locationDisplay.textContent = opt.textContent.trim() || 'Select Location';
            locationSearchInput.value = '';
            locationDropdown.classList.add('hidden');
            filterTable();
        });
    });

    document.addEventListener('click', e => {
        if (!e.target.closest('.group') && !e.target.closest('#location-trigger')) {
            locationDropdown?.classList.add('hidden');
        }
    });

    // Restore selected location on page load
    const selected = locationFilter?.value;
    if (selected) {
        const opt = locationFilter.querySelector(`option[value="${selected}"]`);
        if (opt) locationDisplay.textContent = opt.textContent.trim();
    }
});

function filterTable() {
    document.getElementById('filter-form').submit();
}
</script>
@endsection 