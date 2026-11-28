<?php

require_once __DIR__ . '/kendaraan_api.php';
require_once __DIR__ . '/koneksi.php';

api_require('POST', 'csrf_kendaraan');
$id = api_post_id('ID kendaraan tidak valid.');
$data = kendaraan_api_validated_data();

try {
    $db = koneksi_database();
    $query = $db->prepare(
        'UPDATE kendaraan
         SET no_polisi = :polisi, merk = :nama, tipe = :jenis, tahun = :tahun
         WHERE id_kendaraan = :id'
    );
    $query->execute([
        'polisi' => $data['polisi'],
        'nama' => $data['nama'],
        'jenis' => $data['jenis'],
        'tahun' => $data['tahun'],
        'id' => $id,
    ]);

    if ($query->rowCount() === 0) {
        $check = $db->prepare('SELECT 1 FROM kendaraan WHERE id_kendaraan = :id');
        $check->execute(['id' => $id]);

        if (!$check->fetchColumn()) {
            api_response(['message' => 'Kendaraan tidak ditemukan.'], 404);
        }
    }

    api_response(['message' => 'Kendaraan berhasil diperbarui.']);
} catch (PDOException $exception) {
    if ($exception->getCode() === '23000') {
        api_response(['message' => 'Nomor polisi tersebut sudah terdaftar.'], 409);
    }

    error_log('Vehicle update database error: ' . $exception->getMessage());
    api_response(['message' => 'Kendaraan tidak dapat diperbarui.'], 500);
}
