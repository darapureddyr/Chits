<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Admin Panel') ?></title>

    <!-- ✅ ADMIN CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/admin.css') ?>">

    <!-- ✅ ADMIN JS -->
    <script src="<?= base_url('assets/admin/js/admin.js') ?>" defer></script>
    <script src="<?= base_url('assets/admin/js/plan.js') ?>" defer></script>
</head>

<body class="admin-body">

    <!-- HEADER -->
    <?= view('admin/layout/header') ?>

    <!-- SIDEBAR -->
    <?= view('admin/layout/sidebar', ['activePage' => $activePage ?? '']) ?>

    <!-- MAIN CONTENT -->
    <div class="page-wrapper">
        <div class="content">
            <?= $this->renderSection('content') ?>
        </div>

        <?= view('admin/layout/footer') ?>
    </div>

</body>
</html>
