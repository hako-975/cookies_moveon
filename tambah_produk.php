<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$produk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY nama_produk ASC");

	if (isset($_POST['btnTambah'])) {
		$nama_produk = htmlspecialchars($_POST['nama_produk']);
		$jenis_produk = htmlspecialchars($_POST['jenis_produk']);
		$jumlah_stok = htmlspecialchars($_POST['jumlah_stok']);
		$harga = htmlspecialchars($_POST['harga']);
		
		$foto = $_FILES['foto']['name'];
		if ($foto != '') {
	        $acc_extension = array('png','jpg', 'jpeg', 'gif');
	        $extension = explode('.', $foto);
	        $extension_lower = strtolower(end($extension));
	        $size = $_FILES['foto']['size'];
	        $file_tmp = $_FILES['foto']['tmp_name'];   
	        
	        if(!in_array($extension_lower, $acc_extension))
	        {
	            echo "
	                <script>
	                    alert('File yang Anda upload tidak sesuai format!')
	                    window.history.back()
	                </script>
	            ";
	            exit;
	        }

	        $foto = uniqid() .'-'. $foto;
	        move_uploaded_file($file_tmp, 'img/'. $foto);
	    }
	    else
	    {
	        $foto = '';
	    }

		$tambahProduk = mysqli_query($koneksi, "INSERT INTO produk VALUES ('', '$nama_produk', '$jenis_produk', '$jumlah_stok', '$harga', '$foto')");

		if ($tambahProduk) {
	        echo "
	            <script>
	                alert('Produk berhasil ditambahkan!')
	                window.location.href='produk.php'
	            </script>
	        ";
	        exit;
	    } else {
	        echo "
	            <script>
	                alert('Produk gagal ditambahkan!')
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
	<title>Tambah Produk</title>
	<?php include_once 'head.php'; ?>
</head>
<body>

	<?php include_once 'navbar.php'; ?>

	<!-- about -->
	<section class="about">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<h2>Tambah Produk</h2>
					<form method="post" enctype="multipart/form-data">
						<div class="mb-3">
						    <label for="nama_produk" class="form-label">Nama Produk</label>
						    <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
						</div>
						<div class="mb-3">
						    <label for="jenis_produk" class="form-label">Jenis Produk</label>
						    <input type="text" class="form-control" id="jenis_produk" name="jenis_produk" required>
						</div>
						<div class="mb-3">
						    <label for="jumlah_stok" class="form-label">Jumlah Stok</label>
						    <input type="number" class="form-control" id="jumlah_stok" name="jumlah_stok" required>
						</div>
						<div class="mb-3">
						    <label for="harga" class="form-label">Harga</label>
						    <input type="number" class="form-control" id="harga" name="harga" required>
						</div>
						<div class="mb-3">
						    <label for="foto" class="form-label">Foto</label>
						    <input type="file" class="form-control" id="foto" name="foto" required>
						</div>
						<div class="mb-3 text-end">
							<button type="submit" class="btn btn-primary" name="btnTambah">Tambah</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>

</body>
</html>