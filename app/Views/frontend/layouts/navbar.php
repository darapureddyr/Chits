<nav class="navbar">
    <a href="<?= base_url('/') ?>" class="logo">Chits</a>

    <div class="nav-links">
        <a href="<?= base_url('/') ?>">Home</a>
        <a href="<?= base_url('/about') ?>">About</a>

        <?php if (session()->get('user_logged_in')): ?>
            <span class="user">Hello, <?= esc(session()->get('user_name')) ?></span>
            <a href="<?= base_url('logout') ?>">Logout</a>
        <?php else: ?>
            <a href="<?= base_url('auth') ?>">Login</a>
        <?php endif; ?>
    </div>
</nav>
