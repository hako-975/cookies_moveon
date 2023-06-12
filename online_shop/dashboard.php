<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$penjualan = mysqli_query($koneksi, "SELECT * FROM penjualan INNER JOIN produk ON penjualan.id_produk = produk.id_produk ORDER BY tanggal DESC");
?>


<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<?php include_once 'head.php'; ?>
</head>
<body>

	<nav class="navbar navbar-expand-lg bg-danger navbar-dark">
	  <div class="container">
	    <a class="navbar-brand" href="dashboard.php">Dashboard</a>
	    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
	      <div class="navbar-nav">
	        <a class="nav-link" href="penjualan.php">Penjualan</a>
	        <a class="nav-link" href="produk.php">Produk</a>
	      </div>
	    </div>
	  </div>
	</nav>

	<!-- about -->
	<section class="about">
		<div class="container">
			<div class="row">
				<div class="col">
					<h2>Penjualan</h2>
				</div>
				<div class="col text-end">
					<a href="tambah_penjualan.php" class="btn btn-primary">Tambah Penjualan</a>
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
						<?php foreach ($penjualan as $data_penjualan): ?>
							<tr>
								<td><?= $i++; ?></td>
								<td><?= $data_penjualan['nama_produk']; ?></td>
								<td><?= $data_penjualan['jenis_produk']; ?></td>
								<td><?= $data_penjualan['jumlah_stok']; ?></td>
								<td><?= $data_penjualan['harga']; ?></td>
								<td>
									<img width="100" src="img/<?= $data_penjualan['foto']; ?>" alt="foto">
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
	</section>

</body>
</html>