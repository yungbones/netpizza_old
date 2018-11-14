<!DOCTYPE html>
<html lang="hu-HU">
	<head>
		<title>NetPizza - Backdoor</title>

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

		<link rel="stylesheet" type="text/css" href="css/backdoor.css">
    </head>

	<body class="bg-dark">
		<?php 
			require "misc/connection.php3";

			if ($mysqli->connect_errno)
				die("<div class=\"maintance\">Az adatbázishoz való csatlakozás sikertelen volt!</div>");

			$mysqli->close();
		?>

		<nav class="navbar navbar-default navbar-fixed-top bg-danger" style="border: none">
			<div class="container">
				<h4 class="text-light">NetPizza - Backdoor</h4>
			</div>
		</nav>

		<?php 
			if (isset($_COOKIE["admin_user"])) {
			?>
				<div class="container">
					<div class="col-md-3 m-0 p-0 pr-sm-2">
						<ul class="list-group">
							<li data-holder="orderlist" class="list-group-item d-flex justify-content-between align-items-center li-active">
								Napi rendelések
								<span class="badge badge-pill bg-primary">
									<?php 
										require "misc/connection.php3";

										$result = $mysqli->query("SELECT COUNT(*) as counted FROM orders WHERE date=" . date("Ymd"));

										if ($result)
											while ($rows = $result->fetch_assoc())
												echo $rows["counted"];

										$mysqli->close();
									?>
								</span>
							</li>

							<li data-holder="addnote" class="list-group-item d-flex justify-content-between align-items-center">
								Kiadás feljegyzése <i class="fas fa-money-bill-wave"></i>
							</li>
							
							<li data-holder="orderprint" class="list-group-item d-flex justify-content-between align-items-center">
								Napi összesítés nyomtatása <i class="fas fa-print"></i>
							</li>

							<li data-holder="exit" class="list-group-item d-flex justify-content-between align-items-center text-danger">
								Kijelentkezés <i class="fas fa-sign-out-alt"></i>
							</li>
						</ul>		
					</div>

					<div class="orderlist col-md-9 m-0 p-0 pl-sm-2">
						<div class="panel-group" id="accordion">
							<?php 
								require "misc/connection.php3";

								if ($result = $mysqli->query("SELECT orders.id as oid, orders.orderdatas as oorderdatas, orders.price as oprice, orders.userid as ouid, orders.status as ostatus, orders.time as otime, accounts.name as aname, accounts.phone as aphone, accounts.address as aadress FROM orders LEFT JOIN accounts ON accounts.id=orders.userid WHERE date=" . date("Ymd") . " ORDER BY orders.id DESC")) {
									$texts = array("30 cm", "50 cm");
									$colors = array("bg-warning", "bg-danger");

									while ($rows = $result->fetch_assoc()) {
										$text = "";
										foreach (json_decode($rows["oorderdatas"]) as $value)
											$text = $text . "<p class='mt-2 mb-1'><span class='" . $colors[$value[1] - 1] . "'>" . $texts[$value[1] - 1] . "</span> <b>" . $value[0] . "</b> - " . number_format($value[2]) . " Forint</p>";

										$text = $text . "<p class='h5 mt-4'><i class='fas fa-phone-square'></i> Telefonszám: <b>" . $rows["aphone"] . "</b></p><p class='h5 mb-1'><i class='fas fa-money-bill-alt'></i> Összesen: <b>" . number_format($rows["oprice"]) . " Forint</b></p>";

										if ($rows["ostatus"] == 0)
											$button = "<button data-holder='" . $rows["oid"] . "' class='btn btn-success start-btn'><i class='fas fa-truck'></i> Futár elindult</button>";
										else if ($rows["ostatus"] == 1)
											$button = "<button data-holder='" . $rows["oid"] . "' class='btn btn-warning finish-btn'><i class='fas fa-hourglass-end'></i> Futár megérkezett</button>";
										else if ($rows["ostatus"] == 2)
											$button = "<button data-holder='" . $rows["oid"] . "' class='btn btn-dark' disabled><i class='fas fa-check-circle'></i> Rendelés teljesítve</button>";
										else if ($rows["ostatus"] == 3)
											$button = "<button data-holder='" . $rows["oid"] . "' class='btn btn-secondary' disabled><i class='fas fa-exclamation-circle'></i> Rendelés törölve</button>";

										// if order not completed add delete button
										if ($rows["ostatus"] < 2)
											$button = $button . '<br id="br-' . $rows["oid"] . '"><button id="remove-' . $rows["oid"] . '" data-holder="' . $rows["oid"] . '" class="btn btn-danger delete-btn mt-2"><i class="fas fa-times"></i> Sztornó</button>';

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

															<div class="col-md-3">' . $button . '</div>
														</div>
													</div>
												</div>
											</div>';
									}
								}

								$mysqli->close();
							?>
						</div>
					</div>

					<div class="addnote col-md-9 pt-4 pl-4 mb-4 rounded bg-white" style="display: none;">
						<div class="col-md-6">
							<form method="post" id="addnote">
								<h4 class="mt-0 mb-4">Kiadás feljegyzése</h4>

								<div class="row d-block w-100">
					                <div class="form-group">
					                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
					                        <div class="input-group-addon" style="width: 40px">
					                        	<i class="fas fa-sticky-note"></i>
					                        </div>

					                        <input type="text" name="desc" class="form-control" id="desc" placeholder="Kiadás" required autofocus>
					                    </div>
					                </div>
						        </div>

						        <div class="row d-block w-100">
					                <div class="form-group">
					                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
					                        <div class="input-group-addon" style="width: 40px">
					                        	<i class="fas fa-dollar-sign"></i>
					                        </div>

					                        <input type="text" name="money" class="form-control" id="money" placeholder="Összeg" required autofocus>
					                    </div>
					                </div>
						        </div>

						        <div class="row d-block w-100">
					                <div class="form-group">
					                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
					                       	<button type="submit" class="btn btn-success btn-block" id="confirm-note"><i class="fa fa-user-plus"></i> Kiadás rögízése</button>
					                    </div>
					                </div>
						        </div>
							</form>
						</div>

						<div class="col-md-6">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
							proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</div>
					</div>

					<div class="orderprint col-md-9 text-light" style="display: none;">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</div>

					<button class="btn btn-primary btn-block">Rendelések összegzése <i class="fas fa-angle-right"></i></button>
				</div>
		<?php 
			}
			else {
				?>
					<div class="col-md-5 bg-white rounded logindiv">
						<form method="post">
							<div class="mx-auto text-center mb-4">
							    <h3>Bejelentkezés</h3>

							    <p>Backdoor megtekintéséhez add meg a dolgozói jelszót</p>
						    </div>

					        <div class="row mx-auto" style="display: block;">
				                <div class="form-group">
				                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                        <div class="input-group-addon" style="width: 40px">
				                        	<i class="fas fa-unlock-alt"></i>
				                        </div>

				                        <input type="password" name="password" class="form-control" id="password" placeholder="Jelszó" autofocus>
				                    </div>
				                </div>
					        </div>

					        <div class="mx-auto mb-4">
					        	<button class="btn btn-primary btn-block loginbtn">Bejelentkezés</button>
					        </div>
					    </form>
					</div>
				<?php
			}
		?>

		<nav class="navbar navbar-default navbar-fixed-bottom" style="background: black; border: none">
			<div class="container text-light">
				<!-- 100% line-height >> disable padding for vertical center -->
				<p class="p-0 m-0"><i class="far fa-copyright"></i> Copyright 2018 - All rights reserved</p>
			</div>
		</nav>

		<!-- [script section] -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="js/notify.js"></script>
		<script src="js/backdoor.js"></script>
	</body>
</html>