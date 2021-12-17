<?php 
require_once 'core/Init.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true)
        ));

        if ($validate->passed()) {
            $user = new User();

            $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if($login) {
                
                Redirect::to('index.php');
            } else {
                echo '<p>Sorry, logging in failed.</p>';
            }

        } else {
            foreach($validate->errors() as $error) {
                echo $error, '<br>';
            }
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="assets/css/stylelogin.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    
</head>
<body>
<?php
date_default_timezone_set('Asia/Manila');
echo "Today is ".date("m-d-Y");
echo "<br>";
echo "Time : ".date("h:i:s:a");
?>

    
    
    <div class="container">
    
        <div class="img">
            <img src="img/bg.svg" alt="">
        </div>

        <div class="login-content">
            <form action="" method="post">
                <img src="img/avatar.png" alt="">
                <h2 class="title">Welcome</h2>
                <div class="input-div one">
                    <div class="i">
                    <i class="fas fa-user"></i>
                </div>
        
                <div class="div">
                    <h5><label for="username">Username</label></h5>
                    <input type="text" name="username" id="username" autocomplete="off" class="input">
            </div>
        </div>
        <div class="input-div pass">
            <div class="i">
                <i class="fas fa-lock"></i>
            </div>
            <div class="div">
                <h5><label for="password">Password</label></h5>
                <input type="password" name="password" class="input" id="password" autocomplete="off">
            </div>
        </div>
        <label for="remember">
            <a ><input type="checkbox" name="remember" id="remember"> Remember me </a>
        </label>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <input type="submit" class="btn" name="" value="Login">
        </form>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>


</body>
</html>