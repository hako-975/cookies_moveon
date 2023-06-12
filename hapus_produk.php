<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$id_produk = $_GET['id_produk'];
	$produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
	$data_produk = mysqli_fetch_assoc($produk);
	$foto_produk = $data_produk['foto_produk'];

	$hapus_produk = mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk = '$id_produk'");

	if ($hapus_produk) {
		unlink('img/'.$foto_produk);
		echo "
			<script>
				alert('Produk berhasil dihapus!')
				window.location.href='produk.php'
			</script>
		";
		exit;
	} else {
		echo "
			<script>
				alert('Produk gagal dihapus!')
				window.history.back()
			</script>
		";
		exit;
	}
?>