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
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nama Produk</th>
						<th>Jenis Produk</th>
						<th>Jumlah Stok</th>
						<th>Harga</th>
						<th>Foto</th>
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
							<td><?= $data_produk['jumlah_stok']; ?></td>
							<td><?= number_format($data_produk['harga']); ?></td>
							<td>
								<img width="100" src="img/<?= $data_produk['foto']; ?>" alt="foto">
							</td>
							<td>
								<a href="" class="btn btn-success">Ubah</a>
								<a href="" class="btn btn-danger">Hapus</a>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>

</body>
</html>