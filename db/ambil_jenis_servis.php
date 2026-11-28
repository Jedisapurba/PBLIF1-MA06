<?php

require_once __DIR__ . '/jenis_servis_api.php';
require_once __DIR__ . '/koneksi.php';

api_require('GET');

try {
    $query = koneksi_database()->query(
        'SELECT id_jenis, nama_servis, interval_km, interval_bulan, keterangan
         FROM jenis_servis
         ORDER BY id_jenis DESC'
    );
    $jenisServis = array_map(
        static function (array $row): array {
            return [
                'id' => (int) $row['id_jenis'],
                'nama' => $row['nama_servis'],
                'intervalKm' => $row['interval_km'] === null ? null : (int) $row['interval_km'],
                'intervalBulan' => $row['interval_bulan'] === null ? null : (int) $row['interval_bulan'],
                'keterangan' => $row['keterangan'],
            ];
        },
        $query->fetchAll()
    );

    api_response(['data' => $jenisServis]);
} catch (PDOException $exception) {
    error_log('Service type list database error: ' . $exception->getMessage());
    api_response(['message' => 'Daftar jenis servis tidak dapat dimuat.'], 500);
}
