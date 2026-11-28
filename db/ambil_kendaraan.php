<?php

require_once __DIR__ . '/kendaraan_api.php';
require_once __DIR__ . '/koneksi.php';

api_require('GET');

try {
    $query = koneksi_database()->query(
        'SELECT id_kendaraan, merk, tipe, no_polisi, tahun
         FROM kendaraan
         ORDER BY id_kendaraan DESC'
    );
    $kendaraan = array_map(
        static function (array $row): array {
            return [
                'id' => (int) $row['id_kendaraan'],
                'nama' => $row['merk'],
                'jenis' => $row['tipe'],
                'polisi' => $row['no_polisi'],
                'tahun' => (int) $row['tahun'],
            ];
        },
        $query->fetchAll()
    );

    api_response(['data' => $kendaraan]);
} catch (PDOException $exception) {
    error_log('Vehicle list database error: ' . $exception->getMessage());
    api_response(['message' => 'Daftar kendaraan tidak dapat dimuat.'], 500);
}
