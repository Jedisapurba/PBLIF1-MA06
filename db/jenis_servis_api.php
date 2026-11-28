<?php

require_once __DIR__ . '/api_helper.php';

function jenis_servis_api_interval(string $value, string $label): ?int
{
    if ($value === '') {
        return null;
    }

    $interval = filter_var($value, FILTER_VALIDATE_INT);
    if ($interval === false || $interval < 1 || $interval > 2147483647) {
        api_response(
            ['message' => 'Interval ' . $label . ' harus bilangan bulat positif yang valid.'],
            422
        );
    }

    return $interval;
}

function jenis_servis_api_validated_data(): array
{
    $nama = api_post_field('nama', 'Data jenis servis tidak lengkap atau tidak valid.');
    $intervalKm = jenis_servis_api_interval(api_post_field('intervalKm', 'Data jenis servis tidak lengkap atau tidak valid.'), 'kilometer');
    $intervalBulan = jenis_servis_api_interval(api_post_field('intervalBulan', 'Data jenis servis tidak lengkap atau tidak valid.'), 'waktu');
    $keterangan = api_post_field('keterangan', 'Data jenis servis tidak lengkap atau tidak valid.');

    if ($nama === '' || mb_strlen($nama, 'UTF-8') > 100) {
        api_response(['message' => 'Nama jenis servis wajib diisi dan maksimal 100 karakter.'], 422);
    }

    if ($intervalKm === null && $intervalBulan === null) {
        api_response(['message' => 'Isi interval kilometer atau waktu.'], 422);
    }

    if (mb_strlen($keterangan, 'UTF-8') > 150) {
        api_response(['message' => 'Keterangan maksimal 150 karakter.'], 422);
    }

    return [
        'nama' => $nama,
        'intervalKm' => $intervalKm,
        'intervalBulan' => $intervalBulan,
        'keterangan' => $keterangan,
    ];
}
