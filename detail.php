<?php
require 'koneksi.php';

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM untitled_spreadsheet___sheet1 WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$server = $result->fetch_assoc();

if (!$server) {
    die("Server tidak ditemukan!");
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
    <title>🔍 Detail Server</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        /* Modernized detail view styles */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
        :root{
            --bg: linear-gradient(180deg,#f8fafc,#eef2fb);
            --card: #ffffff;
            --muted: #475569;
            --accent: #0f766e;
            --border: #e6eef3;
            --size: 14px;
            --radius: 10px;
            --accent-2: #06b6d4;
        }
        *{box-sizing:border-box}
        body{
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
            margin:0; background:var(--bg); color:#0f172a; font-size:var(--size); line-height:1.5;
        }
        .container{max-width:900px;margin:28px auto;padding:0 16px}
        .card{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:var(--radius);
            padding:20px;
            margin-bottom:20px;
            box-shadow:0 6px 18px rgba(15,23,42,0.06);
        }
    .head-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;background:linear-gradient(90deg,var(--accent),var(--accent-2));padding:12px;border-radius:8px;color:white}
    h1{font-size:16px;margin:0;color:white;font-weight:600;display:flex;gap:8px;align-items:center}
    .back-link{display:inline-flex;gap:8px;align-items:center;padding:8px 12px;border-radius:8px;background:#ffffff;border:1px solid var(--border);text-decoration:none;color:var(--accent);font-weight:600}
    .top-back{display:inline-flex;margin-bottom:12px;text-decoration:none;color:var(--accent);font-weight:600;padding:6px 10px;border-radius:8px;border:1px solid var(--border);background:#ffffff}

        .grid{display:grid;grid-template-columns:200px 1fr;gap:12px 20px;align-items:start}
        .detail-label{color:var(--muted);font-weight:600}
        .detail-value{color:#071025}

    .chip{display:inline-block;padding:6px 8px;border-radius:8px;background:#fff;color:var(--accent);font-weight:700;font-size:13px}
    .chip.ip{background:linear-gradient(90deg,#eefbf8,#e6f7ff);color:#047857}
    .chip.pub{background:linear-gradient(90deg,#fff7ed,#fff1f2);color:#c2410c}
    .chip.pwd{background:linear-gradient(90deg,#f0f9ff,#eff6ff);color:#0369a1}
    .chip.wa{background:linear-gradient(90deg,#fff7ed,#ffefef);color:#b91c1c}
    a.wa-link{text-decoration:none}

        .password-control{display:inline-flex;gap:8px;align-items:center}
        .password-plain{display:none}
        .btn-toggle{background:#0f766e;color:white;border:none;padding:6px 8px;border-radius:6px;cursor:pointer;font-size:13px}

        @media (max-width:640px){
            .grid{grid-template-columns:1fr}
        }
    </style>
</head>
<body>
    <div class="container">
        <a class="top-back" href="index.php">⬅ Kembali ke Daftar</a>

        <div class="card">
            <div class="head-row">
                <h1>🔍 Detail Server: <?= htmlspecialchars($server['no_urut']) ?></h1>
            </div>
            <div class="grid">
                <div class="detail-label">No. Urut:</div>
                <div class="detail-value"><?= htmlspecialchars($server['no_urut']) ?></div>

                <div class="detail-label">IP Local:</div>
                <div class="detail-value"><span class="chip ip"><?= htmlspecialchars($server['ip_local']) ?></span></div>

                <div class="detail-label">IP Publik:</div>
                <div class="detail-value">
                    <?php if (!empty($server['ip_publik'])): ?>
                        <span class="chip pub"><?= htmlspecialchars($server['ip_publik']) ?></span>
                    <?php else: ?>
                        <em>Tidak ada</em>
                    <?php endif; ?>
                </div>

                <div class="detail-label">Username:</div>
                <div class="detail-value"><?= htmlspecialchars($server['username']) ?></div>

                <div class="detail-label">Password:</div>
                <div class="detail-value">
                    <span class="chip pwd"><?= htmlspecialchars($server['password']) ?></span>
                </div>

                <div class="detail-label">Penanggung Jawab:</div>
                <div class="detail-value"><?= htmlspecialchars($server['penanggung_jawab']) ?></div>

                <div class="detail-label">Nomor WhatsApp:</div>
                <div class="detail-value">
                    <?php if (!empty($server['nomor_wa'])): ?>
                        <a class="wa-link" href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $server['nomor_wa']) ?>" target="_blank">
                            <span class="chip wa"><?= htmlspecialchars($server['nomor_wa']) ?></span>
                        </a>
                    <?php else: ?>
                        <em>Tidak ada</em>
                    <?php endif; ?>
                </div>

                <div class="detail-label">Service:</div>
                <div class="detail-value"><?= nl2br(htmlspecialchars($server['service'])) ?></div>

                <div class="detail-label">Open Port:</div>
                <div class="detail-value"><?= htmlspecialchars($server['open_port']) ?></div>

                <div class="detail-label">Path:</div>
                <div class="detail-value"><?= nl2br(htmlspecialchars($server['path'])) ?></div>
            </div>
        </div>
    </div>
    
</body>
</html>