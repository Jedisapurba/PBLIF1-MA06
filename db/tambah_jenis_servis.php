<?php

require_once __DIR__ . '/jenis_servis_api.php';
require_once __DIR__ . '/koneksi.php';

api_require('POST', 'csrf_jenis_servis');
$data = jenis_servis_api_validated_data();

try {
    $query = koneksi_database()->prepare(
        'INSERT INTO jenis_servis (nama_servis, interval_km, interval_bulan, keterangan)
         VALUES (:nama, :interval_km, :interval_bulan, :keterangan)'
    );
    $query->bindValue(':nama', $data['nama']);
    $query->bindValue(':interval_km', $data['intervalKm'], $data['intervalKm'] === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
    $query->bindValue(':interval_bulan', $data['intervalBulan'], $data['intervalBulan'] === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
    $query->bindValue(':keterangan', $data['keterangan']);
    $query->execute();

    api_response(['message' => 'Jenis servis berhasil ditambahkan.'], 201);
} catch (PDOException $exception) {
    error_log('Service type create database error: ' . $exception->getMessage());
    api_response(['message' => 'Jenis servis tidak dapat disimpan.'], 500);
}
