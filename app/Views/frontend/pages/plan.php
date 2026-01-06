<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($plan['plan_name']) ?> | Chit Plan</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            margin: 0;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
        }

        .plan-card {
            background: #2563eb;
            color: #fff;
            padding: 22px;
            border-radius: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .plan-card h1 {
            margin: 0;
            font-size: 28px;
        }

        .plan-card .amount {
            font-size: 22px;
            margin-top: 6px;
        }

        .plan-details {
            background: #fff;
            margin-top: 20px;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
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
            font-weight: 700;
            color: #1e3a8a;
        }

        .slot-status {
            margin-top: 16px;
            font-weight: bold;
        }

        .slot-status.open { color: #16a34a; }
        .slot-status.full { color: #dc2626; }

        .bidding-info {
            margin-top: 20px;
            background: #f0f9ff;
            border-left: 5px solid #2563eb;
            padding: 14px 16px;
            border-radius: 8px;
            font-size: 14px;
        }

        .cta {
            margin-top: 25px;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
        }

        select {
            padding: 8px;
            width: 100%;
            margin-top: 8px;
        }

        button {
            margin-top: 16px;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 6px;
            background: #2563eb;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        button.secondary {
            background: #475569;
        }

        button[disabled] {
            background: #cbd5e1;
            cursor: not-allowed;
        }

        .alert {
            margin-bottom: 12px;
            padding: 10px;
            border-radius: 6px;
            font-size: 14px;
        }

        .alert.error { background: #fee2e2; color: #991b1b; }
        .alert.warning { background: #fef3c7; color: #92400e; }

        .terms-box {
            margin-top: 14px;
            font-size: 14px;
        }
    </style>

    <script>
        function toggleAddButton() {
            document.getElementById('addBtn').disabled =
                !document.getElementById('agreeTerms').checked;
        }
    </script>
</head>
<body>

<?= view('frontend/layouts/header') ?>

<div class="container">

    <!-- TOP CARD -->
    <div class="plan-card">
        <div>
            <h1><?= esc($plan['plan_name']) ?> Chit</h1>
            <div class="amount">₹<?= number_format($plan['chit_amount']) ?></div>
        </div>
        <div>LOGO</div>
    </div>

    <!-- DETAILS -->
    <div class="plan-details">
        <div class="detail-row"><span class="label">Tenure</span><span class="value"><?= $plan['duration_months'] ?> Months</span></div>
        <div class="detail-row"><span class="label">Total Members</span><span class="value"><?= $plan['total_members'] ?></span></div>
        <div class="detail-row"><span class="label">Monthly Contribution</span><span class="value">₹<?= number_format($plan['base_price_per_month']) ?></span></div>
        <div class="detail-row"><span class="label">Organizer Commission</span><span class="value">₹<?= number_format($plan['commission_per_month']) ?></span></div>
        <div class="detail-row"><span class="label">Joined Slots</span><span class="value"><?= $filledSlots ?></span></div>
        <div class="detail-row"><span class="label">Slots Available</span><span class="value"><?= $slotsAvailable ?></span></div>
    </div>

    <div class="slot-status <?= $slotsAvailable > 0 ? 'open' : 'full' ?>">
        Slots: <?= $filledSlots ?> / <?= $plan['total_members'] ?>
    </div>

    <div class="bidding-info">
        📢 <strong>Bidding Info:</strong><br>
        Bidding will start once all slots are filled. You will be notified.
    </div>

    <!-- CTA -->
    <div class="cta">

        <?php if ($slotsAvailable <= 0): ?>

            <div class="alert error">All slots are filled.</div>
            <a href="<?= base_url('/') ?>"><button class="secondary">See Other Plans</button></a>

        <?php elseif ($userSlots >= 2): ?>

            <div class="alert.warning">You already enrolled 2 slots.</div>
            <a href="<?= base_url('my-enrollments') ?>"><button class="secondary">My Enrollments</button></a>

        <?php else: ?>

            <form method="post" action="<?= base_url('cart/add') ?>">
                <input type="hidden" name="product_id" value="<?= $plan['id'] ?>">
                <input type="hidden" name="redirect_url" value="<?= current_url() ?>">

                <label>Select Slots</label>
                <select name="slots" required>
                    <?php for ($i = 1; $i <= $maxSelectableSlots; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?> Slot<?= $i > 1 ? 's' : '' ?></option>
                    <?php endfor; ?>
                </select>

                <div class="terms-box">
                    <label>
                        <input type="checkbox" id="agreeTerms" onchange="toggleAddButton()">
                        I agree to Terms & Conditions
                    </label>
                </div>

                <button id="addBtn" disabled>ADD TO SAVINGS BAG</button>
            </form>

        <?php endif; ?>

    </div>

</div>
</body>
</html>
