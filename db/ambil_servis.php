<?php

require_once __DIR__ . '/servis_api.php';
require_once __DIR__ . '/koneksi.php';

api_require('GET');

try {
    $query = koneksi_database()->query(
        'SELECT s.id_servis, s.id_kendaraan, k.merk, k.no_polisi, s.id_jenis,
                j.nama_servis, s.tanggal, s.kilometer, s.bengkel, s.biaya, s.catatan
         FROM servis s
         INNER JOIN kendaraan k ON k.id_kendaraan = s.id_kendaraan
         INNER JOIN jenis_servis j ON j.id_jenis = s.id_jenis
         ORDER BY s.tanggal DESC, s.id_servis DESC'
    );
    $riwayat = array_map(
        static function (array $row): array {
            return [
                'id' => (int) $row['id_servis'],
                'tanggal' => $row['tanggal'],
                'kendaraanId' => (int) $row['id_kendaraan'],
                'kendaraan' => $row['merk'],
                'polisi' => $row['no_polisi'],
                'jenisId' => (int) $row['id_jenis'],
                'jenis' => $row['nama_servis'],
                'bengkel' => $row['bengkel'],
                'km' => (int) $row['kilometer'],
                'biaya' => (float) $row['biaya'],
                'catatan' => $row['catatan'],
            ];
        },
        $query->fetchAll()
    );

    api_response(['data' => $riwayat]);
} catch (PDOException $exception) {
    error_log('Service history list database error: ' . $exception->getMessage());
    api_response(['message' => 'Daftar servis kendaraan tidak dapat dimuat.'], 500);
}
