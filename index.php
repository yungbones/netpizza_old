<!DOCTYPE html>
<html lang="hu-HU">
	<head>
		<title>NetPizza</title>

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

		<link rel="stylesheet" type="text/css" href="css/index.css">

		<!-- cookies (eu law) -->
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>
		<script>
			window.addEventListener("load", function() {
				window.cookieconsent.initialise({
					"palette": {
						"popup": {
							"background": "#000000"
						},
						
						"button": {
							"background": "#cc0000"
						}
					},
					
					"content": {
						"message": "Jobb felhasználói élmény eléréséhez oldalunk sütiket használ!",
						"dismiss": "Rendben",
						"link": "Bővebben"
					}
				})
			});
		</script>

		<!-- recaptcha for login -->
		<script src="https://www.google.com/recaptcha/api.js?hl=hu" async defer></script>
	</head>

	<body class="bg-dark">
		<?php
			require "misc/connection.php3";

			if ($mysqli->connect_errno)
				die("<div class=\"maintance\">Az oldal karbantartás alatt van</div>");

			$result = $mysqli->query("SELECT * FROM sitedatas WHERE id=1");
			if ($result)
				while ($rows = $result->fetch_assoc())
					if ($rows["maintance"] == 1)
						die("<div class=\"maintance\">Az oldal karbantartás alatt van</div>");

			$mysqli->close();
		?>

		<nav class="navbar navbar-default navbar-fixed-top bg-danger" style="border: none">
			<div class="container">
				<h4 class="text-light">NetPizza</h4>
			</div>
		</nav>

		<div class="container bg-white rounded p-4">
			<div class="row">
				<div class="col-md-3">
					<?php 
						if (isset($_COOKIE["json_userdata"])) {
							$datas = json_decode($_COOKIE["json_userdata"], true);
							?>
								<div class="row col-md-12 mx-auto p-0">
									<h3 class="mt-2">Profil</h3>
								</div>

								<div class="row d-block col-md-12 mx-auto p-0">
									<span class="d-block text-center">
										<?php 
											echo "<b>" . $datas["user"] . "</b><br>(" . $datas["datas"]["address"] . ")<br>";

											require "misc/connection.php3";

											if ($result = $mysqli->query("SELECT COUNT(*) as counted FROM orders WHERE userid=" . $datas["id"]))
												while ($rows = $result->fetch_assoc())
													echo "<a href='index.php?page=orders'>Eddigi rendelések: <span class='badge badge-pill bg-info'>" . $rows["counted"] . "</span></a>";

											$mysqli->close();
										?>
									</span>
								</div>

								<div class="row col-md-12 mx-auto p-0 m-4">
									<a href="order.php" class="btn-block" style="text-decoration: none;"><button class="btn btn-success btn-block">Rendelés</button></a>
								</div>

								<div class="row col-md-12 mx-auto p-0 mb-4">
									<button class="mb-0 btn btn-primary btn-block">Jelszó módosítása</button>
									<button class="mt-1 btn btn-primary btn-block">Lakcím módosítása</button>
								</div>

								<div class="row col-md-12 mx-auto p-0 mb-5">
									<button class="btn btn-danger btn-block" id="logout">Kijelentkezés <i class="fas fa-sign-out-alt"></i></button>
								</div>
							<?php
						}
						else {
							?>
								<form method="post" id="login-form">
							        <div class="row col-md-12 mx-auto p-0">
							        	<h3 class="mt-2">Bejelentkezés</h3>
							        </div>

							        <div class="row col-md-12 mx-auto p-0">
							        	<div class="d-block w-100 form-group">
									        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
									            <div class="input-group-addon" style="width: 40px">
									            	<i class="fa fa-phone"></i>
									            </div>

									            <input type="text" name="phone" class="form-control" id="phone" placeholder="Telefonszám" autofocus>
									        </div>
									    </div>
							        </div>

							        <div class="row col-md-12 mx-auto p-0">
									    <div id="forCaptcha" class="d-block w-100 form-group">
									        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
									            <div class="input-group-addon" style="width: 40px">
									            	<i class="fas fa-unlock-alt"></i>
									            </div>

									            <input type="password" name="password" class="form-control" id="password" placeholder="Jelszó">
									        </div>
									    </div>
									</div>

									<!-- recaptcha --> 
									<div class="row col-md-12 mx-auto p-0 d-block w-100">
										<div class="g-recaptcha" data-sitekey="6LcIq3kUAAAAAK8mp7IhEPL30ZMhwWajtoaLPJhG"></div>
									</div>

									<div class="row col-md-12 mx-auto p-0">
									    <button type="submit" class="btn btn-success btn-block" id="loginbtn">Belépés <i class="fas fa-sign-in-alt"></i></button>
									</div>

									<div class="row col-md-12 mx-auto p-0">
										<a href="register.php" class="mt-3 mb-4">Még nem regisztráltál?</a>
									</div>
								</form>
							<?php
						}
					?>
				</div>

				<div class="col-md-3 col-md-push-6">
					<h3 class="mt-2 ml-2 mb-4">Információk</h3>

					<ul class="pl-2" style="list-style: none;">
						<li>Nyitvatartás: <b>11:00 - 22:00</b></li>
						<li class="pt-3">Kiszállítás: <b>Paks</b> és 10km-es körzetében <b>ingyenes</b> kiszállítás, ezen felül <b>semmilyen</b> térítés ellenében nem áll módunkban kiszállítani.</li>
						<li class="pt-3">Kapcsolat felvétel: <b>+36 30 123 4567</b></li>

						<li class="pt-3">Áraink a csomagolást és az ÁFÁ-t tartalmazzák!</li>

						<li>Étkezési utalványt elfogadunk!<br>Étkezési jeggyel történő fizetés esetén készpénzt visszaadni <b>nem</b> tudunk!</li>
					</ul>
				</div>

				<div class="col-md-6 col-md-pull-3">
					<?php if (!isset($_GET["page"])) { ?>
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
													<p class="mt-2 mb-1 ml-1"><span class="bg-warning">30 cm</span> - <b>' . number_format($price) . ' Forint</b></p>
													<p class="mt-3 mb-1 ml-1"><span class="bg-danger">50 cm</span> - <b>' . number_format(floor($price * 2.45)) . ' Forint</b></p>
												</div>
											</div>
										</div>';
								}
							?>
						</div>
					<?php } if (isset($_GET["page"]) && $_GET["page"] == "orders") { ?>
						<h3 class="mt-2 ml-2">Eddigi rendeléseim</h3>

						<div class="panel-group">
							<?php 
								require "misc/connection.php3";

								if (isset($_COOKIE["json_userdata"])) {
									//echo $datas["id"];

									if ($result = $mysqli->query("SELECT orders.id as oid, orders.orderdatas as oorderdatas, orders.price as oprice, orders.time as otime, orders.finished as ofinished FROM orders WHERE orders.userid=" . $datas["id"] . " ORDER BY orders.id DESC")) {
										$texts = array("30 cm", "50 cm");
										$colors = array("bg-warning", "bg-danger");

										while ($rows = $result->fetch-assoc()) {
											$text = "";
											foreach (json_decode($rows["oorderdatas"]) as $value)
												$text = $text . "<p class='mt-2 mb-1'><span class='" . $colors[$value[1] - 1] . "'>" . $texts[$value[1] - 1] . "</span> <b>" . $value[0] . "</b> - " . number_format($value[2]) . " Forint</p>";

											$text = $text . "<p class='h5 mb-1'><i class='fas fa-money-bill-alt'></i> Összesen: <b>" . number_format($rows["oprice"]) . " Forint</b></p>";

											echo '<div class="panel panel-default mb-4">
													<div data-toggle="collapse" data-parent="#accordion" href="#collapse' . $rows["oid"] . '" class="panel-heading bg-light">
														<h4 class="panel-title">
															<a><b>#' . $rows["oid"] . '</b> - Rögzített rendelés <b>' . $rows["aname"] . '</b> névre <b>(' . $rows["aadress"] . ')</b></a>
														</h4>

														<h4 class="panel-title" style="font-size: 1.3rem;">
															<a style="text-align: right;"><i class="fa fa-clock"></i> ' . $rows["otime"] . '</a>
														</h4>
													</div>

													<div id="collapse' . $rows["oid"] . '" class="panel-collapse collapse in">
														<div class="panel-body">
															<div class="row">
																<div class="col-md-6">' . $text . '</div>
															</div>
														</div>
													</div>
												</div>';
										}
									}
								}
								else {
									echo "<p class='ml-2'>Megtekintéshez be kell jelentkezned</p>";
								}
							?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>

		<nav class="navbar navbar-default navbar-fixed-bottom" style="background: black; border: none">
			<div class="container text-light">
				<p class="p-0 m-0"><i class="far fa-copyright"></i> Copyright 2018 - All rights reserved</p>
			</div>
		</nav>

		<!-- [script section] -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
		<script src="js/index.js"></script>
		<script src="js/notify.js"></script>
	</body>
</html>