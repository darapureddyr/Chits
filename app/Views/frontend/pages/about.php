<?= view('frontend/layouts/header', ['title' => 'About Us']) ?>
<?= view('frontend/layouts/navbar') ?>

<section class="container" style="max-width: 900px; margin: 40px auto;">

    <h1 style="font-size: 32px; margin-bottom: 10px;">
        About Our Chit Fund
    </h1>

    <p style="font-size: 16px; color: #475569; line-height: 1.7;">
        We are a trusted chit fund organization committed to helping families
        and individuals save money in a disciplined and transparent way.
        Our system is built on trust, accountability, and long-term relationships.
    </p>

    <hr style="margin: 30px 0;">

    <h2 style="font-size: 24px;">Why Choose Us?</h2>

    <ul style="margin-top: 15px; line-height: 1.8; color: #334155;">
        <li>✔ Transparent monthly bidding process</li>
        <li>✔ Fixed commission declared upfront</li>
        <li>✔ Secure slot allocation system</li>
        <li>✔ Admin-controlled bidding dates</li>
        <li>✔ Trusted by members for years</li>
    </ul>

    <hr style="margin: 30px 0;">

    <h2 style="font-size: 24px;">How It Works</h2>

    <ol style="margin-top: 15px; line-height: 1.8; color: #334155;">
        <li>Admin releases a chit plan</li>
        <li>Members join by booking slots</li>
        <li>Once all slots are filled, bidding starts</li>
        <li>Monthly auction happens transparently</li>
        <li>Members receive funds as per bidding results</li>
    </ol>

    <div style="margin-top: 40px; text-align: center;">
        <a href="<?= base_url('/') ?>" class="btn-primary">
            View Available Chits
        </a>
    </div>

</section>

<?= view('frontend/layouts/footer') ?>
