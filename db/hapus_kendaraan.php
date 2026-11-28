<?php

require_once __DIR__ . '/kendaraan_api.php';
require_once __DIR__ . '/koneksi.php';

api_require('POST', 'csrf_kendaraan');
$id = api_post_id('ID kendaraan tidak valid.');

try {
    $query = koneksi_database()->prepare(
        'DELETE FROM kendaraan
         WHERE id_kendaraan = :id'
    );
    $query->execute(['id' => $id]);

    if ($query->rowCount() === 0) {
        api_response(['message' => 'Kendaraan tidak ditemukan.'], 404);
    }

    api_response(['message' => 'Kendaraan berhasil dihapus.']);
} catch (PDOException $exception) {
    if ($exception->getCode() === '23000') {
        api_response(
            ['message' => 'Kendaraan tidak dapat dihapus karena masih memiliki data servis kendaraan.'],
            409
        );
    }

    error_log('Vehicle delete database error: ' . $exception->getMessage());
    api_response(['message' => 'Kendaraan tidak dapat dihapus.'], 500);
}
