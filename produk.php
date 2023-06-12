<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$produk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY nama_produk ASC");
?>


<!DOCTYPE html>
<html>
<head>
	<title>Produk</title>
	<?php include_once 'head.php'; ?>
</head>
<body>

	<?php include_once 'navbar.php'; ?>
	
	<div class="container anti-navbar">
		<div class="row">
			<div class="col">
				<h2>Produk</h2>
			</div>
			<div class="col text-end">
				<a href="tambah_produk.php" class="btn btn-primary">Tambah Produk</a>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nama Produk</th>
						<th>Jenis Produk</th>
						<th>Satuan Produk</th>
						<th>Stok Produk</th>
						<th>Harga Produk</th>
						<th>Foto Produk</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					<?php foreach ($produk as $data_produk): ?>
						<tr>
							<td><?= $i++; ?></td>
							<td><?= $data_produk['nama_produk']; ?></td>
							<td><?= $data_produk['jenis_produk']; ?></td>
							<td><?= $data_produk['satuan_produk']; ?></td>
							<td><?= $data_produk['stok_produk']; ?></td>
							<td>Rp. <?= str_replace(",", ".", number_format($data_produk['harga_produk'])); ?></td>
							<td>
								<img width="100" src="img/<?= $data_produk['foto_produk']; ?>" alt="foto">
							</td>
							<td>
								<a href="ubah_produk.php?id_produk=<?= $data_produk['id_produk']; ?>" class="btn m-1 btn-success">Ubah</a>
								<a href="hapus_produk.php?id_produk=<?= $data_produk['id_produk']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus Produk <?= $data_produk['nama_produk']; ?>?')" class="btn m-1 btn-danger">Hapus</a>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php include_once 'script.php'; ?>
</body>
</html>