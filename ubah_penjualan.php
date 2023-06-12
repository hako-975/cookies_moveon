<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_penjualan = $_GET['id_penjualan'];
	$data_penjualan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM penjualan INNER JOIN produk ON penjualan.id_produk = produk.id_produk WHERE penjualan.id_penjualan = '$id_penjualan'"));
	$stok_terjual_old = $data_penjualan['stok_terjual'];

	$produk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY nama_produk ASC");

	if (isset($_POST['btnUbah'])) {
		$id_produk = htmlspecialchars($_POST['id_produk']);
		$stok_terjual = htmlspecialchars($_POST['stok_terjual']);
		$tanggal_penjualan = htmlspecialchars($_POST['tanggal_penjualan']);
		$nama_pembeli = htmlspecialchars($_POST['nama_pembeli']);
		$alamat_pembeli = htmlspecialchars($_POST['alamat_pembeli']);
		$status_penjualan = htmlspecialchars($_POST['status_penjualan']);
	
		$update_stok_old = mysqli_query($koneksi, "UPDATE produk SET stok_produk = stok_produk + $stok_terjual_old WHERE id_produk = '$id_produk'");

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

		$total_harga = $data_produk['harga_produk'] * $stok_terjual;

		$ubahPenjualan = mysqli_query($koneksi, "UPDATE penjualan SET id_produk = '$id_produk', stok_terjual = '$stok_terjual', tanggal_penjualan = '$tanggal_penjualan', total_harga = '$total_harga', nama_pembeli = '$nama_pembeli', alamat_pembeli = '$alamat_pembeli', status_penjualan = '$status_penjualan' WHERE id_penjualan = '$id_penjualan'");

		if ($ubahPenjualan) {
			$update_stok = mysqli_query($koneksi, "UPDATE produk SET stok_produk = stok_produk - $stok_terjual WHERE id_produk = '$id_produk'");
			
	        echo "
	            <script>
	                alert('Penjualan berhasil diubah!')
	                window.location.href='penjualan.php'
	            </script>
	        ";
	        exit;
	    } else {
	        echo "
	            <script>
	                alert('Penjualan gagal diubah!')
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
	<title>Ubah Penjualan - <?= $data_penjualan['nama_produk']; ?></title>
	<?php include_once 'head.php'; ?>
</head>
<body>

	<?php include_once 'navbar.php'; ?>

	<div class="container anti-navbar">
		<div class="row">
			<div class="col-lg-6">
				<h2>Ubah Penjualan - <?= $data_penjualan['nama_produk']; ?></h2>
				<form method="post">
					<div class="mb-3">
					    <label for="id_produk" class="form-label">Nama Produk</label>
					    <select class="form-select" id="id_produk" name="id_produk" required>
						    <option value="<?= $data_penjualan['id_produk']; ?>"><?= $data_penjualan['nama_produk']; ?> - Rp. <?= str_replace(",", ".", number_format($data_penjualan['harga_produk'])); ?> (tersisa <?= $data_penjualan['stok_produk']; ?>)</option>
					    	<?php foreach ($produk as $data_produk): ?>
					    		<?php if ($data_produk['id_produk'] != $data_penjualan['id_produk']): ?>
							    	<option value="<?= $data_produk['id_produk']; ?>"><?= $data_produk['nama_produk']; ?> - Rp. <?= str_replace(",", ".", number_format($data_produk['harga_produk'])); ?> (tersisa <?= $data_produk['stok_produk']; ?>)</option>
					    		<?php endif ?>
					    	<?php endforeach ?>
					    </select>
					</div>
					<div class="mb-3">
						<label for="stok_terjual" class="form-label">Stok Terjual</label>
					    <input type="number" class="form-control" id="stok_terjual" name="stok_terjual" value="<?= $data_penjualan['stok_terjual']; ?>" required>
					</div>
					<div class="mb-3">
					    <label for="tanggal_penjualan" class="form-label">Tanggal Penjualan</label>
					    <input type="datetime-local" value="<?= $data_penjualan['tanggal_penjualan']; ?>" class="form-control" id="tanggal_penjualan" name="tanggal_penjualan" required>
					</div>
					<div class="mb-3">
					    <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
					    <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" value="<?= $data_penjualan['nama_pembeli']; ?>" required>
					</div>
					<div class="mb-3">
					    <label for="alamat_pembeli" class="form-label">Alamat Pembeli</label>
					    <textarea class="form-control" id="alamat_pembeli" name="alamat_pembeli" required><?= $data_penjualan['alamat_pembeli']; ?></textarea>
					</div>
					<div class="mb-3">
					    <label for="status_penjualan" class="form-label">Status Penjualan</label>
					    <select class="form-select" id="status_penjualan" name="status_penjualan" required>
						    <option value="Selesai">Selesai</option>
						    <option value="Belum">Belum</option>
					    </select>
					</div>
					<div class="mb-3 text-end">
						<button type="submit" class="btn btn-primary" name="btnUbah">Ubah</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</body>
</html>