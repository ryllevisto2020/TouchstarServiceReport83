@extends('layouts.client')

@section('title', 'TouchStar Medical Enterprises - Service Report History')

@section('content')
<main class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section with Client Info -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Service Reports</h1>
                <p class="text-gray-600 mt-1">{{ $user->client_name }} - Complete service history and maintenance records</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="exportReports()" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-download mr-2"></i>
                    Export CSV
                </button>
                <button onclick="printReports()" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-print mr-2"></i>
                    Print Reports
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-clipboard-list text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Services</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">This Month</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['monthly'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-user-cog text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Service Engineers</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['engineers'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Avg. Response</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['avg_resolution'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
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

    <!-- Advanced Filters -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Filter Service Reports</h3>
        </div>
        <form method="GET" action="{{ route('client.service.history') }}" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Serial Number Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Serial Number</label>
                    <select name="serial_number" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Serial Numbers</option>
                        @foreach($serialNumbers as $serial)
                            <option value="{{ $serial }}" {{ request('serial_number') == $serial ? 'selected' : '' }}>
                                {{ $serial }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Service Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Service Type</label>
                    <select name="service_type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Types</option>
                        <option value="PMS" {{ request('service_type') == 'PMS' ? 'selected' : '' }}>Preventive Maintenance</option>
                        <option value="Troubleshooting" {{ request('service_type') == 'Troubleshooting' ? 'selected' : '' }}>Troubleshooting</option>
                        <option value="Installation" {{ request('service_type') == 'Installation' ? 'selected' : '' }}>Installation</option>
                        <option value="Warranty" {{ request('service_type') == 'Warranty' ? 'selected' : '' }}>Warranty</option>
                        <option value="Calibration" {{ request('service_type') == 'Calibration' ? 'selected' : '' }}>Calibration</option>
                    </select>
                </div>

                <!-- Service Engineer Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Service Engineer</label>
                    <select name="service_engineer" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Engineers</option>
                        @foreach($engineers as $engineer)
                            <option value="{{ $engineer }}" {{ request('service_engineer') == $engineer ? 'selected' : '' }}>
                                {{ $engineer }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Equipment Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Equipment Status</label>
                    <select name="equipment_status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="Operational" {{ request('equipment_status') == 'Operational' ? 'selected' : '' }}>Operational</option>
                        <option value="Not Operational" {{ request('equipment_status') == 'Not Operational' ? 'selected' : '' }}>Not Operational</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <!-- Problem Search -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Problem Description</label>
                <input type="text" name="problem" value="{{ request('problem') }}"
                    placeholder="Search in issues, root cause, actions taken..."
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Filter Actions -->
            <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                <div class="text-sm text-gray-500">
                    Showing {{ $serviceRecords->firstItem() ?? 0 }} to {{ $serviceRecords->lastItem() ?? 0 }} of {{ $serviceRecords->total() }} results
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('client.service.history') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                        <i class="fas fa-undo mr-2"></i>
                        Reset Filters
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-filter mr-2"></i>
                        Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Service Records Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Service Records</h3>
        </div>

        @if($serviceRecords->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Machine</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Engineer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($serviceRecords as $record)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $record->service_date ? $record->service_date->format('M d, Y') : 'N/A' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $record->service_date ? $record->service_date->format('g:i A') : '' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-lg object-cover border" 
                                                 src="{{ $record->machine && $record->machine->image_path ? Storage::url($record->machine->image_path) : asset('images/machines/default-machine.jpg') }}" 
                                                 alt="">
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $record->machine->name ?? 'Deleted Machine' }}</div>
                                            <div class="text-xs text-gray-500">SN: {{ $record->machine->serial_number ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $record->service_type_display }}</div>
                                    @if($record->service_images && count($record->service_images) > 0)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-blue-100 text-blue-800 mt-1">
                                            <i class="fas fa-camera mr-1"></i>
                                            {{ count($record->service_images) }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $record->service_engineer ?: 'N/A' }}</div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $record->equipment_status == 'Operational' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $record->equipment_status ?: 'Unknown' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex space-x-3">
                                        <button onclick="viewServiceDetails({{ $record->id }})" 
                                                class="text-blue-600 hover:text-blue-900 text-sm" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="printServiceReport({{ $record->id }})" 
                                                class="text-green-600 hover:text-green-900 text-sm" title="Print Report">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-white px-6 py-3 border-t border-gray-200">
                {{ $serviceRecords->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Service Records Found</h3>
                <p class="text-gray-500">
                    @if(request()->hasAny(['serial_number', 'service_type', 'date_from', 'date_to', 'service_engineer', 'equipment_status', 'problem']))
                        No service records match your current filter criteria.
                    @else
                        No service records have been created for your location yet.
                    @endif
                </p>
                @if(request()->hasAny(['serial_number', 'service_type', 'date_from', 'date_to', 'service_engineer', 'equipment_status', 'problem']))
                    <a href="{{ route('client.service.history') }}" class="inline-flex items-center px-4 py-2 mt-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-times mr-2"></i> Clear Filters
                    </a>
                @endif
            </div>
        @endif
    </div>
</main>

<!-- Details Modal -->
<div id="service-details-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Service Report Details</h3>
            <button onclick="closeServiceDetailsModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div id="service-details-content" class="max-h-[70vh] overflow-y-auto">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="image-modal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center">
    <div class="relative max-w-4xl max-h-screen p-4">
        <button onclick="closeImageModal()" class="absolute top-2 right-2 text-white text-2xl hover:text-gray-300 z-10">
            <i class="fas fa-times"></i>
        </button>
        <img id="modal-full-image" src="" alt="Full size image" class="max-w-full max-h-screen object-contain">
    </div>
</div>

<!-- Loading Spinner -->
<div id="loading-spinner" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 shadow-xl flex items-center">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mr-3"></div>
        <span class="text-gray-700">Loading...</span>
    </div>
</div>

@push('styles')
<style>
    /* Modal animations */
    #service-details-modal, #image-modal {
        transition: opacity 0.3s ease;
    }
    
    #service-details-modal.hidden, #image-modal.hidden {
        display: none;
    }
    
    #service-details-modal:not(.hidden), #image-modal:not(.hidden) {
        display: block;
    }
    
    #image-modal:not(.hidden) {
        display: flex;
    }
    
    /* Custom scrollbar */
    .overflow-y-auto::-webkit-scrollbar {
        width: 8px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    
    /* Table hover effect */
    tbody tr {
        transition: background-color 0.2s ease;
    }
    
    /* Print styles */
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Service Details Modal Functions
function viewServiceDetails(recordId) {
    // Show loading state
    document.getElementById('loading-spinner').classList.remove('hidden');
    
    const modalContent = document.getElementById('service-details-content');
    modalContent.innerHTML = '';

    fetch(`/client/service-report/${recordId}/details`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        document.getElementById('loading-spinner').classList.add('hidden');
        
        if (data.success) {
            document.getElementById('service-details-content').innerHTML = data.html;
            document.getElementById('service-details-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        } else {
            throw new Error(data.message || 'Failed to load service details');
        }
    })
    .catch(error => {
        document.getElementById('loading-spinner').classList.add('hidden');
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Something went wrong while loading details'
        });
    });
}

function closeServiceDetailsModal() {
    document.getElementById('service-details-modal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Image Modal Functions
function openImageModal(imageUrl) {
    document.getElementById('modal-full-image').src = imageUrl;
    document.getElementById('image-modal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeImageModal() {
    document.getElementById('image-modal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Print Functions
function printServiceReport(recordId) {
    Swal.fire({
        title: 'Generating Report',
        text: 'Please wait while we prepare the print view...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch(`/client/service-report/${recordId}/print`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        Swal.close();
        if (data.success) {
            const printWindow = window.open('', '_blank', 'width=1200,height=800,scrollbars=yes');
            printWindow.document.write(data.print_html);
            printWindow.document.close();
            
            printWindow.onload = function() {
                printWindow.print();
            };
        } else {
            throw new Error(data.message || 'Failed to generate print view');
        }
    })
    .catch(error => {
        Swal.close();
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Print Error',
            text: error.message || 'Something went wrong while printing'
        });
    });
}

function printReports() {
    const params = new URLSearchParams(window.location.search);
    
    Swal.fire({
        title: 'Generating Reports',
        text: 'Please wait while we prepare all reports...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch(`/client/service-report/print?${params.toString()}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        Swal.close();
        if (data.success) {
            const printWindow = window.open('', '_blank', 'width=1200,height=800,scrollbars=yes');
            printWindow.document.write(data.print_html);
            printWindow.document.close();
            
            printWindow.onload = function() {
                printWindow.print();
            };
        } else {
            throw new Error(data.message || 'Failed to generate print view');
        }
    })
    .catch(error => {
        Swal.close();
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Print Error',
            text: error.message || 'Something went wrong while printing'
        });
    });
}

function exportReports() {
    const params = new URLSearchParams(window.location.search);
    window.location.href = `/client/service-report/export?${params.toString()}`;
}

// Close modals when clicking outside
document.getElementById('service-details-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeServiceDetailsModal();
    }
});

document.getElementById('image-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeServiceDetailsModal();
        closeImageModal();
    }
});

// Auto-submit form on select change (optional - uncomment if desired)
/*
document.querySelectorAll('select[name]').forEach(select => {
    select.addEventListener('change', function() {
        this.form.submit();
    });
});
*/
</script>
@endpush

@endsection