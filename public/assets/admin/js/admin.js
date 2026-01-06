document.addEventListener('DOMContentLoaded', function () {

    const toggleBtn = document.getElementById('menuToggle');
    const body = document.body;

    if (!toggleBtn) return;

    toggleBtn.addEventListener('click', function () {
        body.classList.toggle('sidebar-collapsed');

        toggleBtn.textContent = body.classList.contains('sidebar-collapsed')
            ? '✕'
            : '☰';
    });

});
