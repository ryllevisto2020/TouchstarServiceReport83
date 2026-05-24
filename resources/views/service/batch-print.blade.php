<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batch Service Reports - MediTech Solutions</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        @media print {
            body { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .no-print { display: none !important; }
            .report-card { page-break-after: always; break-inside: avoid; box-shadow: none !important; margin: 0 !important; border-radius: 0 !important; }
            .report-card:last-child { page-break-after: auto; }
            @page { size: A4; margin: 12mm; }
        }
        @media screen {
            body { background: #F3F4F6; }
            .report-card { background: white; margin-bottom: 2rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border-radius: 1rem; overflow: hidden; }
            .report-card:hover { box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); transform: translateY(-2px); transition: all 0.3s ease; }
        }
        .fade-in { animation: fadeIn 0.5s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="font-sans antialiased" onload="loadBatchReports()">
    
    <!-- Action Bar -->
    <div class="no-print fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-200 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-3">
                <div class="flex items-center space-x-3">
                    <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl p-2.5 shadow-lg">
                        <i class="fas fa-print text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Batch Print Service Reports</h2>
                        <p class="text-sm text-gray-600" id="batchCount">Loading...</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button onclick="window.print()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-print mr-2"></i> Print All Reports
                    </button>
                    <button onclick="window.close()" class="inline-flex items-center px-5 py-3 bg-white hover:bg-gray-50 text-gray-700 text-sm font-bold rounded-xl border-2 border-gray-300 transition-all">
                        <i class="fas fa-times mr-2"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto pt-24 pb-8">
        
        <!-- Summary -->
        <div class="no-print bg-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4" id="summaryCards">
                <!-- Filled dynamically -->
            </div>
        </div>

        <!-- Reports Container -->
        <div id="reportsContainer">
            <!-- Filled dynamically -->
        </div>

        <!-- Footer -->
        <div class="no-print text-center mt-8 text-gray-500">
            <p class="text-sm">Generated from Service Report Management System</p>
            <p class="text-xs mt-1">© 2024 Medical Solutions Inc. All rights reserved.</p>
        </div>
    </div>

    <script>
        const MOCK_REPORTS = [
            { id: 1001, machine_name: "HemaTech X100", model: "HTX-100", serial_number: "SN-HTX-8821", client_location: "Manila", client_name: "WellMed Diagnostics", service_type: "PMS", service_date: "2025-02-10", formatted_date: "Feb 10, 2025", root_cause_findings: "Calibration drift on laser module. QC outliers detected on HGB channel.", action_taken: "Realigned optics, performed full QC calibration, replaced cuvette washer.", parts_replaced: [{qty:1, particulars:"Laser diode", si_dr_no:"SI-2024-001"}], equipment_status: "Operational", recommendations: "Schedule quarterly calibration and monthly QC checks.", service_engineer: "Michael Tan", approved_by: "Dr. Reyes", service_images: 2 },
            { id: 1002, machine_name: "MRI 3T Pro", model: "SIGNA", serial_number: "SN-MRI-4532", client_location: "Cebu", client_name: "MetroHealth Labs", service_type: "Troubleshooting", service_date: "2025-02-18", formatted_date: "Feb 18, 2025", root_cause_findings: "Noise artifact in axial view, RF interference suspected.", action_taken: "Replaced RF amplifier board, performed system noise test.", parts_replaced: [{qty:1, particulars:"RF Amp Board", si_dr_no:"DR-2024-045"}], equipment_status: "Operational", recommendations: "Monitor weekly for 1 month.", service_engineer: "Sarah Gomez", approved_by: "Dr. Alonzo", service_images: 3 },
            { id: 1003, machine_name: "Ultrasound Logiq E10", model: "E10", serial_number: "SN-ULT-1290", client_location: "Davao", client_name: "St. Catherine Hospital", service_type: "Installation", service_date: "2025-02-05", formatted_date: "Feb 5, 2025", root_cause_findings: "New installation & configuration of ultrasound system.", action_taken: "Installed software, calibrated all probes, trained sonographers.", parts_replaced: [], equipment_status: "Operational", recommendations: "User training completion required.", service_engineer: "James Cruz", approved_by: "Engr. Villanueva", service_images: 5 },
            { id: 1004, machine_name: "Centrifuge CL-2", model: "CryoSpin", serial_number: "SN-CEN-876", client_location: "Laguna", client_name: "Northside Imaging", service_type: "Warranty", service_date: "2025-01-28", formatted_date: "Jan 28, 2025", root_cause_findings: "Motor not spinning, rotor imbalance error.", action_taken: "Replaced motor assembly and rotor locking mechanism.", parts_replaced: [{qty:1, particulars:"Drive motor", si_dr_no:"SI-2024-089"},{qty:1, particulars:"Rotor lock", si_dr_no:"SI-2024-090"}], equipment_status: "Operational", recommendations: "Check belt tension monthly.", service_engineer: "Patricia Lim", approved_by: "Mr. Lim", service_images: 1 },
            { id: 1005, machine_name: "HemaTech X100", model: "HTX-100", serial_number: "SN-HTX-8821", client_location: "Manila", client_name: "WellMed Diagnostics", service_type: "Troubleshooting", service_date: "2025-01-15", formatted_date: "Jan 15, 2025", root_cause_findings: "Intermittent power failure, unit reboots randomly.", action_taken: "Replaced PSU capacitor bank, verified voltage stability.", parts_replaced: [{qty:1, particulars:"Power supply unit", si_dr_no:"SI-2024-095"}], equipment_status: "Operational", recommendations: "Add voltage regulator to outlet.", service_engineer: "Michael Tan", approved_by: "Dr. Reyes", service_images: 2 },
            { id: 1006, machine_name: "Anesthesia Workstation", model: "Aisys CS2", serial_number: "SN-AN-3340", client_location: "Manila", client_name: "WellMed Diagnostics", service_type: "PMS", service_date: "2025-02-22", formatted_date: "Feb 22, 2025", root_cause_findings: "Gas flow sensor deviation, O2 readings unstable.", action_taken: "Calibrated flow sensors, replaced O2 cell, updated firmware.", parts_replaced: [{qty:1, particulars:"O2 sensor", si_dr_no:"SI-2024-102"}], equipment_status: "Operational", recommendations: "Recalibrate after 6 months.", service_engineer: "Sarah Gomez", approved_by: "Dr. Cruz", service_images: 4 },
            { id: 1008, machine_name: "ECG Mac 2000", model: "MAC 2000", serial_number: "SN-ECG-9921", client_location: "Quezon City", client_name: "Makati Medical Center", service_type: "PMS", service_date: "2025-02-28", formatted_date: "Feb 28, 2025", root_cause_findings: "Baseline wander on lead II, electrode cable wear.", action_taken: "Replaced patient cable, cleaned electrode inputs, performed signal test.", parts_replaced: [{qty:1, particulars:"10-lead patient cable", si_dr_no:"SI-2024-110"}], equipment_status: "Operational", recommendations: "Replace cables annually.", service_engineer: "Anna Reyes", approved_by: "Dr. Santos", service_images: 1 }
        ];

        function loadBatchReports() {
            const urlParams = new URLSearchParams(window.location.search);
            const idsParam = urlParams.get('ids');
            
            let reportsToPrint = MOCK_REPORTS;
            
            // If specific IDs are provided, filter
            if (idsParam) {
                const ids = idsParam.split(',').map(Number);
                reportsToPrint = MOCK_REPORTS.filter(r => ids.includes(r.id));
            }
            
            // Update count
            document.getElementById('batchCount').textContent = `${reportsToPrint.length} Reports • Preview Mode`;
            
            // Update summary
            const operational = reportsToPrint.filter(r => r.equipment_status === 'Operational').length;
            const notOperational = reportsToPrint.filter(r => r.equipment_status === 'Not Operational').length;
            const uniqueEngineers = [...new Set(reportsToPrint.map(r => r.service_engineer))].length;
            
            document.getElementById('summaryCards').innerHTML = `
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div><p class="text-sm text-blue-600 font-medium">Total Reports</p><p class="text-2xl font-bold text-blue-900">${reportsToPrint.length}</p></div>
                        <i class="fas fa-file-alt text-4xl text-blue-300"></i>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
                    <div class="flex items-center justify-between">
                        <div><p class="text-sm text-green-600 font-medium">Operational</p><p class="text-2xl font-bold text-green-900">${operational}</p></div>
                        <i class="fas fa-check-circle text-4xl text-green-300"></i>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 border border-red-200">
                    <div class="flex items-center justify-between">
                        <div><p class="text-sm text-red-600 font-medium">Not Operational</p><p class="text-2xl font-bold text-red-900">${notOperational}</p></div>
                        <i class="fas fa-exclamation-triangle text-4xl text-red-300"></i>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
                    <div class="flex items-center justify-between">
                        <div><p class="text-sm text-purple-600 font-medium">Engineers</p><p class="text-2xl font-bold text-purple-900">${uniqueEngineers}</p></div>
                        <i class="fas fa-users text-4xl text-purple-300"></i>
                    </div>
                </div>
            `;
            
            // Generate report cards
            const statusColors = {
                'PMS': 'bg-blue-100 text-blue-700',
                'Troubleshooting': 'bg-orange-100 text-orange-700',
                'Installation': 'bg-purple-100 text-purple-700',
                'Warranty': 'bg-teal-100 text-teal-700'
            };
            
            document.getElementById('reportsContainer').innerHTML = reportsToPrint.map((report, index) => {
                const statusColor = statusColors[report.service_type] || 'bg-gray-100 text-gray-700';
                const eqStatusColor = report.equipment_status === 'Operational' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                
                return `
                <div class="report-card fade-in" style="animation-delay: ${index * 0.15}s;">
                    <div class="p-6 md:p-8">
                        <!-- Report Header -->
                        <div class="border-b-4 border-blue-600 pb-6 mb-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                                    <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl p-3 shadow-lg">
                                        <i class="fas fa-heartbeat text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black text-gray-900">MEDICAL SOLUTIONS INC.</h3>
                                        <p class="text-sm text-gray-600">Professional Equipment Services</p>
                                    </div>
                                </div>
                                <div class="text-left md:text-right">
                                    <span class="bg-blue-600 text-white px-3 py-1 rounded-lg text-xs font-bold">REPORT #${report.id}</span>
                                    <p class="text-sm font-medium text-gray-700 mt-1">${report.formatted_date}</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Machine Info -->
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-5 border border-gray-200">
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wider mb-3">
                                    <i class="fas fa-laptop-medical mr-1"></i> Machine Details
                                </h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm"><span class="text-gray-600">Location:</span><span class="font-semibold text-gray-900">${report.client_location}</span></div>
                                    <div class="flex justify-between text-sm"><span class="text-gray-600">Machine:</span><span class="font-semibold text-gray-900">${report.machine_name}</span></div>
                                    <div class="flex justify-between text-sm"><span class="text-gray-600">Model:</span><span class="font-semibold text-gray-900">${report.model}</span></div>
                                    <div class="flex justify-between text-sm"><span class="text-gray-600">Serial No:</span><span class="font-bold text-blue-600 font-mono">${report.serial_number}</span></div>
                                </div>
                            </div>

                            <!-- Service Info -->
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-5 border border-blue-200">
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wider mb-3">
                                    <i class="fas fa-tools mr-1"></i> Service Details
                                </h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm"><span class="text-gray-600">Type:</span><span class="px-2 py-0.5 rounded-full text-xs font-bold ${statusColor}">${report.service_type}</span></div>
                                    <div class="flex justify-between text-sm"><span class="text-gray-600">Engineer:</span><span class="font-semibold text-gray-900">${report.service_engineer}</span></div>
                                    <div class="flex justify-between text-sm"><span class="text-gray-600">Status:</span><span class="px-2 py-0.5 rounded-full text-xs font-bold ${eqStatusColor}">${report.equipment_status}</span></div>
                                    <div class="flex justify-between text-sm"><span class="text-gray-600">Approved By:</span><span class="font-semibold text-gray-900">${report.approved_by}</span></div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Summary -->
                        <div class="mt-4 bg-gradient-to-r from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-bold text-gray-600 uppercase">Issue/Findings:</p>
                                    <p class="text-sm text-gray-700 mt-1">${report.root_cause_findings.substring(0, 100)}${report.root_cause_findings.length > 100 ? '...' : ''}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-600 uppercase">Action Taken:</p>
                                    <p class="text-sm text-gray-700 mt-1">${report.action_taken.substring(0, 100)}${report.action_taken.length > 100 ? '...' : ''}</p>
                                </div>
                            </div>
                            ${report.parts_replaced?.length ? `<p class="text-xs text-gray-500 mt-2"><i class="fas fa-tools mr-1"></i>${report.parts_replaced.length} part(s) replaced</p>` : ''}
                            ${report.service_images ? `<p class="text-xs text-gray-500 mt-1"><i class="fas fa-camera mr-1"></i>${report.service_images} image(s) attached</p>` : ''}
                        </div>
                    </div>
                </div>
                `;
            }).join('');
        }
    </script>
</body>
</html>