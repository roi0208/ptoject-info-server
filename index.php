<?php
require 'koneksi.php';
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// GANTI 'servers' dengan nama tabelmu jika berbeda!
$result = $conn->query("SELECT * FROM `untitled_spreadsheet___sheet1` ORDER BY no_urut");
$countRes = $conn->query("SELECT COUNT(*) as cnt FROM `untitled_spreadsheet___sheet1`");
$countRow = $countRes->fetch_assoc();
$serverCount = $countRow['cnt'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rekap Server Life Media</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
    /* inlined styles from styles.css */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

    :root{
        --bg: linear-gradient(180deg,#f8fafc,#eef2fb);
        --card: #ffffff;
        --text: #0f172a;
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
        margin:20px; background:var(--bg); color:var(--text); font-size:var(--size);
    }

    .container {
    width: 100%;
    padding: 0 20px; /* Menambah sedikit jarak di kanan-kiri agar tidak menempel */
    }

    /* Header: title left, actions (tombol) right */
    .site-head{display:flex;flex-direction:row;align-items:center;justify-content:space-between;margin:18px 0;background:linear-gradient(90deg,var(--accent),var(--accent-2));padding:18px;border-radius:12px;color:white;gap:16px}
    h1{font-size:24px;margin:0 0 6px 0;font-weight:700;color:white;display:flex;gap:8px;align-items:center}
    .meta{color:rgba(255,255,255,0.9);font-size:13px;margin:0}
    .actions{display:flex;align-items:center;gap:12px}
    .actions a{display:inline-block}
    .badge-count{background:rgba(255,255,255,0.12);padding:6px 10px;border-radius:999px;font-weight:700;margin-left:8px}

    .card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:16px;box-shadow:0 6px 18px rgba(15,23,42,0.06)}

    .table-wrap{overflow-x:auto}
    table{
        width:100%;border-collapse:collapse;background:transparent;
    }
    th, td{
        padding:10px 12px;border:1px solid var(--border);text-align:left;vertical-align:middle;font-size:var(--size);
    }
    th{
        background:#f1f5f9;color:var(--text);font-weight:600
    }

    tbody tr:hover{background:#f8fafc}

    .chip{display:inline-block;padding:6px 8px;border-radius:8px;background:#fff;color:var(--accent);font-weight:700;font-size:13px}
    .chip.ip{background:linear-gradient(90deg,#eefbf8,#e6f7ff);color:#047857}
    .chip.pub{background:linear-gradient(90deg,#fff7ed,#fff1f2);color:#c2410c}
    .chip.pwd{background:linear-gradient(90deg,#f0f9ff,#eff6ff);color:#0369a1}
    .chip.wa{background:linear-gradient(90deg,#fff7ed,#ffefef);color:#b91c1c}
    a.wa-link{color:var(--accent);text-decoration:none;font-weight:600}
    .cell-with-tooltip{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:block}
    
    td pre{margin:0;font-family:monospace;font-size:var(--size);white-space:pre-wrap}
    
    /* small screens */
    @media (max-width:600px){
        body{margin:12px}
        th,td{padding:8px}
        .site-head{flex-direction:column;align-items:center;text-align:center}
        .actions{width:100%;justify-content:center;margin-top:12px}
    }

    /* === [START] GAYA TOMBOL AKSI BARU === */
    .action-buttons {
    display: flex;
    flex-direction: row; /* Tombol tersusun ke bawah */
    gap: 6px; /* Jarak antar tombol */
    align-items: center;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px; /* Jarak antara ikon dan teks */
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        padding: 5px 10px;
        border-radius: 6px;
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }

    .btn:hover {
        filter: brightness(0.95);
        transform: translateY(-1px);
    }

    /* 🔹 Tombol Detail Warna Abu-abu */
    .btn-detail {
        background-color: #d3d3d3; /* Abu-abu muda */
        color: #475569;          /* Abu-abu tua (teks) */
    }

    /* 🔹 Tombol Edit Warna Biru */
    .btn-edit {
        background-color: #d3d3d3; /* Biru muda */
        color: #0369a1;          /* Biru tua (teks) */
    }

    /* 🔹 Tombol Hapus Warna Merah */
    .btn-delete {
        background-color: #d3d3d3; /* Merah muda */
        color: #b91c1c;          /* Merah tua (teks) */
    }
    /* === [END] GAYA TOMBOL AKSI BARU === */

    </style>
</head>
<body>
    <div class="container">
        <header class="site-head">
            <div class="site-title">
                <h1>📋 Rekap Server Life Media <span class="badge-count"><?= htmlspecialchars($serverCount) ?> Servers</span></h1>
                <p class="meta">Rekap semua server — daftar, IP, layanan, dan penanggung jawab</p>
            </div>
            <div class="actions">
                <a href="tambah.php" class="btn-add" style="background:#0f766e;color:white;padding:10px 20px;text-decoration:none;border-radius:8px;font-weight:700;display:inline-block;">➕ Tambah Server Baru</a>
                <a href="logout.php" style="background:#b91c1c;color:white;padding:10px 20px;text-decoration:none;border-radius:8px;font-weight:700;display:inline-block;">🚪 Logout</a>
            </div>
        </header>

        <div class="card">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>IP Local</th>
                            <th>IP Publik</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Penanggung Jawab</th>
                            <th>WA</th>
                            <th>Service</th>
                            <th>Port</th>
                            <th>Path</th>
                            <th>Aksi</th> </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['no_urut'] ?? '') ?></td>
                            <td><span class="chip ip"><?= htmlspecialchars($row['ip_local'] ?? '') ?></span></td>
                            <td><?php if(!empty($row['ip_publik'])): ?><span class="chip pub"><?= htmlspecialchars($row['ip_publik']) ?></span><?php else: ?><em>Tidak ada</em><?php endif; ?></td>
                            <td><?= htmlspecialchars($row['username'] ?? '') ?></td>
                            <td><span class="chip pwd"><?= htmlspecialchars($row['password'] ?? '') ?></span></td>
                            <td><?= htmlspecialchars($row['penanggung_jawab'] ?? '') ?></td>
                            <td><?php if(!empty($row['nomor_wa'])): ?><a class="wa-link" href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $row['nomor_wa']) ?>" target="_blank"><span class="chip wa"><?= htmlspecialchars($row['nomor_wa']) ?></span></a><?php else: ?><em>Tidak ada</em><?php endif; ?></td>
                            <td>
                                <?php $svc = $row['service'] ?? ''; ?>
                                <div class="cell-with-tooltip" title="<?= htmlspecialchars($svc, ENT_QUOTES) ?>"><?= htmlspecialchars($svc) ?></div>
                            </td>
                            <td><?= htmlspecialchars($row['open_port'] ?? '') ?></td>
                            <td>
                                <?php $pth = $row['path'] ?? ''; ?>
                                <div class="cell-with-tooltip" title="<?= htmlspecialchars($pth, ENT_QUOTES) ?>"><?= htmlspecialchars($pth) ?></div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="detail.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-detail">🔍 Detail</a>
                                    <a href="edit.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-edit">✏️ Edit</a>
                                    <a href="hapus.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-delete" onclick="return confirm('Yakin hapus server ini?')">🗑️ Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>