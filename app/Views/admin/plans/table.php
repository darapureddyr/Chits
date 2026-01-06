<table class="plans-table">
    <thead>
        <tr>
            <th>Plan Name</th>
            <th>Chit Amount</th>
            <th>Total Slots</th>
            <th>Commission / Customer</th>
            <th>Total Commission / Month</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($plans)): ?>
            <?php foreach ($plans as $plan): ?>
                <tr>
                    <td><?= esc($plan['plan_name']) ?></td>
                    <td>₹<?= number_format($plan['chit_amount']) ?></td>
                    <td><?= (int)$plan['total_slots'] ?></td>
                    <td>₹<?= number_format($plan['commission_amount']) ?></td>
                    <td>₹<?= number_format($plan['total_commission_per_month']) ?></td>
                    <td>
                        <?php if ($plan['status'] == 1): ?>
                            <span class="badge open">Open</span>
                        <?php else: ?>
                            <span class="badge draft">Closed</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('admin/plans/edit/'.$plan['id']) ?>" class="btn btn-edit">
                            Edit
                        </a>
                        <a href="<?= base_url('admin/plans/delete/'.$plan['id']) ?>"
                           class="btn btn-delete"
                           onclick="return confirm('Delete this plan?')">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align:center;">No plans found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
