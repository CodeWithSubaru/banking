<?php
include_once 'core/Init.php';

if(isset($_POST['deposit'])) {
    $insertTrans = new Transaction();
    $insertTrans->transaction($_POST['name'], $_POST['account_number'], $_POST['amount'], $_POST['teller_id'],);
}

$user = new User();
?>

<form method="POST">

    <input type="text" name="name" value="<?php echo escape($user->data()->Name); ?>">
    <input type="text" name="account_number" value="">
    <input type="text" name="amount" value="">
    <button type="submit" name="deposit" value="<?php echo $_SESSION['UsersID']; ?>"> Deposit</button>
</form>