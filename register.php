<!DOCTYPE html>
<html>
	<head>
		<title>NetPizza</title>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
		<meta name="author" content="Lovász Bence">

		<link rel="icon" type="image/x-icon" href="images/favicon.png">
		<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,700">
		<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/maintance.css">
		<link rel="stylesheet" type="text/css" href="css/notify.css">

		<link rel="stylesheet" type="text/css" href="css/register.css">
    </head>

	<body>
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
		?>

		<div class="container">
			<form method="post" id="register-form">
		        <div class="row">
		            <div class="col-md-3"></div>

		            <div class="col-md-6">
		                <h2>Új felhasználó létrehozása</h2>
		                <hr>
		            </div>
		        </div>

		        <div class="row">
		            <div class="col-md-3 field-label-responsive">
		                <label for="name">Név</label>
		            </div>

		            <div class="col-md-6">
		                <div class="form-group">
		                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
		                        <div class="input-group-addon" style="width: 40px">
		                        	<i class="fa fa-user-circle"></i>
		                        </div>

		                        <input type="text" name="name" class="form-control" id="name" placeholder="Valódi név" required autofocus>
		                    </div>
		                </div>
		            </div>
		        </div>

		        <div class="row">
		            <div class="col-md-3 field-label-responsive">
		                <label for="phone">Telefonszám</label>
		            </div>

		            <div class="col-md-6">
		                <div class="form-group">
		                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
		                        <div class="input-group-addon" style="width: 40px">
		                        	<i class="fa fa-phone"></i>
		                        </div>

		                        <input type="text" name="phone" class="form-control" id="phone" placeholder="06301234567" required autofocus>
		                    </div>
		                </div>
		            </div>
		        </div>

		        <div class="row">
		            <div class="col-md-3 field-label-responsive">
		                <label for="address">Lakcím</label>
		            </div>

		            <div class="col-md-6">
		                <div class="form-group">
		                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
		                        <div class="input-group-addon" style="width: 40px">
		                        	<i class="fa fa-map-marker-alt"></i>
		                        </div>

		                        <input type="text" name="address" class="form-control" id="address" placeholder="Város, út, házszám" required autofocus>
		                    </div>
		                </div>
		            </div>
		        </div>

		        <div class="row">
		            <div class="col-md-3 field-label-responsive">
		                <label for="password">Jelszó</label>
		            </div>

		            <div class="col-md-6">
		                <div class="form-group has-danger">
		                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
		                        <div class="input-group-addon" style="width: 40px">
		                        	<i class="fa fa-key"></i>
		                        </div>

		                        <input type="password" name="password" class="form-control" id="password" placeholder="Jelszó" required>
		                    </div>
		                </div>
		            </div>
		        </div>

		        <div class="row">
		            <div class="col-md-3 field-label-responsive">
		                <label for="password">Jelszó újra</label>
		            </div>

		            <div class="col-md-6">
		                <div class="form-group">
		                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
		                        <div class="input-group-addon" style="width: 40px">
		                            <i class="fa fa-redo"></i>
		                        </div>

		                        <input type="password" name="password-confirmation" class="form-control" id="password-confirmation" placeholder="Jelszó" required>
		                    </div>
		                </div>
		            </div>
		        </div>

		        <div class="row">
		            <div class="col-md-3"></div>
		            <div class="col-md-6">
		                <button type="submit" class="btn btn-success" id="registerbtn"><i class="fa fa-user-plus"></i> Regisztráció</button>
		            </div>
		        </div>

		        <div class="row mt-2">
		            <div class="col-md-3"></div>
		            <div class="col-md-6">
		            	<!-- <a> tag doesnt work (jquery validate plugin block any action if the form has empty required input) -->
		                <button class="btn btn-primary" onclick="location.href='index.php'"><i class="fa fa-caret-left"></i> Vissza</button>
		            </div>
		        </div>
			</form>
	    </div>

		<!-- [script section] -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
		<script src="js/register.js"></script>
		<script src="js/notify.js"></script>
	</body>
</html>