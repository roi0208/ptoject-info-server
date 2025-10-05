<?php
// Mulai session
session_start();

// Hancurkan semua data session
$_SESSION = array();

// Jika ingin menghapus cookie session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hancurkan session
session_destroy();

// Redirect ke login dengan pesan
header('Location: login.php?logout=success');
exit;
?>