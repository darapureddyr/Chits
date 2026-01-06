<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }
        .login-box {
            width: 320px;
            margin: 120px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 6px;
        }
        .login-box h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 12px;
            box-sizing: border-box;
        }
        input {
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background: #2563eb;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background: #1e40af;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h3>Admin Login</h3>

    <form method="post" action="<?= base_url('admin/login-post') ?>">
    <input type="text" name="mobile" placeholder="Mobile Number" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>


    <?php if (session()->getFlashdata('error')): ?>
        <div class="error">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
