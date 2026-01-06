<form
    id="addPlanForm"
    method="post"
    action="<?= base_url('admin/plans/store') ?>"
    autocomplete="off"
>

    <?= csrf_field() ?>

    <!-- =========================
         ERROR MESSAGE
    ========================= -->
    <div id="formError" class="form-error" style="color:#dc2626; margin-bottom:10px;"></div>

    <!-- =========================
         PLAN NAME
    ========================= -->
    <label>Plan Name</label>
    <input
        type="text"
        name="plan_name"
        placeholder="Ex: Gold Chit"
        required
        minlength="3"
    >

    <!-- =========================
         PLAN CODE (UNIQUE)
    ========================= -->
    <label>Plan Code</label>
    <input
        type="text"
        name="plan_code"
        placeholder="Ex: GOLD001"
        required
        pattern="[A-Za-z0-9_-]+"
        title="Only letters, numbers, - and _ allowed"
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
        placeholder="Ex: 100000"
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
        placeholder="Ex: 20"
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
        placeholder="Ex: 150"
        required
    >

    <!-- =========================
         TOTAL COMMISSION (AUTO)
    ========================= -->
    <label>Total Admin Commission (Per Month)</label>
    <input
        type="number"
        name="total_commission_per_month"
        id="total_commission_per_month"
        readonly
        style="background:#f3f4f6"
        placeholder="Auto calculated"
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
        placeholder="Ex: 2"
        required
    >

    <!-- =========================
         DESCRIPTION (OPTIONAL)
    ========================= -->
    <label>Description</label>
    <textarea
        name="description"
        placeholder="Optional plan description"
        rows="3"
    ></textarea>

    <!-- =========================
         PLAN STATUS
    ========================= -->
    <label>Status</label>
    <select name="status" required>
        <option value="1">Open (Users can enroll)</option>
        <option value="4">Closed (Hidden from users)</option>
    </select>

    <!-- =========================
         SUBMIT
    ========================= -->
    <button type="submit" class="btn btn-primary">
        Save Plan
    </button>

</form>

<!-- =========================
     AUTO CALC SCRIPT
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
