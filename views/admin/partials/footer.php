</div><!-- /.srt-content -->
</main><!-- /.srt-main -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ── Auto-dismiss alerts ───────────────────────────────────
document.querySelectorAll('.srt-alert').forEach(el => {
    el.style.transition = 'opacity .4s';
    setTimeout(() => {
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 400);
    }, 4000);
});

// ── Sidebar overlay close on mobile ──────────────────────
document.addEventListener('click', e => {
    const sidebar = document.getElementById('srtSidebar');
    const toggle  = document.querySelector('.srt-sidebar-toggle');
    if (window.innerWidth <= 768 && sidebar.classList.contains('open')) {
        if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    }
});

// ── Topbar breadcrumb: auto-populate from page h4 ────────
(function() {
    const h4 = document.querySelector('.srt-page-header h4');
    const bc = document.querySelector('.srt-topbar .breadcrumb');
    if (h4 && bc) {
        const li = document.createElement('li');
        li.className = 'breadcrumb-item active';
        // Strip HTML tags from h4 for plain text
        li.textContent = h4.innerText.replace(/^\s+/, '');
        bc.appendChild(li);
    }
})();
</script>
</body>
</html>
