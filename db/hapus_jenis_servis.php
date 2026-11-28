<?php

require_once __DIR__ . '/jenis_servis_api.php';
require_once __DIR__ . '/koneksi.php';

api_require('POST', 'csrf_jenis_servis');
$id = api_post_id('ID jenis servis tidak valid.');

try {
    $query = koneksi_database()->prepare(
        'DELETE FROM jenis_servis
         WHERE id_jenis = :id'
    );
    $query->execute(['id' => $id]);

    if ($query->rowCount() === 0) {
        api_response(['message' => 'Jenis servis tidak ditemukan.'], 404);
    }

    api_response(['message' => 'Jenis servis berhasil dihapus.']);
} catch (PDOException $exception) {
    if ($exception->getCode() === '23000') {
        api_response(
            ['message' => 'Jenis servis tidak dapat dihapus karena sudah digunakan pada data servis kendaraan.'],
            409
        );
    }

    error_log('Service type delete database error: ' . $exception->getMessage());
    api_response(['message' => 'Jenis servis tidak dapat dihapus.'], 500);
}
