<?php
session_start();

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_POST) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // GANTI DENGAN USERNAME & PASSWORD YANG KAMU INGINKAN
    if ($username === 'admin' && $password === 's0t0kudus') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>🔒 Login - Rekap Server</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
    :root{
        --bg: linear-gradient(135deg, #0f766e, #06b6d4);
        --card: #ffffff;
        --text: #0f172a;
        --muted: #475569;
        --border: #e6eef3;
        --size: 16px;
        --radius: 12px;
    }
    *{box-sizing:border-box}
    body{
        font-family: 'Inter', system-ui, sans-serif;
        margin:0; 
        background:var(--bg); 
        color:var(--text); 
        font-size:var(--size);
        min-height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:20px;
    }
    .login-card{
        background:var(--card);
        border-radius:var(--radius);
        padding:32px;
        width:100%;
        max-width:420px;
        box-shadow:0 10px 25px rgba(0,0,0,0.15);
        text-align:center;
    }
    .logo{
        font-size:28px;
        margin-bottom:8px;
        color:#0f766e;
    }
    h1{
        font-size:24px;
        margin:0 0 24px 0;
        color:var(--text);
    }
    .form-group{
        margin-bottom:16px;
        text-align:left;
    }
    label{
        display:block;
        margin-bottom:6px;
        font-weight:600;
        color:var(--muted);
    }
    input{
        width:100%;
        padding:12px;
        border:1px solid var(--border);
        border-radius:8px;
        font-family:inherit;
        font-size:16px;
    }
    .btn{
        background:#0f766e;
        color:white;
        border:none;
        padding:12px;
        border-radius:8px;
        font-weight:700;
        font-size:16px;
        width:100%;
        cursor:pointer;
        margin-top:8px;
    }
    .btn:hover{
        background:#0d6a61;
    }
    .alert{
        padding:12px;
        background:#fee2e2;
        color:#b91c1c;
        border-radius:8px;
        margin-bottom:20px;
        border-left:4px solid #ef4444;
    }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">🔐</div>
        <h1>Login ke Dashboard Server</h1>

        <?php if (!empty($error)): ?>
            <div class="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required autofocus>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn">Masuk</button>
        </form>
    </div>
</body>
</html>