<?php
require_once 'core/init.php';

if(Session::exists('home')) {
    echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User();

if($user->isLoggedIn()) {

?>
   
<!-- // $anotheruser = new User(6);


// $user = Db::getInstance()->update('users', 5, array(
//     'Password' => 'password',
//     'Name' => 'thordy'
// ));


// $user = Db::getInstance()->get('users', array('Username', '=', 'florence'));

// if(!$user->count()){
//     echo 'No User';
// } else {
//     echo $user->first()->Username;
// }

// echo Config::get('mysql/host');
// var_dump(Config::get()); -->

<!Doctype html>
<html lang="en">
  <head>
  	<title>Sidebar 01</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/style (2).css">
  </head>
  <body>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="p-4 pt-5">
		  		<a href="#" class="img logo rounded-circle mb-5" style="background-image: url(assets/img/login.jpg);"></a>
	        <ul class="list-unstyled components mb-5">
	          <li class="active">
	            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Transaction</a>
	            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li>
                    <a href="Deposit.php">Deposit</a>
                </li>
                <li>
                    <a href="Withdraw.php">Withdraw</a>
                </li>
                <li>
                    <a href="#">Transfer</a>
                </li>
	            </ul>
	          </li>
	          <li>
	              <a href="Profile.php?user=<?php echo escape($user->data()->Username); ?>">Profile</a>
	          </li>
	          <li>
              <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Settings</a>
              <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a href="Changepassword.php">Change Password</a>
                </li>
                <li>
                    <a href="Update.php">Update Details</a>
                </li>
              </ul>
	          </li>
	          <li>
              <a href="#">Contact</a>
	          </li>
	        </ul>

	        <div class="footer">
	        	<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved <i class="icon-heart" aria-hidden="true"></i> by <a href="index.php" target="_blank">PCRBANK</a>
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
	        </div>

	      </div>
    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Logout.php">Log out</a>
                </li>

              </ul>
            </div>
          </div>
        </nav>

        <h2 class="mb-4"> <p>Hello <a href="Profile.php?user=<?php echo escape($user->data()->Username); ?>"><?php echo escape($user->data()->Username); ?></a>!</p></h2>

<div class="w3-card-4 w3-margin" style="width:50%">
    <div class="w3-display-container w3-text-white">
        <div class="w3-xlarge w3-display-bottomleft w3-padding"></div>
    </div>
    table
</div>


        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      </div>
		</div>
<?php

    if($user->hasPermission('admin')) {
        echo '<p>You are an admin!</p>';
    }

} else {
    echo '<p>You need to <a href="Login.php">Log in</a> or <a href="Register.php">Register</a></p>';
}
?>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/mainside.js"></script>
  </body>
</html>