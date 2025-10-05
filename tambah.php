<?php
require 'koneksi.php';

$error = '';
if ($_POST) {
    $no_urut = trim($_POST['no_urut']);
    $ip_local = trim($_POST['ip_local']);
    $ip_publik = trim($_POST['ip_publik']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $penanggung_jawab = trim($_POST['penanggung_jawab']);
    $nomor_wa = trim($_POST['nomor_wa']);
    $service = trim($_POST['service']);
    $open_port = trim($_POST['open_port']);
    $path = trim($_POST['path']);

    if (empty($no_urut) || empty($ip_local) || empty($username)) {
        $error = "Kolom No, IP Local, dan Username wajib diisi!";
    } else {
        $stmt = $conn->prepare("INSERT INTO untitled_spreadsheet___sheet1 (no_urut, ip_local, ip_publik, username, password, penanggung_jawab, nomor_wa, service, open_port, path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $no_urut, $ip_local, $ip_publik, $username, $password, $penanggung_jawab, $nomor_wa, $service, $open_port, $path);

        if ($stmt->execute()) {
            header("Location: index.php?pesan=ditambah");
            exit;
        } else {
            $error = "Gagal menyimpan data!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>➕ Tambah Server</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
    :root{
        --bg: linear-gradient(180deg,#f8fafc,#eef2fb);
        --card: #ffffff;
        --text: #0f172a;
        --muted: #475569;
        --accent: #0f766e;
        --border: #e6eef3;
        --size: 16px;
        --radius: 10px;
    }
    *{box-sizing:border-box}
    body{
        font-family: 'Inter', system-ui, sans-serif;
        margin:0; background:var(--bg); color:var(--text); font-size:var(--size);
        line-height:1.6;
    }
    .container{max-width:800px;margin:20px auto;padding:0 20px}
    .card{
        background:var(--card);
        border:1px solid var(--border);
        border-radius:var(--radius);
        padding:24px;
        margin-bottom:20px;
        box-shadow:0 6px 18px rgba(15,23,42,0.06);
    }
    h1{
        font-size:24px;
        margin:0 0 20px 0;
        color:var(--accent);
        display:flex;
        align-items:center;
        gap:10px;
    }
    .back-link{
        display:inline-block;
        color:#0f766e;
        text-decoration:none;
        margin-bottom:20px;
        font-weight:600;
    }
    .form-group{
        margin-bottom:16px;
    }
    label{
        display:block;
        margin-bottom:6px;
        font-weight:600;
        color:var(--muted);
    }
    input, textarea{
        width:100%;
        padding:10px;
        border:1px solid var(--border);
        border-radius:8px;
        font-family:inherit;
        font-size:15px;
    }
    textarea{
        min-height:80px;
        resize:vertical;
    }
    .btn{
        background:var(--accent);
        color:white;
        border:none;
        padding:12px 24px;
        border-radius:8px;
        font-weight:700;
        cursor:pointer;
        font-size:16px;
        display:inline-flex;
        align-items:center;
        gap:8px;
    }
    .btn:hover{
        opacity:0.9;
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
    <div class="container">
        <a href="index.php" class="back-link">⬅ Kembali ke Daftar Server</a>

        <div class="card">
            <h1>➕ Tambah Server Baru</h1>

            <?php if (!empty($error)): ?>
                <div class="alert"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>No. Urut:</label>
                    <input type="text" name="no_urut" required>
                </div>

                <div class="form-group">
                    <label>IP Local:</label>
                    <input type="text" name="ip_local" required>
                </div>

                <div class="form-group">
                    <label>IP Publik:</label>
                    <input type="text" name="ip_publik">
                </div>

                <div class="form-group">
                    <label>Username:</label>
                    <input type="text" name="username" required>
                </div>

                <div class="form-group">
                    <label>Password:</label>
                    <input type="text" name="password" required>
                </div>

                <div class="form-group">
                    <label>Penanggung Jawab:</label>
                    <input type="text" name="penanggung_jawab" required>
                </div>

                <div class="form-group">
                    <label>Nomor WhatsApp:</label>
                    <input type="text" name="nomor_wa" required>
                </div>

                <div class="form-group">
                    <label>Service:</label>
                    <textarea name="service" placeholder="Contoh: Apache, MySQL, PHP, Node.js"></textarea>
                </div>

                <div class="form-group">
                    <label>Open Port:</label>
                    <textarea name="open_port" placeholder="Contoh: 22, 80, 443, 3306"></textarea>
                </div>

                <div class="form-group">
                    <label>Path:</label>
                    <textarea name="path" placeholder="Contoh: /var/www/html/project"></textarea>
                </div>

                <button type="submit" class="btn">💾 Simpan Server</button>
            </form>
        </div>
    </div>
</body>
</html>