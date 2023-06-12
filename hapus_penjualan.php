<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$id_penjualan = $_GET['id_penjualan'];
	$penjualan = mysqli_query($koneksi, "SELECT * FROM penjualan WHERE id_penjualan = '$id_penjualan'");
	$data_penjualan = mysqli_fetch_assoc($penjualan);
	
	$id_produk = $data_penjualan['id_produk'];
	$stok_terjual = $data_penjualan['stok_terjual'];

	$update_stok = mysqli_query($koneksi, "UPDATE produk SET stok_produk = stok_produk + $stok_terjual WHERE id_produk = '$id_produk'");

	$hapus_penjualan = mysqli_query($koneksi, "DELETE FROM penjualan WHERE id_penjualan = '$id_penjualan'");

	if ($hapus_penjualan) {
		echo "
			<script>
				alert('Penjualan berhasil dihapus!')
				window.location.href='penjualan.php'
			</script>
		";
		exit;
	} else {
		echo "
			<script>
				alert('Penjualan gagal dihapus!')
				window.history.back()
			</script>
		";
		exit;
	}
?>