<?php

require_once __DIR__ . '/servis_api.php';
require_once __DIR__ . '/koneksi.php';

api_require('POST', 'csrf_servis');
$data = servis_api_validated_data();

try {
    $query = koneksi_database()->prepare(
        'INSERT INTO servis (id_kendaraan, id_jenis, tanggal, kilometer, bengkel, biaya, catatan)
         VALUES (:kendaraan, :jenis, :tanggal, :kilometer, :bengkel, :biaya, :catatan)'
    );
    $query->execute([
        'kendaraan' => $data['kendaraanId'],
        'jenis' => $data['jenisId'],
        'tanggal' => $data['tanggal'],
        'kilometer' => $data['kilometer'],
        'bengkel' => $data['bengkel'],
        'biaya' => $data['biaya'],
        'catatan' => $data['catatan'],
    ]);

    api_response(['message' => 'Data servis kendaraan berhasil ditambahkan.'], 201);
} catch (PDOException $exception) {
    if ($exception->getCode() === '23000') {
        api_response(['message' => 'Kendaraan atau jenis servis yang dipilih tidak ditemukan.'], 422);
    }

    error_log('Service history create database error: ' . $exception->getMessage());
    api_response(['message' => 'Data servis kendaraan tidak dapat disimpan.'], 500);
}
