<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Home</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/Login-Form-Basic-icons.css">
	<link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
	<nav class="navbar navbar-dark navbar-expand-md fixed-top bg-dark">
		<div class="container"><a class="navbar-brand" href="#">Inventory-OL</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
			<div class="collapse navbar-collapse" id="navcol-1">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item"><a class="nav-link" href="#">Home</a></li>
					<li class="nav-item"><a class="nav-link active" href="#">Login</a></li>
					<li class="nav-item"><a class="nav-link" href="#">Register</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container py-5">
		<main>
			<section class="position-relative py-4 py-xl-5">
				<div class="row d-flex justify-content-center">
					<div class="col-md-6 col-xl-4">
						<div class="card">
							<div class="card-body text-center d-flex flex-column align-items-center">
								<div class="bs-icon-xl bs-icon-circle bs-icon-primary bs-icon my-4"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-person">
										<path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"></path>
									</svg></div>
								<form method="post" id="formLogin">
									<div class="mb-3 form-group">
										<input class="form-control form-user-input" type="email" name="email" placeholder="Email">
									</div>
									<div class="mb-3 form-group">
										<input class="form-control form-user-input" type="password" name="password" placeholder="Password">
									</div>
									<div class="mb-3 form-group">
										<button class="btn btn-primary d-block w-100" type="submit">Log in</button>
									</div>
									<p class="text-muted">Forgot your password?</p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url('assets/xtreme_admin_lite/') ?>assets/libs/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript">
		$("#formLogin").on('submit', function(e) {
			e.preventDefault();
			checkLogin();
		});

		function checkLogin() {
			var link = "http://localhost/backend_inventory/user/check_login/";
			var dataForm = {};
			var allInput = $('.form-user-input');
			$.each(allInput, function(i, val) {
				dataForm[val['name']] = val['value'];
			});
			$.ajax(link, {
				type: 'POST',
				data: dataForm,
				success: function(data, status, xhr) {
					var data_str = JSON.parse(data);
					alert(data_str['pesan']);
					if (data_str['sukses'] == 'Ya') {
						setSession(data_str['user']);
					}
				},
				error: function(jqXHR, textStatus, errorMsg) {
					alert('Error : ' + errorMsg);
				}
			});
		}

		function setSession(user) {
			var link = "http://localhost/client_inventory/index.php/login/setSession";
			var dataForm = {};
			dataForm['id_user'] = user['id_admin'];
			dataForm['email'] = user['email'];
			dataForm['level'] = user['level'];
			dataForm['nama'] = user['nama'];
			$.ajax(link, {
				type: 'POST',
				data: dataForm,
				success: function(data, status, xhr) {
					location.replace('http://localhost/client_inventory/index.php/home');
				},
				error: function(jqXHR, textStatus, errorMsg) {
					alert('Error : ' + errorMsg);
				}
			});
		}
	</script>
</body>

</html>
