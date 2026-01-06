<?= view('frontend/layouts/header') ?>

<div class="container">

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (!empty($cartItems)): ?>

        <table class="cart-table">
            <thead>
                <tr>
                    <th>Plan</th>
                    <th>Chit Amount</th>
                    <th>Slots</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($cartItems as $item): ?>
                <?php
                    $maxReached = ($item['slots'] + $item['enrolled_slots']) >= 2;
                ?>
                <tr>
                    <td><?= esc($item['plan_name']) ?></td>
                    <td>₹<?= number_format($item['chit_amount']) ?></td>

                    <td>
                        <form method="post" action="<?= base_url('cart/update-slots') ?>" style="display:inline;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="action" value="decrease">
                            <button <?= $item['slots'] <= 1 ? 'disabled' : '' ?>>−</button>
                        </form>

                        <strong style="margin:0 10px;"><?= $item['slots'] ?></strong>

                        <form method="post" action="<?= base_url('cart/update-slots') ?>" style="display:inline;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="action" value="increase">
                            <button <?= $maxReached ? 'disabled' : '' ?>>+</button>
                        </form>
                    </td>

                    <td>
                        <a href="<?= base_url('cart/remove/' . $item['id']) ?>"
                           onclick="return confirm('Remove this plan?')"
                           style="color:red;">
                            Remove
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-footer">
            <p><strong>Total Slots:</strong> <?= $totalSlots ?></p>

            <form method="post" action="<?= base_url('join/confirm') ?>">
                <?= csrf_field() ?>
                <button type="submit" class="btn-confirm">
                    Confirm Enrollment
                </button>
            </form>
        </div>

    <?php else: ?>
        <p class="empty-cart">Your cart is empty.</p>
    <?php endif; ?>

</div>
