<?php
require 'koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'] ?? 0;
if (!$id) {
    die("ID server tidak ditemukan!");
}

// Ambil data lama
$stmt = $conn->prepare("SELECT * FROM untitled_spreadsheet___sheet1 WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$server = $result->fetch_assoc();

if (!$server) {
    die("Data server tidak ditemukan!");
}

// Proses form saat disubmit
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

    // Validasi minimal
    if (empty($no_urut) || empty($ip_local) || empty($username)) {
        $error = "Kolom No, IP Local, dan Username wajib diisi!";
    } else {
        $stmt = $conn->prepare("UPDATE untitled_spreadsheet___sheet1 SET no_urut=?, ip_local=?, ip_publik=?, username=?, password=?, penanggung_jawab=?, nomor_wa=?, service=?, open_port=?, path=? WHERE id=?");
        $stmt->bind_param("ssssssssssi", $no_urut, $ip_local, $ip_publik, $username, $password, $penanggung_jawab, $nomor_wa, $service, $open_port, $path, $id);

        if ($stmt->execute()) {
            header("Location: index.php?pesan=diedit");
            exit;
        } else {
            $error = "Gagal menyimpan perubahan!";
        }
    }
}
?>

<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>✏️ Edit Server</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
    :root{
        --bg: #ffffff;
        --text: #0f172a;
        --muted: #6b7280;
        --accent: #0f766e;
        --border: #e5e7eb;
        --size: 16px;
    }
    *{box-sizing:border-box}
    body{
        font-family: 'Inter', system-ui, sans-serif;
        margin:0; background:#f8fafc; color:var(--text); font-size:var(--size);
        line-height:1.6;
    }
    .container{max-width:800px;margin:20px auto;padding:0 20px}
    .card{
        background:var(--bg);
        border:1px solid var(--border);
        border-radius:8px;
        padding:24px;
        margin-bottom:20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    h1{
        font-size:24px;
        margin:0 0 20px 0;
        color:var(--accent);
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
        border-radius:6px;
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
        border-radius:6px;
        font-weight:600;
        cursor:pointer;
        font-size:16px;
    }
    .btn:hover{
        opacity:0.9;
    }
    .alert{
        padding:12px;
        background:#fee2e2;
        color:#b91c1c;
        border-radius:6px;
        margin-bottom:20px;
    }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-link">⬅ Kembali ke Daftar Server</a>

        <div class="card">
            <h1>✏️ Edit Server: <?= htmlspecialchars($server['no_urut']) ?></h1>

            <?php if (!empty($error)): ?>
                <div class="alert"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>No. Urut:</label>
                    <input type="text" name="no_urut" value="<?= htmlspecialchars($server['no_urut']) ?>" required>
                </div>

                <div class="form-group">
                    <label>IP Local:</label>
                    <input type="text" name="ip_local" value="<?= htmlspecialchars($server['ip_local']) ?>" required>
                </div>

                <div class="form-group">
                    <label>IP Publik:</label>
                    <input type="text" name="ip_publik" value="<?= htmlspecialchars($server['ip_publik']) ?>">
                </div>

                <div class="form-group">
                    <label>Username:</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($server['username']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Password:</label>
                    <input type="text" name="password" value="<?= htmlspecialchars($server['password']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Penanggung Jawab:</label>
                    <input type="text" name="penanggung_jawab" value="<?= htmlspecialchars($server['penanggung_jawab']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Nomor WhatsApp:</label>
                    <input type="text" name="nomor_wa" value="<?= htmlspecialchars($server['nomor_wa']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Service:</label>
                    <textarea name="service"><?= htmlspecialchars($server['service']) ?></textarea>
                </div>

                <div class="form-group">
                    <label>Open Port:</label>
                    <textarea name="open_port"><?= htmlspecialchars($server['open_port']) ?></textarea>
                </div>

                <div class="form-group">
                    <label>Path:</label>
                    <textarea name="path"><?= htmlspecialchars($server['path']) ?></textarea>
                </div>

                <button type="submit" class="btn">💾 Simpan Perubahan</button>
            </form>
        </div>
    </div>
</body>
</html>