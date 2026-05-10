@extends('layouts.client')
@section('title', 'Service Report History')
@section('content')

<script>
const RECORDS = [
  { id:1, machine:"Mindray MX-900", model:"MX-900", serial:"SN-20241101-001", type:"Preventive Maintenance", engineer:"Ramon dela Cruz", status:"Operational", date:"May 08, 2025", time:"9:30 AM", problem:"Unit displaying intermittent low battery warnings despite AC power. Screen brightness degraded during extended use.", root:"Defective battery management IC causing false drain readings. Display backlight driver PCB showing early signs of capacitor aging.", actions:"Replaced battery management module. Recalibrated power sensing circuit. Cleaned and reseated display ribbon cable. Conducted 2-hour burn-in test — unit passed all checks.", recommendations:"Schedule next PMS in 3 months. Install surge protector on outlet.", id_verification:"Unit serial number verified against service log. All patient contact surfaces cleaned per hospital protocol.", parts:[{qty:1,item:"Battery Management IC",si:"SI-2025-001"},{qty:2,item:"Backlight Capacitor 100µF",si:"SI-2025-002"}], before:2, after:2 },
  { id:2, machine:"Draeger Evita XL", model:"Evita XL", serial:"SN-20241101-002", type:"Troubleshooting", engineer:"Maria Santos", status:"Not Operational", date:"May 06, 2025", time:"2:15 PM", problem:"Ventilator alarming on high pressure limit. Patient circuit pressure readings inconsistent with set parameters.", root:"Partially blocked expiratory valve due to secretion buildup. Flow sensor calibration drift detected after 14 months.", actions:"Disassembled and cleaned expiratory valve assembly. Replaced flow sensor. Performed full ventilator calibration and leak test. Unit requires follow-up within 7 days.", recommendations:"Follow-up visit required within 7 days. Recommend daily expiratory valve inspection by nursing staff.", id_verification:"Unit tagged Out of Service pending part arrival. Serial verified against hospital equipment register.", parts:[{qty:1,item:"Flow Sensor Assembly",si:"SI-2025-010"},{qty:1,item:"Expiratory Valve Seal Kit",si:"SI-2025-011"}], before:3, after:0 },
  { id:3, machine:"Nihon Kohden BSM-6000", model:"BSM-6000", serial:"SN-20230615-008", type:"Calibration", engineer:"Joel Reyes", status:"Operational", date:"May 05, 2025", time:"10:00 AM", problem:"Routine annual calibration due. SpO2 readings slightly off from reference by ±2%.", root:"SpO2 sensor drift after 18 months of continuous use.", actions:"Performed full multi-parameter calibration per manufacturer protocol. Adjusted SpO2, NIBP, and temperature offsets. Verified ECG lead performance. All parameters within spec.", recommendations:"Next calibration due May 2026.", id_verification:"Calibration reference equipment certificates verified and on file. Unit calibration stickers updated.", parts:[], before:1, after:1 },
  { id:4, machine:"GE Logiq E10", model:"Logiq E10", serial:"SN-20220310-014", type:"Installation", engineer:"Ana Flores", status:"Operational", date:"Apr 29, 2025", time:"11:45 AM", problem:"New unit installation at Radiology Department, Room 3.", root:"N/A — New unit installation.", actions:"Unboxed and inspected unit. Installed at designated workstation. Configured DICOM network settings. Performed image quality verification and handed over to department head with user orientation.", recommendations:"User training follow-up in 2 weeks for remaining staff.", id_verification:"System installation complete. All probes calibrated against phantom. PACS connectivity tested with IT.", parts:[], before:5, after:3 },
  { id:5, machine:"Philips IntelliVue MP70", model:"MP70", serial:"SN-20210820-003", type:"Warranty", engineer:"Carlos Tan", status:"Operational", date:"Apr 24, 2025", time:"8:00 AM", problem:"Touch screen unresponsive in the lower-right quadrant.", root:"Digitizer film delamination — covered under active manufacturer warranty.", actions:"Filed warranty claim with Philips. Replaced touchscreen digitizer assembly under warranty. Performed full functional test post-replacement. No charges to client.", recommendations:"Monitor for recurrence over next 30 days.", id_verification:"Warranty status confirmed with Philips distributor. Serial number registered in warranty system.", parts:[{qty:1,item:"Touchscreen Digitizer Assembly",si:"WR-2025-041"}], before:1, after:1 },
  { id:6, machine:"Hamilton C6 Ventilator", model:"C6", serial:"SN-20230101-011", type:"Troubleshooting", engineer:"Ramon dela Cruz", status:"Not Operational", date:"Apr 20, 2025", time:"3:30 PM", problem:"Unit throwing E-045 hardware fault. Cannot enter operational mode.", root:"Main control board failure. Component-level fault in the power regulation subsystem confirmed via diagnostic port.", actions:"Isolated fault to main PCB. Replacement board ordered from distributor — ETA 5 business days. Unit tagged Out of Service pending repair.", recommendations:"Do not use unit until replacement board is installed and verified.", id_verification:"Fault code E-045 logged. Unit quarantined and tagged per hospital HTMO protocol.", parts:[{qty:1,item:"Main Control PCB (Hamilton C6)",si:"PO-2025-088"}], before:2, after:0 },
  { id:7, machine:"Sysmex XN-3000", model:"XN-3000", serial:"SN-20191205-021", type:"Preventive Maintenance", engineer:"Joel Reyes", status:"Operational", date:"Apr 17, 2025", time:"1:00 PM", problem:"Scheduled quarterly preventive maintenance service.", root:"No issues found — routine maintenance only.", actions:"Cleaned sample probe and flow cell. Replaced sheath fluid filter. Ran QC materials and verified CBC+Diff accuracy. All parameters within acceptable range.", recommendations:"Next PMS scheduled for July 2025.", id_verification:"QC materials lot numbers recorded in service log. Maintenance sticker updated.", parts:[{qty:1,item:"Sheath Fluid Filter",si:"SI-2025-055"},{qty:1,item:"Sample Probe Cleaning Kit",si:"SI-2025-056"}], before:1, after:1 },
  { id:8, machine:"Spacelabs 91370", model:"91370", serial:"SN-20200718-006", type:"Calibration", engineer:"Maria Santos", status:"Operational", date:"Apr 10, 2025", time:"10:30 AM", problem:"Annual calibration required per hospital protocol.", root:"Battery backup holding less than 60% capacity. No calibration drift detected.", actions:"Performed NIBP calibration against mercury reference. Verified alarm thresholds and SpO2 accuracy. Replaced backup battery.", recommendations:"Next calibration due April 2026.", id_verification:"Reference sphygmomanometer calibration certificate on file. Battery replaced and tested.", parts:[{qty:1,item:"Backup Battery Pack 12V 4Ah",si:"SI-2025-060"}], before:0, after:0 },
  { id:9, machine:"Mindray DC-70", model:"DC-70", serial:"SN-20240205-019", type:"Installation", engineer:"Ana Flores", status:"Operational", date:"Apr 03, 2025", time:"9:00 AM", problem:"New ultrasound unit installation at OB-GYN Department.", root:"N/A — New installation.", actions:"Completed site inspection and equipment positioning. Installed transducers, configured OB/GYN presets. Connected to hospital PACS via DICOM. User training conducted for 4 staff members.", recommendations:"Follow-up training session in 2 weeks for remaining 3 staff.", id_verification:"PACS connectivity tested with IT department. DICOM tags verified. All probes calibrated.", parts:[], before:7, after:2 },
  { id:10, machine:"Siemens ACUSON SC2000", model:"SC2000", serial:"SN-20180430-033", type:"Troubleshooting", engineer:"Carlos Tan", status:"Not Operational", date:"Mar 28, 2025", time:"4:00 PM", problem:"System not booting. Stuck on POST screen with error code 0xA3.", root:"HDD failure confirmed. Boot sector corrupted from brownout event.", actions:"Cloned original HDD to new SSD using disk imaging tool. System boots successfully. Full imaging function scan performed and passed.", recommendations:"Install a UPS for this workstation immediately to prevent recurrence.", id_verification:"System boot log reviewed. Error code 0xA3 confirmed as HDD fault via hardware diagnostic.", parts:[{qty:1,item:"256GB SSD (replacement HDD)",si:"SI-2025-071"},{qty:1,item:"SATA Data Cable",si:"SI-2025-072"}], before:2, after:1 }
];

function typeIcon(t){ return {Troubleshooting:"fa-wrench",Installation:"fa-screwdriver-wrench",Warranty:"fa-file-contract",Calibration:"fa-ruler-combined","Preventive Maintenance":"fa-shield-check"}[t]||"fa-tools"; }
function typeBadge(t){ return {Troubleshooting:"bg-orange-100 text-orange-800",Installation:"bg-purple-100 text-purple-800",Warranty:"bg-teal-100 text-teal-800",Calibration:"bg-indigo-100 text-indigo-800","Preventive Maintenance":"bg-blue-100 text-blue-800"}[t]||"bg-gray-100 text-gray-700"; }
function mIcon(n){ if(/ventilator|evita|hamilton/i.test(n)) return "fa-lungs"; if(/mri|ct|logiq|acuson|dc-70|ultrasound/i.test(n)) return "fa-radiation"; if(/sysmex|hema/i.test(n)) return "fa-microscope"; return "fa-heartbeat"; }
function mColor(n){ if(/ventilator|evita|hamilton/i.test(n)) return "bg-violet-50 text-violet-400 border-violet-100"; if(/mri|ct|logiq|acuson|dc-70/i.test(n)) return "bg-amber-50 text-amber-500 border-amber-100"; if(/sysmex|hema/i.test(n)) return "bg-emerald-50 text-emerald-500 border-emerald-100"; return "bg-blue-50 text-blue-400 border-blue-100"; }

function svgDataUrl(label, w, h, bg){
  const svg = `<svg xmlns='http://www.w3.org/2000/svg' width='${w}' height='${h}'><rect width='${w}' height='${h}' fill='${bg}' rx='4'/><text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' font-size='${w>100?18:10}' fill='#6B7280' font-family='sans-serif'>${label}</text></svg>`;
  return 'data:image/svg+xml;base64,' + btoa(svg);
}
const COLORS = ["#DBEAFE","#D1FAE5","#FEF3C7","#EDE9FE","#FCE7F3","#E0F2FE","#FEE2E2","#ECFDF5"];
</script>

<div class="no-print">
  <nav class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between sticky top-0 z-40 shadow-sm">
    <div class="flex items-center gap-3">
      <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-sm">
        <i class="fas fa-heart-pulse text-white text-sm"></i>
      </div>
      <span class="font-bold text-gray-900 text-sm tracking-tight">TouchStar Medical</span>
      <span class="text-gray-300">|</span>
      <span class="text-gray-500 text-xs">St. Luke's Medical Center</span>
    </div>
    <span class="text-xs text-gray-400">Client Portal</span>
  </nav>

  <main class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 flex items-start justify-between flex-wrap gap-4">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Service Reports</h1>
        <p class="text-gray-500 text-sm mt-1">St. Luke's Medical Center — Complete service history &amp; maintenance records</p>
      </div>
      <button onclick="batchPrint()" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors text-sm gap-2 shadow-sm">
        <i class="fas fa-print"></i> Batch Print
      </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
      <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500 flex items-center gap-4">
        <div class="p-2.5 rounded-xl bg-blue-50 text-blue-600 text-lg"><i class="fas fa-clipboard-list"></i></div>
        <div><p class="text-xs text-gray-500 font-medium">Total Services</p><p class="text-2xl font-bold text-gray-900">148</p></div>
      </div>
      <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500 flex items-center gap-4">
        <div class="p-2.5 rounded-xl bg-green-50 text-green-600 text-lg"><i class="fas fa-calendar-check"></i></div>
        <div><p class="text-xs text-gray-500 font-medium">This Month</p><p class="text-2xl font-bold text-gray-900">12</p></div>
      </div>
      <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500 flex items-center gap-4">
        <div class="p-2.5 rounded-xl bg-purple-50 text-purple-600 text-lg"><i class="fas fa-user-cog"></i></div>
        <div><p class="text-xs text-gray-500 font-medium">Engineers</p><p class="text-2xl font-bold text-gray-900">6</p></div>
      </div>
      <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-amber-500 flex items-center gap-4">
        <div class="p-2.5 rounded-xl bg-amber-50 text-amber-600 text-lg"><i class="fas fa-clock"></i></div>
        <div><p class="text-xs text-gray-500 font-medium">Avg. Response</p><p class="text-2xl font-bold text-gray-900">2.4h</p></div>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm mb-8">
      <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
        <i class="fas fa-sliders text-gray-400 text-sm"></i>
        <h3 class="text-sm font-semibold text-gray-900">Filter Service Reports</h3>
      </div>
      <div class="p-5">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <div><label class="block text-xs font-semibold text-gray-500 mb-1.5">Serial Number</label>
            <select><option>All Serial Numbers</option><option>SN-20241101-001</option><option>SN-20241101-002</option><option>SN-20230615-008</option></select></div>
          <div><label class="block text-xs font-semibold text-gray-500 mb-1.5">Service Type</label>
            <select><option>All Types</option><option>Preventive Maintenance</option><option>Troubleshooting</option><option>Installation</option><option>Warranty</option><option>Calibration</option></select></div>
          <div><label class="block text-xs font-semibold text-gray-500 mb-1.5">Service Engineer</label>
            <select><option>All Engineers</option><option>Ramon dela Cruz</option><option>Maria Santos</option><option>Joel Reyes</option><option>Ana Flores</option><option>Carlos Tan</option></select></div>
          <div><label class="block text-xs font-semibold text-gray-500 mb-1.5">Equipment Status</label>
            <select><option>All Status</option><option>Operational</option><option>Not Operational</option></select></div>
          <div><label class="block text-xs font-semibold text-gray-500 mb-1.5">From Date</label><input type="date" value="2025-01-01"></div>
          <div><label class="block text-xs font-semibold text-gray-500 mb-1.5">To Date</label><input type="date" value="2025-05-10"></div>
          <div class="lg:col-span-2"><label class="block text-xs font-semibold text-gray-500 mb-1.5">Search Problem Description</label>
            <input type="text" placeholder="Search in issues, root cause, actions taken…"></div>
        </div>
        <div class="flex justify-between items-center mt-5 pt-4 border-t border-gray-100">
          <span class="text-xs text-gray-400">Showing 1–10 of 148 results</span>
          <div class="flex gap-2">
            <button class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs gap-1.5 font-medium transition-colors">
              <i class="fas fa-rotate-left"></i> Reset
            </button>
            <button class="inline-flex items-center px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs gap-1.5 font-medium transition-colors">
              <i class="fas fa-filter"></i> Apply Filters
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-sm font-semibold text-gray-900">Service Records</h3>
        <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">10 of 148</span>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
              <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
              <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Machine</th>
              <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Service Type</th>
              <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Engineer</th>
              <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody id="tbl" class="divide-y divide-gray-50"></tbody>
        </table>
      </div>
      <div class="px-6 py-3 border-t border-gray-100 flex items-center justify-between">
        <span class="text-xs text-gray-400">Showing 1–10 of 148 results</span>
        <div class="flex gap-1">
          <button class="pag-btn">&laquo;</button>
          <button class="pag-btn active">1</button>
          <button class="pag-btn">2</button>
          <button class="pag-btn">3</button>
          <span class="pag-btn" style="border:none;background:transparent;color:#9CA3AF;">…</span>
          <button class="pag-btn">15</button>
          <button class="pag-btn">&raquo;</button>
        </div>
      </div>
    </div>
  </main>
</div>

<!-- MODAL -->
<div id="modal" class="hidden fixed inset-0 bg-black/50 z-50 overflow-y-auto">
  <div class="relative mx-auto my-8 w-11/12 max-w-3xl bg-white rounded-2xl shadow-2xl overflow-hidden">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
          <i id="m-icon" class="fas fa-tools text-white text-sm"></i>
        </div>
        <div>
          <p class="text-white font-bold text-sm" id="m-machine">—</p>
          <p class="text-blue-200 text-xs mono" id="m-serial">—</p>
        </div>
      </div>
      <div class="flex items-center gap-2">
        <button onclick="printSingle()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 hover:bg-white/30 text-white rounded-lg text-xs font-medium transition-colors">
          <i class="fas fa-print"></i> Print
        </button>
        <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-xl bg-white/20 hover:bg-white/30 text-white">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>

    <div class="p-6 max-h-[80vh] overflow-y-auto space-y-5">
      <!-- Summary grid -->
      <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
        <div class="bg-gray-50 rounded-xl p-3 border border-gray-100">
          <p class="text-xs text-gray-400 font-medium mb-0.5">Service Date</p>
          <p class="text-sm font-semibold text-gray-800" id="m-date">—</p>
        </div>
        <div class="bg-gray-50 rounded-xl p-3 border border-gray-100">
          <p class="text-xs text-gray-400 font-medium mb-0.5">Service Type</p>
          <p class="text-sm font-semibold text-gray-800" id="m-type">—</p>
        </div>
        <div class="bg-gray-50 rounded-xl p-3 border border-gray-100">
          <p class="text-xs text-gray-400 font-medium mb-0.5">Engineer</p>
          <p class="text-sm font-semibold text-gray-800" id="m-engineer">—</p>
        </div>
        <div class="bg-gray-50 rounded-xl p-3 border border-gray-100">
          <p class="text-xs text-gray-400 font-medium mb-0.5">Model</p>
          <p class="text-sm font-semibold text-gray-800 mono" id="m-model">—</p>
        </div>
        <div class="bg-gray-50 rounded-xl p-3 border border-gray-100 col-span-2">
          <p class="text-xs text-gray-400 font-medium mb-1">Equipment Status</p>
          <span id="m-status" class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold"></span>
        </div>
      </div>

      <!-- ID Verification -->
      <div class="bg-gray-50 border border-gray-100 rounded-xl p-4">
        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Identification / Verification</p>
        <p class="text-sm text-gray-700 leading-relaxed" id="m-idver">—</p>
      </div>

      <!-- Details -->
      <div class="space-y-3">
        <div class="border border-orange-100 bg-orange-50/40 rounded-xl p-4">
          <p class="text-xs font-bold text-orange-600 uppercase tracking-wide mb-2"><i class="fas fa-triangle-exclamation mr-1"></i>Problem / Issue Reported</p>
          <p class="text-sm text-gray-700 leading-relaxed" id="m-problem">—</p>
        </div>
        <div class="border border-red-100 bg-red-50/40 rounded-xl p-4">
          <p class="text-xs font-bold text-red-600 uppercase tracking-wide mb-2"><i class="fas fa-magnifying-glass mr-1"></i>Root Cause / Findings</p>
          <p class="text-sm text-gray-700 leading-relaxed" id="m-root">—</p>
        </div>
        <div class="border border-green-100 bg-green-50/40 rounded-xl p-4">
          <p class="text-xs font-bold text-green-700 uppercase tracking-wide mb-2"><i class="fas fa-check-circle mr-1"></i>Actions Taken</p>
          <p class="text-sm text-gray-700 leading-relaxed" id="m-actions">—</p>
        </div>
        <div class="border border-blue-100 bg-blue-50/40 rounded-xl p-4">
          <p class="text-xs font-bold text-blue-700 uppercase tracking-wide mb-2"><i class="fas fa-lightbulb mr-1"></i>Recommendations</p>
          <p class="text-sm text-gray-700 leading-relaxed" id="m-reco">—</p>
        </div>
      </div>

      <!-- Parts Replaced -->
      <div id="parts-block">
        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2"><i class="fas fa-gears mr-1"></i>Parts Replaced</p>
        <div class="rounded-xl border border-gray-200 overflow-hidden">
          <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
              <tr>
                <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 uppercase w-16">Qty</th>
                <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 uppercase">Part / Item</th>
                <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-500 uppercase">SI/DR No.</th>
              </tr>
            </thead>
            <tbody id="parts-rows" class="divide-y divide-gray-100"></tbody>
          </table>
        </div>
      </div>

      <!-- Before Images -->
      <div id="before-block">
        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2"><i class="fas fa-camera mr-1"></i>Before Service Images</p>
        <div id="before-imgs" class="flex flex-wrap gap-2"></div>
      </div>

      <!-- After Images -->
      <div id="after-block">
        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2"><i class="fas fa-camera-rotate mr-1"></i>After Service Images</p>
        <div id="after-imgs" class="flex flex-wrap gap-2"></div>
      </div>
    </div>

    <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-2">
      <button onclick="printSingle()" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
        <i class="fas fa-print"></i> Print Report
      </button>
      <button onclick="closeModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">
        <i class="fas fa-times"></i> Close
      </button>
    </div>
  </div>
</div>

<!-- Lightbox -->
<div id="lightbox" class="hidden fixed inset-0 bg-black/85 z-[60] flex items-center justify-center" onclick="closeLB()">
  <button class="absolute top-5 right-5 text-white text-xl w-10 h-10 rounded-xl bg-white/20 hover:bg-white/30 flex items-center justify-center" onclick="closeLB()"><i class="fas fa-times"></i></button>
  <img id="lb-img" src="" alt="" class="max-w-[90vw] max-h-[90vh] object-contain rounded-xl shadow-2xl">
</div>

<script>
let currentId = null;

function render() {
  document.getElementById('tbl').innerHTML = RECORDS.map(r => {
    const mc = mColor(r.machine);
    const tc = typeBadge(r.type);
    const sc = r.status === 'Operational' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    const si = r.status === 'Operational' ? 'fa-circle-check' : 'fa-circle-xmark';
    return `<tr onclick="openModal(${r.id})">
      <td class="px-5 py-3.5 whitespace-nowrap">
        <div class="text-sm font-semibold text-gray-900">${r.date}</div>
        <div class="text-xs text-gray-400">${r.time}</div>
      </td>
      <td class="px-5 py-3.5">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl border flex items-center justify-center text-sm flex-shrink-0 ${mc}"><i class="fas ${mIcon(r.machine)}"></i></div>
          <div>
            <div class="text-sm font-semibold text-gray-900">${r.machine}</div>
            <div class="text-xs text-gray-400 mono">SN: ${r.serial}</div>
          </div>
        </div>
      </td>
      <td class="px-5 py-3.5">
        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold ${tc}"><i class="fas ${typeIcon(r.type)} text-[9px]"></i>${r.type}</span>
        ${r.before > 0 || r.after > 0 ? `<div class="mt-1"><span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-xs bg-gray-100 text-gray-600"><i class="fas fa-camera text-[9px]"></i>${r.before + r.after}</span></div>` : ''}
      </td>
      <td class="px-5 py-3.5 text-sm text-gray-800">${r.engineer}</td>
      <td class="px-5 py-3.5"><span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold ${sc}"><i class="fas ${si} text-[9px]"></i>${r.status}</span></td>
      <td class="px-5 py-3.5" onclick="event.stopPropagation()">
        <div class="flex gap-1.5">
          <button onclick="openModal(${r.id})" class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition-colors" title="View"><i class="fas fa-eye text-sm"></i></button>
          <button onclick="printOne(${r.id})" class="w-8 h-8 rounded-lg bg-green-50 hover:bg-green-100 text-green-600 flex items-center justify-center transition-colors" title="Print"><i class="fas fa-print text-sm"></i></button>
        </div>
      </td>
    </tr>`;
  }).join('');
}

function openModal(id) {
  const r = RECORDS.find(x => x.id === id);
  if (!r) return;
  currentId = id;

  document.getElementById('m-machine').textContent = r.machine;
  document.getElementById('m-serial').textContent = r.serial;
  document.getElementById('m-date').textContent = r.date + ' — ' + r.time;
  document.getElementById('m-type').textContent = r.type;
  document.getElementById('m-model').textContent = r.model;
  document.getElementById('m-engineer').textContent = r.engineer;
  document.getElementById('m-idver').textContent = r.id_verification;
  document.getElementById('m-problem').textContent = r.problem;
  document.getElementById('m-root').textContent = r.root;
  document.getElementById('m-actions').textContent = r.actions;
  document.getElementById('m-reco').textContent = r.recommendations;
  document.getElementById('m-icon').className = `fas ${typeIcon(r.type)} text-white text-sm`;

  const sb = document.getElementById('m-status');
  const op = r.status === 'Operational';
  sb.className = `inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold ${op ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
  sb.innerHTML = `<i class="fas ${op ? 'fa-circle-check' : 'fa-circle-xmark'} text-[9px]"></i>${r.status}`;

  // Parts
  const pb = document.getElementById('parts-block');
  if (r.parts.length) {
    pb.classList.remove('hidden');
    document.getElementById('parts-rows').innerHTML = r.parts.map(p =>
      `<tr><td class="px-4 py-2.5 font-bold text-gray-900">${p.qty}</td><td class="px-4 py-2.5 text-gray-800">${p.item}</td><td class="px-4 py-2.5 mono text-gray-600 text-xs">${p.si}</td></tr>`
    ).join('');
  } else { pb.classList.add('hidden'); }

  // Before images
  const bb = document.getElementById('before-block');
  const bi = document.getElementById('before-imgs');
  if (r.before > 0) {
    bb.classList.remove('hidden');
    bi.innerHTML = Array.from({length: r.before}, (_, i) => {
      const src = svgDataUrl('Before ' + (i+1), 68, 68, COLORS[i % COLORS.length]);
      const lsrc = svgDataUrl('Before Image ' + (i+1), 800, 600, COLORS[i % COLORS.length]);
      return `<img src="${src}" class="img-thumb" onclick="openLB('${lsrc}')" alt="Before ${i+1}">`;
    }).join('');
  } else { bb.classList.add('hidden'); }

  // After images
  const ab = document.getElementById('after-block');
  const ai = document.getElementById('after-imgs');
  ab.classList.remove('hidden');
  if (r.after > 0) {
    ai.innerHTML = Array.from({length: r.after}, (_, i) => {
      const src = svgDataUrl('After ' + (i+1), 68, 68, COLORS[(i+3) % COLORS.length]);
      const lsrc = svgDataUrl('After Image ' + (i+1), 800, 600, COLORS[(i+3) % COLORS.length]);
      return `<img src="${src}" class="img-thumb" onclick="openLB('${lsrc}')" alt="After ${i+1}">`;
    }).join('');
  } else {
    ai.innerHTML = `<div class="img-placeholder"><i class="fas fa-image text-gray-300 text-xl"></i><span>No after images</span></div>`;
  }

  document.getElementById('modal').classList.remove('hidden');
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  document.getElementById('modal').classList.add('hidden');
  document.body.style.overflow = '';
}

function openLB(src) { document.getElementById('lb-img').src = src; document.getElementById('lightbox').classList.remove('hidden'); }
function closeLB() { document.getElementById('lightbox').classList.add('hidden'); }

function printOne(id) { window.open(`print.html?id=${id}`, '_blank', 'width=1100,height=800,scrollbars=yes'); }
function printSingle() { if (currentId) printOne(currentId); }
function batchPrint() { window.open('batch.html', '_blank', 'width=1200,height=900,scrollbars=yes'); }

document.getElementById('modal').addEventListener('click', e => { if (e.target === document.getElementById('modal')) closeModal(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeModal(); closeLB(); } });

render();
</script>
@endsection 