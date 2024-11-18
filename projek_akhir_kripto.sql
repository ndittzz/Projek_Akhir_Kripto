-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Nov 2024 pada 15.34
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projek_akhir_kripto`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'mohamad risqi', 'bdc517bec1eadc9e34923ccef9ae471a');

-- --------------------------------------------------------

--
-- Struktur dari tabel `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `aes_key` varchar(255) DEFAULT NULL,
  `upload` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `file`
--

INSERT INTO `file` (`id`, `id_pegawai`, `nama`, `file`, `aes_key`, `upload`) VALUES
(1, 1, 'John Doe', 'encrypted_CV_JohnDoe.pdf', 'punyajohndoe', '2024-11-18 14:23:22'),
(2, 2, 'Jane Smith', 'encrypted_CV_Jane.pdf', 'inipunyajane', '2024-11-18 14:26:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gambar`
--

CREATE TABLE `gambar` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `upload` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `gambar`
--

INSERT INTO `gambar` (`id`, `id_pegawai`, `nama`, `gambar`, `upload`) VALUES
(1, 1, 'John Doe', 'encrypted_Foto_JohnDoe.jpg', '2024-11-18 08:28:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gaji` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `aes_key` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nik`, `nama`, `alamat`, `no_telepon`, `email`, `gaji`, `jabatan`, `tanggal_masuk`, `aes_key`) VALUES
(1, 'UpOJ6muK8SdRt5vad2jBAjftx56AfqU16hXjzD9mg4Gmpw5Ut/aH2yKgV1Rv4GPZ', 'John Doe', 'C4HshXvEHNTlU1Mv+OXtQ5uJV8Cj67WyZfHVsOTe2DD+ffiQfXrd23XCbhG3XWJ0', 'I5Y51oEWYWFAovGSUIve/7xjZWVSe7GHcyzk6DiOUic=', 'LA+2dfUy3lfhVVhn1ufNJOjj17jzsuHOXMsAhWyTWOsDbu5aGhPJg2mfzVuBDPgG', '+5c5/hZSJxxnjx0akulGBplQx1uGQOTZ1qfG6jY/CFE=', 'Manager', '2020-01-08', 'key123'),
(2, 'vbnLuBsFAdwMbGxD6dPluSUa7wXWBXgN71nasNwtwywwsMATK6bWtNwBkC20XmPi', 'Jane Smith', 'UHZGGboh1sD9Vn74YDDH4L+xkSB32p3+Wyeyl7cNZee7z1oHERHguCRvp3lrvVAS', 'CuG295QuUXpEOUQd9zB19FXTZ9MqEgGE51mh1ThZ/Pg=', 'k4PpM8+sSSwZi5ynGySKMdSa1Ko7hhl+tFLJpjtvyVQg+HdQ5PQPBiAiYtWMyqJq', 'NRU3J1mJfmJc2efwAzqtQ2e84hFkHhf2GHz/2vrTk1M=', 'Supervisor', '2021-02-26', 'key456');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `gambar`
--
ALTER TABLE `gambar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `gambar`
--
ALTER TABLE `gambar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
