@push('scripts')
<script>
// SAMPLE PENDING SERVICE DATA - Replace with your actual database data
let pendingServices = [
    {
        id: 'pending_001',
        machine_id: 1,
        machine_name: 'Siemens X-Ray Machine',
        serial_number: 'XR-2024-001',
        model: 'Siemens Multix',
        location: 'Manila General Hospital',
        client_name: 'Manila General Hospital',
        created_at: '2024-01-15T09:30:00',
        last_updated: '2024-01-15T14:20:00',
        status: 'draft',
        service_type: ['PMS', 'Calibration'],
        identification: 'Unit showing intermittent display issues',
        root_cause: 'Loose connection on main board',
        action_taken: 'Reseated connectors and updated firmware',
        equipment_status: 'Operational',
        recommendations: 'Schedule quarterly maintenance',
        approved_by: 'Dr. Juan Santos',
        medtech_signature: null,
        parts: [
            { qty: 1, particulars: 'Display Cable', si_dr_no: 'SI-2024-001' }
        ]
    },
    {
        id: 'pending_002',
        machine_id: 2,
        machine_name: 'Philips Ultrasound',
        serial_number: 'US-2024-045',
        model: 'Philips EPIQ 7',
        location: 'Cebu Medical Center',
        client_name: 'Cebu Medical Center',
        created_at: '2024-01-16T10:15:00',
        last_updated: '2024-01-16T11:45:00',
        status: 'draft',
        service_type: ['Troubleshooting'],
        identification: 'Probe not detected by system',
        root_cause: 'Faulty probe connector',
        action_taken: 'Replaced probe connector assembly',
        equipment_status: 'Operational',
        recommendations: 'Monitor probe performance weekly',
        approved_by: 'Dr. Maria Reyes',
        medtech_signature: null,
        parts: [
            { qty: 1, particulars: 'Probe Connector', si_dr_no: 'DR-2024-089' }
        ]
    },
    {
        id: 'pending_003',
        machine_id: 3,
        machine_name: 'GE Ventilator',
        serial_number: 'VENT-2024-123',
        model: 'GE CARESCAPE R860',
        location: 'Davao Doctors Hospital',
        client_name: 'Davao Doctors Hospital',
        created_at: '2024-01-16T13:00:00',
        last_updated: '2024-01-16T15:30:00',
        status: 'draft',
        service_type: ['Maintenance', 'Calibration'],
        identification: 'Oxygen sensor calibration drift',
        root_cause: 'Sensor老化',
        action_taken: 'Replaced oxygen sensor and recalibrated',
        equipment_status: 'Operational',
        recommendations: 'Replace sensor every 6 months',
        approved_by: 'Dr. Antonio Cruz',
        medtech_signature: null,
        parts: [
            { qty: 1, particulars: 'Oxygen Sensor', si_dr_no: 'SI-2024-056' },
            { qty: 2, particulars: 'Filter Kit', si_dr_no: 'SI-2024-056' }
        ]
    },
    {
        id: 'pending_004',
        machine_id: 4,
        machine_name: 'Mindray Patient Monitor',
        serial_number: 'PM-2024-789',
        model: 'Mindray uMEC12',
        location: 'St. Lukes Medical Center',
        client_name: 'St. Lukes Medical Center',
        created_at: '2024-01-17T08:45:00',
        last_updated: '2024-01-17T10:20:00',
        status: 'draft',
        service_type: ['Installation'],
        identification: 'New unit installation and setup',
        root_cause: 'Initial deployment',
        action_taken: 'Installed, configured network, and tested all parameters',
        equipment_status: 'Operational',
        recommendations: 'Train staff on proper usage',
        approved_by: 'Dr. Robert Lim',
        medtech_signature: null,
        parts: []
    },
    {
        id: 'pending_005',
        machine_id: 5,
        machine_name: 'B Braun Dialysis Machine',
        serial_number: 'DIA-2024-234',
        model: 'B Braun Dialog+',
        location: 'National Kidney Institute',
        client_name: 'National Kidney Institute',
        created_at: '2024-01-17T14:30:00',
        last_updated: '2024-01-17T16:15:00',
        status: 'draft',
        service_type: ['Troubleshooting', 'PMS'],
        identification: 'Flow rate error during dialysis',
        root_cause: 'Clogged filter in fluid path',
        action_taken: 'Cleaned filter system and replaced tubing',
        equipment_status: 'Operational',
        recommendations: 'Replace filter every 3 months',
        approved_by: 'Dr. Cristina Fernandez',
        medtech_signature: null,
        parts: [
            { qty: 1, particulars: 'Filter Assembly', si_dr_no: 'DR-2024-112' },
            { qty: 2, particulars: 'Tubing Set', si_dr_no: 'DR-2024-112' }
        ]
    },
    {
        id: 'pending_006',
        machine_id: 6,
        machine_name: 'Drager Anesthesia Machine',
        serial_number: 'AN-2024-567',
        model: 'Drager Perseus A500',
        location: 'Philippine Heart Center',
        client_name: 'Philippine Heart Center',
        created_at: '2024-01-18T09:00:00',
        last_updated: '2024-01-18T11:30:00',
        status: 'draft',
        service_type: ['Calibration'],
        identification: 'Vaporizer output inaccurate',
        root_cause: 'Calibration out of spec',
        action_taken: 'Recalibrated vaporizer and tested',
        equipment_status: 'Operational',
        recommendations: 'Annual calibration required',
        approved_by: 'Dr. Manuel Santos',
        medtech_signature: null,
        parts: []
    }
];

// Function to load pending services (from localStorage + sample data)
function loadPendingServices() {
    // Load from localStorage drafts
    const localStorageDrafts = [];
    for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        if (key && key.startsWith('serviceDraft_')) {
            try {
                const draft = JSON.parse(localStorage.getItem(key));
                localStorageDrafts.push({
                    id: key.replace('serviceDraft_', ''),
                    machine_id: draft.machine_id || 'unknown',
                    machine_name: draft.machine_name || 'Unknown Machine',
                    serial_number: draft.serial_number || 'N/A',
                    model: draft.model || 'N/A',
                    location: draft.location || 'N/A',
                    client_name: draft.client_name || 'N/A',
                    created_at: draft.created_at || new Date().toISOString(),
                    last_updated: draft.last_updated || new Date().toISOString(),
                    status: 'draft',
                    service_type: draft.service_type || [],
                    identification: draft.identification || '',
                    root_cause: draft.root_cause || '',
                    action_taken: draft.action_taken || '',
                    equipment_status: draft.equipment_status || '',
                    recommendations: draft.recommendations || '',
                    approved_by: draft.approved_by || '',
                    medtech_signature: draft.medtech_signature || null,
                    parts: draft.parts || []
                });
            } catch(e) {
                console.error('Error loading draft:', e);
            }
        }
    }
    
    // Merge sample data with localStorage drafts (avoid duplicates)
    const allDrafts = [...pendingServices];
    
    localStorageDrafts.forEach(localDraft => {
        const exists = allDrafts.some(d => d.id === localDraft.id);
        if (!exists) {
            allDrafts.unshift(localDraft);
        }
    });
    
    pendingServices = allDrafts;
    updatePendingBadge();
    renderPendingTable();
}

// Update floating button badge
function updatePendingBadge() {
    const badge = document.getElementById('pending-badge');
    const countSpan = document.getElementById('pending-count');
    if (badge) {
        const count = pendingServices.length;
        badge.textContent = count;
        badge.classList.toggle('hidden', count === 0);
    }
    if (countSpan) {
        countSpan.textContent = pendingServices.length;
    }
}

// Delete a pending service
function deletePendingService(serviceId) {
    Swal.fire({
        title: 'Delete Draft?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Remove from localStorage if exists
            localStorage.removeItem(`serviceDraft_${serviceId}`);
            
            // Remove from pendingServices array
            pendingServices = pendingServices.filter(s => s.id !== serviceId);
            
            // Re-render
            updatePendingBadge();
            renderPendingTable();
            
            Swal.fire('Deleted!', 'Draft has been deleted.', 'success');
        }
    });
}

// View pending service details
function viewPendingDetails(serviceId) {
    const service = pendingServices.find(s => s.id === serviceId);
    if (!service) return;
    
    let detailsHtml = `
        <div class="space-y-3 text-left">
            <div class="border-b pb-2">
                <p class="text-xs text-gray-500">Machine</p>
                <p class="font-medium">${escapeHtml(service.machine_name)}</p>
                <p class="text-sm text-gray-600">SN: ${escapeHtml(service.serial_number)} | ${escapeHtml(service.model)}</p>
            </div>
            <div class="border-b pb-2">
                <p class="text-xs text-gray-500">Client / Location</p>
                <p class="font-medium">${escapeHtml(service.client_name)}</p>
                <p class="text-sm text-gray-600">${escapeHtml(service.location)}</p>
            </div>
            <div class="border-b pb-2">
                <p class="text-xs text-gray-500">Service Type</p>
                <div class="flex gap-1 flex-wrap mt-1">
                    ${service.service_type.map(t => `<span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs">${t}</span>`).join('')}
                </div>
            </div>
            <div class="border-b pb-2">
                <p class="text-xs text-gray-500">Identification/Verification</p>
                <p class="text-sm">${escapeHtml(service.identification) || 'N/A'}</p>
            </div>
            <div class="border-b pb-2">
                <p class="text-xs text-gray-500">Root Cause/Findings</p>
                <p class="text-sm">${escapeHtml(service.root_cause) || 'N/A'}</p>
            </div>
            <div class="border-b pb-2">
                <p class="text-xs text-gray-500">Action Taken</p>
                <p class="text-sm">${escapeHtml(service.action_taken) || 'N/A'}</p>
            </div>
            <div class="border-b pb-2">
                <p class="text-xs text-gray-500">Equipment Status</p>
                <p class="text-sm font-semibold ${service.equipment_status === 'Operational' ? 'text-green-600' : 'text-red-600'}">${service.equipment_status || 'N/A'}</p>
            </div>
            ${service.parts && service.parts.length > 0 ? `
            <div>
                <p class="text-xs text-gray-500">Parts Replaced</p>
                <div class="text-sm space-y-1 mt-1">
                    ${service.parts.map(p => `<div class="flex gap-2"><span class="font-medium">${p.qty}x</span> ${p.particulars} <span class="text-gray-400">(${p.si_dr_no})</span></div>`).join('')}
                </div>
            </div>
            ` : ''}
            <div class="pt-2 text-xs text-gray-400">
                Created: ${formatDate(service.created_at)}
                ${service.last_updated ? `<br>Last updated: ${formatDate(service.last_updated)}` : ''}
            </div>
        </div>
    `;
    
    Swal.fire({
        title: 'Service Draft Details',
        html: detailsHtml,
        icon: 'info',
        width: '500px',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-edit mr-1"></i> Edit',
        cancelButtonText: 'Close',
        confirmButtonColor: '#3b82f6'
    }).then((result) => {
        if (result.isConfirmed) {
            editPendingService(serviceId);
        }
    });
}

// Render the pending table
function renderPendingTable() {
    const tbody = document.getElementById('pending-table-body');
    if (!tbody) return;
    
    if (pendingServices.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-12 text-gray-400">
                    <i class="fas fa-inbox text-4xl mb-3 block"></i>
                    <p class="text-sm">No pending services found</p>
                    <p class="text-xs mt-1">Drafts you save will appear here</p>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = pendingServices.map(service => `
        <tr class="border-b border-gray-100 hover:bg-amber-50 transition-colors group">
            <td class="px-3 py-3">
                <div class="font-medium text-gray-800 text-sm flex items-center gap-2">
                    <i class="fas fa-microscope text-amber-500 text-xs"></i>
                    ${escapeHtml(service.machine_name)}
                </div>
                <div class="text-xs text-gray-400 mt-0.5">
                    SN: ${escapeHtml(service.serial_number)} | ${escapeHtml(service.model)}
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>${escapeHtml(service.location)}
                </div>
            </td>
            <td class="px-3 py-3 text-sm text-gray-500 whitespace-nowrap">
                <div>${formatDate(service.created_at)}</div>
                <div class="text-xs text-gray-400 mt-0.5">${getRelativeTime(service.created_at)}</div>
            </td>
            <td class="px-3 py-3">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                    <i class="fas fa-pen-fancy mr-1 text-10"></i> Draft
                </span>
                <div class="text-xs text-gray-400 mt-1">
                    <i class="far fa-clock mr-1"></i>${service.service_type?.slice(0,2).join(', ')}${service.service_type?.length > 2 ? '...' : ''}
                </div>
            </td>
            <td class="px-3 py-3">
                <div class="flex gap-1 flex-wrap">
                    <button onclick="viewPendingDetails('${service.id}')" 
                            class="px-2.5 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
                            title="View Details">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button onclick="editPendingService('${service.id}')" 
                            class="px-2.5 py-1.5 text-xs font-medium text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                            title="Edit Draft">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button onclick="submitPendingService('${service.id}')" 
                            class="px-2.5 py-1.5 text-xs font-medium text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                            title="Submit Service">
                        <i class="fas fa-check-circle"></i> Submit
                    </button>
                    <button onclick="deletePendingService('${service.id}')" 
                            class="px-2.5 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                            title="Delete Draft">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

// Helper: Get relative time (e.g., "2 hours ago")
function getRelativeTime(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffMs = now - date;
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMs / 3600000);
    const diffDays = Math.floor(diffMs / 86400000);
    
    if (diffMins < 1) return 'Just now';
    if (diffMins < 60) return `${diffMins} minute${diffMins > 1 ? 's' : ''} ago`;
    if (diffHours < 24) return `${diffHours} hour${diffHours > 1 ? 's' : ''} ago`;
    return `${diffDays} day${diffDays > 1 ? 's' : ''} ago`;
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' });
}

function editPendingService(draftId) {
    const service = pendingServices.find(s => s.id === draftId);
    if (service) {
        populateServiceForm(service);
        closePendingModal();
        if (typeof openModal === 'function') {
            openModal(service.machine_id);
        }
    } else {
        // Try localStorage as fallback
        const draft = localStorage.getItem(`serviceDraft_${draftId}`);
        if (draft) {
            const data = JSON.parse(draft);
            populateServiceForm(data);
            closePendingModal();
            if (typeof openModal === 'function') {
                openModal(data.machine_id);
            }
        }
    }
}

function submitPendingService(draftId) {
    const service = pendingServices.find(s => s.id === draftId);
    if (service) {
        populateServiceForm(service);
        closePendingModal();
        if (typeof openModal === 'function') {
            openModal(service.machine_id);
        }
        // setTimeout(() => {
        //     const submitBtn = document.getElementById('submit-service-btn');
        //     if (submitBtn) {
        //         // Highlight the submit button briefly
        //         submitBtn.style.transform = 'scale(1.05)';
        //         setTimeout(() => { submitBtn.style.transform = ''; }, 200);
        //         submitBtn.click();
        //     }
        // }, 500);
    } else {
        // Try localStorage as fallback
        const draft = localStorage.getItem(`serviceDraft_${draftId}`);
        if (draft) {
            const data = JSON.parse(draft);
            populateServiceForm(data);
            closePendingModal();
            if (typeof openModal === 'function') {
                openModal(data.machine_id);
            }
            setTimeout(() => {
                const submitBtn = document.getElementById('submit-service-btn');
                if (submitBtn) submitBtn.click();
            }, 500);
        }
    }
}

function populateServiceForm(data) {
    // Populate machine ID
    const machineIdField = document.getElementById('machine-id');
    if (machineIdField && data.machine_id) machineIdField.value = data.machine_id;
    
    // Service types
    if (data.service_type && Array.isArray(data.service_type)) {
        document.querySelectorAll('input[name="service_type[]"]').forEach(cb => {
            cb.checked = data.service_type.includes(cb.value);
        });
        if (data.service_type.includes('others_specified') && data.others_specified) {
            const othersCheckbox = document.getElementById('others-checkbox');
            if (othersCheckbox) othersCheckbox.checked = true;
            const othersInputDiv = document.getElementById('others-input');
            if (othersInputDiv) othersInputDiv.classList.remove('hidden');
            const othersInput = document.querySelector('#others-input input');
            if (othersInput) othersInput.value = data.others_specified;
        }
    }
    
    // Textareas
    const fields = ['identification', 'root_cause', 'action_taken', 'recommendations'];
    fields.forEach(field => {
        const el = document.querySelector(`textarea[name="${field}"]`);
        if (el && data[field]) el.value = data[field];
    });
    
    // Equipment status
    if (data.equipment_status) {
        const radio = document.querySelector(`input[name="equipment_status"][value="${data.equipment_status}"]`);
        if (radio) radio.checked = true;
    }
    
    // Signature
    if (data.medtech_signature) {
        const signatureData = document.getElementById('signature-data');
        if (signatureData) signatureData.value = data.medtech_signature;
        const preview = document.getElementById('signature-image');
        if (preview) preview.src = data.medtech_signature;
        document.getElementById('signature-preview')?.classList.remove('hidden');
    }
    
    // Approved by
    const approvedBy = document.querySelector('input[name="approved_by"]');
    if (approvedBy && data.approved_by) approvedBy.value = data.approved_by;
    
    // Parts - clear and repopulate
    const partsContainer = document.getElementById('parts-container');
    if (partsContainer && data.parts && data.parts.length > 0) {
        // Clear existing except first row
        while (partsContainer.children.length > 1) {
            partsContainer.removeChild(partsContainer.lastChild);
        }
        // Populate first row
        const firstRow = partsContainer.querySelector('.parts-row');
        if (firstRow) {
            const firstPart = data.parts[0];
            firstRow.querySelector('.parts-qty').value = firstPart.qty || '';
            firstRow.querySelector('.parts-part').value = firstPart.particulars || '';
            firstRow.querySelector('.parts-si').value = firstPart.si_dr_no || '';
        }
        // Add additional rows
        for (let i = 1; i < data.parts.length; i++) {
            const part = data.parts[i];
            const newRow = document.createElement('div');
            newRow.className = 'parts-row';
            newRow.innerHTML = `
                <input type="number" name="qty[]" placeholder="Qty" class="svc-input parts-qty" value="${part.qty || ''}">
                <input type="text" name="particulars[]" placeholder="Particulars" class="svc-input parts-part" value="${escapeHtml(part.particulars || '')}">
                <input type="text" name="si_dr_no[]" placeholder="S.I./D.R. No." class="svc-input parts-si" value="${escapeHtml(part.si_dr_no || '')}">
            `;
            partsContainer.appendChild(newRow);
        }
    }
}

function togglePendingModal() {
    const modal = document.getElementById('pending-modal');
    if (modal) {
        modal.classList.toggle('hidden');
        if (!modal.classList.contains('hidden')) {
            renderPendingTable();
        }
    }
}

function closePendingModal() {
    const modal = document.getElementById('pending-modal');
    if (modal) modal.classList.add('hidden');
}

// Load on page ready
document.addEventListener('DOMContentLoaded', function() {
    loadPendingServices();
    
    // Close modal when clicking backdrop
    const backdrop = document.getElementById('pending-modal-backdrop');
    if (backdrop) {
        backdrop.addEventListener('click', closePendingModal);
    }
    
    // Escape key to close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePendingModal();
        }
    });
});

// Enhanced save draft function
window.saveDraft = function() {
    const form = document.getElementById('service-form');
    if (form) {
        const formData = new FormData(form);
        const draftData = {};
        
        formData.forEach((value, key) => {
            if (key.includes('[]')) {
                const cleanKey = key.replace('[]', '');
                if (!draftData[cleanKey]) draftData[cleanKey] = [];
                draftData[cleanKey].push(value);
            } else {
                draftData[key] = value;
            }
        });
        
        // Get machine info from the current machine being viewed
        const activeCard = document.querySelector('#card-view .bg-white.border');
        let machineName = 'Unknown Machine';
        let serialNumber = 'N/A';
        let machineModel = 'N/A';
        let clientLocation = 'N/A';
        
        if (activeCard) {
            const nameEl = activeCard.querySelector('.font-bold');
            const serialEl = activeCard.querySelector('.text-gray-400');
            const locationEl = activeCard.querySelector('.text-gray-700');
            
            if (nameEl) machineName = nameEl.innerText;
            if (serialEl) serialNumber = serialEl.innerText.replace('# ', '');
            if (locationEl && locationEl.closest('div')?.previousElementSibling?.innerText === 'Location') {
                clientLocation = locationEl.innerText;
            }
        }
        
        // Add metadata
        draftData.machine_name = machineName;
        draftData.serial_number = serialNumber;
        draftData.model = machineModel;
        draftData.location = clientLocation;
        draftData.client_name = clientLocation;
        draftData.created_at = new Date().toISOString();
        draftData.last_updated = new Date().toISOString();
        draftData.machine_id = document.getElementById('machine-id')?.value || 'unknown';
        
        // Collect parts
        const parts = [];
        const qtyInputs = document.querySelectorAll('.parts-qty');
        const partInputs = document.querySelectorAll('.parts-part');
        const siInputs = document.querySelectorAll('.parts-si');
        
        for (let i = 0; i < qtyInputs.length; i++) {
            if (qtyInputs[i].value || partInputs[i].value) {
                parts.push({
                    qty: qtyInputs[i].value || 0,
                    particulars: partInputs[i].value || '',
                    si_dr_no: siInputs[i].value || ''
                });
            }
        }
        draftData.parts = parts;
        
        const draftId = 'draft_' + Date.now();
        localStorage.setItem(`serviceDraft_${draftId}`, JSON.stringify(draftData));
        
        // Reload pending services
        loadPendingServices();
        
        // Show success message
        Swal.fire({
            title: 'Draft Saved!',
            text: 'Your service report has been saved to pending list.',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        });
    }
};

// Expose functions globally
window.togglePendingModal = togglePendingModal;
window.closePendingModal = closePendingModal;
window.editPendingService = editPendingService;
window.submitPendingService = submitPendingService;
window.deletePendingService = deletePendingService;
window.viewPendingDetails = viewPendingDetails;
</script>
@endpush

<!-- Floating Button - Bottom Right -->
<button onclick="togglePendingModal()" 
        class="fixed bottom-6 right-6 z-40 w-14 h-14 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200 flex items-center justify-center text-white border-0 cursor-pointer group">
    <i class="fas fa-clock text-xl"></i>
    <span id="pending-badge" 
          class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold min-w-[20px] h-5 px-1 rounded-full flex items-center justify-center shadow-md">
        6
    </span>
</button>

<!-- Pending Modal -->
<div id="pending-modal" class="fixed inset-0 z-50 hidden">
    <div id="pending-modal-backdrop" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
    
    <div class="absolute bottom-0 right-0 w-full sm:relative sm:max-w-5xl sm:mx-auto sm:my-8 sm:w-11/12">
        <div class="bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl max-h-[85vh] flex flex-col overflow-hidden">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-5 py-4 flex justify-between items-center flex-shrink-0">
                <h3 class="text-white font-bold text-lg flex items-center gap-2">
                    <i class="fas fa-hourglass-half"></i>
                    Pending Services
                    <span id="pending-count" class="bg-white/20 text-white text-xs px-2 py-0.5 rounded-full">6</span>
                </h3>
                <div class="flex gap-2">
                    <button onclick="loadPendingServices()" class="text-white/80 hover:text-white transition-colors" title="Refresh">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <button onclick="closePendingModal()" class="text-white/80 hover:text-white transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Table Content -->
            <div class="flex-1 overflow-auto p-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Machine</th>
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="pending-table-body" class="divide-y divide-gray-100">
                            <tr>
                                <td colspan="4" class="text-center py-8 text-gray-400">
                                    <i class="fas fa-spinner fa-spin text-2xl mb-2 block"></i>
                                    Loading...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 text-xs text-gray-400 flex justify-between items-center flex-shrink-0">
                <span><i class="fas fa-info-circle mr-1"></i> Drafts are saved locally. Click Submit to complete the service report.</span>
                <div class="flex gap-2">
                    <button onclick="closePendingModal()" class="text-gray-400 hover:text-gray-600">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // const saveDraftBtn = document.getElementById('save-draft-btn');
    // if (saveDraftBtn) {
    //     // Replace existing button to ensure our handler is used
    //     const newBtn = saveDraftBtn.cloneNode(true);
    //     saveDraftBtn.parentNode.replaceChild(newBtn, saveDraftBtn);
    //     newBtn.addEventListener('click', window.saveDraft);
    // }
});
</script>