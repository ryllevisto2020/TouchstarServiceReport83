@extends('layouts.client')

@section('title', 'TouchStar Medical Enterprises Inc. - Client Portal')

@section('content')
<div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">TouchStar Medical Machines</h2>
            <p class="text-gray-600">List of all machines with their Preventive Maintenance Schedules</p>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-sm text-gray-500">Operational</p>
                    {{ $operational }}
                    <p class="text-2xl font-bold text-gray-800"></p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-sm text-gray-500">Maintenance</p>
                    {{ $maintenance }}
                    <p class="text-2xl font-bold text-gray-800"></p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-tools text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-red-500">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-sm text-gray-500">Overdue PMS</p>
                    {{ $pms_overdue }}
                    <p class="text-2xl font-bold text-gray-800"></p>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-sm text-gray-500">Client Name</p>
                    {{ $client_detail->client_name }}
                    <p class="text-2xl font-bold text-gray-800"></p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-blue-600 text-xl"></i>
                </div>
            </div>
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

    <!-- Search and Filters -->
    <form method="GET" action="" id="filter-form" class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search by name, model, or serial..." 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-10">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    <option value="Operational" {{ request('status') == 'Operational' ? 'selected' : '' }}>Operational</option>
                    <option value="Maintenance" {{ request('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="Standby" {{ request('status') == 'Standby' ? 'selected' : '' }}>Standby</option>
                    <option value="Not Operational" {{ request('status') == 'Not Operational' ? 'selected' : '' }}>Not Operational</option>
                </select>
            </div>
       
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">PMS Due</label>
                <select name="pms_due" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Any Time</option>
                    <option value="Next 7 Days" {{ request('pms_due') == 'Next 7 Days' ? 'selected' : '' }}>Next 7 Days</option>
                    <option value="Next 30 Days" {{ request('pms_due') == 'Next 30 Days' ? 'selected' : '' }}>Next 30 Days</option>
                    <option value="Overdue" {{ request('pms_due') == 'Overdue' ? 'selected' : '' }}>Overdue</option>
                </select>
            </div>
            
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                    Apply Filters
                </button>
                <a href="" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
                    Clear
                </a>
            </div>
        </div>
    </form>

    <!-- View Toggle -->
    <div class="flex justify-between items-center mb-4">
        {{-- <p class="text-sm text-gray-600">
            Showing <span class="font-semibold">{{ $machines->firstItem() ?? 0 }}</span> to 
            <span class="font-semibold">{{ $machines->lastItem() ?? 0 }}</span> of 
            <span class="font-semibold">{{ $machines->total() }}</span> machines
        </p> --}}
        
        <div class="inline-flex rounded-md shadow-sm" role="group">
            <button type="button" id="card-view-btn" class="view-toggle px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-l-md border border-blue-600 hover:bg-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-500" data-view="card">
                <i class="fas fa-th-large mr-1"></i> Card View
            </button>
            <button type="button" id="table-view-btn" class="view-toggle px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-r-md border border-gray-300 hover:bg-gray-50 focus:z-10 focus:ring-2 focus:ring-blue-500" data-view="table">
                <i class="fas fa-table mr-1"></i> Table View
            </button>
        </div>
    </div>

    @if($machines->count() > 0)
        <!-- Machine Cards View -->
        <div id="card-view" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($machines as $machine)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="relative h-48 bg-gray-200">
                    <img class="w-full h-full object-cover" 
                        src="{{ $machine->image_path ? Storage::url($machine->image_path) : asset('images/machines/default-machine.jpg') }}" 
                        alt="{{ $machine->name }}"
                        onerror="this.onerror=null; this.src='{{ asset('images/machines/default-machine.jpg') }}';">
                    
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full shadow-lg
                            @if($machine->status == 'Operational') bg-green-100 text-green-800
                            @elseif($machine->status == 'Maintenance') bg-yellow-100 text-yellow-800
                            @elseif($machine->status == 'Standby') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $machine->status }}
                        </span>
                    </div>
                    
                    <!-- PMS Status Indicator -->
                    <div class="absolute bottom-4 left-4">
                        <div class="flex items-center space-x-1">
                            @if($machine->next_service_date)
                                @if($machine->next_service_date->isPast())
                                    <span class="flex h-3 w-3">
                                        <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                    </span>
                                    <span class="text-xs font-medium text-white bg-red-600 px-2 py-1 rounded">Overdue</span>
                                @elseif($machine->next_service_date->diffInDays(now()) <= 7)
                                    <span class="flex h-3 w-3">
                                        <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-yellow-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
                                    </span>
                                    <span class="text-xs font-medium text-white bg-yellow-600 px-2 py-1 rounded">Due Soon</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $machine->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $machine->model }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-barcode text-gray-400 w-5"></i>
                            <span class="text-gray-600">SN: {{ $machine->serial_number }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-map-pin text-gray-400 w-5"></i>
                            <span class="text-gray-600">{{ $machine->city }}, {{ $machine->region }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-calendar-check text-gray-400 w-5"></i>
                            <span class="text-gray-600">Last: {{ $machine->last_service_date ? $machine->last_service_date->format('M d, Y') : 'Never' }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-calendar-alt text-gray-400 w-5"></i>
                            <span class="text-gray-600">Next: 
                                @if($machine->next_service_date)
                                    <span class="@if($machine->next_service_date->isPast()) text-red-600 font-semibold
                                        @elseif($machine->next_service_date->diffInDays(now()) <= 7) text-yellow-600 font-semibold
                                        @else text-green-600 @endif">
                                        {{ $machine->next_service_date->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">Not scheduled</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between pt-2 border-t border-gray-100">
                        <button type="button" 
                                class="text-blue-600 hover:text-blue-900 text-sm font-medium view-details" 
                                data-machine-id="{{ $machine->id }}">
                            <i class="fas fa-eye mr-1"></i> View Details
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Table View (Hidden by default) -->
        <div id="table-view" class="bg-white shadow rounded-lg overflow-hidden hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Machine</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Service</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Next PMS</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($machines as $machine)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-lg object-cover" 
                                        src="{{ $machine->image_path ? Storage::url($machine->image_path) : asset('images/machines/default-machine.jpg') }}" 
                                        alt=""
                                        onerror="this.onerror=null; this.src='{{ asset('images/machines/default-machine.jpg') }}';">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $machine->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $machine->model }}</div>
                                    <div class="text-xs text-gray-400">SN: {{ $machine->serial_number }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $machine->city }}</div>
                            <div class="text-sm text-gray-500">{{ $machine->region }}</div>
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
                            {{ $machine->last_service_date ? $machine->last_service_date->format('M d, Y') : 'Never' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($machine->next_service_date)
                                <span class="text-sm 
                                    @if($machine->next_service_date->isPast()) text-red-600 font-semibold
                                    @elseif($machine->next_service_date->diffInDays(now()) <= 7) text-yellow-600 font-semibold
                                    @else text-green-600 @endif">
                                    {{ $machine->next_service_date->format('M d, Y') }}
                                </span>
                                @if($machine->next_service_date->isPast())
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        Overdue
                                    </span>
                                @elseif($machine->next_service_date->diffInDays(now()) <= 7)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Due Soon
                                    </span>
                                @endif
                            @else
                                <span class="text-gray-400">Not scheduled</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button type="button" 
                                    class="text-blue-600 hover:text-blue-900 mr-3 view-details" 
                                    data-machine-id="{{ $machine->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <a href="" 
                               class="text-gray-600 hover:text-gray-900">
                                <i class="fas fa-history"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $machines->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="text-gray-400 text-6xl mb-4">
                <i class="fas fa-tools"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No machines found</h3>
            <p class="text-gray-500 mb-4">
                @if(request()->hasAny(['status', 'search', 'pms_due']))
                    No machines match your current filter criteria. Try adjusting your filters.
                @else
                    There are no machines registered for your location yet.
                @endif
            </p>
            @if(request()->hasAny(['status', 'search', 'pms_due']))
                <a href="{{ route('client.landing') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-600 bg-blue-100 hover:bg-blue-200">
                    <i class="fas fa-times mr-2"></i> Clear Filters
                </a>
            @endif
        </div>
    @endif
</div>

<!-- Details Modal -->
<div id="details-modal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Machine Details
                    </h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500 close-modal">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="mt-2">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Machine Image -->
                        <div>
                            <img id="modal-image" class="w-full h-64 object-cover rounded-lg" src="" alt="Machine Image">
                        </div>
                        
                        <!-- Machine Details -->
                        <div class="space-y-4">
                            <div>
                                <h4 id="modal-name" class="text-xl font-bold text-gray-900"></h4>
                                <p id="modal-model" class="text-gray-600"></p>
                                <p class="text-sm text-gray-500">Serial: <span id="modal-serial"></span></p>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500">Status</p>
                                    <span id="modal-status" class="px-2 py-1 text-xs font-semibold rounded-full"></span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Location</p>
                                    <p id="modal-location" class="text-sm"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Installation Date</p>
                                    <p id="modal-installation" class="text-sm"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 hidden">Service Interval</p>
                                    <p id="modal-interval" class="text-sm hidden"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Last Service</p>
                                    <p id="modal-last-service" class="text-sm"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Next Service</p>
                                    <p id="modal-next-service" class="text-sm"></p>
                                </div>
                            </div>
                            
                            <div>
                                <p class="text-xs text-gray-500 mb-2">Description</p>
                                <p id="modal-description" class="text-sm text-gray-700"></p>
                            </div>
                            
                            <!-- Recent Service Records -->
                            <div>
                                <p class="text-xs text-gray-500 mb-2">Recent Service History</p>
                                <div id="modal-service-history" class="space-y-2">
                                    <!-- Will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="close-modal w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Spinner -->
<div id="loading-spinner" class="hidden fixed z-50 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg p-6 shadow-xl">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
            <p class="mt-2 text-gray-600">Loading...</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // View Toggle Functionality
    const viewToggleBtns = document.querySelectorAll('.view-toggle');
    const cardView = document.getElementById('card-view');
    const tableView = document.getElementById('table-view');
    
    // Load saved view preference
    const savedView = localStorage.getItem('clientViewPreference') || 'card';
    setActiveView(savedView);
    
    viewToggleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const view = this.dataset.view;
            setActiveView(view);
            localStorage.setItem('clientViewPreference', view);
        });
    });
    
    function setActiveView(view) {
        // Update button styles
        viewToggleBtns.forEach(btn => {
            if (btn.dataset.view === view) {
                btn.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
                btn.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
            } else {
                btn.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
                btn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
            }
        });
        
        // Show/hide views
        if (view === 'card') {
            cardView.classList.remove('hidden');
            tableView.classList.add('hidden');
        } else {
            cardView.classList.add('hidden');
            tableView.classList.remove('hidden');
        }
    }
    
    // Machine Details Modal
    const modal = document.getElementById('details-modal');
    const spinner = document.getElementById('loading-spinner');
    const viewDetailsBtns = document.querySelectorAll('.view-details');
    const closeBtns = document.querySelectorAll('.close-modal');
    
    viewDetailsBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const machineId = this.dataset.machineId;
            fetchMachineDetails(machineId);
        });
    });
    
    closeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
    });
    
    // Close modal on outside click
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });
    
    // Fetch machine details via AJAX
    function fetchMachineDetails(machineId) {
        // Show spinner
        spinner.classList.remove('hidden');
        
        fetch(`/client/machines/${machineId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(machine => {
            // Populate modal with machine data
            document.getElementById('modal-name').textContent = machine.name || '-';
            document.getElementById('modal-model').textContent = machine.model || '-';
            document.getElementById('modal-serial').textContent = machine.serial_number || '-';
            
            // Set image
            const imageUrl = machine.image_path 
                ? `/storage/${machine.image_path}` 
                : '/images/machines/default-machine.jpg';
            document.getElementById('modal-image').src = imageUrl;
            
            // Set status with proper styling
            const statusSpan = document.getElementById('modal-status');
            statusSpan.textContent = machine.status || '-';
            statusSpan.className = `px-2 py-1 text-xs font-semibold rounded-full ${
                machine.status === 'Operational' ? 'bg-green-100 text-green-800' :
                machine.status === 'Maintenance' ? 'bg-yellow-100 text-yellow-800' :
                machine.status === 'Standby' ? 'bg-blue-100 text-blue-800' :
                'bg-red-100 text-red-800'
            }`;
            
            // Location details
            document.getElementById('modal-location').textContent = 
                `${machine.city || '-'}, ${machine.region || '-'}`;
            
            // Dates
            document.getElementById('modal-installation').textContent = 
                machine.installation_date ? new Date(machine.installation_date).toLocaleDateString('en-US', {
                    year: 'numeric', month: 'short', day: 'numeric'
                }) : '-';
            
            document.getElementById('modal-last-service').textContent = 
                machine.last_service_date ? new Date(machine.last_service_date).toLocaleDateString('en-US', {
                    year: 'numeric', month: 'short', day: 'numeric'
                }) : 'Never';
            
            document.getElementById('modal-next-service').textContent = 
                machine.next_service_date ? new Date(machine.next_service_date).toLocaleDateString('en-US', {
                    year: 'numeric', month: 'short', day: 'numeric'
                }) : 'Not scheduled';
            
            // Service interval
            document.getElementById('modal-interval').textContent = 
                machine.service_interval_days ? `${machine.service_interval_days} days` : '-';
            
            // Description
            document.getElementById('modal-description').textContent = 
                machine.description || 'No description available.';
            
            // Service history
            const serviceHistory = document.getElementById('modal-service-history');
            if (machine.recent_service_records && machine.recent_service_records.length > 0) {
                let historyHtml = '';
                machine.recent_service_records.forEach(record => {
                    historyHtml += `
                        <div class="flex justify-between items-center text-sm border-b border-gray-100 pb-1">
                            <span class="text-gray-600">${new Date(record.service_date).toLocaleDateString()}</span>
                            <span class="text-gray-900">${record.description || 'Service performed'}</span>
                        </div>
                    `;
                });
                serviceHistory.innerHTML = historyHtml;
            } else {
                serviceHistory.innerHTML = '<p class="text-sm text-gray-500">No service history available.</p>';
            }
            
            // Hide spinner and show modal
            spinner.classList.add('hidden');
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            spinner.classList.add('hidden');
            alert('Failed to load machine details. Please try again.');
        });
    }
    
    // Auto-submit form on filter change (optional)
    const filterSelects = document.querySelectorAll('#filter-form select');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
    });
});
</script>

<style>
/* Modal animations */
#details-modal {
    transition: opacity 0.3s ease;
}

#details-modal.hidden {
    display: none;
}

#details-modal:not(.hidden) {
    display: block;
}

/* Loading spinner animation */
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

/* Card hover effects */
.bg-white {
    transition: all 0.3s ease;
}

/* Status indicator animations */
.animate-ping {
    animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
}

@keyframes ping {
    75%, 100% {
        transform: scale(2);
        opacity: 0;
    }
}

/* Responsive adjustments */
@media (max-width: 640px) {
    #details-modal .sm:flex {
        flex-direction: column;
    }
    
    #details-modal .sm:flex > * {
        margin-left: 0;
        margin-top: 0.5rem;
    }
}
</style>

@endsection