<?php

require_once __DIR__ . '/kendaraan_api.php';
require_once __DIR__ . '/koneksi.php';

api_require('POST', 'csrf_kendaraan');
$data = kendaraan_api_validated_data();

try {
    $query = koneksi_database()->prepare(
        'INSERT INTO kendaraan (no_polisi, merk, tipe, tahun)
         VALUES (:polisi, :nama, :jenis, :tahun)'
    );
    $query->execute([
        'polisi' => $data['polisi'],
        'nama' => $data['nama'],
        'jenis' => $data['jenis'],
        'tahun' => $data['tahun'],
    ]);

    api_response(['message' => 'Kendaraan berhasil ditambahkan.'], 201);
} catch (PDOException $exception) {
    if ($exception->getCode() === '23000') {
        api_response(['message' => 'Nomor polisi tersebut sudah terdaftar.'], 409);
    }

    error_log('Vehicle create database error: ' . $exception->getMessage());
    api_response(['message' => 'Kendaraan tidak dapat disimpan.'], 500);
}
