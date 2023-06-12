-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jun 2023 pada 19.05
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cookies_moveon`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `stok_terjual` int(11) NOT NULL,
  `tanggal_penjualan` datetime NOT NULL,
  `total_harga` int(11) NOT NULL,
  `nama_pembeli` varchar(100) NOT NULL,
  `alamat_pembeli` text NOT NULL,
  `status_penjualan` enum('Belum','Selesai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_produk`, `stok_terjual`, `tanggal_penjualan`, `total_harga`, `nama_pembeli`, `alamat_pembeli`, `status_penjualan`) VALUES
(2, 7, 2, '2023-06-12 23:40:00', 100000, 'Andri Firman Saputra', 'Jl. AMD Babakan Pocis', 'Selesai'),
(3, 1, 3, '2023-06-12 23:43:00', 150000, 'Andre', 'Pocis', 'Selesai'),
(4, 1, 1, '2023-06-13 00:02:00', 50000, 'Andri Firman Saputra', 'Pocis', 'Selesai'),
(5, 3, 2, '2023-06-13 00:03:00', 16000, 'Andri Firman Saputra', 'Pocis', 'Selesai'),
(6, 7, 2, '2023-06-13 00:03:00', 100000, 'Andre', 'Pocis', 'Belum');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `jenis_produk` enum('Kue','Roti','Pizza') NOT NULL,
  `satuan_produk` enum('Pcs','Toples') NOT NULL,
  `stok_produk` int(11) NOT NULL,
  `harga_produk` int(11) NOT NULL,
  `foto_produk` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `jenis_produk`, `satuan_produk`, `stok_produk`, `harga_produk`, `foto_produk`) VALUES
(1, 'Nastar', 'Kue', 'Toples', 97, 50000, '648749eb3fef8Nastar.jpeg'),
(2, 'Sagu Keju', 'Kue', 'Pcs', 101, 50000, 'Sagu Keju.jpeg'),
(3, 'Pizza Mini', 'Pizza', 'Pcs', 99, 8000, 'Pizza.jpeg'),
(4, 'Pizza', 'Pizza', 'Pcs', 101, 35000, 'Pizza.jpeg'),
(5, 'Lidah Kucing', 'Kue', 'Pcs', 101, 50000, 'Lidah Kucing.jpeg'),
(6, 'Putri Salju', 'Kue', 'Pcs', 101, 50000, 'Putri Salju.jpeg'),
(7, 'Bolu Kacang', 'Kue', 'Pcs', 96, 50000, '6487301fefe79Bolu Kacang Almond.jpeg'),
(8, 'Roti Usro', 'Roti', 'Pcs', 301, 2500, 'Roti usro.jpeg'),
(9, 'Peler bedebu', 'Kue', 'Pcs', 101, 2000, '6486fbc52b76f-d4a737b9-eb1a-475f-a90b-23c8a9d9e7a4_43.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'admin', '$2y$10$pTnbyZVJa8JH0gtk7MVmGOSrWjvoanDyMGgWZYjbbUtyn2LLNoqlu', 'Administrator');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
