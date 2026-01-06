<!DOCTYPE html>
<html>
<head>
    <title>Login / Register</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .auth-box {
            width: 420px;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 12px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #c7d2fe;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        .toggle {
            text-align: center;
            margin-top: 10px;
        }

        .toggle a {
            color: #2563eb;
            cursor: pointer;
            font-weight: bold;
        }

        .hidden {
            display: none;
        }

        .msg {
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 6px;
            font-size: 14px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }
    </style>
</head>

<body>

<div class="auth-box">

    <!-- FLASH MESSAGES -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="msg error">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="msg success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- ================= LOGIN FORM ================= -->
    <div id="loginBox">
        <h2>Login</h2>

        <form method="post" action="<?= base_url('auth/login') ?>">
            <div class="form-group">
                <input
                    type="text"
                    name="user_code"
                    placeholder="Account Number"
                    required
                >
            </div>

            <div class="form-group">
                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                >
            </div>

            <button type="submit">Login</button>
        </form>

        <div class="toggle">
            New user? <a onclick="showRegister()">Register</a>
        </div>
    </div>

    <!-- ================= REGISTER FORM ================= -->
    <div id="registerBox" class="hidden">
        <h2>Register</h2>

        <form method="post" action="<?= base_url('auth/register') ?>">
            <div class="form-group">
                <input
                    type="text"
                    name="first_name"
                    placeholder="First Name"
                    required
                >
            </div>

            <div class="form-group">
                <input
                    type="text"
                    name="last_name"
                    placeholder="Last Name"
                    required
                >
            </div>

            <div class="form-group">
                <input
                    type="text"
                    name="mobile"
                    placeholder="Mobile Number"
                    required
                >
            </div>

            <div class="form-group">
                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                >
            </div>

            <button type="submit">Register</button>
        </form>

        <div class="toggle">
            Already have an account? <a onclick="showLogin()">Login</a>
        </div>
    </div>

</div>

<script>
    // Remove page reload history
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    function showRegister() {
        document.getElementById('loginBox').classList.add('hidden');
        document.getElementById('registerBox').classList.remove('hidden');
    }

    function showLogin() {
        document.getElementById('registerBox').classList.add('hidden');
        document.getElementById('loginBox').classList.remove('hidden');
    }

    // ✅ AUTO SWITCH TO LOGIN AFTER REGISTER
    <?php if (session()->getFlashdata('show_login')): ?>
        showLogin();
    <?php endif; ?>
</script>

</body>
</html>
