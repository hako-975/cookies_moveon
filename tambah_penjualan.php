<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$produk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY nama_produk ASC");

	if (isset($_POST['btnTambah'])) {
		$id_produk = htmlspecialchars($_POST['id_produk']);
		$stok_terjual = htmlspecialchars($_POST['stok_terjual']);
		$tanggal_penjualan = htmlspecialchars($_POST['tanggal_penjualan']);
		$nama_pembeli = htmlspecialchars($_POST['nama_pembeli']);
		$alamat_pembeli = htmlspecialchars($_POST['alamat_pembeli']);

		$produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
		$data_produk = mysqli_fetch_assoc($produk);
		if ($stok_terjual > $data_produk['stok_produk']) {
			echo "
                <script>
                    alert('Stok kurang!')
                    window.history.back()
                </script>
            ";
            exit;
		}

		$tambahPenjualan = mysqli_query($koneksi, "INSERT INTO penjualan VALUES ('', '$id_produk', '$stok_terjual', '$tanggal_penjualan', '$nama_pembeli', '$alamat_pembeli')");

		if ($tambahPenjualan) {
			$update_stok = mysqli_query($koneksi, "UPDATE produk SET stok_produk = stok_produk - $stok_terjual WHERE id_produk = '$id_produk'");
	        echo "
	            <script>
	                alert('Penjualan berhasil ditambahkan!')
	                window.location.href='penjualan.php'
	            </script>
	        ";
	        exit;
	    } else {
	        echo "
	            <script>
	                alert('Penjualan gagal ditambahkan!')
	                window.history.back()
	            </script>
	        ";
	        exit;
	    }
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Tambah Penjualan</title>
	<?php include_once 'head.php'; ?>
</head>
<body>

	<?php include_once 'navbar.php'; ?>

	<div class="container anti-navbar">
		<div class="row">
			<div class="col-lg-6">
				<h2>Tambah Penjualan</h2>
				<form method="post">
					<div class="mb-3">
					    <label for="id_produk" class="form-label">Nama Produk</label>
					    <select class="form-select" id="id_produk" name="id_produk" required>
					    	<?php foreach ($produk as $data_produk): ?>
						    	<option value="<?= $data_produk['id_produk']; ?>"><?= $data_produk['nama_produk']; ?> - Rp. <?= str_replace(",", ".", number_format($data_produk['harga_produk'])); ?> (tersisa <?= $data_produk['stok_produk']; ?>)</option>
					    	<?php endforeach ?>
					    </select>
					</div>
					<div class="mb-3">
						<label for="stok_terjual" class="form-label">Stok Terjual</label>
					    <input type="number" class="form-control" id="stok_terjual" name="stok_terjual" required>
					</div>
					<div class="mb-3">
					    <label for="tanggal_penjualan" class="form-label">Tanggal Penjualan</label>
					    <input type="datetime-local" value="<?= date("Y-m-d H:i"); ?>" class="form-control" id="tanggal_penjualan" name="tanggal_penjualan" required>
					</div>
					<div class="mb-3">
					    <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
					    <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" required>
					</div>
					<div class="mb-3">
					    <label for="alamat_pembeli" class="form-label">Alamat Pembeli</label>
					    <textarea class="form-control" id="alamat_pembeli" name="alamat_pembeli" required></textarea>
					</div>
					<div class="mb-3 text-end">
						<button type="submit" class="btn btn-primary" name="btnTambah">Tambah</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</body>
</html>