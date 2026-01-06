/* =========================
   BASE URL (CI SAFE)
========================= */
const baseUrl = document.querySelector('base')?.href || '/';

document.addEventListener('DOMContentLoaded', function () {

    /* =========================
       SIDE PANEL (ADD PLAN)
    ========================= */
    const openBtn  = document.getElementById('openAddPlan');
    const closeBtn = document.getElementById('closePanel');
    const panel    = document.getElementById('addPlanPanel');
    const overlay  = document.getElementById('panelOverlay');

    if (openBtn) {
        openBtn.addEventListener('click', () => {
            panel.classList.add('open');
            overlay.classList.add('show');
        });
    }

    if (closeBtn) closeBtn.addEventListener('click', closePanel);
    if (overlay) overlay.addEventListener('click', closePanel);

    function closePanel() {
        panel.classList.remove('open');
        overlay.classList.remove('show');
    }

    /* =========================
       ADD PLAN (AJAX)
    ========================= */
    const addForm  = document.getElementById('addPlanForm');
    const errorBox = document.getElementById('formError');

    if (addForm) {
        addForm.addEventListener('submit', function (e) {
            e.preventDefault();

            errorBox.innerHTML = '';

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status !== 'success') {
                    errorBox.innerHTML = data.msg || 'Failed to add plan';
                    return;
                }

                // Reset form
                this.reset();

                // Close panel
                closePanel();

                // Reload plans table
                reloadPlansTable();
            })
            .catch(() => {
                errorBox.innerHTML = 'Network error. Please try again.';
            });
        });
    }

});

/* =========================
   RELOAD PLANS TABLE
========================= */
function reloadPlansTable() {
    fetch(baseUrl + 'admin/plans')
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTable = doc.getElementById('plansTable');
            document.getElementById('plansTable').innerHTML = newTable.innerHTML;
        });
}

/* =========================
   DELETE PLAN
========================= */
function deletePlan(planId) {
    if (!confirm('Delete this plan permanently?')) return;

    fetch(baseUrl + 'admin/plans/delete/' + planId)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                reloadPlansTable();
            } else {
                alert(data.msg || 'Delete failed');
            }
        })
        .catch(() => alert('Network error'));
}
