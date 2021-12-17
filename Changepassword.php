<?php
    include 'core/Init.php';

    $user = new User();

    if(!$user->isLoggedIn()) {
        Redirect::to('index.php');
    }

    if(Input::exists()) {
        if(Token::check(Input::get('token'))) {
        
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'password_current' => array(
                    'required' => true,
                    'min' => 6
                ),
                'password_new' => array(
                    'required' => true,
                    'min' => 6,
                ),
                'password_new_again' => array(
                    'required' => true,
                    'min' => 6,
                    'matches' => 'password_new'
                )
            ));

            if($validate->passed()) {

                if(Hash::make(Input::get('password_current'), $user->data()->Salt) !== $user->data()->Password) {
                    echo 'Your current password is wrong.';
                } else {
                    $salt = Hash::salt(32);
                    $user->update(array(
                        'password' => Hash::make(Input::get('password_new'), $salt),
                        'salt' => $salt
                    ));

                    Session::flash('home', 'Your password has been changed!');
                    Redirect::to('Dashboard.php');
                }

            } else {
                foreach($validate->errors() as $error) {
                    echo $error, '<br>';
                }
            }
        
        }
    }

?>

    <div class="container">
        <div class="login-content">
            <form action="" method="post">
            
            <div class="div">
                <h5><label for="password_current">Current password</label></h5>
                <input type="password" name="password_current" id="password_current" class="input">
            </div>

            <div class="div">
                <h5><label for="password_new">New password</label></h5>
                <input type="password" name="password_new" id="password_new" class="input">
            </div>

            <div class="div">
                <h5><label for="password_new_again">New password again:</label></h5>
                <input type="password" name="password_new_again" id="password_new_again" class="input">
            </div>

        </div>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <input type="submit" class="btn" name="" value="Change">
        </form>
        </div>
    </div>