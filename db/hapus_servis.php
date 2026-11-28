<?php

require_once __DIR__ . '/servis_api.php';
require_once __DIR__ . '/koneksi.php';

api_require('POST', 'csrf_servis');
$id = api_post_id('ID data servis kendaraan tidak valid.');

try {
    $query = koneksi_database()->prepare(
        'DELETE FROM servis
         WHERE id_servis = :id'
    );
    $query->execute(['id' => $id]);

    if ($query->rowCount() === 0) {
        api_response(['message' => 'Data servis kendaraan tidak ditemukan.'], 404);
    }

    api_response(['message' => 'Data servis kendaraan berhasil dihapus.']);
} catch (PDOException $exception) {
    error_log('Service history delete database error: ' . $exception->getMessage());
    api_response(['message' => 'Data servis kendaraan tidak dapat dihapus.'], 500);
}
