<?php 
	require_once 'koneksi.php';

	$produk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY nama_produk ASC");
?>
<!DOCTYPE html>
<html>
<head>
	<?php include_once 'head.php'; ?>
	<title>PRODUCT</title>
</head>
<body>

	<!-- header -->
	<?php include_once 'header.php'; ?>

	<!--services-->
	<section class="services">
		<div class="container">
			<h3>OUR PRODUCT</h3>
			<div class="box">
				<?php foreach ($produk as $data_produk): ?>
					<div class="col-4">
						<div class="icon"><img src="img/<?= $data_produk['foto']; ?>" style="width: 100%; height: 100%; border-radius: 50%;"></div>
						<h4><?= $data_produk['nama_produk']; ?></h4>
						<p>Rp. <?= number_format($data_produk['harga']); ?>,-</p>
						<p><?= $data_produk['jumlah_stok']; ?> Pcs</p>
					</div>
				<?php endforeach ?>
			</div>
		</div>

	</section>

	<!-- footer -->
	<?php include_once 'footer.php'; ?>

</body>
</html>