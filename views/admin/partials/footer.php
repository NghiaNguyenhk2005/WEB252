</div><!-- /.srt-content -->
</main><!-- /.srt-main -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Auto-dismiss alerts after 4s
document.querySelectorAll('.srt-alert').forEach(el => {
    setTimeout(() => { el.style.opacity = '0'; setTimeout(() => el.remove(), 300); }, 4000);
    el.style.transition = 'opacity .3s';
});
</script>
</body>
</html>
