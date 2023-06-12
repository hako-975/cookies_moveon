<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$id_penjualan = $_GET['id_penjualan'];
	$ubah_status_penjualan = mysqli_query($koneksi, "UPDATE penjualan SET status_penjualan = 'Selesai' WHERE id_penjualan = '$id_penjualan'");

	if ($ubah_status_penjualan) {
		echo "
			<script>
				alert('Status penjualan berhasil diubah!')
				window.location.href='penjualan.php'
			</script>
		";
		exit;
	} else {
		echo "
			<script>
				alert('Status penjualan gagal diubah!')
				window.history.back()
			</script>
		";
		exit;
	}
?>