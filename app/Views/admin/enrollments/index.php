<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<!-- =========================
     PAGE HEADER
========================= -->
<div class="products-header">
    <div>
        <h2>Enrollments – <?= esc($plan['plan_name']) ?></h2>
        <p style="color:#6b7280; margin-top:4px;">
            Commission:
            <strong>₹<?= number_format($plan['commission_amount'], 2) ?></strong>
            / month
        </p>
    </div>

    <a href="<?= base_url('admin/plans') ?>" class="btn btn-secondary">
        ← Back to Plans
    </a>
</div>

<!-- =========================
     PLAN SUMMARY
========================= -->
<div style="margin-bottom:20px; font-size:14px;">
    <strong>Total Slots:</strong> <?= (int)$plan['total_slots'] ?> |
    <strong>Filled Slots:</strong> <?= (int)$totalFilled ?>
</div>

<!-- =========================
     ENROLLMENTS TABLE
========================= -->
<div class="table-responsive">
    <table class="plans-table">
        <thead>
            <tr>
                <th>#</th>
                <th>User UID</th>
                <th>User Name</th>
                <th>Mobile</th>
                <th>Slots Taken</th>
                <th>First Enrolled At</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($enrollments)): ?>
                <?php foreach ($enrollments as $index => $row): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>

                        <td><?= esc($row['uid']) ?></td>

                        <td><?= esc($row['name']) ?></td>

                        <td><?= esc($row['mobile']) ?></td>

                        <td>
                            <strong><?= (int)$row['slots_used'] ?></strong>
                        </td>

                        <td>
                            <?= date('d M Y, h:i A', strtotime($row['enrolled_at'])) ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;">
                        No enrollments yet
                    </td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</div>

<!-- =========================
     BIDDING ACTION (CONDITIONAL)
========================= -->
<?php if ((int)$totalFilled === (int)$plan['total_slots']): ?>
    <div style="margin-top:25px; padding:15px; background:#f8fafc; border-radius:8px;">
        <strong>All slots are filled.</strong>

        <div style="margin-top:10px;">
            <a
                href="<?= base_url('admin/plans/set-bidding/' . $plan['id']) ?>"
                class="btn btn-primary"
            >
                Set Bidding Date
            </a>
        </div>
    </div>
<?php else: ?>
    <div style="margin-top:25px; color:#9ca3af;">
        Bidding can be set only after all slots are filled.
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
