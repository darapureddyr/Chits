<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<!-- =========================
     PAGE HEADER
========================= -->
<div class="products-header">
    <h2>Edit Plan</h2>

    <a href="<?= base_url('admin/plans') ?>" class="btn btn-secondary">
        ← Back to Plans
    </a>
</div>

<!-- =========================
     EDIT PLAN FORM
========================= -->
<form
    method="post"
    action="<?= base_url('admin/plans/update/' . (int)$plan['id']) ?>"
    autocomplete="off"
>

    <?= csrf_field() ?>

    <!-- =========================
         PLAN NAME
    ========================= -->
    <label>Plan Name</label>
    <input
        type="text"
        name="plan_name"
        value="<?= esc($plan['plan_name']) ?>"
        required
        minlength="3"
    >

    <!-- =========================
         PLAN CODE (READ ONLY)
    ========================= -->
    <label>Plan Code</label>
    <input
        type="text"
        value="<?= esc($plan['plan_code']) ?>"
        readonly
        style="background:#f3f4f6"
    >

    <!-- =========================
         CHIT AMOUNT
    ========================= -->
    <label>Chit Amount</label>
    <input
        type="number"
        name="chit_amount"
        min="1"
        step="1"
        value="<?= (int)$plan['chit_amount'] ?>"
        required
    >

    <!-- =========================
         TOTAL SLOTS
    ========================= -->
    <label>Total Slots</label>
    <input
        type="number"
        name="total_slots"
        id="total_slots"
        min="1"
        step="1"
        value="<?= (int)$plan['total_slots'] ?>"
        required
    >

    <!-- =========================
         COMMISSION PER CUSTOMER
    ========================= -->
    <label>Commission Per Customer (Monthly)</label>
    <input
        type="number"
        name="commission_amount"
        id="commission_amount"
        min="0"
        step="1"
        value="<?= (int)$plan['commission_amount'] ?>"
        required
    >

    <!-- =========================
         TOTAL COMMISSION (READ ONLY)
    ========================= -->
    <label>Total Admin Commission (Per Month)</label>
    <input
        type="number"
        id="total_commission_per_month"
        value="<?= (int)$plan['total_commission_per_month'] ?>"
        readonly
        style="background:#f3f4f6"
    >

    <!-- =========================
         MAX SLOTS PER USER
    ========================= -->
    <label>Max Slots Per User</label>
    <input
        type="number"
        name="max_slots_per_user"
        min="1"
        step="1"
        value="<?= (int)$plan['max_slots_per_user'] ?>"
        required
    >

    <!-- =========================
         DESCRIPTION
    ========================= -->
    <label>Description</label>
    <textarea
        name="description"
        rows="3"
    ><?= esc($plan['description']) ?></textarea>

    <!-- =========================
         PLAN STATUS
    ========================= -->
    <label>Status</label>
    <select name="status" required>
        <option value="1" <?= $plan['status'] == 1 ? 'selected' : '' ?>>
            Open
        </option>
        <option value="4" <?= $plan['status'] == 4 ? 'selected' : '' ?>>
            Closed
        </option>
    </select>

    <!-- =========================
         ACTION BUTTONS
    ========================= -->
    <div style="margin-top:20px;">
        <button type="submit" class="btn btn-primary">
            Update Plan
        </button>

        <a href="<?= base_url('admin/plans') ?>" class="btn btn-secondary">
            Cancel
        </a>
    </div>

</form>

<!-- =========================
     AUTO CALCULATE TOTAL COMMISSION (UI ONLY)
========================= -->
<script>
function updateTotalCommission() {
    const commission = Number(document.getElementById('commission_amount').value || 0);
    const slots = Number(document.getElementById('total_slots').value || 0);
    document.getElementById('total_commission_per_month').value = commission * slots;
}

document.getElementById('commission_amount').addEventListener('input', updateTotalCommission);
document.getElementById('total_slots').addEventListener('input', updateTotalCommission);
</script>

<?= $this->endSection() ?>
