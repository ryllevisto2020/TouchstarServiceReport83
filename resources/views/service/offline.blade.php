<div id="conn-toast" style="
  position: fixed; bottom: 1.5rem; left: 50%; transform: translateX(-50%) translateY(20px);
  display: flex; align-items: center; gap: 10px;
  padding: 10px 16px; border-radius: 12px;
  background: white; border: 1px solid #e5e7eb;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  font-size: 13px; font-weight: 500;
  opacity: 0; pointer-events: none;
  transition: opacity 0.25s ease, transform 0.25s ease;
  z-index: 9999;">
  <span id="conn-dot" style="width:8px;height:8px;border-radius:50%;flex-shrink:0;"></span>
  <div>
    <div id="conn-title" style="color:#111;"></div>
    <div id="conn-sub" style="font-size:11px;color:#6b7280;margin-top:1px;"></div>
  </div>
</div>

<script>
(function(){
  let timer = null;
  function showConn(type) {
    const t = document.getElementById('conn-toast');
    const dot = document.getElementById('conn-dot');
    document.getElementById('conn-title').textContent = type === 'offline' ? 'You are offline' : 'Back online';
    document.getElementById('conn-sub').textContent   = type === 'offline' ? 'Changes will be saved as drafts' : 'Submit your Service Report in Drafts';
    dot.style.background  = type === 'offline' ? '#ef4444' : '#22c55e';
    t.style.borderColor   = type === 'offline' ? '#fca5a5' : '#86efac';
    t.style.opacity = '1'; t.style.transform = 'translateX(-50%) translateY(0)';
    clearTimeout(timer);
    timer = setTimeout(() => {
      t.style.opacity = '0'; t.style.transform = 'translateX(-50%) translateY(20px)';
    }, type === 'offline' ? 5000 : 3000);
  }
  window.addEventListener('offline', () => showConn('offline'));
  window.addEventListener('online',  () => showConn('online'));
})();
</script>