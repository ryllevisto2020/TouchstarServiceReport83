<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Report #<span id="reportId"></span> - MediTech Solutions</title>
    
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
        
        // Get report ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        const reportId = urlParams.get('id');
        document.title = `Service Report #${reportId} - MediTech Solutions`;
    </script>

    <style>
        @media print {
            body { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .no-print { display: none !important; }
            .print-container { box-shadow: none !important; margin: 0 !important; padding: 0 !important; }
            .print-break { page-break-before: always; }
            @page { size: A4; margin: 15mm; }
        }
        @media screen {
            body { background: #F3F4F6; }
            .print-container { max-width: 210mm; margin: 2rem auto; background: white; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
        }
    </style>
</head>
<body class="font-sans antialiased" onload="loadReportData()">
    
    <!-- Action Bar -->
    <div class="no-print fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-200 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-3">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-600 rounded-lg p-2">
                        <i class="fas fa-file-alt text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-gray-900">Service Report</h2>
                        <p class="text-xs text-gray-500" id="headerReportId">#Loading...</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button onclick="window.print()" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 shadow-md">
                        <i class="fas fa-print mr-2"></i> Print Report
                    </button>
                    <button onclick="window.close()" class="inline-flex items-center px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg border border-gray-300 transition-all">
                        <i class="fas fa-times mr-2"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Content -->
    <div class="print-container bg-white min-h-screen pt-16 print:pt-0">
        <div id="printContent" class="max-w-4xl mx-auto p-8 md:p-12 lg:p-16 print:p-8">
            <!-- Content will be loaded dynamically -->
            <div class="text-center py-12">
                <i class="fas fa-spinner fa-spin text-4xl text-blue-600 mb-4"></i>
                <p class="text-gray-600">Loading report data...</p>
            </div>
        </div>
    </div>

    <script>
        const MOCK_REPORTS = [
            { id: 1001, machine_name: "HemaTech X100", model: "HTX-100", serial_number: "SN-HTX-8821", client_location: "Manila", client_name: "WellMed Diagnostics", service_type: "PMS", service_date: "2025-02-10", formatted_date: "Feb 10, 2025", root_cause_findings: "Calibration drift on laser module. QC outliers detected on HGB channel.", action_taken: "Realigned optics, performed full QC calibration, replaced cuvette washer.", parts_replaced: [{qty:1, particulars:"Laser diode", si_dr_no:"SI-2024-001"}], equipment_status: "Operational", recommendations: "Schedule quarterly calibration and monthly QC checks.", service_engineer: "Michael Tan", approved_by: "Dr. Reyes", identification_verification: "Patient table movement checked and verified. All sensors responding correctly. Image quality calibration performed.", service_images: ["before1.jpg","before2.jpg"], after_images: ["after1.jpg","after2.jpg"], medtech_signature: null },
            { id: 1002, machine_name: "MRI 3T Pro", model: "SIGNA", serial_number: "SN-MRI-4532", client_location: "Cebu", client_name: "MetroHealth Labs", service_type: "Troubleshooting", service_date: "2025-02-18", formatted_date: "Feb 18, 2025", root_cause_findings: "Noise artifact in axial view, RF interference suspected.", action_taken: "Replaced RF amplifier board, performed system noise test.", parts_replaced: [{qty:1, particulars:"RF Amp Board", si_dr_no:"DR-2024-045"}], equipment_status: "Operational", recommendations: "Monitor weekly for 1 month.", service_engineer: "Sarah Gomez", approved_by: "Dr. Alonzo", identification_verification: "RF shielding integrity verified. All connections secured.", service_images: ["service1.jpg","service2.jpg","service3.jpg"], after_images: [], medtech_signature: null },
            { id: 1003, machine_name: "Ultrasound Logiq E10", model: "E10", serial_number: "SN-ULT-1290", client_location: "Davao", client_name: "St. Catherine Hospital", service_type: "Installation", service_date: "2025-02-05", formatted_date: "Feb 5, 2025", root_cause_findings: "New installation & configuration of ultrasound system.", action_taken: "Installed software, calibrated all probes, trained sonographers.", parts_replaced: [], equipment_status: "Operational", recommendations: "User training completion required.", service_engineer: "James Cruz", approved_by: "Engr. Villanueva", identification_verification: "System installation complete. All probes calibrated.", service_images: ["install1.jpg","install2.jpg","install3.jpg","install4.jpg","install5.jpg"], after_images: [], medtech_signature: null },
            { id: 1004, machine_name: "Centrifuge CL-2", model: "CryoSpin", serial_number: "SN-CEN-876", client_location: "Laguna", client_name: "Northside Imaging", service_type: "Warranty", service_date: "2025-01-28", formatted_date: "Jan 28, 2025", root_cause_findings: "Motor not spinning, rotor imbalance error.", action_taken: "Replaced motor assembly and rotor locking mechanism.", parts_replaced: [{qty:1, particulars:"Drive motor", si_dr_no:"SI-2024-089"},{qty:1, particulars:"Rotor lock", si_dr_no:"SI-2024-090"}], equipment_status: "Operational", recommendations: "Check belt tension monthly.", service_engineer: "Patricia Lim", approved_by: "Mr. Lim", identification_verification: "Rotor assembly inspected. All components secure.", service_images: ["warranty1.jpg"], after_images: [], medtech_signature: null },
            { id: 1005, machine_name: "HemaTech X100", model: "HTX-100", serial_number: "SN-HTX-8821", client_location: "Manila", client_name: "WellMed Diagnostics", service_type: "Troubleshooting", service_date: "2025-01-15", formatted_date: "Jan 15, 2025", root_cause_findings: "Intermittent power failure, unit reboots randomly.", action_taken: "Replaced PSU capacitor bank, verified voltage stability.", parts_replaced: [{qty:1, particulars:"Power supply unit", si_dr_no:"SI-2024-095"}], equipment_status: "Operational", recommendations: "Add voltage regulator to outlet.", service_engineer: "Michael Tan", approved_by: "Dr. Reyes", identification_verification: "Power supply checked. Voltage output stable.", service_images: ["trouble1.jpg","trouble2.jpg"], after_images: ["after3.jpg"], medtech_signature: null }
        ];

        function loadReportData() {
            const urlParams = new URLSearchParams(window.location.search);
            const reportId = parseInt(urlParams.get('id'));
            
            const report = MOCK_REPORTS.find(r => r.id === reportId);
            
            if (!report) {
                document.getElementById('printContent').innerHTML = `
                    <div class="text-center py-12">
                        <i class="fas fa-exclamation-triangle text-4xl text-red-500 mb-4"></i>
                        <p class="text-gray-800 font-semibold">Report not found</p>
                        <p class="text-gray-600 mt-2">Service report #${reportId} does not exist.</p>
                        <button onclick="window.close()" class="mt-4 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">Close</button>
                    </div>
                `;
                return;
            }

            document.getElementById('headerReportId').textContent = `#${report.id}`;
            document.getElementById('reportId').textContent = report.id;

            const serviceTypes = Array.isArray(report.service_type) ? report.service_type.join(', ') : report.service_type;
            const partsReplacedHtml = report.parts_replaced?.length ? `
                <div class="mb-8 print-break">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-lg p-2.5 mr-3 shadow-md">
                            <i class="fas fa-cogs text-white"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Parts Replaced</h2>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Qty</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Particulars</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">SI/DR No.</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                ${report.parts_replaced.map(p => `
                                    <tr class="hover:bg-blue-50 transition-colors">
                                        <td class="px-6 py-4 text-sm font-bold">${p.qty}</td>
                                        <td class="px-6 py-4 text-sm font-medium">${p.particulars}</td>
                                        <td class="px-6 py-4 text-sm font-mono">${p.si_dr_no}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>
            ` : '';

            document.getElementById('printContent').innerHTML = `
                <!-- Header -->
                <div class="border-b-4 border-blue-600 pb-8 mb-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center space-x-4 mb-6 md:mb-0">
                            <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl p-3 shadow-lg">
                                <i class="fas fa-heartbeat text-white text-3xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl md:text-3xl font-black text-gray-900">MEDICAL SOLUTIONS INC.</h1>
                                <p class="text-sm text-gray-600 font-medium">Professional Equipment Services</p>
                            </div>
                        </div>
                        <div class="text-left md:text-right">
                            <div class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg mb-2">
                                <p class="text-sm font-bold">SERVICE REPORT</p>
                            </div>
                            <div class="space-y-1 text-sm">
                                <p class="font-bold text-gray-900">Report #${report.id}</p>
                                <p class="text-gray-600">${report.formatted_date}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Machine Information -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-2.5 mr-3 shadow-md">
                            <i class="fas fa-laptop-medical text-white"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Machine Information</h2>
                    </div>
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200 shadow-sm">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><label class="text-xs font-bold text-blue-600 uppercase">Client Location</label><p class="text-sm font-semibold bg-white rounded-lg px-3 py-2 border">${report.client_location}</p></div>
                            <div><label class="text-xs font-bold text-blue-600 uppercase">Machine Name</label><p class="text-sm font-semibold bg-white rounded-lg px-3 py-2 border">${report.machine_name}</p></div>
                            <div><label class="text-xs font-bold text-blue-600 uppercase">Model</label><p class="text-sm font-semibold bg-white rounded-lg px-3 py-2 border">${report.model}</p></div>
                            <div><label class="text-xs font-bold text-blue-600 uppercase">Serial Number</label><p class="text-sm font-bold text-blue-600 bg-blue-50 rounded-lg px-3 py-2 border border-blue-200 font-mono">${report.serial_number}</p></div>
                        </div>
                    </div>
                </div>

                <!-- Service Information -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-2.5 mr-3 shadow-md">
                            <i class="fas fa-tools text-white"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Service Information</h2>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200 shadow-sm">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><label class="text-xs font-bold text-blue-600 uppercase">Service Type</label><p class="text-sm font-semibold bg-white rounded-lg px-3 py-2 border border-blue-200">${serviceTypes}</p></div>
                            <div><label class="text-xs font-bold text-blue-600 uppercase">Service Engineer</label><p class="text-sm font-semibold bg-white rounded-lg px-3 py-2 border border-blue-200">${report.service_engineer}</p></div>
                            <div><label class="text-xs font-bold text-blue-600 uppercase">Equipment Status</label><span class="inline-flex px-3 py-2 rounded-lg text-xs font-bold ${report.equipment_status === 'Operational' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">${report.equipment_status}</span></div>
                            <div><label class="text-xs font-bold text-blue-600 uppercase">Approved By</label><p class="text-sm font-semibold bg-white rounded-lg px-3 py-2 border border-blue-200">${report.approved_by}</p></div>
                        </div>
                    </div>
                </div>

                <!-- Service Details -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-2.5 mr-3 shadow-md">
                            <i class="fas fa-clipboard-check text-white"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Service Details</h2>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-5 py-3 border-b border-gray-200">
                                <h3 class="text-sm font-bold text-gray-700 uppercase">Identification / Verification</h3>
                            </div>
                            <div class="p-5"><p class="text-sm text-gray-900 leading-relaxed">${report.identification_verification || 'N/A'}</p></div>
                        </div>
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-5 py-3 border-b border-gray-200">
                                <h3 class="text-sm font-bold text-gray-700 uppercase">Root Cause / Findings</h3>
                            </div>
                            <div class="p-5"><p class="text-sm text-gray-900 leading-relaxed">${report.root_cause_findings}</p></div>
                        </div>
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-5 py-3 border-b border-gray-200">
                                <h3 class="text-sm font-bold text-gray-700 uppercase">Action Taken</h3>
                            </div>
                            <div class="p-5"><p class="text-sm text-gray-900 leading-relaxed">${report.action_taken}</p></div>
                        </div>
                        ${report.recommendations ? `
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-5 py-3 border-b border-gray-200">
                                <h3 class="text-sm font-bold text-gray-700 uppercase">Recommendations</h3>
                            </div>
                            <div class="p-5"><p class="text-sm text-gray-900 leading-relaxed">${report.recommendations}</p></div>
                        </div>` : ''}
                    </div>
                </div>

                ${partsReplacedHtml}

                <!-- Signatures -->
                <div class="mt-16 pt-8 border-t-4 border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 mb-8 text-center">
                        <i class="fas fa-pen-fancy text-blue-600 mr-2"></i>Authorized Signatures
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <div class="text-center">
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border-2 border-blue-200 shadow-lg">
                                <h3 class="text-sm font-bold text-blue-600 uppercase mb-6">Approved By (MedTech)</h3>
                                <div class="h-32 flex items-end justify-center mb-6 bg-white/50 rounded-lg p-4">
                                    <div class="text-gray-400">Signature</div>
                                </div>
                                <div class="w-full border-t-2 border-gray-400 mb-3"></div>
                                <p class="text-base font-bold text-gray-900">${report.approved_by}</p>
                                <p class="text-sm text-gray-600 font-medium">Medical Technologist</p>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border-2 border-green-200 shadow-lg">
                                <h3 class="text-sm font-bold text-green-600 uppercase mb-6">Service Engineer</h3>
                                <div class="h-32 flex items-end justify-center mb-6 bg-white/50 rounded-lg p-4">
                                    <div class="text-gray-400">Signature</div>
                                </div>
                                <div class="w-full border-t-2 border-gray-400 mb-3"></div>
                                <p class="text-base font-bold text-gray-900">${report.service_engineer}</p>
                                <p class="text-sm text-gray-600 font-medium">Service Engineer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-12 pt-6 border-t-2 border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                        <p>Generated on: ${new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                        <p class="mt-2 md:mt-0">© ${new Date().getFullYear()} Medical Solutions Inc. All rights reserved.</p>
                    </div>
                </div>
            `;
        }
    </script>
</body>
</html>