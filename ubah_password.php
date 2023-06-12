<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	if (isset($_POST['btnUbah'])) {
        $password_lama = $_POST['password_lama'];
        $password_baru = $_POST['password_baru'];
        $verifikasi_password_baru = $_POST['verifikasi_password_baru'];

        // check password with verify
        if ($password_baru != $verifikasi_password_baru) {
            echo "
                <script>
                    alert('Password baru harus sama dengan verifikasi password baru!')
                    window.history.back()
                </script>
            ";
            exit;
        }

        // check password lama
        if (!password_verify($password_lama, $data_user['password'])) {
            echo "
                <script>
                    alert('Password lama tidak sesuai!')
                    window.history.back()
                </script>
            ";
            exit;
        }

        $password_baru = password_hash($password_baru, PASSWORD_DEFAULT);

        $ubah_password = mysqli_query($koneksi, "UPDATE user SET password = '$password_baru' WHERE id_user = '$id_user'");

        if ($ubah_password) {
            echo "
                <script>
                    alert('Password berhasil diubah!')
                    window.location.href='profile.php'
                </script>
            ";
            exit;
        } else {
            echo "
                <script>
                    alert('Password gagal diubah!')
                    window.history.back()
                </script>
            ";
            exit;
        }
    }

?>

<html>
<head>
	<?php include_once 'head.php'; ?>
	<title>Ubah Password - <?= $data_user['username']; ?></title>
</head>
<body>
	<?php include_once 'navbar.php'; ?>
	<div class="container anti-navbar">
		<div class="row">
			<div class="col-lg-4">
				<h2>Ubah Password - <?= $data_user['username']; ?></h2>
		        <form method="post">
					<div class="mb-3">
			            <label class="form-label" for="password_lama">Password Lama</label>
		    	        <input class="form-control" type="password" id="password_lama" name="password_lama" required>
					</div>
					<div class="mb-3">
			            <label class="form-label" for="password_baru">Password Baru</label>
		    	        <input class="form-control" type="password" id="password_baru" name="password_baru" required>
					</div>
					<div class="mb-3">
			            <label class="form-label" for="verifikasi_password_baru">Verifikasi Password Baru</label>
		    	        <input class="form-control" type="password" id="verifikasi_password_baru" name="verifikasi_password_baru" required>
					</div>
					<div class="mb-3 text-end">
			            <button type="submit" class="btn btn-primary" name="btnUbah">Ubah</button>
					</div>
		        </form>
			</div>
		</div>
	</div>
	<?php include_once 'navbar.php'; ?>

	<script src="script.js"></script>
</body>
</html>