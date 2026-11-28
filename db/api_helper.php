<?php

require_once __DIR__ . '/auth.php';

header('Content-Type: application/json; charset=utf-8');

function api_response(array $data, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

function api_require(string $method, ?string $csrfSessionKey = null): void
{
    if (pengguna_login() === null) {
        api_response(['message' => 'Sesi login berakhir. Silakan login kembali.'], 401);
    }

    if ($_SERVER['REQUEST_METHOD'] !== $method) {
        header('Allow: ' . $method);
        api_response(['message' => 'Metode permintaan tidak diizinkan.'], 405);
    }

    if ($csrfSessionKey !== null) {
        $expectedToken = $_SESSION[$csrfSessionKey] ?? '';
        $providedToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

        if (
            !is_string($expectedToken)
            || $expectedToken === ''
            || !is_string($providedToken)
            || !hash_equals($expectedToken, $providedToken)
        ) {
            api_response(['message' => 'Permintaan tidak valid. Muat ulang halaman dan coba lagi.'], 403);
        }
    }
}

function api_post_field(string $name, string $invalidMessage = 'Data permintaan tidak lengkap atau tidak valid.'): string
{
    $value = $_POST[$name] ?? null;

    if (!is_string($value)) {
        api_response(['message' => $invalidMessage], 422);
    }

    return trim($value);
}

function api_post_id(string $invalidMessage = 'ID tidak valid.'): int
{
    $id = filter_var(api_post_field('id', $invalidMessage), FILTER_VALIDATE_INT);

    if ($id === false || $id < 1) {
        api_response(['message' => $invalidMessage], 422);
    }

    return $id;
}
