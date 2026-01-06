<?= view('frontend/layouts/header') ?>

<style>
.container {
    max-width: 1000px;
    margin: 30px auto;
    padding: 20px;
}

.page-title {
    font-size: 26px;
    margin-bottom: 20px;
}

.enroll-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 20px;
    margin-bottom: 22px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}

.enroll-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.enroll-header h3 {
    margin: 0;
    font-size: 22px;
    color: #1e3a8a;
}

.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: bold;
}

.badge.open { background: #dcfce7; color: #166534; }
.badge.full { background: #fee2e2; color: #991b1b; }
.badge.running { background: #e0f2fe; color: #075985; }

.enroll-details {
    margin-top: 15px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #e5e7eb;
}

.detail-row:last-child {
    border-bottom: none;
}

.label {
    color: #475569;
    font-weight: 600;
}

.value {
    font-weight: bold;
    color: #020617;
}

.total-box {
    margin-top: 15px;
    background: #f0f9ff;
    padding: 12px 16px;
    border-left: 5px solid #2563eb;
    border-radius: 8px;
    font-size: 15px;
}

.actions {
    margin-top: 18px;
    display: flex;
    gap: 12px;
}

.actions a {
    text-decoration: none;
}

.btn {
    padding: 10px 16px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-size: 14px;
}

.btn-primary {
    background: #2563eb;
    color: #fff;
}

.btn-secondary {
    background: #475569;
    color: #fff;
}

.empty {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    font-size: 16px;
}
</style>

<div class="container">

    <h2 class="page-title">My Enrollments</h2>

    <?php if (!empty($enrollments)): ?>

        <?php foreach ($enrollments as $planId => $plan): ?>

            <div class="enroll-card">

                <!-- HEADER -->
                <div class="enroll-header">
                    <h3><?= esc($plan['plan_name']) ?></h3>

                    <?php if ($plan['status'] == 1): ?>
                        <span class="badge open">Open</span>
                    <?php elseif ($plan['status'] == 2): ?>
                        <span class="badge full">Slots Full</span>
                    <?php else: ?>
                        <span class="badge running">Running</span>
                    <?php endif; ?>
                </div>

                <!-- DETAILS -->
                <div class="enroll-details">

                    <div class="detail-row">
                        <span class="label">Chit Amount</span>
                        <span class="value">₹<?= number_format($plan['chit_amount']) ?></span>
                    </div>

                    <div class="detail-row">
                        <span class="label">Monthly Contribution (Per Slot)</span>
                        <span class="value">₹<?= number_format($plan['base_price']) ?></span>
                    </div>

                    <div class="detail-row">
                        <span class="label">Tenure</span>
                        <span class="value"><?= esc($plan['duration']) ?> Months</span>
                    </div>

                    <div class="detail-row">
                        <span class="label">Slots Taken</span>
                        <span class="value"><?= esc($plan['total_slots']) ?></span>
                    </div>

                </div>

                <!-- TOTAL AMOUNT -->
                <div class="total-box">
                    💰 <strong>Total Contribution:</strong>
                    ₹<?= number_format($plan['total_amount']) ?>
                </div>

                <!-- ACTIONS -->
                <div class="actions">
                    <a href="<?= base_url('plan/' . $planId) ?>">
                        <button class="btn btn-primary">View Plan</button>
                    </a>

                    <a href="<?= base_url('/') ?>">
                        <button class="btn btn-secondary">Explore Plans</button>
                    </a>
                </div>

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <div class="empty">
            You have not enrolled in any plans yet.<br><br>
            <a href="<?= base_url('/') ?>">
                <button class="btn btn-primary">Explore Plans</button>
            </a>
        </div>

    <?php endif; ?>

</div>
