<!DOCTYPE html>
<html lang="hu-HU">
	<head>
		<title>Rendelés - NetPizza</title>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
		<meta name="theme-color" content="#dc3545">
		<meta name="author" content="Lovász Bence">

		<link rel="icon" type="image/x-icon" href="images/favicon.png">
		<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,700">
		<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/maintance.css">
		<link rel="stylesheet" type="text/css" href="css/notify.css">

		<link rel="stylesheet" type="text/css" href="css/order.css">
    </head>

	<body class="bg-dark">
		<?php
			require_once "misc/connection.php3";

			if ($mysqli->connect_errno)
				die("<div class=\"maintance\">Az oldal karbantartás alatt van</div>");

			$result = $mysqli->query("SELECT * FROM sitedatas WHERE id=1");
			if ($result)
				while ($rows = $result->fetch_assoc())
					if ($rows["maintance"] == 1)
						die("<div class=\"maintance\">Az oldal karbantartás alatt van</div>");

			$mysqli->close();

			if (!isset($_COOKIE["json_userdata"]))
				header("Location: index.php");
		?>

		<nav class="navbar navbar-default navbar-fixed-top bg-danger" style="border: none">
			<div class="container">
				<h4 class="text-light">NetPizza</h4>
			</div>
		</nav>

		<div class="container bg-white rounded p-4">
			<div class="col-md-9">
				<h3 class="mt-2 ml-2">Kínálatunk</h3>

					<div class="panel-group" id="accordion">
						<?php
							$pizzadatas = json_decode(file_get_contents("files/menulist.json"));

							usort($pizzadatas, function ($a, $b) {
								return $b[3] <=> $a[3];
							});

							foreach ($pizzadatas as $key => $value) {
								$name = $value[3] ? $value[0] . ' <span class="badge badge-pill bg-warning text-dark">AKCIÓ</span>' : $value[0];
								$price = $value[3] ? $value[3] : $value[1];
								$classes = $value[3] ? "panel panel-default mb-4 border-warning" : "panel panel-default mb-4";

								echo '<div class="' . $classes . '">
										<div class="panel-heading bg-light">
											<h4 class="panel-title">
												<a><b>' . $name . '</b></a>
											</h4>

											<h4 class="panel-title" style="font-size: 1.3rem;">
												<a style="text-align: right;"><i class="fas fa-comment-alt"></i> ' . $value[2] . '</a>
											</h4>
										</div>

										<div class="panel-collapse collapse in">
											<div class="panel-body">
												<p class="mt-2 mb-1 ml-1"><span class="bg-warning">30 cm</span> - <b>' . number_format($price) . ' Forint</b><button data-holder="' . $value[0] . '" data-type="1" data-price="' . $price . '" class="btn btn-success btn-sm mr-2 float-right"><i class="fas fa-cart-plus"></i> Kosárba</button></p>
												<p class="mt-3 mb-1 ml-1"><span class="bg-danger">50 cm</span> - <b>' . number_format(floor($price * 2.45)) . ' Forint</b><button data-holder="' . $value[0] . '" data-type="2" data-price="' . floor($price * 2.45) . '" class="btn btn-primary btn-sm mr-2 float-right"><i class="fas fa-cart-plus"></i> Kosárba</button></p>
											</div>
										</div>
									</div>';
							}
						?>
					</div>
			</div>

			<div class="col-md-3" id="orderlist">
				<h3 class="pt-0 mt-2 mb-3">Kosár</h3>

				<ul class="pl-0 pb-3 mb-3 border-bottom border-secondary" id="orders" style="list-style: none;">
					<li>Kosár tartalma jelenleg üres</li>
				</ul>

				<p id="total">Összesen: <b>0 Forint</b></p>

				<button class="btn btn-danger btn-block clearorders"><i class="fas fa-trash-alt"></i> Kosár ürítése</button>
				<button class="btn btn-success btn-block completeorder">Rendelés elküldése <i class="fas fa-angle-double-right"></i></button>
				<a href="index.php" style="text-decoration: none;"><button class="btn btn-info btn-block mt-4"><i class="fas fa-angle-double-left"></i> Vissza</button></a>
			</div>
		</div>

		<nav class="navbar navbar-default navbar-fixed-bottom" style="background: black; border: none">
			<div class="container text-light">
				<p class="p-0 m-0"><i class="far fa-copyright"></i> Copyright 2018 - All rights reserved</p>
			</div>
		</nav>

		<div class="fullscreen m-0 p-0">
			<div class="loader-bg m-0 p-0">
				<div class="loader m-0 p-0 mx-auto"></div>

				<h4 class="text-center">Feldolgozás folyamatban</h4>
			</div>
		</div>

		<!-- [script section] -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
		<script src="js/notify.js"></script>
		<script src="js/order.js"></script>
	</body>
</html>