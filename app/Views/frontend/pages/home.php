<?= view('frontend/layouts/header') ?>

<!-- =========================
     HERO SECTION
========================= -->
<section class="hero">

    <!-- ✅ REQUIRED OVERLAY (FIXES PAGE BLOCK ISSUE) -->
    <div class="hero-overlay"></div>

    <div class="hero-content">

        <h1><?= esc($settings['hero_title'] ?? 'Trusted Chits') ?></h1>

        <h2><?= esc($settings['hero_subtitle'] ?? 'Proven by Time') ?></h2>

        <p class="hero-tagline">
            <?= esc($settings['hero_tagline'] ?? 'Serving families with transparent savings since 1970') ?>
        </p>

        <!-- CTA BUTTONS -->
        <div class="hero-buttons">

            <!-- Join Chit -->
            <a href="#plans" class="btn-primary">
                <?= esc($settings['cta_button'] ?? 'Join a Chit') ?>
            </a>

            <!-- My Enrollments -->
            <?php if (session()->get('user_logged_in')): ?>
                <a href="<?= base_url('my-enrollments') ?>" class="btn-secondary">
                    My Enrollments
                </a>
            <?php endif; ?>

        </div>
    </div>
</section>

<!-- =========================
     PLANS SECTION
========================= -->
<section class="products" id="plans">
    <h2>Available Chit Plans</h2>

    <?php if (!empty($products)) : ?>
        <div class="product-list">

            <?php foreach ($products as $product) : ?>

                <?php
                    // ✅ SAFE SLOT CALCULATION
                    $filledSlots    = (int) ($product['filled_slots'] ?? 0);
                    $totalMembers   = (int) $product['total_members'];
                    $remainingSlots = max(0, $totalMembers - $filledSlots);
                ?>

                <div class="product-card">

                    <h3><?= esc($product['plan_name']) ?> Chit</h3>

                    <p class="amount">
                        Chit Amount:
                        <strong>₹<?= number_format($product['chit_amount']) ?></strong>
                    </p>

                    <p class="duration">
                        Tenure: <?= esc($product['duration_months']) ?> months
                    </p>

                    <p class="slots">
                        Slots:
                        <?= $filledSlots ?> /
                        <?= $totalMembers ?>
                    </p>

                    <?php if ($remainingSlots > 0): ?>
                        <p class="slot-status open">
                            <?= $remainingSlots ?> slots available
                        </p>
                    <?php else: ?>
                        <p class="slot-status full">
                            Slots Full
                        </p>
                    <?php endif; ?>

                    <a href="<?= base_url('plan/' . $product['id']) ?>" class="btn">
                        View Plan
                    </a>

                </div>

            <?php endforeach; ?>

        </div>
    <?php else : ?>
        <p style="text-align:center;">No plans available right now.</p>
    <?php endif; ?>
</section>
