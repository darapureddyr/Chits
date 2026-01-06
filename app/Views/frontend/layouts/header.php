<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Chits') ?></title>

    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">

    <!-- ✅ COMMON HEADER -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/header.css') ?>">

    <!-- ✅ HOME PAGE STYLES -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/home.css') ?>">
</head>


<body>

<header class="top-header">
     <a href="<?= base_url('/') ?>" class="home-link" title="Home">
        <svg xmlns="http://www.w3.org/2000/svg"
             width="22" height="22"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round">
            <path d="M3 9.5L12 3l9 6.5"></path>
            <path d="M9 22V12h6v10"></path>
        </svg>
    </a>

    <div class="right">
        <?php if (session()->get('user_logged_in')): ?>
            <span class="username">Hi, <?= esc(session()->get('user_name')) ?></span>
            <a href="<?= base_url('auth/logout') ?>" class="logout">Logout</a>
        <?php else: ?>
            <a href="<?= base_url('auth') ?>" class="logout">Login</a>
        <?php endif; ?>
    </div>
</header>

