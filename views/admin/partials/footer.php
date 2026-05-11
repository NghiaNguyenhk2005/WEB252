    </div><!-- /.srt-content -->
</main><!-- /.srt-main -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle
    const sidebar = document.getElementById('srtSidebar');
    const topbar = document.getElementById('srtTopbar');
    const main = document.getElementById('srtMain');
    const toggleBtn = document.getElementById('sidebarToggleBtn');
    
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // For desktop
            if (window.innerWidth > 768) {
                sidebar.classList.toggle('closed');
                if (topbar) topbar.classList.toggle('expanded');
                if (main) main.classList.toggle('expanded');
                
                // Save state
                localStorage.setItem('sidebarClosed', sidebar.classList.contains('closed'));
            } 
            // For mobile
            else {
                sidebar.classList.toggle('open');
            }
        });
    }
    
    // Load saved state (desktop only)
    if (window.innerWidth > 768) {
        const isClosed = localStorage.getItem('sidebarClosed') === 'true';
        if (isClosed && sidebar) {
            sidebar.classList.add('closed');
            if (topbar) topbar.classList.add('expanded');
            if (main) main.classList.add('expanded');
        }
    }
    
    // Close mobile sidebar when clicking outside
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768 && sidebar && sidebar.classList.contains('open')) {
            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            if (sidebar) sidebar.classList.remove('open');
        }
    });
    
    // ── Auto-dismiss alerts (DISABLED - manual dismiss only) ──
    // Alerts now stay until manually closed with the X button
    // document.querySelectorAll('.srt-alert').forEach(el => {
    //     el.style.transition = 'opacity .4s';
    //     setTimeout(() => {
    //         el.style.opacity = '0';
    //         setTimeout(() => el.remove(), 400);
    //     }, 4000);
    // });
    
    // Add breadcrumb from page title
    const pageTitle = document.querySelector('.srt-page-header h4');
    const breadcrumb = document.querySelector('.srt-topbar .breadcrumb');
    if (pageTitle && breadcrumb && breadcrumb.children.length === 1) {
        const li = document.createElement('li');
        li.className = 'breadcrumb-item active';
        li.textContent = pageTitle.innerText.trim();
        breadcrumb.appendChild(li);
    }
});
</script>
</body>
</html>