@push('scripts')
<script>
// ─── SAMPLE DATA ───────────────────────────────────────────────────────────────
// let pendingServices = [
//     {
//         id: 'pending_001',
//         machine_id: 1,
//         machine_name: 'Siemens X-Ray Machine',
//         serial_number: 'XR-2024-001',
//         model: 'Siemens Multix',
//         location: 'Manila General Hospital',
//         client_name: 'Manila General Hospital',
//         created_at: '2024-01-15T09:30:00',
//         last_updated: '2024-01-15T14:20:00',
//         status: 'draft',
//         service_type: ['PMS', 'Calibration'],
//         identification: 'Unit showing intermittent display issues',
//         root_cause: 'Loose connection on main board',
//         action_taken: 'Reseated connectors and updated firmware',
//         equipment_status: 'Operational',
//         recommendations: 'Schedule quarterly maintenance',
//         approved_by: 'Dr. Juan Santos',
//         medtech_signature: null,
//         parts: [{ qty: 1, particulars: 'Display Cable', si_dr_no: 'SI-2024-001' }],
//         before_images: [], after_images: [], service_images: [], calibration_images: []
//     },
//     {
//         id: 'pending_002',
//         machine_id: 2,
//         machine_name: 'Philips Ultrasound',
//         serial_number: 'US-2024-045',
//         model: 'Philips EPIQ 7',
//         location: 'Cebu Medical Center',
//         client_name: 'Cebu Medical Center',
//         created_at: '2024-01-16T10:15:00',
//         last_updated: '2024-01-16T11:45:00',
//         status: 'draft',
//         service_type: ['Troubleshooting'],
//         identification: 'Probe not detected by system',
//         root_cause: 'Faulty probe connector',
//         action_taken: 'Replaced probe connector assembly',
//         equipment_status: 'Operational',
//         recommendations: 'Monitor probe performance weekly',
//         approved_by: 'Dr. Maria Reyes',
//         medtech_signature: null,
//         parts: [{ qty: 1, particulars: 'Probe Connector', si_dr_no: 'DR-2024-089' }],
//         before_images: [], after_images: [], service_images: [], calibration_images: []
//     },
//     {
//         id: 'pending_003',
//         machine_id: 3,
//         machine_name: 'GE Ventilator',
//         serial_number: 'VENT-2024-123',
//         model: 'GE CARESCAPE R860',
//         location: 'Davao Doctors Hospital',
//         client_name: 'Davao Doctors Hospital',
//         created_at: '2024-01-16T13:00:00',
//         last_updated: '2024-01-16T15:30:00',
//         status: 'draft',
//         service_type: ['Maintenance', 'Calibration'],
//         identification: 'Oxygen sensor calibration drift',
//         root_cause: 'Sensor aging',
//         action_taken: 'Replaced oxygen sensor and recalibrated',
//         equipment_status: 'Operational',
//         recommendations: 'Replace sensor every 6 months',
//         approved_by: 'Dr. Antonio Cruz',
//         medtech_signature: null,
//         parts: [
//             { qty: 1, particulars: 'Oxygen Sensor', si_dr_no: 'SI-2024-056' },
//             { qty: 2, particulars: 'Filter Kit', si_dr_no: 'SI-2024-056' }
//         ],
//         before_images: [], after_images: [], service_images: [], calibration_images: []
//     },
//     {
//         id: 'pending_004',
//         machine_id: 4,
//         machine_name: 'Mindray Patient Monitor',
//         serial_number: 'PM-2024-789',
//         model: 'Mindray uMEC12',
//         location: 'St. Lukes Medical Center',
//         client_name: 'St. Lukes Medical Center',
//         created_at: '2024-01-17T08:45:00',
//         last_updated: '2024-01-17T10:20:00',
//         status: 'draft',
//         service_type: ['Installation'],
//         identification: 'New unit installation and setup',
//         root_cause: 'Initial deployment',
//         action_taken: 'Installed, configured network, and tested all parameters',
//         equipment_status: 'Operational',
//         recommendations: 'Train staff on proper usage',
//         approved_by: 'Dr. Robert Lim',
//         medtech_signature: null,
//         parts: [],
//         before_images: [], after_images: [], service_images: [], calibration_images: []
//     },
//     {
//         id: 'pending_005',
//         machine_id: 5,
//         machine_name: 'B Braun Dialysis Machine',
//         serial_number: 'DIA-2024-234',
//         model: 'B Braun Dialog+',
//         location: 'National Kidney Institute',
//         client_name: 'National Kidney Institute',
//         created_at: '2024-01-17T14:30:00',
//         last_updated: '2024-01-17T16:15:00',
//         status: 'draft',
//         service_type: ['Troubleshooting', 'PMS'],
//         identification: 'Flow rate error during dialysis',
//         root_cause: 'Clogged filter in fluid path',
//         action_taken: 'Cleaned filter system and replaced tubing',
//         equipment_status: 'Operational',
//         recommendations: 'Replace filter every 3 months',
//         approved_by: 'Dr. Cristina Fernandez',
//         medtech_signature: null,
//         parts: [
//             { qty: 1, particulars: 'Filter Assembly', si_dr_no: 'DR-2024-112' },
//             { qty: 2, particulars: 'Tubing Set', si_dr_no: 'DR-2024-112' }
//         ],
//         before_images: [], after_images: [], service_images: [], calibration_images: []
//     },
//     {
//         id: 'pending_006',
//         machine_id: 6,
//         machine_name: 'Drager Anesthesia Machine',
//         serial_number: 'AN-2024-567',
//         model: 'Drager Perseus A500',
//         location: 'Philippine Heart Center',
//         client_name: 'Philippine Heart Center',
//         created_at: '2024-01-18T09:00:00',
//         last_updated: '2024-01-18T11:30:00',
//         status: 'draft',
//         service_type: ['Calibration'],
//         identification: 'Vaporizer output inaccurate',
//         root_cause: 'Calibration out of spec',
//         action_taken: 'Recalibrated vaporizer and tested',
//         equipment_status: 'Operational',
//         recommendations: 'Annual calibration required',
//         approved_by: 'Dr. Manuel Santos',
//         medtech_signature: null,
//         parts: [],
//         before_images: [], after_images: [], service_images: [], calibration_images: []
//     }
// ];

let pendingServices = JSON.parse(localStorage.getItem("serviceDraft"));
// ─── HELPERS ───────────────────────────────────────────────────────────────────

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>"']/g, m => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[m]));
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    return new Date(dateString).toLocaleDateString('en-PH', {
        month: 'short', day: 'numeric', year: 'numeric',
        hour: '2-digit', minute: '2-digit'
    });
}

function getRelativeTime(dateString) {
    const diffMs  = Date.now() - new Date(dateString);
    const mins    = Math.floor(diffMs / 60000);
    const hours   = Math.floor(diffMs / 3600000);
    const days    = Math.floor(diffMs / 86400000);
    if (mins  < 1)  return 'Just now';
    if (mins  < 60) return `${mins} minute${mins  > 1 ? 's' : ''} ago`;
    if (hours < 24) return `${hours} hour${hours  > 1 ? 's' : ''} ago`;
    return `${days} day${days > 1 ? 's' : ''} ago`;
}

// Convert a single File → { name, type, data: base64DataURL }
function fileToBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload  = () => resolve({ name: file.name, type: file.type, data: reader.result });
        reader.onerror = reject;
        reader.readAsDataURL(file);
    });
}

// Collect all files from an <input id="..."> and return base64 array
async function collectImages(inputId) {
    const input = document.getElementById(inputId);
    if (!input || !input.files || !input.files.length) return [];
    return Promise.all(Array.from(input.files).map(fileToBase64));
}

// Render saved base64 images into a preview container with a "draft" badge
function restoreImagePreviews(images, previewContainerId) {
    const container = document.getElementById(previewContainerId);
    if (!container || !images || !images.length) return;
    container.innerHTML = images.map(img => `
        <div class="relative group">
            <img src="${img.data}" alt="${escapeHtml(img.name)}"
                 class="w-full h-20 object-cover rounded-lg border border-gray-200">
            <div class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-xs
                        px-1 py-0.5 rounded-b-lg truncate">${escapeHtml(img.name)}</div>
            <span class="absolute top-1 right-1 bg-amber-400 text-white text-xs
                         px-1.5 py-0.5 rounded font-medium">draft</span>
        </div>
    `).join('');
}

// ─── BADGE ─────────────────────────────────────────────────────────────────────

function updatePendingBadge() {
    const badge     = document.getElementById('pending-badge');
    const countSpan = document.getElementById('pending-count');
    const count     = pendingServices.length;
    if (badge)     { badge.textContent = count; badge.classList.toggle('hidden', count === 0); }
    if (countSpan) { countSpan.textContent = count; }
}

// ─── LOAD ──────────────────────────────────────────────────────────────────────

function loadPendingServices() {
    const localStorageDrafts = [];

    for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        if (!key || !key.startsWith('serviceDraft')) continue;
        try {
            const draft = JSON.parse(localStorage.getItem(key));
            localStorageDrafts.push({
                id:                 key.replace('serviceDraft', ''),
                machine_id:         draft.machine_id         || 'unknown',
                machine_name:       draft.machine_name       || 'Unknown Machine',
                serial_number:      draft.serial_number      || 'N/A',
                model:              draft.model              || 'N/A',
                location:           draft.location           || 'N/A',
                client_name:        draft.client_name        || 'N/A',
                created_at:         draft.created_at         || new Date().toISOString(),
                last_updated:       draft.last_updated       || new Date().toISOString(),
                status:             'draft',
                service_type:       draft.service_type       || [],
                identification:     draft.identification     || '',
                root_cause:         draft.root_cause         || '',
                action_taken:       draft.action_taken       || '',
                equipment_status:   draft.equipment_status   || '',
                recommendations:    draft.recommendations    || '',
                approved_by:        draft.approved_by        || '',
                medtech_signature:  draft.medtech_signature  || null,
                parts:              draft.parts              || [],
                before_images:      draft.before_images      || [],
                after_images:       draft.after_images       || [],
                service_images:     draft.service_images     || [],
                calibration_images: draft.calibration_images || [],
            });
        } catch(e) {
            console.error('Error loading draft:', e);
        }
    }

    // Merge — localStorage drafts first, then sample data (no duplicates)
    const merged = [...pendingServices.filter(s => s.id.startsWith('pending_'))];
    localStorageDrafts.forEach(d => {
        if (!merged.some(m => m.id === d.id)) merged.unshift(d);
    });
    pendingServices = merged;

    updatePendingBadge();
    renderPendingTable();
}

// ─── RENDER TABLE ──────────────────────────────────────────────────────────────

function renderPendingTable() {
    const tbody = document.getElementById('pending-table-body');
    if (!tbody) return;

    if (!pendingServices.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center py-12 text-gray-400">
                    <i class="fas fa-inbox text-4xl mb-3 block"></i>
                    <p class="text-sm">No pending services found</p>
                    <p class="text-xs mt-1">Drafts you save will appear here</p>
                </td>
            </tr>`;
        return;
    }

    tbody.innerHTML = pendingServices.map(service => {
        // Count saved images
        const imgCount = (service.before_images?.length  || 0)
                       + (service.after_images?.length   || 0)
                       + (service.service_images?.length || 0)
                       + (service.calibration_images?.length || 0);
        
        let machines = {{Js::from($machines)}};
        let find = false;
        let index = 0;
        while(!find){
            if(machines[index].id == service.machine_id){
                find = true;
            }else{
                index++;
            }
        }

        console.log(machines[index])

        return `
        <tr class="border-b border-gray-100 hover:bg-amber-50 transition-colors group">
            <td class="px-3 py-3">
                <div class="font-medium text-gray-800 text-sm flex items-center gap-2">
                    <i class="fas fa-microscope text-amber-500 text-xs"></i>
                    ${escapeHtml(machines[index].name)}
                </div>
                <div class="text-xs text-gray-400 mt-0.5">
                    SN: ${escapeHtml(machines[index].serial_number)} | ${escapeHtml(machines[index].model)}
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>${escapeHtml(machines[index].
client_location
)}
                </div>
            </td>
            <td class="px-3 py-3 text-sm text-gray-500 whitespace-nowrap">
                <div>${service.service_date}</div>
            </td>
            <td class="px-3 py-3">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                    <i class="fas fa-pen-fancy mr-1"></i> Draft
                </span>
                <div class="text-xs text-gray-400 mt-1">
                    <i class="far fa-clock mr-1"></i>
                    ${service.service_type?.slice(0,2).join(', ')}${service.service_type?.length > 2 ? '…' : ''}
                </div>
                ${imgCount > 0 ? `
                <div class="text-xs text-blue-500 mt-0.5">
                    <i class="fas fa-images mr-1"></i>${imgCount} image${imgCount > 1 ? 's' : ''} saved
                </div>` : ''}
                ${service.medtech_signature ? `
                <div class="text-xs text-green-500 mt-0.5">
                    <i class="fas fa-signature mr-1"></i>Signature saved
                </div>` : ''}
            </td>
            <td class="px-3 py-3">
                <div class="flex gap-1 flex-wrap">
                    <button onclick="viewPendingDetails(${service.service_id})"
                            class="px-2.5 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
                            title="View Details">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button onclick="deletePendingService(${service.service_id})"
                            class="px-2.5 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                            title="Delete Draft">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        </tr>`;
    }).join('');
}

// ─── VIEW DETAILS ──────────────────────────────────────────────────────────────

function viewPendingDetails(serviceId) {
    const service = pendingServices.find(s => s.service_id === serviceId);
    if (!service) return;

    const totalImages = (service.before_images?.length       || 0)
                      + (service.after_images?.length        || 0)
                      + (service.service_images?.length      || 0)
                      + (service.calibration_images?.length  || 0);


        let machines = {{Js::from($machines)}};
        let find = false;
        let index = 0;
        while(!find){
            if(machines[index].id == service.machine_id){
                find = true;
            }else{
                index++;
            }
        }
    // Build image thumbnails section
    function thumbsHtml(label, arr) {
        if (!arr || !arr.length) return '';
        return `
            <div class="mb-2">
                <p class="text-xs text-gray-400 mb-1">${label} (${arr.length})</p>
                <div class="flex gap-1 flex-wrap">
                    ${arr.map(img => `
                        <img src="${img.data}" alt="${escapeHtml(img.name)}"
                             class="h-14 w-14 object-cover rounded-lg border border-gray-200 cursor-pointer"
                             onclick="window.open('${img.data}','_blank')"
                             title="${escapeHtml(img.name)}">
                    `).join('')}
                </div>
            </div>`;
    }

    const imagesSection = totalImages > 0 ? `
        <div class="border-b pb-2">
            <p class="text-xs text-gray-500 mb-2">
                <i class="fas fa-images mr-1 text-blue-400"></i>Saved Images (${totalImages} total)
            </p>
            ${thumbsHtml('Before', service.before_images)}
            ${thumbsHtml('After',  service.after_images)}
            ${thumbsHtml('Service', service.service_images)}
            ${thumbsHtml('Calibration', service.calibration_images)}
        </div>` : `
        <div class="bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs text-gray-400">
            <i class="fas fa-image mr-1"></i> No images saved in this draft.
        </div>`;

    Swal.fire({
        title: 'Service Draft Details',
        html: `
        <div class="space-y-3 text-left">
            <div class="border-b pb-2">
                <p class="text-xs text-gray-500">Machine</p>
                <p class="font-medium">${escapeHtml(service.machine_name)}</p>
                <p class="text-sm text-gray-600">SN: ${escapeHtml(machines[index].serial_number)} | ${escapeHtml(service.model)}</p>
            </div>
            <div class="border-b pb-2">
                <p class="text-xs text-gray-500">Client / Location</p>
                <p class="font-medium">${escapeHtml(service.client_name)}</p>
                <p class="text-sm text-gray-600">${escapeHtml(machines[index].
client_location)}</p>
            </div>
            <div class="border-b pb-2">
                <p class="text-xs text-gray-500">Service Type</p>
                <div class="flex gap-1 flex-wrap mt-1">
                    ${service.service_type.map(t =>
                        `<span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs">${escapeHtml(t)}</span>`
                    ).join('')}
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
                <p class="text-sm font-semibold ${service.equipment_status === 'Operational' ? 'text-green-600' : 'text-red-600'}">
                    ${escapeHtml(service.equipment_status) || 'N/A'}
                </p>
            </div>
            ${service.recommendations ? `
            <div class="border-b pb-2">
                <p class="text-xs text-gray-500">Recommendations</p>
                <p class="text-sm">${escapeHtml(service.recommendations)}</p>
            </div>` : ''}
            ${service.parts && service.parts.length ? `
            <div class="border-b pb-2">
                <p class="text-xs text-gray-500">Parts Replaced</p>
                <div class="text-sm space-y-1 mt-1">
                    ${service.parts.map(p =>
                        `<div class="flex gap-2">
                            <span class="font-medium">${escapeHtml(String(p.qty))}x</span>
                            ${escapeHtml(p.particulars)}
                            <span class="text-gray-400">(${escapeHtml(p.si_dr_no)})</span>
                        </div>`
                    ).join('')}
                </div>
            </div>` : ''}
            ${service.medtech_signature ? `
            <div class="border-b pb-2">
                <p class="text-xs text-gray-500 mb-1">
                    <i class="fas fa-signature mr-1 text-green-500"></i>Signature
                </p>
                <div class="border border-gray-200 rounded-lg p-2 bg-gray-50 inline-block">
                    <img src="${service.medtech_signature}" alt="Signature" class="max-h-12">
                </div>
            </div>` : ''}
            ${imagesSection}
            <div class="pt-1 text-xs text-gray-400">
                Created: ${formatDate(service.created_at)}
                ${service.last_updated ? `<br>Last updated: ${formatDate(service.last_updated)}` : ''}
            </div>
        </div>`,
        width: '520px',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-edit mr-1"></i> Edit / Submit',
        cancelButtonText: 'Close',
        confirmButtonColor: '#3b82f6'
    }).then(result => {
        if (result.isConfirmed) editPendingService(serviceId);
    });
}

// ─── DELETE ────────────────────────────────────────────────────────────────────

function deletePendingService(serviceId) {
    Swal.fire({
        title: 'Delete Draft?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
    }).then(result => {
        if (!result.isConfirmed) return;
        localStorage.removeItem(`serviceDraft_${serviceId}`);
        pendingServices = pendingServices.filter(s => s.id !== serviceId);
        updatePendingBadge();
        renderPendingTable();
        Swal.fire({ title: 'Deleted!', text: 'Draft has been deleted.', icon: 'success', timer: 1500, showConfirmButton: false });
    });
}

// ─── POPULATE FORM ─────────────────────────────────────────────────────────────

function populateServiceForm(data) {
    const machineIdField = document.getElementById('machine-id');
    if (machineIdField && data.machine_id) machineIdField.value = data.machine_id;

    if (Array.isArray(data.service_type)) {
        document.querySelectorAll('input[name="service_type[]"]').forEach(cb => {
            cb.checked = data.service_type.includes(cb.value);
        });
        const knownTypes = ['PMS','Troubleshooting','Installation','Warranty','Calibration'];
        const othersVal  = data.service_type.find(t => !knownTypes.includes(t));
        if (othersVal) {
            const othersCheckbox = document.getElementById('others-checkbox');
            const othersInputDiv = document.getElementById('others-input');
            const othersInput    = document.querySelector('#others-input input');
            if (othersCheckbox) othersCheckbox.checked = true;
            if (othersInputDiv) othersInputDiv.classList.remove('hidden');
            if (othersInput)    othersInput.value = othersVal;
        }
    }

    ['identification','root_cause','action_taken','recommendations'].forEach(field => {
        const el = document.querySelector(`textarea[name="${field}"]`);
        if (el && data[field] != null) el.value = data[field];
    });

    // Equipment status
    if (data.equipment_status) {
        const radio = document.querySelector(`input[name="equipment_status"][value="${data.equipment_status}"]`);
        if (radio) radio.checked = true;
    }

    if (data.medtech_signature) {
        const sigData    = document.getElementById('signature-data');
        const sigImg     = document.getElementById('signature-image');
        const sigPreview = document.getElementById('signature-preview');
        if (sigData)    sigData.value = data.medtech_signature;
        if (sigImg)     sigImg.src    = data.medtech_signature;
        if (sigPreview) sigPreview.classList.remove('hidden');

        try {
            const canvas = document.getElementById('signature-pad');
            if (canvas && window.SignaturePad) {
              
                const ctx = canvas.getContext('2d');
                const img = new Image();
                img.onload = () => {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                };
                img.src = data.medtech_signature;
            }
        } catch(e) { /* non-critical */ }
    }

    const approvedBy = document.querySelector('input[name="approved_by"]');
    if (approvedBy && data.approved_by) approvedBy.value = data.approved_by;

    const partsContainer = document.getElementById('parts-container');
    if (partsContainer && data.parts && data.parts.length) {
        // Remove all fieldset rows
        partsContainer.querySelectorAll('.fieldset_particular').forEach(el => el.remove());

        data.parts.forEach((part, i) => {
            const fieldset  = document.createElement('fieldset');
            fieldset.className = 'fieldset_particular';
            const row       = document.createElement('div');
            row.className   = 'parts-row';
            row.innerHTML   = `
                <input type="number" name="qty[]"         placeholder="Qty"          class="svc-input parts-qty"  value="${escapeHtml(String(part.qty || ''))}">
                <input type="text"   name="particulars[]" placeholder="Particulars"  class="svc-input parts-part" value="${escapeHtml(part.particulars || '')}">
                <input type="text"   name="si_dr_no[]"    placeholder="S.I./D.R. No." class="svc-input parts-si"  value="${escapeHtml(part.si_dr_no || '')}">
            `;
            fieldset.appendChild(row);
            partsContainer.appendChild(fieldset);
        });
    }

    restoreImagePreviews(data.before_images,      'before-image-preview');
    restoreImagePreviews(data.after_images,       'after-image-preview');
    restoreImagePreviews(data.service_images,     'service-image-preview');
    restoreImagePreviews(data.calibration_images, 'calibration-image-preview');
}


function editPendingService(draftId) {
    const service = pendingServices.find(s => s.service_id === draftId)
                 || (() => {
                        const raw = localStorage.getItem(`serviceDraft_${draftId}`);
                        return raw ? JSON.parse(raw) : null;
                    })();

    if (!service) { Swal.fire('Not Found', 'Could not load this draft.', 'error'); return; }

    closePendingModal();
    if (typeof openModal === 'function') {
        openModal(service.machine_id);
    } else {
        const modal = document.getElementById('service-modal');
        if (modal) { modal.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
    }
    setTimeout(() => populateServiceForm(service), 350);
}


// function submitPendingService(serviceId) {
//     const service = pendingServices.find(s => s.id === serviceId)
//                  || (() => {
//                         const raw = localStorage.getItem(`serviceDraft_${serviceId}`);
//                         return raw ? JSON.parse(raw) : null;
//                     })();

//     if (!service) { Swal.fire('Not Found', 'Could not load this draft.', 'error'); return; }

//     const totalImages = (service.before_images?.length      || 0)
//                       + (service.after_images?.length       || 0)
//                       + (service.service_images?.length     || 0)
//                       + (service.calibration_images?.length || 0);

//     Swal.fire({
//         title: 'Open Draft for Submission?',
//         html: `
//             <p class="text-sm text-gray-600 mb-3">The form will be pre-filled with your saved data.</p>
//             <div class="flex justify-center gap-4 text-xs">
//                 <span class="${service.medtech_signature ? 'text-green-600' : 'text-gray-400'}">
//                     <i class="fas fa-signature mr-1"></i>
//                     ${service.medtech_signature ? 'Signature saved' : 'No signature — must re-sign'}
//                 </span>
//                 <span class="${totalImages > 0 ? 'text-blue-600' : 'text-gray-400'}">
//                     <i class="fas fa-images mr-1"></i>
//                     ${totalImages > 0 ? `${totalImages} image(s) saved` : 'No images saved'}
//                 </span>
//             </div>`,
//         icon: 'question',
//         showCancelButton: true,
//         confirmButtonText: '<i class="fas fa-folder-open mr-1"></i> Open Form',
//         cancelButtonText: 'Cancel',
//         confirmButtonColor: '#16a34a'
//     }).then(result => {
//         if (!result.isConfirmed) return;

//         closePendingModal();

//         if (typeof openModal === 'function') {
//             openModal(service.machine_id);
//         } else {
//             const modal = document.getElementById('service-modal');
//             if (modal) { modal.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
//         }

//         setTimeout(() => {
//             populateServiceForm(service);

//             // Briefly highlight the submit button
//             const submitBtn = document.getElementById('submit-service-btn');
//             if (submitBtn) {
//                 submitBtn.classList.add('ring-2', 'ring-offset-2', 'ring-green-400');
//                 setTimeout(() => submitBtn.classList.remove('ring-2','ring-offset-2','ring-green-400'), 2500);
//             }

//             // Toast reminder
//             Swal.fire({
//                 toast: true,
//                 position: 'top-end',
//                 icon: 'info',
//                 title: service.medtech_signature
//                     ? 'Draft loaded — review and click Complete Service'
//                     : 'Draft loaded — please re-sign before submitting',
//                 showConfirmButton: false,
//                 timer: 4500,
//                 timerProgressBar: true,
//             });
//         }, 400);
//     });
// }

// ─── SAVE DRAFT (async — converts images to base64) ────────────────────────────

window.saveDraft = async function() {
    const form = document.getElementById('service-form');
    if (!form) return;

    // Show loading
    Swal.fire({
        title: 'Saving Draft…',
        text: 'Converting images, please wait.',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    try {
        // Collect images as base64 in parallel
        const [beforeImages, afterImages, serviceImages, calibrationImages] = await Promise.all([
            collectImages('before-images'),
            collectImages('after-images'),
            collectImages('service-images'),
            collectImages('calibration-images'),
        ]);

        // Service types
        const serviceTypes = [];
        document.querySelectorAll('.services:checked').forEach(cb => serviceTypes.push(cb.value));
        document.querySelectorAll('.services-others:checked').forEach(() => {
            const val = document.querySelector('.services-others-write')?.value;
            if (val) serviceTypes.push(val);
        });

        // Parts
        const parts = [];
        document.querySelectorAll('.fieldset_particular').forEach(fieldset => {
            const inputs = fieldset.querySelectorAll('input');
            if (inputs[0]?.value || inputs[1]?.value) {
                parts.push({
                    qty:        inputs[0]?.value || 0,
                    particulars:inputs[1]?.value || '',
                    si_dr_no:   inputs[2]?.value || ''
                });
            }
        });

        // Signature
        const signatureVal = document.getElementById('signature-data')?.value || '';

        // Machine metadata (from the active machine card)
        const activeCard     = document.querySelector('#card-view .bg-white.border');
        let machineName      = document.querySelector('#service-engineer-name')?.dataset?.machineName || 'Unknown Machine';
        let serialNumber     = 'N/A';
        let machineModel     = 'N/A';
        let clientLocation   = 'N/A';

        if (activeCard) {
            const nameEl     = activeCard.querySelector('.font-bold');
            const serialEl   = activeCard.querySelector('.text-gray-400');
            if (nameEl)   machineName   = nameEl.innerText.trim();
            if (serialEl) serialNumber  = serialEl.innerText.replace('# ','').trim();
        }

        const draftData = {
            machine_id:         document.getElementById('machine-id')?.value || 'unknown',
            machine_name:       machineName,
            serial_number:      serialNumber,
            model:              machineModel,
            location:           clientLocation,
            client_name:        clientLocation,
            service_type:       serviceTypes,
            identification:     document.querySelector('textarea[name="identification"]')?.value  || '',
            root_cause:         document.querySelector('textarea[name="root_cause"]')?.value      || '',
            action_taken:       document.querySelector('textarea[name="action_taken"]')?.value    || '',
            equipment_status:   document.querySelector('input[name="equipment_status"]:checked')?.value || '',
            recommendations:    document.querySelector('textarea[name="recommendations"]')?.value || '',
            approved_by:        document.querySelector('input[name="approved_by"]')?.value        || '',
            medtech_signature:  signatureVal,
            parts,
            before_images:      beforeImages,
            after_images:       afterImages,
            service_images:     serviceImages,
            calibration_images: calibrationImages,
            created_at:         new Date().toISOString(),
            last_updated:       new Date().toISOString(),
        };

        const draftId = 'draft_' + Date.now();

        try {
            localStorage.setItem(`serviceDraft_${draftId}`, JSON.stringify(draftData));
        } catch (storageErr) {
            // localStorage full — save without images as fallback
            console.warn('localStorage full, saving without images:', storageErr);
            draftData.before_images      = [];
            draftData.after_images       = [];
            draftData.service_images     = [];
            draftData.calibration_images = [];
            localStorage.setItem(`serviceDraft_${draftId}`, JSON.stringify(draftData));

            loadPendingServices();
            Swal.fire({
                title: 'Draft Saved (No Images)',
                html: `Saved without images due to storage limits.<br>
                       <small class="text-gray-500">Delete old drafts to free up space.</small>`,
                icon: 'warning'
            });
            return;
        }

        loadPendingServices();

        const imgTotal = beforeImages.length + afterImages.length
                       + serviceImages.length + calibrationImages.length;

        Swal.fire({
            title: 'Draft Saved!',
            html: `
                <p>Service report saved successfully.</p>
                <div class="flex justify-center gap-4 mt-2 text-xs text-gray-500">
                    <span><i class="fas fa-images mr-1 text-blue-400"></i>${imgTotal} image(s)</span>
                    <span><i class="fas fa-signature mr-1 ${signatureVal ? 'text-green-500' : 'text-gray-300'}"></i>
                          ${signatureVal ? 'Signature saved' : 'No signature'}</span>
                </div>`,
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
        });

    } catch (err) {
        console.error('saveDraft error:', err);
        Swal.fire('Error', 'Failed to save draft. Try with fewer or smaller images.', 'error');
    }
};


function togglePendingModal() {
    const modal = document.getElementById('pending-modal');
    if (!modal) return;
    modal.classList.toggle('hidden');
    if (!modal.classList.contains('hidden')) renderPendingTable();
}

function closePendingModal() {
    const modal = document.getElementById('pending-modal');
    if (modal) modal.classList.add('hidden');
}


document.addEventListener('DOMContentLoaded', function () {
    loadPendingServices();

    document.getElementById('pending-modal-backdrop')
        ?.addEventListener('click', closePendingModal);

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closePendingModal();
    });
});


window.togglePendingModal    = togglePendingModal;
window.closePendingModal     = closePendingModal;
window.loadPendingServices   = loadPendingServices;
window.editPendingService    = editPendingService;
//window.submitPendingService  = submitPendingService;
window.deletePendingService  = deletePendingService;
window.viewPendingDetails    = viewPendingDetails;
</script>
@endpush

<!-- Floating Button - Bottom Right -->
<button onclick="togglePendingModal()" 
        class="fixed bottom-6 right-6 z-40 w-14 h-14 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200 flex items-center justify-center text-white border-0 cursor-pointer group">
    <i class="fas fa-clock text-xl"></i>
    <span id="pending-badge" 
          class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold min-w-[20px] h-5 px-1 rounded-full flex items-center justify-center shadow-md">
        0
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