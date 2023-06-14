<?php 
	require_once 'koneksi.php';

	if (isset($_SESSION['id_user'])) {
        echo "
            <script>
                window.location='dashboard.php'
            </script>
        ";
        exit;
    }

    if (isset($_POST['btnLogin'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query_login = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
        
        if ($data_user = mysqli_fetch_assoc($query_login)) {
            if (password_verify($password, $data_user['password'])) {
                $_SESSION['id_user'] = $data_user['id_user'];
                header("Location: dashboard.php");
                exit;
            } else {
                echo "
                    <script>
                        alert('Gagal Username atau Password salah!')
                        window.history.back()
                    </script>
                ";
                exit;
            }
        } else {
            echo "
                <script>
                    alert('Gagal Username atau Password salah!')
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
	<title>Login</title>
	<?php include_once 'head.php'; ?>
</head>
<body>

	<!-- about -->
	<section class="about">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-4 p-3 border rounded">
					<img src="img/Logo.jpeg" class="d-block mx-auto rounded-circle" width="200" alt="gambar">
					<h2 class="text-center">Form Login</h2>
					<h2 class="text-center">Cookies MoveOn</h2>
					<form method="post">
						<div class="mb-3">
						    <label for="username" class="form-label">Username</label>
						    <input type="text" class="form-control" id="username" name="username" required>
						</div>
						<div class="mb-3">
						    <label for="password" class="form-label">Password</label>
						    <input type="password" class="form-control" id="password" name="password" required>
						</div>
						<div class="mb-3 text-end">
							<button type="submit" class="btn btn-primary" name="btnLogin">Login</button>
						</div>
						<a href="index.php" class="d-block text-center">Landing Page</a>
					</form>
				</div>
			</div>
		</div>
	</section>

</body>
</html>