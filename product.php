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
			<div class="row">
				<?php foreach ($produk as $data_produk): ?>
					<div class="col-lg-4">
						<div class="my-3 border rounded p-5 text-center">
							<div class="icon">
								<img src="img/<?= $data_produk['foto_produk']; ?>" style="width: 100%; height: 100%; border-radius: 50%;">
							</div>
							<h4><?= $data_produk['nama_produk']; ?></h4>
							<p>Rp. <?= str_replace(",", ".", number_format($data_produk['harga_produk'])); ?>,-</p>
							<p><?= $data_produk['stok_produk'] . " " . $data_produk['satuan_produk']; ?></p>
							<?php
								$isi_pesan = "Halo kak, aku mau dong " . $data_produk['nama_produk'] .  " Rp. ". str_replace(",", ".", number_format($data_produk['harga_produk'])) . "%0AJumlah: 1 " . $data_produk['satuan_produk'] ." %0ANama:%0AAlamat:";
							?>
							<a class="btn btn-success p-3" target="_blank" href="https://api.whatsapp.com/send?text=<?= $isi_pesan; ?>&phone=6285770192122"><h4 class="p-0 m-0"><i class="fab fa-whatsapp"></i> Pesan Sekarang!</h4></a>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>

	</section>

	<!-- footer -->
	<?php include_once 'footer.php'; ?>

</body>
</html>