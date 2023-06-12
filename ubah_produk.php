<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_produk = $_GET['id_produk'];
	$produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
	$data_produk = mysqli_fetch_assoc($produk);

	if (isset($_POST['btnUbah'])) {
		$nama_produk = htmlspecialchars($_POST['nama_produk']);
		$jenis_produk = htmlspecialchars($_POST['jenis_produk']);
		$satuan_produk = htmlspecialchars($_POST['satuan_produk']);
		$stok_produk = htmlspecialchars($_POST['stok_produk']);
		$harga_produk = htmlspecialchars($_POST['harga_produk']);
		
		$foto_produk = $_POST['foto_produk_old'];

		$foto_produk_new = $_FILES['foto_produk']['name'];
        if ($foto_produk_new != '') {
            $acc_extension = array('png','jpg', 'jpeg', 'gif', 'pdf');
            $extension = explode('.', $foto_produk_new);
            $extension_lower = strtolower(end($extension));
            $size = $_FILES['foto_produk']['size'];
            $file_tmp = $_FILES['foto_produk']['tmp_name'];   
            
            if(!in_array($extension_lower, $acc_extension))
            {
                echo "
                    <script>
                        alert('Foto yang Anda upload bukan gambar!')
						window.history.back()
                    </script>
                ";
                exit;
            }

			unlink('img/'.$foto_produk);

            $foto_produk = uniqid() . $foto_produk_new;
            move_uploaded_file($file_tmp, 'img/'. $foto_produk);
        }

		$ubahProduk = mysqli_query($koneksi, "UPDATE produk SET nama_produk = '$nama_produk', jenis_produk = '$jenis_produk', satuan_produk = '$satuan_produk', stok_produk = '$stok_produk', harga_produk = '$harga_produk', foto_produk = '$foto_produk' WHERE id_produk = '$id_produk'");

		if ($ubahProduk) {
	        echo "
	            <script>
	                alert('Produk berhasil diubah!')
	                window.location.href='produk.php'
	            </script>
	        ";
	        exit;
	    } else {
	        echo "
	            <script>
	                alert('Produk gagal diubah!')
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
	<title>Ubah Produk</title>
	<?php include_once 'head.php'; ?>
</head>
<body>

	<?php include_once 'navbar.php'; ?>

	<div class="container anti-navbar">
		<div class="row">
			<div class="col-lg-6">
				<h2>Ubah Produk</h2>
				<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="foto_produk_old" value="<?= $data_produk['foto_produk']; ?>">
					<div class="mb-3">
					    <label for="nama_produk" class="form-label">Nama Produk</label>
					    <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?= $data_produk['nama_produk']; ?>" required>
					</div>
					<div class="mb-3">
					    <label for="jenis_produk" class="form-label">Jenis Produk</label>
					    <select class="form-select" id="jenis_produk" name="jenis_produk" required>
						    <option value="<?= $data_produk['jenis_produk']; ?>"><?= $data_produk['jenis_produk']; ?></option>
						    <?php if ($data_produk['jenis_produk'] == 'Kue'): ?>
						        <option value="Pizza">Pizza</option>
						        <option value="Roti">Roti</option>
						    <?php elseif ($data_produk['jenis_produk'] == 'Roti'): ?>
						        <option value="Kue">Kue</option>
						        <option value="Pizza">Pizza</option>
						    <?php elseif ($data_produk['jenis_produk'] == 'Pizza'): ?>
						        <option value="Kue">Kue</option>
						        <option value="Roti">Roti</option>
						    <?php endif ?>
						</select>
					</div>
					<div class="mb-3">
					    <label for="satuan_produk" class="form-label">Satuan Produk</label>
					    <select class="form-select" id="satuan_produk" name="satuan_produk" required>
					    	<option value="<?= $data_produk['satuan_produk']; ?>"><?= $data_produk['satuan_produk']; ?></option>
					    	<?php if ($data_produk['satuan_produk'] == 'Pcs'): ?>
						    	<option value="Toples">Toples</option>
						    <?php else: ?>
						    	<option value="Pcs">Pcs</option>
					    	<?php endif ?>
					    </select>
					</div>
					<div class="mb-3">
					    <label for="stok_produk" class="form-label">Stok Produk</label>
					    <input type="number" class="form-control" id="stok_produk" name="stok_produk" value="<?= $data_produk['stok_produk']; ?>" required>
					</div>
					<div class="mb-3">
					    <label for="harga_produk" class="form-label">Harga Produk</label>
					    <input type="number" class="form-control" id="harga_produk" name="harga_produk" value="<?= $data_produk['harga_produk']; ?>" required>
					</div>
					<div class="mb-3">
					    <label for="foto_produk" class="form-label">Foto Produk (Upload foto jika ingin mengubah foto)</label>
					    <input type="file" class="form-control" id="foto_produk" name="foto_produk">
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