<?php


$msgBox = '';


include('includes/notification.php');

include('includes/Functions.php');

include('includes/db.php');

// When the signup is empty a message will be relayed that SignUp is empty 
if(isset($_POST['signup'])){
	if($_POST['email'] == '' || $_POST['firstname'] == '' || $_POST['lastname'] == '' || $_POST['password'] == '' || $_POST['rpassword'] == '') {
				$msgBox = alertBox($SignUpEmpty);

                //When Password and Re
			} else if($_POST['password'] != $_POST['rpassword']) {
				$msgBox = alertBox($PwdNotSame);
				
			} else {

				$Email 		= $mysqli->real_escape_string($_POST['email']);
				$Password 	= md5($_POST['password']);
				$FirstName	= $mysqli->real_escape_string($_POST['firstname']);
				$LastName	= $mysqli->real_escape_string($_POST['lastname']);
				$Currency	= $mysqli->real_escape_string($_POST['currency']);
				

				$sql="Select Email from user Where Email = '$Email'";

				 $c= mysqli_query($mysqli, $sql);

                    if (mysqli_num_rows($c) >= 1) {

                        $msgBox = alertBox($AlreadyRegister);
                    }
                    else{

				$sql="INSERT INTO user (FirstName, LastName, Email, Password, Currency) VALUES (?,?,?,?,?)";
				if($statement = $mysqli->prepare($sql)){
					//bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
					$statement->bind_param('sssss', $FirstName, $LastName, $Email, $Password, $Currency);	
					$statement->execute();
				}
				$msgBox = alertBox($SuccessAccount);
				}
			}
}

?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SmartWallet Sign Up</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <link href="css/custom.css" rel="stylesheet">

    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">


</head>

<body style="background: url('img/bg.jpg');">

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-panel panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><span class="glyphicon glyphicon-lock"></span> <?php  echo $CreateAnAccount; ?></h3>
                    </div>
                    <div class="panel-body">
						<?php if ($msgBox) { echo $msgBox; } ?>
                        <form method="post" action="" role="form">
                            <fieldset>
                                <div class="form-group col-lg-6">
                                    <label for="email"><?php  echo $Emails; ?></label>
                                    <input class="form-control"  placeholder="<?php  echo $Emails; ?>" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="email"><?php  echo $FirstNames; ?></label>
                                    <input class="form-control"  placeholder="<?php  echo $FirstNames; ?>" name="firstname" type="text" >
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="email"><?php  echo $LastNames; ?></label>
                                    <input class="form-control"  placeholder="<?php  echo $LastNames; ?>" name="lastname" type="text" >
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="email"><?php  echo $Currencys; ?></label>
                                    <select class="form-control bold"  name="currency">
										<option value="KES">Kenyan Shilling (KES)</option>
										<option value="UGX">Ugandan Shilling (UGX)</option>
										<option value="TZS">Tanzanian Shilling (TZS)</option>				
									</select>
                                </div>
                                <div class="form-group col-lg-6">
                                     <label for="password"><?php  echo $Passwords; ?></label>
                                    <input class="form-control"  placeholder="<?php  echo $Passwords; ?>" name="password" type="password" value="">
                               </div>
                                <div class="form-group col-lg-6">
                                     <label for="password"><?php  echo $RepeatPassword; ?></label>
                                    <input class="form-control"  placeholder="<?php  echo $RepeatPassword; ?>" name="rpassword" type="password" value="">
                               </div>
                               <hr>
                                <button type="submit" name="signup" class="btn btn-success btn-block"><span class="glyphicon glyphicon-log-in"></span>  <?php  echo $Save; ?></button>                                 <hr>
                               
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      
    </div>

    <script src="js/jquery-1.11.0.js"></script>

    <script src="js/bootstrap.min.js"></script>

    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <script src="js/sb-admin-2.js"></script>

</body>

</html>
