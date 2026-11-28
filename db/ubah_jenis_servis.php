<?php

require_once __DIR__ . '/jenis_servis_api.php';
require_once __DIR__ . '/koneksi.php';

api_require('POST', 'csrf_jenis_servis');
$id = api_post_id('ID jenis servis tidak valid.');
$data = jenis_servis_api_validated_data();

try {
    $db = koneksi_database();
    $query = $db->prepare(
        'UPDATE jenis_servis
         SET nama_servis = :nama,
             interval_km = :interval_km,
             interval_bulan = :interval_bulan,
             keterangan = :keterangan
         WHERE id_jenis = :id'
    );
    $query->bindValue(':nama', $data['nama']);
    $query->bindValue(':interval_km', $data['intervalKm'], $data['intervalKm'] === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
    $query->bindValue(':interval_bulan', $data['intervalBulan'], $data['intervalBulan'] === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
    $query->bindValue(':keterangan', $data['keterangan']);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();

    if ($query->rowCount() === 0) {
        $check = $db->prepare('SELECT 1 FROM jenis_servis WHERE id_jenis = :id');
        $check->execute(['id' => $id]);

        if (!$check->fetchColumn()) {
            api_response(['message' => 'Jenis servis tidak ditemukan.'], 404);
        }
    }

    api_response(['message' => 'Jenis servis berhasil diperbarui.']);
} catch (PDOException $exception) {
    error_log('Service type update database error: ' . $exception->getMessage());
    api_response(['message' => 'Jenis servis tidak dapat diperbarui.'], 500);
}
