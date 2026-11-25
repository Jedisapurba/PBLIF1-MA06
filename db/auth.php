<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    $isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params([
        'httponly' => true,
        'secure' => $isHttps,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function pengguna_login(): ?array
{
    return isset($_SESSION['pengguna']) && is_array($_SESSION['pengguna'])
        ? $_SESSION['pengguna']
        : null;
}

function wajib_login(): void
{
    if (pengguna_login() === null) {
        header('Location: ../login.php');
        exit;
    }
}
