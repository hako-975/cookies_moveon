<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$penjualan = mysqli_query($koneksi, "SELECT * FROM penjualan INNER JOIN produk ON penjualan.id_produk = produk.id_produk WHERE DATE(tanggal_penjualan) = CURDATE() ORDER BY tanggal_penjualan DESC, id_penjualan DESC");

	$total_penjualan_hari_ini = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT *, count(id_penjualan) as total_penjualan FROM penjualan INNER JOIN produk ON penjualan.id_produk = produk.id_produk WHERE DATE(tanggal_penjualan) = CURDATE()"))['total_penjualan'];

	$total_penjualan_belum_hari_ini = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT *, count(id_penjualan) as total_penjualan FROM penjualan INNER JOIN produk ON penjualan.id_produk = produk.id_produk WHERE DATE(tanggal_penjualan) = CURDATE() AND status_penjualan = 'Belum'"))['total_penjualan'];
	
	$total_penjualan_selesai_hari_ini = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT *, count(id_penjualan) as total_penjualan FROM penjualan INNER JOIN produk ON penjualan.id_produk = produk.id_produk WHERE DATE(tanggal_penjualan) = CURDATE() AND status_penjualan = 'Selesai'"))['total_penjualan'];

	$omset_hari_ini = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT *, sum(total_harga) as omset_hari_ini FROM penjualan INNER JOIN produk ON penjualan.id_produk = produk.id_produk WHERE DATE(tanggal_penjualan) = CURDATE()"))['omset_hari_ini'];
?>


<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<?php include_once 'head.php'; ?>
</head>
<body>

	<?php include_once 'navbar.php'; ?>

	<div class="container anti-navbar">
		<div class="row my-3">
			<div class="col-lg-3">
				<div class="card">
				  <div class="card-body">
				    <h5 class="card-title">Penjualan Hari Ini:</h5>
				    <h5><?= str_replace(",", ".", number_format($total_penjualan_hari_ini)); ?></h5>
				  </div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="card">
				  <div class="card-body">
				    <h5 class="card-title">Belum Hari Ini:</h5>
				    <h5><?= str_replace(",", ".", number_format($total_penjualan_belum_hari_ini)); ?></h5>
				  </div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="card">
				  <div class="card-body">
				    <h5 class="card-title">Selesai Hari Ini:</h5>
				    <h5><?= str_replace(",", ".", number_format($total_penjualan_selesai_hari_ini)); ?></h5>
				  </div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="card">
				  <div class="card-body">
				    <h5 class="card-title">Omset Hari Ini:</h5>
				    <h5><?= str_replace(",", ".", number_format($omset_hari_ini)); ?></h5>
				  </div>
				</div>
			</div>
		</div>
		<div class="row my-3">
			<div class="col">
				<h2>Penjualan Hari Ini:</h2>
			</div>
			<div class="col text-end">
				<a href="tambah_penjualan.php" class="btn btn-primary">Tambah Penjualan</a>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nama Produk</th>
						<th>Stok Terjual</th>
						<th>Tanggal Penjualan</th>
						<th>Total Harga</th>
						<th>Nama Pembeli</th>
						<th>Alamat Pembeli</th>
						<th>Status Penjualan</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					<?php foreach ($penjualan as $data_penjualan): ?>
						<tr>
							<td><?= $i++; ?></td>
							<td><?= $data_penjualan['nama_produk']; ?></td>
							<td><?= $data_penjualan['stok_terjual']; ?></td>
							<td><?= date("d-m-Y, H:i", strtotime($data_penjualan['tanggal_penjualan'])); ?></td>
							<td>Rp. <?= str_replace(",", ".", number_format($data_penjualan['total_harga'])); ?></td>
							<td><?= $data_penjualan['nama_pembeli']; ?></td>
							<td><?= $data_penjualan['alamat_pembeli']; ?></td>
							<td>
								<?php if ($data_penjualan['status_penjualan'] == 'Belum'): ?>
									<a onclick="return confirm('Apakah Anda yakin ingin mengubah status penjualan <?= $data_penjualan['nama_produk']; ?>?')" class="btn btn-danger btn-sm" href="ubah_status.php?id_penjualan=<?= $data_penjualan['id_penjualan']; ?>"><?= $data_penjualan['status_penjualan']; ?></a>
								<?php else: ?>
									<span class="btn btn-info text-white btn-sm"><?= $data_penjualan['status_penjualan']; ?></span>
								<?php endif ?>
							</td>
							<td>
								<a href="ubah_penjualan.php?id_penjualan=<?= $data_penjualan['id_penjualan']; ?>" class="btn m-1 btn-success">Ubah</a>
								<a href="hapus_penjualan.php?id_penjualan=<?= $data_penjualan['id_penjualan']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus penjualan <?= $data_penjualan['nama_produk']; ?>?')" class="btn m-1 btn-danger">Hapus</a>
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