<div id="clientModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50 hidden transition-all">
    <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
            <h3 id="modalTitle" class="text-xl font-bold text-gray-800"><i class="fas fa-hospital mr-2 text-blue-500"></i>Add New Client</h3>
            <button id="closeClientModal" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <form id="clientForm" class="p-6 space-y-6">
            <input type="hidden" id="clientId" value="">
            
            <!-- Image Upload Section -->
            <div class="border-b pb-4">
                <label class="text-sm font-semibold text-gray-700 block mb-3"><i class="fas fa-image mr-1 text-blue-500"></i> Client Logo / Hospital Image</label>
                <div class="flex items-center gap-6 flex-wrap">
                    <div id="imagePreview" class="relative">
                        <div id="clientImagePrev" class="w-28 h-28 bg-gray-100 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center text-gray-400 overflow-hidden">
                            <i class="fas fa-building text-4xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <input type="file" id="clientImage" accept="image/*" class="text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        <p class="text-xs text-gray-400 mt-2">Recommended: JPG, PNG (Max 2MB). Square image works best.</p>
                    </div>
                </div>
            </div>

            <!-- 2 columns layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="col-span-1 md:col-span-2">
                    <label class="text-sm font-semibold text-gray-700"><i class="fas fa-building mr-1"></i> Hospital / Client Name *</label>
                    <input type="text" id="clientName" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 mt-1 focus:ring-2 focus:ring-blue-200">
                </div>
                <div class="md:col-span-2">
                    <label class="text-sm font-semibold text-gray-700"><i class="fas fa-map-marker-alt mr-1"></i> Complete Address</label>
                    <input type="text" id="address" placeholder="Street, City, Province, Zip" class="w-full border rounded-lg px-4 py-2.5">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700"><i class="fas fa-user-md"></i> Pathologist</label>
                    <input type="text" id="pathologist" placeholder="Dr. Full Name" class="w-full border rounded-lg px-4 py-2.5">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700"><i class="fas fa-microscope"></i> Head MedTech</label>
                    <input type="text" id="headMedtech" placeholder="MedTech Supervisor" class="w-full border rounded-lg px-4 py-2.5">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700"><i class="fas fa-user-tie"></i> Contact Person Name *</label>
                    <input type="text" id="contactPersonName" required placeholder="Full name of primary contact" class="w-full border rounded-lg px-4 py-2.5">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700"><i class="fas fa-phone-alt"></i> Contact Phone</label>
                    <input type="text" id="contactPhone" placeholder="+63 / landline" class="w-full border rounded-lg px-4 py-2.5">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700"><i class="fas fa-envelope"></i> Contact Email</label>
                    <input type="email" id="contactEmail" placeholder="hospital@example.com" class="w-full border rounded-lg px-4 py-2.5">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700"><i class="fas fa-tag"></i> Status</label>
                    <select id="clientStatus" class="w-full border rounded-lg px-4 py-2.5 bg-white">
                        <option value="ACTIVE">Active Partner</option>
                        <option value="INACTIVE">Inactive</option>
                        <option value="PENDING">Pending Contract</option>
                    </select>
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" id="cancelModalBtn" class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium shadow-sm">Save Client</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: View Client Details (Profile with Image) -->
<div id="viewClientModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[85vh] overflow-y-auto shadow-xl">
        <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800"><i class="fas fa-notes-medical text-green-600"></i> Client Profile</h3>
            <button onclick="closeViewClientModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <div id="viewClientContent" class="p-6 space-y-4"></div>
    </div>
</div>

{{-- Client Account Modal --}}
<div id="clientAccountModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-700 to-indigo-700 px-6 py-5 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                <i class="fas fa-user-plus text-white text-lg"></i>
            </div>
            <div class="flex-1">
                <p class="text-white font-semibold text-base">Create Client Account</p>
                <p class="text-blue-100 text-xs mt-0.5" id="accClientNameDisplay">—</p>
            </div>
            <button onclick="closeClientAccountModal()"
                class="w-7 h-7 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        {{-- Body --}}
        <form id="clientAccountForm" class="px-6 py-5 space-y-4">
            <input type="hidden" id="accClientId">

            {{-- Info banner --}}
            <div class="flex items-start gap-3 bg-blue-50 border-l-4 border-blue-400 rounded-lg px-4 py-3">
                <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                <p class="text-xs text-gray-600">This creates a system login for the client portal. Share credentials securely after creation.</p>
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                    <i class="fas fa-envelope mr-1"></i> Email Address
                </label>
                <input type="email" id="accClientEmail" required
                    placeholder="client@hospital.ph"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-400 outline-none transition">
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                    <i class="fas fa-lock mr-1"></i> Password
                </label>
                <div class="relative">
                    <input type="password" id="accClientPassword" required
                        placeholder="••••••••"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-400 outline-none transition pr-10">
                    <button type="button" onclick="togglePassword('accClientPassword', this)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                    <i class="fas fa-lock mr-1"></i> Confirm Password
                </label>
                <div class="relative">
                    <input type="password" id="accClientConfirm" required
                        placeholder="••••••••"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-400 outline-none transition pr-10">
                    <button type="button" onclick="togglePassword('accClientConfirm', this)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3 pt-1">
                <button type="button" onclick="closeClientAccountModal()"
                    class="flex-1 border border-gray-300 text-gray-600 rounded-lg py-2 text-sm hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-[2] bg-blue-600 hover:bg-blue-700 text-white rounded-lg py-2 text-sm font-semibold flex items-center justify-center gap-2 transition">
                    <i class="fas fa-user-check"></i> Create Account
                </button>
            </div>
        </form>
    </div>
</div>