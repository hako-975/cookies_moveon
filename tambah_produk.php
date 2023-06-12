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
		$satuan_produk = htmlspecialchars($_POST['satuan_produk']);
		$stok_produk = htmlspecialchars($_POST['stok_produk']);
		$harga_produk = htmlspecialchars($_POST['harga_produk']);
		
		$foto_produk = $_FILES['foto_produk']['name'];
		if ($foto_produk != '') {
	        $acc_extension = array('png','jpg', 'jpeg', 'gif');
	        $extension = explode('.', $foto_produk);
	        $extension_lower = strtolower(end($extension));
	        $size = $_FILES['foto_produk']['size'];
	        $file_tmp = $_FILES['foto_produk']['tmp_name'];   
	        
	        if(!in_array($extension_lower, $acc_extension))
	        {
	            echo "
	                <script>
	                    alert('Foto yang Anda upload tidak sesuai format!')
	                    window.history.back()
	                </script>
	            ";
	            exit;
	        }

	        $foto_produk = uniqid() .'-'. $foto_produk;
	        move_uploaded_file($file_tmp, 'img/'. $foto_produk);
	    }
	    else
	    {
	        $foto_produk = '';
	    }

		$tambahProduk = mysqli_query($koneksi, "INSERT INTO produk VALUES ('', '$nama_produk', '$jenis_produk', '$satuan_produk', '$stok_produk', '$harga_produk', '$foto_produk')");

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

	<div class="container anti-navbar">
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
					    <select class="form-select" id="jenis_produk" name="jenis_produk" required>
					    	<option value="Kue">Kue</option>
					    	<option value="Pizza">Pizza</option>
					    	<option value="Roti">Roti</option>
					    </select>
					</div>
					<div class="mb-3">
					    <label for="satuan_produk" class="form-label">Satuan Produk</label>
					    <select class="form-select" id="satuan_produk" name="satuan_produk" required>
					    	<option value="Pcs">Pcs</option>
					    	<option value="Toples">Toples</option>
					    </select>
					</div>
					<div class="mb-3">
					    <label for="stok_produk" class="form-label">Stok Produk</label>
					    <input type="number" class="form-control" id="stok_produk" name="stok_produk" required>
					</div>
					<div class="mb-3">
					    <label for="harga_produk" class="form-label">Harga Produk</label>
					    <input type="number" class="form-control" id="harga_produk" name="harga_produk" required>
					</div>
					<div class="mb-3">
					    <label for="foto_produk" class="form-label">Foto Produk</label>
					    <input type="file" class="form-control" id="foto_produk" name="foto_produk" required>
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