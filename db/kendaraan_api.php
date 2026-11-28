<?php

require_once __DIR__ . '/api_helper.php';

function kendaraan_api_validated_data(): array
{
    $nama = api_post_field('nama', 'Data kendaraan tidak lengkap atau tidak valid.');
    $jenis = api_post_field('jenis', 'Data kendaraan tidak lengkap atau tidak valid.');
    $polisi = strtoupper(api_post_field('polisi', 'Data kendaraan tidak lengkap atau tidak valid.'));
    $tahun = filter_var(api_post_field('tahun', 'Data kendaraan tidak lengkap atau tidak valid.'), FILTER_VALIDATE_INT);

    if ($nama === '' || mb_strlen($nama, 'UTF-8') > 50) {
        api_response(['message' => 'Nama kendaraan wajib diisi dan maksimal 50 karakter.'], 422);
    }

    if (!in_array($jenis, ['Motor', 'Mobil'], true)) {
        api_response(['message' => 'Jenis kendaraan harus Motor atau Mobil.'], 422);
    }

    if ($polisi === '' || mb_strlen($polisi, 'UTF-8') > 15) {
        api_response(['message' => 'Nomor polisi wajib diisi dan maksimal 15 karakter.'], 422);
    }

    $tahunMaksimal = 2050;
    if ($tahun === false || $tahun < 1901 || $tahun > $tahunMaksimal) {
        api_response(['message' => 'Tahun kendaraan harus antara 1901 dan ' . $tahunMaksimal . '.'], 422);
    }

    return [
        'nama' => $nama,
        'jenis' => $jenis,
        'polisi' => $polisi,
        'tahun' => $tahun,
    ];
}
