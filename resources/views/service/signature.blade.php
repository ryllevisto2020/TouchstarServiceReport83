<div id="bulk-sig-modal" class="fixed inset-0 z-[60] hidden">
    <div id="bulk-sig-backdrop"
         class="absolute inset-0 bg-gray-900/60"
         style="backdrop-filter:blur(4px);"></div>

    <div class="absolute inset-0 overflow-y-auto flex items-end sm:items-center justify-center sm:p-4">
        <div class="relative w-full bg-white shadow-2xl"
             style="border-radius:1rem 1rem 0 0;max-height:92dvh;overflow-y:auto;
                    display:flex;flex-direction:column;max-width:600px;">

            <div class="flex items-center justify-between px-5 py-4 flex-shrink-0"
                 style="background:linear-gradient(to right,#f59e0b,#ea580c);">
                <h3 class="text-white font-semibold text-base flex items-center gap-2">
                    <i class="fas fa-signature"></i> Apply Signature to Drafts
                </h3>
                <button onclick="closeBulkSigModal()"
                        class="text-white/80 hover:text-white transition-colors text-lg leading-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-5 pt-5 pb-2 space-y-5">

                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                        Select drafts to apply signature
                    </p>

                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <!-- Check-all row -->
                        <label class="flex items-center gap-3 px-4 py-2.5 bg-gray-50 border-b border-gray-200 cursor-pointer select-none">
                            <input type="checkbox" id="bulk-check-all"
                                   onchange="bulkToggleAll(this.checked)"
                                   class="w-4 h-4 rounded accent-amber-500">
                            <span class="text-xs text-gray-500 font-medium">Select all</span>
                            <span id="bulk-selected-label"
                                  class="ml-auto text-xs font-semibold text-amber-600"></span>
                        </label>

                        <div id="bulk-draft-list" class="divide-y divide-gray-100"></div>
                    </div>
                </div>

                <!-- Signature pad -->
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                        Draw your signature <span class="text-red-500">*</span>
                    </p>
                    <div class="border border-gray-300 rounded-xl p-3 bg-white">
                        <div class="border border-gray-300 rounded-lg bg-white overflow-hidden mb-3">
                            <canvas id="bulk-sig-canvas"
                                    class="touch-none bg-white block w-full"
                                    style="height:130px;"></canvas>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" onclick="bulkClearSig()"
                                    class="flex-1 py-2 px-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-eraser mr-1.5"></i>Clear
                            </button>
                            <button type="button" onclick="bulkUndoSig()"
                                    class="flex-1 py-2 px-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-undo mr-1.5"></i>Undo
                            </button>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-2">
                        MedTech approver name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="bulk-approved-by"
                           placeholder="Enter approver name…"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400">
                </div>
            </div>

            <div class="flex-shrink-0 px-5 py-3 bg-gray-50 border-t border-gray-200
                        flex items-center justify-between gap-3">
                <p class="text-xs text-gray-400">
                    <i class="fas fa-info-circle mr-1"></i>
                    Will overwrite existing signatures on selected drafts.
                </p>
                <div class="flex gap-2">
                    <button onclick="closeBulkSigModal()"
                            class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg
                                   hover:bg-gray-100 transition-colors">
                        Cancel
                    </button>
                    <button onclick="applyBulkSignature()"
                            class="px-4 py-2 text-sm font-semibold text-white rounded-lg
                                   hover:opacity-90 transition-opacity flex items-center gap-1.5"
                            style="background:linear-gradient(to right,#f59e0b,#ea580c);">
                        <i class="fas fa-check-circle"></i>
                        Apply to selected
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
(function () {
    'use strict';

    let _bulkSigPad   = null;   
    let _bulkDrafts   = [];     
    let _bulkChecked  = new Set();

    window.openBulkSigModal = function () {
        _loadBulkDrafts();
        document.getElementById('bulk-sig-modal').classList.remove('hidden');

        /* Init SignaturePad once canvas is visible */
        requestAnimationFrame(() => {
            const canvas = document.getElementById('bulk-sig-canvas');
            if (!canvas) return;

            /* Resize canvas to match CSS size */
            const rect = canvas.getBoundingClientRect();
            canvas.width  = rect.width  * (window.devicePixelRatio || 1);
            canvas.height = rect.height * (window.devicePixelRatio || 1);
            canvas.getContext('2d').scale(
                window.devicePixelRatio || 1,
                window.devicePixelRatio || 1
            );

            if (window.SignaturePad) {
                _bulkSigPad = new SignaturePad(canvas, { penColor: '#1e3a8a' });
            }
        });
    };

    window.closeBulkSigModal = function () {
        document.getElementById('bulk-sig-modal').classList.add('hidden');
        if (_bulkSigPad) _bulkSigPad.clear();
        document.getElementById('bulk-approved-by').value = '';
    };

    /* ── Load drafts from localStorage ────────────────────────────────────── */
    function _loadBulkDrafts() {
        _bulkDrafts  = [];
        _bulkChecked = new Set();

        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            if (!key) continue;

            /* Accept both storage formats used in the codebase */
            const isOldFormat = key === 'serviceDraft';
            const isNewFormat = key.startsWith('serviceDraft_');
            if (!isOldFormat && !isNewFormat) continue;

            try {
                if (isOldFormat) {
                    /* Old format: one key holds a JSON array */
                    const arr = JSON.parse(localStorage.getItem(key));
                    if (!Array.isArray(arr)) continue;
                    arr.forEach((draft, idx) => {
                        const virtualKey = `serviceDraft__old_${idx}`;
                        _bulkDrafts.push({ key, virtualKey, draft, arrayIndex: idx });
                        _bulkChecked.add(virtualKey);
                    });
                } else {
                    /* New format: one key per draft */
                    const draft = JSON.parse(localStorage.getItem(key));
                    _bulkDrafts.push({ key, virtualKey: key, draft, arrayIndex: null });
                    _bulkChecked.add(key);
                }
            } catch (e) {
                console.error('bulk-sig: parse error', key, e);
            }
        }

        _renderDraftList();
        _updateCheckAllState();
    }

    /* ── Render checklist ──────────────────────────────────────────────────── */
    function _renderDraftList() {
        let machines = {{Js::from($machines)}};
        const list = document.getElementById('bulk-draft-list');
        if (!list) return;

        if (!_bulkDrafts.length) {
            list.innerHTML = `
                <div class="px-4 py-6 text-center text-sm text-gray-400">
                    <i class="fas fa-inbox text-2xl block mb-2"></i>No drafts found
                </div>`;
            return;
        }

        list.innerHTML = _bulkDrafts.map(({ virtualKey, draft }) => {
            const location = machines.find(x => x.id == draft.machine_id)?.client_location;
            const hasSig    = !!(draft.medtech_signature || draft.medtech_signature?.length);
            const checked   = _bulkChecked.has(virtualKey);
            const machineName = _getMachineName(draft);
            //const location    = draft.location || draft.client_name || 'N/A';
            const types       = Array.isArray(draft.service_type)
                                    ? draft.service_type.slice(0, 2).join(', ')
                                    : (draft.service_type || '');
            const date        = draft.service_date || draft.created_at
                                    ? new Date(draft.service_date || draft.created_at)
                                            .toLocaleDateString('en-PH', { month:'short', day:'numeric' })
                                    : '';

            const badgeClass = hasSig
                ? 'bg-green-100 text-green-700'
                : 'bg-amber-100 text-amber-700';
            const badgeText  = hasSig ? 'Has signature' : 'No signature';

            return `
            <label class="flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-amber-50
                          transition-colors select-none" data-vkey="${_esc(virtualKey)}">
                <input type="checkbox"
                       class="bulk-draft-cb w-4 h-4 rounded accent-amber-500 flex-shrink-0"
                       value="${_esc(virtualKey)}"
                       ${checked ? 'checked' : ''}
                       onchange="bulkToggleOne('${_esc(virtualKey)}', this.checked)">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">${_esc(machineName)}</p>
                    <p class="text-xs text-gray-400 truncate mt-0.5">
                        ${_esc(location)}
                        ${types  ? `· ${_esc(types)}`  : ''}
                        ${date   ? `· ${_esc(date)}`   : ''}
                    </p>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full font-medium flex-shrink-0 ${badgeClass}">
                    ${badgeText}
                </span>
            </label>`;
        }).join('');

        _updateSelectedLabel();
    }

    function _getMachineName(draft) {
        // /* Try machine_name first, then fall back to a machines lookup if available */
        // if (draft.machine_name && draft.machine_name !== 'Unknown Machine') {
        //     return draft.machine_name;
        // }
        // /* If the page exposes $machines via a global (set in renderPendingTable), use it */
        // try {
        //     const machines = window.__pageMachines || [];
        //     const found = machines.find(m => String(m.id) === String(draft.machine_id));
        //     if (found) return found.name;
        // } catch (_) {}
        // return draft.machine_name || 'Unknown Machine';
        let machines = {{Js::from($machines)}};
        return machines.find(x=>x.id == draft.machine_id)?.name;
    }

    /* ── Check-all / toggle ────────────────────────────────────────────────── */
    window.bulkToggleAll = function (checked) {
        _bulkChecked.clear();
        if (checked) _bulkDrafts.forEach(d => _bulkChecked.add(d.virtualKey));
        document.querySelectorAll('.bulk-draft-cb').forEach(cb => cb.checked = checked);
        _updateSelectedLabel();
    };

    window.bulkToggleOne = function (vkey, checked) {
        if (checked) _bulkChecked.add(vkey);
        else         _bulkChecked.delete(vkey);
        _updateCheckAllState();
        _updateSelectedLabel();
    };

    function _updateCheckAllState() {
        const ca = document.getElementById('bulk-check-all');
        if (!ca) return;
        ca.indeterminate = _bulkChecked.size > 0 && _bulkChecked.size < _bulkDrafts.length;
        ca.checked       = _bulkChecked.size === _bulkDrafts.length && _bulkDrafts.length > 0;
    }

    function _updateSelectedLabel() {
        const el = document.getElementById('bulk-selected-label');
        if (el) el.textContent = `${_bulkChecked.size} selected`;
    }

    /* ── Signature pad helpers ─────────────────────────────────────────────── */
    window.bulkClearSig = function () { _bulkSigPad?.clear(); };
    window.bulkUndoSig  = function () {
        if (!_bulkSigPad) return;
        const data = _bulkSigPad.toData();
        if (data.length) { data.pop(); _bulkSigPad.fromData(data); }
    };

    /* ── Apply ─────────────────────────────────────────────────────────────── */
    window.applyBulkSignature = function () {
        if (!_bulkChecked.size) {
            Swal.fire({ icon:'warning', title:'No drafts selected', text:'Please select at least one draft.', timer:2000, showConfirmButton:false });
            return;
        }

        const approvedBy = (document.getElementById('bulk-approved-by')?.value || '').trim();
        const sigData    = (_bulkSigPad && !_bulkSigPad.isEmpty())
                               ? _bulkSigPad.toDataURL()
                               : '';

        if (!sigData) {
            Swal.fire({ icon:'warning', title:'Signature required', text:'Please draw your signature first.', timer:2000, showConfirmButton:false });
            return;
        }
        if (!approvedBy) {
            Swal.fire({ icon:'warning', title:'Name required', text:'Please enter the approver name.', timer:2000, showConfirmButton:false });
            return;
        }

        let patchCount = 0;

        /* ── Patch new-format keys (one draft per key) ─── */
        _bulkDrafts
            .filter(d => d.arrayIndex === null && _bulkChecked.has(d.virtualKey))
            .forEach(({ key, draft }) => {
                draft.medtech_signature = sigData;
                draft.approved_by       = approvedBy;
                draft.last_updated      = new Date().toISOString();
                try {
                    localStorage.setItem(key, JSON.stringify(draft));
                    patchCount++;
                } catch (e) {
                    console.error('bulk-sig: save failed', key, e);
                }
            });

        /* ── Patch old-format key (array in one key) ─────── */
        const oldKey = 'serviceDraft';
        const oldRaw = localStorage.getItem(oldKey);
        if (oldRaw) {
            try {
                const arr = JSON.parse(oldRaw);
                let changed = false;
                arr.forEach((draft, idx) => {
                    const vk = `serviceDraft__old_${idx}`;
                    if (_bulkChecked.has(vk)) {
                        draft.medtech_signature = sigData;
                        draft.approved_by       = approvedBy;
                        draft.last_updated      = new Date().toISOString();
                        patchCount++;
                        changed = true;
                    }
                });
                if (changed) localStorage.setItem(oldKey, JSON.stringify(arr));
            } catch (e) {
                console.error('bulk-sig: old-format patch failed', e);
            }
        }

        /* ── Feedback + refresh ─── */
        closeBulkSigModal();

        Swal.fire({
            icon: 'success',
            title: 'Signature applied!',
            html: `<p>Updated <strong>${patchCount}</strong> draft${patchCount !== 1 ? 's' : ''} with your signature and approver name.</p>`,
            timer: 2200,
            showConfirmButton: false
        });

        /* Refresh the pending table if available */
        if (typeof window.loadPendingServices === 'function') window.loadPendingServices();
    };

    /* ── Close on backdrop click ───────────────────────────────────────────── */
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('bulk-sig-backdrop')
            ?.addEventListener('click', closeBulkSigModal);
    });

    /* ── Tiny HTML-escape helper ───────────────────────────────────────────── */
    function _esc(str) {
        if (!str) return '';
        return String(str).replace(/[&<>"']/g, m => ({
            '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'
        }[m]));
    }

    window.closeBulkSigModal = closeBulkSigModal;
    window.openBulkSigModal  = openBulkSigModal;
})();
</script>