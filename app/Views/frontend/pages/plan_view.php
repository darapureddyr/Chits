<!DOCTYPE html>
<html>
<head>
    <title><?= esc($plan['plan_name']) ?></title>
</head>
<body>

<h2><?= esc($plan['plan_name']) ?></h2>

<p><strong>Chit Amount:</strong> ₹<?= esc($plan['chit_amount']) ?></p>

<p>
    <strong>Slots Remaining:</strong>
    <?= $slotsRemaining ?>
</p>

<hr>

<?php if (!session()->get('user_logged_in')): ?>

    <!-- USER NOT LOGGED IN -->
    <p>Please login to enroll in this plan.</p>
    <a href="<?= base_url('/login') ?>">Login</a>

<?php else: ?>

    <?php if ($slotsRemaining <= 0): ?>

        <!-- PLAN FULL -->
        <p style="color:red;">
            ❌ All slots are filled for this plan.
        </p>

        <a href="<?= base_url('/') ?>">🏠 Home</a>

    <?php elseif ($userSlotsUsed >= $plan['max_slots_per_user']): ?>

        <!-- USER MAX LIMIT REACHED -->
        <p style="color:red;">
            ❌ You have reached the maximum slots allowed for this plan.
        </p>

        <a href="<?= base_url('/') ?>">🏠 View Other Plans</a>

    <?php else: ?>

        <!-- USER CAN ENROLL -->
        <p>
            Slots used by you:
            <?= $userSlotsUsed ?> /
            <?= $plan['max_slots_per_user'] ?>
        </p>

        <a href="<?= base_url('enroll/'.$plan['id']) ?>">
            <button>✅ Enroll Slot</button>
        </a>

    <?php endif; ?>

<?php endif; ?>

<hr>

<!-- ALWAYS VISIBLE -->
<a href="<?= base_url('/') ?>">🏠 Home</a> |
<a href="<?= base_url('/plans') ?>">📋 Other Plans</a>

</body>
</html>
