<?php
require_once 'core/Init.php';

$user = new User(); 

if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            )
        ));

        if ($validate->passed()) {
            
            try {
                $user->update(array(
                    'name' => Input::get('name')
                ));

                Session::flash('home', 'Your details have been updated.');
                Redirect::to('Dashboard.php');

            } catch(Exception $e) {
                die($e->getMessage());
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
                <h5><label for="name">Name</label></h5>
                <input type="text" name="name" value="<?php echo escape($user->data()->Name); ?>" class="input">
            </div>
        </div>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <input type="submit" class="btn" name="" value="Update">
        </form>
        </div>
    </div>

