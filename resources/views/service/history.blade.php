@extends('layouts.app')
@section('title', 'Service Report History')
@section('content')

    <main class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Service Reports</h1>
                <p class="text-slate-500 mt-1 text-sm">Complete service history & maintenance records — track every repair, PMS, and calibration</p>
            </div>
            <div class="flex space-x-3 no-print">
                <button onclick="batchPrint()" id="batchPrintBtn" class="inline-flex items-center gap-2 px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-xl shadow-sm transition-all duration-200">
                    <i class="fas fa-print text-sm"></i> Batch Print
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center"><i class="fas fa-clipboard-list text-xl"></i></div>
                <div class="ml-4"><p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Total Services</p><p class="text-2xl font-bold text-slate-800" id="statTotal">0</p></div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center"><i class="fas fa-calendar-check text-xl"></i></div>
                <div class="ml-4"><p class="text-xs font-medium text-slate-400 uppercase tracking-wide">This Month</p><p class="text-2xl font-bold text-slate-800" id="statMonthly">0</p></div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center"><i class="fas fa-user-cog text-xl"></i></div>
                <div class="ml-4"><p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Active Engineers</p><p class="text-2xl font-bold text-slate-800" id="statEngineers">0</p></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/40">
                <h3 class="text-base font-semibold text-slate-700"><i class="fas fa-sliders-h mr-2 text-slate-500"></i>Filter Service Reports</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div><label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1">Client Name</label><select id="filterClient" class="w-full rounded-lg border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-blue-200 px-3 py-2"><option value="">All Clients</option><option>WellMed Diagnostics</option><option>MetroHealth Labs</option><option>St. Catherine Hospital</option><option>Northside Imaging</option><option>Makati Medical Center</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1">Serial Number</label><input type="text" id="filterSerial" placeholder="Enter serial number" class="w-full rounded-lg border-slate-200 bg-slate-50 text-sm px-3 py-2"></div>
                    <div><label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1">Location</label><select id="filterLocation" class="w-full rounded-lg border-slate-200 bg-slate-50 text-sm px-3 py-2"><option value="">All Locations</option><option>Manila</option><option>Cebu</option><option>Davao</option><option>Laguna</option><option>Quezon City</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1">Service Type</label><select id="filterType" class="w-full rounded-lg border-slate-200 bg-slate-50 text-sm px-3 py-2"><option value="">All Types</option><option>PMS</option><option>Troubleshooting</option><option>Installation</option><option>Warranty</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1">From Date</label><input type="date" id="filterDateFrom" class="w-full rounded-lg border-slate-200 bg-slate-50 text-sm px-3 py-2"></div>
                    <div><label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1">To Date</label><input type="date" id="filterDateTo" class="w-full rounded-lg border-slate-200 bg-slate-50 text-sm px-3 py-2"></div>
                    <div><label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1">Engineer</label><select id="filterEngineer" class="w-full rounded-lg border-slate-200 bg-slate-50 text-sm px-3 py-2"><option value="">All Engineers</option><option>Michael Tan</option><option>Sarah Gomez</option><option>James Cruz</option><option>Patricia Lim</option><option>Anna Reyes</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1">Equipment Status</label><select id="filterStatus" class="w-full rounded-lg border-slate-200 bg-slate-50 text-sm px-3 py-2"><option value="">All Status</option><option>Operational</option><option>Not Operational</option></select></div>
                </div>
                <div class="mt-5"><label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-1">Keyword (Issue / Action)</label><input type="text" id="filterKeyword" placeholder="Search root cause, findings, actions..." class="w-full rounded-lg border-slate-200 bg-slate-50 text-sm px-3 py-2"></div>
                <div class="flex justify-between items-center mt-6 pt-4 border-t border-slate-100">
                    <div class="text-sm text-slate-500"><span id="resultCount">0</span> records displayed</div>
                    <div class="flex space-x-3"><button id="resetFiltersBtn" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-xl transition"><i class="fas fa-undo-alt mr-1"></i>Reset</button><button id="applyFiltersBtn" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-sm transition"><i class="fas fa-filter mr-1"></i>Apply Filters</button></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-white flex justify-between items-center">
                <h3 class="text-lg font-semibold text-slate-800"><i class="fas fa-history mr-2 text-slate-500"></i>Service history log</h3>
                <span class="text-xs text-slate-400" id="pageIndicator">Page 1 of 1</span>
            </div>
            <div class="overflow-x-auto custom-scroll">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Machine Details</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Service Info</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Service Details</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Personnel</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody" class="divide-y divide-slate-100 bg-white"></tbody>
                </table>
            </div>
            <div id="noResultsMessage" class="text-center py-12 hidden">
                <i class="fas fa-clipboard-list text-5xl text-slate-300 mb-3"></i>
                <p class="text-slate-500 font-medium">No service records match your filters.</p>
                <p class="text-slate-400 text-sm mt-1">Try adjusting your search criteria.</p>
            </div>
            <div class="bg-white px-6 py-3 border-t border-slate-200 flex justify-between items-center">
                <p class="text-xs text-slate-500" id="paginationInfo">Showing 0 of 0 records</p>
                <div class="flex space-x-2">
                    <button id="prevPageBtn" class="px-3 py-1.5 border border-slate-300 rounded-lg text-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-slate-50 transition">Prev</button>
                    <button id="nextPageBtn" class="px-3 py-1.5 border border-slate-300 rounded-lg text-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-slate-50 transition">Next</button>
                </div>
            </div>
        </div>
    </main>

    <!-- ========== DETAIL MODAL ========== -->
    <div id="detailModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 hidden modal-transition">
        <div class="bg-white rounded-2xl shadow-xl w-11/12 md:w-2/3 lg:w-1/2 max-h-[85vh] overflow-y-auto m-4">
            <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800"><i class="fas fa-file-alt mr-2 text-blue-500"></i>Service Report Details</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            <div id="modalContent" class="p-6 space-y-5 text-sm"></div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // const MOCK_REPORTS = [
        //     { id: 1001, 
        //         machine_id: "HemaTech X100", 
        //         service_type: "PMS", 
        //         service_date: "2025-02-10", 
        //         root_cause_findings: "Calibration drift on laser module. QC outliers detected on HGB channel.", 
        //         action_taken: "Realigned optics, performed full QC calibration, replaced cuvette washer.", 
        //         parts_replaced: [{qty:1, name:"Laser diode", particulars:"Laser diode", si_dr_no:"SI-2024-001"}], 
        //         equipment_status: "Operational", 
        //         recommendations: "Schedule quarterly calibration and monthly QC checks.", 
        //         service_engineer: "Michael Tan", 
        //         approved_by: "Dr. Reyes", 
        //         service_images: 2, 
        //         completion_notes: "All parameters within spec.", 
        //         identification_verification: "Patient table movement checked and verified. All sensors responding correctly." },];
        const MOCK_REPORTS = {{Js::from($service_records)}}

        let machines = {{Js::from($machines)}}

        console.log(machines)

        let filteredData = [...MOCK_REPORTS];
        let currentPage = 1;
        const rowsPerPage = 6;

        function updateStats() {
            const total = filteredData.length;
            const currentMonth = new Date().getMonth();
            const currentYear = new Date().getFullYear();
            const monthly = filteredData.filter(r => {
                let d = new Date(r.service_date);
                return d.getMonth() === currentMonth && d.getFullYear() === currentYear;
            }).length;
            const uniqueEngineers = [...new Set(filteredData.map(r => r.service_engineer))].length;
            document.getElementById('statTotal').innerText = total;
            document.getElementById('statMonthly').innerText = monthly;
            document.getElementById('statEngineers').innerText = uniqueEngineers;
        }

        function renderTable() {
            const totalRecords = filteredData.length;
            const totalPages = Math.max(1, Math.ceil(totalRecords / rowsPerPage));
            if (currentPage > totalPages) currentPage = totalPages;
            const start = (currentPage - 1) * rowsPerPage;
            const paginated = filteredData.slice(start, start + rowsPerPage);
            const tbody = document.getElementById('tableBody');
            const noResultDiv = document.getElementById('noResultsMessage');
            
            if (filteredData.length === 0) {
                tbody.innerHTML = '';
                noResultDiv.classList.remove('hidden');
                document.getElementById('resultCount').innerText = '0';
                document.getElementById('paginationInfo').innerText = 'Showing 0 of 0 records';
                document.getElementById('pageIndicator').innerText = `Page 0 of 0`;
                updateStats();
                return;
            }
            noResultDiv.classList.add('hidden');
            
            tbody.innerHTML = paginated.map(record => {
                const statusClass = record.equipment_status === 'Operational' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700';
                const partsBadge = JSON.parse(record.parts_replaced)?.length ? `<span class="inline-flex items-center gap-1 text-xs text-slate-500 mt-1"><i class="fas fa-tools"></i> ${JSON.parse(record.parts_replaced).length} part(s)</span>` : '';
                
                const machine_name = machines.find(m=> m.id === record.machine_id)?.name;
                const machine_model = machines.find(m=> m.id === record.machine_id)?.model;
                const machine_serial = machines.find(m=> m.id === record.machine_id)?.serial_number;
                const machine_location = machines.find(m=> m.id === record.machine_id)?.client_location;

                const machineInitial = machine_name.charAt(0);
                const machine_image = machines.find(m=> m.id === record.machine_id)?.image_path;
                return `
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600 font-semibold text-sm">
                                    <img src="/storage/${machine_image}" alt="${machine_name}" class="w-full h-full object-cover rounded-lg"> 
                                    </div>
                                <div>
                                    <div class="font-semibold text-slate-800">
                                        ${machine_name}
                                    </div>
                                    <div class="text-xs text-slate-400">${machine_model} | SN: ${machine_serial}</div>
                                    <div class="text-xs text-slate-500 mt-0.5"><i class="fas fa-map-marker-alt text-[10px] mr-1"></i>${machine_location}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-slate-700">FORMATTED DATE</div>
                            <div class="mt-1"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">${record.service_type}</span></div>
                            ${record.service_images ? `<div class="text-xs text-slate-400 mt-1"><i class="fas fa-camera mr-1"></i>${record.service_images}</div>` : ''}
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <div class="text-xs text-slate-600"><span class="font-semibold">Issue:</span> ${record.root_cause_findings.substring(0, 70)}${record.root_cause_findings.length > 70 ? '…' : ''}</div>
                            <div class="text-xs text-slate-600 mt-1"><span class="font-semibold">Action:</span> ${record.action_taken.substring(0, 60)}${record.action_taken.length > 60 ? '…' : ''}</div>
                            ${partsBadge}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-slate-800">${record.service_engineer}</div>
                            <div class="text-xs text-slate-400">Service Engineer</div>
                            <div class="text-xs text-slate-500 mt-1">Approved: ${record.approved_by}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold ${statusClass}">${record.equipment_status}</span>
                            <div class="text-xs text-slate-400 mt-1 font-mono">ID: #${record.id}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick="viewDetails(${record.id})" class="text-blue-600 hover:text-blue-800 p-1.5 rounded-lg hover:bg-blue-50 transition" title="View Details"><i class="fas fa-eye"></i></button>
                                <button onclick="printSingleReport(${record.id})" class="text-slate-500 hover:text-slate-700 p-1.5 rounded-lg hover:bg-slate-100 transition" title="Print Report"><i class="fas fa-print"></i></button>
                                <button onclick="deleteMock(${record.id})" class="text-red-500 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50 transition" title="Delete Report"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
            
            const startIdx = totalRecords === 0 ? 0 : start + 1;
            const endIdx = Math.min(start + rowsPerPage, totalRecords);
            document.getElementById('paginationInfo').innerText = `Showing ${startIdx}–${endIdx} of ${totalRecords} records`;
            document.getElementById('pageIndicator').innerText = `Page ${currentPage} of ${totalPages}`;
            document.getElementById('resultCount').innerText = totalRecords;
            updateStats();
            document.getElementById('prevPageBtn').disabled = currentPage === 1;
            document.getElementById('nextPageBtn').disabled = currentPage === totalPages;
        }

        function applyFilters() {
            const client = document.getElementById('filterClient').value;
            const serial = document.getElementById('filterSerial').value.trim().toLowerCase();
            const location = document.getElementById('filterLocation').value;
            const serviceType = document.getElementById('filterType').value;
            const dateFrom = document.getElementById('filterDateFrom').value;
            const dateTo = document.getElementById('filterDateTo').value;
            const engineer = document.getElementById('filterEngineer').value;
            const eqStatus = document.getElementById('filterStatus').value;
            const keyword = document.getElementById('filterKeyword').value.trim().toLowerCase();

            filteredData = MOCK_REPORTS.filter(r => {
                if (client && r.client_name !== client) return false;
                if (serial && !r.serial_number.toLowerCase().includes(serial)) return false;
                if (location && r.client_location !== location) return false;
                if (serviceType && r.service_type !== serviceType) return false;
                if (engineer && r.service_engineer !== engineer) return false;
                if (eqStatus && r.equipment_status !== eqStatus) return false;
                if (dateFrom && new Date(r.service_date) < new Date(dateFrom)) return false;
                if (dateTo && new Date(r.service_date) > new Date(dateTo)) return false;
                if (keyword && !(r.root_cause_findings.toLowerCase().includes(keyword) || r.action_taken.toLowerCase().includes(keyword) || (r.recommendations && r.recommendations.toLowerCase().includes(keyword)))) return false;
                return true;
            });
            currentPage = 1;
            renderTable();
        }

        function resetFilters() {
            document.getElementById('filterClient').value = '';
            document.getElementById('filterSerial').value = '';
            document.getElementById('filterLocation').value = '';
            document.getElementById('filterType').value = '';
            document.getElementById('filterDateFrom').value = '';
            document.getElementById('filterDateTo').value = '';
            document.getElementById('filterEngineer').value = '';
            document.getElementById('filterStatus').value = '';
            document.getElementById('filterKeyword').value = '';
            filteredData = [...MOCK_REPORTS];
            currentPage = 1;
            renderTable();
        }

        // View details modal
        window.viewDetails = (id) => {
            const report = filteredData.find(r => r.id === id);
            if (!report) return;
            const partsHtml = JSON.parse(report.parts_replaced)?.length ? `<div class="bg-slate-50 rounded-xl p-4"><p class="text-xs font-semibold text-slate-500 uppercase mb-2">Parts Replaced</p><ul class="space-y-1">${JSON.parse(report.parts_replaced).map(p => `<li class="text-sm flex items-center gap-2"><i class="fas fa-microchip text-slate-400 text-xs"></i><span class="font-medium">${p.qty}x</span> ${p.particulars}</li>`).join('')}</ul></div>` : '<div class="text-slate-400 italic text-sm">No parts replaced</div>';
            const service_images = JSON.parse(report.service_images)

            let i = '';

            for (let index = 0; index < service_images.length; index++) {
                i += `<img src="/storage/${service_images[index]}" class="w-24 h-24 object-cover rounded-lg border">`
            }
            
            document.getElementById('modalContent').innerHTML = `
                <div class="grid grid-cols-2 gap-4">
                    <div><p class="text-xs font-semibold text-slate-400 uppercase">Machine</p><p class="font-medium text-slate-800">${report.machine_id} (${report.machine_id})</p></div>
                    <div><p class="text-xs font-semibold text-slate-400 uppercase">Serial / Location</p><p class="text-slate-700">${report.machine_id} | ${report.machine_id}</p></div>
                    <div><p class="text-xs font-semibold text-slate-400 uppercase">Service Type</p><p><span class="inline-flex px-2 py-0.5 rounded-full text-xs bg-indigo-100 text-indigo-700">${report.service_type}</span></p></div>
                    <div><p class="text-xs font-semibold text-slate-400 uppercase">Service Date</p><p class="text-slate-700">${report.formatted_date}</p></div>
                    <div><p class="text-xs font-semibold text-slate-400 uppercase">Service Engineer</p><p class="text-slate-700">${report.service_engineer}</p></div>
                    <div><p class="text-xs font-semibold text-slate-400 uppercase">Approved By</p><p class="text-slate-700">${report.approved_by}</p></div>
                    <div class="col-span-2"><p class="text-xs font-semibold text-slate-400 uppercase">Root Cause / Findings</p><p class="text-slate-700 bg-slate-50 p-3 rounded-lg">${report.root_cause_findings}</p></div>
                    <div class="col-span-2"><p class="text-xs font-semibold text-slate-400 uppercase">Action Taken</p><p class="text-slate-700 bg-slate-50 p-3 rounded-lg">${report.action_taken}</p></div>
                    <div class="col-span-2"><p class="text-xs font-semibold text-slate-400 uppercase">Recommendations</p><p class="text-slate-700">${report.recommendations || 'N/A'}</p></div>
                    <div><p class="text-xs font-semibold text-slate-400 uppercase">Equipment Status</p><p><span class="inline-flex px-2.5 py-1 rounded-full text-xs ${report.equipment_status === 'Operational' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'}">${report.equipment_status}</span></p></div>
                    <div><p class="text-xs font-semibold text-slate-400 uppercase">Images Attached</p>
                        <p class="text-slate-700" id="test_services_images">
                            ${i}
                        </p>
                    </div>
                </div>
                ${partsHtml}
                <div class="border-t pt-3 mt-2 text-xs text-slate-400 flex justify-end"><i class="far fa-clock mr-1"></i> Record ID: #${report.id}</div>
            `;
            document.getElementById('detailModal').classList.remove('hidden');
        };
        
        window.closeModal = () => document.getElementById('detailModal').classList.add('hidden');

        // Print single report
        window.printSingleReport = (id) => {
            const printWindow = window.open(`/service/print?id=${id}`, '_blank', 'width=1200,height=800');
            if (printWindow) {
                printWindow.focus();
            } else {
                Swal.fire({
                    title: 'Print Report',
                    text: `Opening print view for report #${id}`,
                    icon: 'info',
                    confirmButtonText: 'Open Print View',
                    confirmButtonColor: '#2563eb'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.open(`/service/print?id=${id}`, '_blank');
                    }
                });
            }
        };

        // Batch print all filtered reports
        window.batchPrint = () => {
            const ids = filteredData.map(r => r.id).join(',');
            if (!ids) {
                Swal.fire({
                    title: 'No Reports',
                    text: 'No service reports to print. Please adjust your filters.',
                    icon: 'warning',
                    confirmButtonColor: '#2563eb'
                });
                return;
            }
            
            const printWindow = window.open(`/service/batch-print?ids=${ids}`, '_blank', 'width=1200,height=800');
            if (printWindow) {
                printWindow.focus();
            } else {
                Swal.fire({
                    title: 'Batch Print',
                    text: 'Opening batch print view...',
                    icon: 'info',
                    confirmButtonText: 'Open Print View',
                    confirmButtonColor: '#2563eb'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.open(`/service/batch-print?ids=${ids}`, '_blank');
                    }
                });
            }
        };

        // Delete report
        window.deleteMock = (id) => {
            Swal.fire({ 
                title: 'Confirm Deletion', 
                text: `Delete service report #${id}? This action cannot be undone.`, 
                icon: 'warning', 
                showCancelButton: true, 
                confirmButtonColor: '#d33', 
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel'
            }).then((res) => {
                if (res.isConfirmed) {
                    const idx = MOCK_REPORTS.findIndex(r => r.id === id);
                    if (idx !== -1) MOCK_REPORTS.splice(idx, 1);
                    filteredData = filteredData.filter(r => r.id !== id);
                    if (filteredData.length === 0 && currentPage > 1) currentPage--;
                    renderTable();
                    Swal.fire('Deleted!', 'Record has been removed.', 'success');
                }
            });
        };

        // Event Listeners
        document.getElementById('prevPageBtn').addEventListener('click', () => { 
            if (currentPage > 1) { 
                currentPage--; 
                renderTable(); 
            } 
        });
        
        document.getElementById('nextPageBtn').addEventListener('click', () => { 
            const totalPages = Math.ceil(filteredData.length / rowsPerPage); 
            if (currentPage < totalPages) { 
                currentPage++; 
                renderTable(); 
            } 
        });
        
        document.getElementById('applyFiltersBtn').addEventListener('click', applyFilters);
        document.getElementById('resetFiltersBtn').addEventListener('click', resetFilters);
        
        document.getElementById('detailModal').addEventListener('click', (e) => { 
            if (e.target === document.getElementById('detailModal')) closeModal(); 
        });
        
        // Keyboard shortcut to close modal
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
        
        // Initial render
        renderTable();
    </script>
@endsection