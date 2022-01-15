-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jan 2022 pada 03.55
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lay_diskusi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE `komentar` (
  `id` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `waktu` varchar(32) NOT NULL,
  `pesan` varchar(300) DEFAULT NULL,
  `pengirim` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `komentar`
--

INSERT INTO `komentar` (`id`, `id_post`, `waktu`, `pesan`, `pengirim`) VALUES
(1, 1, '1635684157', 'silahkan dikerjakan file proposalnya untuk melanjutkan ke jenjan', '170411100042'),
(2, 1, '1635765747', 'segera upload filenya sehingga dapat kami periksa kekurangannya', '170411100024'),
(3, 1, '1635775209', 'baik akan saya kerjakan', '170411100099'),
(4, 1, '1635865059', 'sedang saya kerjakan', '170411100099'),
(5, 8, '1639306683', 'silahkan upload file dan judul yang ingin terapkan', '197406102008121002'),
(6, 8, '1639314356', 'sip mas silahkan di lanjutkan untuk mendaftar seminar proposal', '198002232008121001'),
(7, 9, '1639320630', 'silahkan update proposal terbarunya', '197406102008121002'),
(8, 10, '1639320655', 'silahkan update skripsi terbarunya mas', '197406102008121002'),
(9, 10, '1639320687', 'baik bapak', '170411100106'),
(10, 10, '1639320716', 'untuk meetnya silahkan join link berikut :\r\nmeet.trunojoyo.ac.id/1j2n3bnun/', '170411100106'),
(11, 10, '1639320797', 'ok terimakasih atas pertemuannya saya harap para penguji memberi nilai sesuai apa yang telah dipresentasikan', '198002232008121001'),
(12, 10, '1639320878', 'ok siap', '198101092006041003'),
(13, 10, '1639320939', 'sudah saya berikan nilai sesuai kemampuan mahasiswa', '198609262014041001'),
(14, 10, '1639320988', 'hasil kalkulasi nilai sudah muncul', '170411100042');

-- --------------------------------------------------------

--
-- Struktur dari tabel `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `id_skripsi` int(11) NOT NULL,
  `tipe` int(1) NOT NULL,
  `tanggal_dibuat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `post`
--

INSERT INTO `post` (`id`, `id_skripsi`, `tipe`, `tanggal_dibuat`) VALUES
(1, 1, 1, '0000-00-00'),
(2, 2, 2, '0000-00-00'),
(3, 3, 3, '0000-00-00'),
(4, 1, 2, '0000-00-00'),
(7, 1, 3, '0000-00-00'),
(8, 4, 1, '0000-00-00'),
(9, 4, 2, '0000-00-00'),
(10, 4, 3, '0000-00-00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tipe`
--

CREATE TABLE `tipe` (
  `id` int(1) NOT NULL,
  `keterangan` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tipe`
--

INSERT INTO `tipe` (`id`, `keterangan`) VALUES
(1, 'bimbingan'),
(2, 'proposal'),
(3, 'sidang');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `komentar_post` (`id_post`);

--
-- Indeks untuk tabel `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_tipe` (`tipe`);

--
-- Indeks untuk tabel `tipe`
--
ALTER TABLE `tipe`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tipe`
--
ALTER TABLE `tipe`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_post` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_tipe` FOREIGN KEY (`tipe`) REFERENCES `tipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
