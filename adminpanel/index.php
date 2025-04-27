<?php
require_once 'auth.php';
if (is_logged_in()) {
    header('Location: dashboard.php');
    exit();
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    if (login($user, $pass)) {
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .login-box { max-width: 320px; margin: 80px auto; background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px #bbb; }
        h2 { text-align: center; color: #29b6f6; }
        input[type=text], input[type=password] { width: 100%; padding: 0.5rem; margin: 0.5rem 0 1rem 0; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 0.5rem; background: #29b6f6; color: #fff; border: none; border-radius: 4px; font-size: 1rem; }
        .error { color: #c00; text-align: center; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html> 