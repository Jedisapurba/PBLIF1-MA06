<?php

require_once __DIR__ . '/api_helper.php';

function servis_api_validated_data(): array
{
    $tanggal = api_post_field('tanggal', 'Data servis kendaraan tidak lengkap atau tidak valid.');
    $kendaraanId = filter_var(
        api_post_field('kendaraanId', 'Data servis kendaraan tidak lengkap atau tidak valid.'),
        FILTER_VALIDATE_INT
    );
    $jenisId = filter_var(
        api_post_field('jenisId', 'Data servis kendaraan tidak lengkap atau tidak valid.'),
        FILTER_VALIDATE_INT
    );
    $kilometer = filter_var(
        api_post_field('km', 'Data servis kendaraan tidak lengkap atau tidak valid.'),
        FILTER_VALIDATE_INT
    );
    $biaya = filter_var(
        api_post_field('biaya', 'Data servis kendaraan tidak lengkap atau tidak valid.'),
        FILTER_VALIDATE_INT
    );
    $bengkel = api_post_field('bengkel', 'Data servis kendaraan tidak lengkap atau tidak valid.');
    $catatan = api_post_field('catatan', 'Data servis kendaraan tidak lengkap atau tidak valid.');
    $date = DateTimeImmutable::createFromFormat('!Y-m-d', $tanggal);
    $dateErrors = DateTimeImmutable::getLastErrors();
    $dateHasErrors = $dateErrors !== false
        && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0);

    if (
        $date === false
        || $dateHasErrors
        || $date->format('Y-m-d') !== $tanggal
    ) {
        api_response(['message' => 'Tanggal servis harus menggunakan tanggal yang valid.'], 422);
    }

    if ($kendaraanId === false || $kendaraanId < 1) {
        api_response(['message' => 'Pilih kendaraan yang valid.'], 422);
    }

    if ($jenisId === false || $jenisId < 1) {
        api_response(['message' => 'Pilih jenis servis yang valid.'], 422);
    }

    if ($kilometer === false || $kilometer < 0 || $kilometer > 2147483647) {
        api_response(['message' => 'Kilometer harus berupa bilangan bulat antara 0 dan 2147483647.'], 422);
    }

    if ($biaya === false || $biaya < 0 || $biaya > 9999999999) {
        api_response(['message' => 'Biaya harus berupa bilangan bulat yang valid.'], 422);
    }

    if (mb_strlen($bengkel, 'UTF-8') > 100) {
        api_response(['message' => 'Nama bengkel maksimal 100 karakter.'], 422);
    }

    if (strlen($catatan) > 65535) {
        api_response(['message' => 'Catatan servis terlalu panjang.'], 422);
    }

    return [
        'tanggal' => $tanggal,
        'kendaraanId' => $kendaraanId,
        'jenisId' => $jenisId,
        'kilometer' => $kilometer,
        'biaya' => $biaya,
        'bengkel' => $bengkel,
        'catatan' => $catatan,
    ];
}
