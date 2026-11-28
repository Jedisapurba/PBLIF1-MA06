-- Jalankan satu kali pada database lama. Tidak diperlukan setelah impor dump terbaru.
ALTER TABLE jenis_servis
  ADD COLUMN interval_km INT UNSIGNED DEFAULT NULL,
  ADD COLUMN interval_bulan INT UNSIGNED DEFAULT NULL;
