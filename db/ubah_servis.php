<?php

require_once __DIR__ . '/servis_api.php';
require_once __DIR__ . '/koneksi.php';

api_require('POST', 'csrf_servis');
$id = api_post_id('ID data servis kendaraan tidak valid.');
$data = servis_api_validated_data();

try {
    $db = koneksi_database();
    $query = $db->prepare(
        'UPDATE servis
         SET id_kendaraan = :kendaraan, id_jenis = :jenis, tanggal = :tanggal,
             kilometer = :kilometer, bengkel = :bengkel, biaya = :biaya, catatan = :catatan
         WHERE id_servis = :id'
    );
    $query->execute([
        'kendaraan' => $data['kendaraanId'],
        'jenis' => $data['jenisId'],
        'tanggal' => $data['tanggal'],
        'kilometer' => $data['kilometer'],
        'bengkel' => $data['bengkel'],
        'biaya' => $data['biaya'],
        'catatan' => $data['catatan'],
        'id' => $id,
    ]);

    if ($query->rowCount() === 0) {
        $check = $db->prepare('SELECT 1 FROM servis WHERE id_servis = :id');
        $check->execute(['id' => $id]);

        if (!$check->fetchColumn()) {
            api_response(['message' => 'Data servis kendaraan tidak ditemukan.'], 404);
        }
    }

    api_response(['message' => 'Data servis kendaraan berhasil diperbarui.']);
} catch (PDOException $exception) {
    if ($exception->getCode() === '23000') {
        api_response(['message' => 'Kendaraan atau jenis servis yang dipilih tidak ditemukan.'], 422);
    }

    error_log('Service history update database error: ' . $exception->getMessage());
    api_response(['message' => 'Data servis kendaraan tidak dapat diperbarui.'], 500);
}
