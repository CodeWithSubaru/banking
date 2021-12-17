<?php 
require_once 'core/Init.php';


if(Input::exists()) {
    // echo Input::get('username');
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
        //items and rules
            'birthday' => array(
                'required' => true
            ),
            'mother_s' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
            'mother_m' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
            'mother_f' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
            'contact' => array(
                'required' => true,
                'min' => 11,
                'max' => 11
            ),
            'account' => array(
                'required' => true,
                'min' => 10,
                'max' => 12,

            ),

            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'password_again' => array(  
                'required' => true,
                'matches' => 'password'
            ),
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
            'user_type' => array(
                'required' => true
            )
        ));
        

        if($validate->passed()) {
            $user = new User();
            $salt = Hash::salt(32);
  
            try {
                $user->createuser(array(

                    'username' => Input::get('username'),
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'name' => Input::get('name'),
                    'UserType' => Input::get('user_type'),
                    'joined' => date('Y-m-d H:i:s'),
                    'group' => 1
                ));
                

                if($user) {
                    $user->createother_details(array(
                    'users_fk' => $user->getfk(),
                    'birthday' => Input::get('birthday'),
                    'mother_s' => Input::get('mother_s'),
                    'mother_m' => Input::get('mother_m'),
                    'mother_f' => Input::get('mother_f'),
                    'contact_num' => Input::get('contact'),
                    // 'balance' => Input::get('balance'),
                    'account_num' => Input::get('account'),
                ));
                    Session::flash('home', 'You have been registered and can now log in!');
                    Redirect::to('index.php');
                }


            } catch(Exception $e) {
                die($e->getMessage());
            }

            Session::flash('success', 'You registered successfully!');
            header('Location: index.php');
        } else {
            foreach($validate->errors() as $error){
                echo $error, '<br>';
            }
        }
    }
}
$user = new User();
?>

<form action="" method="post">
    
    <div class="field">
        <label for="birthday">Birthday</label>
        <input type="date" name="birthday" id="birthday" value="<?php echo escape(Input::get('birthday')); ?>" autocomplete="off">   
    </div>

    <div class="field">
        <label for="mother_s">Mother's Lastname</label>
        <input type="text" name="mother_s" id="mother_s" value="<?php echo escape(Input::get('mother_s')); ?>" autocomplete="off">   
    </div>

    <div class="field">
        <label for="mother_m">Mother's maiden name</label>
        <input type="text" name="mother_m" id="mother_m" value="<?php echo escape(Input::get('mother_m')); ?>" autocomplete="off">   
    </div>

    <div class="field">
        <label for="mother_f">Mother's Firstname</label>
        <input type="text" name="mother_f" id="mother_f" value="<?php echo escape(Input::get('mother_f')); ?>" autocomplete="off">   
    </div>

    <div class="field">
        <label for="contact">Contact no.</label>
        <input type="tel" name="contact" id="contact" pattern="[0-9]{11}" value="<?php echo escape(Input::get('contact')); ?>" >  
    </div>

    <!-- <div class="field">
        <label for="balance">Your Balance</label>
        <input type="tel" name="balance" id="balance">   
    </div> -->

    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">   
    </div>

    <div class="field">
        <label for="password">Choose a password</label>
        <input type="password" name="password" id="password">
    </div>
    
    <div class="field">
        <label for="password_again">Enter your password again</label>
        <input type="password" name="password_again" id="password_again">
    </div>

    <div class="field">
        <label for="name">Your Name</label>
        <input type="text" name="name" id="name" value="<?php echo escape(Input::get('name')) ?>">
    </div>

    <input type="hidden" name="account" value="<?php echo $user->generateAccountNumber(); ?>">
    
    <label for="">User Type</label>
    <select class="form-select" name="user_type" aria-label="Default select example">
    <option selected>Open this select menu</option>
    <option value="1">Customer</option>
        <?php if(isset($_SESSION['User_Type'])) : ?>
            <option value="2">Teller</option>
            <option value="3">Advance User</option>
            <option value="4">Admin</option>
        <?php endif; ?>
    </select>
    
    <br>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Register">
</form>